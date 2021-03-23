<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StoreContactDetail extends BaseModel {

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'store_contact_details';
    protected $fillable = [
        'firstname', 'lastname', 'street_address_1', 'street_address_2', 'city', 'suburb', 'country_id', 'email', 'phone',
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
}
