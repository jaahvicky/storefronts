
<div class='category-header-breadcrumbs'>

	<div class='container'>
		<ul class='clearfix'>

			<li>
				<!-- home -->
				<a href='{{URL::route('store', ['slug' => $store->slug])}}'>Home</a>
			</li>

			<?php $ancestor = $category->ancestor; ?>

			@if (isset($ancestor->ancestor))

				<li>&gt</li>
				<li>
					<a href='{{ URL::route('store-category', ['slug' => $store->slug, 'categorySlug' => $ancestor->ancestor->slug]) }}'>{{ $ancestor->ancestor->name }}</a>
				</li>

			@endif

			@if (isset($ancestor))

				<li>&gt</li>
				<li>
					<a href='{{ URL::route('store-category', ['slug' => $store->slug, 'categorySlug' => $ancestor->slug]) }}'>{{ $ancestor->name }}</a>
				</li>

			@endif
		
				<li>&gt</li>
				<li>
					{{ $category->name }}
				</li>

		</ul>
	</div>

</div>