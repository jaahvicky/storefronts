<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use App\Http\Requests\BackOffice\UpdateAccountRequest;
use App\Http\Requests\BackOffice\UpdateAccountUserRequest;

use Illuminate\Support\Facades\Auth;

use App\Models\City;
use App\Models\Suburb;

use App\Models\Store;
use App\Models\StoreContactDetail;
use App\Models\Country;
use App\Models\StorePreference;
use Validator;
use Config;

class AccountController extends BaseController
{
    
    
    public function __construct() {
        //parent::__construct();
        \ViewHelper::setPageDetails('Storefronts | Account', 'Account', 'this is a small description');
        \ViewHelper::setActiveNav('account');
    }
    
    public function index(Request $request) {

        $store = Auth::user()->stores()->with('details')->with('contactDetails')->first();

        $old_city_id = $request->old('city');

        // if edit was not done, get the current id
        if (!$old_city_id) {
            $old_city_id = $store->contactDetails->city_id;
        }

        $data = [
            'countries' => Config::get('storefronts.countries'),
            'cities'    => $this->cities(),
            'suburbs'   => $this->suburbs($old_city_id),
            'storefront_types' => Config::get('storefronts.storefront-types')
        ];
        
        if (!is_null($store)) {

            $data['store'] = $store;
            return view('backoffice/account/index', $data);
        }
        
        $request->session()->flash('alert-error', 'There is no store associated with this account.');
        return redirect()->route("admin.dashboard");
    }

    public function update(UpdateAccountRequest $request) {
        
        $inputs = $request->all();
        
        $store = Store::where('id', $inputs['store_id'])->first();
        if (isset($store)) {
             $rules =[
                    'phone' => 'required|phone.store.unique.auth',
                    'email' => 'required|email.store.unique.auth',
            
            ];
           $validation = Validator::make($request->all(), $rules);
            if ($validation->fails()) {
               
                return redirect()->back()->withInput()->withErrors($validation->messages()->toArray());
            }else{
                 $contactDetails = (isset($store->contactDetails)) ? $store->contactDetails : new StoreContactDetail();
                $preferences = (isset($store->preferences)) ? $store->preferences : new StorePreference();
                
                //store
                $store->save();
                
                //store - store contact details
                $contactDetails->firstname = $inputs['firstname'];
                $contactDetails->lastname = $inputs['lastname'];
                $contactDetails->street_address_1 = $inputs['street_address_1'];
                $contactDetails->street_address_2 = $inputs['street_address_2'];
                $contactDetails->suburb_id = $inputs['suburb'];
                $contactDetails->city_id = $inputs['city'];
                $country = Country::where('name', $inputs['country'])->first();
                if (isset($country)) {
                    $contactDetails->country_id = $country->id;
                }
                $contactDetails->phone = $inputs['phone'];
                $contactDetails->email = $inputs['email'];
                $contactDetails->store_id = $store->id;
                $contactDetails->save();
                
                //store - store preferences
                $preferences->notification_order_sms = isset($inputs['preference_sms']) ? $inputs['preference_sms'] : false;
                $preferences->notification_order_email = isset($inputs['preference_email']) ? $inputs['preference_email'] : false;
                $preferences->store_id = $store->id;
                $preferences->save();
                
                $request->session()->flash('alert-success', 'Account was successfully updated.');
                return redirect()->route("admin.account");
            }
           
        }
        
        $request->session()->flash('alert-error', 'There is no store associated with this account.');
        return redirect()->route("admin.dashboard");
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

    public function updateUser(UpdateAccountUserRequest $request) {
        
        $inputs = $request->all();
        
        $user = Auth::user();
        $user->password = bcrypt($inputs['new_password']);
        $user->save();
        
        $request->session()->flash('alert-success', 'Password was successfully updated.');
        return redirect()->route("admin.account");
    }

}

