<?php

namespace App\Http\Controllers\BackOffice;

use App\Models\Store;
use App\Models\StoreStatusType;
use App\Models\Order;
use App\Models\DeliveryStatus;
use App\Models\OrderCancellation;
use View;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\TableSortingAndFilteringTrait;
use App\Facades\SortFilterHelper;
use App\Facades\LookupHelper;

class AdminOrderController extends BaseController {
    
    use TableSortingAndFilteringTrait;
    
    protected $tableSortFilterTag = 'orders';
    //Fields that can be filtered
    protected $tableFilters = [
        'storeStatus' => 'store_status_types.label',
    ];
    
    public function __construct() {

        $this->middleware('pagination');
    }
    
    public function index(Request $request) {
        
        \ViewHelper::setPageDetails('Storefronts | Orders List', 'Manage Orders', 'this is a small description');
        \ViewHelper::setActiveNav('manageorders');

        $query = Order::select('orders.*');
        $query = $this->updateCustomFiltering($query);
        $query->orderBy('created_at');
       
       
       
        $order = $this->tablePaginate($query);
        
        View::share('orders', $order);
        View::share('StatusFilters', DeliveryStatus::all());
        return view('backoffice.admin.orders.index');
    }
    
    private function checkfilter(){
        $filters = \SortFilterHelper::getFilters($this->tableSortFilterTag);
        if(array_key_exists('orderstatus', $filters) && $filters['orderstatus'][0] == 'any'){
            return false;
        }else{
            return true;
        }
    }
    private function updateCustomFiltering($query) {
        
        $filters = \SortFilterHelper::getFilters($this->tableSortFilterTag);
        if(array_key_exists('orderstatus', $filters) && $filters['orderstatus'][0] !='any'){
            $query->where('delivery_status_id', (int)$filters['orderstatus'][0]);
            \SortFilterHelper::updateFilters($filters);
        }
        if(array_key_exists('store_name', $filters) && $filters['store_name'] !=''){
            $stores = Store::where("name", 'like', ''.$filters['store_name'].'%')->get();
            $store_ids =[];
            foreach ($stores as $store) {
               array_push($store_ids,$store->id);
            }
           
            $query->whereIn('store_id', $store_ids);
        }
        if(array_key_exists('Order_id', $filters) && $filters['Order_id'] !=''){
             $query->where('invoice_number', $filters['Order_id']);
            \SortFilterHelper::updateFilters($filters);
        }
        return $query;
      
    }
    
    public function modalChangeStatus($id) {
        
        $order = Order::where('id', $id)->first();
        
        View::share('order', $order);
        $delivery_status = DeliveryStatus::all();
        $DeliveryStatus = [];
        foreach ($delivery_status as $status) {
            $DeliveryStatus[$status->id] = $status->status;
        }

        View::share('statuses', $DeliveryStatus);

        return view('backoffice.admin.orders.modal-change-status');
    }

    public function modalAddNote($id)
    {
         $order = Order::where('id', $id)->first();
        
        View::share('order', $order);
       

        return view('backoffice.admin.orders.modal-add-note');
    }

    public function changeNote(Request $request){
        $input = $request->all();
        $order = Order::where('id', $input['id'])->first();
        if(!$order){
            $request->session()->flash('alert-error', 'There is no Order associated with that information');
        }else{
            $order->order_notes = $input['note'];
            $order->save();
            $request->session()->flash('alert-success', 'Order Note was successfully saved.');
        }
        return redirect()->route("admin.manage.orders"); 
    }

   
        
    public function changeStatus(Request $request) {
        
        $input = $request->all();
        $order = Order::where('id', $input['id'])->first();
        $status = DeliveryStatus::where('id', $input['order_status'])->first();
        if(!$order){
            $request->session()->flash('alert-error', 'There is no Order associated with that information');
        }
        if(!$status){
            $request->session()->flash('alert-error', 'There is no Order Status associated with that information');
        }

        if(!empty($status) && !empty($order)){
            $request->session()->flash('alert-success', 'Order Status status was successfully updated.');
            $order->delivery_status_id = $status->id;
            $order->save();

            $cancel = false;
            if ( (int)$status->id === 6) {
                $cancel = true;
            }

            $this->sendmail($order, $cancel);
            //$this->sendsms($order);
        }

        return redirect()->route("admin.manage.orders");        
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

