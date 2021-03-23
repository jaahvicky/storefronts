<?php

namespace App\Models;


class Logistics extends BaseModel
{

    
    protected $table = 'logistics';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'token', 'method'
    ];


	
}