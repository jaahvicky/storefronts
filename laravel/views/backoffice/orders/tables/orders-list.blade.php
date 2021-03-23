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

@foreach($orders as $order)
                            
    <tr role="row">
        
        <td class="order-nr">
        	<a class="" href="{{ URL::route('orders.details', ['id' => $order->id]) }}">{{ $order->invoice_number }}</a>
        </td>
        <td class="order-date">
        	{{ date('d/m/Y', strtotime($order->created_at))  }}
        </td>
        <td class="buyer-details">
        	Full Name : <strong>{{ $order->buyer_firstname }} {{ $order->buyer_lastname }}</strong> <br />
            Address : <strong>{{ $order->buyer_address }}</strong> <br />
            Contact no : <strong>+263{{ $order->buyer_phone }}</strong> <br /> 
            Email : <strong>{{ $order->buyer_email }}</strong>
        </td>
        <td class="item-count">
        	{{ LookupHelper::OrderItemsTotal($order->id) }}
        </td>
        <td class="total-price">
        	${{ $order->amount }}
        </td>
        <td class="payment-status text-lowercase" >
          {{ $order->payment_status }}

        </td>
        <td class="delivery-status">
            {{ $order->delivery_status }}
        </td>
        <td class='table-actions'>
            <a class="" href="{{ URL::route('orders.details', ['id' => $order->id]) }}"><span class="glyphicon glyphicon-th-list"></span></a>
            
        </td>
    </tr>
    
@endforeach