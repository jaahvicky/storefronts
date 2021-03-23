<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Store;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseLaravelController;

class BaseController extends BaseLaravelController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
	
	/**
	 * Fetches a store based on a slug.
	 * 
	 * Only returns a store if it is active.
	 * 
	 * @param string $slug
	 * @return App\Models\Store $store
	 */
	protected function getStoreBySlug($slug) {
		$store = Store::where('slug', '=', $slug)

				// ->where('store_status_type_id', '=', Store::STATUS_TYPE_APPROVED) //removed as different store status will show different error messages
				->first();
		
		return $store;
	}
}

