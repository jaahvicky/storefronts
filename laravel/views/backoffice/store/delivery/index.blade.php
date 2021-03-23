@extends('backoffice/layout/default')

@section('content')

    <link href="{{ asset('/css/backoffice.css') }}" rel="stylesheet">
    
	{{-- @js('/js/backoffice/store/appearance.js') --}}
    
    {!! Form::model($store, ['class' => 'form', 'role' => 'form', 'route' => 'admin.store.delivery.update']) !!}

    	@include('backoffice.store.delivery.delivery')
    
    {!! (isset($store)) ? Form::hidden('store', $store->id) : "" !!}

    {!! Form::submit('Update', ['class' => 'btn btn-primary btn-flat']) !!}
    
    {!! Form::close() !!}
    
@stop