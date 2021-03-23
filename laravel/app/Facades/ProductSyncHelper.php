<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ProductSyncHelper extends Facade {
	protected static function getFacadeAccessor() {
		return 'ProductSyncHelper';
	}
}