@extends('frontend/layout/default')

@section('content')


@include('frontend.layout.header-openstore')

<!-- breadcrumbs -->
{{--@include('frontend.page.page-crumbs')--}}


<div class="open-a-store">

	<!-- store banner -->
	<section id="sp-store-banner" role="store banner">

		<div class="container text-center">
			<h1 class=""><span class="color-orange bold-text"></span> </h1>
			<div class="sp-cta-box">
				<h3>Open your store</h3>
			  	<p>Create your own storefront to sell all kinds of products online now!</p>
			  	<a class="btn btn-primary btn-md btn-block" href="{{URL::route('store.setup.details')}}" role="button">Register Now</a>
			</div>
		</div>
	</section>
	<!-- store banner end -->

	<!-- main container -->
	<div class="container">

		<main class="main" role="main content">
			<!-- intro -->
			<section id="sp-intro" class="text-center" role="intro & features">
				<h2 class="sp-title">Features</h2>

				<div class="row sp-selling-points">
					<div class="col-sm-3">
						<img src="{{ asset('images/store/women_park_laptop.jpg') }}" alt="">
						<h3>Sell products across Zimbabwe</h3>
						<p>Sell your products across Zimbabwe and reach Ownai's full audience.</p>
					</div>
					<div class="col-sm-3">
						<img src="{{ asset('images/store/man_holding_phone.jpg') }}" alt="">
						<h3>Digital Storefronts</h3>
						<p>Create your own digital store and be seen by thousands of users across Zimbabwe.</p>
					</div>
					<div class="col-sm-3">
						<img src="{{ asset('images/store/man_holding_tablet.jpg') }}" alt="">
						<h3>Easy store management</h3>
						<p>Manage your Storefront easily with our well designed and easy to use product management features.</p>
					</div>
					<div class="col-sm-3">
						<img src="{{ asset('images/store/ecocash_payment.jpg') }}" alt="">
						<h3>Simple payment with EcoCash</h3>
						<p>Accept payment for your goods with EcoCash.</p>
					</div>
				</div>
			</section>
			<!-- intro end -->

			<!-- features -->
			<section id="sp-key-features" role="more features">
				<h2 class="text-center sp-title">More reasons to register</h2>

				<div class="row sp-feature-row">
					<div class="col-sm-6">
						<i class="material-icons  sp-customize">store_mall_directory</i>
						<h3>Customize your store appearance</h3>
						<p>Make your Storefront unique with a range of custom banners and colour choices.</p>
					</div>
					<div class="col-sm-6">
						<i class="material-icons sp-ssl">verified_user</i>
						<h3>Secure personal information</h3>
						<p>Your personal information is always safe with us, our transaction are secured by EcoCash.</p>
					</div>
				</div>
				<div class="row sp-feature-row">
					<div class="col-sm-6">
						<i class="material-icons sp-logistics">local_shipping</i>
						<h3>Order delivery with Ownai Logistics</h3>
						<p>Door to door delivery with Ownai Logistics is safer and better.</p>
					</div>
					<div class="col-sm-6">
						<i class="material-icons sp-support">headset_mic</i>
						<h3>Friendly professional support</h3>
						<p>We're always here for you, our friendly support is here to assit every step of the way.</p>
					</div>
				</div>
			</section>
			<!-- features end -->
		</main>
		<!-- main end -->
	</div>

	<!-- faq -->

	<section id="sp-faq" class="sp-dark-bg" role="freaquently asked questions">
		<div class="container">
			<div class="col-sm-10 col-sm-offset-1">
				<h2 class="text-center">Frequently asked questions</h2>

				<!-- accordian -->
				<div class="sp-faq-accordian">
					<ol>
						<li data-toggle="collapse" data-target="#question">
							What is a Storefront? <i class="material-icons pull-right">keyboard_arrow_down</i>
							<div id="question" class="collapse">
								We've created Storefronts with you, the customer in mind.
								Your own Storefront opens a world of possibilities.  Showcase your products and reach millions of Zimbabweans across the country.
							</div>
						</li>
						<li data-toggle="collapse" data-target="#question2">
							How do I sign up for my own Storefront? <i class="material-icons pull-right">keyboard_arrow_down</i>
							<div id="question2" class="collapse">
								Simply click 'Register' and follow our easy sign up process.  We'll have you up and running in no time at all.
							</div>
						</li>
						<li data-toggle="collapse" data-target="#question3">
							Who can I sell my products to? <i class="material-icons pull-right">keyboard_arrow_down</i>
							<div id="question3" class="collapse">
								With Ownai Storefronts, the possibilities are endless.  Showcase and sell your products across Zimbabwe!
							</div>
						</li>
						<li data-toggle="collapse" data-target="#question4">
							I need help? <i class="material-icons pull-right">keyboard_arrow_down</i>
							<div id="question4" class="collapse">
								We're here every step of the way.  Give us a call on 118 and we'd be glad to assist in getting you started.
							</div>
						</li>
					</ol>
				</div>
			</div>
		</div>
	</section>
	<!-- faq end -->


	<!-- registration -->
	<section id="sp-register" class="sp-dark-bg" role="open a store">
		<div class="container">
			<div class="row sp-cto">
				<div class="col-sm-12 text-center">
					<h2 class="">Open your store today</h2>
					<a href="{{URL::route('store.setup.details')}}" class="btn btn-md btn-default">Register Now </a>
				</div>

			</div>
		</div>
	</section>
	<!-- registration end -->

</div>


{{--@include('frontend.layout.store-footer')--}}
@include('frontend.layout.footer')

@stop
