<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use DB;

use App\Models\Product;
use App\Models\City;
use App\Models\ProductImage;
use App\Models\ProductStatusType;
use App\Models\ProductModerationType;
use App\Models\Category;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeVariant;
use App\Models\AttributeVariantValue;
use App\Models\AttributeValueProduct;
use App\Http\Helpers\ProductSyncHelper;
use App\Models\Suburb;
use App\Models\ProductContactDetails;
class ProductController extends BaseController
{

    public function index(Request $request, $product_id = null) {
        
        \ViewHelper::setActiveNav('products');
        \ViewHelper::setPageDetails('Storefronts | Products', 'Add Product', 'this is a small description');
        
        $store = Auth::user()->stores()->first();
        if (!$store) {
            $request->session()->flash('alert-error', 'There is no store associated with this account.');
            return redirect()->route("admin.dashboard");
        }
        
        $visibils = ProductStatusType::all();
        foreach($visibils As $visibility) {
            $visibilities[$visibility->name] = $visibility->name; 
        }
        
        $shift = array_shift($visibilities);
        $visibilities[$shift] = $shift;
        
        $cit = City::all();
        $cities = [];
        $cities[0] = 'Select City'; 
        foreach($cit As $city) {
            $cities[$city->id] = $city->name; 
        }
        $categories = $this->getCategories(strtolower($store->type->slug));
        $attributes = $this->getAttributes();
        $variantvalues = $this->getAttributesVariantValues($product_id);
        $variants = DB::table('attribute_variant')->get();
        $data = [
            'categories' => $categories,
            'attributes' => $attributes,
            'visibilities' => $visibilities,
            'city' => $cities,
            'suburb' => Suburb::all(),
            'variants' => $variants,
            'variantvalues'=>$variantvalues,
            'store' => $store
        ];
        
        if ($product_id) {
            
            $product = Product::where('id', $product_id)->first();
            if ($product && $product->store()->first()->user()->first()->id && $product->store()->first()->user()->first()->id == Auth::user()->id) {
                
                $data['product'] = $product;
                \ViewHelper::setPageDetails('Storefronts | Products', 'Edit Product', 'this is a small description');

                //Images
                $imgs = $product->images->all();
                foreach($imgs As $img) {
                    $images[] = $img->filename;
                }
                $data['images'] = (isset($images) > 0) ? $images : [];
                
                //The values for the product attributes if any
                $attributeValueProduct = $this->getAttributeValueProduct($product);
                
                $data['attributeValueProduct'] = $attributeValueProduct;
            }
            else {
                $request->session()->flash('alert-error', 'No product found.');
                return redirect()->route("admin.products");
            }
        }
        
        return view('backoffice/product/index', $data);
    }
    
    private function getCategories($storeType) {
       
        $propertiesCat = Category::where('slug', "property")->first();
        $vehiclesCat = Category::where('slug', "vehicles")->first();
        $jobsCat = Category::where('slug', "jobs")->first();
        $category = Category::where('slug', $storeType)->first();
        
        if ($storeType ==  $vehiclesCat->slug) {
                
            $cats = DB::select("select categories.name As parent_name, subcats.name As child_name, subcats.id As child_id from categories left join categories As subcats on subcats.parent_id = categories.id where categories.id = ".$category->id);
        }
        else if ($storeType == $propertiesCat->slug) {

            $cats = DB::select("select categories.name As parent_name, subcats.name As child_name, subcats.id As child_id from categories left join categories As subcats on subcats.parent_id = categories.id where categories.id = ".$propertiesCat->id);
        }
        else if ($storeType == $jobsCat->slug) {

            $cats = DB::select("select categories.name As parent_name, subcats.name As child_name, subcats.id As child_id from categories left join categories As subcats on subcats.parent_id = categories.id where categories.id = ".$jobsCat->id);
        }else {

            $notIn = "(".$propertiesCat->id.",".$vehiclesCat->id.",".$jobsCat->id.")";
            $cats = DB::select("select categories.name As parent_name, subcats.name As child_name, subcats.id As child_id from categories left join categories As subcats on subcats.parent_id = categories.id where categories.parent_id is null and categories.id not in $notIn");
        }
        
        foreach($cats As $cat) {
            $categories[$cat->parent_name][$cat->child_name] = $cat->child_id;
        }
        
        return $categories;
    }
    
    private function getAttributes() {
        
        $attribute_data = DB::select("
            SELECT attributes.id, attributes.name, attributes.type, categories.id As category_id, categories.name As category_name
            FROM `attributes`
            LEFT JOIN attribute_category ON attribute_category.attribute_id = attributes.id
            LEFT JOIN categories ON attribute_category.category_id = categories.id
            WHERE categories.parent_id IS NOT NULL
            AND attributes.slug !='price_range'
            AND attributes.slug !='price-type-custom'
            AND attributes.slug !='whatsapp-custom-field'
            ORDER BY category_name");

        $attributes = [];
        foreach($attribute_data As $attribute) {
            
            $attribute_options = AttributeValue::where('attribute_id', $attribute->id)->get();
            $options = [];
            foreach($attribute_options As $option) {
                $options[] = $option->value;
            }
            
            $attributes[$attribute->category_id][] = [
                'id' => $attribute->id,
                'name' => $attribute->name,
                'type' => $attribute->type,
                'options' => $options
            ];
        }
        
        return $attributes;
    }

    private function getAttributesVariantValues($productid){
        if($productid){
           return $qry = AttributeVariantValue::where('product_id', $productid)->first();

        }else{
            return [];
        }
    }
     
    private function getAttributeValueProduct($product) {
        
        $attributeValueProduct = [];
        $values = $product->AttributeValueProduct;
        foreach($values As $value) {


            $attributeValueProduct[$value->attribute_value_id] = $value->value;
        }

        return $attributeValueProduct;
    }
    
    public function update(Request $request) {

        $this->validateProduct($request);
        $inputs = $request->all(); 

        $visibility = $inputs['visibility'];

        //Product object and store link
        if (isset($inputs['product_id'])) {
            $product = Product::where('id', $inputs['product_id'])->first();
           

        }
        else {
            $product = new Product();
            $store = Auth::user()->stores()->first();
            if ($store) {
                $product->store_id = $store->id;
            }
        }

        //Product Title and Slug
        if (isset($inputs['title'])) {
            $product->title = $inputs['title'];
            if(empty($product->slug)){
                $product->slug = str_slug($inputs['title'], "-");
            }
            
        }

        // Check that slug is already taken
        // if so, add a -'number' to the slug
        $slug = $product->slug;

        if(!isset($inputs['product_id'])) {
            $slug_taken = Product::where('slug', $slug)->first();
            $slug_count = 1;
            while(!empty($slug_taken)) {
                // slug-2, slug-3 etc
                $slug_count += 1;
                $slug_taken = Product::where('slug', $slug . '-' . $slug_count)->first();
            }

            // if slug_count has been used in the while loop
            if($slug_count > 1) {
                $product->slug = $slug . '-' . $slug_count;
            }
        }

        //Product Description
        if (isset($inputs['description'])) {
            $product->description = $inputs['description'];
        }

        //Product Price
        if (isset($inputs['price'])) {
            $product->price = $inputs['price']*100;
        }

        //ProductType
        $productType = DB::select("SELECT id from product_types where name = 'Simple'");
        $product->product_type_id = $productType[0]->id;

        //ProductStatusType
        $productStatusType = ProductStatusType::where('name', $visibility)->first();
        $product->product_status_id = $productStatusType->id;

        //ProductModerationType
        //if ($visibility !== "Draft") {
            $productModerationType = ProductModerationType::where('name', 'Approved')->first();
            $product->product_moderation_type_id = $productModerationType->id;
        //}

        //Category
        $category = Category::where('id', $inputs['category'])->first();
        if ($category) {
            $product->category_id = $category->id;
        }

        
        //Currency
        $product->currency_id =  1;
       
        if(empty($product->platform)){
            $product->platform= 'storefront';
        }
        
        $product->save();

        //contact details 
        $conatcDetails = ProductContactDetails::where('product_id',  $product->id)->first();
        if(!$conatcDetails){
            $conatcDetails = new ProductContactDetails();
        }
        $conatcDetails->product_id = $product->id;
        $conatcDetails->contact_name = $inputs['contact_name'];
        $conatcDetails->phone = $inputs['phone'];
        $conatcDetails->city_id = $inputs['city'];
        $conatcDetails->suburb_id = $inputs['suburb'];
        $conatcDetails->save();
        //the code has been disabled
        // $attributeValues = AttributeVariantValue::where('product_id', $product->id)->first();
        // if($attributeValues){
        //     $attributeValues->data = $inputs['variantvalues'];
            
        // }else{
        //     $attributeValues = new  AttributeVariantValue();
        //     $attributeValues->fill([
        //         'product_id'=> $product->id,
        //         'data'=>$inputs['variantvalues']
        //     ]);
        // }
        // $attributeValues->save();
        //Once Product has been saved:
        
        //Images
        $productImages = ProductImage::where('product_id', $product->id)->take(5)->get();
        for ($i=0; $i<5; $i++) {
            if (isset($inputs['images-'.$i]) && !empty($inputs['images-'.$i])) {
                
                if (isset($productImages[$i])) {
                    $productImage = $productImages[$i];
                }
                else {
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                }
                
                $productImage->filename = $inputs['images-'.$i];
                $productImage->original_upload = $inputs['images-'.$i];
                $productImage->featured = (isset($inputs['featured']) && $inputs['featured'] == $i) ? 1 : 0;
                
                $productImage->save();
            }
            else {
                if (isset($productImages[$i])) {
                    $productImages[$i]->delete();
                }
            }
        }
        
        //Attributes
        DB::table('attribute_value_product')->where('product_id', '=', $product->id)->delete();
        $amount_attr = Attribute::where('slug', 'price-type-custom')->first();
        if($amount_attr){
            $productatr = new AttributeValueProduct();
            $productatr->fill([
                'attribute_value_id'=>$amount_attr->id,
                'value'=> 'Amount',
                'product_id'=>$product->id
            ])->save();
        }
        
        foreach($inputs As $name => $value) {
            
            if (strstr($name, "subcat-")) {
                
                $attrId = str_replace("subcat-", "", $name);
                $attribute = Attribute::where('id', $attrId)->first();
                
                if ($attribute->type === "CHECKBOX") {
                    $value = ($value == "on") ? 1 : 0;
                }
               
                $productatr = new AttributeValueProduct();
                $productatr->fill([
                            'attribute_value_id'=>$attribute->id,
                            'value'=> $value,
                            'product_id'=>$product->id
                ])->save();
                

                // $attributeValue = AttributeValue::where('attribute_id', $attribute->id)->where('value', $value)->first();
                
                // if (!is_null($attributeValue)) {
                    
                //     $product->addAttributeValue($attributeValue);
                // }
            }
        }

        // run sync with osclass
        $sync = new ProductSyncHelper();
        $data = $sync->itemOsclassSync($product->id);
        

        $request->session()->flash('alert-success', 'Product saved.');
        return redirect()->route("admin.products");
    }
    
    private function validateProduct($request) {
        
        $inputs = $request->all();
        
        //Check that product belongs to user
        if (isset($inputs['product_id'])) {
            $product = Product::where('id', $inputs['product_id'])->first();
            $store = $product->store;
            
            if ($store && $store->user->first()->id !== Auth::user()->id) {
                $request->session()->flash('alert-error', "You don't have permission to change this product.");
                return redirect()->route("admin.dashboard");
            }
        }

        $category = Category::where('id', $inputs['category'])->first();
        
        //Only make sure all attribute fields are not greater than 500 for extra protection
        $attribute_validation = [];
        foreach($inputs As $name => $value) {
            
            if (strstr($name, "subcat-")) {
                $attribute_validation[$name] = ['max:500'];
            }
        }
         
        $common_validation = [
            'images-0' => ['max:500'],
            'images-1' => ['max:500'],
            'images-2' => ['max:500'],
            'images-3' => ['max:500'],
            'images-4' => ['max:500'],
            'price' => ['numeric', 'digits_between:1,10'],
        ];
        
        $category_constraints = ['max:500','numeric', 'exists:categories,id']; 
        $title_constraints = ['max:100'];
        $description_constraints = ['max:255'];
        $price_constraints = ['whole.number'];
        $city = ['numeric', 'min:1', 'required'];
        $phone = ['numeric', 'required'];
        
        $visibility = $inputs['visibility'];
        if ($visibility != "Draft") {
            
            $category_constraints[] = 'required';
            $title_constraints[] = 'required';
            $description_constraints[] = 'required';
            $price_constraints[] = 'required';
        }
        
        $this->validate($request, array_merge($common_validation, $attribute_validation, [
            'category' => $category_constraints,
            'title' => $title_constraints,
            'description' => $description_constraints,
            'price' => $price_constraints,
            'contact_name'=>$title_constraints,
            'phone'=>$phone,
            'city'=>$city,
            'suburb'=>$city,
        ]));
    }

    private function SortVariantValues($variantvalues){
        $returnData = [];
        if(array_key_exists('variant_ids', $variantvalues)){
            $returnData['variant_ids'] = $variantvalues->variant_ids;
        }
       
        if(array_key_exists('data_values', $variantvalues)){
           foreach ($variantvalues->data_values as $value) {
            if($value->options[0]->options->delete == 0){
                $returnData['data_values'][] = $value;
            }
           } 
        }
        if(array_key_exists('elements', $variantvalues)){
            $returnData['elements']= $variantvalues->elements;
        }
        

        return json_encode((object)$returnData);
    }
}
