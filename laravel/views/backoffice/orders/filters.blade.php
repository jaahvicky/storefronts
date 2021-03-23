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

<div class='row row-vertical-margin row-filters' data-methys-filter="container" 
    data-methys-filter-url="{{URL::route('ajax-filters-queue', ['tag'=>'orders'])}}" data-methys-refresh-url="{{ URL::route('orders.get_orders') }}">
    <!-- search customer -->
    <div class='col-xs-12'>
        <div class='form-inline'>

            Filter by

            <?php //print_r(LookupHelper::getOrderStatus()); ?>
            
            <div class="btn-group" data-methys-filter='dropdown-toggle'>
                <button class="btn btn-default btn-label" data-methys-ses="container" data-methys-session-url="{{ URL::route('get_order_session') }}" >Order status </button>
                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Pending <span class="caret"></span></button>
                <ul class="dropdown-menu noclose">
                     <li>
                        <input type="radio"
                            id="orderStatusAny" 
                            name="orderStatus[]" 
                            value="any"
                            {{ SortFilterHelper::isFilterArrayValueSet('orderStatus', 'any', 'orders') ? 'checked="checked"':'' }}
                            >
                        <label for="orderStatusAny">Any</label>
                    </li>

                    @foreach (LookupHelper::getOrderStatus() as $type)
                    <li>
                        <input type="radio"
                            id="orderStatus{{$type->status}}" 
                            name="orderStatus[]" 
                            value="{{$type->id}}"
                            {{ SortFilterHelper::isFilterArrayValueSet('orderStatus', $type->id, 'orders') ? 'checked="checked"':'' }}
                            >
                        <label for="orderStatus{{$type->status}}">{{$type->status}}</label>
                    </li>

                    @endforeach

                   
                </ul>
            </div>

        </div>
    </div>
</div>

@js('plugins/methys-javascript/methys.filters.js')
@js('plugins/methys-javascript/methys.filters.orders.js')
@js('plugins/bootstrap-dropdowns-enhancement/v3.1.1-beta/dropdowns-enhancement.js')
@js('/js/backoffice/products/filters.js')

@css('plugins/bootstrap-dropdowns-enhancement/v3.1.1-beta/dropdowns-enhancement.css')
@css('css/backoffice.css')
