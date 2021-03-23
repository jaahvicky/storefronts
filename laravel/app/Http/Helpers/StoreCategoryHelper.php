<?php

namespace App\Http\Helpers;
use DB;

use Debugbar;
class StoreCategoryHelper {

	/**
	 * Fetches all categories for a store
	 * @param type $withChildCounts
	 */
	public function getStoreCategories($storeId, $withChildCounts = false) {


		//tier 3 (getting categories for the products)

		// GET ALL THE SECOND TIER CATEGORIES WHERE THE STORE HAS PRODUCTS 153/201
		// (ASSUMING THAT THE PRODUCT CATEGORY ID WILL ALWAYS BE SECOND TIER)
		$catstore = DB::table('categories as c1')
					    ->join('products', 'products.category_id', '=', 'c1.id')
					    ->select('products.store_id as products_store_id', 'products.category_id as products_category_id','c1.*')
					    ->where('products.store_id', '=', $storeId)
					    ->whereNull('products.deleted_at')
					    ->groupBy('c1.parent_id')
					    ->orderBy('c1.parent_id', 'ASC')
						->orderBy('c1.order', 'ASC')
						->get();
		
		$categories = [];

		foreach ($catstore as $catstor) {

			$t3cats = DB::table('products')->where('products.store_id', '=', $storeId)
							->select('categories_customs.*','products.id as product_id',
								\DB::raw('COUNT(products.id) as numProducts'))
							->join('categories_customs', 'categories_customs.id', '=', 'products.category_custom_id')
							->where('products.category_id', '=', $catstor->id)
							->whereNotNull('products.category_custom_id')
							->groupBy('categories_customs.id')
							->get();
							

			$t1cat = \App\Models\Category::select('categories.*')
					->where('categories.id', '=',  $catstor->parent_id)
					->get();
			
			if($t1cat->count() == 0){
				$categories[] = (object)[
					"id" 		  => $catstor->id,
					"store_id"    => $catstor->products_store_id,
					"name" 		  =>$catstor->name,
					"slug"        => $catstor->slug,
					"parent_id"   => $catstor->id,
					"order" 	  => $catstor->order,
					"created_at"  => $catstor->created_at,
					"updated_at"  =>$catstor->updated_at,
					"numProducts" => '',
					"children" => (object)$this->get_t2_without_parent($catstor->id, $storeId)
				];
			}
			
			// getting all t2 categories
			foreach ($t1cat as $t1cats) {
				
				if ($t3cats) {

					// PASS THE TIER 3 CATEGORY OBJECT
					$categories[] = (object)$this->get_t2_tree_with_t3($t3cats);

				}

				// if (!empty($t1cats->parent_id)) {
				// 	$categories[] = (object)$this->get_t2_tree_with_t3($catstor);
				// }

				else
				{
					$categories[] = (object)[
						"id" 		  => $t1cats->id,
						"store_id"    => $t1cats->store_id,
						"name" 		  =>$t1cats->name,
						"slug"        => $t1cats->slug,
						"parent_id"   => $t1cats->parent_id,
						"order" 	  => $t1cats->order,
						"deleted_at"  => $t1cats->deleted_at,
						"created_at"  => $t1cats->created_at,
						"updated_at"  =>$t1cats->updated_at,
						"numProducts" => '',
						"children" => (object)$this->get_t2_tree_without_t3($t1cats->id, $storeId)
					];
				}

			}
				
		}
		
		return $categories;
	}

	public function get_home_path(){
		$path = $_SERVER['REQUEST_URI'];
		$path_array = explode('/', $path);
		$first_segment = $path_array[1];
		
		if($first_segment == 'index.php'){
			$all_categories = '/index.php/store/benjamin';
		} else {
			$all_categories = '/store/benjamin';
		}

		return $all_categories;
	}

	public function get_products_total($store_id){
		$categories   = $this->getStoreCategories($store_id);
		$all_products = 0;
		$data_t1_id   = [];
		$t2_total     = [];

		foreach ($categories as $t1) {
			$data_t1_id[] = $t1->id;

			foreach ($t1->children as $t2) {

				$all_products += $t2->numProducts;

				if(!empty($t2->children)){
					foreach ($t2->children as $t3) {
						$all_products += $t3->numProducts;
					}
				}
				
			}

		}

		for ($i=0; $i < sizeof($data_t1_id) ; $i++) { 
			foreach ($categories as $t1) {
				
				foreach ($t1->children as $t2) {
					
					if($data_t1_id[$i] == $t2->parent_id ){
						$t2_total[$t1->id] []= $t2->numProducts;
					}

					// if(!empty($t2->children)){
               		//      $t2_total[$t2->id] [] = 0;
                	//      foreach ($t2->children as $t3) {
               		//              if($data_t1_id[$i] == $t2->parent_id && $t2->id == $t3->parent_id){
               		//                      $t2_total[$t2->id] [] = $t3->numProducts;
               		//              }
               		//      }
               		// }
				}

			}
		}
			
		//final t2 total 
		$data_t2 = [];
		foreach ($t2_total as $key => $value) {
			$data_t2[$key] = array_sum($value);
		}

		$category_sum = (object)['cat_total' => $all_products, 't2_total'=> (object)$data_t2];

		return $category_sum;

		foreach ($category_sum as $tall) {
			
			echo "<pre>";
			print_r($tall);
			echo "</pre>";
		}
	}

	public function getCategoryProducts($store_id, $slug) {

		// $tier   = 0;

		$products = [];
		$active_cats = [];
				

		$cur_category = DB::table('categories')->where('slug', $slug)->first();

		if (!$cur_category) {
			
			$cur_tier3_category = DB::table('categories_customs')->where('slug', $slug)
								->where('store_id', $store_id)->first();

			if ($cur_tier3_category) {

				// $tier = 3;

				$products = \App\Models\Product::where('store_id', $store_id)
								->where('category_custom_id', $cur_tier3_category->id);
								//->get();

			}
		}

		if(isset($cur_category)) {

			// is category tier 1 or 2
			if ($cur_category->parent_id) {

				// tier 2
				$products = \App\Models\Product::where('store_id', $store_id)
									->where([
									    ['category_id',"=", $cur_category->id],
									    ['product_moderation_type_id', '=', \App\Models\Product::PRODUCT_MODERATION_APPROVED]
									]);

			} else {

				// tier 1
				$tier_2_cats = DB::table('categories')->where('parent_id', $cur_category->id)->get();
				$tier_2_cats_ar = [];

				foreach($tier_2_cats as $tier_2_c) {
					$tier_2_cats_ar[] = (int)$tier_2_c->id;
				}

				// use the category tier 2 array

				$products = \App\Models\Product::where('store_id', $store_id)
									->whereIn('category_id', $tier_2_cats_ar)
									->where('product_moderation_type_id', '=', \App\Models\Product::PRODUCT_MODERATION_APPROVED);

			}

		}

		return $products;
	}

	private function addParentCount(&$categories, $parentId, $count) {
		foreach ($categories as $category) {
			if ($category->id === $parentId) {
				$category->numProducts += $count;
				$this->addParentCount($categories, $category->parent_id, $count);
			}
		}
	}

	private function convertCategoryArray($categoriesCollection) {
		$categories = [];
		$this->setChildCategories($categories, $categoriesCollection, null);
		return $categories;
	}

	private function setChildCategories(&$categories, $categoriesCollection, $parentId) {
		foreach ($categoriesCollection as $category) {
			if ($category->parent_id === $parentId && $category->numProducts !== null) {
				$categories[] = array_merge($category->toArray(), ['numProducts' => $category->numProducts]);
				$this->setChildCategories($categories, $categoriesCollection, $category->id);
			}
		}
	}

	private function get_t2_tree_without_t3($t1cats, $storeId = null) { // if the parent id is empty
		$ct2 = [];
		$t3Cat = DB::table('categories')
					->select('categories.*','products.id as product_id',\DB::raw('COUNT(products.id) as numProducts'))
					->join('products', 'products.category_id', '=', 'categories.id')
					->where([
					    ['categories.parent_id',"=", $t1cats],
					    ['products.product_moderation_type_id', '=', \App\Models\Product::PRODUCT_MODERATION_APPROVED],
					    ['products.store_id', '=', $storeId]
					])
					->groupBy('categories.id')
					->get();
		
		foreach ($t3Cat as $t2cats) {

			$t3_data = ['children'=> ''];
			$data = (object)array_merge((array)$t2cats, $t3_data);
			$ct2[]= (object)$data;
		}

		return $ct2;

	}

	private function get_t2_without_parent($t1cats, $storeId = null) { // if the parent id is empty
		$ct2 = [];
		$t3Cat = DB::table('categories')
					->select('categories.*','products.id as product_id',\DB::raw('COUNT(products.id) as numProducts'))
					->join('products', 'products.category_id', '=', 'categories.id')
					->where([
					    ['categories.id',"=", $t1cats],
					    ['products.product_moderation_type_id', '=', \App\Models\Product::PRODUCT_MODERATION_APPROVED],
					    ['products.store_id', '=', $storeId]
					])
					->groupBy('categories.id')
					->get();
		
		foreach ($t3Cat as $t2cats) {

			$t3_data = ['children'=> ''];
			$data = (object)array_merge((array)$t2cats, $t3_data);
			$ct2[]= (object)$data;
		}

		return $ct2;

	}

	private function get_t2_tree_with_t3($t3cats) {

		// get tier 3 parent category
		$t3cat = $t3cats[0];

		//getting T2 category
		$t2Cat = DB::table('categories')
					->select('categories.*')
					->where('categories.id',"=", $t3cat->parent_id)
					->first();

		$t1_id = $t2Cat->parent_id;

		// count tier 3 products
		$t3productCount = 0;
		foreach($t3cats as $t3c) {
			$t3productCount += $t3c->numProducts;
		}
		$t2Cat->numProducts = $t3productCount;

		$t2Cat->children    = $t3cats;

		$t1Cat = DB::table('categories')
				->select('categories.*')
				->where('categories.id',"=", $t1_id)
				->first();

		$cate_tree = [];

		//foreach ($t1Cat as $t1cats) {
		$cate_tree =  [
			"id" 		  => $t1Cat->id,
			"store_id"    => $t1Cat->store_id,
			"name" 		  =>$t1Cat->name,
			"slug" 		  => $t1Cat->slug,
			"parent_id"   => $t1Cat->parent_id,
			"order"       => $t1Cat->order,
			"deleted_at"  => $t1Cat->deleted_at,
			"created_at"  => $t1Cat->created_at,
			"updated_at"  =>$t1Cat->updated_at,
			"numProducts" => 0,
			"children"    => (array)[ 0=>$t2Cat ]
		];
				
		//}
			
		return $cate_tree;
	}
}
