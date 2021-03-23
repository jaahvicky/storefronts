<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable As AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable As AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword As CanResetPasswordContract;
use App\Http\Controllers\Traits\HasRoles;

use App\Models\Store;

class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    
    use Authenticatable, Authorizable, CanResetPassword, HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function stores() {
        return $this->belongsToMany(Store::class);
    }
    
    public function addStore(Store $store) {
        return $this->stores()->save($store);
    }
    
}
