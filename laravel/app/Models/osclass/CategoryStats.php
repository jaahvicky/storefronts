<?php

namespace App\Models\osclass;

class CategoryStats extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_category_stats';

    public $primaryKey = 'fk_i_category_id';
    protected $fillable =[
        "fk_i_category_id",
        "i_num_items",
    ];
    public $timestamps = false;

    /**
     * Get the comments for the blog post.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Api\category', 'pk_i_id');
    }

    public function description()
    {
        return $this->belongsTo('App\Models\Api\CategoryDescription', 'fk_i_category_id');
    }
}
