<?php
/* Copyright (c) 2017 Methys Digital
 * All rights reserved.
 *
 * This software is the confidential and proprietary information of Methys Digital.
 * ("Confidential Information"). You shall not disclose such
 * Confidential Information and shall use it only in accordance with
 * the terms of the license agreement you entered into with Methys Digital.
 *
 * @author Anthony Galagade <galagadea@gmail.com>
 */

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;  
use DB; 
use View;
use App\Models\Store;
use App\Models\AttributeVariant;
use App\Models\AttributeVariantValue;
use App\Models\Product;
use App\Http\Controllers\Traits\TableSortingAndFilteringTrait;
use App\Facades\SortFilterHelper;
use Response;
class VariantController extends BaseController
{

    use TableSortingAndFilteringTrait;

	public function __construct() {
        $this->middleware('pagination');
    }

     public function modelAdd($storeid) {
        
        $store = Store::where('id', $storeid)->first();
        if(!$store){
          $request->session()->flash('alert-error', 'There is no store associated with this account.');
           return redirect()->route("admin.dashboard");
        }else{
        	
        	View::share('store', $store);
           	return view('backoffice.product.modal-add');
        }
        
    }

    public function modelAdminadd(){
    	
        return view('backoffice.variant.model-add');
        
    }

    public function modelAdminEDIT($id){
    	$variant = AttributeVariant::where('id', $id)->first();
        if(!$variant){
          $request->session()->flash('alert-error', 'There is no product attribute associated with this account.');
           return redirect()->route("admin.variants");
        }else{
        	
        	View::share('variant', $variant);
           	return view('backoffice.variant.model-edit');
        }
    }
    

    public function add(Request $request)
    {
    	$inputs = $request->all();
    	$variant = new AttributeVariant();
    	$variant->store_id = $inputs['store_id'];
    	$variant->name = $inputs['variant_name'];
		  $variant->save();
		  $request->session()->flash('alert-success', 'Product attribute was successfully added.');
      
      // if user is a superadmin or productmoderator, allow
      if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('productmoderator')) {
           return redirect()->route("admin.moderator");
      } else {
        return redirect()->route("admin.products");
      }

    }
     public function save(Request $request)
    {
    	$inputs = $request->all();
    	
    	if(array_key_exists('id', $inputs)){
    		$variant = AttributeVariant::where('id', $inputs['id'])->first();
    		$variant->name = $inputs['variant_name'];
		    $variant->save();
		    $request->session()->flash('alert-success', 'Product attribute was successfully edited.');
    	}else{
    		$variant = new AttributeVariant();
    		$variant->name = $inputs['variant_name'];
			$variant->save();
			$request->session()->flash('alert-success', 'Product attribute was successfully added.');
    	}

		return redirect()->route("admin.variants");
    }
    
    public function modelDELETE($id){
    	$variant = AttributeVariant::where('id', $id)->first();
        if(!$variant){
          $request->session()->flash('alert-error', 'There is no product attribute associated with that info.');
           return redirect()->route("admin.variants");
        }else{
        	
        	View::share('variant', $variant);
           	return view('backoffice.variant.model-delete');
        }
    }
    public function delete(Request $request){
    	$inputs = $request->all();
    	$variant = AttributeVariant::where('id', $inputs['id'])->first();
        if(!$variant){
          $request->session()->flash('alert-error', 'There is no product attribute associated with that info.');
           return redirect()->route("admin.variants");
        }else{
        	$variant->delete();
        	$request->session()->flash('alert-success', 'Product attribute was successfully deleted.');
		    return redirect()->route("admin.variants");
        }
    }

    public function index(Request $request){
  		  \ViewHelper::setActiveNav('variants');
  		  \ViewHelper::setPageDetails('Storefronts | Attributes', 'Products Attributes ', 'this is a small description');
        $query = AttributeVariant::select('attribute_variant.*');
 		
		$query->orderBy('name');
		$query = $this->tableFilter($query);
        $variant = $this->tablePaginate($query);
      	View::share('variants', $variant);
      	return view('backoffice.variant.index');
    } 

}

