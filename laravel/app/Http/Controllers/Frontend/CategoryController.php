<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

use \App\Models\Category;
use \App\Models\CategoriesCustom;

class CategoryController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the homepage
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
	
	public function category($slug, $categorySlug, \App\Http\Helpers\StoreCategoryHelper $categoryHelper, $sortby = null) {
		//Fetch store
		$store = $this->getStoreBySlug($slug);
		if (!$store) {
			
			\App::abort(404);

		} else {

			$store_status = $store->store_status_type_id;

			// Show the category products
			if ($store_status === 3) {

				// pass to view to determine if 'All Categories' should be a link
				$home = false;

				//Fetch categories
				\View::share('categories', $categoryHelper->getStoreCategories($store->id));

				// Fetch store appearance
				$appearance =  DB::table('store_appearance')->where('store_id', $store->id)->first();

				// total products count
				\View::share('category_sum',$categoryHelper->get_products_total($store->id));

				// get the products under the category group
				// if the category is given, load the correct item count and category groups


				//Fetch all the products for store

				$productsQuery = $categoryHelper->getCategoryProducts($store->id, $categorySlug);

				// no products in category
				// for if customer tries a direct navigation

				if(!$productsQuery) {
					return redirect()->back();
				}

				$productsQuery = $productsQuery
									->where('product_status_id', '=', \App\Models\Product::PRODUCT_STATUS_TYPE_VISIBLE)
									->where('product_moderation_type_id', '=', \App\Models\Product::PRODUCT_MODERATION_APPROVED);
				//$productsQuery->orderBy('created_at', 'desc' );

				// fetch current category
				$category = Category::where('slug', $categorySlug)->first();
				if (!$category) {
					$category = CategoriesCustom::where('slug', $categorySlug)->first();
				}

				// Active category items
				$active_cats[]	= $categorySlug;
				$cat_ancestor   = (isset($category->ancestor)) ? $category->ancestor : '';
				if($cat_ancestor) {
					$active_cats[] = $cat_ancestor->slug;
					$cat_grand_ancestor = (isset($cat_ancestor->ancestor)) ? $cat_ancestor->ancestor : '';
					if ($cat_grand_ancestor) {
						$active_cats[] = $cat_grand_ancestor->slug;
					} 
				}

				\View::share('active_cats', $active_cats);
				

				// Crumbs partial
				\View::share('category', $category);

				// Sort By

				//order products	
				if (!is_null($sortby)) {
					if ($sortby == 'newest') { //order by created data the products 
						$productsQuery->orderBy('created_at', 'desc' );
						\View::share('order', 'Newest');
					}
					if ($sortby == 'highest') { //order by price the products 
						$productsQuery->orderBy('price', 'desc' );
						\View::share('order', 'Highest to lowest price');
					}

					if ($sortby == 'lowest') { //order by price the products 
						$productsQuery->orderBy('price', 'asc' );
						\View::share('order', 'Lowest to highest price');
					}
						
				} else {

					$productsQuery->orderBy('created_at', 'desc' );
					\View::share('order', 'Newest');
				}

				// paginate
				$products = $productsQuery->paginate(\Config('storefronts-frontend.product-pagination-count'));
				$home_path = $categoryHelper->get_home_path();

				\View::share('products', $products);
				\View::share('store', $store);
				\view::share('appearance', $appearance);

				\View::share('home', $home);

				return view('frontend.categories.index', ['home_path' => $home_path]);
			
			} else {

				$note = "";

				switch($store_status) {
					case 1:
					case 2:
						$note = "This store is not accessible yet.";
						break;
					case 5:
						$note = "This store has been closed";
						break;
					default:
						$note ="404 error";
						break;
				}

				\View::share('Storenote', $note);
				return view('frontend.store.error');

			}
		}

	}
}
