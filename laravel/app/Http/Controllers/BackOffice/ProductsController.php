<?php

namespace App\Http\Controllers\BackOffice;

use App\Models\Product;
use App\Models\Category;

use View;
use Auth;
use URL;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\TableSortingAndFilteringTrait;
use App\Http\Helpers\ProductSyncHelper;

class ProductsController extends BaseController {
    
    use TableSortingAndFilteringTrait;
    
    protected $tableSortFilterTag = 'products';
    //Fields that can be filtered 
    protected $tableFilters = [
        'productStatus' => 'product_status_types.name',
        // 'productCategory' => 'categories.name',
        'moderationType' => 'product_moderation_types.name'
    ];
    
    public function __construct() {

        $this->middleware('pagination');
    }
    
    public function index(Request $request) {
        
        \ViewHelper::setPageDetails('Storefronts | Product List', 'Products', 'this is a small description');
        \ViewHelper::setActiveNav('products');

        $query = Product::select('products.*');
                
        $query->leftJoin('product_status_types', 'products.product_status_id', '=', 'product_status_types.id');
        $query->leftJoin('categories', 'products.category_id', '=', 'categories.id');
        $query->leftJoin('product_moderation_types', 'products.product_moderation_type_id', '=', 'product_moderation_types.id');
        $query->leftJoin('stores', 'products.store_id', '=', 'stores.id');
        $query->leftJoin('store_user', 'stores.id', '=', 'store_user.store_id');
        $query->leftJoin('users', 'store_user.user_id', '=', 'users.id');
        
        
        //Only the logged in user's products
        $query = $query->where('users.id', '=', Auth::user()->id);
        
        $query = $this->customFilters($query);
        $query = $this->tableCustomFilter($query);
        
       // print_r($query->toSql());
       // die();
      
        $products = $this->tablePaginate($query);
        
        $actions = [
            URL::route('admin.product') => "Add Product"
        ];

       
        View::share('actions', $actions);
        View::share('products', $products);
        return view('backoffice.products.index');
    }
    
    private function customFilters(\Illuminate\Database\Eloquent\Builder $query) {
        $filters = \SortFilterHelper::getFilters($this->tableSortFilterTag); //fetch session filters
       
        $filters = $this->sortFilters($filters);
        
     
        if (key_exists('subCategory', $filters) && key_exists('productCategory', $filters)) {
            $name = $filters['subCategory'];
            $name = str_replace('&', "&amp;", $name );
            $category = Category::where('name', $name)->first();
            if ($category) {
               
                $categories[] = $category->id;
                $children = Category::where('parent_id', $category->id)->get();
                foreach($children As $child) {
                    $categories[] = $child->id;
                    $grandchildren = Category::where('parent_id', $child->id)->get();
                    foreach($grandchildren As $grandchild) {
                        $categories[] = $grandchild->id;    
                    }
                }
                
                $query->whereIn('categories.id', $categories);
            }
        }
        if(key_exists('orderbyname', $filters)){
            $column = explode(',', $filters['orderbyname'][0])[0];
            $order = explode(',', $filters['orderbyname'][0])[1];
            switch ($column) {
                case 'prod_title':
                     $query->orderBy('products.title', $order);
                    break;
                case 'prod_price':
                     $query->orderBy('products.price', $order);
                    break;
                case 'prod_category':
                     $query->orderBy('categories.id', $order);
                    break;
                case 'prod_visibilty':
                     $query->orderBy('product_status_types.name', $order);
                    break;
                case 'prod_mod_status':
                     $query->orderBy('product_moderation_types.name', $order);
                    break;
                default:
                   
                    break;
            }
          
         
        }else{
            $query->orderBy('product_moderation_types.name', 'asc');
        }
        return $query;
    }
    
    
    public function modalDelete($id) {
        
        $product = Product::where('id', $id)->first();
        
        View::share('product', $product);

        return view('backoffice.products.modal-delete');
    }

    private function sortFilters($filters){
        foreach ($filters as $key => $value) {
           foreach ($value as $k => $v) {
              if($v =='all' || $v=='any'){
                unset($filters[$key]);
              }
           }
        }

        return $filters;
    }
    
    public function delete(Request $request) {
        
        $input = $request->all();
        $product = Product::where('id', $input['id'])->first();
        $slug = $product->slug;
        $store = $product->store()->first();
        if ($store) {
            $user = $store->user()->first();
            if ($user && $user->id === Auth::user()->id) {
                
                $product->delete();
                 ProductSyncHelper::ItemDelete($slug);
                $request->session()->flash('alert-success', 'Product was successfully deleted.');
                return redirect()->route("admin.products");
            }
        }
        
        $request->session()->flash('alert-danger', "You don't have permission to delete this product.");
        return redirect()->route("admin.products");
    }

}

