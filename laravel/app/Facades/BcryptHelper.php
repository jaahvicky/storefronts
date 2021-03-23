<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class BcryptHelper extends Facade {
	protected static function getFacadeAccessor() {
		return 'BcryptHelper';
	}
}