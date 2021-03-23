@extends('backoffice/layout/default')

@section('content')

    @css('/css/backoffice.css')
    @js('/js/backoffice/account/login.js')
    @js('/js/backoffice/account/details.js')
    
    @include('backoffice.account.login', [])
    
    @include('backoffice.account.settings', [])

    @include('backoffice.account.details', [])
    
    @include('backoffice.account.notification-preferences', [])    
    
    {!! (isset($store)) ? Form::hidden('store_id', $store->id) : "" !!}

    {!! Form::button('Cancel', ['class' => 'btn btn-inverse btn-flat', 'onclick' => 'location.reload()']) !!}
    {!! Form::submit('Save', ['class' => 'btn btn-primary btn-flat']) !!}
    
    {!! Form::close() !!}
    
@stop

