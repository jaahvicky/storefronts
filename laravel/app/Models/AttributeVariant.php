<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeVariant extends BaseModel {

    protected $table = 'attribute_variant';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'store_id'

    ];

    public function ancestor() {
		return $this->belongsTo('\App\Models\Store', 'store_id');
	}
}
