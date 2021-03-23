<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class CronHelper extends Facade {
	protected static function getFacadeAccessor() {
		return 'CronHelper';
	}
}
