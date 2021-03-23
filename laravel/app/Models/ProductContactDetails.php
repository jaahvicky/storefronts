<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;



class ProductContactDetails extends BaseModel {
	use SoftDeletes;

	protected $table = 'product_contact_details';
	protected $fillable = [
	'product_id',
	'contact_name',
	'phone',
	'city_id',
	'suburb_id',
	];

	public function city(){
		 return $this->belongsTo('App\Models\City', 'city_id');
	}
	public function suburb(){
		 return $this->belongsTo('App\Models\Suburb', 'suburb_id');
	}
}