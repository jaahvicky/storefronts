@extends('frontend/layout/default')

@section('content')

{{--main header with search input--}}
@include('frontend.layout.details')

        <!-- breadcrumbs -->

        <!-- Main content -->
<section class="container product-container"> 
    <div class="row">
        <div class="col-md-12 ">
            <!-- <div class="panel panel-default"> -->
            <h1>Thank you for your order</h1>
            <h6 class="ref">ORDER REF:{{$order->invoice_number}}</h6>
            <p>You have successfully placed an order for the items below.</p>
        </div>
    </div>
    <div  class="row">
        <div class="col-md-12 ">
            <h4 class="order_details">Your Details</h4>
            <div  class="row">
                <div class="col-md-2 ">
                   <label class="control-label">Name:</label>
                </div>
                <div class="col-md-8">
                    <span class="pull-left">{{$order->buyer_firstname .' '.$order->buyer_lastname}}</span>
                </div>
            </div>
            <div  class="row">
                <div class="col-md-2 ">
                   <label class="control-label">Phone number:</label>
                </div>
                <div class="col-md-8">
                    <span class="pull-left">+263{{$order->buyer_phone}}</span>
                </div>
            </div>
            <div  class="row">
                <div class="col-md-2 ">
                   <label class="control-label">Email Address:</label>
                </div>
                <div class="col-md-8">
                    <span class="pull-left">{{$order->buyer_email}}</span>
                </div>
            </div>
            <div  class="row">
                <div class="col-md-2 ">
                   <label class="control-label">Address:</label>
                </div>
                <div class="col-md-8">
                    <span class="pull-left"> {{$order->buyer_address}}</span>
                </div>
            </div>
        </div>
    </div>
    <div  class="row margin_spc">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row ">
                        <div class="col-xs-10">
                             <span>Kindly contact <b> {{$store->name}}</b>, regarding all queries.</span>
                        </div>
                        <div class="col-xs-2 text-right">
                            <a type="button" class="btn btn-default btn-block" href='{{URL::route('store-contact', ['storeslug' => $store->slug])}}'>Store Contact</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        </div>
    </div>
    <div  class="row">
        <div class="col-md-9 ">
            <h2>Last Purchase </h2>
            <div class="col-xs-12" style="height:50px;"></div>

            <div class="row">
                @foreach ($order->OrderItems as $order_item)
                   
                        @php $order_item->product;
                        @endphp
                        <div class="col-md-6">
                            <div  class="row dsk_view">
                                <div class="col-xs-2">
                                    @if($order_item->product->platform == 'Ownai')
                                        <img src='{!! LookupHelper::getImage($order_item->product->slug) !!}' class="img-responsive" /> 
                                    @else
                                        <img class="img-responsive" src="{!!$order_item->product->getCoverImageUrl() !!}">
                                    @endif
                                    
                                </div>
                                <div class="col-xs-10">
                                    <h4 class="product-name"><strong>{{ $order_item->product->title }}</strong></h4>
                                    <h4>
                                        <small>
                                            Qty {{$order_item->qty}}
                                        </small>
                                    </h4>
                                     <h4>${{ $order_item->product->price/100 }}</h4>
                                </div>
                                
                                </div>
                                <div class="row mob_view">
                                    <div class="col-xs-5">
                                        <img class="img-responsive" src="{!!$order_item->product->getCoverImageUrl() !!}" width='100' height='70'>
                                    </div>
                                    <div class="col-xs-7">
                                        <h5 class="product-name"><strong>{{ $order_item->product->title }}</strong></h5>
                                        
                                        <h6>
                                            <small>
                                                Qty {{$order_item->qty}}
                                            </small>
                                        </h6>
                                        <h6>${{ $order_item->product->price/100 }}</h6>
                                    </div>                     
                                </div>
                         </div>
                            
                    @endforeach 
            </div>
                
            </div>
        </div>
        
    </div>
    <div  class="row">
        <div class="col-md-9">
        <div class="panel-footer">
            <div class="row ">
                <div class="col-xs-12 text-right">
                    {!! Form::open(['route' => 'check-continue']) !!}
                    {!! Form::hidden('store_id', $store->id) !!}
                    <button type="submit" class="btn btn-primary">Continue Shopping</button>
                </div>
            </div>
        </div>
    </div>
   
</section>
<div class="row">
    <div class="col-xs-12" style="height:50px;"></div>
</div>

<style type="text/css">
    .ref{padding-top:10px;font-weight: 600;}
    .order_details{
        font-weight: 600;
    }
    .margin_spc{
        margin-top:20px;
    }
    ul {
    /*list-style: none;*/
    }
</style>

{{--website footer--}}
@include('frontend.layout.footer')

@stop
