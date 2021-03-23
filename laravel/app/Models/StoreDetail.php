<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StoreDetail extends BaseModel {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $table = "store_details";
    protected $fillable = [
        'store_id', 'street_address_1', 'street_address_2', 'city_id', 'suburb_id', 'country_id', 'email', 'phone', 'collection_hours', 'location_lat', 'location_lng', 'migrated'
    ];

    public function country() {
        return $this->belongsTo('\App\Models\Country');
    }

    public function city() {
        return $this->belongsTo('\App\Models\City');
    }

    public function suburb() {
        return $this->belongsTo('\App\Models\Suburb');
    }
     public function store() {
        return $this->belongsTo('\App\Models\Store');
    }

}
