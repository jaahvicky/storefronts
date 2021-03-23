<?php

namespace App\Models\osclass;

class City extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_city';
    public $timestamps = false;
    	
    public function region()
    {
        return $this->belongsTo('App\Models\osclass\Region', 'fk_i_region_id');
    }
}