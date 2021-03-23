<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\StoreContactDetail;
use App\Models\StoreStatusType;

use DB;

class ProductController extends BaseController
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
	
	public function product($slug, $productSlug) {

		// Fetch store
		$store = Store::where('slug', '=', $slug)->first();
		if (!$store) {
			\App::abort(404);

		}

		switch ($store->store_status_type_id) {
			case 3:
					//Fetch product
					$product = \App\Models\Product::
								where('slug', '=', $productSlug)
								->where('store_id', '=', $store->id)
								->where('product_status_id', '=', \App\Models\Product::PRODUCT_STATUS_TYPE_VISIBLE)
								->where('product_moderation_type_id', '=', \App\Models\Product::PRODUCT_MODERATION_APPROVED)
								->with('images')
								->first();


					if (!$product) {
							\App::abort(404);
					}// Appearance

					$ancestor_cat_name = '';

					if($product->category->parent_id) {
						$ancestor_cat_name = strtolower($product->category->ancestor->getAttributes()['name']);
					}

					// display 'configuration'
					$show_qty 					= true;
					$show_add_to_cart 			= true;
					$show_price 				= true;
					$product_information_title  = 'Product Information';

					// if product ancestor category and product ancestor category is : property, jobs, services or vehicles
				 	if ($ancestor_cat_name) {

				 		if($ancestor_cat_name === 'property' || $ancestor_cat_name === 'jobs' || $ancestor_cat_name === 'services' || 
				 			$ancestor_cat_name === 'vehicles') {

				 			$show_qty	      = false;
				 			$show_add_to_cart = false;

				 			if ($ancestor_cat_name === 'jobs' || $ancestor_cat_name === 'services') {
				 				$show_price = false;
				 			}

				 			if ($ancestor_cat_name === 'property' || $ancestor_cat_name === 'jobs' || $ancestor_cat_name === 'services') {
				 				$product_information_title = ucfirst($ancestor_cat_name);

				 				if(substr($product_information_title, -1) === 's') {
				 					$product_information_title = substr($product_information_title, 0, -1);
				 				}
				 				$product_information_title .= ' Information';
				 			}

				 		}

				 	}

				 	// add 'config' to array
				 	$display_settings = [
				 		'show_qty'					=> $show_qty,
				 		'show_add_to_cart'  		=> $show_add_to_cart,
				 		'show_price' 			    => $show_price,
				 		'product_information_title'	=> $product_information_title
				 	];

					\View::share('display_settings', $display_settings);
                    // store contact details
                    $seller_details = $store->contactDetails;
                    //$seller_details = StoreContactDetail::where('store_id', '=', $store->id);

                    if ($seller_details) {

                        $seller_details = $store->contactDetails();

                        //$seller_details = $seller_details->with('city', 'suburb', 'country');
                        $seller_details = $seller_details->first(['firstname', 'lastname', 'phone', 'city_id', 'suburb_id', 'country_id'])->getAttributes();

                        $location = '';
                        $suburb  = ( (!empty($product->ContactDetails))?$product->ContactDetails->suburb : \App\Models\Suburb::find($seller_details['suburb_id']));
                        $city    = ( (!empty($product->ContactDetails))?$product->ContactDetails->city :\App\Models\City::find($seller_details['city_id']));
                        $country = \App\Models\Country::find($seller_details['country_id']);
                        $location .= ($suburb) ? $suburb['name'] . ', ' : '';
                        $location .= ($city) ? $city['name'] . ', ' : '';
                        $location .= ($country) ? $country['name'] : '';
                        $seller_details['name'] =  ( (!empty($product->ContactDetails))?$product->ContactDetails->contact_name :$seller_details['firstname'] . ' '. $seller_details['lastname']);
						$seller_details['phone'] =  ( (!empty($product->ContactDetails))?$product->ContactDetails->phone :$seller_details['phone']);
                        $seller_details = array_merge($seller_details, ['location' => $location] );
                    }

		            $appearance =  DB::table('store_appearance')->where('store_id', $store->id)->first();


						// get other product from the current store
						$other_products = \App\Models\Product::where('store_id', '=', $store->id)
											  ->where('slug', '<>', $productSlug)
											  ->where('product_status_id', '=', \App\Models\Product::PRODUCT_STATUS_TYPE_VISIBLE)
											->where('product_moderation_type_id', '=', \App\Models\Product::PRODUCT_MODERATION_APPROVED)
											  ->take(4)
											  ->get();



		                \View::share('seller_details', $seller_details);
		                // Seller Contact details

						
						\View::share('appearance', $appearance);
				        // Display

						\View::share('product', $product);
						\View::share('other_products', $other_products);
						\View::share('store', $store);
						
						return view('frontend.product.index');
				break;
			
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
					 $note ="404 error";
					  \View::share('Storenote', $note);
					  return view('frontend.store.error');
					break;
		}

		
	}
}
