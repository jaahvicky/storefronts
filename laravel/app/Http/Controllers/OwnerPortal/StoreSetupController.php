<?php

namespace App\Http\Controllers\OwnerPortal;

use Illuminate\Http\Request;
use App\Http\Requests\OwnerPortal\UpdateStoreSetupDetailsRequest;
use App\Http\Requests\OwnerPortal\UpdateStoreSetupContactDetailsRequest;
use App\Http\Requests\OwnerPortal\UpdateStoreSetupPaymentDetailsRequest;

use App\Models\User;
use App\Models\Store;
use App\Models\StoreAbout;
use App\Models\StoreEcocash;
use App\Models\StoreDetail;
use App\Models\StoreContactDetail;
use App\Models\City;
use App\Models\Suburb;
use App\Models\Country; 
use App\Models\StoreType;
use App\Models\StoreDeliveryMethod;
use App\Models\StoreWarranty;
use Config;
use Validator;
use Response;
use Session;
use App\Http\Helpers\BcryptHelper;
class StoreSetupController extends BaseController
{
    
    public function details(Request $request) {

        $old_city_id = '';

        // check for city_id in session in case user goes back
        if (Session::has('storeDetail')) {
            $storeDetail = Session::get('storeDetail');
            $storeDetailAttr = $storeDetail->getAttributes();
            if($storeDetailAttr['city_id']) {
                $old_city_id = $storeDetailAttr['city_id'];
            }
        }

        // check if city is in old value
        if ($request->old('city')) {
            $old_city_id = $request->old('city');
        }

        $store_type  = $request->old('store_type');

        // 11 - Harare , if the city is Harare, set logistics to true to allow that delivery method.
        $logistics = false;
        if ( isset($old_city_id) && (int)$old_city_id == City::CITY_HARARE ) {
            $logistics = true;
        }

        $propertyOrVehicle = false;
        if ($store_type == Store::STORE_TYPE_VEHICLES || $store_type == Store::STORE_TYPE_PROPERTY) {
            $propertyOrVehicle = true;
        }
       
        $data = [
            'countries' => Config::get('storefronts.countries'),
            'cities'    => $this->cities(),
            'suburbs'   => $this->suburbs($old_city_id),
            'storefront_types' => $this->store_type(),
            'storefront_delivery_method' => $this->storefrontDeliveryMethods($logistics, $propertyOrVehicle),
            'step' => 1
        ];
        
        if ($request->session()->has('user')) {
            $user = $request->session()->get('user', null);
            $data['user'] = $user;
        }
        
        if ($request->session()->has('store')) {
            $store = $request->session()->get('store', null);
            $data['store'] = $store;
        }
        
        if ($request->session()->has('storeDetail')) {
            $storeDetail = $request->session()->get('storeDetail', null);
            $data['storeDetail'] = $storeDetail;
        }
        
        return view('ownerportal/store/details/index', $data);
    }

    private function store_type(){
        $store_type = StoreType::all();
        $store_type_data = [];
        foreach ($store_type as $type) {
            $store_type_data[$type->id]= $type->type;

        }

        return $store_type_data;
    }

    /**
     * Fetches the store delivery methods
     *
     * Only returns the logistics option if logistics is true,
     * depending on if the store is in Harare
     *
     * @param boolean $logistics
     * @param boolean $propertyOrVehicle
     * @return array $storefront_delivery_method
    */
    private function storefrontDeliveryMethods($logistics = false, $propertyOrVehicle = false){

        $delivery_method = StoreDeliveryMethod::all();
        $storefront_delivery_method = [];
        foreach ($delivery_method as $delivery) {
            $storefront_delivery_method[$delivery->id]= $delivery->method;
        }

        if($propertyOrVehicle || !$logistics) {
            unset( $storefront_delivery_method[Store::ECONET_LOGISTICS] ); // 1 - Use Econet Logistics
        }

        if($propertyOrVehicle) {
            unset( $storefront_delivery_method[Store::DELIVERY_COLLECT_IN_STORE] );
        }


        return $storefront_delivery_method;

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
   
    public function Uservalidate(Request $request) {
        $user_name = '+263'.\Request::get('username');
        $password = \Request::get('password');
        $rules =[
            'username' => 'required|integer|zim.phone',
            'password' => 'required',
            
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return Response::json([
                'success'=>false,
                'message'=>$validation->messages()->toArray(),
            ]);
        }else{
            $user = \App\Models\osclass\User::where('s_username', $user_name)->first();
            if($user){
                $security = new BcryptHelper();
                if($security->verify($password, $user->s_password)){
                    $user->s_password = null;
                    $user->pk_i_id = null;
                    $user->s_secret = null;
                    
                   return Response::json([
                            'success'=>true,
                            'data'=>$user,
                        ]);
                
                   
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

    public function ValidateNumber(Request $request) {
        $user_name = '+263'.\Request::get('username');
        
        $rules =[
            'username' => 'required|integer|zim.phone',
            
        ];
        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            return Response::json([
                'success'=>3,
                'message'=>"Please provide storefront number",
            ]);
        }else{
            $user = \App\Models\osclass\User::where('s_username', $user_name)->first();
            if($user){
                return Response::json([
                        'success'=>2,
                        'message'=>"Number already exist, please provide password",
                ]);
                
                
            }else{
                return Response::json([
                'success'=>1,
                'message'=>'User does not exist',
                ]);
            }
        }


    }

    public function updateDetails(UpdateStoreSetupDetailsRequest $request) {
        
        $input = $request->all(); 
        
        $user = $request->session()->get('user', new User());
        $store = $request->session()->get('store', new Store());
        $storeDetail = $request->session()->get('storeDetail', new StoreDetail());
        


        //User
        $user->username = $input['username'];
        $user->email = $input['email'];
        if (!empty($input['password'])) {
            $user->password = bcrypt($input['password']);
        }
        $request->session()->put('user', $user);    
        
        //Store
        $store->name = $input['store_name'];
        $store->slug = $input['store_slug'];
        $store->store_status_type_id = Store::STATUS_TYPE_PENDING_REOPEN;
        $store->store_type_id = $input['store_type'];
        $delivery = $input['store_delivery'];
        if ($input['store_type'] == Store::STORE_TYPE_VEHICLES || $input['store_type'] == Store::STORE_TYPE_PROPERTY) {
            $delivery = Store::DELIVERY_ARRANGE_WITH_SELLER;
        }
        $store->store_delivery_method_id = $delivery;

        $request->session()->put('store', $store);
        
        //StoreDetail
        $storeDetail->street_address_1 = $input['street_address_1'];
        //$storeDetail->street_address_2 = $input['street_address_2'];
        $storeDetail->suburb_id = $input['suburb'];
        $storeDetail->city_id = $input['city'];
        $country = Country::where('name', $input['country'])->first();
        if (isset($country)) {
            $storeDetail->country_id = $country->id;
        }
        $storeDetail->phone = $input['phone'];
        $storeDetail->email = $input['email'];
        if(($input['account_verifd'] == 'verified') && ($input['ownai_account'] == 'account_available')){
            $storeDetail->migrated = 1;
            $storeDetail->phone = $input['username_ownai'];
        }

        $storeDetail->location_lat = (float)$input['l1'];
        $storeDetail->location_lng = (float)$input['l2'];

        if($input['ownai_account'] == 'account_notavailable'){
            $security = new BcryptHelper();
            $ownai_user = $request->session()->get('ownai_user', new \App\Models\osclass\User());
            $ownai_user->dt_reg_date = date('Y-m-d h:i:s');
            $ownai_user->s_name = date('Y-m-d h:i:s');
            $ownai_user->s_username = '+263'.$input['phone'];
            $ownai_user->s_password = $security->hash($input['password']);
            $ownai_user->s_secret = $security->osc_genRandomPassword();
            $ownai_user->s_email = '+263'.$input['phone'].'@tengai.zw';
            $ownai_user->s_email_address = $input['email'];
            $ownai_user->s_phone_mobile = '+263'.$input['phone'];
            $ownai_user->b_company = 2;//$input['b_company']
            $ownai_user->b_email_enabled = 1;
            $ownai_user->b_sms_enabled = 1;
            $ownai_user->b_email_prompted = 1;
            $ownai_user->b_enabled = 1;  
            $ownai_user->b_active = 1;
            $storeDetail->migrated = 1;
            $request->session()->put('ownai_user', $ownai_user);
        }else{
            $number = '+263'.$input['phone'];
            $ownai_user = \App\Models\osclass\User::where('s_username', $number)->first();
            $ownai_user->s_email_address = $input['email'];
            $ownai_user->b_email_enabled = 1;
            $ownai_user->save();
        }
        $request->session()->put('storeDetail', $storeDetail);

        return redirect()->route("store.setup.contact-details");
    }
    
    public function contactDetails(Request $request) {
        
        $user = $request->session()->get('user', null);
        $store = $request->session()->get('store', null);
        $storeDetail = $request->session()->get('storeDetail', null);
        
        if (!is_null($user) && !is_null($store) && !is_null($storeDetail)) {

            $old_city_id = $request->old('city');
            
            $data = [
                'countries'         => Config::get('storefronts.countries'),
                'cities'            => $this->cities(),
                'suburbs'           => $this->suburbs($old_city_id),
                'storefront_types'  => $this->store_type(),
                'store'             => $store,
                'storeDetail'       => $storeDetail,
                'step'              => 2
            ];
            
            if ($request->session()->has('storeContactDetail')) {
                $data['storeContactDetail'] = $request->session()->get('storeContactDetail', null);
            }

            return view('ownerportal/store/contact-details/index', $data);
        }
        
        return redirect()->route("store.setup.details");
    }
    
    public function updateContactDetails(UpdateStoreSetupContactDetailsRequest $request) {
        
        $input = $request->all();
        
        $user = $request->session()->get('user', null);
        $store = $request->session()->get('store', null);
        $storeDetail = $request->session()->get('storeDetail', null);
        
        if (!is_null($user) && !is_null($store) && !is_null($storeDetail)) {
            
            $storeContactDetail = $request->session()->get('storeContactDetail', new StoreContactDetail());
            
            $storeContactDetail->firstname = $input['firstname'];
            $storeContactDetail->lastname = $input['lastname'];
            $storeContactDetail->street_address_1 = $input['street_address_1'];
            $storeContactDetail->street_address_2 = $input['street_address_2'];
            $storeContactDetail->suburb_id = $input['suburb'];
            $storeContactDetail->city_id = $input['city'];
            $country = Country::where('name', $input['country'])->first();
            if (isset($country)) {
                $storeContactDetail->country_id = $country->id;
            }


            $storeContactDetail->phone = (isset($input['phone'])) ? $input['phone'] : ''; // optional
            $storeContactDetail->email = $input['email'];
            
            $request->session()->put('storeContactDetail', $storeContactDetail);

            return redirect()->route("store.setup.payment-details");
        }
        
        return redirect()->route("store.setup.details");
    }
    
    public function paymentDetails(Request $request) {
        
        $user = $request->session()->get('user', null);
        $store = $request->session()->get('store', null);
        $storeDetail = $request->session()->get('storeDetail', null);
        $storeContactDetail = $request->session()->get('storeContactDetail', null);
        
        if (!is_null($user) && !is_null($store) && !is_null($storeDetail) && !is_null($storeContactDetail)) {
            
            $data = [
                'store' => $store,
                'storeDetail' => $storeDetail,
                'storeContactDetail' => $storeContactDetail,
                'cost' => StoreType::where('id', $store->store_type_id)->first(),
                'step' => 3
            ];
            
            $storePaymentDetail = $request->session()->get('storePaymentDetail', null);
            if (!is_null($storePaymentDetail)) {
                $data['storePaymentDetail'] = $storePaymentDetail;
            }

            return view('ownerportal/store/payment-details/index', $data);
        }
        
        return redirect()->route("store.setup.details");
    }
    
    public function updatePaymentDetails(UpdateStoreSetupPaymentDetailsRequest $request) {
        
        $input = $request->all(); 
                        
        $user = $request->session()->get('user', null);
        $store = $request->session()->get('store', null);
        $storeDetail = $request->session()->get('storeDetail', null);
        $storeContactDetail = $request->session()->get('storeContactDetail', null);
        
        if (!is_null($user) && !is_null($store) && !is_null($storeDetail) && !is_null($storeContactDetail)) {
            
            $storePaymentDetail = $request->session()->get('storePaymentDetail', new StoreEcocash());
            
            $storePaymentDetail->name = (isset($input['account_type']) && $input['account_type'] == 'merchant-acc') ? 'merchant-acc' : "subscriber-acc";
            $storePaymentDetail->number = $input['number'];
            $request->session()->put('storePaymentDetail', $storePaymentDetail);
            
            //Finally we save the models and clear them from the session
            $this->createStoreOwner($request->session());

            return view('ownerportal/store/confirm/index', []);
        }
        
        return redirect()->route("store.setup.details");
    }
    
    public function createStoreOwner($session) {
        
        $user = $session->pull('user', null);
        $store = $session->pull('store', null);
        $storeDetail = $session->pull('storeDetail', null);
        $storeContactDetail = $session->pull('storeContactDetail', null);
        $storePaymentDetail = $session->pull('storePaymentDetail', null);
        $ownai_user = $session->pull('ownai_user', null);
        
        if (is_null($user) || is_null($store) || is_null($storeDetail) || is_null($storeContactDetail) 
            || is_null($storePaymentDetail)) {
            return redirect()->route("store.setup.details");    
        }
        
        //User
        $user->save();
        
        //RoleUser
        $user->assignRole('storeowner');
        $user->save();
        
        //Store
        $store->save();
        
        //StoreUser
        $user->stores()->attach($store->id);
        
        //StoreDetail
        $storeDetail->store_id = $store->id;
        $storeDetail->save();
        
        //StoreContactDetail
        $storeContactDetail->store_id = $store->id;
        $storeContactDetail->save();
      
        //StoreEcocash
        // should be optional for the trial period
        $storePaymentDetail->store_id = $store->id;
        $storePaymentDetail->save();

        //ownai user
        if(!is_null($ownai_user)){
            $ownai_user->s_name = $storeContactDetail->firstname.' '.$storeContactDetail->lastname;
            $ownai_user->save();
        }

        // default about
        $about = new StoreAbout();
        $about->exerpt = 'Welcome to ' . $store->name  . '. Feel free to browse through our store.';
        $about->description = '<p>Thanks for visiting us. Please contact us should you require any assistance.</p>';
        $about->store_id = $store->id;
        $about->save();

        // default warranty
        $warranty = new StoreWarranty();
        $warranty->warranty = '<p>Please contact us regarding our warranty policy.</p>';
        $warranty->store_id = $store->id;
        $warranty->save();

        $this->sendmail($store, $user->username);
    }

    private function sendmail($store, $username){
        \Mail::send('backoffice.admin.stores.mail', ['store'=>$store, 'username'=>$username], function ($message) use ($store){
            $message->to($store->contactDetails->email)->subject('Ownai.co.zw | Storefront Registration');
        });
    }
}
