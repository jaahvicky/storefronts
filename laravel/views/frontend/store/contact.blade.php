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
				<div class='store-description-title'>Contact - {{ $store->name }}</div>
				<div class='store-description-description'>
					Business Hours: {{ (!empty($details->collection_hours)) ? $details->collection_hours : 'N/A' }}
				</div>
			</div>
		</div>
		
		{{-- <div class='page-title'>{{ $pageTitle }}</div> --}}
		<div class='page-content-text-wrapper store-contact-details'>

			<span class="details-label">Address :</span> {{ (!empty($address)) ? $address :                            'n/a' }}<br />
			<span class="details-label">Suburb :</span>  {{ (!empty($details->suburb)) ? $details->suburb->name :            'n/a' }}<br />
			<span class="details-label">City :</span>    {{ (!empty($details->city)) ? $details->city->name   :              'n/a' }}<br />
			<span class="details-label">Country :</span> {{ (!empty($details->country_id)) ? $details->country->name : 'n/a' }}<br />

			<br />
			<span class="details-label">Phone :</span>    {!! (!empty($details->phone)) ? '<a class="phone-nr" href="tel:' . $details->phone . '">' . $details->phone . '</a>'  :              'n/a' !!} <br />

			<span class="details-label">Email :</span>    {!! (!empty($details->email)) ? '<a href="mailto:' . $details->email . '">' . $details->email . '</a>'   :  'n/a' !!}

		</div>

	</div>
	
	<hr>

</section>
<!-- /.content -->


@include('frontend.layout.store-footer')
@include('frontend.layout.footer')

@stop
