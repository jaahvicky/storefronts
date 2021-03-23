<section class='store-header'>

	@if (isset($appearance) && !empty($appearance->banner_image))

	<div class='store-header-banner' style="background-image: url('{{asset($appearance->banner_image)}}')">

	</div>
	@else

	<div class='store-header-banner' style="background-image: url('{{asset('images/store/default_banner.png')}}')">

	@endif
</section>