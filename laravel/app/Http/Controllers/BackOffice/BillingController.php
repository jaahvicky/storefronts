<?php

namespace App\Http\Controllers\BackOffice;

use Illuminate\Http\Request;
use App\Http\Requests\BackOffice\UpdateAccountRequest;
use App\Http\Requests\BackOffice\UpdateAccountUserRequest;

use Illuminate\Support\Facades\Auth;

use App\Models\Store;
use App\Models\EcocashTransaction;
use App\Models\StoreEcocash;
use App\Models\StoreStatusType;
use View;
use Config;
use Validator;
use App;
use PDF;
use Response;
use App\Http\Controllers\Traits\TableSortingAndFilteringTrait;
use App\Http\Helpers\EcocashHelper;

class BillingController extends BaseController
{
    use TableSortingAndFilteringTrait;
    
    public function __construct() {
        
        \ViewHelper::setPageDetails('Storefronts | Billing', 'Billing', 'this is a small description');
        \ViewHelper::setActiveNav('billing');
        $this->middleware('pagination');
    }
    
    public function index(Request $request) {
        $store = Auth::user()->stores()->first();
        if (!$store) {
            $request->session()->flash('alert-error', 'There is no store associated with this billing.');
            return redirect()->route("admin.dashboard");
        }
        $account  = StoreEcocash::where('store_id', $store->id)->first();
        if(!$account){
            $account = [];
        }
        $store_status = StoreStatusType::where('id', $store->store_status_type_id)->first();
        View::share('store', $store);
        View::share('account', $account);
        View::share('status',$store_status->tag );
        return view('backoffice.billing.index');
    }

    public function Accountadd(Request $request){
         $validator = Validator::make($request->all(), [
            //'merchant_name' => 'required|max:255',
            'merchant_number' => 'required|numeric|digits_between:9,10',
        ]);
        $inputs = $request->all();

        if ($validator->fails()) {
            return redirect()->route('admin.billing')
                        ->withErrors($validator)
                        ->withInput($inputs);
        }else{
            $billing  = StoreEcocash::where('store_id', $inputs['store_id'])->first();
            if($billing){
                //$billing->name = $inputs['merchant_name'];
                $billing->number =$inputs['merchant_number'];
                $billing->account_type = $inputs['account_type'];
                $billing->save();
                $request->session()->flash('alert-success', 'EcoCach Account has been updated successfully.');
            }else{
                $billing = new StoreEcocash();
                $billing->fill([
                    'store_id'=> $inputs['store_id'],
                    //'name'=>$inputs['merchant_name'],
                    'number'=>$inputs['merchant_number'],
                    'account_type'=> $inputs['account_type']
                ])->save();
                $request->session()->flash('alert-success', 'EcoCach Account has been saved successfully.');

            }
           return redirect()->route('admin.billing');
        }

    }

    public function Storeupdate(Request $request){
        $inputs = $request->all();
        $store = Auth::user()->stores()->first();
        if($store){
           if(empty($store->billing) && $inputs['account_status'] == Store::STATUS_TYPE_APPROVED)
            {
               $request->session()->flash('alert-error', 'Store update was unsuccessful, please pay your bill.'); 
            }else{
                $store->store_status_type_id = $inputs['account_status'];
                $store->save();
                $request->session()->flash('alert-success', 'Store has been updated successfully.');
            }
           
        }else{
            $request->session()->flash('alert-error', 'Store update was unsuccessful.');
        }
       
        return redirect()->route('admin.billing');
    }

    public function Invoice(Request $request){
         \ViewHelper::setPageDetails('Storefronts | Invoices', 'Invoices', 'this is a small description');
        $store = Auth::user()->stores()->first();
        if (!$store) {
            $request->session()->flash('alert-error', 'There is no store associated with this billing.');
            return redirect()->route("admin.dashboard");
        }
        $query = EcocashTransaction::select('ecocash_transaction.*');
        $query = $query->where('store_id', '=', $store->id);
        $query = $query->orderBy('id', 'asc');
        $invoices = $this->tablePaginate($query);
    
        View::share('invoices', $invoices);
        return view('backoffice.invoice.index');
    }
    
    public function PdfInvoice($id, Request $request){
        $transactions = EcocashTransaction::where('id', $id )->first();
        if(!$transactions){
            $request->session()->flash('alert-error', 'There is no invoice associated with that info.');
            return redirect()->route('admin.billing.invoice');
        }
        
        $url = public_path().'/storage/pdf/invoice_'.$transactions->bill->slug.'_'.$transactions->id.'.pdf';
        return PDF::loadView('backoffice.invoice.invoice', ['transaction'=>$transactions])->save($url)->stream($url);
       
    }

    public function PayModal(Request $request){
        $store = Auth::user()->stores()->first();
        if(!$store){
            $request->session()->flash('alert-error', 'There is no store associated with that info.');
            return redirect()->route('admin.billing');
        }
        if(!$store->ecocash){
            $request->session()->flash('alert-error', 'Please provide payment account details first.');
            return redirect()->route('admin.billing');
        }
        View::share('store', $store);
        return view('backoffice.billing.modal');
    }


    public function AccountPay($storeid){
        $store = Auth::user()->stores()->first();
        if(!$store){
            return Response::json(['success' => false]);
        }

        $transaction = new EcocashTransaction();
        $transaction->fill([
            'store_id'=> $storeid,
            'msiadn'=> $store->ecocash->number,
            'status'=>'pending',
            'response_data'=>'',
            'correlator'=>'',
            'paid_on'=> date('Y-m-d h:m:s'),
            'amount'=> $store->type->amount
        ])->save();
        $ecocash = new EcocashHelper();
        $eco = $ecocash->execute($transaction->id);
        if(array_key_exists('clientCorrelator', $eco['data']) && $eco['status'] == true){
            return Response::json(['success' => true, 'data'=>$eco, 'transaction_id'=>$transaction->id]);
        }else{
            $transaction->delete();
            return Response::json(['success' => false, 'data'=>$eco, 'transaction_id'=>$transaction->id]);
        }
        

    }

    public function TransactionDelete(Request $request){
        $inputs = $request->all();
        $store = Auth::user()->stores()->first();
        if(!$store){
            return Response::json(['success' => false]);
        }
        $transaction = EcocashTransaction::where('id', $inputs['transaction_id'] )->first();
         if(!$transaction){
            return Response::json(['success' => false]);
         }else{
             $transaction->delete();
             return Response::json(['success' => true]);
         }
    }
    public function TransactionUpdate(Request $request){
        $inputs = $request->all();
        $store = Auth::user()->stores()->first();
        if(!$store){
            return Response::json(['success' => false]);
        }
        $transactions = EcocashTransaction::where('id', $inputs['transaction_id'] )->first();
         if(!$transactions){
            return Response::json(['success' => false]);
         }
         $ecocash = new EcocashHelper();
         $data = $ecocash->getLiveTransactionStatus($transactions);
         if($data->transactionOperationStatus == 'COMPLETED'){
            $store->store_status_type_id = Store::STATUS_TYPE_APPROVED;
            $store->save();
            $transactions->status = 'completed';
            $transactions->save();
           
            $pathToFile = public_path().'/storage/pdf/invoice_'.$transactions->bill->slug.'_'.$transactions->id.'.pdf';
            PDF::loadView('backoffice.invoice.invoice', ['transaction'=>$transactions])->save($pathToFile);
            \Mail::send('backoffice.invoice.invoicee', ['store'=>$store], function ($message) use ($store, $pathToFile){
                        $message->to($store->contactDetails->email)->subject('Ownai.co.zw | Storefront Payment Inovice');
                        $message->attach($pathToFile, []); 
            });
            $request->session()->flash('alert-success', 'The transaction was successfully.');

            return Response::json(['success' => true, 'data'=>$data]);
         }else{
            
            return Response::json(['success' => false, 'data'=>$data]);
         }
         

    }

    

    public function BillUpdate($id){
         $transactions = EcocashTransaction::where('id', $id )->first();
         if(!$transactions){
            return Response::json(['success' => false]);
         }
         $ecocash = new EcocashHelper();
         $data = $ecocash->getLiveTransactionStatus($transactions);
         if($data->transactionOperationStatus == 'COMPLETED'){
            $transactions->status = 'completed';
            $transactions->save();

            return Response::json(['success' => true, 'data'=>$data]);
         }
         return Response::json(['success' => false, 'data'=>$data]);

    }
}

