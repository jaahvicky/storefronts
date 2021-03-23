<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class AttributeVariantValue extends BaseModel {

    protected $table = 'attribute_variant_values';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'data'
    ];
    protected $casts = [
        'data' => 'json'
    ];
}
