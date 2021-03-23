<section class='store-footer'>
@if(!empty($store))
	<div class='container'>
		<ul class='store-footer-nav'>
			<li>
				<a title="About" href='{{URL::route('store-about', ['slug' => $store->slug])}}'>About</a>
			</li>
			<li>
				<a title="Warranty" href='{{URL::route('store-warranty', ['slug' => $store->slug])}}'>Warranty</a>
			</li>
			<li>
				<a title="Contact Details" href='{{URL::route('store-contact', ['slug' => $store->slug])}}'>Contact Details</a>
			</li>
		</ul>
	</div>
@endif
</section>