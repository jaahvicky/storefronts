<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use Auth;
use Hash;
use App\Models\User;
use App\Models\StoreContactDetail;
use App\Models\StoreDetail;
use App\Models\Order;
use App\Models\DeliveryStatus;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Checks if the password enterered matches the currently logged in users password
        Validator::extend('auth', function($attribute, $value, $parameters, $validator) {
            return (Hash::check($value, Auth::user()->password));
        });
        
        //Checks if store is accessible
        Validator::extend('store.access', function($attribute, $value, $parameters, $validator) {
            $user = User::where('username', $value)->first();
            if (!is_null($user) && $user->hasRole('storeowner')) {
                $store = $user->stores()->with('status')->first();
                if (!is_null($store) && ($store->status->tag == "pending-open" || $store->status->tag == "rejected")) {
                    return false;
                }
            }
            return true;
        });
        
        //Checks if zim phone is valid
        Validator::extend('zim.phone', function($attribute, $value, $parameters, $validator) {
            return preg_match("/^\(?([7][7|8]\d{1})\)?[- ]?(\d{3})[- ]?(\d{3})$/", $value);
        });

        //Checks if zim phone is valid
        Validator::extend('whole.number', function($attribute, $value, $parameters, $validator) {
            return preg_match("/^[1-9][0-9]*$/", $value);
            
        });
        //Checks if email address  is unique for each store
        Validator::extend('email.store.unique', function($attribute, $value, $parameters, $validator) {
           
            $email = StoreDetail::where('email',  $value)->first();
            $email_too = StoreContactDetail::where('email',  $value)->first();
            
               
                if($email){
                    return false;
                }elseif($email_too){
                     return false;
                }else{
                    return true;
                }
            
        });

         //Checks if email address  is unique for each store
        Validator::extend('email.store.unique.auth', function($attribute, $value, $parameters, $validator) {
            $store = Auth::user();
            $emails =[];  
            $emails[] = $store->stores()->first()->contactDetails->email;
            $emails[] = $store->stores()->first()->details->email;
            $email = StoreDetail::where('email',  $value)->whereNotIn('email', $emails)->first();
            $email_too = StoreContactDetail::where('email',  $value)->whereNotIn('email', $emails)->first();
            
               
                if($email){
                    return false;
                }elseif($email_too){
                     return false;
                }else{
                    return true;
                }
            
        });

        //Checks if phone  is unique for each store
        Validator::extend('phone.store.unique', function($attribute, $value, $parameters, $validator) {
            $phone = StoreDetail::where('phone',  $value)->first();
            $phone_too = StoreContactDetail::where('phone',  $value)->first();
            
                
            if($phone){
                return false;
            }elseif($phone_too){
                return false;
            }else{
                return true;
            }

            
        });
        //Checks if phone  is unique for each store
        Validator::extend('phone.store.unique.auth', function($attribute, $value, $parameters, $validator) {
            $store = Auth::user();
            $phones =[];
            $phones[] = $store->stores()->first()->contactDetails->phone;
            $phones[] = $store->stores()->first()->details->phone;  
            $phone = StoreDetail::where('phone',  $value)->whereNotIn('phone', $phones)->first();
            $phone_too = StoreContactDetail::where('phone',  $value)->whereNotIn('phone', $phones)->first();
            
            if($phone){
                return false;
            }elseif($phone_too){
                return false;
            }else{
                return true;
            }

            
        });
        //Checks if order id is valid 
        Validator::extend('order.valid', function($attribute, $value, $parameters, $validator) {
               $data =Order::where('id', $value)->first();
               if($data){
                    return true;
               }else{
                    return false;
               }

        });
        //Checks if delivery status is valid
        Validator::extend('deliverystatus.valid', function($attribute, $value, $parameters, $validator) {
               $data =DeliveryStatus::where('id', $value)->first();
               if($data){
                    return true;
               }else{
                    return false;
               }

        });
        


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('sortfilterHelper', 'App\Http\Helpers\SortFilterHelper');
        $this->app->bind('ShoppingCartHelper', 'App\Http\Helpers\ShoppingCartHelper');
    }
}
