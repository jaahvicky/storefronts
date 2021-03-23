@extends('frontend/layout/default')

@section('content')

{{--main header with search input--}}
@include('frontend.layout.details')
        <!-- breadcrumbs -->

        <!-- Main content -->
<section class="container product-container">
    <div class="row">
        <div class="col-md-8 ">
            <!-- <div class="panel panel-default"> -->
             <p class="text">The Store owner will contact you to arrange payment and collect or delivery of the items you ordered ... Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean euismod bibendum laoreet. Proin gravida dolor sit amet lacus accumsan et viverra justo commodo.</p>
 
            <p class="text">Proin sodales pulvinar tempor. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nam fermentum, nulla luctus pharetra vulputate, felis tellus mollis orci, sed rhoncus sapien nunc eget odio. 
            </p>
            
            <!-- </div> -->
        </div>
        <div class="col-md-4 ">
           <div class="panel panel-default">
                <div class="panel-body">
                    <h4 class="product-name text-center"><strong>Order Summary</strong></h4>
                    @php $total = 0; @endphp
                     @foreach (LookupHelper::getproductsCart($store->slug) as $products)
                                    @for($p = 0; $p < sizeOf($products); $p++)
                                        @php $product = LookupHelper::getproductDetails($products[$p]['product_id']); 
                                            $product->price = $product->price * (int)$products[$p]['quantity'];
                                            $total += $product->price;
                                          @endphp
                    <div class="row">
                        <div class="col-xs-9">
                            <h4 class="product-name">
                                <strong>x {{ $products[$p]['quantity'] }}</strong> {{ $product->title }}
                            </h4>
                        </div>
                        <div class="col-xs-3">
                            <h5>
                                <strong>${{ $product->price/100 }}</strong>
                            </h5>
                        </div>
                    </div>
                    <hr>
                        @endfor
                                    
                    @endforeach 
                     <div class="row">
                        <div class="col-xs-9">
                            <h5 class="product-name">
                                Delivery Cost
                            </h5>
                        </div>
                        <div class="col-xs-3">
                            <h5>
                                <strong>${{ $delivery_cost }}</strong>
                            </h5>
                        </div>
                    </div> 
                    <div class="row">
                        <div class="col-xs-9">
                            <h5 class="product-name">
                                item/s Total
                            </h5>
                        </div>
                        <div class="col-xs-3">
                            <h5>
                                <strong>Price</strong>
                            </h5>
                        </div>
                    </div>

                    <div class="row ">
                        <div class="col-xs-11 text-right">
                            <h5>
                                <strong>Total: ${{ ($total/100) + $delivery_cost }}</strong>
                            </h5>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-xs-12 text-right">
                       
                        @if($store->deliveryMethods->id == $store::ECONET_LOGISTICS)
                            <a class="btn btn-primary btn-block" href="{{ URL::route('shopping.details.modal', ['slug' => $store->slug]) }}" data-modal='true'>PLACE ORDER AND PAY WITH ECOCASH</a>
                        @else 
                             <a class="btn btn-primary btn-block" href="{{ URL::route('shopping.details.storeOrder', ['slug' => $store->slug]) }}">PLACE ORDER</a>
                        @endif
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
   
</section>

<!-- /.content -->
{{--store footer--}}
@include('frontend.layout.store-footer')

{{--website footer--}}
@include('frontend.layout.footer')

@stop
