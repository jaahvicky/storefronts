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
    @js('/js/backoffice/product/angular.min.js')
    @js('/js/backoffice/store/angularSync.js')
    @js('/js/backoffice/store/migration.js')
    

    @include('backoffice.store.migration.login', [])
    @include('backoffice.store.migration.items', [])
    @include('backoffice.store.migration.loading-modal', [])
    
    
@stop

