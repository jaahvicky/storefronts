<?php

namespace App\Models\osclass;

class CategoryDescription extends BaseModel
{
    
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_category_description';

    public $primaryKey = 'fk_i_category_id';
    protected $fillable =[
        "fk_i_category_id",
        "fk_c_locale_code",
        "s_name",
        "s_slug",
    ];
    public $timestamps = false;

    // /**
    //  * Get the comments for the blog post.
    //  */
    // public function items()
    // {
    //     return $this->hasMany('App\Models\Api\Item', 'pk_i_id');
    // }
}
