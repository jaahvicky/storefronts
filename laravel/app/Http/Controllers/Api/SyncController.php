<?php

namespace App\Http\Controllers\Api;

use View;
use DB;
use Validator;
use Illuminate\Http\Request;
use Response;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeCategory;
use App\Models\Store;
use App\Models\Product;
use App\Models\osclass\Items;
use App\Models\osclass\User;
use App\Models\osclass\ItemDescription;
use App\Models\osclass\ItemLocation;
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
use App\Http\Helpers\ProductSyncHelper;
// use Request;
use App\Http\Helpers\LookupHelper;
class SyncController extends BaseController {

	
	public function index(Request $request){
		$connection = DB::connection('mysql_OSCLASS');
		$attribute = $this->SyncAttributes($connection);
		$categories = $this->SyncCategories($connection);
		$car_attributes = $this->SyncVehicleAttributes($connection,'car_make');
		$bike_attributes = $this->SyncVehicleAttributes($connection,'bike_make');
		$truck_attributes = $this->SyncVehicleAttributes($connection,'truck_make');
		return Response::json(['success' => true, 'attribute'=>$attribute,'categories'=> $categories,"car_attributes"=>$car_attributes,  "bike_attributes"=>$bike_attributes, "truck_attributes"=>$truck_attributes]);
			
		
	}

	private function SyncVehicleAttributes($connection, $mslug){
		
		$attr =[];
		$insertedAtr = Attribute::where('slug', $mslug)->first();
		if(!$insertedAtr){
			$insertedAtr = new Attribute();
			$insertedAtr->fill([
				'name'=>'Make',
				'slug'=>$mslug,
				'type'=> "DROPDOWN",
			])->save();
		}
		$storefrntid = $insertedAtr->id;
		$categoreyAttribute =[];
		$attributes =[];
		switch($mslug){
			case 'car_make':
				$categoreyAttribute = $this->VehicleCategories($connection, "cars-pickup-trucks-4-x-4-s,car-parts-accessories", $storefrntid);
				$attributes = $connection->table("oc_t_item_car_make_attr")->get();
				break;
			case 'bike_make':
				$categoreyAttribute = $this->VehicleCategories($connection, "motorcycles-scooters", $storefrntid);
				$attributes = $connection->table("oc_t_item_bike_make_attr")->get();
				break;
			case 'truck_make':
				$categoreyAttribute = $this->VehicleCategories($connection, "lorries-commercial-vehicles", $storefrntid);
				$attributes = $connection->table("oc_t_item_truck_make_attr")->get();
				break;
			default:
				break;
		}
		
		$attr[]= ['categoreyAttribute'=>$categoreyAttribute];
		
		if(!empty($attributes)){
			foreach ($attributes as $attribute) {
				$value = $attribute->s_name;
		        $attrvalue = AttributeValue::where('attribute_id', $storefrntid)->where('value', $value)->first();
		        if(empty($attrvalue)){
		           $attrvalue = new AttributeValue();
					$data = $attrvalue->fill([
						'value'=> $value,
						'attribute_id'=>$storefrntid,
					])->save();
		        }	
				
				$data_r = $this->CarModelSync($connection, $attribute->pk_i_id, $attrvalue->id,$mslug);
				$attr[]= $data_r;
			}
		}
		


		return $attr;
	

	}

	private function CarModelSync($connection, $osclasid, $storefrntid, $mslug){
		$datareturn = [];
		$model_slug = null;
		switch($mslug){
			case 'car_make':
				$model_slug = 'car_model';
				break;
			case 'bike_make':
				$model_slug = 'bike_model';
				break;
			case 'truck_make':
				$model_slug = 'truck_model';
				break;
			default:

				break;

		}
		if($model_slug !=null){
			$insertedAtr = Attribute::where('slug', $model_slug)->first();
			if(!$insertedAtr){
				$insertedAtr = new Attribute();
				$insertedAtr->fill([
					'name'=>'Model',
					'slug'=>$model_slug,
					'type'=> "DROPDOWN",
				])->save();
			}
			$categoreyAttribute =[];
			$attributes =[];
			switch($model_slug){
				case 'car_model':
					$categoreyAttribute = $this->VehicleCategories($connection, "cars-pickup-trucks-4-x-4-s,car-parts-accessories", $insertedAtr->id);
					$attributes = $connection->table("oc_t_item_car_model_attr")->where("fk_i_make_id", $osclasid)->get();
					break;
				case 'bike_model':
					$categoreyAttribute = $this->VehicleCategories($connection, "motorcycles-scooters", $insertedAtr->id);
					$attributes = $connection->table("oc_t_item_bike_model_attr")->where("fk_i_make_id", $osclasid)->get();
					break;
				case 'truck_model':
					$categoreyAttribute = $this->VehicleCategories($connection, "lorries-commercial-vehicles", $insertedAtr->id);
					$attributes = $connection->table("oc_t_item_truck_model_attr")->where("fk_i_make_id", $osclasid)->get();
					break;
				default:

					break;
			}
			
			
			$datareturn[] =['categoreyAttribute'=>$categoreyAttribute];
			if(!empty($attributes)){
				foreach ($attributes as $attribute) {
					$data = $this->VehicleAttributeValue($attribute, $storefrntid);
					$datareturn[]=['insertstatus'=> $data, 'model_attribute'=>$attribute->s_name];
				}
			}
			
		}
		
		

		return $datareturn;

	}

	private function VehicleCategories($query,$category_Arry, $storefrntid){
		$array=array_map(null, explode(',', $category_Arry));
		$array = implode("','",$array);
		$return_data = [];
		$categories = $query->select("SELECT c.pk_i_id as id, d.s_name as name, d.s_slug as slug, c.fk_i_parent_id as parent_id from oc_t_category c INNER JOIN oc_t_category_description d on d.fk_i_category_id = c.pk_i_id where d.s_slug IN('".$array."')");
		foreach ($categories as $category) {
			$StoreCategory = Category::where('slug', $category->slug)->first();
			if($StoreCategory){
					$StorefrontAtributCat = AttributeCategory::where("category_id", $StoreCategory->id)->where("attribute_id", $storefrntid)->first();
					if(!$StorefrontAtributCat){
						$StorefrontAtributCat = new AttributeCategory();
						$StorefrontAtributCat->fill([
							"category_id" =>$StoreCategory->id,
							"attribute_id" =>$storefrntid,
						])->save();
						$return_data = ['status'=>true, 'categoreyAttributeInserted' =>$category->slug];
					}else{
						$return_data = ['status'=>true, 'categoreyAttribute' =>$category->slug, 'available'=>true];
					}
			}else{
				$return_data = ['status'=>false, 'categoreyAttribute' =>$category->slug];
			}
			
		}

		return $return_data;
	}

	private function VehicleAttributeValue($attribute, $parent){
		$inserted = false;
		$value = $attribute->s_name;
        $attrvalue = AttributeValue::where('value', $value)->where('parent_id', $parent)->first();
        if(empty($attrvalue)){
           $attrvalue = new AttributeValue();
			$data = $attrvalue->fill([
				'value'=> $value,
				'parent_id'=>$parent,
			])->save();
			$inserted = true;
        }	

        return $inserted;
		 
		 
	}

	private function SyncAttributes($connection){
		$attributes = $connection->table("oc_t_meta_fields")->get();
		$attr =[];
		foreach ($attributes as $attribute) {
			$attr[] = $this->AttributeSync($attribute);
		}

		return $attr;
	

	}

	private function AttributeSync($attribute){
		$Attribut = [];
		$atr = Attribute::where('slug',$attribute->s_slug)->first();
		if(empty($atr)){
				$attr = new Attribute();
				$data = $attr->fill([
					'name'=>$attribute->s_name,
					'slug'=>$attribute->s_slug,
					'type'=>$attribute->e_type
					])->save();
				$atrvaltotal = $this->AttributeValue($attribute,  $attr->id);
			   $Attribut = ['processed'=>$attribute->s_slug, 'number_of_atrr_values'=>$atrvaltotal]; 
		}else{
				$atr->name = $attribute->s_name;
				$atr->type = $attribute->e_type;
				$atr->save();
			$atrvaltotal =$this->AttributeValue($attribute, $atr->id);
			$Attribut = ['processed'=>$attribute->s_slug, 'number_of_atrr_values'=>$atrvaltotal];
		}

		return $Attribut;
	}

	private function AttributeValue($attribute, $id){
		$inserted = 0;
		$values = explode(",", trim($attribute->s_options, ","));
		foreach($values As $i => $value) {

            if (trim($value) !== "") {
                 	$attrvalue = AttributeValue::where('attribute_id', $id)->where('value', $value)->first();
                 	if(empty($attrvalue)){
                 	 		$attrvalue = new AttributeValue();
							$data = $attrvalue->fill([
								'value'=> $value,
								'attribute_id'=> $id,
							])->save();
							$inserted++;
                 	}	 
 			}
         }

         return $inserted;
		 
		 
	}

	private function SyncCategories($query){
		
		$categories = $query->select("SELECT c.pk_i_id as id, d.s_name as name, d.s_slug as slug, c.fk_i_parent_id as parent_id from oc_t_category c INNER JOIN oc_t_category_description d on d.fk_i_category_id = c.pk_i_id");
		
		$inserted = 0;
		$failed =0;
		$updated = 0;
		$attributeinserted = 0;
		foreach ($categories as $Category) {
			$StoreCategory = Category::where('slug', $Category->slug)->first();
			
			if($StoreCategory){
				$StoreCategory->name = $Category->name;
				$StoreCategory->save();
				 $attributeinserted +=$this->CategoryAttribute($Category->id, $StoreCategory->id);
				$updated++;
			}else{
				
				$parent = null;
				if(!empty($Category->parent_id)){
					$parent = $query->table("oc_t_category_description")->where('fk_i_category_id','=', $Category->parent_id)->first();
				}
				$cate = $this->InsertCategory($Category, $parent);
				$attributeinserted +=$cate->attributeinserted;
				if($cate->inserted){
					$inserted++;
				}else{
					$failed++;
				}
				
			}
			
		}
		return ['inserted'=>$inserted, 'updated'=> $updated, 'failed'=>$failed, 'attributeinserted' => $attributeinserted];
	}

	private function InsertCategory($Category, $parent){
		$Sync = new Category();
		$data = null;
		if($parent != null){
			$StoreCategory = Category::where('slug', $parent->s_slug)->first();
			$data = $Sync->fill([
				'name'=>$Category->name,
				'slug' => $Category->slug,
				'parent_id'=> $StoreCategory->id
			])->save();
		}else{
			$data = $Sync->fill([
				'name'=>$Category->name,
				'slug' => $Category->slug,
			])->save();
			
		}
		$attributeinserted = $this->CategoryAttribute($Category->id, $Sync->id);


		return (object)['inserted'=>$data, 'attributeinserted'=> $attributeinserted];
	
	}

	private function GetAttributes($id){
		$query = DB::connection('mysql_OSCLASS');
		$attributes = $query->select("SELECT m.s_name as attribute_name, m.s_slug as attribute_slug, m.e_type as attribute_type, m.pk_i_id as attribute_id, m.s_options as attribute_option, mc.fk_i_category_id,mc.fk_i_field_id, d.s_name  from oc_t_category c 
		INNER JOIN oc_t_category_description d on d.fk_i_category_id = c.pk_i_id
		INNER JOIN oc_t_meta_categories mc on mc.fk_i_category_id = d.fk_i_category_id
		INNER JOIN oc_t_meta_fields m on m.pk_i_id = mc.fk_i_field_id where c.pk_i_id = $id");
		return $attributes;
	}

	private function CategoryAttribute($id, $StoreCategoryid){
		$inserted = 0;
		$attributes = $this->GetAttributes($id);
		foreach ($attributes as $attribute) {
			$atr = Attribute::where('slug',$attribute->attribute_slug)->first();
			
			if($atr){
				$attrib = AttributeCategory::where('category_id', $StoreCategoryid)->where('attribute_id', $atr->id)->first();
				if(empty($attrib)){
					$attrib = new AttributeCategory();
					$attrib->fill([
						'category_id'=>$StoreCategoryid,
						'attribute_id'=> $atr->id
						])->save();
					$inserted++;
					
				}
			}
			
		}
		return $inserted;
	}

	public function syncProducts(){

		$sync = new ProductSyncHelper();
		$data = $sync->productSync(1729551);
		// // $url         = 'http://192.168.101.218:8081/smsgateway/rest/sms/send';
  // //       $handle = curl_init($url);
  // //       curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
		// // $response = curl_exec($handle);
		// // $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
		// // 
		// $httpCode = LookupHelper::generateInvoiceNum();
		return Response::json($data);

	}

	public function syncItems($data, Request $request){
		$data = (object)json_decode($data);
		$err = $this->validateASync($data);
		

		if($err->fail){
			return Response::json([
				'success'=> false,
				'status_code'=>418, 
				'message'=>$err,
				'data_sent'=>$data,
				]);
		}else{
			$sync = new ProductSyncHelper();
			$data_responds = $sync->productSync($data->item_id);
			return Response::json([
				'success'=> true,
				'status_code'=>200, 
				'message'=>$data_responds,
				'data_sent'=>$data,
				]);
		}
		
	}

	public function ChnageStatusSync($data, Request $request){
		$data = (object)json_decode($data);
		$err = $this->validateASync($data);
		

		if($err->fail){
			return Response::json([
				'success'=> false,
				'status_code'=>418, 
				'message'=>$err,
				]);
		}else{
			$sync = new ProductSyncHelper();
			$data_responds = $sync->productSyncChangeStatus($data->item_id);
			return Response::json([
				'success'=> true,
				'status_code'=>200, 
				'message'=>$data_responds,
				'data_sent'=>$data,
				]);
		}
	}

	public function SyncItemDelete($data, Request $request){
		$data = (object)json_decode($data);
		$err = $this->validateASync($data);
		

		if($err->fail){
			return Response::json([
				'success'=> false,
				'status_code'=>418, 
				'message'=>$err,
				]);
		}else{
			$sync = new ProductSyncHelper();
			$data_responds = $sync->productSyncDelete($data->slug);
			return Response::json([
				'success'=> true,
				'status_code'=>200, 
				'message'=>$data_responds,
				'data_sent'=>$data,
				]);
		}
	}

	private function validateASync($data, $itemid = true){
		$err = (object)[
				'fail'=>false,
				
		];
		if(!array_key_exists('secret', $data)){
			$err->secret= 'is required';
			$err->fail= true;
		}elseif(empty($data->secret)){
			$err->secret= 'is required';
			$err->fail= true;	
		}
		if(!array_key_exists('platform', $data)){
			$err->platform= 'is required';
			$err->fail= true;
		}elseif(empty($data->platform)){
			$err->platform= 'is required';
			$err->fail= true;
		}elseif(str_replace(' ', '', $data->platform) != "OSCLASS"){
			$err->platform = 'Invalid platform';
			$err->fail= true;
		}
		if($itemid){
			if(!array_key_exists('item_id', $data)){
			$err->item_id= 'is required';
			$err->fail= true;
			}elseif(empty($data->item_id)){
				$err->item_id= 'is required';
				$err->fail= true;
			}elseif(!is_numeric($data->item_id)){
				$err->item_id= 'is required';
				$err->fail= true;
			}
		}
		

		return $err;
	}

	public function Stores($data){
		$data = (object)json_decode($data);
		$err = $this->validateASync($data, false);
		if($err->fail){
			return Response::json([
				'success'=> false,
				'status_code'=>418, 
				'message'=>$err,
				]);
		}else{
			$stores = Store::where('store_status_type_id',3)->get();
			$data_store = [];
			$category =[];
			$cat = Category::where('parent_id', null)->get();
			foreach ($cat as $categ) {
				$category[] = (object)[
					'id'=>$categ->id,
					'slug'=>$categ->slug,
					'name'=>$categ->name,
					'sub'=> $categ->child,
				];
			}
			foreach ($stores as $store) {

				if(empty($store->appearance)){
					$logo = 'images/samples/image-holder-thumb.jpg';
				}else{
					$logo = $store->appearance->logo_image;	
				}

				$categories = [];
				$category_string = null;
				foreach ($store->products as $product) {
					$categories[] =(object)[
						'name' => $product->category->name,
						'slug' => $product->category->slug,
						'slug_parent'=>$product->category->ancestor['slug'],
						
					];

					$category_string .= $product->category->name.',';
					
					
				}
				
					$data_store[]= (object)[
						'id'=>$store->id,
						'name'=>$store->name,
						'slug'=>$store->slug,
						'logo'=> $logo,
						'categories'=>$categories,
						'category_string'=>$category_string,
						'orders'=>$store->orders,
						'collection_hours'=> $store->details->collection_hours,
						'street'=>$store->details->street_address_1,
						'city'=>$store->details->city->name,
						'suburb'=>$store->details->suburb->name,
						
					];
				
				
			}
			return Response::json([
				'success'=> true,
				'status_code'=>200, 
				'data'=>$data_store,
				'categories'=>$category,
				]);
		}
	}


}