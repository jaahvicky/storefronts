<?php

namespace App\Models\osclass;

class CarItemAttribute extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_car_attr';
    public $timestamps = false;
    public $primaryKey = 'fk_i_item_id';
    protected $fillable = [
        'fk_i_item_id',
        'fk_i_make_id',
        'fk_i_model_id',
        'fk_vehicle_type_id',
        
    ];	
    public function make()
    {
        return $this->belongsTo('App\Models\osclass\CarMakeAttribute', 'fk_i_make_id');
    }
    public function model()
    {
        return $this->belongsTo('App\Models\osclass\CarModelAttribute', 'fk_i_model_id');
    }
}