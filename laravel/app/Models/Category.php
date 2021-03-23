<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Category extends BaseModel {

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'slug', 'parent_id'];

	public function ancestor() {
		return $this->belongsTo('\App\Models\Category', 'parent_id');
	}
    public function child() {
        return $this->hasMany('\App\Models\Category', 'parent_id');
    }

        
        public function attributes() {
            return $this->belongsToMany('\App\Models\Attribute');
        }
        
        public function addAttribute(\App\Models\Attribute $attribute) {
            
            return $this->attributes()->save($attribute);
        }

    public function topCategories($user_id){

    	$store_id = DB::table('store_user')
        					->where('user_id', "=", $user_id)
        					->select('store_id')
        					->first();

    	$categories = $this->_getTopCategories($user_id, $store_id->store_id);
                     

    	return $categories;
    }


    public function _getTopCategories($user_id, $store_id){

    	$categories = DB::table('products as prod')
    				 ->join('categories as cat', 'prod.category_id', '=', 'cat.id')
                     ->select(DB::raw('category_id, COUNT(*) AS online, cat.name, cat.parent_id'))
                     ->where('product_status_id', '=', 2)
                     ->where([
							    ['product_status_id', '=', 2],
							    ['store_id', '=', $store_id],
							])
                     ->groupBy('category_id')
                     ->orderBy('online', 'desc')
                     ->limit(5)
                     ->get();

        foreach ($categories as $cat) {

        	$parent_name = DB::table('categories')
        					->where('id', "=", $cat->parent_id)
        					->select('name','slug')
        					->first();
        	if($parent_name){
        		$cat->parent_name = $parent_name->name;
        		$cat->parent_slug = $parent_name->slug;
        	} else {
        		$cat->parent_name = '';
        		$cat->parent_slug = '';
        	}

        	//Getting 
        	$not_active = DB::table('products')
                     ->select(DB::raw('category_id, COUNT(*) AS offline'))
                     ->where([
							    ['product_status_id', '!=', 2],
							    ['category_id', '=', $cat->category_id],
							])
                     ->groupBy('category_id')
                     ->first();
             
            if($not_active){
            	$cat->offline = $not_active->offline;
            } else {
            	$cat->offline = 0;
            }


        } //end foreach

        return $categories;
    } //end _getTopCategories

}
