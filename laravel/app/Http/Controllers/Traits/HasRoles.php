<?php

namespace App\Http\Controllers\Traits;

use App\Models\Role;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

trait HasRoles {
    
    public function roles() {
        return $this->belongsToMany(Role::class);
    }
    
    public function assignRole($role) {
        
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }
    
    public function hasRole($role) {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        
        return !! $role->intersect($this->roles)->count();
    }
    
}