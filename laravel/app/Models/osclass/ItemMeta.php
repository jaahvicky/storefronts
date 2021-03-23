<?php

namespace App\Models\osclass;

class ItemMeta extends BaseModel
{
    
	protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_meta';

    public $timestamps = false;

    //public $primaryKey = 'pk_i_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['fk_i_item_id', 'fk_i_field_id', 's_value', 's_multi'];

    /**
     * Get the post that owns the comment.
     */
    public function item()
    {
        return $this->belongsTo('App\Models\osclass\Item', 'pk_i_id');
    }
    public function field()
    {
        return $this->belongsTo('App\Models\osclass\MetaFields', 'fk_i_field_id');
    }
}
