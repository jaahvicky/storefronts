<?php

namespace App\Models;


class EcocashConfig extends BaseModel
{

    
    protected $table = 'ecocash_config';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ecocash_endpoint','ecocash_endpoint_query','ecocash_endpoint_query_user','ecocash_channel','ecocash_merchant_code','ecocash_merchant_pin','ecocash_merchant_number','ecocash_username','ecocash_password'
    ];


	
}
