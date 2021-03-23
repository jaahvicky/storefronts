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

@extends('backoffice/layout/print')

@section('content')

<div class="box no-border">
	<p>Store Address : </p>
	<p><strong>
		{{ $store_contact_details->street_address_1 }}<br />
		@if($store_contact_details->street_address_2)
			{{ $store_contact_details->street_address_2}}<br />
		@endif
		{{ $store_contact_details->suburb}}<br />
		{{ $store_contact_details->city}}<br />
		{{ $store_country }}
	</strong></p>
</div>

<div class="general-info box box-default">

	<p><span class="invoice-date">Date: <strong>{{ $order->created_at }}</strong></span><br />
	<span class="invoice-time">Time: <strong>{{ $order->created_at }}</strong></span><br />
	<span class="invoice-nr">Invoice Nr: <strong>{{ $order->invoice_nr }}</strong></span><br />
	</p>

</div>

<div class="billing-info box box-default">
	
	<p>Billing Information: </p>
	<p><strong>
		{{ $order->buyer_firstname}} {{ $order->buyer_lastname }}<br />
		{{ $order->buyer_address_line_1 }}<br />
		@if ($order->buyer_address_line_2)
		    {{ $order->buyer_address_line_2 }}<br />
		@endif
		{{ $order->buyer_suburb }}<br />
		{{ $order->buyer_city }}<br />
		{{ $order->buyer_province_state }}<br />
		{{ $order->buyer_country }}
		@if ($order->buyer_postal_code)
			<br />{{ $order->buyer_postal_code }}
		@endif
	</strong></p>
</div>


<p>Order Items :</p>

<div class="invoice-items">

<?php $total = 0; ?>

	@foreach($order->orderItems as $orderItem)

	    <?php 
	        $product    = $orderItem->product;
	        $price      = $product->price;
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
	    	<div class="item-info">
	    		<h4 class="item-name">{{ $product->title }}</h4>
	    		<span class="item-variant">{{ $product->description }}</span>
	    		<span class="item-quantity-confirmation">Quantity : <strong>{{ $orderItem->qty }}</strong></span>
	    	</div>
	    	<div class="item-price">
	    		<strong>Total Price:</strong> <span>{{ $order->currency }} {{ $price * $orderItem->qty }}</span>
	    	</div>
	    	<div class="item-price">
				<strong>Unit Price:</strong> <span>{{ $order->currency }} {{ $price}}</span>
	    	</div>
	    </div>

	    <?php $total += $price * $orderItem->qty; ?>

	@endforeach

</div>

<div class='order-costs box'>
    <p class="order-subtotal">Item / s Total <span>{{ $order->currency }} {{ number_format($total, 2) }}</span></p>
    <p class="order-tax">VAT <span>14%</span></p>
    <p class="order-total">Total <span>{{ $order->currency }} {{ number_format($total*1.14, 2) }}</span></p>
</div>  

@stop