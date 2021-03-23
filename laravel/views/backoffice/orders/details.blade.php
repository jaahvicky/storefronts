<?php 

/*
 * Copyright (c) 2017 Methys Digital
 * All rights reserved.
 *
 * This software is the confidential and proprietary information of Methys Digital.
 * ("Confidential Information"). You shall not disclose such
 * Confidential Information and shall use it only in accordance with
 * the terms of the license agreement you entered into with Methys Digital.
 */

?>

@extends('backoffice/layout/default')

@section('content')



    {{-- Order Details and Billing Address --}}
    <div class='box box-primary'>
        <div class="box-header">
            <h3 class="box-title">Details</h3>
            <div class="print"><a href="{{ URL::route('orders.print_invoice', ['id' => $order->id]) }}" target="_blank">Print Invoice <span class="fa fa-print">&nbsp;</span></a></div>
        </div>

        <!-- /.box-header -->
        <div class="row box-body">
            <div class="order-general col-md-4">
            	<p><strong class="order-detail-label">Date</strong>{{ date('d/m/Y', strtotime($order->created_at)) }}</p>
            	<p><strong class="order-detail-label">Time</strong>{{ date('h:i:s A', strtotime($order->created_at)) }}</p>

            	<div class="form-group  @if($errors->has('status')) has-error @endif">
                    <label for="status" class="order-detail-label">Status</label>
                    {!! Form::select('status', $delivery_status, 
                    (isset($order) && empty(old('status')) ) ? $order->delivery_status_id : old('status'),
                    ['class' => 'form-control', 'disabled' => 'disabled']); !!}  
                    @php \ViewHelper::showErrors(('status')); @endphp
                </div>

                @if(isset($modals_btn))

                <div class="order-status-btns">

                    @foreach($modals_btn as $modal_btn)

                    @if($modal_btn === 'start')

                        <button id="start-mod" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#start-modal">Start Order</button>

                    @elseif($modal_btn === 'dispatched')

                        <button id="dispatched-mod" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#dispatched-modal">Dispatched</button>

                    @elseif($modal_btn === 'collection')

                        <button id="collection-mod" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#collection-modal">Ready for Collection</button>

                    @elseif($modal_btn === 'complete')

                        <button id="complete-mod" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#complete-modal">Complete Order</button>

                    @elseif($modal_btn === 'cancel')

                        <button id="cancel-mod" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#cancel-modal">Cancel Order</button>

                    @else

                    @endif

                    @endforeach

                </div>

                @endif

            </div>
            <div class="order-billing smaller-box col-md-8">
            	<a href="#" class="pencil order-billing-modal" data-target="#order-billing-modal"><span class="fa fa-pencil">&nbsp;</span></a>
    			<div class="row">
    				<div class="col-md-5">
    				   <h5 class="smaller-box-title">Billing Info</h5>
    				   {{ $order->buyer_firstname}} {{ $order->buyer_lastname }}<br />
    				   {{ $order->buyer_address}}
    				</div>
    				<div class="col-md-7">
    					<h5 class="smaller-box-title">Email</h5>
    					{{ $order->buyer_email }}
    					<h5 class="smaller-box-title margin-t-35">Phone</h5>
    					+263{{ $order->buyer_phone }}
    				</div>
    			</div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>


    {{ Form::model($order, [ 'route' => ['orders.update', $order->id], 'id' => 'form-order-detail', 'method' => 'put' ]) }}

    {{-- Order Items --}}
    <div class='box box-primary'>
        <div class="box-header">
            <h3 class="box-title">Order Items</h3>
        </div>
        <!-- /.box-header -->

        <!-- Order Items -->

        <div class="order-items">

            <?php $total = 0; ?>

            @foreach($order->orderItems as $orderItem)

                <?php 
                    $product    = $orderItem->product;
                    $price      = $product->price * $orderItem->qty;
                    $image      = $product->images->first();
                    $image_url  = '';
                    $thumbnail = asset('images/samples/image-holder.jpg');
                    
                    if ($image) {
                        $image_url = \ImageHelper::resizeImage($image->filename, 85, 85);
                        if ($image_url) {
                            $thumbnail = asset($image_url);
                        }
                    }
                    // TEST : WHAT IF THERE IS NO IMAGE 
                ?>
            
                <div class="order-item">
                	<div class="item-img @if(!$image_url) no-item-img @endif">
                		<img src="{{ $thumbnail }}" />
                	</div>
                	<div class="item-info">
                		<h4 class="item-name">{{ $product->title }}</h4>
                		<span class="item-variant">{{ $product->description }}</span>
                		<span class="item-quantity-confirmation">Quantity : <strong>{{ $orderItem->qty }}</strong></span>
                	</div>
                	<div class="item-price">
                        <span>${{ ($price/100) }}</span>

                	</div>
                </div>

                <?php $total += $price; ?>

            @endforeach

        </div>

        <!-- /.Order Items -->

        <!-- /.box-body -->
    </div>  

    {{-- Order Costs  --}} 
    <div class='order-costs box no-border'>
        <!-- /.box-header -->
        <div class="box-body smaller-box">
            <p class="order-total">Total <span>${{ ($total/100) }}</span></p>
        </div>
        <!-- /.box-body -->
    </div>  

    {{-- Order Notes  --}} 
    <div class='box box-primary'>
        <div class="box-header">
            <h3 class="box-title">Order Notes</h3>
            <p>Leave a note as a reference or reminder. Order notes are only visible on this screen</p>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
           	<div class="form-group @hasError('order_notes')">
                {!! Form::textarea('order_notes', 
                    \ViewHelper::showValue(old('order_notes'), (isset($order)) ? $order : null, 'order_notes'),
                    ['class' => 'form-control', 'placeholder' => "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu."] ) !!}    
                <?php \ViewHelper::showErrors('order_notes') ?>
            </div>
        </div>
        <!-- /.box-body -->
    </div>

    <a href="{{ route('orders.index') }}" class="btn btn-inverse btn-flat" style="color: #333; background-color: #DDD;">Back to orders</a>

    {{ Form::submit('Save', ['class' => 'btn btn-primary btn-flat', 'id' => 'saveButton']) }}

{{ Form::close() }}

@if(isset($modals_info))

    @foreach($modals_info as $modal_info)

        @include('backoffice.orders.modal.modal-status', ['modal_info' => $modal_info])

    @endforeach

@endif

@include('backoffice.orders.modal-edit-buyer-billing')

@stop