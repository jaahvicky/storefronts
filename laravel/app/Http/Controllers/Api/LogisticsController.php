<?php

namespace App\Http\Controllers\Api;

use View;
use DB;
use Validator;
use Illuminate\Http\Request;
use Response;
use App\Models\Logistics;
use App\Models\Order;
use App\Models\DeliveryStatus;
class LogisticsController extends BaseController {

	public function orders(Request $request){
		$like ="{";
		$data =[];
		$orders = Order::where('response_data', 'like', '%'.$like.'%')->get();
		foreach ($orders as $order) {
			$response_data = json_decode($order->response_data);
			if(array_key_exists('bookingreference', $response_data) && array_key_exists('bookingdata', $response_data)){
				$data[]=(object)[
					'id'=>$order->id,
					'invoice_number'=>$order->invoice_number,
					'store_name'=>$order->store->name,
					'delivery_status_id'=>$order->delivery_status_id,
					'delivery_status'=>$order->DeliveryStatus->status,
					"buyer_firstname"=>$order->buyer_firstname,
					"buyer_lastname"=>$order->buyer_lastname,
					"buyer_address"=>$order->buyer_address,
					"buyer_email"=>$order->buyer_email,
					"buyer_phone"=>$order->buyer_phone,
					'bookingreference'=>(int)$response_data->bookingreference,
					'bookingdata'=>$response_data->bookingdata

				];
			}else{
				$data[]=(object)[
					'id'=>$order->id,
					'invoice_number'=>$order->invoice_number,
					'store_name'=>$order->store->name,
					'delivery_status_id'=>$order->delivery_status_id,
					'delivery_status'=>$order->DeliveryStatus->status,
					"buyer_firstname"=>$order->buyer_firstname,
					"buyer_lastname"=>$order->buyer_lastname,
					"buyer_address"=>$order->buyer_address,
					"buyer_email"=>$order->buyer_email,
					"buyer_phone"=>$order->buyer_phone,

				];
			}
			
		}
		if(empty($data)){
			return Response::json([
				'success' =>false,
				'message'=>'there are no orders available now, please try again later'
				]);
		}else{
			return Response::json([
				'success' =>true,
				'order_data'=>$data
				]);
		}
		
	}

	public function deliveryStatus(Request $request){
			return Response::json([
				'success'=>true,
				'delivery_status_data'=>DeliveryStatus::all()
			]);
	}
	public function orderUpdate(Request $request){
		$rules = [
			'id' => 'required|order.valid',
			'delivery_status_id' => 'required|deliverystatus.valid',
			
		];
		$validation = Validator::make($request->all(), $rules);
		if ($validation->fails()) {
			return Response::json([
				'success' =>false,
				'message'=>$validation->messages()->toArray()
				]);
		}else{
			$order =Order::where('id', $request->id)->first();
			$order->delivery_status_id = $request->delivery_status_id;
			$order->save();

			return Response::json([
				'success'=>true,
				'message'=>'Order has been updated'
			]);
		}
	}
	public function getQuote(Request $request){

		$rules = [
			'pAddr' => 'required',
			'dAddr' => 'required',
			'vehicle'=> 'required',
			'multidrop'=> 'required',
		];

		$validation = Validator::make($request->all(), $rules);

		//Validate passed info
		if ($validation->fails()) {
			return Response::json([
				'success' =>false,
				'message'=>$validation->messages()->toArray()
				]);
		}else{
			$logistic = Logistics::where('method', 'getQuote')->first();
			if($logistic){
				$data=[
				'token'=>$logistic->token,
				'pAddr' => $request->pAddr,
				'dAddr' => $request->dAddr,
				'vehicle'=> $request->vehicle,
				'multidrop'=> $request->multidrop
			
				];
				$results = $this->http($logistic->url, $data);
				$results = json_decode($results);
				if(array_key_exists('status', $results) && $results->status > 0 ){
					return Response::json([
					'success' =>true,
					'data'=> $results,
					
					]);

				}else{
					return Response::json([
					'success' =>false,
					'message'=>$results,
					
					]);
				}
				
			}else{
				return Response::json([
				'success' =>false,
				'message'=>"invalid logistics configurations",
				'data'=>$logistic
				]);
			}
			
		}
	}

	private function http($url, $data){
		$data = http_build_query($data);
		$options = [
			'http'=>[
			'header'=>"Content-type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: " . strlen($data) . "\r\n",//'Content-type: application/x-www-form-urlencoded\r\n',
			'method'=>'POST',
			'content'=>$data,
			],
		];
		$content =stream_context_create($options);
		$results = file_get_contents($url, false, $content);
		
		return $results;	
	}

	public function bookService(Request $request){

		$rules = [
			'pAddr' => 'required',
			'dAddr' => 'required',
			'vehicle'=> 'required',
			'multidrop'=> 'required',
			'pPerson'=> 'required',
			'pNumber'=> 'required',
			'pInstruction'=> 'required',
			'dPerson'=> 'required',
			'dNumber'=> 'required',
			'dInstruction'=> 'required',
			'itemDesc'=> 'required',
			'itemValue'=>'required',
		];

		$validation = Validator::make($request->all(), $rules);

		//Validate passed info
		if ($validation->fails()) {
			return Response::json([
				'success' =>false,
				'message'=>$validation->messages()->toArray()
				]);
		}else{
			$logistic = Logistics::where('method', 'bookservice')->first();
			if($logistic){
				$data=[
				'token'=>$logistic->token,
				'pAddr' => $request->pAddr,
				'dAddr' => $request->dAddr,
				'vehicle'=> $request->vehicle,
				'multidrop'=> $request->multidrop,
				'pPerson'=> $request->pPerson,
				'pNumber'=> $request->pNumber,
				'pInstruction'=> $request->pInstruction,
				'dPerson'=> $request->dPerson,
				'dNumber'=> $request->dNumber,
				'dInstruction'=> $request->dInstruction,
				'itemDesc'=> $request->itemDesc,
				'itemValue'=>$request->itemValue,
				'jobType'=>'Storefronts',
				'order_id'=>235984678,
				'addressMode'=>'address',
			
				];
				$results = $this->http($logistic->url, $data);
				
				$results = json_decode($results);
				if(array_key_exists('status', $results) && $results->status > 0 ){
					return Response::json([
					'success' =>true,
					'data'=> $results,
					
					]);

				}else{
					return Response::json([
					'success' =>false,
					'message'=>$results,
					
					]);
				}

			}else{
				return Response::json([
							'success' =>false,
							'message'=>"invalid logistics configurations",
							'data'=>$logistic
							]);
			}
		}
	}

}