@extends('frontend/layout/default')

@section('content')


@include('frontend.layout.header')

<!-- breadcrumbs -->
@include('frontend.page.page-crumbs')
@include('frontend.layout.store-header')
<!-- Main content -->

<section class="container">

	<div class='page-content-wrapper'>

		<div class="store-description-wrapper">
			
			@if (isset($appearance) && $appearance->logo_image)
		
			<div class='store-description-logo-wrapper'>
				<div class='store-logo' style='background-image: url("{{asset($appearance->logo_image)}}")'></div>
				{{-- <div class='store-logo' style='background-image: url("{{asset("/storage/Ownai_logo.png")}}")'></div> --}}
			</div>

			@else

			<div class='store-description-logo-wrapper'>
				<div class='store-logo' style='background-image: url("{{asset("images/store/store.png")}}")'></div>
			</div>

			@endif

			<div class='store-description-text-wrapper'>
				<div class='store-description-title'>About - {{ $store->name }}</div>
				<div class='store-description-description'>

				@if(isset($about->exerpt))
				
					{!! $about->exerpt !!}

				@else
					Excerpt Line not set.
				@endif

				</div>
			</div>
		</div>
		
		{{-- <div class='page-title'>{{ $pageTitle }}</div> --}}
		<div class='page-content-text-wrapper'>

			@if(isset($about->description))
				{!! $about->description !!}
			@else
				Description not set.
			@endif

		</div>

	</div>
	
	<hr>

</section>
<!-- /.content -->


@include('frontend.layout.store-footer')
@include('frontend.layout.footer')

@stop
