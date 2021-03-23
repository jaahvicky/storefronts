@extends('frontend/layout/default')

@section('content')


@include('frontend.layout.header')

<!-- breadcrumbs -->
@include('frontend.page.page-crumbs')

<!-- Main content -->

<section class="container">

	<div class='page-content-wrapper'>
		
		<div class='page-title'>{{ $pageTitle }}</div>
		<div class='page-content-text-wrapper'>	

			<h3>Use of cookies</h3>

			<ul>
				<li>A cookie is a small text file which is placed onto your computer (or other electronic device) when you access our website. We use cookies on this website to:</li>
				<li>Keep track of the items stored in your shopping basket and take you through the checkout process</li>
				<li>Recognise you whenever you visit this website (this speeds up your access to the site as you do not have to log on each time)</li>
				<li>Obtain information about your preferences, online movements and use of the internet</li>
				<li>Carry out research and statistical analysis to help improve our content, products and services and to help us better understand our customer requirements and interests</li>
				<li>Target our marketing and advertising campaigns more effectively by providing interest-based advertisements that are personalised to your interests</li>
				<li>Make your online experience more efficient and enjoyable.</li>
			</ul>

			<p>The information we obtain from our use of cookies will not usually contain your personal data. Although we may obtain information about your computer [or other electronic device] such as your IP address, your browser and/or other internet log information, this will not usually identify you personally. In certain circumstances we may collect personal information about you—but only where you voluntarily provide it (eg by completing an online form) or where you purchase goods or services from our site.</p>

			<p>In most cases we will need your consent in order to use cookies on this website. The exception is where the cookie is essential in order for us to provide you with a service you have requested (e.g. to enable you to put items in your shopping basket and use our check-out process.</p>

			<p>If you visit our website when your browser is set to accept cookies, we will interpret this as an indication that you consent to our use of cookies and other similar technologies as described in this Privacy Policy. If you change your mind in the future about letting us use cookies, you can modify the settings of your browser to reject cookies or disable cookies completely.</p>

			<h3>Third-party cookies</h3>

			<p>We work with third-party suppliers who may also set cookies on our website, for example. These third-party suppliers are responsible for the cookies they set on our site. If you want further information please go to the website for the relevant third party.</p>

			<h3>How to turn off cookies</h3>

			<p>If you do not want to accept cookies, you can change your browser settings so that cookies are not accepted. If you do this, please be aware that you may lose some of the functionality of this website. For further information about cookies and how to disable them please go to: <a href="http://www.aboutcookies.org/" target="_blank">www.aboutcookies.org</a> or <a href="http://www.allaboutcookies.org/" target="_blank">www.allaboutcookies.org</a>.</p>

		</div>

	</div>
	
	<hr>

</section>
<!-- /.content -->


@include('frontend.layout.store-footer')
@include('frontend.layout.footer')

@stop
