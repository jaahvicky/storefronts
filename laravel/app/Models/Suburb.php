<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suburb extends Model
{
    public function city()
    {
    	$this->belongsTo('App\Models\City');
    }
}
