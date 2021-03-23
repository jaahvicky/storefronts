<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Models\Permission;
use Schema;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
        
        foreach($this->getPermissions() As $permission) {
            $gate->define($permission->name, function($user) use ($permission) {
                return $user->hasRole($permission->roles);
            });
        }
        //Register policies
    }
    
    protected function getPermissions() {
        
        if (Schema::hasTable('permissions')) {
            return Permission::with('roles')->get();
        }
        else {
            return [];
        }
    }
}
