@extends('backoffice/layout/default')

@section('content')

<div class='box box-primary'>
    <div class="box-header">
        <h3 class="box-title">Orders List</h3>
        <div>
            @include('backoffice.admin.orders.filters')
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="dataTables_wrapper form-inline dt-bootstrap" id="example2_wrapper">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>  
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <table role="grid" id="example2" class="table table-bordered table-hover dataTable">
                        <thead>
                            <tr role="row">
                                <th>Order Number</th>
                                <th>Store Name</th>
                                <th>Products</th>
                                <th>Products total</th>
                                <th>Buyer Details</th>
                                <th>Delivery Status</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders As $order)
                               
                                <tr role="row">
                                <td>{{ $order->invoice_number}}</td>
                                <td>{{ $order->store->name}}</td>
                                <td>
                                    @foreach($order->OrderItems as $items)
                                        <div class="row">
                                            <div class='col-md-6 text-bold'>
                                                Product Name:
                                            </div>
                                            <div class='col-md-6 word-wrap'>
                                                 {{$items->product->title}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class='col-md-6 text-bold'>
                                                Price:
                                            </div>
                                            <div class='col-md-6 word-wrap'>
                                                 
                                                 {!! "$ ".money_format('%i',$items->product->price/100) . "\n"; !!}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class='col-md-6 text-bold'>
                                                Quantity:
                                            </div>
                                            <div class='col-md-6 word-wrap'>
                                                 {{$items->qty}}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class='col-md-6 text-bold'>
                                                Total:
                                            </div>
                                            <div class='col-md-6 word-wrap'>
                                                
                                                 {!! "$ ".money_format('%i',($items->product->price/100) *$items->qty) . "\n"; !!}
                                            </div>
                                        </div>
                                            <hr/>
                                     
                                    @endforeach
                                </td>
                                <td>
                                    {{sizeOf($order->OrderItems)}} 
                                </td>
                                <td>
                                    <div class="row">
                                        <div class='col-md-5 text-bold'>
                                            Firstname:
                                        </div>
                                        <div class='col-md-6 word-wrap'>
                                            {{ $order->buyer_firstname}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class='col-md-5 text-bold '>
                                            Lastname:
                                        </div>
                                        <div class='col-md-6 word-wrap'>
                                            {{ $order->buyer_lastname}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class='col-md-5 text-bold'>
                                            Address:
                                        </div>
                                        <div class='col-md-6 word-wrap'>
                                            {{ $order->buyer_address}}
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class='col-md-5 text-bold'>
                                            Email Address:
                                        </div>
                                        <div class='col-md-6 word-wrap'>
                                            {{ $order->buyer_email}}
                                        </div>
                                    </div>
                                     <div class="row">
                                        <div class='col-md-5 text-bold'>
                                            Phone number:
                                        </div>
                                        <div class='col-md-6 word-wrap'>
                                            +263{{ $order->buyer_phone}}
                                        </div>
                                    </div>


                                </td>
                                <td>{{ $order->DeliveryStatus->status}}</td>
                                <td>{{ $order->order_notes }}</td>
                                <td>{!! date("d M Y", strtotime($order->created_at)) !!}</td>
                                <td class='table-actions'>
                                             <a class="btn btn-sm btn-primary" href="{{ URL::route('admin.manage.order.modal-add-note', ['id' => $order->id]) }}" data-modal='true'><span class="glyphicon glyphicon-pencil"></span> 
                                              Add Note </a>  
                                              @if(!empty(json_decode($order->response_data)))
                                                    <a class="btn btn-sm btn-primary" href="#" data-modal='true'>Make Payment </a>  
                                              @endif
                                            <a class="btn btn-sm btn-primary " href="{{ URL::route('admin.manage.order.modal-change-status', ['id' => $order->id]) }}" data-modal='true'> Change Status </a> 

                                    </td>
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class='row'>
                    <div class='col-sm-4'>
                            @include('helpers.paginator-recordsperpage')
                    </div>
                    <div class="col-sm-4">
                            <div class="text-center">
                                    Showing {{ $orders->firstItem() }} to {{ $orders->lastItem() }} of {{ $orders->total() }} orders
                            </div>
                    </div>
                    <div class="col-sm-4">
                            <div class='pull-right'>
                                    {!! $orders->appends(Input::except('page', '_token'))->render() !!}
                            </div>
                    </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
</div>     
<style type="text/css">
    .word-wrap{
        word-wrap: break-word;
    }
</style>
@js('plugins/methys-javascript/methys.paginator.js')
@stop

