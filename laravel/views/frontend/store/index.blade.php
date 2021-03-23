@extends('frontend/layout/default')

@section('content')


@include('frontend.layout.header')
@include('frontend.layout.store-header')

<!-- Main content -->

<section class="container">

	<div class='store-description-wrapper'>
		
		<div class='store-description-logo-wrapper'>

			@if (isset($appearance) && $appearance->logo_image)
			<div class='store-logo' style='background-image: url("{{asset($appearance->logo_image)}}")'></div>
			@else
			<div class='store-logo' style='background-image: url("{{asset("images/store/store.png")}}")'></div>
			@endif
		</div>
		

		
		<div class='store-description-text-wrapper'>
			<div class='store-description-title'>{{ $store->name }}</div>
			<div class='store-description-description'>
			
			@if(isset($about->exerpt))
				{{ $about->exerpt }}
			@endif
			</div>
			<div class='store-description-contact'>
				@if ($appearance)
				<a href="{{URL::route('store-contact', ['slug' => $store->slug])}}" class='btn btn-primary' style="background-color: {{ $appearance->primary_colour  }} ">Contact Details</a>
				@else
				<a href="{{URL::route('store-contact', ['slug' => $store->slug])}}" class='btn btn-primary' >Contact Details</a>
				@endif
			</div>
		</div>
		<div class='store-description-actions'>
			
		</div>
	</div>
	
	<hr>

</section>
<!-- /.content -->

<section class='container home-categories'>

	<!-- filters/sort -->
	@include('frontend.store.filters')

    <div class="row">
	<div class='store-categories col-lg-3'>
		@include('frontend.categories.sidebar')
	</div>
	<div class='store-search-results col-lg-9'>
		@include('frontend.search.results')
	</div>
    </div>    
</section>

@include('frontend.layout.store-footer')
@include('frontend.layout.footer')

@stop
