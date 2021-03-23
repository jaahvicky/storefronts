<?php

namespace App\Models\osclass;

class ItemResource extends BaseModel
{
    
	protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_resource';

    public $timestamps = false;

    public $primaryKey = 'pk_i_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['fk_i_item_id', 's_name', 's_extension', 's_content_type', 's_path'];

    /**
     * Get the post that owns the comment.
     */
    public function item()
    {
        return $this->belongsTo('App\Models\osclass\Item', 'pk_i_id');
    }
}
