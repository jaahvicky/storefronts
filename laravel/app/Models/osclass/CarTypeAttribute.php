<?php

namespace App\Models\osclass;

class CarTypeAttribute extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_car_vehicle_type_attr';
    public $timestamps = false;
    public $primaryKey = 'pk_i_id';		
    // public function region()
    // {
    //     return $this->belongsTo('App\Models\osclass\Region', 'fk_i_region_id');
    // }
}