<section class='header container'>
	<!-- desktop -->
	<div class='header-wrapper'>

		<div class='header-logo' onclick="location.href='https://www.ownai.co.zw' " style="cursor:pointer;"></div>
		<!-- <div class='header-sitename color-orange'>Storefronts</div> -->
		<div class='header-desktop-search hidden-xs'>
			@include('frontend.layout.header-search')
		</div>
		<div class='header-cart-wrapper'>
			@if(!empty($store))
			<div>
				@if (!empty($appearance))
					<div class='header-cart-number' style='background-color: {{ $appearance->secondary_colour  }}; '>{!! LookupHelper::getproductsCarttotal($store->slug) !!}</div>
				@else
					<div class='header-cart-number'>{!! LookupHelper::getproductsCarttotal($store->slug) !!}</div>
				@endif
				
			</div>
			
			<div class='header-cart-text hidden-xs'>Items in cart</div>
			<div class='header-cart-icon'>
				<a @if(!LookupHelper::getproductsCarttotal($store->slug)) class="empty-cart" @endif href="{{URL::route('storecart', ['slug' => $store->slug])}}">
				<img src='{{ asset('images/icons/icon_cart.png') }}' width='28' height='28'/>
				</a>
			</div>
			@endif
		</div>
	</div>
	<div class='header-mobile-search visible-xs'>
		@include('frontend.layout.header-search')
	</div>
	<!-- end desktop -->
</section>
