@extends('frontend/layout/default')

@section('content')


@include('frontend.layout.header')

<!-- breadcrumbs -->
@include('frontend.categories.category-crumbs')
@include('frontend.layout.store-header')

<!-- Main content -->
<section class="container category-container">

	<div class='store-description-wrapper'>
		
		<!-- desktop category header -->
		<div class='row clearfix category-header'>
			<div class='col-xs-12 clearfix'>
				
				@if (isset($appearance) && $appearance->logo_image)

				<div class='store-logo-wrapper pull-left'>
					<div class='store-logo' style='background-image: url("{{asset($appearance->logo_image)}}")'></div>
				</div>

				@else

				<div class='store-logo-wrapper pull-left'>
					<div class='store-logo' style='background-image: url("{{asset("images/store/store.png")}}")'></div>
				</div>

				@endif

				<!-- category name or search results -->
				<div class='store-category-header-wrapper pull-left hidden-xs'>
					<h1>
						@if ($category)
							{{ $category->name }}
						@else
							Search Results
						@endif
					</h1>
				</div>

			</div>
		</div>
		<!-- end desktop category header -->

	</div>

	<!-- filters -->
	@include('frontend.categories.filters')

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