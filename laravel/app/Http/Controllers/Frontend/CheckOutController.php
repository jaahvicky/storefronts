<?php

namespace App\Http\Controllers\Frontend;

// use \App\Http\Request;
use App\Models\StoreStatusType;
use Illuminate\Http\Request;
use \App\Models\Category;
use DB;
class CheckOutController extends BaseController
{
   
	public function productCheckout(Request $request){
		
		$inputs = $request->all();
		echo "<pre>";
		print_r($inputs);
		echo "</pre>";
		die();
	}
}
