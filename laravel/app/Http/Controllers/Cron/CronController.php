<?php

namespace App\Http\Controllers\Cron;

// use \App\Http\Request;
use App\Models\StoreStatusType;
use Illuminate\Http\Request;
use \App\Models\Category;
use \App\Models\Store;
use \App\Models\Product;
use DB;
use Response;
use App\Facades\CronHelper;
use App\Http\Helpers\ProductSyncHelper;
use App\Models\osclass\Items;
use \App\Models\StoreUser;
class CronController extends BaseController
{
   
	public function index(Request $request){
		$stores = Store::all();
		$stores_non_trail = [];
		$stores_on_trail = [];
		foreach ($stores as $store) {
			$period = CronHelper::checkStoreTrailPeriod($store);
			if($period->status){
				$stores_on_trail[]= (object)['store'=>$store, 'remaining_days'=>$period->remaining_days];
				if($period->remaining_days == 3){ // three days remaining
					CronHelper::Sendmail($store, 0);//CronHelper::STORE_TRAIL_PERIOD_DUE
					
				}
				CronHelper::SendTrailExpire($store);
			}else{
				$stores_non_trail[] = ["store_details"=>$store, "payment_due"=> CronHelper::CheckPaymentDueDate($store)];
				CronHelper::checkStorePayment($store);
				//CronHelper::SendInvoice($store);
			}
		}
		
		return Response::json(['success' => true, 'on_trail'=>$stores_on_trail, 'non_trail'=> $stores_non_trail, 'stores'=>$stores]);
	}

	public function storeSyc(Request $request){
		$cron = $this->restoreProducts();//(array($this, 'restoreProducts'));
		$DateTime = new \DateTime();
		$date1 = $DateTime->format("Y-m-d H:i:s");
		$DateTime->modify('-2 hours');
 		$date = $DateTime->format("Y-m-d H:i:s");
		$storefront_path = public_path().'/uploads';
		$file_name = $storefront_path.'/stores.storefront';
		$data = json_encode(['time_run'=>$date1, 'checked_range'=>$date, 'data'=>$cron]);
		if(!file_exists($file_name)){
		  	$write = fopen($file_name, 'w');
		  	fwrite($write,  $data);
		  	fclose($write);
		}else{
			$write = fopen($file_name, 'a');
		  	fwrite($write,  $data);
		  	fclose($write);
		} 
		return Response::json(['success' => true, 'message'=>"we here son", 'data'=>$cron]);
	}

	private function deleteProducts(callable $callback){
		// $DateTime = new \DateTime();
 	// 	$DateTime->modify('-2 hours');
		// // $DateTime->modify('-2 days');
 	// 	$date = $DateTime->format("Y-m-d H:i:s");
		// $return_data = [];
		// $stores = Store::where('store_status_type_id', '!=', Store::STATUS_TYPE_APPROVED)->where('updated_at','>=', $date)->get();
		// $store_data= [];
		// $count =0;
		// foreach ($stores as $store) {
		// 	foreach ($store->products as $product) {
		// 		if($product->platform =='storefront'){
		// 			$store_data[] = $this->hideProduct($product);
		// 		}else{
		// 			$product->product_status_id = Product::PRODUCT_STATUS_TYPE_DRAFT;
		// 			$product->save();
		// 		}
				
		// 	}
		// 	$count++;
		// }
		
 	// 	if($count == 0){
		// 	$store_data[] = ['no store was updated since'=>$date];
		// }
		// $return_data[]=['deleted_products'=> $store_data ] ;
		$return_data[] = ['restored_products'=> $callback()];
		return $return_data;

	}
	private function restoreProducts(){
		$DateTime = new \DateTime();
 		$DateTime->modify('-2 hours');
		//$DateTime->modify('-2 days');
 		$date = $DateTime->format("Y-m-d H:i:s");
		$stores = Store::where('store_status_type_id', Store::STATUS_TYPE_APPROVED)->get();
		$store_data= [];
		$count =0;
		foreach ($stores as $store) {

			foreach ($store->products as $product) {
				if($product->platform =='storefront'){
					$store_data[] = $this->ActivateProduct($product);
				}
			}
			$count++;
			
		}
		if($count == 0){
			$store_data[] = ['no store was updated since'=>$date];
		}

		return $store_data;
		
	} 
	private function hideProduct(Product $product){
		$return_data = [];
		$product->product_status_id = Product::PRODUCT_STATUS_TYPE_DRAFT;
		$product->product_moderation_type_id = 1;
		$product->save();
		$return_data[] = ['store_front_product_sync' => $product];
		$item =ProductSyncHelper::ItemDelete($product->slug);
		$return_data[] = ['ownai_product_deleted' => $item];
		return $return_data;
	}

	private function ActivateProduct(Product $product){
		$return_data = [];
		$item = Items::where('slug', $product->slug)->first();
		if(!$item){
			$sync = new ProductSyncHelper();
           $data = $sync->itemOsclassSync($product->id);
		}else{
			 $data = ['message'=>'already exist', 'status'=>false];
		}
		
		
		$return_data[] = ['ownai_product_sync' => $data];
		return $return_data;
	}
}
