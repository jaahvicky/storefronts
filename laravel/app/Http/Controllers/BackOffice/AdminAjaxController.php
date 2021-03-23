<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Traits\TableSortingAndFilteringTrait;
use Response;
use SortFilterHelper;
use Request;
use App\Models\Category;
use Auth;
use App\Models\User;

class AdminAjaxController extends BaseController {

	use TableSortingAndFilteringTrait;
	
	public function filtersQueue($tag) {
		SortFilterHelper::setTag($tag);
		SortFilterHelper::updateFilters();
		return Response::json(['success' => true]);
	}


	public function MainCatData(Request $request){
		$catname = Request::get('category_name');
		$category = Category::where('slug', $catname)->first();
		
		if($category){
			$categories = [];
            $children = Category::where('parent_id', $category->id)->orWhere('parent_id', $category->parent_id)->get();
           
            if($category->parent_id != NULL){
            	$parent = Category::where('id', $category->parent_id)->first();
            	$categories[]= ['name' => $parent->name, 'id'=>$parent->id, 'slug'=>$parent->slug];
            }else{
            	$categories[]= ['name' => $category->name, 'id'=>$category->id, 'slug'=>$category->slug];
            }
            
            foreach ($children as $key => $value) {
            	$categories[] = ['name' => $value->name, 'id'=>$value->id, 'slug'=>$value->slug];
            }
			return Response::json(['success' => true, 'category'=> $categories, 'children'=>$children, 'categorym'=>$category]);
		}else{
			return Response::json(['success' => false, 'data'=>$category]);
		}
		
	}

	public function Sessionget(Request $request){
		$session_name = Request::get('ses_name');
		
		$data = SortFilterHelper::getFilters('products');

		if(array_key_exists($session_name, $data) && array_key_exists(0, $data[$session_name])){
			
			return Response::json(['success' => true, 'session'=> $data[$session_name][0] ]);
		}else{
			if($session_name == 'orderbyname'){
				return Response::json(['success' => true, 'session'=> 'prod_mod_status,asc']);
			}else{
				return Response::json(['success' => false, 'data'=> $data]);
			}
			
		}	
	}
    public function SessiongetOrder(Request $request){
		
		$session_name = Request::get('ses_name');

		$data = SortFilterHelper::getFilters('orders');
		
		if(array_key_exists($session_name, $data) && array_key_exists(0, $data[$session_name])){	
			return Response::json(['success' => true, 'session'=> $data[$session_name][0]]);
		}else{
			return Response::json(['success' => false, 'data'=> $data]);
		}	
	}
	public function lastActivity(){
		$user = Auth::user();
		$this->user_id = $user->id;
		$update_activity  = User::where('id', $this->user_id)->first();
    	$update_activity->last_activity = DB::raw('CURRENT_TIMESTAMP');
    	$update_activity->save();
		
		$data = ['update_activity' => $update_activity];


		return Response::json(['success' => true, 'data'=> $data]);
	}

}
