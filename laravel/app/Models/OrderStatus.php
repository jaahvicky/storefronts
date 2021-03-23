<?php

namespace App\Models;

use DB;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $table = 'order_status';

    public function listKey(){
    	$order_status = DB::table('order_status')->get();

    	return $order_status;
    }
}
