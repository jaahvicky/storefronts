<?php

namespace App\Models\osclass;
class items extends BaseModel {

	protected $connection = 'mysql_OSCLASS';
	protected $table = 'oc_t_item';
	public $primaryKey = 'pk_i_id';
	public $timestamps = false;
	protected $fillable = ['fk_i_user_id', 'fk_moderator_id', 'fk_moderator_action', 'fk_i_category_id', 'f_price', 'i_price','fk_c_currency_code', 'slug','platform','s_contact_name','s_contact_additional','s_contact_email','s_ip','b_premium','b_enabled'
    	,'b_active','b_spam','s_secret','b_show_email','dt_creat_date','dt_pub_date','dt_expiration','b_urgent','b_hpgallery','promote_top_expiry','promote_top_start','
    	promote_highlighted_expiry','promote_urgent_expiry','promote_homepage_expiry','i_reposts','dt_pub_date_ordered'
	];

	/**
     * Get the user that owns the item.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\osclass\User', 'fk_i_user_id');
    }

    /**
     * Get the category that the item is in.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\osclass\Category', 'fk_i_category_id');
    }

    /**
     * Get the details of the category.
     */
    public function category_description()
    {
        return $this->belongsTo('App\Models\osclass\CategoryDescription', 'fk_i_category_id');
    }

    /**
     * Get the item meta data.
     */
    public function item_meta()
    {
        return $this->hasMany('App\Models\osclass\ItemMeta', 'fk_i_item_id');
    }

    /**
     * Get the item resoureces / images.
     */
    public function item_resource()
    {
        return $this->hasMany('App\Models\osclass\ItemResource', 'fk_i_item_id');
    }

    /**
     * Get the item description.
     */
    public function item_desc()
    {
        return $this->hasOne('App\Models\osclass\ItemDescription', 'fk_i_item_id');
    }

    /**
     * Get the item stats.
     */
    public function item_stats()
    {
        return $this->hasOne('App\Models\osclass\ItemStats', 'fk_i_item_id');
    }
    public function item_location()
    {
        return $this->hasOne('App\Models\osclass\ItemLocation', 'fk_i_item_id');
    }

    public function car_attribute()
    {
        return $this->belongsTo('App\Models\osclass\CarItemAttribute', 'pk_i_id');
    }
    public function bike_attribute()
    {
        return $this->belongsTo('App\Models\osclass\BikeItemAttribute', 'fk_i_item_id');
    }
    public function truck_attribute()
    {
        return $this->belongsTo('App\Models\osclass\TruckItemAttribute', 'fk_i_item_id');
    }


}
