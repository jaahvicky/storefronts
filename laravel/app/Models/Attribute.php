<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute  extends Model
{
    
    protected $fillable = ['name','slug','type'];   
    public function categories() {
        return $this->belongsToMany(Category::class);
    }
    
    public function attributeValues() {
        return $this->belongsToMany(AttributeValue::class);
    }
    
}
