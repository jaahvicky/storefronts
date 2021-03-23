<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Store Details</h3>
        <p>These details will reflect on the <a href="#">contact details</a> page</p>
    </div>
    
    <div class='box-body'>
 
        <div class="form-group @hasError('name')">
            {!! Form::Label('name', 'Store Name', ['class' => '']) !!}
            {!! Form::text('name', 
                \ViewHelper::showValue(old('name'), $store, 'name'),
                ['class' => 'form-control', 'placeholder' => 'Store Name'] ) !!}    
            @showErrors('name')
        </div>

        <div class="form-group">
            <input type="hidden" name="l1" id="l1" 
            value="{{ ( isset($store->details) && empty(old('l1')) ) ? $store->details->location_lat : old('l1')  }}" />
            </div>

        <div class="form-group">   
        <input type="hidden" name="l2" id="l2" value="{{ ( isset($store->details) && empty(old('l2')) ) ? $store->details->location_lng : old('l2')  }}" />
        </div>

        <?php
                $street_address_error = false;

                if(isset($errors) && ($errors->first('l1') || $errors->first('l2') || $errors->first('street_address_1'))) {
                    $street_address_error = true;
                }
            ?>
        
        <div class="form-group street-address-1 @if($street_address_error) {{ 'has-error' }} @endif">
            {!! Form::Label('street_address_1', 'Address', ['class' => '']) !!}<br />
            <small><strong>NOTE: Please start typing your address and select the correct suggestion when you see it.</strong></small>
            {!! Form::text('street_address_1', 
                \ViewHelper::showValue(old('street_address_1'), $store->details, 'street_address_1'), 
                ['class' => 'form-control', 'placeholder' => 'Address Line', 'id' => 'street_address_1'] ) !!}    
            {{-- {!! Form::text('street_address_2', 
                \ViewHelper::showValue(old('street_address_2'), $store->details, 'street_address_2'), 
                ['class' => 'form-control', 'placeholder' => 'Address Line 2'] ) !!}     --}}
            @showErrors('street_address_1')
            {{-- @showErrors('street_address_2') --}}

            <span class="street-address-1-message has-error help-block" style="color: #a94442;">&nbsp;</span>

        </div>

        <div class="form-group city-select-wrapper @hasError('city')">

            {!! Form::Label('city', 'City', ['class' => '']) !!}

            {{-- {!! Form::text('city',
                \ViewHelper::showValue(old('city'), $store->details, 'city'),
                ['class' => 'form-control', 'placeholder' => 'City']) !!} --}}

            {!! Form::select('city', $cities,
                (isset($store->details) && empty(old('city')) ) ? $store->details->city_id : old('city'),
                ['class' => 'form-control', 'placeholder' => 'Select a city']); !!}

            @showErrors('city')
        </div>
        
        <div class="form-group suburb-select-wrapper @hasError('suburb')">

            {!! Form::Label('suburb', 'Suburb', ['class' => '']) !!}

            {{-- {!! Form::text('suburb',
                \ViewHelper::showValue(old('suburb'), $store->details, 'suburb'), 
                ['class' => 'form-control', 'placeholder' => 'Suburb'] ) !!} --}}

            {!! Form::select('suburb', $suburbs,
            (isset($store->details) && empty(old('suburb')) ) ? $store->details->suburb_id : old('suburb'),
            ['class' => 'form-control', 'placeholder' => 'Select a suburb']); !!}

            @showErrors('suburb')
        </div>
        
        <div class="form-group @hasError('country')">
            {!! Form::Label('country', 'Country', ['class' => '']) !!}
            {!! Form::select('country', $countries, 
                \ViewHelper::showValue(old('country'), $store->details, 'country'),
                ['class' => 'form-control']) !!}    
            @showErrors('country')
        </div>
        
        <div class="form-group form-inline @hasError('phone')">
            {!! Form::Label('phone', 'Phone', ['class' => '']) !!}
            @addZimCell(['phone', \ViewHelper::showValue(old('phone'), $store->details, 'phone'), 
            ['id' => 'store_details_phone', 'data-methys-valid' => 'phone-zim']])
            @showErrors('phone')
        </div>
        
        <div class="form-group @hasError('email')">
            {!! Form::Label('email', 'Email', ['class' => '']) !!}
            {!! Form::email('email', 
                \ViewHelper::showValue(old('email'), $store->details, 'email'),
                ['class' => 'form-control', 'placeholder' => 'address@domain.com', 'data-methys-valid' => 'email'] ) !!}    
            @showErrors('email')
        </div>
        
        <div class="form-group @hasError('collection_hours')">
            {!! Form::Label('collection_hours', 'Business Hours', ['class' => '']) !!}
            {!! Form::textarea('collection_hours', 
                \ViewHelper::showValue(old('collection_hours'), $store->details, 'collection_hours'),
                ['class' => 'form-control', 'placeholder' => "Mon - Fri: 9am - 5pm, Sat and Sun: Closed"] ) !!}    
            @showErrors('collection_hours')
        </div>
        
    </div>
        
</div>
<style type="text/css">
   .help-block {
     color: #a94442!important;
    }
</style>