@extends('backoffice/layout/default')

@section('content')

	<div class='box box-primary' style="padding-left: 15px;">

		<h3 class="box-subtitle">Store Details</h3>

		<p>
			<strong class="title">Store Name</strong><br />
			{{ $data['name'] }}<br /><br />

			<strong class="title">Type</strong><br />
			{{ $data['type'] }}<br /><br />

			<strong class="title">Slug</strong><br />
			{{ $data['slug'] }}<br /><br />

			<strong class="title">Delivery Method</strong><br />
			{{ $data['delivery_method'] }}<br /><br />

			<strong class="title">Status</strong><br />
			{{ $data['status'] }}<br /><br />
		</p>

		<h3 class="box-subtitle">Store General Contact</h3>

		<p>
			<strong class="title">Street Address 1</strong><br />
			{{ $data['details']['street_address_1'] }}<br /><br />

			<strong class="title">Street Address 2</strong><br />
			{{ $data['details']['street_address_2'] }}<br /><br />

			<strong class="title">City</strong><br />
			{{ $data['details']['city'] }}<br /><br />

			<strong class="title">Suburb</strong><br />
			{{ $data['details']['suburb'] }}<br /><br />

			<strong class="title">Country</strong><br />
			{{ $data['details']['country'] }}<br /><br />

			<strong class="title">Email</strong><br />
			{{ $data['details']['email'] }}<br /><br />

			<strong class="title">Phone</strong><br />
			{{ $data['details']['phone'] }}<br /><br />
		</p>

		<h3 class="box-subtitle">Store Person Contact</h3>

		<p>

			<strong class="title">Name and Surname</strong><br />
			{{ $data['contact_details']['name'] }}<br /><br />

			<strong class="title">Street Address 1</strong><br />
			{{ $data['contact_details']['street_address_1'] }}<br /><br />

			<strong class="title">Street Address 2</strong><br />
			{{ $data['contact_details']['street_address_2'] }}<br /><br />

			<strong class="title">City</strong><br />
			{{ $data['contact_details']['city'] }}<br /><br />

			<strong class="title">Suburb</strong><br />
			{{ $data['contact_details']['suburb'] }}<br /><br />

			<strong class="title">Country</strong><br />
			{{ $data['contact_details']['country'] }}<br /><br />

			<strong class="title">Email</strong><br />
			{{ $data['contact_details']['email'] }}<br /><br />

			<strong class="title">Phone</strong><br />
			{{ $data['contact_details']['phone'] }}<br /><br />
		</p>

		@if($data['store_ecocash'])

		<h3 class="box-subtitle">Store General Contact</h3>

		<p>
			<strong class="title">Merchant Name or Account Type</strong><br />
			{{ $data['store_ecocash']['name'] }}<br /><br />

			<strong class="title">Number</strong><br />
			{{ ($data['store_ecocash']['number']) ? '+263' . $data['store_ecocash']['number'] : '' }}<br /><br />
		</p>

		@endif

		<?php

		// Contact Details

		// Store Ecocash

		// Name subscriber-acc / else custom
		// nr

		// Rothchild Zionism
		// 
		// 
		?>

		<a href="{{ URL::route('admin.stores') }}" class="btn btn-primary btn-flat" title="Back To Stores">Back To Stores</a>

	</div>

@stop