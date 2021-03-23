<section class='product-header-breadcrumbs'>
	<div class='container'>
		<ul class='clearfix'>
			<li>
				<!-- home -->
				<a href='{{URL::route('store', ['slug' => $store->slug])}}'>Home</a>
			</li>
			<li>&gt</li>
			<?php 
			$categories = [];
			$category = $product->category;
			$categories[] = $category;
			while ($category->ancestor) {
				$category = $category->ancestor;
				$categories[] = $category;
			}
			?>
			@for($i=count($categories)-1; $i>=0; $i--)
			<li>
				<a href='{{URL::route('store-category', ['slug' => $store->slug, 'categorySlug' => $categories[$i]->slug])}}'> {{ $categories[$i]->name }}</a>
			</li>
			<li>&gt</li>
			@endfor
			<li>
				<!-- product -->
				{{ $product->title }}
			</li>
		</ul>
	</div>
</section>