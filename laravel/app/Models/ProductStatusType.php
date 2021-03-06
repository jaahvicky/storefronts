<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductStatusType extends Model
{
    protected $fillable = [
        'name'
    ];
    
    public function products() {
        return $this->hasMany('\App\Models\Product');
    }
}
