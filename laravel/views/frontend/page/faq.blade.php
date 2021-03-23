@extends('frontend/layout/default')

@section('content')


@include('frontend.layout.header')

<!-- breadcrumbs -->
@include('frontend.page.page-crumbs')

<!-- Main content -->

<section class="container">

	<div class='page-content-wrapper'>
		
		<div class='page-title'>Frequently Asked Questions</div>
		<div class='page-content-text-wrapper'>	
			
			<p>Have a question about Ownai Storefronts platform? View answers to common questions below.</p>

			<div class="panel-group" id="faq">

				<!-- Question 1 and Answer -->
				
				<div class="panel panel-default">
					
					<div class="panel-heading">
						
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#faq" href="#question-1">What is a Storefront?</a>
						</h4>

					</div>

					<div id="question-1" class="panel-collapse collapse in">
						<div class="panel-body">
							<p>
							We've created Storefronts with you, the customer in mind. Your own Storefront opens a world of possibilities. Showcase your products and reach millions of Zimbabweans across the country.</p>
						</div>
					</div>

				</div>

				<!-- Question 2 and Answer -->
				
				<div class="panel panel-default">
					
					<div class="panel-heading">
						
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#faq" href="#question-2">How do I sign up for my own Storefront?</a>
						</h4>

					</div>

					<div id="question-2" class="panel-collapse collapse">
						<div class="panel-body">
							<p>
							Simply click 'Register' and follow our easy sign up process. We'll have you up and running in no time at all.</p>
						</div>
					</div>

				</div>

				<!-- Question 3 and Answer -->
				
				<div class="panel panel-default">
					
					<div class="panel-heading">
						
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#faq" href="#question-3">Who can I sell my products to?</a>
						</h4>

					</div>

					<div id="question-3" class="panel-collapse collapse">
						<div class="panel-body">
							<p>
							With Ownai Storefronts, the possibilities are endless. Showcase and sell your products across Zimbabwe!</p>
						</div>
					</div>

				</div>

				<!-- Question 4 and Answer -->
				
				<div class="panel panel-default">
					
					<div class="panel-heading">
						
						<h4 class="panel-title">
							<a data-toggle="collapse" data-parent="#faq" href="#question-4">I need help?</a>
						</h4>

					</div>

					<div id="question-4" class="panel-collapse collapse">
						<div class="panel-body">
							<p>
							We're here every step of the way. Give us a call on 118 and we'd be glad to assist in getting you started.</p>
						</div>
					</div>

				</div>

			</div>

		</div>

	</div>
	
	<hr>

</section>
<!-- /.content -->


@include('frontend.layout.store-footer')
@include('frontend.layout.footer')

@stop
