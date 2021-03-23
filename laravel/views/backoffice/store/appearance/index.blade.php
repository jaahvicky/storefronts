@extends('backoffice/layout/default')

@section('content')

    <link href="{{ asset('/css/backoffice.css') }}" rel="stylesheet">
    @css('plugins/colorpicker/bootstrap-colorpicker.min.css')
    @css('plugins/jquery-ui-1.11.4.custom/jquery-ui.min.css')
    @css('plugins/jquery-ui-smoothness/jquery-ui.css')
    @css('plugins/methys-fileupload/methys-fileupload.css')
    
    @js('plugins/jquery-ui-1.11.4.custom/jquery-ui.min.js')
    @js('plugins/colorpicker/bootstrap-colorpicker.min.js')
    @js('plugins/methys-fileupload/jquery.iframe-transport.js')
    @js('plugins/methys-fileupload/jquery.fileupload.js')
    @js('plugins/methys-fileupload/methys-fileupload.js')
    
    @js('/js/backoffice/store/appearance.js')
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.store.appearance.update']) !!}

    @include('backoffice.store.appearance.logo', [])
    
    @include('backoffice.store.appearance.banner', [])
    
    @include('backoffice.store.appearance.colours', [])
    
    {!! (isset($store)) ? Form::hidden('store_id', $store->id) : "" !!}

    {!! Form::button('Cancel', ['class' => 'btn btn-inverse btn-flat', 'onclick' => 'location.reload()']) !!}
    {!! Form::submit('Save', ['class' => 'btn btn-primary btn-flat']) !!}
    
    {!! Form::close() !!}
    
@stop

