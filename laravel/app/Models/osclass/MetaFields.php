<?php

namespace App\Models\osclass;

class MetaFields extends BaseModel
{
    
	protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_meta_fields';

    public $timestamps = false;

    public $primaryKey = 'pk_i_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = ['s_name', 's_slug', 'e_type', 's_filter_type', 's_options', 'b_required', 'b_searchable', 'b_indexable'];

}
