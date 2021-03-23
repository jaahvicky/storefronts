<?php

namespace App\Models\osclass;

class Region extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_region';
    public $timestamps = false;

    public function city()
    {
        return $this->hasMany('App\Models\osclass\City', 'pk_i_id');
    }
}
