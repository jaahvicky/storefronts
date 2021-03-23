<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends BaseModel
{
	
    const STATUS_TYPE_PENDING_OPEN = 1;
    const STATUS_TYPE_PENDING_REOPEN = 2;
    const STATUS_TYPE_APPROVED = 3;
    const STATUS_TYPE_REJECTED = 4;
    const STATUS_TYPE_CLOSED = 5;
    
    const ECONET_LOGISTICS = 1;
    const DELIVERY_ARRANGE_WITH_SELLER  = 2;
    const DELIVERY_COLLECT_IN_STORE     = 3;

    const STORE_TYPE_VEHICLES           = 1;
    const STORE_TYPE_PROPERTY           = 2;
    public static $store_status_types = ['Pending', 'Approved', 'Rejected', 'Closed'];

	use SoftDeletes;
	use Traits\SlugTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'store_type_id',  'logo', 'store_status_type_id',
    ];

    public function banner() {
        return $this->hasOne('\App\Models\StoreBanner')->orderBy('order', 'ASC');
    }

    public function banners() {
        return $this->hasMany('\App\Models\StoreBanner');
    }


    public function contactDetails() {
        return $this->hasOne('\App\Models\StoreContactDetail'); 
    }

    public function details() {
        return $this->hasOne('\App\Models\StoreDetail');
    }

    public function ecocash() {
        return $this->hasOne('\App\Models\StoreEcocash');
    }

    public function status() {
        return $this->belongsTo('App\Models\StoreStatusType', 'store_status_type_id');
    }
     public function type() {
        return $this->belongsTo('App\Models\StoreType','store_type_id');
    }


    public function billing() {
        return $this->hasOne('\App\Models\EcocashTransaction')->whereMonth('ecocash_transaction.paid_on', '=', date('m'))->whereYear('ecocash_transaction.paid_on', '=', date('Y'))->orderBy('id', 'DESC');
    }
    
    public function preferences() {
        return $this->hasOne('\App\Models\StorePreference');
    }
    
    public function appearance() {
        return $this->hasOne('\App\Models\StoreAppearance');
    }
    
    public function about() {
        return $this->hasOne('\App\Models\StoreAbout');
    }
    
    public function warranty() {
        return $this->hasOne('\App\Models\StoreWarranty');
    }

    public function deliveryMethods() {
        return $this->belongsTo('App\Models\StoreDeliveryMethod', 'store_delivery_method_id');
    }
    
    public function user() {
        return $this->belongsToMany('\App\Models\User');
    }
    public function products() {
        return $this->hasMany('\App\Models\Product');
    }
    public function orders() {
        return $this->hasMany('\App\Models\Order');
    }
    public function user_single() {
        return $this->belongsTo('\App\Models\StoreUser','store_id');
    }

    public function closed() {

        $closed = StoreStatusType::where("tag", "closed")->first();
        if ($this->store_status_type_id+0 === $closed->id) {

            return true;
        }
        return false;
    }
}

Store::deleting(function($model) {
    $model->retireSlug();
});

Store::restored(function($model) {
	$model->restoreSlug();
});
