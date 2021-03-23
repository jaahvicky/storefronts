<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Store;
use Illuminate\Http\Response;

class StoreStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $urlParameters = $request->route()->parameters();
        if (!isset($urlParameters['slug'])) {
            \App::abort(404);
        }
        $slug = $urlParameters['slug'];

        $store = Store::where('slug', '=', $slug)->first();
        if (!$store) {
            \App::abort(404);
        }
        // if ($store->closed()) {
        //     return new Response(view("errors.store_closed"));
        // }


        return $next($request);
    }
}
