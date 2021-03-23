<?php

namespace App\Models\osclass;
class Category extends BaseModel
{
    
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_category';

    public $primaryKey = 'pk_i_id';
    protected $fillable =[
        "fk_i_parent_id",
        "i_expiration_days",
        "i_position",
        "b_enabled",
        "b_price_enabled",
    ];
    public $timestamps = false;

    /**
     * Get the comments for the blog post.
     */
    public function items()
    {
        return $this->hasMany('App\Models\osclass\Item', 'pk_i_id');
    }

    public function description()
    {
        return $this->belongsTo('App\Models\osclass\CategoryDescription', 'pk_i_id');
    }
     public function stats()
    {
        return $this->belongsTo('App\Models\osclass\CategoryStats', 'pk_i_id');
    }
     public function parent()
    {
        return $this->belongsTo('App\Models\osclass\Category', 'fk_i_parent_id');
    }
}
