<?php

namespace App\Models\osclass;

class ItemComments extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_comment';

    public $primaryKey = 'pk_i_id';
    public $timestamps = false;
    protected $fillable = [
        'fk_i_item_id',
        'dt_pub_date',
        's_title',
        'dt_date',
        's_author_name', 
        's_author_email', 
        's_body',
        'b_enabled',
        'b_active',
        'b_spam',
        'fk_i_user_id'
    ];  


    /**
     * Get the user that owns the phone.
     */
    public function item()
    {
        return $this->belongsTo('App\Models\osclass\Item', 'pk_i_id');
    }

    
}
