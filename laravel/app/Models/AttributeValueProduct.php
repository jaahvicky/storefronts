<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValueProduct extends Model
{
     protected $table = 'attribute_value_product';
    protected $fillable = [
        'attribute_value_id', 'product_id', 'value'
    ]; 
    
    public function attributedetails(){
    	return $this->belongsTo('\App\Models\Attribute', 'attribute_value_id');
    }
    
}
