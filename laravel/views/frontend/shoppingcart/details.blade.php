@extends('frontend/layout/default')

@section('content')

{{--main header with search input--}}
@include('frontend.layout.details')

        <!-- breadcrumbs -->

        <!-- Main content -->
<section class="container product-container">
        @include('frontend.layout.flash-header')
    <div class="row">
        <div class="col-md-8 ">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="lead">Billing Information</p>
                    <p>Fill in your details in the fields below.  * Mandatory fields</p>
                    <hr>
                     {!! Form::open(['route' => 'shopping.details.post', 'id'=>'contactdata']) !!}
                      {!! Form::hidden('store_id', $store->id) !!}
                    <div class="form-group  @hasError('firstname')">
                        {!! Form::label('firstname', 'Name*', ['class' => 'control-label']) !!}
                        {!! Form::text('firstname', null, ['class' => 'form-control', 'placeholder'=>'First Name']) !!}
                         @showErrors('firstname')
                    </div>



                    <div class="form-group @hasError('firstname')">
                        {!! Form::label('lastname', 'Surname*', ['class' => 'control-label']) !!}
                        {!! Form::text('lastname', null, ['class' => 'form-control', 'placeholder'=>'Surname']) !!}
                        @showErrors('lastname')
                    </div>

                    <div class="form-group @hasError('contact_number')">
                        {!! Form::label('contact_number', 'Contact Number *', ['class' => 'control-label']) !!}
                        <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">+263</span>
                        {!! Form::text('contact_number', null, ['class' => 'form-control', 'placeholder'=>'777654321', 'data-methys-valid'=>'phone-zim', 'aria-describedby'=>'basic-addon3']) !!}
                        </div>
                        @showErrors('contact_number')
                    </div>

                    <div class="form-group @hasError('email')">
                        {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder'=>'address@domain.com']) !!}
                        @showErrors('email')
                    </div>

                    <div class="form-group @hasError('home_address')">
                  
                        {!! Form::label('home_address', 'Your Address:', ['class' => 'control-label']) !!}

                        {!! Form::text('home_address', null, ['class' => 'form-control', 'placeholder'=>'Street, Suburb, City', 'id'=>'auto', 'onFocus'=>"geolocate()" , 'data-logistics'=> URL::route('api.logistics.getQuote'), 'data-store-address'=>$store->details->street_address_1, 'data-logist'=>"$logistics" ])  !!}
                        @showErrors('home_address')
                        <input type="hidden" name="delivery_cost" id="delivery_cost" value="0">
                    </div>
                     <!-- <div class="form-group">
                        {!! Form::label('location_address', 'Precise Location:', ['class' => 'control-label']) !!}
                       <p>Drag the map marker to set an exact location</p>
                    </div> -->

                    <div id="map">
                        
                    </div>
                    <div class="row ">
                        <div class="col-xs-12 text-right">
                            {!! Form::submit('Continue', ['class' => 'btn btn-primary btn-checkout']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
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
                    @if($logistics)
                    <div class="row">
                        <div class="col-xs-9">
                            <h5 class="product-name">
                                Delivery Cost
                            </h5>
                        </div>
                        <div class="col-xs-3">
                            <h5>
                                <strong class="d_cost"><i class='fa fa-spinner fa-spin'></i></strong>
                            </h5>
                        </div>
                    </div>
                    @endif
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
                                <strong>Total: $<span class="total">{{ $total/100 }}</span></strong>
                            </h5>
                        </div>
                    </div>
                    <div class="row ">
                        <div class="col-xs-12 text-right">
                        <button class="btn btn-primary btn-block btn-checkout" id="submit_contact">Continue</button>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="load-modal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"></button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        
          <div class="error_model"></div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> Close</button>
      </div>
    </div>
    
  </div>
</div>
<div class="modal fade" id="loading-modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" >
     <div class="text-center" style="padding: 20px 0;">
        <i class='fa fa-circle-o-notch fa-spin'></i> Please wait..
    </div>
    </div>
    
  </div>
</div>
<script type="text/javascript">
    (function(){
        
        $('#load-modal').modal('hide');
        $('#loading-modal').modal('hide');
        jQuery.fn.extend({
            disable: function(state) {
                return this.each(function() {
                    this.disabled = state;
                });
            }
        });
        $('.btn-checkout').disable(true);
        
        $( "#submit_contact" ).click(function() {
                $( "#contactdata" ).submit();
        });

        $('#auto').on('paste', function(e){
            e.preventDefault();
        });
   
    })();
    var placeSearch, autocomplete;
    var original_cost = parseInt($('.total').html());
    function initAutocomplete() {
        var input = document.getElementById('auto');
        autocomplete = new google.maps.places.Autocomplete(input,{
            types: ['geocode']
        });
        autocomplete.setComponentRestrictions({ country: ['zw'] });
        autocomplete.addListener('place_changed', function () {
            var place = autocomplete.getPlace();
           
           
            $('#loading-modal').modal('show');
                console.log(place.formatted_address);
            if($('#auto').attr('data-logist') == "1"){
                    
                checkdelivery(place.formatted_address);
            }else{
              $('.btn-checkout').disable(false);
              $('#loading-modal').modal('hide');
            }
            
        });
    }

    function checkdelivery(place){
       var formData = {
            _token: $("input[name*='_token']").val(),
            pAddr:$('#auto').attr('data-store-address'),
            dAddr:place,
            vehicle:'car',
            multidrop:0,

       };

        $.ajax({
              url: $('#auto').attr('data-logistics'),
              data: formData,
              method: "POST",
              
            }).done(function( data ) {
                console.log(data);
               if(data.success == false){
                    $('.error_model').html('Storefronts offers delivery quotes for distance that is 60km or less from pick-up location');
                   
                    $('#loading-modal').modal('hide');
                    $('#load-modal').modal('show');
                    $('.btn-checkout').disable(true);
               }else if(data.success == true){
                    $('.d_cost').html('$'+data.data.info.price)
                    $('#delivery_cost').val(parseInt(data.data.info.price));
                    var total = original_cost + parseInt(data.data.info.price)
                    $('.total').html(total)
                    $('.btn-checkout').disable(false);
                    $('#loading-modal').modal('hide');
               }
                
            });

    }
    
    function geolocate() {
      console.log('on focus', navigator.geolocation);
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
              center: geolocation,
              radius: position.coords.accuracy
            });
            autocomplete.setBounds(circle.getBounds());
          });
        }
    }
    
</script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCrblQnygKnezrZERg8Llc1QOi9QKAPA3s&libraries=places,geometry&callback=initAutocomplete"
        async defer></script>

{{--store footer--}}
@include('frontend.layout.store-footer')

{{--website footer--}}
@include('frontend.layout.footer')

@stop
