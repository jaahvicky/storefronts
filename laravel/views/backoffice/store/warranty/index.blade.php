@extends('backoffice/layout/default')

@section('content')

    @js('plugins/ckeditor/ckeditor.js')
    <link href="{{ asset('/css/backoffice.css') }}" rel="stylesheet">
    @js('/js/backoffice/store/warranty.js')
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.store.warranty.update']) !!}

    @include('backoffice.store.warranty.warranty', [])
    
    {!! (isset($store)) ? Form::hidden('store_id', $store->id) : "" !!}

    {!! Form::button('Cancel', ['class' => 'btn btn-inverse btn-flat', 'onclick' => 'location.reload()']) !!}
    {!! Form::submit('Save', ['class' => 'btn btn-primary btn-flat']) !!}
    
    {!! Form::close() !!}
    
@stop

