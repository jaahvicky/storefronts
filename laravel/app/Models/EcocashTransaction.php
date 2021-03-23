<?php

namespace App\Models;


class EcocashTransaction extends BaseModel
{
   
    protected $table = 'ecocash_transaction';
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'store_id','msiadn','status','amount','response_data','correlator','paid_on',
    ];

     public function bill() {
        return $this->belongsTo('App\Models\Store', 'store_id');
    }

	
}
