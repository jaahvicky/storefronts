@extends('frontend/layout/default')

@section('content')

@include('frontend.layout.header')
@include('frontend.layout.store-header')
<br>
 <script type="text/javascript" src="{{ asset('plugins/methys-javascript/methys.logger.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/methys-javascript/methys.modals.js') }}"></script>

        <!-- breadcrumbs -->
@include('frontend.shoppingcart.shopping-cart-crump')

@php
    $products_cart_total = LookupHelper::getproductsCarttotal($store->slug);
@endphp
        <!-- Main content -->
<section class="container product-container shopping-cart">
    <div class="row">
        <div class="col-md-8">
            <table  width="100%"><tr><td>
            <div class="panel panel-info">
                            <div class="panel-body" >
                                <div class="row dsk_view">
                                    <div class="col-xs-2">
                                       
                                    <i class="fa fa-shopping-cart fa-5x" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-xs-8">
                                        <h4 class="product-name"><strong>Your Shopping Cart</strong></h4>
                                    </div>
                                </div>
                                <div class="row mob_view">
                                    <div class="col-xs-5">
                                       <i class="fa fa-shopping-cart fa-5x" aria-hidden="true"></i> 
                                    </div>
                                    <div class="col-xs-7">
                                        <h4 class="product-name"><strong>Your Shopping Cart</strong></h4>
                                    </div>
                                </div>
                                <div class="col-xs-12" style="height:50px;"></div>

                                <div class="cart-products-wrapper @if(!$products_cart_total)empty-cart @endif">

                                  @php $total = 0; @endphp
                                     
                                 @foreach (LookupHelper::getproductsCart($store->slug) as $products)
                                    @for($p = 0; $p < sizeOf($products); $p++)
                                        @php $product = LookupHelper::getproductDetails($products[$p]['product_id']); 
                                            $product->price = $product->price * (int)$products[$p]['quantity'];
                                            $total += $product->price;
                                          @endphp
                                        
                                        <div  class="row cart_product dsk_view" >
                                            <div class="col-xs-2">
                                               
                                                   <img src='{!! LookupHelper::Imagecover($product->getCoverImageUrl()) !!}' class="img-responsive" /> 
                                               
                                                
                                            </div>
                                            <div class="col-xs-4">
                                                <h4 class="product-name"><strong>{{ $product->title }}</strong></h4>
                                                
                                                <div class="row form-group">
                                                        <div class="col-md-6">
                                                            <h4>
                                                                <small>
                                                                    <a class="" data-modal="true" href="{!! URL::route('shopping.modal.remove', ['id' => $product->id]) !!}"> Remove </a> | Qty 
                                                                    </small>
                                                            </h4>
                                                        </div>
                                                        <div class="col-md-6 mix-match">
                                                            <input name='quantity' class="quantity form-control" data-url="{!! URL::route('shopping.quantity.update', ['id' => $product->id]) !!}" type="number" value="{{ $products[$p]['quantity'] }}" min="1" max="999" readonly="true">
                                                           
                                                        </div>
                                                        
                                                </div>
                                                
                                            </div>
                                                <div class="col-md-6 text-right"><h3>${{ $product->price/100 }}</h3></div>
                                            </div>
                                        <div class="row cart_product mob_view">
                                            <div class="col-xs-5">
                                                <img class="img-responsive" src="{!!$product->getCoverImageUrl() !!}" width='100' height='70'>
                                            </div>
                                            <div class="col-xs-7">
                                                <h5 class="product-name"><strong>{{ $product->title }}</strong></h5>
                                                <h6>${{ $product->price/100 }}</h6>
                                                <div class="form-inline">
                                                        <div class="form-group">
                                                            <label>
                                                                <small>
                                                                    <a class="" data-modal="true" href="{!! URL::route('shopping.modal.remove', ['id' => $product->id]) !!}"> Remove </a> | Qty 
                                                    
                                                                </small>
                                                            </label>
                                                            <input name='quantity' class="quantity form-control" data-url="{!! URL::route('shopping.quantity.update', ['id' => $product->id]) !!}" type="number" value="{{ $products[$p]['quantity'] }}" min="1" max="999" readonly="true">
                                                        </div>
                                                        
                                                        
                                                    </div>
                                            </div>
                                                    
                                        </div>
                                        
                                        <hr>
                                    @endfor
                                    
                                 @endforeach
                                 </div>

                                <div class="row">
                                    <div class="text-center">
                                        <div class="col-xs-12">
                                            <h4 class="text-right">Total <strong>${{ $total/100}}</strong></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="row ">
                                    <div class="col-xs-12 text-right">
                                    {!! Form::open(['route' => 'check-continue']) !!}
                                    {!! Form::hidden('store_id', $store->id) !!}
                                    <button type="submit" class="btn btn-default">Continue Shopping</button>
                                    <a type="button" class="btn btn-primary"  @if(!$products_cart_total) disabled="disabled" @endif href="{!! URL::route('shopping.details', ['id' => $store->slug]) !!}">Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div></td></tr></table>
        </div>
        <div class="col-md-4">
            <table width="100%"><tr><td><div class="panel panel-info">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <h4 class="product-name"><strong>Cart Summary</strong></h4>
                                    </div>
                                </div>
                                <div class="col-xs-12" style="height:50px;"></div>
                                <div class="row">
                                    <div class="col-md-6"><h4>Total cost</h4></div>
                                    <div class="col-md-6 text-right"><h3>${{ $total/100}}</h3></div>
                                </div>
                                <div class="row ">
                                    <div class="col-xs-12 text-right">
                                        <a type="button" class="btn btn-primary btn-block" @if(!$products_cart_total) disabled="disabled" @endif href="{!! URL::route('shopping.details', ['id' => $store->slug]) !!}">
                                            Checkout
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</section>
<style type="text/css">
    .mix-match{
        position: relative;
        top:-4px;
       right:40px;
    }
   
</style>
<script type="text/javascript">
    (function(){
         var onhold =1;
         $('.quantity').hover(function(e){
               if($(this).prop('readonly') == true){
                   $( this ).attr('title', "Click to enable edit" );
                   console.log('Click to edit');   
               }
         }).on('click',function(e){
            $( this ).attr('title', "" );
             $(this).attr('readonly', false);
         }).on('focus',function(e){
               
             onhold = this.value;
         }).keyup(function(e){

              if (/^[0-9]+$/.test(this.value) && (this.value < 1000) || (this.value == ''))
              {
                this.value = this.value;
                
              }else{
                this.value=onhold;
              }
            
        }).on('change', function(e){

            if (/^[0-9]+$/.test(this.value) && (this.value < 1000) )
            {
                var url =  $(this).attr('data-url')+'/'+$(this).val();
                window.location.href = url;
            }
            
        });

    })();
</script>
<!-- /.content -->
@css("plugins/")
@include('frontend.layout.store-footer')
@include('frontend.layout.footer')
@stop



