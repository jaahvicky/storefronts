<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Category;
use DB;

class Product extends BaseModel {

	use SoftDeletes;
	use Traits\SlugTrait;

	const PRODUCT_STATUS_TYPE_DRAFT = 1;
	const PRODUCT_STATUS_TYPE_VISIBLE = 2;
	const PRODUCT_STATUS_TYPE_HIDDEN = 3;
	const PRODUCT_MODERATION_APPROVED = 1;
	const PRODUCT_MODERATION_REJECTED = 2;
	
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['store_id', 'title', 'description', 'price', 'currency_id', 'product_type_id', 'category_id','product_moderation_type_id','expiration_dt',
	];
	
	public function images() {
		return $this->hasMany('\App\Models\ProductImage');
	}
	
	public function coverImage() {
		return $this->hasOne('\App\Models\ProductImage');
	}
	
	public function category() {
		return $this->belongsTo('\App\Models\Category');
	}

	public function categoryCustom() {
		return $this->belongsTo('\App\Models\CategoriesCustom');
	}
        
        public function addCategory(Category $category) {
            return $this->category()->save($category);
        }
        
        public function productStatus() {
            return $this->belongsTo('App\Models\ProductStatusType', 'product_status_id');
        }
        
        public function productModerationType() {
            return $this->belongsTo('App\Models\ProductModerationType', 'product_moderation_type_id');
        }
        
        public function store() {
            return $this->belongsTo('\App\Models\Store');
        }

        public function variantAttributesValue() {
            return $this->hasOne('\App\Models\AttributeVariantValue', 'product_id');
        }
	
	public function getCoverImageUrl() {
		if ($this->images && count($this->images) > 0) {
			return \Storage::disk('public')->url($this->images[0]->filename);
		} else {
			return null;
		}
	}
	
	public function attributeVariantValue() {
		return $this->hasOne('\App\Models\AttributeVariantValue');
	}

	public function AttributeValueProduct() {
           return $this->hasMany('\App\Models\AttributeValueProduct', 'product_id');
    }

    public function ContactDetails() {
		return $this->hasOne('\App\Models\ProductContactDetails');
	}


    public function attributeValues() {
            return $this->belongsToMany('\App\Models\AttributeValue');
        }
        
        public function addAttributeValue(\App\Models\AttributeValue $attributeValue) {
            return $this->attributeValues()->save($attributeValue);
        }

        public function getCategory($product_id = null) {
        	$category_id = DB::table('products')
		                    ->select('category_id')
		                    ->where('id', '=', $product_id)
		                    ->first();

		    return $category_id->category_id;

        }
        public function getCatProducts($category_id = null) {
        	

		    if($category_id){
		    	$products = DB::table('products')
		    				->select('id', 'title')
		                    ->where('category_id', '=', $category_id)
		                    ->get();

		    }

        	return $products;
        }
}

        Product::deleting(function($model) {
            $model->retireSlug();
        });

        Product::restored(function($model) {
            $model->restoreSlug();
        });
