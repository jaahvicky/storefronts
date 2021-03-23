<?php

namespace App\Models\osclass;

class TruckItemAttribute extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_truck_attr';
    public $timestamps = false;
    public $primaryKey = 'fk_i_item_id'; 
    protected $fillable = [
        'fk_i_item_id',
        'fk_i_make_id',
        'fk_i_model_id',
        'fk_vehicle_type_id'
        
    ];	
    public function make()
    {
        return $this->belongsTo('App\Models\osclass\TruckMakeAttribute', 'fk_i_make_id');
    }
    public function model()
    {
        return $this->belongsTo('App\Models\osclass\TruckModelAttribute', 'fk_i_model_id');
    }
}