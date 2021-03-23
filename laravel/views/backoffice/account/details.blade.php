<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Store Owner Details</h3>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('firstname')">
            {!! Form::Label('firstname', 'Name', ['class' => '  ']) !!}
            {!! Form::text('firstname', 
                \ViewHelper::showValue(old('firstname'), $store->contactDetails, 'firstname'),
                ['class' => 'form-control', 'placeholder' => 'Name'] ) !!}    
            @showErrors('firstname')
        </div>
        
        <div class="form-group @hasError('lastname')">
            {!! Form::Label('lastname', 'Surname', ['class' => '  ']) !!}
            {!! Form::text('lastname', 
                \ViewHelper::showValue(old('lastname'), $store->contactDetails, 'lastname'),
                ['class' => 'form-control', 'placeholder' => 'Surname'] ) !!}    
            @showErrors('lastname')
        </div>
        
        <div class="form-group @hasError('street_address_1')">
            {!! Form::Label('street_address_1', 'Address', ['class' => '  ']) !!}
            {!! Form::text('street_address_1', 
                \ViewHelper::showValue(old('street_address_1'), $store->contactDetails, 'street_address_1'),
                ['class' => 'form-control', 'placeholder' => 'Address Line 1'] ) !!}    
            {!! Form::text('street_address_2', 
                \ViewHelper::showValue(old('street_address_2'), $store->contactDetails, 'street_address_2'),
                ['class' => 'form-control', 'placeholder' => 'Address Line 2'] ) !!}    
            @showErrors('street_address_1')
            @showErrors('street_address_2')
        </div>

        <div class="form-group city-select-wrapper @hasError('city')">
            {!! Form::Label('city', 'City', ['class' => '']) !!}
            {{-- {!! Form::text('city',
                \ViewHelper::showValue(old('city'), $store->contactDetails, 'city'),
                ['class' => 'form-control', 'placeholder' => 'City']) !!}  --}}

            {!! Form::select('city', $cities,
                (isset($store->contactDetails) && empty(old('city')) ) ? $store->contactDetails->city_id : old('city'),
                ['class' => 'form-control', 'placeholder' => 'Select a city']); !!}

            @showErrors('city')
        </div>
        
        <div class="form-group suburb-select-wrapper @hasError('suburb')">
            {!! Form::Label('suburb', 'Suburb', ['class' => '  ']) !!}
            {{-- {!! Form::text('suburb',
                \ViewHelper::showValue(old('suburb'), $store->contactDetails, 'suburb'),
                ['class' => 'form-control', 'placeholder' => 'Suburb'] ) !!}  --}}

            {!! Form::select('suburb', $suburbs,
                (isset($store->contactDetails) && empty(old('suburb')) ) ? $store->contactDetails->suburb_id : old('suburb'),
                ['class' => 'form-control', 'placeholder' => 'Select a suburb']); !!}

            @showErrors('suburb')
        </div>

        <div class="form-group @hasError('country')">
            {!! Form::Label('country', 'Country', ['class' => '  ']) !!}
            {!! Form::select('country', $countries, 
                \ViewHelper::showValue(old('country'), $store->contactDetails, 'country'),
                ['class' => 'form-control']); !!}    
            @showErrors('country')
        </div>
        
        <div class="form-group form-inline @hasError('phone')">
            {!! Form::Label('phone', 'Phone', []) !!}
            @addZimCell(['phone', \ViewHelper::showValue(old('phone'), $store->contactDetails, 'phone'), 
            ['id' => 'phone', 'data-methys-valid' => 'phone-zim']])
            @showErrors('phone')
        </div>
        
        <div class="form-group @hasError('email')">
            {!! Form::Label('email', 'Email', ['class' => '  ']) !!}
            {!! Form::email('email', 
                \ViewHelper::showValue(old('email'), $store->contactDetails, 'email'),
                ['class' => 'form-control', 'placeholder' => 'address@domain.com', 'id' => 'email', 'data-methys-valid' => 'email'] ) !!}    
            @showErrors('email')
        </div>
        
    </div>
    
</div>
<style type="text/css">
   .help-block {
     color: #a94442!important;
    }
</style>