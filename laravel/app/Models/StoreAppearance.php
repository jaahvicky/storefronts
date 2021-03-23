<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreAppearance extends Model
{
    protected $table = 'store_appearance';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id', 'logo_image', 'banner_image', 'primary_colour', 'secondary_colour'
    ];
}
