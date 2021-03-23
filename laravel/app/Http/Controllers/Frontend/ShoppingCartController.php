<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use View;
use App\Http\Requests;
use App\Models\Store;
use App\Models\Product;
use App\Facades\ShoppingCartHelper;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Logistics;
use App\Facades\LookupHelper;
use App\Http\Helpers\EcocashHelper;
use Response;
use URL;
use DB;
class ShoppingCartController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $shoppingcartSessionTag = 'storefrontshopcart';

    public function index($slug)
    {
       $store = Store::where('slug', '=',$slug)->first();
       if(!$store){
        return redirect('/store/'.$slug);
       }else{
            //appearance 
            $appearance =  DB::table('store_appearance')->where('store_id', $store->id)->first();
            View::share('appearance', $appearance);
            View::share('store', $store);
            return view('frontend.shoppingcart.index');      
       }
        
    }

    public function updatecart(Request $request)
    {
        $inputs = $request->all();
        $product = Product::where('id', $inputs['id'])->first();
        $this->setCart($inputs, $product->store->slug);
        
        return redirect('/shopping/'.$product->store->slug.'/shoppingcart');
        
    }

    public function modelremove($id){
        $product = Product::where('id', $id)->first();
        View::share('product', $product);
        return view('frontend.shoppingcart.modal.remove');
    }

    public function quantityUpdate($id, $quantity){
        $key = 'products';  
        $product_single = Product::where('id', $id)->first(); 
        $session_tag = $this->shoppingcartSessionTag.'_'.$product_single->store->slug; 
        $cart = \ShoppingCartHelper::getShoppingCart($session_tag);
        foreach ($cart as  $product) {
            for ($i=0; $i < sizeof($product); $i++) { 
               if($product[$i]['product_id'] == $id){
                    $cart[$key][$i]['quantity'] = $quantity;
                }
            }
        }
        ShoppingCartHelper::setTag($session_tag);
        ShoppingCartHelper::updateCartSession($cart);
        $product = Product::where('id', $id)->first();
        return redirect('/shopping/'.$product->store->slug.'/shoppingcart');
    }

    public function remove(Request $request){
        $inputs = $request->all();
        $product = Product::where('id', $inputs['id'])->first();
        $this->unsetCart($product->id);
        return redirect('/shopping/'.$product->store->slug.'/shoppingcart');
    }


    private function unsetCart($id){
        $key = 'products';
        $product_single = Product::where('id', $id)->first(); 
        $session_tag = $this->shoppingcartSessionTag.'_'.$product_single->store->slug;       
        $cart = \ShoppingCartHelper::getShoppingCart($session_tag);
        foreach ($cart as  $product) {
            for ($i=0; $i < sizeof($product); $i++) { 
               if($product[$i]['product_id'] == $id){
                    unset($cart[$key][$i]);
                }
            }
        }
        ShoppingCartHelper::setTag($session_tag);
        ShoppingCartHelper::updateCartSession($cart);
    }
    private function setCart($inputs, $slug){
        $key = 'products';  
        $session_tag = $this->shoppingcartSessionTag.'_'.$slug;    
        $cart = \ShoppingCartHelper::getShoppingCart($session_tag);
        $status = false;
         foreach ($cart as  $product) {
            for ($i=0; $i < sizeof($product); $i++) { 
               if($product[$i]['product_id'] == $inputs['id']){
                    $cart[$key][$i]['variant_1'] = (array_key_exists('variant_1', $inputs) ? $inputs['variant_1'] : '');
                    $cart[$key][$i]['variant_2'] = (array_key_exists('variant_2', $inputs) ? $inputs['variant_2'] : '');
                    $cart[$key][$i]['quantity'] = $inputs['quantity'];
                    $status = true;
                }
            }
         }
         if(empty($cart)){
            $cart = [$key => []];
         }
         if($status == false){
            array_push($cart[$key], [
                'product_id' => $inputs['id'],
                'variant_1'=> (array_key_exists('variant_1', $inputs) ? $inputs['variant_1'] : ''),
                'variant_2' => (array_key_exists('variant_2', $inputs) ? $inputs['variant_2'] : ''),
                'quantity' => $inputs['quantity'],
                ]);
         }

        ShoppingCartHelper::setTag($session_tag);
        //ShoppingCartHelper::forgetShoppingCart();
        ShoppingCartHelper::updateCartSession($cart);

    }

    private function getCarts($slug){
        $session_tag = $this->shoppingcartSessionTag.'_'.$slug; 
        return  \ShoppingCartHelper::getShoppingCart($session_tag);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $inputs = $request->all();
       
        $store = Store::where('id', '=',$inputs['store_id'])->first();
        return redirect('/store/'.$store->slug);
    }

    public function PostDetails(Request $request){
        $inputs = $request->all();
        
       $validator = $this->validate($request, [
            'store_id' => 'required',
            'firstname' => 'required|max:255|min:2',
            'lastname' => 'required|max:255|min:2',
            'contact_number' => 'required|numeric',
            'email' => 'required|email',
            'home_address'=> 'required'
        ]);
      
 
        $store = Store::where('id', '=',$inputs['store_id'])->first();
        if (!empty($validator)) {
            return redirect('shopping/'.$store->slug.'/details')
                        ->withErrors($validator)
                        ->withInput($inputs);
        }else{
             $total = 0;
            foreach (LookupHelper::getproductsCart($store->slug) as $products){
                for($p = 0; $p < sizeOf($products); $p++){
                    $product = LookupHelper::getproductDetails($products[$p]['product_id']); 
                    $product->price = $product->price * (int)$products[$p]['quantity'];
                    $total += $product->price;
                                            
                }
            }
            $order = $request->session()->get('order', new Order());
            $order->store_id = $inputs['store_id'];
            $order->buyer_firstname = $inputs['firstname'];
            $order->buyer_lastname = $inputs['lastname'];
            $order->buyer_address = $inputs['home_address'];
            $order->buyer_email = $inputs['email'];
            $order->buyer_phone =$inputs['contact_number'];
            $order->payment_status = 'pending';
            $order->amount = ($total/100) + (int)$inputs['delivery_cost'];
            $order->response_data = json_encode([]);
            $order->invoice_number = time();
            $order->delivery_status_id = 1;
            $request->session()->put('order', $order);
            //for session purpose
            $request->session()->put('delivery_cost',(int)$inputs['delivery_cost']);
            return redirect('/shopping/'.$store->slug.'/order');
        }

       
    }

    public function PlaceOrder($slug, Request $request){
        $store = Store::where('slug', '=',$slug)->first();
        $cart_data = $this->getCarts($store->slug);

        
        if(!array_key_exists('products', $cart_data)){
            $request->session()->flash('alert-warning', 'Please add items on your shopping cart.');
            return redirect('/shopping/'.$slug.'/shoppingcart');
        }
        if($store->deliveryMethods->id == Store::ECONET_LOGISTICS){
            View::share('store', $store);
            View::share('delivery_cost',  $request->session()->get('delivery_cost'));
            View::share('step', 2);
            return view('frontend.shoppingcart.placeorder');
        }else{
            $invoicenum = $this->SaveOrder($request,true);
            return redirect('/shopping/'.$slug.'/order/'.$invoicenum);
           
        }
        
    }

    public function Paymodel($slug, Request $request){
        $store = Store::where('slug', '=',$slug)->first();
        $total = 0;
        foreach (LookupHelper::getproductsCart($store->slug) as $products){
            for($p = 0; $p < sizeOf($products); $p++){
                $product = LookupHelper::getproductDetails($products[$p]['product_id']); 
                $product->price = $product->price * (int)$products[$p]['quantity'];
                $total += $product->price;
                                        
            }
        }
        $delivery_cost = $request->session()->get('delivery_cost');
        View::share('delivery_cost', $delivery_cost);                 
        View::share('amount', $total);
        View::share('store', $store);
        return view('frontend.shoppingcart.modal');
    }

    public function StoreOder($slug, Request $request){
        $store = Store::where('slug', '=',$slug)->first();

        if(!$store){
            View::share('store', $store);
            \App::abort(404);
        }
         $cart_data = $this->getCarts($store->slug);
        if(!array_key_exists('products', $cart_data)){
            $request->session()->flash('alert-warning', 'Please add items on your shopping cart.');
            return redirect('/shopping/'.$slug.'/shoppingcart');
        }
        $order = $request->session()->get('order', null);
        if(empty($order)){
             $request->session()->flash('alert-warning', 'Please provide contact information.');
             return redirect('/shopping/'.$slug.'/details');
        }else{
             $invoicenum = $this->SaveOrder($request,true);
             return redirect('/shopping/'.$slug.'/order/'.$invoicenum);
        }
    }
    public function MakePayment($slug, Request $request){
        $store = Store::where('slug', '=',$slug)->first();
        $cart_data = $this->getCarts($store->slug);
        if(!array_key_exists('products', $cart_data)){
            return Response::json(['success' => false, 'error'=>'items not found']);
        }
        
        if(!$store){
            return Response::json(['success' => false, 'error'=>'invalid store']);
        }
        $order = $request->session()->get('order', null);
        if(empty($order)){
             return Response::json(['success' => false, 'error'=>'invalid order']);
        }else{
           $payment = new EcocashHelper();
           $reposnse = $payment->orderExecute($order);
           if($reposnse['status'] == false){
             return Response::json(['success' => false, 'error'=>'transaction required data incomplete']);
           }else{
            
            $order->response_data = $reposnse['response_data'];
            $order->invoice_number = $reposnse['correlator'];
            $request->session()->put('order', $order);
            return Response::json(['success' => true, 'order'=>$order, 'reposnse'=>$reposnse]);  
           }
           
        }
        
    }
    public function CheckPayment($slug, Request $request){
        $inputs = $request->all();
        $correlator = $inputs['correlator'];
        $store = Store::where('slug', '=',$slug)->first();
        $cart_data = $this->getCarts($store->slug);
        if(!array_key_exists('products', $cart_data)){
            return Response::json(['success' => false, 'error'=>'items not found']);
        }
        
        if(!$store){
            return Response::json(['success' => false, 'error'=>'invalid store']);
        }
        $order = $request->session()->get('order', null);
        if(empty($order)){
             return Response::json(['success' => false, 'error'=>'invalid order']);
        }else{
           $update = new EcocashHelper();
           $reposnse = $update->getOrderTransactionStatus($order);
          
           if($reposnse->status == false){
             return Response::json(['success' => false, 'error'=>'transaction required data incomplete']);
           }else{
                if($reposnse->data->transactionOperationStatus == 'COMPLETED'){
                    //run booking
                    $data = $this->bookService($store, $order, $request);
                    $this->SaveOrder($request,false);
                    
                    return Response::json(['success' => true, 'reposnse'=>$reposnse,'booking'=>$data, 'url'=> URL::route('shopping.details.order',['slug' => $store->slug, 'corrector'=>$order->invoice_number])]);
                }
                return Response::json(['success' => false, 'reposnse'=>$reposnse,'url'=> URL::route('shopping.details.order',['slug' => $store->slug, 'corrector'=>$order->invoice_number])]);
           }
           
        }
        
    }
    private function bookService($store, $order, Request $request){

        $logistic = Logistics::where('method', 'bookservice')->first();
        if($logistic){
            $itemsdesc = '';
            $total = 0;
            foreach (LookupHelper::getproductsCart($store->slug) as $products){
                for($p = 0; $p < sizeOf($products); $p++){
                    $product = LookupHelper::getproductDetails($products[$p]['product_id']);
                    $itemsdesc .=' ('.(int)$products[$p]['quantity'].') '.$product->title; 
                    $product->price = $product->price * (int)$products[$p]['quantity'];
                    
                    $total += $product->price;
                }
            }
            $data=[
                    'token'=>$logistic->token,
                    'pAddr' => $store->details->street_address_1,
                    'dAddr' => $order->buyer_address,
                    'vehicle'=> 'car',
                    'multidrop'=> 0,
                    'pPerson'=> $store->contactDetails->firstname. ' ' .$store->contactDetails->lastname,
                    'pNumber'=> '0'.$store->details->phone,
                    'pInstruction'=> 'Call the number, if not available on the location',
                    'dPerson'=> $order->buyer_firstname.' '.$order->buyer_lastname,
                    'dNumber'=> '0'.$order->buyer_phone,
                    'dInstruction'=> 'Call the number, if not available on the location',
                    'itemDesc'=> $itemsdesc,
                    'itemValue'=>($total/100).'USD',
                    'jobType'=>'Storefronts',
                    'order_id'=>time(),
                    'addressMode'=>'address',
                
            ];
            $results = LookupHelper::http($logistic->url, $data);
                    
            $results = json_decode($results);
            if(array_key_exists('status', $results) && $results->status > 0 ){
                $old_data = json_decode($order->response_data);
                $old_data->transactionOperationStatus = 'COMPLETED';
                $old_data->bookingreference = $results->reference;
                $old_data->bookingdata = $data;
                $order->response_data = json_encode($old_data);
                $request->session()->put('order', $order);
                return (object)[
                'success' =>true,
                'data'=> $results,
                'structure'=>$data,
                ];

            }else{
                return (object)[
                'success' =>false,
                'message'=>$results,
                'structure'=>$data,
                ];
            }

        } else {
            return (object)['success' =>false];
        }
        
    }
    private function SaveOrder($request,$normal){
        $order = $request->session()->pull('order', null);
        $invoicenum = LookupHelper::generateInvoiceNum();
        if($normal){
            $order->invoice_number= $invoicenum;
        }else{
            $order->payment_status='COMPLETED';
        }
       
        $order->save();
        $store = Store::where('id', $order->store_id)->first();
        foreach (LookupHelper::getproductsCart($store->slug) as $products){
            for($p = 0; $p < sizeOf($products); $p++){
    
                $data = ['variant_1'=>$products[$p]['variant_1'], 'variant_2'=>$products[$p]['variant_2']];
                $order_item = new OrderItem();
                $order_item->products_id = $products[$p]['product_id'];
                $order_item->qty = $products[$p]['quantity'];
                $order_item->data = json_encode($data);
                $order_item->orders_id =  $order->id;
                $order_item->save();
            }
        }
        $session_tag = $this->shoppingcartSessionTag.'_'. $store->slug; 
        ShoppingCartHelper::forgetShoppingCart($session_tag);
          \Mail::send('frontend.shoppingcart.invoice', ['store'=>$store, 'order'=>$order], function ($message) use ($order){
            $message->to($order->buyer_email)->subject('Invoice #'.$order->invoice_number);
        });

        \Mail::send('frontend.shoppingcart.store_order_invoice', ['store'=>$store, 'order'=>$order], function ($message) use ($order, $store){
            $message->to($store->contactDetails->email)->subject('Order #'.$order->invoice_number);
        });
        if($normal){
            return $invoicenum;
        }
    }



    public function PaymentListener($correlator, Request $request){
        return Response::json(['success' => false, 'reposnse'=>$correlator]);

    }

    public function Order($slug, $invoicenum, Request $request){
        $store = Store::where('slug', '=',$slug)->first();
        $order = Order::where('invoice_number', '=',$invoicenum)->first();
        View::share('order',  $order); 
        View::share('store', $store);
        View::share('step', 3);
        if(!$store){
            \App::abort(404);
        }
        if(!$order){
            \App::abort(404);
        }

      
       
        return view('frontend.shoppingcart.orderConfirm');
        

    }

    public function details($slug, Request $request) {

        $store = Store::where('slug', '=', $slug)->first();
        $cart_data = $this->getCarts($store->slug);
        if(!array_key_exists('products', $cart_data)){

            $request->session()->flash('alert-warning', 'Please add items on your shopping cart.');
            return redirect('/shopping/'.$slug.'/shoppingcart');
        }
        $delivery_logistics = false;
        if($store->deliveryMethods->id == Store::ECONET_LOGISTICS){
            $delivery_logistics=true;
        }
        View::share('store', $store);
        View::share('logistics', $delivery_logistics);
        View::share('step', 1);
        return view('frontend.shoppingcart.details');
    }

    public function invoice($slug, Request $request) {

        $store = Store::where('slug', '=',$slug)->first();
        $order = Order::where('id', 4)->first();
        View::share('store', $store);
        View::share('order', $order);
        //  \Mail::send('frontend.shoppingcart.invoice', ['store'=>$store, 'order'=>$order], function ($message) use ($order){
        //     $message->to('vmusvibe@methys.com')->subject('Invoice #'.$order->invoice_number.'');
        // });
        return view('frontend.shoppingcart.invoice');
    }
}
