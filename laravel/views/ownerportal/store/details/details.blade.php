 <!-- store details -->
<section id="sp-store-details" role="store details">
    <h2 class="text-center sp-title">Store Details</h2>
    <p class="sp-subtitle text-center">Fields marked with <span class="accent-orange bold-text">*</span> are required.</p>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">
            
            <div class="form-group @hasError('store_name')">
                <label for="store_name">Store Name <span class="accent-orange bold-text">*</span></label>
                <small>Choose a store name. This is what your customers will see when they visit your store.</small>
                {!! Form::text('store_name', 
                (isset($store) && empty(old('store_name')) ) ? $store->name : old('store_name'),
                    ['class' => 'form-control', 'placeholder' => 'Store Name', 'id' => 'store-name'] ) !!}    
                @showErrors('store_name')
            </div>
            
            <div class="form-group @hasError('store_type')">
                <label for="store-type">Store Type <span class="accent-orange bold-text">*</span></label>
                <small>Select the type of store you would like. Choose from our wide range of categories to suit your needs.</small>
                {!! Form::select('store_type', $storefront_types,
                    (isset($store) && empty(old('store_type')) ) ? $store->store_type_id : old('store_type'),
                    ['class' => 'form-control', 'placeholder' => 'Select a storefront type']); !!}
                @showErrors('store_type')
            </div>

            <div class="form-group">
            <input type="hidden" name="l1" id="l1" 
            value="{{ ( isset($storeDetail) && empty(old('l1')) ) ? $storeDetail->latitude : old('l1')  }}" />
            </div>

            <div class="form-group">   
            <input type="hidden" name="l2" id="l2" value="{{ ( isset($storeDetail) && empty(old('l2')) ) ? $storeDetail->longitude : old('l2')  }}" />
            </div>

            <div class="form-group @hasError('store_slug')">
                <label for="store_slug">Custom URL <span class="accent-orange bold-text">*</span></label>
                <small>Choose a unique store address. We suggest the following:</small>
                {!! Form::text('store_slug', 
                    (isset($store) && empty(old('store_slug')) ) ? $store->slug : old('store_slug'),
                    ['class' => 'form-control', 'placeholder' => 'Unique store name', 'id' => 'store-slug'] ) !!}    
                @showErrors('store_slug')
            </div>


            <?php
                $street_address_error = false;

                if(isset($errors) && ($errors->first('l1') || $errors->first('l2') || $errors->first('street_address_1'))) {
                    $street_address_error = true;
                }
            ?>
            
            <div class="form-group street-address-1 @if($street_address_error) {{ 'has-error' }} @endif">
                <label for="street_address_1">Street Address <span class="accent-orange bold-text">*</span></label>
                <small>This is the address where your business is based or where any collections or shipping would take place from.</small>
                <small><strong>NOTE: Please start typing your address and select the correct suggestion when you see it.</strong></small>
                {!! Form::text('street_address_1', 
                    (isset($storeDetail) && empty(old('street_address_1')) ) ? $storeDetail->street_address_1 : old('street_address_1'),
                    ['class' => 'form-control', 'placeholder' => 'Address Line', 'id' => 'street_address_1'] ) !!}    
                {{-- {!! Form::text('street_address_2', 
                    (isset($storeDetail) && empty(old('street_address_2')) ) ? $storeDetail->street_address_2 : old('street_address_2'),
                    ['class' => 'form-control', 'placeholder' => 'Address Line 2'] ) !!} --}}

                <span class="street-address-1-message has-error help-block" style="color: #a94442;">&nbsp;</span>

            </div>

            <div class="form-group city-select-wrapper @hasError('city')">
                <label for="city">City <span class="accent-orange bold-text">*</span></label>

                {!! Form::select('city', $cities,
                (isset($storeDetail) && empty(old('city')) ) ? $storeDetail->city_id : old('city'),
                ['class' => 'form-control', 'placeholder' => 'Select a city']); !!}

                @showErrors('city')
            </div>

            <div class="form-group suburb-select-wrapper @hasError('suburb')">
                <label for="suburb">Suburb</label>

                {!! Form::select('suburb', $suburbs,
                (isset($storeDetail) && empty(old('suburb')) ) ? $storeDetail->suburb_id : old('suburb'),
                ['class' => 'form-control', 'placeholder' => 'Select a suburb']); !!}

                @showErrors('suburb')
            </div>

            <div class="form-group @hasError('store_delivery')">
                <label for="store-type">Store Delivery Method <span class="accent-orange bold-text">*</span></label>
                <small>Choose how you would like to deliver products to your customers (more options coming soon)</small>
                {!! Form::select('store_delivery', $storefront_delivery_method,
                    (isset($store) && empty(old('store_delivery')) ) ? $store->store_delivery_method_id : old('store_delivery'),
                    ['class' => 'form-control', 'placeholder' => 'Select a store delivery method']); !!}
                @showErrors('store_delivery')
            </div>


            <div class="form-group @hasError('country')">
                <label for="country">Country <span class="accent-orange bold-text">*</span></label>
                {!! Form::select('country', $countries, 
                    (isset($storeDetail) && empty(old('country')) ) ? $storeDetail->country : old('country'),
                    ['class' => 'form-control']); !!}    
                @showErrors('country')
            </div>
            
            <div class="form-group @hasError('email')">
                <label for="email">Store Email Address</label>
                <small>We will use this email address for all store related communication, including new orders.</small>
                {!! Form::text('email', 
                    (isset($storeDetail) && empty(old('email')) ) ? $storeDetail->email : old('email'),
                    ['class' => 'form-control', 'placeholder' => 'address@domain.com'] ) !!}    
                @showErrors('email')
            </div>
            
            <div class="form-group @hasError('phone')">
                <label for="phone">Store Contact Number <span class="accent-orange bold-text">*</span></label>
                <small>You'll need an Econet mobile number to create a store. We'll use this number to create an Ownai account for you, should you not already have one.</small>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">+263</span>
                    <input placeholder="777654321" value="{!! (isset($storeDetail) && empty(old('phone')) ) ? $storeDetail->phone : old('phone') !!}" type="text" name="phone" id="phone" data-methys-valid="phone-zim" class="form-control" aria-describedby="basic-addon3">
                </div>
                @showErrors('phone')
            </div>

        </div>	  	   	  					  						  
    </div>
</section>
<!-- store details end -->