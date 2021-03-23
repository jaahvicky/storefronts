<?php

namespace App\Models\osclass;

class ItemStats extends BaseModel
{
    protected $connection = 'mysql_OSCLASS';
    protected $table = 'oc_t_item_stats';

    public $primaryKey = 'fk_i_item_id';
    public $timestamps = false;
    protected $fillable = [
        'fk_i_item_id',
        'i_num_views',
        'i_num_spam',
        'dt_date',
        'i_num_repeated', 
        'i_num_bad_classified', 
        'i_num_offensive',
        'i_num_premium_views',
        'i_num_expired',
    ];  


    /**
     * Get the user that owns the phone.
     */
    public function item()
    {
        return $this->belongsTo('App\Models\osclass\Item', 'pk_i_id');
    }

    
}
