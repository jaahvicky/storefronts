<section class='footer'>
	<div class='container'>
		{{-- <div class='footer-row clearfix visible-xs'> --}}
			{{-- @include('frontend/layout/footer-affiliates') --}}
		{{-- </div> --}}
		
		{{-- <hr class='visible-xs'> --}}
		
		<div class='footer-row clearfix'> 

			@if(!empty($store))

			<ul class='footer-nav'>
				<li>
					<a title="Privacy" href='{{URL::route('content-page', ['storeslug' => $store->slug, 'pageslug' => 'privacy'])}}'>Privacy</a>
				</li>
				<li>
					<a title="Cookies" href='{{URL::route('content-page', ['storeslug' => $store->slug, 'pageslug' => 'cookies'])}}'>Cookies</a>
				</li>
				<li>
					<a title="Terms and Conditions" href='{{URL::route('content-page', ['storeslug' => $store->slug, 'pageslug' => 'terms-and-conditions'])}}'>Ownai Terms &amp; Conditions</a>
				</li>
				<li>
					<a title="FAQs" href='{{URL::route('content-page', ['storeslug' => $store->slug, 'pageslug' => 'faq'])}}'>FAQs</a>
				</li>
				<li>
					<a title="Want a Storefront?" href='{{URL::route( 'content-page', [ 'storeslug' => $store->slug, 'pageslug' => 'open-a-store' ])}}'>Want a Storefront?</a>
				</li>
			</ul>

			@endif
			
			{{-- <div class='footer-affiliates-wrapper hidden-xs'> --}}
				{{-- @include('frontend/layout/footer-affiliates') --}}
			{{-- </div> --}}
		</div>
		<div class='footer-row clearfix'>
			<div class='footer-copyright'>Copyright &copy; 2016 - {{ date('Y') }}. All Rights Reserved</div>
			{{-- <div class='footer-powered'>Powered by <a href='http://www.ownai.co.zw'>Ownai</a> --}}
		</div>
	</div>
</section>