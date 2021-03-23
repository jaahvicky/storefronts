<?php
$number = (isset($storePaymentDetail)) ? $storePaymentDetail->number : old('number');
if (isset($store) && isset($storeContactDetail) && empty($number)) {
    $number = $storeContactDetail->phone;
}

$accountTypeMer = (isset($storePaymentDetail) && !empty($storePaymentDetail->name));
$accountTypeSub = (isset($storePaymentDetail) && empty($storePaymentDetail->name));

if (!$accountTypeMer && !$accountTypeSub) {
    $accountTypeSub = true;
}

?>

<!-- contact person details -->
<section id="sp-ecocash-details" role="ecocash details">
    <h2 class="sp-title text-center">EcoCash Details</h2>
    <p class="sp-subtitle text-center">You qualify for a promotional 30 days <span class="accent-blue bold-text">FREE</span> when you open a storefront.<br>Thereafter ${!! $cost->amount !!}.00 will be deducted from your Ecocash account every month. <br><br />You can cancel at anytime during the trial period with NO CHARGE.<br>Please see our terms and conditions for further details on pricing.<br/><br/>Fields marked with <span class="accent-orange bold-text">*</span> are required.</p>
    <div class="col-sm-8 col-sm-offset-2">
        
        <div class="row">

            <div class="form-group col-sm-12 ">
                <div class="radio">
                    <label>
                        {{ Form::radio('account_type', 'subscriber-acc', $accountTypeSub) }}
                        EcoCash Subscriber Account
                    </label>
                </div>
                <small>Select this option if you would like to pay for your store with an Ecocash subscriber account.</small>
            </div>

           <!--  <div class="form-group col-sm-6">
                <div class="radio">
                    <label>
                        {{ Form::radio('account_type', 'merchant-acc', $accountTypeMer) }}
                        EcoCash Merchant Account 
                    </label>
                </div>
                <small>Select this option if you would like to pay for your store with an Ecocash merchant account.</small>
            </div>		 -->										
        </div>

     <!--    <span id="section-merchant">

            <p class="text-center">We will contact you for payment before your trial period is over. In the meantime you can proceed to open your store and begin trading.</p>
            
             <div class="form-group @hasError('name')">
                <label for="name">EcoCash Merchant Name</label>
                <input type="text" value="{!! (isset($storePaymentDetail)) ? $storePaymentDetail->name : '' !!}" class="form-control" id="eco-merchant-name" name="name" placeholder="Merchant Name">
                @showErrors('name')
            </div>					
            <div class="form-group @hasError('number')">

                <label for="number">EcoCash Merchant Number <span class="accent-orange bold-text">*</span></label>
               <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">+263</span>
                    <input type="text" value="{!! (isset($storePaymentDetail)) ? $storePaymentDetail->number : '' !!}" class="form-control" id="eco-merchant-number" value="{!! $number !!}" name="number" placeholder="Merchant Number">
                
                </div>
                @showErrors('number')
                
            </div>  
            
        </span> -->
        
        <span id="section-subscriber">
            
            <div class="form-group @hasError('number')">
                <label for="number">EcoCash Subscriber Number</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">+263</span>
                    <input type="text" class="form-control" id="eco-subscriber-number" value="{!! (isset($storePaymentDetail) && empty(old('number'))) ? $storePaymentDetail->number : old('number') !!}" name="number" placeholder="Subscriber Number">

                </div>
                @showErrors('number')
            </div>
            
        </span>
        
    </div>
</section>