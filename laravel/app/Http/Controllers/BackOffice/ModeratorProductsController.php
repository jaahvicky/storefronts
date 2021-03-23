<?php

namespace App\Http\Controllers\BackOffice;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductStatusType;
use App\Models\ProductModerationType;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeVariant;
use App\Models\AttributeVariantValue;
use App\Models\AttributeValueProduct;
use App\Http\Helpers\ProductSyncHelper;
use View;
use Auth;
use URL;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\TableSortingAndFilteringTrait;
use App\Models\City;
use App\Models\Suburb;
use App\Models\ProductContactDetails;
class ModeratorProductsController extends BaseController {
    
    use TableSortingAndFilteringTrait;
    
    protected $tableSortFilterTag = 'products';
    //Fields that can be filtered 
    protected $tableFilters = [
        'productStatus' => 'product_status_types.name',
        'moderationType' => 'product_moderation_types.name'
    ];
    
    public function __construct() {
        $this->middleware('pagination');
    }
    
    public function index(Request $request) {
        
        \ViewHelper::setPageDetails('Storefronts | Products List', 'Moderate Products', 'this is a small description');
        \ViewHelper::setActiveNav('moderator');

        $query = Product::select('products.*');
                
        $query->leftJoin('product_status_types', 'products.product_status_id', '=', 'product_status_types.id');
        $query->leftJoin('categories', 'products.category_id', '=', 'categories.id');
        $query->Join('product_moderation_types', 'products.product_moderation_type_id', '=', 'product_moderation_types.id');
        $query->leftJoin('stores', 'products.store_id', '=', 'stores.id');
        $query->leftJoin('store_user', 'stores.id', '=', 'store_user.store_id');
        $query->leftJoin('users', 'store_user.user_id', '=', 'users.id');
        $query->where('products.product_status_id', '=', Product::PRODUCT_STATUS_TYPE_VISIBLE);
        
        $query = $this->customFilters($query);
        $query = $this->tableCustomFilter($query);
        
       
      
        $products = $this->tablePaginate($query);
     
    

       $mod_status = ProductModerationType::all();
        View::share('statuses', $mod_status);
        View::share('products', $products);
        return view('backoffice.moderator.index');
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
    
    public function product($id){
        $product = Product::where('id', $id)->first();
        if (!$product) {
            $request->session()->flash('alert-error', 'There is no product associated with that data.');
            return redirect()->route("admin.dashboard");
        }
        \ViewHelper::setPageDetails('Storefronts | Products', 'Edit Product', 'this is a small description');
        $visibils = ProductStatusType::all();
        foreach($visibils As $visibility) {
            $visibilities[$visibility->name] = $visibility->name; 
        }
       $cit = City::all();
        $cities = [];
        $cities[0] = 'Select City'; 
        foreach($cit As $city) {
            $cities[$city->id] = $city->name; 
        }
        $categories = $this->getCategories(strtolower($product->store->type->slug));
        $attributes = $this->getAttributes();
        $variantvalues = AttributeVariantValue::where('product_id', $product->id)->first();
        $variants = DB::table('attribute_variant')->get();
        $data = [
            'categories' => $categories,
            'attributes' => $attributes,
            'visibilities' => $visibilities,
            'variants' => $variants,
            'city' => $cities,
            'suburb' => Suburb::all(),
            'variantvalues'=>$variantvalues,
            'store' => $product->store,
        ];
              
        $data['product'] = $product;
        //Images
        $imgs = $product->images->all();
        foreach($imgs As $img) {
            $images[] = $img->filename;
        }
        $data['images'] = (isset($images) > 0) ? $images : [];
        $data['attributeValueProduct'] =$this->getAttributeValueProduct($product);

        return view('backoffice.moderator.product.index', $data);
    }

    public function update(Request $request) {

        $this->validateProduct($request);
        $inputs = $request->all();
        
        $visibility = $inputs['visibility'];

        //Product object and store link
        
        $product = Product::where('id', $inputs['product_id'])->first();

        //Product Title and Slug
        if (isset($inputs['title'])) {
            $product->title = $inputs['title'];
            // $product->slug = str_slug($inputs['title'], "-");
        }

        //Product Description
        if (isset($inputs['description'])) {
            $product->description = $inputs['description'];
        }

        //Product Price
        
        if (isset($inputs['price'])) {
            $product->price = $inputs['price']*100;
        }

        //ProductType
        $productType = DB::select("SELECT id from product_types where name = 'Simple'");
        $product->product_type_id = $productType[0]->id;

        //ProductStatusType
        $productStatusType = ProductStatusType::where('name', $visibility)->first();
        $product->product_status_id = $productStatusType->id;

        //ProductModerationType
       
            
        $product->product_moderation_type_id = (int)$inputs['product_status'];
        

        //Category
        $category = Category::where('id', $inputs['category'])->first();
        if ($category) {
            $product->category_id = $category->id;
        }

        
        //Currency
        $product->currency_id =  1;
        
        $product->save();
        //contact details 
        $conatcDetails = ProductContactDetails::where('product_id',  $product->id)->first();
        if(!$conatcDetails){
            $conatcDetails = new ProductContactDetails();
        }
        $conatcDetails->product_id = $product->id;
        $conatcDetails->contact_name = $inputs['contact_name'];
        $conatcDetails->phone = $inputs['phone'];
        $conatcDetails->city_id = $inputs['city'];
        $conatcDetails->suburb_id = $inputs['suburb'];
        $conatcDetails->save();
        //the code has been disabled
        // $attributeValues = AttributeVariantValue::where('product_id', $product->id)->first();
        // if($attributeValues){
        //     $attributeValues->data = $inputs['variantvalues'];
            
        // }else{
        //     $attributeValues = new  AttributeVariantValue();
        //     $attributeValues->fill([
        //         'product_id'=> $product->id,
        //         'data'=>$inputs['variantvalues']
        //     ]);
        // }
        // $attributeValues->save();
        //Once Product has been saved:
        
        //Images
        $productImages = ProductImage::where('product_id', $product->id)->take(5)->get();
        for ($i=0; $i<5; $i++) {
            if (isset($inputs['images-'.$i]) && !empty($inputs['images-'.$i])) {
                
                if (isset($productImages[$i])) {
                    $productImage = $productImages[$i];
                }
                else {
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                }
                
                $productImage->filename = $inputs['images-'.$i];
                $productImage->original_upload = $inputs['images-'.$i];
                $productImage->featured = (isset($inputs['featured']) && $inputs['featured'] == $i) ? 1 : 0;
                
                $productImage->save();
            }
            else {
                if (isset($productImages[$i])) {
                    $productImages[$i]->delete();
                }
            }
        }
        
        //Attributes
        DB::table('attribute_value_product')->where('product_id', '=', $product->id)->delete();
        $amount_attr = Attribute::where('slug', 'price-type-custom')->first();
        if($amount_attr){
            $productatr = new AttributeValueProduct();
            $productatr->fill([
                'attribute_value_id'=>$amount_attr->id,
                'value'=> 'Amount',
                'product_id'=>$product->id
            ])->save();
        }
        foreach($inputs As $name => $value) {
            
            if (strstr($name, "subcat-")) {
                
                $attrId = str_replace("subcat-", "", $name);
                $attribute = Attribute::where('id', $attrId)->first();
                
                if ($attribute->type === "CHECKBOX") {
                    $value = ($value == "on") ? 1 : 0;
                }
                $productatr = new AttributeValueProduct();
                $productatr->fill([
                            'attribute_value_id'=>$attribute->id,
                            'value'=> $value,
                            'product_id'=>$product->id
                ])->save();
                
            }
        }

         // run sync with osclass
        $sync = new ProductSyncHelper();
        $data = $sync->itemOsclassSync($product->id);
        
        if($inputs['product_status'] == 2){
            $request->session()->flash('alert-success', 'Product has been approved and updated.');
        }else{
            $request->session()->flash('alert-success', 'Product has been rejected and updated.');
        }
        
        return redirect()->route("admin.moderator");
    }

    private function validateProduct($request) {
        
        $inputs = $request->all();
        
        //Check that product belongs to user
        if (isset($inputs['product_id'])) {
            $product = Product::where('id', $inputs['product_id'])->first();
            $store = $product->store;
            
            // if ($store && $store->user->first()->id !== Auth::user()->id) {
            //     $request->session()->flash('alert-error', "You don't have permission to change this product.");
            //     return redirect()->route("admin.dashboard");
            // }
        }

        $category = Category::where('id', $inputs['category'])->first();
      
        
        //Only make sure all attribute fields are not greater than 500 for extra protection
        $attribute_validation = [];
        foreach($inputs As $name => $value) {
            
            if (strstr($name, "subcat-")) {
                $attribute_validation[$name] = ['max:500'];
            }
        }
        
        $common_validation = [
            'images-0' => ['max:500'],
            'images-1' => ['max:500'],
            'images-2' => ['max:500'],
            'images-3' => ['max:500'],
            'images-4' => ['max:500'],
            'price' => ['numeric', 'digits_between:1,10'],
        ];
        
        $category_constraints = ['max:500','numeric', 'exists:categories,id']; 
        $title_constraints = ['max:100'];
        $description_constraints = ['max:255'];
        $price_constraints = ['whole.number'];
        $city = ['numeric', 'min:1', 'required'];
        $phone = ['numeric', 'required'];
        $visibility = $inputs['visibility'];
        if ($visibility != "Draft") {
            
            $category_constraints[] = 'required';
            $title_constraints[] = 'required';
            $description_constraints[] = 'required';
            $price_constraints[] = 'required';
        }
        
        $this->validate($request, array_merge($common_validation, $attribute_validation, [
            'category' => $category_constraints,
            'title' => $title_constraints,
            'description' => $description_constraints,
            'price' => $price_constraints,
            'contact_name'=>$title_constraints,
            'phone'=>$phone,
            'city'=>$city,
            'suburb'=>$city,
        ]));
    }
    private function getAttributeValueProduct($product) {
        
        $attributeValueProduct = [];
        $values = $product->AttributeValueProduct;
        foreach($values As $value) {


            $attributeValueProduct[$value->attribute_value_id] = $value->value;
        }

        return $attributeValueProduct;
    }
    private function getCategories($storeType) {
        
       $propertiesCat = Category::where('slug', "property")->first();
        $vehiclesCat = Category::where('slug', "vehicles")->first();
        $jobsCat = Category::where('slug', "jobs")->first();
        $category = Category::where('slug', $storeType)->first();
        
        if ($storeType ==  $vehiclesCat->slug) {
                
            $cats = DB::select("select categories.name As parent_name, subcats.name As child_name, subcats.id As child_id from categories left join categories As subcats on subcats.parent_id = categories.id where categories.id = ".$category->id);
        }
        else if ($storeType == $propertiesCat->slug) {

            $cats = DB::select("select categories.name As parent_name, subcats.name As child_name, subcats.id As child_id from categories left join categories As subcats on subcats.parent_id = categories.id where categories.id = ".$propertiesCat->id);
        }
        else if ($storeType == $jobsCat->slug) {

            $cats = DB::select("select categories.name As parent_name, subcats.name As child_name, subcats.id As child_id from categories left join categories As subcats on subcats.parent_id = categories.id where categories.id = ".$jobsCat->id);
        }else {

            $notIn = "(".$propertiesCat->id.",".$vehiclesCat->id.",".$jobsCat->id.")";
            $cats = DB::select("select categories.name As parent_name, subcats.name As child_name, subcats.id As child_id from categories left join categories As subcats on subcats.parent_id = categories.id where categories.parent_id is null and categories.id not in $notIn");
        }
        
        foreach($cats As $cat) {
            $categories[$cat->parent_name][$cat->child_name] = $cat->child_id;
        }
        
        return $categories;
    }
    
    private function getAttributes() {
        
        $attribute_data = DB::select("
            SELECT attributes.id, attributes.name, attributes.type, categories.id As category_id, categories.name As category_name
            FROM `attributes`
            LEFT JOIN attribute_category ON attribute_category.attribute_id = attributes.id
            LEFT JOIN categories ON attribute_category.category_id = categories.id
            WHERE categories.parent_id IS NOT NULL
            AND attributes.slug !='price_range'
            AND attributes.slug !='price-type-custom'
            AND attributes.slug !='whatsapp-custom-field'
            ORDER BY category_name");

        $attributes = [];
        foreach($attribute_data As $attribute) {
            
            $attribute_options = AttributeValue::where('attribute_id', $attribute->id)->get();
            $options = [];
            foreach($attribute_options As $option) {
                $options[] = $option->value;
            }
            
            $attributes[$attribute->category_id][] = [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'type' => $attribute->type,
                'options' => $options
            ];


        }




        
        return $attributes;
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

    public function modalBulk($statusid, $selectedid){
        $mod_status = ProductModerationType::where('id', $statusid)->first();
        View::share('status', $mod_status);
        View::share('selectedid', $selectedid);
        return View('backoffice.moderator.modal.modal-bulk');
    }

    public function modalChangeStatus($id) {
        $product = Product::where('id', $id)->first();
        $mod_status = ProductModerationType::all();
        View::share('statuses', $mod_status);
        View::share('product', $product);
        return View('backoffice.moderator.modal.modal-status');
    }

    public function ChangeStatus(Request $request){
        $input = $request->all();
        $product = Product::where('id', $input['id'])->first();
        if($product){

            $product->product_moderation_type_id = (int)$input['status_id'];
            $product->save();
            //sync to osclass db
            ProductSyncHelper::statusChange($product->id);
            switch ($input['status_id']) {
                // case (1):
                //     $request->session()->flash('alert-success', 'Product was set to awaits moderation.');
                //     return redirect()->route("admin.moderator");
                //     break;
                case (1):
                    $request->session()->flash('alert-success', 'Product was successfully approved.');
                    return redirect()->route("admin.moderator");
                    break;
                case (2):
                    $request->session()->flash('alert-success', 'Product was successfully rejected.');
                    return redirect()->route("admin.moderator");
                    break;
                
                default:
                    $request->session()->flash('alert-danger', "ERROR OCCURED.");
                    return redirect()->route("admin.moderator");
                    break;
            }
            
        }else{
             $request->session()->flash('alert-danger', "ERROR OCCURED.");
            return redirect()->route("admin.moderator");
        }
    }

    public function bulkChangeStatus(Request $request){
        $input = $request->all();
        $products = explode(',', $input['selected_ids']);
        $actionid = $input['actionid'];
        $i =0;
        foreach ($products as $key => $value) {
            $product = Product::where('id', $value)->first();
            if($product->product_moderation_type_id != $actionid){
                $i++;
                $product->product_moderation_type_id = (int)$actionid;
                $product->save();
                //sync to osclass db
                ProductSyncHelper::statusChange($product->id);
            }
        }
        
        if($i == 1){
            switch ($actionid) {
                // case (1):
                //     $request->session()->flash('alert-success', $i.' product was set to awaits moderation.');
                //     return redirect()->route("admin.moderator");
                //     break;
                case (1):
                    $request->session()->flash('alert-success', $i.' products was successfully approved.');
                    return redirect()->route("admin.moderator");
                    break;
                case (2):
                    $request->session()->flash('alert-success', $i.' products was successfully rejected.');
                    return redirect()->route("admin.moderator");
                    break;
                
                default:
                    $request->session()->flash('alert-danger', "ERROR OCCURED.");
                    return redirect()->route("admin.moderator");
                    break;
            }

        }else{
            switch ($actionid) {
                // case (1):
                //     $request->session()->flash('alert-success', $i.' products were set to awaits moderation.');
                //     return redirect()->route("admin.moderator");
                //     break;
                case (2):
                    $request->session()->flash('alert-success', $i.' products were successfully approved.');
                    return redirect()->route("admin.moderator");
                    break;
                case (2):
                    $request->session()->flash('alert-success', $i.' products were successfully rejected.');
                    return redirect()->route("admin.moderator");
                    break;
                
                default:
                    $request->session()->flash('alert-danger', "ERROR OCCURED.");
                    return redirect()->route("admin.moderator");
                    break;
            }
        }
        

    }

    

}

