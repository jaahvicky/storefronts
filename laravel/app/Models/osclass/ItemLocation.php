<?php

namespace App\Models\osclass;

class ItemLocation extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_location';
    public $timestamps = false;
    public $primaryKey = 'fk_i_item_id';
    

    protected $fillable = [
        'fk_i_item_id',
        'fk_c_country_code',
        's_country',
        's_address',
        's_zip',
        'fk_i_region_id',
        's_region',
        'fk_i_city_id',
        's_city',
        'fk_i_city_area_id',
        's_city_area',
        'd_coord_lat',
        'd_coord_long'
    ];
    public function item()
    {
        return $this->belongsTo('App\Models\osclass\Item', 'pk_i_id');
    }
}
