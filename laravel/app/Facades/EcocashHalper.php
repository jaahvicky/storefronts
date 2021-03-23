<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class EcocashHelper extends Facade {
	protected static function getFacadeAccessor() {
		return 'EcocashHelper';
	}
}