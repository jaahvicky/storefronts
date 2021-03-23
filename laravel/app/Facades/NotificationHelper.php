<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class NotificationHelper extends Facade {
	protected static function getFacadeAccessor() {
		return 'NotificationHelper';
	}
}
