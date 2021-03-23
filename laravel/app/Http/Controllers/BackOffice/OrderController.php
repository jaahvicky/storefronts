<?php

/*
 * Copyright (c) 2017 Methys Digital
 * All rights reserved.
 *
 * This software is the confidential and proprietary information of Methys Digital.
 * ("Confidential Information"). You shall not disclose such
 * Confidential Information and shall use it only in accordance with
 * the terms of the license agreement you entered into with Methys Digital.
 */

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderItem;
use App\Models\DeliveryStatus;

use App\Models\OrderCancellation;

use Auth;
use View;
use URL;
use DB;

use Log;

use Validator;

use App\Facades\LookupHelper;

use App\Http\Controllers\Traits\TableSortingAndFilteringTrait;

class OrderController extends BaseController
{
    // view the list of user orders

    use TableSortingAndFilteringTrait;
    
    protected $tableSortFilterTag = 'orders';
    //Fields that can be filtered
    protected $tableFilters = [
        'orderStatus' => 'order_status.status'
    ];
    
    public function __construct() {
        $this->middleware('pagination');
    }

    public function index() {

        \ViewHelper::setPageDetails('Storefronts | Orders', 'Orders', '');
        \ViewHelper::setActiveNav('orders');

        // if there is no store, then no orders should show
        $store = Auth::user()->stores()->first();
        $store_ids = [];

        if (!$store) {
            $request->session()->flash('alert-danger', 'There is no store associated with this account.');
        } else {
            $stores = Auth::user()->stores()->get();
            foreach ($stores as $s) {
                $store_ids[] = $s->id;
            }
        }

        $query = Order::select('orders.*', 'orders.payment_status as payment_status','delivery_status.status as delivery_status');
        $query->leftJoin('order_items', 'orders.id', '=', 'order_items.orders_id');
        $query->join('products', 'order_items.products_id', '=', 'products.id');
        $query->leftJoin('delivery_status', 'orders.delivery_status_id', '=', 'delivery_status.id');
        $query->where('orders.store_id',$store->id);
        $query->groupBy('orders.id');

        // only show orders related to one of user's stores
        // $query = $query->whereIn('orders.store_id', $store_ids);

        $query  = $this->customFilters($query);
        // tableCustomFilter
        $orders = $this->tablePaginate($query);

        
    	return view('backoffice.orders.index', ['orders' => $orders]);
    }

    // view or edit a single order
    public function details($id) {

        $order = Order::find($id);
        $delivery_status_id = (isset($order->delivery_status_id)) ? (int)$order->delivery_status_id : '';
        $delivery  = $this->delivery_status($delivery_status_id);
        
        \ViewHelper::setPageDetails('Storefronts | Order View', 'Order #' . $order->invoice_number, '');

        View::share('delivery_status', $delivery);
        View::share('order', $order);

        $delivery_modal_info = $this->delivery_status_modal_info($delivery_status_id);

        View::share('modals_info', $delivery_modal_info['info']);
        View::share('modals_btn', $delivery_modal_info['btn']);

    	return view('backoffice.orders.details');
    
    }

    /**
     * delivery_status_modal_info 
     * Gather the necessary modal info for the order 'view' depending on the current status.
     * This is for the modal or the modals used ( the 'confirmation' ) when the user wants to change the status.
     * @param  int   $delivery_status_id [description]
     * @return array $modal_info         [description]
    */
    private function delivery_status_modal_info($delivery_status_id) {

        $modals_info = [];
        $btn         = [];

        switch($delivery_status_id) {
            
            // assume pending 
            case 1:
                $modals_info[] = $this->delivery_status_btn_modal_info('start');
                $modals_info[] = $this->delivery_status_btn_modal_info('cancel');
                // order is important
                $btn = ['start', 'cancel'];
                break;

            // assume process
            case 2:
                $modals_info[] = $this->delivery_status_btn_modal_info('dispatched');
                $modals_info[] = $this->delivery_status_btn_modal_info('collection');
                $modals_info[] = $this->delivery_status_btn_modal_info('cancel');
                $btn = ['dispatched', 'collection', 'cancel'];
                break;

            // assume dispatched
            case 4:
                $modals_info[] = $this->delivery_status_btn_modal_info('complete');
                $modals_info[] = $this->delivery_status_btn_modal_info('cancel');
                $btn = ['complete', 'cancel'];
                break;

            // assume ready for collection
            case 5:
                $modals_info[] = $this->delivery_status_btn_modal_info('complete');
                $modals_info[] = $this->delivery_status_btn_modal_info('cancel');
                $btn = ['complete', 'cancel'];
                break;

        }

        return ['info' => $modals_info, 'btn' => $btn];

    }

    /**
     * delivery_status_btn_modal_info
     * Gather the necessary modal info for the order 'view' depending on the current status and the button
     * This is for the modal or the modals used ( the 'confirmation' ) when the user wants to change the status.
     * @param  string  $btn_type           start, cancel, dispatched, collection and complete
     * @return array   $modal_info         [description]
    */
    private function delivery_status_btn_modal_info($btn_type) {

        $modal_info = [ 'title' => '', 'body' => '', 'main_btn_link' => '', 
        'main_btn_text' => '', 'mod_id' => $btn_type];

        switch ($btn_type) {
            case 'start':
                $modal_info['title'] = 'Start Order';
                $modal_info['body']  = 'Are you ready to start this order and mark it as \'processing\'. We will send the buyer an email to let them know that the order is in progress.';
                //$modal_info['main_btn_link'] = 'http://www.google.co.za';
                $modal_info['main_btn_text'] = 'Start Order';
                break;

            case 'dispatched':
                $modal_info['title'] = 'Dispatch Order';
                $modal_info['body']  = 'Are you sure this order has been dispatched? Only dispatch orders which are already on the way to the buyer. We will let the buyer know that you have dispatched this order.';
                //$modal_info['main_btn_link'] = '#';
                $modal_info['main_btn_text'] = 'Dispatch Order';
                break;

            case 'collection':
                $modal_info['title'] = 'Ready For Collection';
                $modal_info['body']  = 'Are you sure this order is ready for collection? We will let the buyer know that the order is ready for collection at your store address.';
                //$modal_info['main_btn_link'] = '#';
                $modal_info['main_btn_text'] = 'Ready For Collection';
                break;

            case 'complete':
                $modal_info['title'] = 'Complete Order';
                $modal_info['body']  = 'Set an order as completed when delivery has been made, or the buyer has successfully collected the order from your premises. Are you sure you want to complete this order?';
                //$modal_info['main_btn_link'] = '#';
                $modal_info['main_btn_text'] = 'Complete Order';
                break;

            case 'cancel':
                $modal_info['title'] = 'Cancel Order';
                $modal_info['body']  = 'Cancelling an order is never good business! Only cancel this order if you are certain you cannot fulfill the buyers\' request. Cancelling an order will return any funds which have been charged.';
                //$modal_info['main_btn_link'] = '#';
                $modal_info['main_btn_text'] = 'Cancel Order';
                break;

        }

        return $modal_info;

    }

    private function delivery_status($delivery_status_id = null){

        $delivery_status = [];

        if ($delivery_status_id) {
            $delivery_status[] = DeliveryStatus::find($delivery_status_id);
        } else {
            $delivery_status = DeliveryStatus::all();
        }

        $delivery_method = [];
        foreach ($delivery_status as $delivery) {
            
            $delivery_method[$delivery->id]= $delivery->status;
                    
        }

        return $delivery_method;

    }

    // update a single order
    public function update(Request $request, $id) {

        $data  = $request->all();

        $rules = [
            //'status'    => 'required|numeric|max:4',
            'order_notes' => 'max:255'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $request->session()->flash('alert-error', 'Please make sure the information is correct');
            return redirect()->route('orders.details', $id)->withErrors($validator)->withInput();
        }

        $order                      = Order::findOrFail($id);
        //$order->delivery_status_id = $request->input('status');
        $order->order_notes         = $request->input('order_notes');
        $order->save();

        $request->session()->flash('alert-success', 'Order information updated');
        return redirect()->route('orders.details', $id);

    }
    
    /**
     * [updateOrderStatus description]
     * @param  Request $request  next  start, dispatched, complete, collection, cancel
     * @param  $id               order id
    */
    public function updateOrderStatus(Request $request, $id){

        // 1. is the order part of the current store? - mid
        // 2. what is the current status of the order? - php for security

        $order = Order::findOrFail($id);

        $current = (int)$order->delivery_status_id;
        $function = $request->input('next');

        // each current status to have certain allowed options

        // start,  dispatched, complete, collection, cancel
        $allowed = [];

        switch ($current) {
            // assume pending
            case 1:
                $allowed = ['start', 'cancel'];
                break;
            // assume processing
            case 2:
                $allowed = ['dispatched', 'collection', 'cancel'];
                break;
            // assume dispatched
            case 4:
                $allowed = ['complete', 'cancel'];
                break;
            // assume ready for collection
            case 5:
                $allowed = ['complete', 'cancel'];
        }

        if (in_array($function, $allowed)) {

            switch($function) {
                case 'start':
                    $order->delivery_status_id = '2';
                    break;
                case 'dispatched':
                    $order->delivery_status_id = '4';
                    break;
                case 'collection':
                    $order->delivery_status_id = '5';
                    break;
                case 'complete':
                    $order->delivery_status_id = '3';
                    break;
                case 'cancel':
                    $order->delivery_status_id = '6';
                    
                    $data = $request->all();

                    $rules = [

                        'cancellation_reason' => 'required',
                        'other_reason'        => 'max:255'

                    ];

                    $validator = Validator::make($data, $rules);

                    if ($validator->fails()) {

                        return redirect()->route('orders.details', $id)->withErrors($validator)->withInput();

                    }

                    $options_ar   = array_keys($data['cancellation_reason']);
                    $other_reason = $data['other_reason'];

                    $order_cancellations_id = DB::table('order_cancellations')->insertGetId([
                        'orders_id' => $order->id,
                        'reason'    => $other_reason,
                    ]);

                    foreach ($options_ar as $option_id) {

                        DB::table('order_cancellations_cancel_options')->insert([
                            'order_cancellations_id'  => $order_cancellations_id,
                            'order_cancel_options_id' => $option_id
                        ]);

                    }

                    break;
                default:
                    break;

            }

            $order->save();

            $cancel = false;
            if ($function === 'cancel') {
                $cancel = true;
            }

            $this->sendmail($order, $cancel);
            //$this->sendsms($order);

            $request->session()->flash('alert-success', 'Order information status updated');
            return redirect()->route('orders.details', $id);

        }

        $request->session()->flash('alert-error', 'Something went wrong or status skip not allowed');
        return redirect()->route('orders.details', $id); 
        
    }

    public function modalUpdateBilling(Request $request, $id) {

        $data = $request->all();

        $rules = [
            'buyer_firstname'       => 'required|max:255',
            'buyer_lastname'        => 'required|max:255',
            'buyer_address_line_1'  => 'required',
            'buyer_address_line_2'  => '',
            'buyer_suburb'          => 'required|max:255',
            'buyer_city'            => 'required|max:255',
            'buyer_province_state'  => 'required|max:255',
            'buyer_country'         => 'required|max:255',
            'buyer_postal_code'     => 'max:255',
            'buyer_email'           => 'required|email',
            'buyer_phone'           => 'required|max:255'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            // $request->session()->flash('alert-error', 'Please make sure the information is correct');
            return redirect()->route('orders.details', $id)->withErrors($validator)->withInput();
        }

        $order                        = Order::findOrFail($id);
        $order->buyer_firstname       = $request->input('buyer_firstname');
        $order->buyer_lastname        = $request->input('buyer_lastname');
        $order->buyer_address_line_1  = $request->input('buyer_address_line_1');
        $order->buyer_address_line_2  = $request->input('buyer_address_line_2');
        $order->buyer_suburb          = $request->input('buyer_suburb');
        $order->buyer_city            = $request->input('buyer_city');
        $order->buyer_province_state  = $request->input('buyer_province_state');
        $order->buyer_country         = $request->input('buyer_country');
        $order->buyer_postal_code     = $request->input('buyer_postal_code');
        $order->buyer_email           = $request->input('buyer_email');
        $order->buyer_phone           = $request->input('buyer_phone');

        $order->save();

        $request->session()->flash('alert-success', 'Order information updated');
        return redirect()->route('orders.details', $id);

    }

    private function customFilters(\Illuminate\Database\Eloquent\Builder $query) {

        $filters = \SortFilterHelper::getFilters($this->tableSortFilterTag); //fetch session filters

        $filters = $this->sortFilters($filters);

        // if (key_exists('orderStatus', $filters) && $filters['orderStatus'][0] !== 'any') {
            
        //     $status = $filters['orderStatus'];

        //     $order_status  = DB::table('order_status')->where('status', $status)->first();

        //     $order_status_id  = ($order_status) ? $order_status->id : '';

        //     if ($order_status_id) {
        //         $query->where('order_status.id', $order_status_id);
        //     }
        // }


        
        if(array_key_exists('orderStatus', $filters) && $filters['orderStatus'][0] !='any'){
            $query->where('orders.delivery_status_id', (int)$filters['orderStatus'][0]);
            \SortFilterHelper::updateFilters($filters);
        }
        

        // if a sort by key exists
        if (key_exists('orderByColumn', $filters)) {

            $order_ar = explode(',', $filters['orderByColumn'][0]);
            $order_name = $order_ar[0];
            $order_dir = $order_ar[1];

            switch ($order_name) {
                case 'order-no':
                    $query->orderBy('orders.invoice_number', $order_dir);
                    break;
                case 'date':
                    $query->orderBy('orders.created_at', $order_dir);
                    break;
                case 'buyer-details':
                    $query->orderBy('orders.buyer_firstname', $order_dir);
                    break;
                case 'item-count':
                    //$query->orderBy('orders.item_count', $order_dir);
                    break;
                case 'total-price':
                    $query->orderBy('orders.amount', $order_dir);
                    break;
                default:
                    break;
            }

        } else {
            $query->orderBy('orders.id', 'asc');
        }

        return $query;
    }

    public function getOrdersData() {

        // if there is no store, then no orders should show
        $store = Auth::user()->stores()->first();
        $store_ids = [];

        if (!$store) {
            $request->session()->flash('alert-danger', 'There is no store associated with this account.');
        } else {
            $stores = Auth::user()->stores()->get();
            foreach ($stores as $s) {
                $store_ids[] = $s->id;
            }
        }

        $query = Order::select('orders.*');
        $query->join('order_status', 'orders.order_status_id', '=', 'order_status.id');
        $query->leftJoin('order_items', 'orders.id', '=', 'order_items.orders_id');
        $query->leftJoin('products', 'order_items.products_id', '=', 'products.id');
        // $query->join('users', 'orders.users_id', '=', 'users.id');
        $query->groupBy('orders.id');

        // only show orders related to one of user's stores
        $query = $query->whereIn('orders.store_id', $store_ids);

        $query  = $this->customFilters($query);
        // tableCustomFilter
        $orders = $this->tablePaginate($query);

        $form_body       = view('backoffice.orders.tables.orders-list', ['orders' => $orders])->render();
        $form_pagination = view('backoffice.orders.tables.orders-list-pagination', ['orders' => $orders])->render();

        $form_data = [ 'form_body' => $form_body, 'form_pagination' => $form_pagination ];

        return $form_data;
    }

    private function sortFilters($filters) {

        foreach ($filters as $key => $value) {
           foreach ($value as $k => $v) {
              if($v =='all' || $v=='any'){
                unset($filters[$key]);
              }
           }
        }

        return $filters;

    }

    public function exportOrderList (Request $request) {
        
        // $table = 'orders';

        $data = $request->all();

        // if there is no store, then no orders should show
        $store = Auth::user()->stores()->first();
        $store_ids = [];

        if (!$store) {
            $request->session()->flash('alert-danger', 'There is no store associated with this account.');
        } else {
            $stores = Auth::user()->stores()->get();
            foreach ($stores as $s) {
                $store_ids[] = $s->id;
            }
        }

        $rules = [
            'from_date'       => 'date_format:d/m/Y',
            'to_date'        => 'date_format:d/m/Y'
        ];

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            //$request->session()->flash('alert-danger', 'Please make sure the information is correct');
            return redirect()->route('orders.index')->withErrors($validator)->withInput();
        }

        $from = $data['from_date'];
        $to   = $data['to_date'];

        if ($from) {
            $from = str_replace('/','-', $from); // 22/4/1111
            $from = new \DateTime($from);        // 2017-04-22
            $from = $from->format("Y-m-d") . ' 00:00:00'; // 2017-04-22 00:00:00
        }

        if($to) {
            $to   = str_replace('/','-', $to); // 22/2/1111
            $to   = new \DateTime($to);        // 2017-02-08
            $to   = $to->format("Y-m-d") . ' 23:59:59'; // 2017-02-08 23:59:59
        }

        $filters      = \SortFilterHelper::getFilters($this->tableSortFilterTag); //fetch session filters
        $file_subname = '';

        if (key_exists('orderStatus', $filters) && $filters['orderStatus'][0] !== 'any') {
            $file_subname = '_' . \strtolower($filters['orderStatus'][0]);
        }
        $file_subname .= '_orders';

        $full_name = 'concat(buyer_firstname, " ", buyer_lastname)';
        $address   = 'buyer_address';

        $columns = [ 
            'invoice_number', 'orders.created_at', 
            DB::raw($full_name . ' as full_name'),   
            DB::raw($address . ' as address'), 
            'buyer_email', 'buyer_phone','orders.store_id','amount'
        ];

        $column_names = ['Order', 'Date', 'Full Name', 'Address', 'Email', 'Contact Number', 'Items Ordered', 'Total Price'];
        //$row_columns  = ['order_nr', 'orders.created_at', 'full_name', 'address', 'buyer_email', 'buyer_phone', 'item_count', 'total_after_tax'];

        $query = Order::select($columns);
        $query->join('delivery_status', 'orders.delivery_status_id', '=', 'delivery_status.id');
        $query->leftJoin('order_items', 'orders.id', '=', 'order_items.orders_id');
        $query->leftJoin('products', 'order_items.products_id', '=', 'products.id');
        // $query->join('users', 'orders.users_id', '=', 'users.id');
        $query->groupBy('orders.id');

        // only show orders related to one of user's stores
        $query = $query->whereIn('orders.store_id', $store_ids);

        if ($from || $to) {
            if ($from && $to) {
                // between dates
                $query = $query->whereBetween('orders.created_at', [$from, $to]);
            } else if($from) {
                $query = $query->where('orders.created_at', '>=', $from);
            } else if ($to) {
                $query = $query->where('orders.created_at', '<=', $to);
            } else {

            }
        }

        $query  = $this->customFilters($query);

        // tableCustomFilter
        $orders = $this->tablePaginate($query);

        $from_date = str_replace(' 00:00:00', '', $from);
        $to_date   = str_replace(' 23:59:59', '', $to);

        $this->exportToCSV($orders, $column_names, $file_subname, $from_date, $to_date);

    }

    // table, columns, column_names                  - required
    // to (date), from (date), orderby, order_status - optional
    public function exportToCSV($items, $column_names, $file_subname, $from, $to) {


        $items = $items->toArray();

        //ob_start();

        $output = fopen('php://output', 'w');
        fputcsv($output, $column_names);
        
        foreach($items['data'] as $item) {
           
            $order = Order::where('invoice_number', $item['invoice_number'])->first();
            $item['store_id'] = sizeof($order->OrderItems);
            fputcsv($output, $item);

        }
       

        if(!$from) {
            $from = 'no-from-date';
        }
        if(!$to) {
            $to = 'no-to-date';
        }

        $filename = $from . '_' . $to . $file_subname;

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' .  $filename . '.csv"');

        fclose($output);

        //ob_end_clean();

        // don't print html
        exit();
    
    }

    public function printInvoice($id) {

        $order = Order::findOrFail($id);
        $store = $order->store()->first();
        $store_contact_details = $store->contactDetails()->first();
        $store_country = $store_contact_details->country()->first();

        \ViewHelper::setPageDetails('Storefronts | Order Invoice', $store->name, '');

        return view('backoffice.orders.invoice', [
            'order'                 => $order, 
            'store'                 => $store,
            'store_contact_details' => $store_contact_details,
            'store_country'         => $store_country->name
        ]);
    }

    private function sendmail($order, $cancel = false){

        $status = $order->DeliveryStatus->status;
        $order_mail_descr = $this->getOrderMailDescription($order, $status);
        $store_contact = '+263' . $order->store->details->phone;

        if($cancel) {

            $order_cancel = OrderCancellation::where('orders_id', $order->id)->first();
            $cancel_order = ['options' => [], 'description' => ''];

            if ($order_cancel) {

                $order_cancel_options = DB::table('order_cancellations_cancel_options')
                            ->where('order_cancellations_id', $order_cancel->id)->get();

                $order_cancel_options_ids = [];

                foreach($order_cancel_options as $o) {
                    $order_cancel_options_ids[] = $o->order_cancel_options_id;
                }

                $order_options = LookupHelper::getOrderCancelOptions($order_cancel_options_ids);

                foreach($order_options as $o_o) {
                    $cancel_order['options'][] = $o_o['options'];
                }

                $cancel_order['description'] = $order_cancel['reason'];

            }

            \Mail::send('backoffice.admin.orders.order_status', [
                'order'=>$order,
                'cancel_order'     => $cancel_order,
                'order_mail_descr' => $order_mail_descr,
                'store_contact'    => $store_contact
                ], function ($message) use ($order){
                $message->to($order->buyer_email)->subject('Order#'.$order->invoice_number.' Update');
                });

        } else {

            \Mail::send('backoffice.admin.orders.order_status', [
                'order'=>$order,
                'order_mail_descr' => $order_mail_descr,
                'store_contact'    => $store_contact
                ], function ($message) use ($order){
                $message->to($order->buyer_email)->subject('Order#'.$order->invoice_number.' Update');
            });
        }

    }

    private function getOrderMailDescription($order, $status) {

        $status = strtolower($status);
        $description = '';

        switch($status) {

            // pending

            case 'processing':
                $description = 'Your order <b>' . $order->invoice_number . '</b> placed on <b>' . $order->store->name . '</b> is now being processed. You will receive a mail when the status of this order changes.';
                break;
            case 'completed':
                $description = 'Your order <b>' . $order->invoice_number . '</b> placed on <b>' . $order->store->name . '</b> has been completed.';
                break;

            case 'dispatched':
                $description = 'Your order <b>' . $order->invoice_number . '</b> placed on <b>' . $order->store->name . '</b> has been dispatched. You will receive a mail when the status of this order changes.';
                break;

            case 'ready for collection':
                $description = 'Your order <b>' . $order->invoice_number . '</b> placed on <b>' . $order->store->name . '</b> is ready to be collected. You will receive a mail if the status of this order changes.';
                break;

            case 'cancelled':
                $description = 'Your order <b>' . $order->invoice_number . '</b> placed on <b>' . $order->store->name . '</b> has been cancelled by the seller. Unfortunately, the order cannot be fulfilled.';
                break;

        }

        return $description;

    }

    private function sendsms($order){
        $number = '263'.$order->buyer_phone;
        switch ($order->DeliveryStatus->status) {
            case 'Pending':
                $message = "Ownai Storefronts: Thanks for your order $order->invoice_number. We'll keep you up to date on progress.";
                break;
            case 'Processing':
                $message = "Ownai Storefronts: Great news, your order $order->invoice_number is currently being processed. We'll keep you up to date on progress.";
                break;
            case 'Completed':
                $message = "Ownai Storefronts: Your order $order->invoice_number is packed and ready to go. You'll receive collection/dispatch information shortly.";
                break;
            case 'Dispatched':
                $message = "Ownai Storefronts: Your order $order->invoice_number has been dispatched. You should receive delivery information from the chosen courier shortly.";
                break;
             case 'Ready For Collection':
                $message = "Ownai Storefronts: Your order $order->invoice_number is ready for collection.  Contact the store owner for more details.";
                break;
            case 'Cancelled':
                $message = "Ownai Storefronts: Your order $order->invoice_number has been cancelled by the store owner. Please get in touch with the store for more details.";
                break;
            default:
               $message = NULL;
                break;
        }
        if($message != NULL){
             LookupHelper::_send_sms($number, '', $message);
        }
    }

}
