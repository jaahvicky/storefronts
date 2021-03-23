<?php

namespace App\Http\Helpers;

use DB;
// use App\Facades\SortFilterHelper;
use App\Models\Product;
use App\Models\StoreType;
use App\Models\StoreStatusType;
use App\Models\AttributeVariant;
use App\Models\Category;
use App\Models\AttributeValue;
use App\Models\ProductStatusType;
use App\Models\ProductModerationType;
use App\Models\Order;
use App\Models\DeliveryStatus;
use App\Models\Store;
use Auth;
use App\Models\OrderCancelOption;
use App\Models\OrderItem;
use App\Models\osclass\Items;
use App\Models\osclass\ItemResource;
use App\Models\OwnaiConfig;

class LookupHelper {
    protected $tableSortFilterTag = 'stores';
    protected $shoppingcartSessionTag = 'storefrontshopcart';

	
    public function getStoreStatusTypes() {
       // $types = DB::table('store_status_types')->groupBy('store_status_types.label')->orderBy('id', 'asc');  
        $types = StoreStatusType::groupBy('label')->orderBy('id', 'asc');               
        return $types->get();
    }


    // To do : add order status filter

    public function getOrderStatus() {
        // Pending First
        $order_status = DeliveryStatus::all();
        return $order_status;
    }
    public function generateRecoverLink(){
        $ownai = OwnaiConfig::first();
        return (string) $ownai->url.'user/recover';
    }
    public function generateActivateLink(){
        $ownai = OwnaiConfig::first();
        return (string) $ownai->url.'33-activate';
    }

    //get ownai image

    public function getImage($images){
       
        if(file_exists("storage/".$images)){
             return  (string) asset(\Storage::url($images));
        }else{
            
            $img = explode('.', $images);

            $image = ItemResource::where('s_name', $img[0])->first();
            $ownai = OwnaiConfig::first();

            if($image){
                $img_s = (string) $ownai->url.$image->s_path.$image->pk_i_id."_thumbnail.".$image->s_extension;
                if(LookupHelper::remoteFileExists($img_s)){
                    return (string) $img_s;
                 }else{
                 return (string) asset('images/samples/no-photo-available.png'); 
                 }
               
            }else{
                return (string) asset('images/samples/no-photo-available.png');
            }
        }

       
    }

    public function Imagecover($images){
        $mg = explode('/', $images);
        if(array_key_exists('2', $mg)){
             if(file_exists("storage/".$mg[2])){
             return (string) asset($images);
            }else{
                $img = explode('.', $mg[2]);
                $image = ItemResource::where('s_name', $img[0])->first();
                $ownai = OwnaiConfig::first();
                if($image){
                    $img_s = (string) $ownai->url.$image->s_path.$image->pk_i_id."_thumbnail.".$image->s_extension;
                    if(LookupHelper::remoteFileExists($img_s)){
                        return (string) $img_s;
                     }else{
                      return (string) asset('images/samples/no-photo-available.png'); 
                     }
                }else{
                    return (string) asset('images/samples/no-photo-available.png');
                }
            }
        }else{
             return (string) asset('images/samples/no-photo-available.png');
        }
       
      
    }

    public function remoteFileExists($url) {
        $curl = curl_init($url);

        //don't fetch the actual page, you only want to check the connection is ok
        curl_setopt($curl, CURLOPT_NOBODY, true);

        //do request
        $result = curl_exec($curl);

        $ret = false;

        //if request did not fail
        if ($result !== false) {
            //if request was ok, check response code
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  

            if ($statusCode == 200) {
                $ret = true;   
            }
        }

        curl_close($curl);

        return $ret;
    }

    public function getVariant($id){
        $data = AttributeVariant::where('id', $id)->first();
        return $data->name;
    }

    public function getproductsCart($slug){
        $session_tag = $this->shoppingcartSessionTag.'_'. $slug;
        $data = \ShoppingCartHelper::getShoppingCart($session_tag);
        if(array_key_exists('products', $data)){
             return $data;
        }else{
            return [];
        }
        
    }
    public function getproductsCarttotal($slug){ 
        $session_tag = $this->shoppingcartSessionTag.'_'. $slug;
        $data = \ShoppingCartHelper::getShoppingCart($session_tag);
        if(array_key_exists('products', $data)){
             return sizeof($data['products']);
        }else{
            return 0;
        }
    }
    public function getproductDetails($id){
        $data = Product::where('id', $id)->first();
        return $data;
    }

    public function checkbalance($store){

        if($store->approved_at == NULL){

            return false;
        }else{
            $activated_date = date("d", strtotime($store->approved_at));
            $currentday = date('d');
            $days = ((int)$currentday - (int)$activated_date);
            if($days > 3  && empty($store->billing)){
                return true;
            }else{
                return false;
            }
        }

    }

    public function paymentstatusfiltercheck($store){
         $filters = \SortFilterHelper::getFilters($this->tableSortFilterTag);
        $status = null;
        $billing = $store->billing;
        //store free period 
        $datetime1 = date_create($store->approved_at);
        $datetime2 = date_create(date('Y-m-d h:m:s'));
        $interval = date_diff($datetime1, $datetime2);
        $trial_period = $interval->days;

        if(key_exists('storeStatusPayment', $filters)){
            $status = $filters['storeStatusPayment'][0];
           
        }
        if($status != null && $status !='any'){
            if(!empty($billing) && $billing->status != $status){
                return false;
                
            }
            elseif($status != 'pending' && $trial_period < 30 )
            {
                return true;
            }
            elseif($status == 'pending' && $trial_period < 30)
            {
                return false;
            }
            elseif($status != 'pending' && $trial_period > 30)
            {
                return false;
            }else{
                return true;
            }
        }
        else
        {
            return true;
        }
    }
    public function checkStoreBalance($store){
        $store_date = date_create($store->approved_at);
        $now = date_create(date('Y-m-d h:m:s'));
        $interval = date_diff($store_date, $now);
        $trial_period = $interval->days;

        $now->modify('last day of this month');
        $duedate = $now->format('d M Y');
        $billing = $store->billing;
        $cost_type = StoreType::where('id', $store->store_type_id)->first();
        $return_data = [];
        if($trial_period < 30){
            $return_data=(object)['status'=>false, 'amount'=>$cost_type->amount, 'message'=> 'Still on trial period '. (30 - $trial_period). ' days remaining'];
           
        }else{
            if(!empty($billing) && $billing->status != 'pending'){
               
                $return_data=(object)['status'=>false, 'amount'=>$cost_type->amount, 'message'=> 'Paid' ];    
            }elseif(!empty($billing) && $billing->status == 'pending'){
               
                $return_data=(object)['status'=>false, 'amount'=>$cost_type->amount, 'message'=> 'Due on: '. $duedate ];    
            }else{
                $return_data=(object)['status'=>true, 'amount'=>$cost_type->amount, 'message'=> 'Due on: '. $duedate ];
            }
            
        }

        return $return_data;
    }
    public function checkpaymentstatus($store)
    {
        $filters = \SortFilterHelper::getFilters($this->tableSortFilterTag);
        $status = null;
        if (key_exists('storeStatusPayment', $filters)) {
            $status = $filters['storeStatusPayment'][0];

        }

        $timestamp = strtotime(date('Y-m-d h:m:s'));
        $daysRemaining = (int)date('t', $timestamp) - (int)date('j', $timestamp);
        //store free period 
        $datetime1 = date_create($store->approved_at);
        $datetime2 = date_create(date('Y-m-d h:m:s'));
        $interval = date_diff($datetime1, $datetime2);
        $trial_period = $interval->days;

        $billing = $store->billing;

        if ($status != null && $status != 'any') {
            if (!empty($billing)) {
                if ($billing->status == 'pending') {
                    if ($daysRemaining > 1) {
                        return 'Late Payment ' . $daysRemaining . ' days remaining';
                    } else {
                        return 'Late Payment ' . $daysRemaining . ' day remaining';
                    }
                } else {

                    return 'Paid';
                }
            } else {
                if ($trial_period < 30) {
                    return 'Still on trial period ' . (30 - $trial_period) . ' days remaining';
                } elseif ($daysRemaining > 1) {
                    return 'Late Payment ' . $daysRemaining . ' days remaining';
                } else {
                    return 'Late Payment ' . $daysRemaining . ' day remaining';
                }
            }
        } else {
            if (!empty($billing)) {
                if ($billing->status == 'pending') {
                    if ($daysRemaining > 1) {
                        return 'Late Payment ' . $daysRemaining . ' days remaining';
                    } else {
                        return 'Late Payment ' . $daysRemaining . ' day remaining';
                    }
                } else {
                    return 'Paid';
                }
            } else {
                if ($trial_period < 30) {
                    return 'Still on trial period ' . (30 - $trial_period) . ' days remaining';
                } elseif ($daysRemaining > 1) {
                    return 'Late Payment ' . $daysRemaining . ' days remaining';
                } else {
                    return 'Late Payment ' . $daysRemaining . ' day remaining';
                }
            }
        }
    }

    public function getCategories() {
        $categories =Category::orderBy('parent_id', 'asc')->get();
        $tmp = [];
         
        //Get 1st level
        foreach($categories As $i => $category) {
            if ($category->parent_id == NULL) {
                $tmp[$category->id] = [];
                $tmp[$category->id]['record'] = $category;
                unset($categories[$i]);
            }
        }
        
        //Get 2nd Level
        foreach($categories As $i => $category) {
            if (isset($tmp[$category->parent_id])) {
                $tmp[$category->parent_id]['children'][$category->id]['record'] = $category;
                unset($categories[$i]);
            }
        }
        
        //Get 3rd Level 
        foreach($categories As $i => $category) {
            foreach($tmp As $l1_cat_id => $fields) {
                if ( isset($fields['children'][$category->parent_id])) {
                    $tmp[$l1_cat_id]['children'][$category->parent_id]['children'][$category->id]['record'] = $category;
                }
            }
        }
        
        return $tmp;
    }
    
    public function getProductStatusTypes() {
        $types =ProductStatusType::groupBy('name')->orderBy('name', 'asc');                
        return $types->get();
    }
    
    public function getProductModerationTypes() {
        $types = ProductModerationType::groupBy('name')->orderBy('name', 'asc');                
        return $types->get();
    }
    
    public function getCategoriesForCategory($category_id) {
        
        $catString = "";
        
        $category = Category::where('id', $category_id)->first();
        if ($category) {
            $catString .= $category->name;
            
            if ($category->parent_id) {    
                $parent = Category::where('id', $category->parent_id)->first();
                
                if ($parent) {
                    $catString .= ", ".$parent->name;
                    
                    if ($parent->parent_id) {
                        $grandparent = Category::where('id', $parent->parent_id)->first();    
                        
                        if ($grandparent) {
                            $catString .= ", ".$grandparent->name;
                        }
                    }
                }
            }
        }
        return $catString;
    }

    public function getOrderTotal(){
        $user = Auth::user();
        $store = Store::where('id', $user->id)->first();
        if($store){
            $order = Order::where('store_id', $store->id)->count();
            return $order;
        }

    }

    public function OrderItemsTotal($id){
        if($id){
            return OrderItem::where('orders_id', $id)->count();
        }
    }

    // comment out
    public function getOrderDeliveryStatus(){
        $status = new \StdClass();
        $user = Auth::user();
        $store = Store::where('id', $user->id)->first();
        if($store){
            $pending = Order::where('store_id', $store->id)->where('delivery_status_id', 1)->count();
            $inprogress = Order::where('store_id', $store->id)->whereIn('delivery_status_id', [2, 4, 5])->count();
            $cancel = Order::where('store_id', $store->id)->where('delivery_status_id', 6)->count();
            $complete = Order::where('store_id', $store->id)->where('delivery_status_id', 3)->count();
            $status->pending = $pending;
            $status->inprogress = $inprogress;
            $status->cancel = $cancel;
            $status->complete = $complete;
           
        }else{
            $status->pending = 0;
            $status->inprogress = 0;
            $status->cancel = 0;
            $status->complete = 0;
        }

        return $status;
    }

    public function getAtrributeChild(){
        $attributes = [];
        $child = AttributeValue::whereNotNull('parent_id')->get();
        foreach ($child as $attr) {
            $attributes[]=[
                'id'=>$attr->id,
                'parent_id'=> $attr->parent_id,
                'value'=>$attr->value,
                'parent_value'=> $attr->Attrparent->value,
            ];
        }

        return $attributes;
    }

    public function _send_sms($destNumber, $clientCorrelator, $message)
    {
       

        
       // writeto file
        LookupHelper::writeSMS(array($destNumber => $message));
        try {
             $url         = 'http://192.168.101.218:8081/smsgateway/rest/sms/send';
       
             //set POST variables
            $sourceAddress = "26312345";

           
            $data        = array("sourceAddress"     => "$sourceAddress",
                "destinationNumber" => "$destNumber",
                "notificationUrl"   => urlencode('http://localhost/econet/sms.html'),
                "message"           => ("$message"),
                "clientCorrelator"  => "$clientCorrelator"
            );
            $data_string = json_encode($data);

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER,
                array(
                    'Content-Type: application/json',
                    'Content-Length: '.strlen($data_string))
            );

            //execute post
            $result = curl_exec($ch);

            //close connection
            curl_close($ch);

            return $result;
        }catch(\Exception $e){
            return $e->getMessage();
        }
       
        
       
    }

    public function writeSMS($data_y){
        $storefront_path = public_path().'/uploads';
        $file_name = $storefront_path.'/sent_sms.log';
        $data = json_encode($data_y);
        if(!file_exists($file_name)){
            $write = fopen($file_name, 'w');
            fwrite($write,  $data);
            fclose($write);
        }else{
            $write = fopen($file_name, 'a');
            fwrite($write,  $data);
            fclose($write);
        } 
    }

    public static function generateRandomString($length = 6) {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function generateInvoiceNum(){
        $invoicenumber = null;
        $status = true;
        while ( $status == true) {
           $string = LookupHelper::generateRandomString();
           $order = Order::where('invoice_number',  $string)->first();
           if(!$order){
                $status = false;
                $invoicenumber = $string;
           }
        }

        return $invoicenumber;
    }

    /**
     * @param  array optional $ids Specify the options with specific ids to return
     * @return array The id and option of all or specific
     */
    public static function getOrderCancelOptions($ids = [])
    {

        $cancel_options = OrderCancelOption::get(['id', 'options'])->toArray();

        if ($ids) {
            foreach ($cancel_options as $index => $value) {
                // if the current option id is not in the ids array
                if (!in_array($value['id'], $ids)) {
                    unset($cancel_options[$index]);
                }
            }
        }

        return $cancel_options;
    }
    
    public static function http($url, $data){
        $data = http_build_query($data);
        $options = [
            'http'=>[
            'header'=>"Content-type: application/x-www-form-urlencoded\r\n"
                . "Content-Length: " . strlen($data) . "\r\n",//'Content-type: application/x-www-form-urlencoded\r\n',
            'method'=>'POST',
            'content'=>$data,
            ],
        ];
        $content =stream_context_create($options);
        $results = file_get_contents($url, false, $content);
        
        return $results;
    }
}
