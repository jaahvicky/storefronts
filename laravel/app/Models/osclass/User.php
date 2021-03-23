<?php

namespace App\Models\osclass;
class User extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_user';

    public $primaryKey = 'pk_i_id';
    public $timestamps = false;
    /**
     * Get the comments for the blog post.
     */
    public function items()
    {
        return $this->hasMany('App\Models\osclass\Item', 'pk_i_id');
    }
}
