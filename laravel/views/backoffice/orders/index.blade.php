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

<div class="btn-group sort-by" data-methys-filter='dropdown-toggle'>
    <input type="hidden" id="orderbycolumn" name="orderByColumn[]" />
</div>


<div class='box box-primary'>
    <div class="box-header">
        <h3 class="box-title">Order List</h3>
        <div class="header-right">
            <div class="order-list-filter">
                @include('backoffice.orders.filters') 
            </div>
            <div class="order-list-export">
                <a class="" href="#" data-toggle="modal" data-target="#order-export-modal">Export to CSV  <span class="icon-export">&nbsp;</span></a>
            </div>
            <div class="order-list-refresh">
                Refresh <span class="fa fa-refresh">&nbsp;</span>
            </div>
        </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap" id="order-list">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>  
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table role="grid" id="order-list" class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr role="row">
                                <th class="order_no item-order-by" data-order-name='order-no'><i class="order fa " ></i> Order</th>
                                <th class="order-date item-order-by" data-order-name='date'><i class="order fa " ></i> Date</th>
                                <th class="buyer-details item-order-by" data-order-name='buyer-details'><i class="order fa " ></i> Buyer Details</th>
                                <th class="item-count item-order-by" data-order-name='item-count'><i class="order fa " ></i> Items Ordered</th>
                                <th class="total-price item-order-by" data-order-name='total-price'><i class="order fa " ></i> Total Price</th>
                                <th class="payment-status item-order-by" data-order-name='payment-status'><i class="order fa " ></i> Payment Status (method)</th>
                                <th class="delivery-status item-order-by" data-order-name='delivery-status'><i class="order fa " ></i> Delivery Status</th>
                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            @include('backoffice.orders.tables.orders-list')
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='row row-pagination'>

                    @include('backoffice.orders.tables.orders-list-pagination')

            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>     

@include('backoffice.orders.modal-export-csv')

@js('plugins/methys-javascript/methys.paginator.js')
@stop