<?php

namespace App\Http\Controllers\BackOffice;

use App\Models\Category;
use App\Models\Order;

use Auth;

class DashboardController extends BaseController
{
    
	public function index() {
		\ViewHelper::setPageDetails('Storefronts | Dashboard', 'Dashboard', 'this is a small description');
		\ViewHelper::setActiveNav('dashboard');
		
		
		$user = Auth::user();
		$user_id = $user->id;
		
		//Get Order Notifications
		$order = new Order();
		$orders = $order->userOrders($user_id);
		$data['orders'] =$orders;
		$categories = new Category();
		$top_categories = $categories->topCategories($user_id);
		
		$data['top_categories'] = $top_categories;
		return view('backoffice/dashboard/index' , $data);
	}
	
}

