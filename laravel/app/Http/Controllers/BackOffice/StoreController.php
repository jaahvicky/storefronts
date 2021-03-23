<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use App\Http\Requests\BackOffice\UpdateStoreDetailsRequest;
use App\Http\Requests\BackOffice\UpdateStoreAboutRequest;
use App\Http\Requests\BackOffice\UpdateStoreWarrantyRequest;

use App\Models\StoreAppearance;
use App\Models\StoreDetail;
use App\Models\Store;
use App\Models\Country;
use App\Models\City;
use App\Models\Suburb;
use App\Models\StoreAbout;
use App\Models\StoreWarranty;
use App\Models\StoreDeliveryMethod;
use App\Models\osclass\Items;
use App\Models\osclass\User;
use App\Http\Helpers\BcryptHelper;
use App\Models\Product;
use App\Http\Helpers\ProductSyncHelper;
use Response;
use Config;
use DB;
use Auth;
use Validator;
use View;
class StoreController extends BaseController
{
    
    public function __construct(){
       // parent::__construct();
    }

    
    public function bulkSync(Request $request) {
        $items = \Request::get('items');
        $rules =[
            'items' => 'required',
            
            
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
             return Response::json([
                'success'=>false,
                'message'=>$validation->messages()->toArray(),
            ]);
        }else{
            $count =0;
            $data_return =[];
            foreach ($items as $item) {
                if($item['status_id'] == 0){
                    $sync = new ProductSyncHelper();
                    $data = $sync->productSync($item['id']);
                    array_push($data_return, $data);
                    $count++;
                }
               
            }
            return Response::json(['message'=>$count, 'data'=>$data_return]);
        }
    }

    public function bulkDelete(Request $request) {
        $items = \Request::get('items');
        $rules =[
            'items' => 'required',
            
            
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
             return Response::json([
                'success'=>false,
                'message'=>$validation->messages()->toArray(),
            ]);
        }else{
            $data_return =[];
            $count = 0;
            foreach ($items as $item) {
                $sync = new ProductSyncHelper();
                $data = $sync->DeleteMigration($item['id']);
                $count++;
                array_push($data_return, $data);
            }
             return Response::json(['message'=>$count, 'data'=>$data_return]);
        }
    }

    public function syncMigrate(Request $request) {
        $id = \Request::get('id');
        $rules =[
            'id' => 'required|integer',
            
            
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
             return Response::json([
                'success'=>false,
                'message'=>$validation->messages()->toArray(),
            ]);
        }else{
            $sync = new ProductSyncHelper();
            $data = $sync->productSync($id);

            return Response::json([
                'success'=>true,
                'message'=>$data,
            ]);
        }
    }

    public function deleteMigrate(Request $request) {
        $id = \Request::get('deleteId');
        $rules =[
            'deleteId' => 'required|integer',
            
            
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
             return Response::json([
                'success'=>false,
                'message'=>$validation->messages()->toArray(),
            ]);
        }else{
            $sync = new ProductSyncHelper();
            $data = $sync->DeleteMigration($id);

            return Response::json([
                'success'=>true,
                'message'=>$data,
            ]);
        }
    }

    public function userMigrate(Request $request) {
        $user_name = '+263'.\Request::get('username');
        $password = \Request::get('password');
        $rules =[
            'username' => 'required|integer',
            'password' => 'required',
            
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return Response::json([
                'success'=>false,
                'message'=>$validation->messages()->toArray(),
            ]);
        }else{
            $user = User::where('s_username', $user_name)->first();
            if($user){
                $security = new BcryptHelper();
                if($security->verify($password, $user->s_password)){
                    $store = Auth::user()->stores()->first();
                    $update = StoreDetail::where('store_id', $store->id)->first();
                    if($update){
                        $update->phone = \Request::get('username');
                        $update->migrated = 1;
                        $update->save();
                        return Response::json([
                                'success'=>true
                        ]);
                    }else{
                        return Response::json([
                            'success'=>false,
                            'message'=>['Store'=>'Please fill in your store details first then try again'],
                        ]);
                    }
                   
                }else{
                     return Response::json([
                        'success'=>false,
                        'message'=>['Password'=>'Password Combination error'],
                    ]);
                }
                
            }else{
                return Response::json([
                'success'=>false,
                'message'=>['user'=>'User does not exist'],
                ]);
            }
            
            
        }
    }

    public function migration(Request $request) {
        $store = Auth::user()->stores()->first();
        $store_details = StoreDetail::where('store_id', $store->id)->first();
        
        View::share('migrated', $store_details);
        return view('backoffice/store/migration/index');
    }

    public function itemsMigration(Request $request){
        $store = Auth::user()->stores()->first();
        if($store){
            $update = StoreDetail::where('store_id', $store->id)->first();
            if($update){
                $number = '+263'.$update->phone;
                $user = User::where('s_username', $number)->first();
                if($user){
                    return $this->getItems($user, $store);
                }else{
                    return Response::json([
                        'success'=>false,
                        'message'=>['ownai'=>'user does not exist'],
                    ]);
                }
        
            }else{
                return Response::json([
                    'success'=>false,
                    'message'=>['Store'=>'store details not found'],
                ]);
            }
        }else{
            return Response::json([
                'success'=>false,
                'message'=>['user'=>'User does not exist'],

            ]);
        }
        



    }

    private function getItems($user, $store){
        $items = Items::where('fk_i_user_id', $user->pk_i_id)->where('b_active', 1)->get();//
        if($items){
            $data = [];
            foreach ($items as $item) {
                $status = 'Not Available on Storefront';
                $status_id= 0;
                $product = Product::where('slug', $item->slug)->first();
                if($product){
                    $status ='Available on Storefront';
                    $status_id = 1;
                }
                if(($item->platform == 'Ownai') && ($store->type->slug == $item->category->parent->description->s_slug)){
                            $data[]=(object)[
                            'id'=>$item->pk_i_id,
                            'slug'=>$item->slug,
                            'platform'=>$item->platform,
                            'title'=>$item->item_desc->s_title,
                            'description'=>$item->item_desc->s_description,
                            'status'=>$status, 
                            'status_id'=>$status_id,
                            'slug_cate'=>$item->category->parent->description->s_slug,
                            'store_cate'=>$store->type->slug,
                        ];
                }
                
            }

            return Response::json([
             'success'=>true,
             'data'=>$data,
            ]);
        }else{
            return Response::json([
             'success'=>false,
             'message'=>['ownai'=>'no items'],
            ]);
        }
    }
    public function appearance(Request $request) {
        
        \ViewHelper::setPageDetails('Storefronts | Store', 'Appearance', 'this is a small description');
        \ViewHelper::setActiveNav('store.appearance');
        
        $store = Auth::user()->stores()->with('appearance')->first();
        if (!is_null($store)) {

            $data['store'] = $store;
            return view('backoffice/store/appearance/index', $data);
        }

        $request->session()->flash('alert-error', 'There is no store associated with this account.');
        return redirect()->route("admin.dashboard");
    }
    
    public function updateAppearance(Request $request) {        
        $input = $request->all();
        $store = Auth::user()->stores()->with('appearance')->first();

        if (!is_null($store)) {
            $appearance = new StoreAppearance();
            $appearance->store_id = $store->id;
            if (!is_null($store->appearance)) {
                $appearance = $store->appearance;
            }

            $appearance->logo_image = $input['logo-image'];
            $appearance->banner_image = $input['banner-image'];
            $appearance->primary_colour = (empty($input['primary-colour'])) ? "#009eff" : $input['primary-colour'];
            $appearance->secondary_colour = (empty($input['secondary-colour'])) ? "#22d497" : $input['secondary-colour'];

            $appearance->save();
            $request->session()->flash('alert-success', 'Store was successfully updated.');
            return redirect()->route("admin.store.appearance");
        }
        
        $request->session()->flash('alert-error', 'There is no store associated with this account.');
        return redirect()->route("admin.dashboard");
    }
    
    public function details(Request $request) {
        
        \ViewHelper::setPageDetails('Storefronts | Store', 'Details', 'this is a small description');
        \ViewHelper::setActiveNav('store.details');

        $store = Auth::user()->stores()->with('details')->with('contactDetails')->first();

        $old_city_id = $request->old('city');

        // if edit was not done, get the current id
        if (!$old_city_id && !is_null($store)) {
            $old_city_id = $store->details->city_id;
        }
        
        $data = [
            'countries' => Config::get('storefronts.countries'),
            'cities'    => $this->cities(),
            'suburbs'   => $this->suburbs($old_city_id),
            'storefront_types' => Config::get('storefronts.storefront-types')
        ];
        
        if (!is_null($store)) {

            $data['store'] = $store;
            return view('backoffice/store/details/index', $data);
        }

        $request->session()->flash('alert-error', 'There is no store associated with this account.');
        return redirect()->route("admin.dashboard");
    }

    public function updateDetails(UpdateStoreDetailsRequest $request) {

        $inputs = $request->all();

        $store = Store::where('id', $inputs['store_id'])->first();
        if (isset($store)) {
            $rules = [
                'phone' => 'required|phone.store.unique.auth',
                'email' => 'required|email.store.unique.auth',

            ];
            $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {

                return redirect()->back()->withInput()->withErrors($validation->messages()->toArray());
            } else {
                $details = (isset($store->details)) ? $store->details : new StoreDetail();
                //store - store details
                $details->street_address_1 = $inputs['street_address_1'];
                $details->street_address_2 = $inputs['street_address_2'];
                $details->suburb_id = $inputs['suburb'];
                $details->city_id = $inputs['city'];
                $country = Country::where('name', $inputs['country'])->first();
                if (isset($country)) {
                    $details->country_id = $country->id;
                }
                $details->phone = $inputs['phone'];
                $details->email = $inputs['email'];
                $details->collection_hours = $inputs['collection_hours'];
                $details->store_id = $store->id;
                $details->save();

                $request->session()->flash('alert-success', "Store was successfully updated.");
                return redirect()->route("admin.store.details");
            }
        }
        $request->session()->flash('alert-error', 'There is no store associated with this account.');
        return redirect()->route("admin.dashboard");
    }
    
    public function about(Request $request) {
        
        \ViewHelper::setPageDetails('Storefronts | Store', 'About', 'this is a small description');
        \ViewHelper::setActiveNav('store.about');
        
        $store = Auth::user()->stores()->with('about')->first();
        if (!is_null($store)) {

            $data['store'] = $store;
            return view('backoffice/store/about/index', $data);
        }

        $request->session()->flash('alert-error', 'There is no store associated with this account.');
        return redirect()->route("admin.dashboard");
    }
    
    public function updateAbout(UpdateStoreAboutRequest $request) {
        
        $inputs = $request->all();
        
        $store = Store::where('id', $inputs['store_id'])->first();
        if (isset($store)) {
            
            $about = (isset($store->about)) ? $store->about : new StoreAbout();
            $about->exerpt = $inputs['exerpt'];
            $about->description = $inputs['description'];
            
            $about->store_id = $store->id;
            $about->save();
            
            $request->session()->flash('alert-success', "Store was successfully updated.");
            return redirect()->route("admin.store.about");
        }
        
        $request->session()->flash('alert-error', 'There is no store associated with this account.');
        return redirect()->route("admin.dashboard");
    }
    
    public function warranty(Request $request) {
        
        \ViewHelper::setPageDetails('Storefronts | Store', 'Warranty', 'this is a small description');
        \ViewHelper::setActiveNav('store.warranty');
        
        $store = Auth::user()->stores()->with('warranty')->first();
        if (!is_null($store)) {

            $data['store'] = $store;
            return view('backoffice/store/warranty/index', $data);
        }

        $request->session()->flash('alert-error', 'There is no store associated with this account.');
        return redirect()->route("admin.dashboard");
    }
    
    public function updateWarranty(UpdateStoreWarrantyRequest $request) {
        
        $inputs = $request->all();
        
        $store = Store::where('id', $inputs['store_id'])->first();
        if (isset($store)) {
            
            $warranty = (isset($store->warranty)) ? $store->warranty : new StoreWarranty();
            $warranty->warranty = $inputs['warranty'];
            
            $warranty->store_id = $store->id;
            $warranty->save();
            
            $request->session()->flash('alert-success', "Store was successfully updated.");
            return redirect()->route("admin.store.warranty");
        }
        
        $request->session()->flash('alert-error', 'There is no store associated with this account.');
        return redirect()->route("admin.dashboard");
    }

    public function delivery(Request $request) {

        \ViewHelper::setPageDetails('Delivery | Store', 'Delivery', 'this is a small description');
        \ViewHelper::setActiveNav('store.delivery');

        // if the store is not in Harare, don't show the Econet Logistics option
        // don't allow the Econet option on update

        $store = Auth::user()->stores()->first(); // with('delivery')
        if (!$store) {
             $request->session()->flash('alert-error', 'There is no store associated with this account.');
            return redirect()->route("admin.dashboard");
        }
       
        $storefront_delivery_method = $this->storefront_delivery_method();

        $logistics = false;
        $propertyOrVehicle = false;


        if (isset($store->details)) {
                
            $storeDets = $store->details;
            if($storeDets->city_id == City::CITY_HARARE) {
                $logistics = true;
            }
        }

        $store_type = $store->store_type_id;
        if ($store_type == Store::STORE_TYPE_VEHICLES || $store_type == Store::STORE_TYPE_PROPERTY) {
            $propertyOrVehicle = true;
        }

        if($propertyOrVehicle || !$logistics) {
            
            unset($storefront_delivery_method[$store::ECONET_LOGISTICS]);
            if($propertyOrVehicle) {
                unset($storefront_delivery_method[$store::DELIVERY_COLLECT_IN_STORE]); 
            }

        }

        View::share('storefront_delivery_method', $storefront_delivery_method);
        View::share('store', $store);
        return view('backoffice/store/delivery/index');
       
    }

    private function storefront_delivery_method(){
        $delivery_method = StoreDeliveryMethod::all();
        $storefront_delivery_method = [];
        foreach ($delivery_method as $delivery) {
            
            $storefront_delivery_method[$delivery->id]= $delivery->method;
                    
        }

        return $storefront_delivery_method;
    }
    

    public function updateDelivery(Request $request) {
        
        $data = $request->all();
        $store = Store::where('id', $data['store'])->first();
        if (!$store) {
            $request->session()->flash('alert-error', 'There is no store associated with this account.');
            return redirect()->route("admin.dashboard");
        }
        if(empty($data['store_delivery'])){
             $request->session()->flash('alert-error', 'Please select the valid delivery method');
             return redirect()->route('admin.store.delivery')->withInput($data);
        }else{

            $store_type = $store->store_type_id;
            $delivery = (int)$data['store_delivery'];
            if ($store_type == Store::STORE_TYPE_VEHICLES || $store_type == Store::STORE_TYPE_PROPERTY) {
                $delivery = (int)Store::DELIVERY_ARRANGE_WITH_SELLER;
            }

            $store->store_delivery_method_id = (int)$delivery;
            $store->save();
            $request->session()->flash('alert-success', 'Delivery information has been updated');
            return redirect()->route('admin.store.delivery');


        }
        
        
    }

     public function ApproveMessage($slug, Request $request){
        $store = Store::where('slug', $slug)->first();
        if(!$store){
            $request->session()->flash('alert-error', 'There is no store associated with this account.');
                return redirect()->route("admin.dashboard");
        }
       
        View::share('store', $store);
        return view('backoffice.admin.stores.mail');
    }

    private function cities() {
        $cities = City::all();
        $cities_arr = [];
        foreach ($cities as $city) {
            $cities_arr[$city->id] = $city->name;
        }

        return $cities_arr;
    }

    private function suburbs($cityid = null) {
        
        $suburbs = [];

        if ($cityid) {
            $suburbs = Suburb::where('city_id', $cityid)->get();
        }

        $suburbs_arr = [];
        foreach ($suburbs as $suburb) {
            $suburbs_arr[$suburb->id] = $suburb->name;
        }

        return $suburbs_arr;
    }
}
