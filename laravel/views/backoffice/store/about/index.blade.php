@extends('backoffice/layout/default')

@section('content')

    @js('plugins/ckeditor/ckeditor.js')
    @js('/js/backoffice/store/about.js')
    <link href="{{ asset('/css/backoffice.css') }}" rel="stylesheet">
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.store.about.update']) !!}

    @include('backoffice.store.about.exerpt', [])
    
    @include('backoffice.store.about.description', [])
    
    {!! (isset($store)) ? Form::hidden('store_id', $store->id) : "" !!}

    {!! Form::button('Cancel', ['class' => 'btn btn-inverse btn-flat', 'onclick' => 'location.reload()']) !!}
    {!! Form::submit('Save', ['class' => 'btn btn-primary btn-flat']) !!}
    
    {!! Form::close() !!}
    
@stop

