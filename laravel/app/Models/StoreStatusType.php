<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreStatusType extends Model
{
    // protected $fillable = [
    //     'name'
    // ];
    
    public function stores() {
        return $this->hasMany('\App\Models\Store');
    }
}
