<?php

namespace App\Models\Traits;

/**
 * 
 */
trait SlugTrait {

	function retireSlug() {
		$this->slug = date('Y-m-d') . '::' . $this->slug;
		$this->save();
	}

	function restoreSlug() {
		$this->slug = substr($this->slug, strpos($this->slug, '::') + 2);
		$this->save();
	}

}
