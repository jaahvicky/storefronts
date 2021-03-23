<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class LookupHelper extends Facade {
	protected static function getFacadeAccessor() {
		return 'lookupHelper';
	}
}