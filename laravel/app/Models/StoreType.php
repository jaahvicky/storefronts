<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Storetype extends BaseModel
{
	use SoftDeletes;
	protected $fillable = [
        'type', 'amount'
    ];
    protected $table = 'store_types';
}