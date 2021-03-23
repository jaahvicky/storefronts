<?php

$address_l1 = old('street_address_1');
$address_l2 = old('street_address_2');
$email = old('email');

if (!isset($storeContactDetail) && isset($storeDetail)) {
    if (empty($address_l1)) {
        $address_l1 = $storeDetail->street_address_1;
    }
    if (empty($address_l2)) {
        $address_l2 = $storeDetail->street_address_2;
    }
    if (empty($email)) {
        $email = $storeDetail->email;
    }
}
else {
    $address_l1 = $storeContactDetail->street_address_1;
    $address_l2 = $storeContactDetail->street_address_2;
    $email = $storeContactDetail->email;
}

?>

<!-- contact person details -->
<section id="sp-contact-details" role="store contact details">
    <h2 class="sp-title text-center">Contact Details</h2>
    <p class="sp-subtitle text-center">These are the details of the person we will be in contact with regarding the store creation and management.<br>Fields marked with <span class="accent-orange bold-text">*</span> are required.</p>

    <div class="col-sm-8 col-sm-offset-2">
        
        <div class="row">
            
            <div class="form-group col-sm-6 @hasError('firstname')">
                <label for="firstname">Name <span class="accent-orange bold-text">*</span></label>
                {!! Form::text('firstname', 
                (isset($storeContactDetail) && empty(old('firstname')) ) ? $storeContactDetail->firstname : old('firstname'),
                    ['class' => 'form-control', 'placeholder' => 'First Name', 'id' => 'firstname'] ) !!}    
                @showErrors('firstname')
            </div>
            <div class="form-group col-sm-6 @hasError('lastname')">
                <label for="lastname">Surname <span class="accent-orange bold-text">*</span></label>
                {!! Form::text('lastname', 
                (isset($storeContactDetail) && empty(old('lastname')) ) ? $storeContactDetail->lastname : old('lastname'),
                    ['class' => 'form-control', 'placeholder' => 'Surname', 'id' => 'lastname'] ) !!}    
                @showErrors('lastname')
            </div>
            
        </div>
        
        <div class="form-group @hasError('street_address_1')">
            <label for="street_address_1">Street Address <span class="accent-orange bold-text">*</span></label>
            {!! Form::text('street_address_1', 
                $address_l1,
                ['class' => 'form-control', 'placeholder' => 'Store Address Line 1'] ) !!}    
            {!! Form::text('street_address_2', 
                $address_l2,
                ['class' => 'form-control', 'placeholder' => 'Store Address Line 2'] ) !!}  
            @showErrors('street_address_1') @showErrors('street_address_2')
        </div>

        <div class="form-group city-select-wrapper @hasError('city')">
            <label for="city">City <span class="accent-orange bold-text">*</span></label>
            {{-- {!! Form::text('city',
                (isset($storeContactDetail) && empty(old('city')) ) ? $storeContactDetail->city : old('city'),
                ['class' => 'form-control', 'placeholder' => 'Harare'] ) !!}  --}}

            {!! Form::select('city', $cities,
                (isset($storeContactDetail) && empty(old('city')) ) ? $storeContactDetail->city : old('city'),
                ['class' => 'form-control', 'placeholder' => 'Select a city']); !!}

            @showErrors('city')
        </div>

        <div class="form-group suburb-select-wrapper @hasError('suburb')">
            <label for="suburb">Suburb</label>
            {{-- {!! Form::text('suburb',
                (isset($storeContactDetail) && empty(old('suburb')) ) ? $storeContactDetail->suburb : old('suburb'),
                ['class' => 'form-control', 'placeholder' => 'Suburb'] ) !!}  --}}

            {!! Form::select('suburb', $suburbs,
                (isset($storeContactDetail) && empty(old('suburb')) ) ? $storeContactDetail->suburb : old('suburb'),
                ['class' => 'form-control', 'placeholder' => 'Select a suburb']); !!}
            @showErrors('suburb')
        </div>

        <div class="form-group @hasError('country')">
            <label for="country">Country <span class="accent-orange bold-text">*</span></label>
            {!! Form::select('country', $countries, 
                (isset($storeContactDetail) && empty(old('country')) ) ? $storeContactDetail->country : old('country'),
                ['class' => 'form-control']); !!}    
            @showErrors('country')
        </div>
        
        <div class="row">

            <div class="form-group col-sm-6 @hasError('phone')">
                <label for="phone">Contact Number</label>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">+263</span>
                    <input placeholder="777654321" value="{!! (isset($storeContactDetail) && empty(old('phone')) ) ? $storeContactDetail->phone : old('phone') !!}" type="text" name="phone" id="phone" class="form-control" aria-describedby="basic-addon3">
                </div>
                @showErrors('phone')
            </div>
            
            <div class="form-group col-sm-6 @hasError('email')">
                <label for="email">Email Address</label>
                {!! Form::text('email', 
                    $email,
                    ['class' => 'form-control', 'placeholder' => 'address@domain.com'] ) !!}    
                @showErrors('email')
            </div>
            
        </div>

    </div>
</section>
<!-- store details end -->