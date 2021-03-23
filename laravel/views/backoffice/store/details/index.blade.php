@extends('backoffice/layout/default')

@section('content')

    <link href="{{ asset('/css/backoffice.css') }}" rel="stylesheet">
    @js('/js/backoffice/store/details.js')
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.store.details.update', 'id' => 'backend-store-details']) !!}

    @include('backoffice.store.details.details', [])
    
    {!! (isset($store)) ? Form::hidden('store_id', $store->id) : "" !!}

    {!! Form::button('Cancel', ['class' => 'btn btn-inverse btn-flat', 'onclick' => 'location.reload()']) !!}
    {!! Form::submit('Save', ['class' => 'btn btn-primary btn-flat']) !!}
    
    {!! Form::close() !!}

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

