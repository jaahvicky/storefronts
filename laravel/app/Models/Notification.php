<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB;
use Auth;

class Notification extends Model
{
    
	// public function __construct()
 //    {
 //    	$user = Auth::user();
	// 	$this->user_id = $user->id;
	// 	$this->last_activity = $user->last_activity;
 //    }

 //    // Get New Orders, Approved products, Rejected Products
 //    public function userNotifications(){

    	
	// 	//Get Order Notifications

 //        $store = DB::table('store_user')
 //                            ->where('user_id', "=", $this->user_id)
 //                            ->select('store_id')
 //                            ->first();

 //        $store_id = $store->store_id;

 //        $recent_orders = DB::table('order_items')
 //                            ->join('orders', 'order_items.orders_id', '=', 'orders.id')
 //                            ->join('products', 'order_items.products_id', '=', 'products.id')
 //                            //->select('order_items.id AS order_id', 'orders.order_status_id AS status')
 //                            ->where([
 //                                ['products.store_id', "=", $store_id],
 //                                ['orders.created_at', '>', $this->last_activity],
 //                            ])
 //                            ->groupBy('orders.id')
 //                            ->get();
                            
 //        $order_num = sizeof($recent_orders);

 //        // Approved Products
 //        $approved_products = DB::table('products')
 //                            ->where([
 //                                        ['store_id', "=", $store_id],
 //                                        ['product_moderation_type_id', "=", 2],
 //                                        ['updated_at', '>', $this->last_activity],
 //                                    ])
 //                            ->count();

 //        // Rejected Products
 //        $rejected_products = DB::table('products')
 //                            ->where([
 //                                        ['store_id', "=", $store_id],
 //                                        ['product_moderation_type_id', "=", 3],
 //                                        ['updated_at', '>', $this->last_activity],
 //                                    ])
 //                            ->count();

 //        $total = intval($recent_orders) + intval($approved_products) + intval($rejected_products);


 //        $notifications = [
 //            'new_orders' => $order_num,
 //            'approved_products' => $approved_products,
 //            'rejected_products' => $rejected_products,
 //            'total' => $total,
 //            'last_activity' => $this->last_activity,

 //        ];
        
 //        return $notifications;
 //    }

 //    public function updateUser(){

 //    	$update = DB::table('users')
 //            ->where('id', $this->user_id)
 //            ->update(['last_activity' => DB::raw('CURRENT_TIMESTAMP')]);
 //    	return $update;
 //    }
}
