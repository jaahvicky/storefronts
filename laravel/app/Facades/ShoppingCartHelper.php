<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ShoppingCartHelper extends Facade {
	protected static function getFacadeAccessor() {
		return 'ShoppingCartHelper';
	}
}