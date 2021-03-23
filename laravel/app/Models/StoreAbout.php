<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StoreAbout extends BaseModel {

    use SoftDeletes;

    protected $table = 'store_about';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id', 'exerpt', 'description'
    ];

}
