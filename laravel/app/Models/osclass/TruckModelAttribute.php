<?php

namespace App\Models\osclass;

class TruckModelAttribute extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_truck_model_attr';
    public $timestamps = false;
    public $primaryKey = 'pk_i_id';		
    // public function region()
    // {
    //     return $this->belongsTo('App\Models\osclass\Region', 'fk_i_region_id');
    // }
}