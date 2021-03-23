@extends('backoffice/layout/default')

@section('content')
@php
    $back_notifications = NotificationHelper::userNotifications();
    $order_status = LookupHelper::getOrderDeliveryStatus();
@endphp
<div class="row">
        <div class="col-md-6">
          <div class="box box-widget">
            <div class="box-header">
              <h3>Orders &nbsp;<span class="badge bg-yellow order-number">{{ LookupHelper::getOrderTotal() }}</span></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-condensed">
                <tbody>
                <tr>
                  <td>Pending</td>
                  <td><span class="badge bg-light-blue pull-right">{{$order_status->pending }}</span></td>
                </tr>
                <tr>
                  <td>In progress</td>
                  <td><span class="badge bg-light-blue pull-right">{{ $order_status->inprogress }}</span></td>
                </tr>
                <tr>
                  <td>Cancelled</td>
                  <td><span class="badge bg-light-blue pull-right">{{ $order_status->cancel }}</span></td>
                </tr>
                <tr>
                  <td>Completed</td>
                  <td><span class="badge bg-light-blue pull-right">{{ $order_status->complete }}</span></td>
                </tr>
              </tbody></table>
            </div>
            <div class="box-footer">
              <a href="{!! URL::route('orders.index') !!}" class="btn btn-primary">Manage Orders</a>
            </div>
           
          </div>
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="box box-widget">
            <div class="box-header">
              <h3>Top categories (by online products)</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-condensed">
                <tbody><tr>
                  <th>Category</th>
                  <th>Online</th>
                  <th style="width: 40px">Offline</th>
                </tr>
                @if ($top_categories)
                @foreach ($top_categories as $category)
				    <tr>
	                  <td>{{ $category->parent_name }}&nbsp; 
	                   <span class="pull-right-container">
			              <i class="fa fa-angle-right"></i>
			           </span> &nbsp;{{ $category->name }}
			          </td>
	                  <td><span class="badge bg-light-blue">{{ $category->online }}</span></td>
	                  <td><span class="badge">{{ $category->offline }}</span></td>
	                </tr>
				@endforeach
				@else
				<div class="alert alert-info">
	               There is no product on your store yet
	            </div>
                @endif
                
              </tbody></table>
            </div>
           <!--  <div class="box-footer">
              <a href="#" class="btn btn-primary">Manage Categories</a>
            </div> -->
           
          </div>
        </div>
        <!-- /.col -->
      </div>

      


@stop