<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StoreEcocash extends BaseModel
{
    use SoftDeletes;
    
    protected $table = 'store_ecocash';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id', 'account_type', 'name', 'number',
    ];

	
}
