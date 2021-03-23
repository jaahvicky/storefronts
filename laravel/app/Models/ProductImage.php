<?php

namespace App\Models;


class ProductImage extends BaseModel {

   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename', 'original_upload', 'effects', 'featured', 'product_id'
    ];

}
