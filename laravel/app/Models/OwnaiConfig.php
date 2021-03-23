<?php

namespace App\Models;


class OwnaiConfig extends BaseModel
{

    
    protected $table = 'ownai_system';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url'
    ];


	
}
