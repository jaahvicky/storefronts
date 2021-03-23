<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriesCustom extends BaseModel {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['store_id','name', 'slug', 'parent_id'];

	public function ancestor() {
		return $this->belongsTo('\App\Models\Category', 'parent_id');
	}
        

}

?>
