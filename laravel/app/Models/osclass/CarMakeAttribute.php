<?php

namespace App\Models\osclass;

class CarMakeAttribute extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_car_make_attr';
    public $timestamps = false;
    public $primaryKey = 'pk_i_id';	
    // public function region()
    // {
    //     return $this->belongsTo('App\Models\osclass\Region', 'fk_i_region_id');
    // }
}