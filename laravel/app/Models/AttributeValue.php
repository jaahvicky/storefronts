<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    
    protected $fillable = ['value', 'attribute_id', 'parent_id'];
    
    public function attribute() {
        return $this->hasOne('\App\Models\Attribute');
    }
    public function Attrparent(){
    	return $this->belongsTo('\App\Models\AttributeValue', 'parent_id');
    }
    
    public function products() {
        return $this->belongsToMany('\App\Models\Product');
    }
    
}
