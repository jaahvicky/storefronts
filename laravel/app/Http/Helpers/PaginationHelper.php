<?php

namespace App\Http\Helpers;

use Config;
use Input;

class PaginationHelper {
	
	public function isRppSelected($value) {
		if (!Input::has('rpp') && $value == Config::get('storefronts-backoffice.pagination-default')) {
			//use default
			return true;
		} else if (Input::get('rpp') == $value) {
			return true;
		}
		return false;
	}
}

