
<div class='category-header-breadcrumbs'>

	<div class='container'>
		<ul class='clearfix'>

			<li>
				<!-- home -->
				<a href='{{URL::route('store', ['slug' => $store->slug])}}'>Home</a>
			</li>

			<li>&gt</li>
			<li>
				{{ 'Search Results for "' . $term . '"'}}@if($category) {{ ' in category "' . $category->name . '"' }}@endif
			</li>

		</ul>
	</div>

</div>