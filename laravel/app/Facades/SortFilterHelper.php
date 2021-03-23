<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class SortFilterHelper extends Facade {
	protected static function getFacadeAccessor() {
		return 'sortfilterHelper';
	}
}