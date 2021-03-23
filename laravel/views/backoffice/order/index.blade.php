@extends('backoffice/layout/default')

@section('content')

    <link href="{{ asset('/css/backoffice.css') }}" rel="stylesheet">
    @js('/js/backoffice/order/index.js')
    @js('/js/backoffice/order/store.js')
    @js('/js/backoffice/order/category.js')
    @js('/js/backoffice/order/product.js')
    
    @css('plugins/jquery-ui-1.11.4.custom/jquery-ui.min.css')
    @css('plugins/jquery-ui-smoothness/jquery-ui.css')
    @css('plugins/methys-fileupload/methys-fileupload.css')
    @css('plugins/adminlte-2.3.0/css/ion.rangeSlider.css')
    @css('plugins/adminlte-2.3.0/css/ion.rangeSlider.skinNice.css')
    
    @js('plugins/jquery-ui-1.11.4.custom/jquery-ui.min.js')
    @js('plugins/methys-fileupload/jquery.iframe-transport.js')
    @js('plugins/methys-fileupload/jquery.fileupload.js')
    @js('plugins/methys-fileupload/methys-fileupload.js')
    @js('plugins/adminlte-2.3.0/js/ion.rangeSlider.min.js')
     
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.order.update', 'id' => 'orderForm']) !!}
    
    @include('backoffice.order.store', [])

    @include('backoffice.order.category', [])

    @include('backoffice.order.product', [])

    @include('backoffice.order.items', [])

    @include('backoffice.order.buyer', [])

    @include('backoffice.order.currency', [])

    @if( isset($order_id) )
        @include('backoffice.order.status', [])
        @include('backoffice.order.payment_status', [])
        @include('backoffice.order.delivery_status', [])
        @include('backoffice.order.payment_method', [])
    @endif
    
    <!-- @include('backoffice.order.visibility', [])    --> 
    <div class="alert alert-warning alert-dismissible email-errors-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Info!</h4>
        Order Saved ... But We couldn't send the email, please edit your order with the correct email address.
    </div>
    <div class="alert alert-warning alert-dismissible sms-errors-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Info!</h4>
        Order Saved ... But We couldn't send the sms, please edit your order with the right phone number.
    </div>
    <div class="alert alert-danger alert-dismissible order-errors-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Error!</h4>
        Please check for the errors in your order, and re-submit ...
    </div>
    <div class="alert alert-success alert-dismissible order-success-alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> Success!</h4>
        Your order has been saved ...
    </div>
    <div>
        <small>        
            By publishing a order, you agree and accept Ownai Storefronts

            <a href="#">Terms & Conditions</a>
        </small>
        <br/><br/>
    </div>
    
    {!! (isset($order)) ? Form::hidden('order_id', $order->id) : "" !!}

    {!! Form::button('Cancel', ['class' => 'btn btn-inverse btn-flat', 'onclick' => 'location.reload()']) !!}
    @if(isset($cur_order))
    {!! Form::hidden('cur_order_id', $cur_order->id) !!}
    {!! Form::submit('Save & Submit for Moderation', ['class' => 'btn btn-primary btn-flat', 'id' => 'saveButton']) !!}
    @else
    {!! Form::submit('Save & Submit for Moderation', ['class' => 'btn btn-primary btn-flat', 'id' => 'saveButton', 'disabled']) !!}
    @endif
    
    {!! Form::close() !!}
    
@stop

