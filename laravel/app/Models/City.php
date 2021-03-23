<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

	const CITY_HARARE = 11;
	
    public function suburbs()
    {
    	return $this->hasMany('App\Models\Suburb');
    }
}
