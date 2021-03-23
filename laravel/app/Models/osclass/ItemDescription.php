<?php

namespace App\Models\osclass;

class ItemDescription extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_description';
    public $timestamps = false;
    public $primaryKey = 'fk_i_item_id';
    protected $fillable = [
        'fk_i_item_id',
        'fk_c_locale_code',
        's_title',
        's_description',
        's_attributes'
    ];
    public function item()
    {
        return $this->belongsTo('App\Models\osclass\Item', 'pk_i_id');
    }
}
