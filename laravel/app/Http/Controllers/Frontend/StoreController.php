<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use App\Models\StoreStatusType;
use Illuminate\Http\Request;
use \App\Models\Category;
use \App\Models\CategoriesCustom;

use DB;
use Input;
use Log;

class StoreController extends BaseController
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
    	\View::share('store', []);
        \View::share('appearance', []);
        \View::share('pageTitle', 'Open a Store');
        return view('frontend.page.open-a-store');		 
    }
	
	public function store($slug,  \App\Http\Helpers\StoreCategoryHelper $categoryHelper, $sortby = null) {
		$store = $this->getStoreBySlug($slug);

		// pass to view to determine if 'All Categories' should be a link
		$home = true;
		
		if (!$store) {
			\App::abort(404);
		}else{
			//TODO: handle disabled stores
			
			switch ($store->store_status_type_id) { 
				case 3:
					// $this->showStore($store, $categoryHelper, $sortby);
					 \View::share('categories', $categoryHelper->getStoreCategories($store->id));
		
					//appearance 
					$appearance =  DB::table('store_appearance')->where('store_id', $store->id)->first();
								
					\View::share('category_sum',$categoryHelper->get_products_total($store->id));
					
					//Fetch products for store
					$productsQuery = \App\Models\Product::where('store_id', '=', $store->id)
									->where('product_status_id', '=', \App\Models\Product::PRODUCT_STATUS_TYPE_VISIBLE)
									->where('product_moderation_type_id', '=', \App\Models\Product::PRODUCT_MODERATION_APPROVED);
					//$productsQuery->orderBy('created_at', 'desc' );
						
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
					
					$products = $productsQuery->paginate(\Config('storefronts-frontend.product-pagination-count'));//paginating products
					$about = $store->about;
					$home_path = $categoryHelper->get_home_path();
					
					\View::share('products', $products);
					
					\View::share('store', $store);
					\view::share('appearance', $appearance);

					\View::share('home', $home);
							
					return view('frontend.store.index', ['about' => $about, 'home_path' => $home_path]);
					break;
				case 1:
				case 2:
					  $note ="This store is not accessible yet.";
					  \View::share('Storenote', $note);
					  return view('frontend.store.error');
					break;
				case 5:
					  $note ="This store has been closed";
					  \View::share('Storenote', $note);
					  return view('frontend.store.error');
					break;
				default:
					 $note ="This store is not accessible yet.";
					  \View::share('Storenote', $note);
					  return view('frontend.store.error');
					break;
		     }
		}
		
	}

	public function search(Request $request, $slug, \App\Http\Helpers\StoreCategoryHelper $categoryHelper, $sortby = null) {

		
		$term = '';
		$category = '';
		$cat_name = '';

		// if post request ( from searchbar )
		if ($request->isMethod('post')) {
			$term = $request->input('term');
		}

		// if get request, pass category and term to the url ( sidebar > search page )
		if ($request->isMethod('get')) {
			$term 		= Input::get('t');
			$cat_name   = Input::get('c');
		}

		// if term is empty, go back with flash notification
		if (!$term) {
			
			$request->session()->flash('search-error', 'Search term cannot be blank');
			if (request()->is('*/search*')) {
				return redirect()->route('store', ['slug' => $slug]);
			}

			return back();

		}


		// get parameters if available for url
		$term_parameter = ($term)    ? 't=' . urlencode($term) : '';
		$cat_parameter = ($cat_name) ? '&c=' . urlencode($cat_name) : '';	

		if (!$sortby) {
			$sortby = Input::get('sortby');
		}

		//Fetch store
		$store = $this->getStoreBySlug($slug);
		if (!$store) {
			
			\App::abort(404);

		} else {

			$store_status = $store->store_status_type_id;

			// Show the category products
			if ($store_status === 3) {

				// Fetch store appearance
				$appearance =  DB::table('store_appearance')->where('store_id', $store->id)->first();

				// total products count
				\View::share('category_sum',$categoryHelper->get_products_total($store->id));

				//Fetch all the products for store
				$productsQuery = \App\Models\Product::where('store_id', '=', $store->id)
									->where('product_status_id', '=', \App\Models\Product::PRODUCT_STATUS_TYPE_VISIBLE)
									->where('product_moderation_type_id', '=', \App\Models\Product::PRODUCT_MODERATION_APPROVED);

				// if term (temp?)
				if ($term) {
					$productsQuery = $productsQuery->where(function($query) use ($term) {
						$query->where('products.title', 'like', '%' . $term . '%')
							->orWhere('products.description', 'like', '%' . $term . '%');
					}); 
				}

				$cat_tier = 0;
				if ($cat_name) {

					$category = Category::where('name', $cat_name)->first();

					if (!$category) {
						$category = CategoriesCustom::where('name', $cat_name)->first();
						if ($category) {
							$cat_tier = 3;
						}
					} else {
						$cat_tier = 2;
					}

				}

				// get all search result categories for term ( not if category used )

				\View::share('categories', $this->getStoreSearchCategories($store->id, $productsQuery->get()));

				// filter by category if category is available

				if ($cat_tier === 2) {
					$productsQuery->where('products.category_id', $category->id);
				}
				if ($cat_tier === 3) {
					$productsQuery->where('products.category_custom_id', $category->id);
				}

				// no products in category


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

				$active_cats = [];
				if($category) {

					// Active category items
					$active_cats[]	= $category->slug;
					$cat_ancestor   = (isset($category->ancestor)) ? $category->ancestor : '';
					if($cat_ancestor) {
						$active_cats[] = $cat_ancestor->slug;
						$cat_grand_ancestor = (isset($cat_ancestor->ancestor)) ? $cat_ancestor->ancestor : '';
						if ($cat_grand_ancestor) {
							$active_cats[] = $cat_grand_ancestor->slug;
						} 
					}

				}

				\View::share('active_cats', $active_cats);

				\View::share('term_parameter', $term_parameter);
				\View::share('cat_parameter', $cat_parameter);

				\View::share('products', $products);
				\View::share('store', $store);
				\View::share('appearance', $appearance);
				\View::share('term', $term);
				\View::share('category', $category);

				return view('frontend.search.index');
			
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

	private function getStoreSearchCategories($storeId, $products, $withChildCounts = false) {
		

		// for each product, get the category_id and category_custom_id

		$cats_tree   	  = [];
		$tier_2_cats_tree = [];

		$tier_1_cats	  = [];
		$tier_2_cats      = [];
		$tier_3_cats      = [];

		foreach($products as $product) {

			// cats_2_tree []
			$tier_2_cat = '';

			// 1. get all the 2nd tier categories and their children
			// 2. $hierarchy = ['tier_2_cat_id' => 'tier_1_cat_id']
			
			// to lower the call amount to db
			// check if category object is already there
			
			if (!in_array($product->category_id, $tier_2_cats)) {
				
				array_push($tier_2_cats, $product->category_id);

				$tier_2_cat = Category::find($product->category_id);
				
				$tier_2_cats_tree[$tier_2_cat->id] = (object)$tier_2_cat->getAttributes();
				$tier_2_cats_tree[$tier_2_cat->id]->numProducts = 0;
				$tier_2_cats_tree[$tier_2_cat->id]->children    = [];

				// add tier 1 category if not there
				if (!in_array($tier_2_cat->parent_id, $tier_1_cats)) {

					array_push($tier_1_cats, $tier_2_cat->parent_id);

					$tier_1_cat = Category::find($tier_2_cat->parent_id);

					$cats_tree[$tier_1_cat->id] = (object)$tier_1_cat->getAttributes();
					$cats_tree[$tier_1_cat->id]->numProducts = 0;
					$cats_tree[$tier_1_cat->id]->children    = [];
				}

			}

			// add to product count
			$tier_2_cats_tree[$product->category_id]->numProducts += 1;

			// to lower the calls amount to db
			if($product->category_custom_id) {
				if(!in_array($product->category_custom_id, $tier_3_cats)) {

					array_push($tier_3_cats, $product->category_custom_id);
					$tier_3_cat = CategoriesCustom::find($product->category_custom_id);
					$tier_2_cats_tree[$product->category_id]->children[$tier_3_cat->id] = (object)$tier_3_cat->getAttributes();
					$tier_2_cats_tree[$product->category_id]->children[$tier_3_cat->id]->numProducts = 0;
					$tier_2_cats_tree[$product->category_id]->children[$tier_3_cat->id]->children = [];

				}

				// add to product count
				$tier_2_cats_tree[$product->category_id]->children[$tier_3_cat->id]->numProducts += 1;
			}

		}

		foreach($tier_2_cats_tree as $t_2) {

			$cats_tree[$t_2->parent_id]->children[] = $t_2; 

		}

		return $cats_tree;
	}

	public function contact($slug) {
		
		$store = $this->getStoreBySlug($slug);
		if (!$store) {
			
			\App::abort(404);

		} else {

			$appearance =  DB::table('store_appearance')->where('store_id', $store->id)->first();

			$details = (isset($store->details)) ? $store->details : '';
			$address = '';
			if($details) {
				$address .=  ($details->street_address_1) ? $details->street_address_1 : '';
				//$address .=  ($details->street_address_2) ? ', ' . $details->street_address_2 : '';
			}

			\View::share('store', $store);
			\View::share('appearance', $appearance);

			\View::share('details', $details);
			\View::share('address', $address);

			\View::share('pageTitle', 'Contact Details');

			return view('frontend.store.contact');

		}

	}

	public function about($slug) {

		$store = $this->getStoreBySlug($slug);
		if (!$store) {
			
			\App::abort(404);

		} else {

			$appearance =  DB::table('store_appearance')->where('store_id', $store->id)->first();

			$about = $store->about;

			\View::share('store', $store);
			\View::share('appearance', $appearance);

			\View::share('about', $about);
			\View::share('pageTitle', 'About');

			return view('frontend.store.about');

		}

	}

	public function warranty($slug) {
		
		$store = $this->getStoreBySlug($slug);
		if (!$store) {
			
			\App::abort(404);

		} else {

			$appearance =  DB::table('store_appearance')->where('store_id', $store->id)->first();

			$about_excerpt   = (isset($store->about)) ? $store->about->exerpt : '';
			$store_warranty  = (isset($store->warranty)) ? $store->warranty->warranty : '';

			\View::share('store', $store);
			\View::share('appearance', $appearance);

			\View::share('about_excerpt', $about_excerpt);
			\View::share('store_warranty', $store_warranty);
			\View::share('pageTitle', 'Warranty');

			return view('frontend.store.warranty');

		}

	}
}
