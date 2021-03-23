<?php

namespace App\Http\Helpers;

use Request;
use Session;

class SortFilterHelper {

	protected $tag;

	function getTag() {
		return $this->tag;
	}

	function setTag($tag) {
		$this->tag = $tag;
	}

	public function getSessionTag($prefix) {
		if (!property_exists($this, 'tableSortFilterTag')) {
			
		}
		return 'tsf-' . $prefix . '-' . $this->tag;
	}

	public function updateFilters($filters = null) {
		Session::forget($this->getSessionTag('filters')); //clear existing filters

		if ($filters === null && !Request::has('filters')) {
			return; //don't do anything if there's no filters to set.
		}

		//set new filters
		if ($filters === null) {
			$filters = Request::get('filters');
		}
		
		Session::put($this->getSessionTag('filters'), $filters);
	}

	public function getFilters($tag = null) {

		if ($tag !== null) {
			$this->setTag($tag);
		}
		if (Session::has($this->getSessionTag('filters'))) {
			return Session::get($this->getSessionTag('filters'));
		} else {
			return [];
		}
	}

	public function isFilterArrayValueSet($name, $value, $tag) {
		$this->setTag($tag);
		
		$filters = $this->getFilters();
		if (key_exists($name, $filters) && in_array($value, $filters[$name])) {
			return true;
		}
		return false;
	}

	public function isFilterTextValue($name, $tag){
		$this->setTag($tag);
		$filters = $this->getFilters();
		if (key_exists($name, $filters) && $filters[$name] != " ") {
			return $filters[$name];
		}else{
			return null;
		}
		
	}

	public function isFilterValueSet($name, $value, $tag) {
		$this->setTag($tag);
		
		$filters = $this->getFilters();
		if (key_exists($name, $filters) && $filters[$name] === $value) {
			return true;
		}
		return false;
	}
	
	public function getFilterValue($key, $tag) {
		$this->setTag($tag);
		
		$filters = $this->getFilters();
		if (key_exists($key, $filters)) {
			return $filters[$key];
		}
		return null;
	}

}
