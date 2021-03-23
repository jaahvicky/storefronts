<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use DB;
use Mail;
use Nexmo;

use App\Models\ProductStatusType;
use App\Models\Category;
use App\Models\AttributeValue;
use App\Models\StoreUser;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderStatus;
use App\Models\User;

class SingleOrderController extends BaseController
{
    //
     public function index(Request $request, $order_id = null) {
     	\ViewHelper::setActiveNav('orders');
        \ViewHelper::setPageDetails('Storefronts | Orders', 'Add Order', 'Add your own order');

        $store = Auth::user()->stores()->first();

        $user_stores = [];
        
        // $stores = $store_users->storeUser();
        
        if (!$store) {
            $request->session()->flash('alert-error', 'There is no store associated with this account.');
            return redirect()->route("admin.dashboard");
        }

        $visibils = ProductStatusType::all();
        foreach($visibils As $visibility) {
            $visibilities[$visibility->name] = $visibility->name; 
        }


        $categories = $this->getCategories($store->type);
        $attributes = $this->getAttributes();

        $orders = new Order();
        $currencies = $orders->getCurrencies();
        $countries = $orders->getCountries();
        $country_codes = $orders->getCountryCode();
        $payment_statuses = $orders->getPaymentStatuses();
        $delivery_statuses = $orders->getDeliveryStatuses();
        $payment_methods = $orders->getPaymentMethods();

        $data = [
        	'stores' => [],
            'categories' => $categories,
            'attributes' => $attributes,
            'visibilities' => $visibilities,
            'currencies' => $currencies,
            'countries' => $countries,
            'country_codes' => $country_codes,
            'payment_statuses' => $payment_statuses,
            'delivery_statuses' => $delivery_statuses,
            'payment_methods' => $payment_methods
        ];

        if($order_id){
           $data['order_id'] = $order_id;

           $order = $orders->getOrder($order_id);
           
           $data['cur_order'] = $order;

           $product = new Product();
           $category_id = $product->getCategory($order->products_id);
           $data['cur_category'] = $category_id;
           $category_products  = $product->getCatProducts($category_id);

           $data['cur_products'] = $category_products;

           $status = new OrderStatus;
           $order_status = $status->listKey();

           $data['order_status'] = $order_status;

        }
        
        return view('backoffice/order/index', $data);

     }


     private function getCategories($storeType) {
        
        $propertiesCat = Category::where('name', "Property")->first();
        $vehiclesCat = Category::where('name', 'Vehicles')->first();
        
        if ($storeType == 'vehicles') {
                
            $cats = DB::select("select categories.name As parent_name, subcats.name As child_name, subcats.id As child_id from categories left join categories As subcats on subcats.parent_id = categories.id where categories.id = ".$vehiclesCat->id);
        }
        else if ($storeType == 'properties') {

            $cats = DB::select("select categories.name As parent_name, subcats.name As child_name, subcats.id As child_id from categories left join categories As subcats on subcats.parent_id = categories.id where categories.id = ".$propertiesCat->id);
        }
        else {

            $notIn = "(".$propertiesCat->id.",".$vehiclesCat->id.")";
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
 
    public function getproducts(Request $request) {

    	$inputs = $request->all();
    	$categoryId = $inputs['categoryId'];
    	$storeId = $inputs['storeId'];

    	$products = DB::table('products')
    					->select('id', 'title', 'product_status_id', 'product_moderation_type_id', 'store_id')
    					->where([
								    ['product_status_id', '=', 2],
								    ['product_moderation_type_id', '=', 2],
								    ['store_id', '=', $storeId],
								    ['category_id', '=', $categoryId],
								])
    					->get();
        
        $prod_str = '';
        $status = 'nope';
        if($products){
        	foreach($products as $product) {
	            $prod_str .= "<option value='$product->id'>$product->title</option>";
	        }
	        $status = 'success';
        }
        

        $result = ['prod_str' => $prod_str, 'status' => ''];
        return $result;
    }

    public function addorder(Request $request) {

    	$input = $request->all();

    	$status = 'success';
    	$dt = new \DateTime();
		$dt->format('Y-m-d H:i:s');

		$user_id = Auth::user()->id;
        $email = $input['buyer_email'];
        $phone = $input['buyer_code'].$input['buyer_phone'];

        // delivery_status_id value changes?

    	$id = DB::table('orders')->insertGetId(
		    [	'order_nr' => '', 
		    	'invoice_nr' => '',
		    	'item_count' => $input['item_count'],
		    	'currency' => $input['currency'],
		    	'total_before_tax' => '',
		    	'tax' => '',
		    	'tax_percentage' => '',
		    	'total_after_tax' => '',
		    	'buyer_firstname' => $input['buyer_firstname'],
		    	'buyer_lastname' => $input['buyer_lastname'],
		    	'buyer_address_line_1' => $input['buyer_address_line_1'],
		    	'buyer_address_line_2' => $input['buyer_address_line_2'],
		    	'buyer_suburb' => $input['buyer_suburb'],
		    	'buyer_city' => $input['buyer_city'],
		    	'buyer_province_state' => $input['buyer_province_state'],
		    	'buyer_country' => $input['buyer_country'],
		    	'buyer_postal_code' => $input['item_count'],
		    	'order_notes' => $input['order_notes'],
                'buyer_email' => $input['buyer_email'],
		    	'buyer_phone' => $phone,
		    	'order_status_id' => 1,
		    	'store_id' => $input['store'],
		    	'users_id' => $user_id,
                'payment_status_id' => 1,
                'delivery_status_id' => 5,
                'payment_method_id' => 1,
		    	'created_at' => $dt,
		    	'updated_at' => $dt
		    ]
		);

		if($id > 0){
			//Update order Items table
			$orders_items_id = DB::table('order_items')->insertGetId(
			    [	'qty' => $input['item_count'], 
			    	'orders_id' => $id,
			    	'products_id' => $input['product'],
			    	'created_at' => $dt,
		    		'updated_at' => $dt
			    ]
			);

			if($orders_items_id > 0){

				$number = sprintf("%03d", $id);
				$order_num = 'OR'.$number;
				$invoice_num = 'IN'.$number;
				$update_order = DB::table('orders')
					            ->where('id', $id)
					            ->update([
					            			'order_nr' => $order_num, 
					            			'invoice_nr' => $invoice_num, 
					            		]);
				if(!$update_order){
					$status = 'error';
				} else {
                    $user = User::findOrFail($user_id);
                    $user->order_num = $order_num;
                    $user->order_id = $id;
                    $user->email = $email;


                    try{
                        $send = Mail::send('backoffice.email.notification', ['user' => $user ], function ($m) use ($user) {
                                    $m->from('tmarebane@methys.com', 'Ownai Storefronts');

                                    $m->to($user->email, $user->name)->subject('New Order!');

                                });

                        if($send){
                            $status_email = 'success';  
                        } else {
                             $status_email = 'error';
                        }
                    } catch(\Exception $e){
                        // catch code
                        $status_email = 'error';
                    }

                    try{
                        // try code
                        $send_sms = Nexmo::message()->send([
                                        'to' => $phone,
                                        'from' => '27837593930',
                                        'text' => 'Ownai Storefronts Order Placed, Ref:'.$order_num
                                    ]);
                        if($send_sms){
                            $status_sms = 'success';
                        } else {
                            $status_sms = 'error';
                        }
                    } catch(\Exception $e){
                        // catch code
                        $status_sms = 'error';
                    }
                            
                    

                }
			} else {
				$status = 'error';	
			}

		} else {
			$status = 'error';
		}

        $statuses = [   'status' => $status,
                        'status_email' => $status_email,
                        'status_sms' => $status_sms
                    ];
		return $statuses;

    }

    public function updateorder(Request $request) {
        $input = $request->all();

        $status = 'success';
        $dt = new \DateTime();
        $dt->format('Y-m-d H:i:s');

        $update = DB::table('orders')
                    ->where('id', $input['cur_order_id'])
                    ->update([
                                'item_count' => $input['item_count'],
                                'currency' => $input['currency'],
                                'buyer_firstname' => $input['buyer_firstname'],
                                'buyer_lastname' => $input['buyer_lastname'],
                                'buyer_address_line_1' => $input['buyer_address_line_1'],
                                'buyer_address_line_2' => $input['buyer_address_line_2'],
                                'buyer_suburb' => $input['buyer_suburb'],
                                'buyer_city' => $input['buyer_city'],
                                'buyer_province_state' => $input['buyer_province_state'],
                                'buyer_country' => $input['buyer_country'],
                                'buyer_postal_code' => $input['buyer_postal_code'],
                                'buyer_email' => $input['buyer_email'],
                                'buyer_phone' => $input['buyer_phone'],
                                'order_notes' => $input['order_notes'],
                                'order_status_id' => $input['order_status_id'],
                                'store_id' => $input['store'],
                                'payment_status_id' => $input['payment_status_id'],
                                'delivery_status_id' => $input['delivery_status_id'],
                                'payment_method_id' => $input['payment_method_id'],
                                'updated_at' => $dt,
                            ]);

        if($update){
            $orders_items = DB::table('order_items')
                            ->where('orders_id', $input['cur_order_id'])
                            ->update(
                                        [   'qty' => $input['item_count'], 
                                            'products_id' => $input['product'],
                                            'updated_at' => $dt
                                        ]
                                    );
            if($orders_items){
                $status = 'success';

            } else {
                $status = 'error';
            }
        }

        $statuses = [   'status' => $status,
                        'status_email' => '',
                        'status_sms' => ''
                    ];
                    
        return $statuses;

    
    }

    private function getAttributeValueProduct($categoryId) {
    	exit(var_dump($categoryId));

    }


}
