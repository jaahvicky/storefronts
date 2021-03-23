
<div class='category-header-breadcrumbs visible'>

	<div class='container'>
		<ul class='clearfix'>
			@if(!empty($store))
			<li>
				<a href='{{URL::route('store', ['slug' => $store->slug])}}'>{{ $store->name }}</a>
			</li>
			@endif
			@if(isset($pageTitle))
				@if(!empty($store))
				<li>&gt</li>
				@endif
				<li>
					{{ $pageTitle }}
				</li>

			@endif

		</ul>
	</div>

</div>