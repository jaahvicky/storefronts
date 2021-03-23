@extends('ownerportal/layout/default')

@section('stepper')
    @include('ownerportal.layout.stepper')
@stop

@section('content')

    @css('/css/ownerportal.css')
    @js('plugins/methys-javascript/methys.ownai-validator.js')
    @js('/js/ownerportal/store/details.js')
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'store.setup.details.update']) !!}
    
    {!! (isset($store)) ? Form::hidden('store_id', $store->id) : "" !!}
    
    @include('ownerportal.store.details.details')
    @include('ownerportal.store.details.classified')
    
    @include('ownerportal.store.details.login')
    
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary" id="submit_btn">Continue <i class="material-icons sp-btn-ic">arrow_forward</i></button>
    </div>	
    
    {!! Form::close() !!}
    <br/><br/>

    <!-- Google Api things -->

    <?php $google_api_key = config('storefronts-owner-portal.google-api-key'); ?>

    <script>
        var google_api_key = '<?php echo $google_api_key; ?>';

        function initAutocomplete()
        {
            street_address_1 = new google.maps.places.Autocomplete(
            (document.getElementById('street_address_1')),
            {types: ['geocode']}
            );

            street_address_1.setComponentRestrictions({ country: ['zw'] });

            street_address_1.addListener('place_changed', getCoord);

        }

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $google_api_key }}&libraries=places&callback=initAutocomplete"
            async defer></script>


@stop 

