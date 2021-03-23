@extends('frontend/layout/default')

@section('content')

{{--main header with search input--}}
@include('frontend.layout.header')
<!--@js('/js/backoffice/product/angular.min.js')-->
 <!-- @js('/js/frontoffice/variant_front.js')  -->
<!-- breadcrumbs -->
@include('frontend.product.product-header-crumbs') 
@include('frontend.layout.store-header')


<script type="text/javascript">
        var variantvalues = <?php echo (!empty($product->variantAttributesValue->data)) ? $product->variantAttributesValue->data : json_encode([]) ?>;
 </script>
<!-- Main content -->
<section class="container product-container">

	<!-- desktop product header -->
	<div class='row clearfix product-header hidden-xs'>
		<div class='col-xs-12 clearfix'>
			@if (isset($appearance) && $appearance->logo_image)
			<div class='store-logo-wrapper pull-left'>
				<div class='store-logo' style='background-image: url("{{asset($appearance->logo_image)}}")'></div>
			</div>
			@else
			<div class='store-logo-wrapper pull-left'>
				<div class='store-logo' style='background-image: url("{{asset("images/store/store.png")}}")'></div>
			</div>
			@endif
			<div class='product-name pull-left'>
				<h1>{{ $product->title }}</h1>
				@include('frontend.product.category-crumbs')
				<div class='product-store'>
					Sold by <a href='{{URL::route('store', ['slug' => $store->slug])}}'>{{ $store->name }}</a>
				</div>
			</div>
		</div>
	</div>
	<!-- end desktop product header -->

	<div class='row'> 
		<!-- image gallery -->
		<div class='col-xs-12 col-md-6 col-lg-8'>
			<div id='gallery' class='product-gallery clearfix'>
				<ul class='bxslider'>

					@if(count($product->images) <= 0)
						<li><img src='{{ asset('images/samples/no-photo-available.png') }}'/></li>
					@endif

					@foreach($product->images as $image)
						
						<?php 
						

						$url = \ImageHelper::resizeImage(\Storage::url($image->filename), 740, 555); 
					
						
						?>

						@if($image->filename)
							@php $pic = "storage/".$image->filename; @endphp
							
							 
                             <li> <img src='{!! LookupHelper::getImage($image->filename) !!}' width="740" height="555"/> </li>
                           
                               
						@else
							<li><img src='{{ asset('images/samples/no-photo-available.png') }}'/></li>
						@endif
					@endforeach
				</ul>

				<div id="bx-pager" class='bx-pager'>

					<?php $thumbIndex = 0; ?>
					@foreach($product->images as $image)

						<?php $url =\ImageHelper::resizeImage(\Storage::url($image->filename), 60, 60); ?>

						@if($image->filename)
							@php $pic = "storage/".$image->filename; @endphp
							
							
                             <a data-slide-index="{{$thumbIndex}}" href=""> <img src='{!! LookupHelper::getImage($image->filename) !!}' width="60" height="60"/> </a>
                            
                              
						@else
							<a data-slide-index="{{$thumbIndex}}" href=""><img src="{{ asset('images/samples/image-holder-thumb.jpg') }}" /></a>
						@endif

						<?php $thumbIndex++; ?>
					@endforeach
				</div>
			</div>
		</div>
		
		<!-- mobile product header -->
		<div class='product-header-mobile visible-xs clearfix'>
			<div class='store-name'>
				<h1>{{ $product->title }}</h1>
				@include('frontend.product.category-crumbs')
			</div>
			
			<div class='product-options-price-wrapper clearfix'>
				<div class='price-amount'>${{ $product->price/100 }}</div>
			</div>
		</div>

		<!-- product details -->
		<div class='product-details-wrapper col-xs-12 col-md-6 col-lg-4'>
		<input type="hidden" name="variantvalues" id="variantvalues" value='<?php echo (!empty($product->variantAttributesValue->data)) ? $product->variantAttributesValue->data : json_encode([]) ?>'/> 
		
		{!! Form::open(['route' => 'check-out']) !!}
        {!! Form::hidden('id', $product->id) !!}
			<h3>{{ $display_settings['product_information_title'] }}</h3>
			<hr>
			<div class="alert alert-danger variant_error" style="display: none"></div>
			<!--  Attributes to come later-->
			@if( isset($product->variantAttributesValue) && !empty(json_decode($product->variantAttributesValue->data)) )
				<?php $data = json_decode($product->variantAttributesValue->data);
				$elements = $data->elements;
				$i = 0; ?>
				@foreach($elements as $element)
					<?php  $values = explode(',', $element->values); ?>
					<!-- <div class='row form-group'> -->
						<!-- <div class='col-xs-4 col-lg-4'> -->
							<!-- <label for='' class='form-control-label'>{{ LookupHelper::getVariant($element->id) }}</label> -->
						<!-- </div>  -->
						<!-- <div class='col-xs-8 col-lg-8'> -->
							<!-- <select id='{{$element->id}}' name='variant_{{$element->id}}' class='form-control variant_select_{{$i}}'> -->
								<!-- <option value=''>Select option</option> -->
								@foreach($values as $value)
								 <!-- <option value='{{$value}}'>{{$value}}</option> -->
								 
								@endforeach
							<!-- </select> -->
						<!-- </div> -->
					<!-- </div> -->
					<?php $i++; ?>
				@endforeach
			
			@endif

			@if($display_settings['show_qty'])

			<div class='row form-group product-qty'>

				<!-- Hide if product is out of stock -->
				<label for='quantity' class='form-control-label col-xs-12 col-sm-4 col-lg-4'>Quantity</label>

				<div class='col-xs-12 col-sm-8 col-lg-8'>
					<input type="number" min="1" max="999" id='quantity' value="1" name='quantity' class='form-control'
						>
				</div>

			</div>

			@else

			<input type="hidden" name="quantity" value="1" />

			@endif

			@if($display_settings['show_price'])

				<div class='product-options-price-wrapper clearfix hidden-xs'>
					<div class='pull-left price-label'>Price</div>
					<div class='pull-right price-amount'>${{ $product->price/100 }}</div>
				</div>

			@endif

			<?php
				$variant   = $product->attributeVariantValue;
				$out_stock = 0; 
			?>
            @if(count($variant))

                <?php $variant_data = json_decode($variant->data); ?>

                @if(array_key_exists('data_values', $variant_data))

                    <?php 
                        // if data_values exist, set out stock to 1 unless an available option is found
                    	$out_stock = 1;
                    ?>
                    @foreach ($variant_data->data_values as $value)
                        @if($value->options[0]->options->available == 1)
                            <?php $out_stock = 0; break; ?>
                        @endif
                    @endforeach

                @endif

            @endif

			<!-- Hide add to cart if product out of stock -->
			@if($display_settings['show_add_to_cart'])

	            @if($out_stock)
					<span class="product-out-of-stock text-danger">Out Of Stock</span>
	            @else
					<button type="submit" class="btn btn-block btn-primary">Add to Cart</button>
	            @endif

	        @endif

			<?php $delivery_m = (isset($store->delivery_method)) ? $store->delivery_method->delivery_method : ''; ?>
            @if( $delivery_m === 'Use Econet Logistics')
				<p class="note text-danger">No delivery outside of Harare</p>
			@endif

			@if($display_settings['show_qty'] || $display_settings['show_price'] || $display_settings['show_add_to_cart'])

			<hr>

			@endif

			<!-- Seller Information -->

			<div class="product-seller-info">

				<h4>Contact Information</h4>

				@if($store->contactDetails)

				<p>Contact Name: {{ $seller_details['name'] }}</p>
				<p><i class="fa fa-phone"></i>Phone: {!! ($seller_details['phone']) ? '+263<span class="number-toggle-dest">***</span>[<a href="#" class="number-toggle">Show Full Number</a>]' : 'n/a' !!}<span class="hidden seller-phone-no">{{ $seller_details['phone'] }}</span></p>
				<p><i class="fa fa-map-marker"></i>Location: {{ $seller_details['location'] }}</p>

				@else

				<p>No Seller information found</p>

				@endif

			</div>

			<!-- End seller information -->

			<hr>

			<div class='product-description'>
				<!-- 
				<ul class='nav nav-tabs' id='itemTabs'>
					<li role='presentation' class='active'><a href='#' data-target='#itemDetails' data-toggle='tab'>Details</a></li>
					<li role='presentation' class=''><a href='#' data-target='#itemDelivery' data-toggle='tab'>Delivery</a></li>
				</ul>
				-->
				
				<div class='tab-content'>
					<div role='tabpanel' class='tab-pane active' id='itemDetails'>
						<h4>Description</h4>
						<p>{{ $product->description }}</p>

						<!-- product attribute values -->

						<?php $attr_value_product = (isset($product->AttributeValueProduct)) ? $product->AttributeValueProduct : []; ?>

						@foreach($attr_value_product as $attr_value_p)

						@php
							$attribute_name = $attr_value_p->attributedetails->name;
						@endphp

							@if($attribute_name !== 'Price Type' && $attribute_name !== 'I am (Agency/Owner)')

								<p>{{ $attribute_name . ' : ' }}
								{{ ($attr_value_p->value) ? $attr_value_p->value : 'n/a' }}</p>

							@endif

						@endforeach

					</div>
					<!-- <div role='tabpanel' class='tab-pane' id='itemDelivery'>[delivery details]</div> -->
				</div>
				
			</div>
		</div>
	</div>

	@include('frontend.product.widgets.other-products')

	@include('frontend.product.modal-product-images')

</section>
<!-- /.content -->
{{--store footer--}}
@include('frontend.layout.store-footer')

{{--website footer--}}
@include('frontend.layout.footer')

<script type='text/javascript'>
	$(document).ready(function () {
		$('.bxslider').bxSlider({
			pagerCustom: '#bx-pager',
			responsive: true,
		});
		
		$('#itemTabs a').on('click', function() {
			e.preventDefault();
			$(this).tab('show');
		});
		var onhold =1;
		$('#quantity').keyup(function(e){

			  if (/^[0-9]+$/.test(this.value) && (this.value < 1000))
			  {
			    this.value = this.value;
			    onhold = this.value
			  }else{
			  	this.value=onhold;
			  }
		});
	});

</script>
<style>
</style>

@stop

@js('plugins/bxslider/jquery.bxslider.min.js')
@css('plugins/bxslider/jquery.bxslider.css')