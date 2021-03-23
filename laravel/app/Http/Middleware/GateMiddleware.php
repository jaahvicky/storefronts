<?php

namespace App\Http\Middleware;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Http\Request;
use Closure;
use Gate;

class GateMiddleware {

    public function handle(Request $request, Closure $next, $permission) {
        
        $user = $request->user();    
        $denies = Gate::denies($permission, $user);

        if ($denies) {
            if ($permission == "admin.stores" && Gate::allows("admin.account", $user)) {          
                return redirect()->route("admin.dashboard");
            }
            if($permission == "admin.stores" && Gate::allows("admin.moderator.products", $user)) {
                return redirect()->route('admin.moderator');
            }
            
            abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }

}