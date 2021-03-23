<?php

namespace App\Http\Helpers;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeValueProduct;
use App\Models\AttributeCategory;
use App\Models\Store;
use App\Models\ProductContactDetails;
use App\Models\Suburb;
use App\Models\Product;
use App\Models\StoreDetail;
use App\Models\ProductImage;
use App\Models\osclass\Items;
use App\Models\osclass\User;
use App\Models\osclass\ItemDescription;
use App\Models\osclass\ItemLocation;
use App\Models\osclass\ItemStats;
use App\Models\osclass\Region;
use App\Models\osclass\City;
use App\Models\osclass\ItemMeta;
use App\Models\osclass\MetaFields;
use App\Models\osclass\ItemResource;
use App\Models\osclass\CategoryDescription;
use App\Models\osclass\CarMakeAttribute;
use App\Models\osclass\CarModelAttribute;
use App\Models\osclass\CarTypeAttribute;
use App\Models\osclass\CarItemAttribute;

use App\Models\osclass\TruckMakeAttribute;
use App\Models\osclass\TruckModelAttribute;
use App\Models\osclass\TruckTypeAttribute;
use App\Models\osclass\TruckItemAttribute;

use App\Models\osclass\BikeMakeAttribute;
use App\Models\osclass\BikeModelAttribute;
use App\Models\osclass\BikeItemAttribute;
use Response;
use URL;
class ProductSyncHelper{

	public static function test(){
		return (object)['status'=>true, 'message'=>'live and direct son'];
	}
	public function itemOsclassSync($id){
		$product = Product::where('id', $id)->first();
		if($product){
			$product_data = (object)[
				'title'=>$product->title,
				'description'=>$product->description,
				'price'=>$product->price,
				'slug'=>$product->slug,
				'platform'=>$product->platform,
				'category_id'=>$product->category_id,
				'category_slug'=>$product->category->slug,
				'expiration_dt'=>$product->expiration_dt,
				'created_date'=>$product->created_at->format('Y-m-d h:i:s'),
				'updated_date'=>$product->updated_at->format('Y-m-d h:i:s'),
				'b_active'=>$product->product_moderation_type_id,
				'usernumber'=>'+263'.$product->store->details->phone,
				'city'=>((!empty($product->ContactDetails))? $product->ContactDetails->city->name : $product->store->details->city->name),
				'suburb'=>((!empty($product->ContactDetails))? $product->ContactDetails->suburb->name: $product->store->details->suburb->name),
				'address'=>$product->store->details->street_address_1,
				'product_url'=>URL::route('product', ['slug' => $product->store->slug, 'productSlug' => $product->slug]),
				'attribute'=>[],
				'images'=>[],
				
			];


			foreach ($product->AttributeValueProduct as $attribute) {
				$product_data->attribute[] =(object)[
						'value'=>$attribute->value,
						'attribute_value_id'=>$attribute->attribute_value_id,
						'attribut_slug'=> $attribute->attributedetails->slug,
						'attribute_value_id_m'=>$attribute->attributedetails->id,
						'attribute_name'=>$attribute->attributedetails->name,
				];
			}

			foreach ($product->images as $image) {
				//print_r($image->filename);
				if(!empty($image->filename)){
					$img = explode('.', $image->filename);
					$product_data->images[] =(object)[
					'filename'=>$img[0],
					'featured'=>$image->featured,
					's_path'=>'storage/',
					's_extension'=>$img[1],
					's_content_type'=>'images/'.$img[1],

				  ];
				}
				
			}
			if(($product->store->store_status_type_id == Store::STATUS_TYPE_APPROVED) && ($product->product_moderation_type_id == Product::PRODUCT_MODERATION_APPROVED)){
				$data  = $this->SyscItem($product_data);
			  return (object)['success'=>true, 'data'=> $data];
			}else{
				return (object)['success'=>false, 'message'=> 'either store is not approve or product is not approved'];
			}
			

		}else{
			return (object)['success'=>false, 'message'=> 'invalid product id'];
		}

	}

	private function SyscItem($product){
		
		//get user osclass
		$user = User::where('s_username', $product->usernumber)->first();
		if($user){
			$return_data =[];
			$category = CategoryDescription::where('s_slug', $product->category_slug)->first();
			$item = Items::where('slug', $product->slug)->first();
			if(!$item){
				$item = new Items();
				$today = date("Y-m-d H:i:s", mktime(23,59,59));

				$item->fill([
					'fk_i_user_id'=>$user->pk_i_id,
					'slug'=>$product->slug,
					'platform'=>$product->platform,
					'product_url'=>$product->product_url,
					'fk_i_category_id'=> $category->fk_i_category_id,
					'dt_creat_date'=>$product->created_date,
					'dt_pub_date'=>$product->created_date,
					'dt_mod_date'=>$product->updated_date,
					'i_price'=>($product->price * 10000),
					'fk_c_currency_code'=>'USD',
					's_contact_name'=>$user->s_name,
					's_contact_email'=>$user->s_email,
					's_ip'=>'192.168.1.1', //fix this
					'b_active'=> (($product->b_active == 2)? 1 : 0),
					'b_enabled'=>1,
					'b_spam'=>0,
					'b_premium'=>0,
					'dt_expiration'=>date("Y-m-d H:i:s", strtotime($today) + 60 * 86400 ),
					'dt_pub_date_ordered'=>$product->created_date,
					's_secret'=>$this->genRandomString(),

				])->save();
				if($item->pk_i_id){
					array_push($return_data, ['item_insert'=>true]);
				}
			}else{
				$item->fk_i_category_id = $category->fk_i_category_id;
				$item->i_price = ($product->price * 10000);
				$item->b_active = (($product->b_active == 2)? 1 : 0);
				$item->product_url = $product->product_url;
				$item->dt_mod_date = date('Y-m-d h:i:s');
				$item->dt_pub_date_ordered = date('Y-m-d h:i:s');
				$item->save();
				array_push($return_data, ['item_update'=>true]);
			}
			

			if($item->pk_i_id){
				//descriptions
				$description = $this->ItemDescriptionSync($item->pk_i_id, $product);
				array_push($return_data, $description);
				$location = $this->ItemLocationSync($item->pk_i_id, $product);
				array_push($return_data, $location);
				$image = $this->ItemImageSync($item->pk_i_id, $product);
				array_push($return_data, $image);
				$attribute_insert = $this->ItemAttributeSync($item->pk_i_id, $product);
				array_push($return_data, $attribute_insert);
				$stats = $this->ItemsStats($item->pk_i_id);
				array_push($return_data, $stats);
			}else{
				array_push($return_data, ['item_insert'=>false]);
			}
			

		   return ['success'=>false, 'proceses'=>$return_data];
		    

		    
		}else{
			return ['success'=>false, 'message'=>'user not available'];
		}
		
	}

	private function ItemsStats($id){
		$item_stats = ItemStats::where('fk_i_item_id', $id)->first();
		if(!$item_stats){
			$item_stats = new ItemStats();
			$item_stats->fill([
				'fk_i_item_id'=>$id,
				'i_num_views'=>0,
				'i_num_spam'=>0,
				'dt_date'=>date('Y-m-d'),
				'i_num_repeated'=>0,
				'i_num_bad_classified'=>0,
				'i_num_offensive'=>0,
				'i_num_premium_views'=>0,
				'i_num_expired'=>0,
			])->save();
			if($item_stats->fk_i_item_id){
				return ['ItemStats_insert'=>true];
			}else{
				return ['ItemStats_insert'=>false];
			}
		}else{
			return ['ItemStats_insert'=>false, 'message'=>'record exist'];
		}
	}
	private function genRandomString($length = 8) {
        $dict = array_merge(range('a', 'z'), range('0', '9'), range('A', 'Z'));
        shuffle($dict);

        $pass = '';
        for($i = 0; $i < $length; $i++)
            $pass .= $dict[rand(0, count($dict) - 1)];

        return $pass;
    }

    private function ItemDescriptionSync($itemid, $product){
    	$items_details = ItemDescription::where('fk_i_item_id', $itemid)->first();
    	if($items_details){
    		$items_details->s_title = $product->title;
		    $items_details->s_description=$product->description;
		    $items_details->save();
		    return ['description_update' => true];
    	}else{
			$items_details = new ItemDescription();
			$items_details->fill([
		    	'fk_i_item_id'=>$itemid,
		    	'fk_c_locale_code'=>'en_US',
		    	's_title'=>$product->title,
		    	's_description'=>$product->description,
		    ])->save();
		    if($items_details->fk_i_item_id){
		    	return ['description_insert' => true];
		    }else{
		    	return ['description_insert' => false];
		    }
		    
    	}
    	
    }

    private function ItemLocationSync($itemid, $product){
    	 $region = Region::where('s_name', $product->city)->first();
		  if(!$region){
		    $region = Region::first();
		  }
		  $suburb = City::where('s_name', $product->suburb)->where('fk_i_region_id', $region->pk_i_id)->first();
		  if(!$suburb){
		  	$suburb = City::where('fk_i_region_id', $region->pk_i_id)->first();
		  }
		  $item_location = ItemLocation::where('fk_i_item_id', $itemid)->first();
		  if($item_location){
		  	$item_location->s_address = $product->address;
		  	$item_location->fk_i_region_id = $region->pk_i_id;
		  	$item_location->s_region = $region->s_name;
		  	$item_location->fk_i_city_id= $suburb->pk_i_id;
		  	$item_location->s_city = $suburb->s_name;
		  	$item_location->save();
		  	return ['location_update' => true];
		  }else{
		  	//location
		    $item_location = new ItemLocation();
		    $item_location->fill(
			    [
			        'fk_i_item_id'=>$itemid,
			        'fk_c_country_code'=>'ZW',
			        's_country'=>'Zimbabwe',
			        's_address'=>$product->address,
			        'fk_i_region_id'=>$region->pk_i_id,
			        's_region'=>$region->s_name,
			        'fk_i_city_id' =>$suburb->pk_i_id,
					's_city'=>$suburb->s_name,
			    ])->save();
		    if($item_location->fk_i_item_id){
		    	return ['location_insert' => true];
		    }else{
		    	return ['location_insert' => false];
		    }
		  }
		    
    }

    private function ItemImageSync($itemid, $product){
    	$item_image = ItemResource::where('fk_i_item_id', $itemid)->get();
    	if($item_image){
    		$delete = ItemResource::where('fk_i_item_id', $itemid)->delete();
    	}
    	$images_insert = 0;
    	//images
		foreach ($product->images as $image) {
		    $image_items = new ItemResource();
		    $image_items->fill([
		    		'fk_i_item_id'=>$itemid,
		    		's_name'=>$image->filename, 
		    		's_extension'=>$image->s_extension, 
		    		's_content_type'=>$image->s_content_type,
		    		's_path'=>$image->s_path

		    ])->save();
		    if($image_items->fk_i_item_id){
				$images_insert++;
			}

		}

		if($images_insert == 0){
			return ['images_insert' => false];
		}else{
			
			return ['images_insert' => true, 'images_inserted_total'=>$images_insert];
		}
    }

    public static function ItemDelete($slug){
    	$item = Items::where('slug', $slug)->first();
		if($item){
			$itemid = $item->pk_i_id;
			$items_details = ItemDescription::where('fk_i_item_id', $itemid)->delete();//description
    		$item_location = ItemLocation::where('fk_i_item_id', $itemid)->delete();//location
    		$delete = ItemResource::where('fk_i_item_id', $itemid)->delete();//images
    		$delete_meta = ItemMeta::where('fk_i_item_id', $itemid)->delete();//meta data
			$delete_car_meta = CarItemAttribute::where('fk_i_item_id', $itemid)->delete();//car attribute
			$delete_truck_meta = TruckItemAttribute::where('fk_i_item_id', $itemid)->delete();//truck attribute
			$delete_bike_meta = BikeItemAttribute::where('fk_i_item_id', $itemid)->delete();//bike attribute 
			$item_stats = ItemStats::where('fk_i_item_id', $itemid)->delete();//item statcs 
			$item->delete();
			return ['success' => true, 'item_deleted'=>$item];
		}else{
			return ['success' => false, 'item_deleted'=>$item];
		}
    	
    }
    private function ItemAttributeSync($itemid, $product){
    	$vehicle = (object)[
		   	'model'=>null,
		   	'model_value' => null,
		   	'make'=> null,
		   	'make_value'=>null
		 ];

		 $return_data =[];
		 $delete_meta = ItemMeta::where('fk_i_item_id', $itemid)->delete();
		 $delete_car_meta = CarItemAttribute::where('fk_i_item_id', $itemid)->delete();
		 $delete_truck_meta = TruckItemAttribute::where('fk_i_item_id', $itemid)->delete();
		 $delete_bike_meta = BikeItemAttribute::where('fk_i_item_id', $itemid)->delete();
		//items attributes
		foreach ($product->attribute as $attribute) {
		    	
		    	switch ($attribute->attribut_slug) {
		    		case 'car_model':
		    			$vehicle->model = $attribute->attribut_slug;
		    			$vehicle->model_value = $attribute->value;
		    			break;
		    		case 'car_make':
		    			$vehicle->make = $attribute->attribut_slug;
		    			$vehicle->make_value = $attribute->value;
		    			break;
		    		case 'bike_make':
		    			$vehicle->make = $attribute->attribut_slug;
		    			$vehicle->make_value = $attribute->value;
		    		break;
		    		case 'bike_model':
		    			$vehicle->model = $attribute->attribut_slug;
		    			$vehicle->model_value = $attribute->value;
		    		break;
		    		case 'truck_make':
		    			$vehicle->make = $attribute->attribut_slug;
		    			$vehicle->make_value = $attribute->value;
		    		break;
		    		case 'truck_model':
		    			$vehicle->model = $attribute->attribut_slug;
		    			$vehicle->model_value = $attribute->value;
		    		break;
		    		
		    		default:
		    			
		    			$meta_filed = MetaFields::where('s_slug', $attribute->attribut_slug)->first();
		    			if($meta_filed){
		    				$meta_items = new ItemMeta();
		    				$meta_items->fill([
		    					'fk_i_item_id'=>$itemid,
		    					'fk_i_field_id'=>$meta_filed->pk_i_id, 
		    					's_value'=>$attribute->value, 
		    					's_multi'=>'',
		    				])->save();
		    				if($meta_items->fk_i_item_id){
		    					$return_data[] =['insert'=>true, 'attribute'=>$attribute];
		    				}else{
		    					$return_data[] =['insert'=>false, 'attribute'=>$attribute];
		    				}
		    			} 

		    			break;
		    	}
		    	
		    	

		}


		switch ($vehicle->make) {
		    case 'car_make':
		    	if(!empty($vehicle->model_value)){
		    		$car_make = CarMakeAttribute::where('s_name', $vehicle->make_value)->first();
		    		$car_model = CarModelAttribute::where('s_name', $vehicle->model_value)->first();
		    		$car_item = new CarItemAttribute();
		    		$car_item->fill([
		    				'fk_i_item_id'=>$itemid,
		    				'fk_i_make_id'=>$car_make->pk_i_id,
		    				'fk_i_model_id'=>$car_model->pk_i_id,
		    				'fk_vehicle_type_id'=>$car_model->fk_i_make_id,
		    		])->save();
		    		if($car_item->fk_i_item_id){
		    			$return_data[] =['insert'=>true, 'attribute'=>$attribute];
		    		}else{
		    			$return_data[] =['insert'=>false, 'attribute'=>$attribute];
		    		}
		    	}else{
		    			$return_data[] =['insert'=>false, 'attribute'=>$attribute];
		    	}
		    	break;
		    case 'truck_make':
		    		if(!empty($vehicle->model_value)){
		    			$truck_make = TruckMakeAttribute::where('s_name', $vehicle->make_value)->first();
			    		$truck_model = TruckModelAttribute::where('s_name', $vehicle->model_value)->first();

			    		$truck_item = new TruckItemAttribute();
			    		$truck_item->fill([
			    				'fk_i_item_id'=>$itemid,
			    				'fk_i_make_id'=>$truck_make->pk_i_id,
			    				'fk_i_model_id'=>$truck_model->pk_i_id,
			    				'fk_vehicle_type_id'=>$truck_model->fk_i_make_id,
			    		])->save();
			    		if($truck_item->fk_i_item_id){
			    			$return_data[] =['insert'=>true, 'attribute'=>$attribute];
			    		}else{
			    			$return_data[] =['insert'=>false, 'attribute'=>$attribute];
			    		}
		    		}else{
			    			$return_data[] =['insert'=>false, 'attribute'=>$attribute];
			    		}
		    		
		    	break;
		    case 'bike_make':
			    if(!empty($vehicle->model_value)){
			    		$bike_make = BikeMakeAttribute::where('s_name', $vehicle->make_value)->first();
			    		$bike_model = BikeModelAttribute::where('s_name', $vehicle->model_value)->first();
			    		$bike_item = new BikeItemAttribute();
			    		$bike_item->fill([
			    				'fk_i_item_id'=>$itemid,
			    				'fk_i_make_id'=>$bike_make->pk_i_id,
			    				'fk_i_model_id'=>$bike_model->pk_i_id,
			    				'fk_vehicle_type_id'=>$bike_model->fk_i_make_id,
			    		])->save();
			    		if($bike_item->fk_i_item_id){
			    			$return_data[] =['insert'=>true, 'attribute'=>$attribute];
			    		}else{
			    			$return_data[] =['insert'=>false, 'attribute'=>$attribute];
			    		}
			    }else{
				    $return_data[] =['insert'=>false, 'attribute'=>$attribute];
				  }
		    	break;
		    			
		    default:
		    				
		    	break;
		}

		return $return_data;
    }


    public static function statusChange($id){
    		$product = Product::where('id', $id)->first();
    		if($product){
    			$item = Items::where('slug', $product->slug)->first();
    			if($item){
    				
    				$item->b_active = (($product->product_moderation_type_id == 2)? 1 : 0);
    				if($product->product_moderation_type_id == 1){
    					$today = date("Y-m-d H:i:s", mktime(23,59,59));
    					$item->dt_expiration = date("Y-m-d H:i:s", strtotime($today) + 60 * 86400 );
    					$item->b_spam = 0;
    					$item->b_active = 1;
    				}elseif($product->product_moderation_type_id == 2){
    					$item->b_spam = 1;
    					$item->b_active = 1;
    				}else{
    					$item->b_spam = 0;
    					$item->b_active = 0;
    				}
    				$item->save();
    				
    			}
    		}
    }

    public function productSyncChangeStatus($id){
    	$item = Items::where('pk_i_id', $id)->first();
    	if($item){
    		$product=(object)[
    				'slug'=>$item->slug,
    				'id'=>$item->pk_i_id,
    				'user_phone'=>substr($item->user->s_username, 4),
    				'product_moderation_type_id'=>$item->b_active,
					'b_spam'=>$item->b_spam,


    		];
    		$data = $this->ChangeStatusProductSync($product);
    		return $data;
    	}else{
    		return ['success'=>false, 'message'=>'invalid item id'];
    	}
    }
	public function productSyncDelete($slug){
		
		$product=(object)[
					'slug'=>$slug,
		];
		$data = $this->DeleteProductSync($product);
		return $data;
		
	}
	private function ChangeStatusProductSync($product){
		$return_data =[];
		$user = StoreDetail::where('phone', $product->user_phone)->first();
		if($user){
				$store_product = Product::where('slug', $product->slug)->first();
				if($store_product){
					if($product->b_spam == 1){
		    			$store_product->product_moderation_type_id = 2;
		    		}else{
		    			$store_product->product_moderation_type_id = 1;
		    		}
					$store_product->save();
				}else{
					$data = $this->productSync($product->id);
					array_push($return_data, $data);
				}
		}else{
			array_push($return_data, ['product_sync'=>false, 'message'=>'user not available']);

		}

		return $return_data;

	}

	private function DeleteProductSync($product){
		$return_data =[];
		
		$store_product = Product::where('slug', $product->slug)->first();
		if($store_product){
			$data_attribuite = AttributeValueProduct::where('product_id', $store_product->id)->delete();
			$data_images = ProductImage::where('product_id', $store_product->id)->delete();
			$data_product = Product::where('id', $store_product->id)->delete();
			array_push($return_data, ['product_sync'=>true, 
						'message'=>'product has been deleted',
						'data'=>[
							$data_attribuite,
							$data_images,
							$data_product,
			]]);

		}else{
			array_push($return_data, ['product_sync'=>false, 
						'message'=>'product is invalid',
						]);
		}
		

		return $return_data;
	}

	public function DeleteMigration($id){
		$return_data = [];
		$item = Items::where('pk_i_id', $id)->first();
		if($item){
			$store_product = Product::where('slug', $item->slug)->first();
			if($store_product){
				$data_attribuite = AttributeValueProduct::where('product_id', $store_product->id)->delete();
				$data_images = ProductImage::where('product_id', $store_product->id)->delete();
				$data_product = Product::where('id', $store_product->id)->delete();
				array_push($return_data, ['item_delete'=>true, 
							'message'=>'product has been deleted',
							'data'=>[
								$data_attribuite,
								$data_images,
								$data_product,
								
				]]);
			}else{
					array_push($return_data, ['item_delete'=>false, 
									'message'=>'product is invalid',
									]);
			}
			$itemid = $item->pk_i_id;
			$items_details = ItemDescription::where('fk_i_item_id', $itemid)->delete();//description
    		$item_location = ItemLocation::where('fk_i_item_id', $itemid)->delete();//location
    		$delete = ItemResource::where('fk_i_item_id', $itemid)->delete();//images
    		$delete_meta = ItemMeta::where('fk_i_item_id', $itemid)->delete();//meta data
			$delete_car_meta = CarItemAttribute::where('fk_i_item_id', $itemid)->delete();//car attribute
			$delete_truck_meta = TruckItemAttribute::where('fk_i_item_id', $itemid)->delete();//truck attribute
			$delete_bike_meta = BikeItemAttribute::where('fk_i_item_id', $itemid)->delete();//bike attribute 
			$item_stats = ItemStats::where('fk_i_item_id', $itemid)->delete();//item statcs 
			$item->delete();
			array_push($return_data, ['item_delete'=>true, 
							'message'=>'product has been deleted',
							'data'=>[
								$items_details,
								$item_location,
								$delete,
								$delete_meta,
								$delete_car_meta,
								$delete_truck_meta,
								$delete_bike_meta,
								$item_stats,
								$item,
				]]);
			
		}else{
			array_push($return_data, ['item_delete'=>false, 
									'message'=>'item is invalid',
									]);
		}
		return $return_data;

	}
    public function productSync($id, $allowed = false){
    	$item = Items::where('pk_i_id', $id)->first();
    	if($item){

    		

			    	$product =(object)[
			    		'user_phone'=>substr($item->user->s_username, 4),
			    		's_name'=>$item->user->s_name,
			    		'title'=>$item->item_desc->s_title,
			    		'description'=>$item->item_desc->s_description,
			    		'slug'=>$item->slug,
			    		'platform'=>$item->platform,
			    		'price'=>$item->i_price,
			    		'currency_id'=>1,
			    		'product_type_id'=>1,
			    		'product_status_id'=>2,
			    		'category_slug'=>$item->category_description->s_slug,
			    		'product_moderation_type_id'=>$item->b_active,
			    		'b_spam'=>$item->b_spam,
			    		'attributes'=>[],
			    		'images'=>[],
			    		'parent_category_name'=>$item->category->parent->description->s_name,
			    		'parent_category_slug'=>$item->category->parent->description->s_slug,
			    		'item_id'=>$item->pk_i_id,
			    	]; 
			    	foreach ($item->item_meta as $attribute) {
			    		$product->attributes[]=(object)[
			    			'value'=>$attribute->s_value,
			    			'field_slug'=>$attribute->field->s_slug
			    		];
			    	}
			    		if(!empty($item->car_attribute->model)){
			    			$product->attributes[]=(object)[
			    					'value'=>$item->car_attribute->model->s_name,
			    					'field_slug'=>'car_model',
			    			];
			    		}
			    		if(!empty($item->car_attribute->make)){
			    			$product->attributes[]=(object)[
			    					'value'=>$item->car_attribute->make->s_name,
			    					'field_slug'=>'car_make',
			    			];
			    		}

			    		if(!empty($item->bike_attribute->model)){
			    			$product->attributes[]=(object)[
			    					'value'=>$item->bike_attribute->model->s_name,
			    					'field_slug'=>'bike_model',
			    			];
			    		}
			    		if(!empty($item->bike_attribute->make)){
			    			$product->attributes[]=(object)[
			    					'value'=>$item->bike_attribute->make->s_name,
			    					'field_slug'=>'bike_make',
			    			];
			    		}

			    		if(!empty($item->truck_attribute->model)){
			    			$product->attributes[]=(object)[
			    					'value'=>$item->truck_attribute->model->s_name,
			    					'field_slug'=>'truck_model',
			    			];
			    		}
			    		if(!empty($item->truck_attribute->make)){
			    			$product->attributes[]=(object)[
			    					'value'=>$item->truck_attribute->make->s_name,
			    					'field_slug'=>'truck_make',
			    			];
			    		}
			    	$i = 0;
			    	foreach ($item->item_resource as $images) {
			    	
			    		$img = explode('.', $images->s_name);
			    		if(array_key_exists(1, $img)){
			    			$imgs = $images->s_name;
			    		}else{
			    			$imgs = $images->s_name.'.'.$images->s_extension;
			    		}
			    		
			    			$product->images[]=(object)[
			    				'filename'=>$imgs,
			    				'original_upload'=>$imgs,
			    				'featured'=>(($i== 0)? 1: 0),
			    			];
			    		
			    		
			    		$i++;
			    	}
			    	
			    			$data_return = $this->SyscProduct($product);
			    			return (object) $data_return;
			
    	}else{
    		return (object) ['success'=>false, 'message'=>'item does not exist'];
    	}
    	
    }

    private function SyscProduct($product){
    	$return_data =[];
    	$user = StoreDetail::where('phone', $product->user_phone)->first();
    	
    	if($user){
    		if($user->store->type->slug == $product->parent_category_slug){
			
	    		$category =  Category::where('slug', $product->category_slug)->first();
	    		if($category){
	    			$store_product = Product::where('slug', $product->slug)->withTrashed()->first();
		    		if(!$store_product){
		    			$store_product = new Product();
		    		}
		    		$store_product->store_id = $user->store_id;
		    		$store_product->title = $product->title;
		    		$store_product->description = $product->description;
		    		$store_product->slug = $product->slug;
		    		$store_product->platform = $product->platform;
		    		$store_product->price = ($product->price == NULL ? 0: ($product->price / 10000)); //fix this
		    		$store_product->currency_id = $product->currency_id;
		    		$store_product->product_type_id = $product->product_type_id;
		    		$store_product->product_status_id = $product->product_status_id;
		    		$store_product->category_id = $category->id;
		    		if($product->b_spam == 1){
		    			$store_product->product_moderation_type_id = 2;
		    		}else{
		    			$store_product->product_moderation_type_id = 1;
		    		}
		    		if(!empty($store_product->deleted_at)){
		    			$store_product->deleted_at = NULL;
		    		}
		    		
		    		$store_product->save();
		    		if($store_product->id){
		    			array_push($return_data, ['product_sync'=>true]);
		    			$data_sync_atrr= $this->ProductAttributeSync($store_product->id, $product);
		    			array_push($return_data, $data_sync_atrr);
		    			$data_sync_contact_details= $this->ProductContactSync($store_product->id, $product);
		    			array_push($return_data, $data_sync_contact_details);
		    			$data_sync_image=  $this->ProductImageSync($store_product->id, $product);
		    			array_push($return_data, $data_sync_image);
		    		}else{
		    			array_push($return_data, ['product_sync'=>false]);
		    		}
		    		
	    		}else{
	    			array_push($return_data, ['product_sync'=>false, 'message'=>'invalid category']);
	    		}
    		}else{
				return (object) ['success'=>false, 'message'=>'item does not match the store type', 'item'=>$product];
			}

    	}else{
    		array_push($return_data, ['product_sync'=>false, 'message'=>'user not available']);
    	}
    	return $return_data;
    }

    private function ProductContactSync($id, $product){
    	$return_data =[];
    	$item_location = ItemLocation::where('fk_i_item_id', $product->item_id)->first();
  //   	$region = Region::where('s_name', $product->city)->first();
		// $suburb = City::where('s_name', $product->suburb)->where('fk_i_region_id', $region->pk_i_id)->first();
		$city = \App\Models\City::where('name', $item_location->s_region)->first();
		if(!$city){
			$city = \App\Models\City::first();
		}
		$Suburb = Suburb::where('name', $item_location->s_city)->first();
		if(!$Suburb){
			$Suburb = Suburb::where('city_id', $city->id)->first();
		}
		$ProductContactDetails = ProductContactDetails::where('product_id', $id)->first();
		if(!$ProductContactDetails){
		   $ProductContactDetails = new ProductContactDetails();
		   $ProductContactDetails->product_id = $id;
		   $ProductContactDetails->contact_name = $product->s_name;
		   $ProductContactDetails->phone = $product->user_phone;

		}
		$ProductContactDetails->city_id = $city->id;
		$ProductContactDetails->suburb_id = $Suburb->id;
		
		$ProductContactDetails->save();
		$return_data[]=['contactdetails'=>true, 'details'=>$ProductContactDetails];	
		return $return_data;
    }
    private function ProductAttributeSync($id, $product){
    	$return_data =[];
    	$attribute = AttributeValueProduct::where('product_id', $id)->delete();
    	foreach ($product->attributes as $attr) {
    		$attribue_value = Attribute::where('slug', $attr->field_slug)->first();
    		if($attribue_value){
    			$attribute_data = new AttributeValueProduct();
    			$attribute_data->fill([
    				'value'=>$attr->value,
    				'product_id'=>$id,
    				'attribute_value_id'=>$attribue_value->id,
    			])->save();
    			if($attribute_data->id){
    				$return_data[]=['attribute_insert'=>true, 'attribute'=>$attr];
    			}else{
    				$return_data[]=['attribute_insert'=>false, 'attribute'=>$attr, 'message'=>'insert error'];
    			}
    		}else{
    			$return_data[]=['attribute_insert'=>false, 'attribute'=>$attr, 'message'=>'invalid attribute'];
    		}
    	}

    	return $return_data;

    }
    private function ProductImageSync($id, $product){
    	$return_data = [];
    	$images = ProductImage::where('product_id', $id)->delete();
    	foreach ($product->images as $image) {
    		
    		$img = new ProductImage();
    		$img->fill([
    				'filename'=>$image->filename,
    				'product_id'=>$id,
    				'original_upload'=>$image->original_upload,
    				'featured'=>$image->featured,
    		])->save();
    		if($img->id){
    			$return_data[]=['images_insert'=>true, 'image'=>$image];
    		}else{
    			$return_data[]=['images_insert'=>false, 'image'=>$image, 'message'=>'insert failed'];
    		}
    	}
    	return $return_data;
    } 
	
}