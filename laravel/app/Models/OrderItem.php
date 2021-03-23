<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends Model
{
    
    
     protected $fillable = [
        'qty', 'data', 'orders_id',  'product_id',
    ];
    public function order() {
    	return $this->belongsTo('App\Models\Order');
    }

    public function product() {
    	return $this->belongsTo('App\Models\Product', 'products_id');
    }

    

}
