<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

use App\Models\Order as Order;

class StoreUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $order_id = (int)$request->route('orderid');
        
        $order = Order::find($order_id);

        // if order does not exist
        if(!count($order)) {
            return redirect()->route('orders.index');
        }

         // if order does not belong to current user's store, redirect to orders
        $is_store_user = Auth::user()->stores()->where('stores.id', '=', $order->store_id)->first();
        if(!$is_store_user) {
            return redirect()->route('orders.index');
        }

        return $next($request);
    }
}
