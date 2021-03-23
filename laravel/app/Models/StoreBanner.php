<?php

namespace App\Models;

class StoreBanner extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id', 'filename', 'order'
    ];

	
}
