<?php

namespace App\Http\Helpers;
use App\Models\EcocashTransaction;
use App\Models\EcocashConfig;
use URL;
class EcocashHelper
{
  
    private $ecocash_username;
    private $ecocash_password;

    const WAIT_TIMEOUT = 120;
    const SLEEP_TIME   = 10;

   
    /*
    * charging a subscriber
    *
    *
    **/
    public function execute($trans_id)
    {
        $config = EcocashConfig::where('ecocash_channel', 'WEB')->first();
        if(!$config){
            return ['status'=> false];
        }
        $this->ecocash_username =$config->ecocash_username;
        $this->ecocash_password = $config->ecocash_password;
        $ecocash_url = $config->ecocash_endpoint;//ECOCASH_ENDPOINT;
        $transaction = EcocashTransaction::where('id', $trans_id)->first();
        if(!$transaction){
            return ['status'=> false];
        }

        $number = '263'.$transaction->msiadn;
        $clientCorrelator = LookupHelper::generateInvoiceNum().'-'.time();  //Use the guid function to populate
        $amount           = $transaction->amount.'.0';

        $amount = 1.0; 

        $ecocash_values = array(
            "clientCorrelator"           => $clientCorrelator,
            "endUserId"                  => $number,
            "merchantCode"               => $config->ecocash_merchant_code,//ECOCASH_MERCHANT_CODE,
            "merchantPin"                => $config->ecocash_merchant_pin,//ECOCASH_MERCHANT_PIN,
            "merchantNumber"             => $config->ecocash_merchant_number,//ECOCASH_MERCHANT_NUMBER,
            "notifyUrl"                  => URL::route('admin.billing.payment', ['id'=> $transaction->id]),
            "paymentAmount"              => array(
                "charginginformation" => array(
                    "amount"      => "$amount",
                    "currency"    => "USD",
                    "description" => 'Storefront Store Payment' //description text to be used for billing information
                ),
                "chargeMetaData"      => array(
                    "onBeHalfOf"           => 'Storefront Store',
                    "purchaseCategoryCode" => 'Online Payment', //indication of the content type
                    "channel"              => $config->ecocash_channel//ECOCASH_CHANNEL
                )
            ),
            "referenceCode"              => $transaction->id,
            "transactionOperationStatus" => "Charged",
        );

        error_log("==== REQUEST =====\n".json_encode($ecocash_values, JSON_PRETTY_PRINT)."\n", 3, '/tmp/ecocash.log');

        // Takes the input fields and turn them into the appropriate format
        // for an https post. E.g: "merchantCode=42467&merchantPin=1357"
        $ecocash_string = json_encode($ecocash_values);

        $json_raw = $this->http($config->ecocash_endpoint, $ecocash_string);

       
        $transaction->correlator = $clientCorrelator;
        $transaction->response_data = $json_raw;
        $transaction->save();
        $ecocash_array = json_decode($json_raw, TRUE);

        error_log("==== RESPONSE ====\n".json_encode($ecocash_array, JSON_PRETTY_PRINT)."\n\n", 3, '/tmp/ecocash.log');

        return ['status'=> true, 'data'=>$ecocash_array]; // return the API response in json code
    }

    private function http($endpoint, $post = null)
    {
        $request = curl_init($endpoint); // initiate curl object
        curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
        curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
        curl_setopt($request, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($request, CURLOPT_USERPWD, sprintf('%s:%s', $this->ecocash_username, $this->ecocash_password));
        curl_setopt($request, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($request, CURLOPT_ENCODING, "");
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        if ($post != null) {
            curl_setopt($request, CURLOPT_POSTFIELDS, $post); // use HTTP POST to send form data
        }
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.

        $response = curl_exec($request); // execute curl post and store results in $json_raw

        curl_close($request); // close curl object

        return $response;
    }

    private function get($endpoint)
    {
        $request = curl_init($endpoint); // initiate curl object
        curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($request, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($request, CURLOPT_USERPWD, sprintf('%s:%s', $this->ecocash_username, $this->ecocash_password));
        curl_setopt($request, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($request, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($request, CURLOPT_HEADER, 0);
        curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE);

        $response = curl_exec($request); // execute curl post and store results in $json_raw

        curl_close($request); // close curl object

        return $response;
    }

    public function getLiveTransactionStatus($transaction)
    {
        $config = EcocashConfig::where('ecocash_channel', 'WEB')->first();
        if(!$config){
            return ['status'=> false];
        }
        $number = $number = '263'.$transaction->msiadn;
        $this->ecocash_username =$config->ecocash_username;
        $this->ecocash_password = $config->ecocash_password;
        $endpoint = sprintf( $config->ecocash_endpoint_query, $number, urlencode($transaction->correlator));

        $response = $this->get($endpoint);

        return json_decode($response);
    }

    public function getLiveTransactionList($transaction)
    {      
        $config = EcocashConfig::where('ecocash_channel', 'WEB')->first();
        if(!$config){
            return ['status'=> false];
        }
        $number = $transaction->msiadn;
        $this->ecocash_username =$config->ecocash_username;
        $this->ecocash_password = $config->ecocash_password;

        $endpoint = sprintf($config->ecocash_endpoint_query_user, $number);

        $response = $this->get($endpoint);

        return json_decode($response);
    }

    /***** for orders ****/

    public function orderExecute($order){
        $config = EcocashConfig::where('ecocash_channel', 'WEB')->first();
        if(!$config){
            return ['status'=> false];
        }
        $this->ecocash_username =$config->ecocash_username;
        $this->ecocash_password = $config->ecocash_password;
        $ecocash_url = $config->ecocash_endpoint;//ECOCASH_ENDPOINT

        if(!$order){
            return ['status'=> false];
        }

       $number = '263'.$order->buyer_phone;
        //$number = '263784536125';
        $clientCorrelator = LookupHelper::generateInvoiceNum();  //Use the guid function to populate
        //$amount           = $order->amount.'.0';

        $amount = 1.0; 

        $ecocash_values = array(
            "clientCorrelator"           => $clientCorrelator,
            "endUserId"                  => $number,
            "merchantCode"               => $config->ecocash_merchant_code,//ECOCASH_MERCHANT_CODE,
            "merchantPin"                => $config->ecocash_merchant_pin,//ECOCASH_MERCHANT_PIN,
            "merchantNumber"             => $config->ecocash_merchant_number,//ECOCASH_MERCHANT_NUMBER,
            "notifyUrl"                  => URL::route('shopping.ecocash.listener', ['corrector'=> $clientCorrelator]),
            "paymentAmount"              => array(
                "charginginformation" => array(
                    "amount"      => "$amount",
                    "currency"    => "USD",
                    "description" => 'Storefront Order Payment' //description text to be used for billing information
                ),
                "chargeMetaData"      => array(
                    "onBeHalfOf"           => 'Storefront Store',
                    "purchaseCategoryCode" => 'Online Payment', //indication of the content type
                    "channel"              => $config->ecocash_channel//ECOCASH_CHANNEL
                )
            ),
            "referenceCode"              => $clientCorrelator,
            "transactionOperationStatus" => "Charged",
        );

        error_log("==== REQUEST =====\n".json_encode($ecocash_values, JSON_PRETTY_PRINT)."\n", 3, '/tmp/ecocash.log');

        // Takes the input fields and turn them into the appropriate format
        // for an https post. E.g: "merchantCode=42467&merchantPin=1357"
        $ecocash_string = json_encode($ecocash_values);

        $json_raw = $this->http($config->ecocash_endpoint, $ecocash_string);
        $ecocash_array = json_decode($json_raw, TRUE);

        error_log("==== RESPONSE ====\n".json_encode($ecocash_array, JSON_PRETTY_PRINT)."\n\n", 3, '/tmp/ecocash.log');

        return ['status'=> true, 'data'=>$ecocash_array, 'correlator'=>$clientCorrelator, 'response_data'=>$json_raw, 'datastructer'=> $ecocash_string]; // return the API response in json code
    }

    public function getOrderTransactionStatus($order)
    {
        $config = EcocashConfig::where('ecocash_channel', 'WEB')->first();
        if(!$config){
            return (object)['status'=> false];
        }
        $number = '263'.$order->buyer_phone;

        $this->ecocash_username =$config->ecocash_username;
        $this->ecocash_password = $config->ecocash_password;
        $endpoint = sprintf( $config->ecocash_endpoint_query, $number, urlencode($order->invoice_number));

        $response = $this->get($endpoint);

        return (object)['status'=>true, 'data'=>json_decode($response)];
    }

   
   
}
