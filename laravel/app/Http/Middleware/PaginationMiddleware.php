<?php

namespace App\Http\Middleware;

use Closure;
use Config;
use Illuminate\Http\Request;
use View;

class PaginationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        View::share('paginationDropdownOptions', Config::get('storefronts-backoffice.pagination-recordsperpage-options'));
		
        return $next($request);
    }
}
