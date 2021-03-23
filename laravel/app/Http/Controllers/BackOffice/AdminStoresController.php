<?php

namespace App\Http\Controllers\BackOffice;

use App\Models\Store;
use App\Models\StoreStatusType;
use App\Models\StoreUser;

use View;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Traits\TableSortingAndFilteringTrait;
use App\Facades\SortFilterHelper;
use Mail;


class AdminStoresController extends BaseController {
    
    use TableSortingAndFilteringTrait;
    
    protected $tableSortFilterTag = 'stores';
    //Fields that can be filtered
    protected $tableFilters = [
        'storeStatus' => 'store_status_types.label',
    ];
    
    public function __construct() {

        $this->middleware('pagination');
    }
    
    public function index(Request $request) {
        
        \ViewHelper::setPageDetails('Storefronts | Store List', 'Manage Stores', 'this is a small description');
        \ViewHelper::setActiveNav('stores');

        $query = Store::select('stores.*');
        
        $this->updateCustomFiltering($request);
        $query->leftJoin('store_status_types', 'stores.store_status_type_id', '=', 'store_status_types.id');
        $query->orderBy('name');
        if($this->checkfilter()){
             $query = $this->tableFilter($query);
        }
        
        $stores = $this->tablePaginate($query);
        
        View::share('stores', $stores);
        return view('backoffice.admin.stores.index');
    }

    public function details(Request $request, $id) {

        $store = Store::find($id);
        if (!$store) {
            $request->session()->flash('alert-error', 'There is no store associated with that data.');
            return redirect()->route("admin.stores");
        }

        $details = $store->details;
        $contact_details = $store->contactDetails;
        $store_ecocash = (isset($store->ecocash)) ? $store->ecocash : '';

        $data = [
            'name'              => $store->name,
            'type'              => $store->type->type,
            'slug'              => $store->slug,
            'delivery_method'   => $store->deliveryMethods->method,
            'status'            => $store->status->label,
            'details'           => [
                'street_address_1' => $details->street_address_1,
                'street_address_2' => $details->street_address_2, // optional
                'city'             => $details->city->name,
                'suburb'           => ($details->suburb_id) ? $details->suburb->name : '', // optional
                'country'          => $details->country->name,
                'email'            => $details->email, // optional
                'phone'            => '+263 ' . $details->phone
            ],
            'contact_details'   => [
                'name'              => $contact_details->firstname . ' ' . $contact_details->lastname,
                'street_address_1'  => $contact_details->street_address_1,
                'street_address_2'  => $contact_details->street_address_2, // optional
                'city'              => $contact_details->city->name,
                'suburb'            => ($contact_details->suburb_id) ? $contact_details->suburb->name : '', // optional
                'country'           => $contact_details->country->name,
                'email'             => $contact_details->email, // optional
                'phone'             => ($contact_details->phone) ? '+263 ' . $contact_details->phone : '' // optional
            ],
            'store_ecocash'     => [
            ]
        ];

        if($store_ecocash) {

            $ecocash_name_field = $store_ecocash->name;
            if ($ecocash_name_field === 'merchant-acc') {
                $ecocash_name_field = 'Merchant Account';
            }
            if ($ecocash_name_field === 'subscriber-acc') {
                $ecocash_name_field = 'Subscriber Account';
            }

            $data['store_ecocash'] = [
                'name'   => $ecocash_name_field,
                'number' => $store_ecocash->number
            ];
        }

        \ViewHelper::setPageDetails('Storefronts | Store View', 'View Store', 'this is a small description');
        \ViewHelper::setActiveNav('stores');

        // $store->getAttributes()

        return view('backoffice.admin.stores.details', ['data' => $data]);

    }
    
    private function checkfilter(){
        $filters = \SortFilterHelper::getFilters($this->tableSortFilterTag);
        if(array_key_exists('storeStatus', $filters) && $filters['storeStatus'][0] == 'any'){
            return false;
        }else{
            return true;
        }
    }
    private function updateCustomFiltering($request) {
        
        $filters = \SortFilterHelper::getFilters($this->tableSortFilterTag);
        //If page was reloaded then don't worry about default filtering
        $referer = $request->server('HTTP_REFERER');
        $showDefaultFilter = !(strstr($referer, "admin/stores"));
        
        //Make default storeStatus filter to be any
        if (!SortFilterHelper::getFilterValue('storeStatus', $this->tableSortFilterTag) || $showDefaultFilter) {
            
            $filters['storeStatus'] = ['any'];
            \SortFilterHelper::updateFilters($filters);
        }

        //If user did not come from the store list, i.e. They came from another page
        if ($showDefaultFilter) {
            
            $countPending = Store::where('store_status_type_id', Store::STATUS_TYPE_PENDING_OPEN)->orWhere(function ($query) {
                $query->where('store_status_type_id', Store::STATUS_TYPE_PENDING_REOPEN);
            })->count();
            $filters = \SortFilterHelper::getFilters($this->tableSortFilterTag);

            //If storeStatus is set to Pending but no results for Pending, set to Approved
            if (SortFilterHelper::getFilterValue('storeStatus', $this->tableSortFilterTag) !== null 
                    && in_array('Pending', SortFilterHelper::getFilterValue('storeStatus', $this->tableSortFilterTag))
                    && $countPending === 0) {

                $filters['storeStatus'] = ['Approved'];
                \SortFilterHelper::updateFilters($filters);
            }
        }
    }
    
    public function modalChangeStatus($id) {
        
        $store = Store::where('id', $id)->first();
        
        View::share('store', $store);
        View::share('statuses', array_combine(Store::$store_status_types, Store::$store_status_types));

        return view('backoffice.admin.stores.modal-change-status');
    }

   
        
    public function changeStatus(Request $request) {
        
        $input = $request->all();
        $store = Store::where('id', $input['id'])->first();
        if($input['store_status'] == "Pending"){
            $status = StoreStatusType::where('tag', 'pending-reopen')->first();
        }else{
            $status = StoreStatusType::where('label', $input['store_status'])->first();
        }
        
      
        if ($status->id !== $store->store_status_type_id) {
            
            $store->store_status_type_id = $status->id;
            $store->status_at = date("Y-m-d H:i:s");

            if ($status->label == 'Approved' &&  $store->approved_at == null){
                 $store->approved_at = date("Y-m-d H:i:s");
            }

            $store->save();

            $flash_mess = 'Store status was successfully updated.';

            if ($status->label == 'Approved' || $status->label == 'Rejected') {

                $store_link =  StoreUser::where('store_id',$store->id)->first();

                // Approved or Rejected
                if ( ($status->label == 'Approved' && isset($input['send_email']) && $input['send_email'] == '1') 
                    || $status->label == 'Rejected') {

                    $this->sendmail($store, $store_link->user->username, $status->label);

                    // should happen.
                    $flash_mess = 'Store status was successfully updated and mail was sent.';

                }

            }

            $request->session()->flash('alert-success', $flash_mess);
            return redirect()->route("admin.stores");

        }        
    }
    
    public function modalApproveStatus($id) {
        
        $store = Store::where('id', $id)->first();
        
        View::share('store', $store);

        return view('backoffice.admin.stores.modal-approve-status');
    }

    private function sendmail($store, $username, $status){

        if ($status == 'Approved') {
            \Mail::send('backoffice.admin.stores.approve', ['store' => $store, 'username' => $username, 'show_browser_link' => true], function ($message) use ($store){
                $message->to($store->contactDetails->email)->subject('Ownai.co.zw | Storefront Approved');
        });
        }

        if ($status == 'Rejected') {
            \Mail::send('backoffice.admin.stores.rejected', ['store'=>$store], function ($message) use ($store){
                $message->to($store->contactDetails->email)->subject('Ownai.co.zw | Storefront Rejection');
        });
        }

    }

}

