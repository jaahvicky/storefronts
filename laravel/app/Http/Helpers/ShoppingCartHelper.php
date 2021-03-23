<?php

namespace App\Http\Helpers;

use Request;
use Session;

class ShoppingCartHelper {

	protected $tag;

	function getTag() {
		return $this->tag;
	}

	function setTag($tag) {
		$this->tag = $tag;
	}

	public function getSessionTag($prefix) {
		// if (!property_exists($this, 'tableSortFilterTag')) {
			
		// }
		return 'tsf-' . $prefix . '-' . $this->tag;
	}

	public function updateCartSession($filters) {
		Session::forget($this->getSessionTag('productcart')); //clear existing filters
		Session::put($this->getSessionTag('productcart'), $filters);
	}

	public function getShoppingCart($tag = null) {

		if ($tag !== null) {
			$this->setTag($tag);
		}
		if (Session::has($this->getSessionTag('productcart'))) {
			return Session::get($this->getSessionTag('productcart'));
		} else {
			return [];
		}
	}
	public function forgetShoppingCart($tag) {
		$this->tag = $tag;
		Session::forget($this->getSessionTag('productcart')); //clear existing filters
	}

	public function isCartArrayValueSet($name, $value, $tag) {
		$this->setTag($tag);
		
		$product = $this->getShoppingCart();
		if (key_exists($name, $product) && in_array($value, $product[$name])) {
			return true;
		}
		return false;
	}

	public function isCartValueSet($name, $value, $tag) {
		$this->setTag($tag);
		
		$product = $this->getShoppingCart();
		if (key_exists($name, $product) && $product[$name] === $value) {
			return true;
		}
		return false;
	}
	
	public function getCartValue($key, $tag) {
		$this->setTag($tag);
		
		$product = $this->getShoppingCart();
		if (key_exists($key, $product)) {
			return $product[$key];
		}
		return null;
	}

}
