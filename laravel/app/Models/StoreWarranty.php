<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StoreWarranty extends BaseModel {

    use SoftDeletes;

    protected $table = 'store_warranty';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id', 'warranty'
    ];

}
