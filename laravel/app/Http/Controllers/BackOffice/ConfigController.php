<?php

namespace App\Http\Controllers\BackOffice;

use View;
use DB;
use Validator;
use Illuminate\Http\Request;
use App\Models\EcocashConfig;
use App\Models\OwnaiConfig;
use App\Models\Logistics;
use Session;
class ConfigController extends BaseController {

	public function __construct() {
        
       
        
    }
	public function Ecocash(Request $request){
         \ViewHelper::setPageDetails('Storefronts | Config', 'Ecocash', 'this is a small description');
        \ViewHelper::setActiveNav('ecocash');
		$config = EcocashConfig::where('ecocash_channel', 'WEB')->first();
		View::share('config', $config);
        return view('backoffice.admin.config.Ecocash');
	}

	public function EcocashUpdate(Request $request){
		 $validator = Validator::make($request->all(), [
            'ecocash_endpoint' => 'required|min:50',
            'ecocash_endpoint_query' => 'required|min:50',
            'ecocash_endpoint_query_user' => 'required|min:50',
            'ecocash_channel' => 'required|min:3',
            'ecocash_merchant_code' => 'required|numeric|min:4',
            'ecocash_merchant_pin' => 'required|numeric|min:4',
            'ecocash_merchant_number' => 'required|numeric|digits_between:9,10',
            'ecocash_username' => 'required|min:4',
            'ecocash_password' => 'required|min:6',
        ]);
        $inputs = $request->all();

        if ($validator->fails()) {
            return redirect()->route('admin.config.ecocash')
                        ->withErrors($validator)
                        ->withInput($inputs);
        }else{
        	$config = EcocashConfig::where('id', $inputs['id'])->first();
        	if($config){
        		$config->ecocash_endpoint =$inputs['ecocash_endpoint'];
				$config->ecocash_endpoint_query =$inputs['ecocash_endpoint_query'];
				$config->ecocash_endpoint_query_user =$inputs['ecocash_endpoint_query_user'];
				$config->ecocash_channel =$inputs['ecocash_channel'];
				$config->ecocash_merchant_code =$inputs['ecocash_merchant_code'];
				$config->ecocash_merchant_pin =$inputs['ecocash_merchant_pin'];
				$config->ecocash_merchant_number =$inputs['ecocash_merchant_number'];
				$config->ecocash_username =$inputs['ecocash_username'];
				$config->ecocash_password =$inputs['ecocash_password'];
				$config->save();
				$request->session()->flash('alert-success', 'Ecocash configurations have been updated successfully.');
        	}else{
        		$config = new EcocashConfig();
        		$config->fill([
            		'ecocash_endpoint' => $inputs['ecocash_endpoint'],
            		'ecocash_endpoint_query' => $inputs['ecocash_endpoint_query'],
            		'ecocash_endpoint_query_user' => $inputs['ecocash_endpoint_query_user'],
            		'ecocash_channel' => $inputs['ecocash_channel'],
            		'ecocash_merchant_code' => $inputs['ecocash_merchant_code'],
            		'ecocash_merchant_pin' => $inputs['ecocash_merchant_pin'],
            		'ecocash_merchant_number' => $inputs['ecocash_merchant_number'],
            		'ecocash_username' => $inputs['ecocash_username'],
            		'ecocash_password' => $inputs['ecocash_password'],
        		])-save();
        		$request->session()->flash('alert-success', 'Ecocash configurations have been saved successfully.');
        	}
        	
        	
        	return redirect()->route('admin.config.ecocash');
		}
	}

    public function Ownai(Request $request){
        \ViewHelper::setPageDetails('Storefronts | Config', 'Ownai', 'this is a small description');
        \ViewHelper::setActiveNav('Ownai');
        $system = OwnaiConfig::first();
        View::share('ownai', $system);
        return view('backoffice.admin.config.Ownai');
    }

    public function OwnaiUpdate(Request $request){
         $validator = Validator::make($request->all(), [
            'url' => 'required|min:10',
            ]);
        $inputs = $request->all();
        if ($validator->fails()) {
            return redirect()->route('admin.config.ownai')
                        ->withErrors($validator)
                        ->withInput($inputs);
        }else{
            $ownai = OwnaiConfig::where('id', $inputs['id'])->first();
            if($ownai){
                $ownai->url = $inputs['url'];
                $ownai->save();
                $request->session()->flash('alert-success', 'Ownai configurations have been updated successfully.');
            }else{
                $ownai = new OwnaiConfig();
                $ownai->fill([
                    'url'=>$inputs['url']
                ])-save();
                $request->session()->flash('alert-success', 'Ownai configurations have been saved successfully.');
            }
            return redirect()->route('admin.config.ownai');
        }
    }

    public function logistics(Request $request){
         \ViewHelper::setPageDetails('Storefronts | Config', 'Logistics', 'this is a small description');
        \ViewHelper::setActiveNav('Logistics');
        $bookservice = Logistics::where("method", 'bookservice')->first();
        $getQuote = Logistics::where("method", 'getQuote')->first();
        
        View::share('bookservice', $bookservice);
        View::share('getQuote', $getQuote);
        return view('backoffice.admin.config.logistics'); 
    }

    public function logisticsBookserviceUpdate(Request $request){
        $validator = Validator::make($request->only('bookservice_url', 'bookservice_token'), [
            'bookservice_url' => 'required|min:20',
            'bookservice_token' => 'required|min:20',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.config.logistics')->withErrors($validator)
                        ->withInput($request->all());
        }else{
           $bookservice = Logistics::where('method', $request->method)->first();
            if($bookservice){
                   $bookservice->url = $request->bookservice_url;
                   $bookservice->token = $request->bookservice_token;
                   $bookservice->save();
                   $request->session()->flash('alert-success', 'Ownai Logistics Booking Service Settings have been updated successfully.');   
            }else{
                   $bookservice = new Logistics();
                   $bookservice->fill([
                       'method' =>$request->method,
                       'url' =>$request->bookservice_url,
                       'token' =>$request->bookservice_token,
                   ])->save();
                   $request->session()->flash('alert-success', 'Ownai Logistics Booking Service Settings have been saved successfully.');
            }   
             return redirect()->route('admin.config.logistics');
        }
    }
    public function logisticsgetQuoteUpdate(Request $request){
        $validator = Validator::make($request->only('getQuote_url', 'getQuote_token'), [
            'getQuote_url' => 'required|min:20',
            'getQuote_token' => 'required|min:20',
        ]);
        if ($validator->fails()) {
            return redirect()->route('admin.config.logistics')->withErrors($validator)
                        ->withInput($request->all());
        }else{
            $getQuote = Logistics::where('method', $request->method)->first();
             if($getQuote){
                $getQuote->url = $request->getQuote_url;
                $getQuote->token = $request->getQuote_token;
                $getQuote->save();
                    $request->session()->flash('alert-success', 'Ownai Logistics Get Quote Settings have been updated successfully.');   
             }else{
                $getQuote = new Logistics();
                $getQuote->fill([
                    'method' =>$request->method,
                    'url' =>$request->getQuote_url,
                    'token' =>$request->getQuote_token,
                ])->save();
                $request->session()->flash('alert-success', 'Ownai Logistics Get Quote Settings have been saved successfully.');
             }   
            return redirect()->route('admin.config.logistics');    
        }
    }
    
}