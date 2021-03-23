<div class='product-categories'>
	<!-- first tier -->
	<a href='{{URL::route('store-category', ['slug' => $store->slug, 'categorySlug' => $product->category->ancestor->slug])}}'>{{ $product->category->ancestor->name }}</a>
	<!-- second tier -->
	/ <a href='{{URL::route('store-category', ['slug' => $store->slug, 'categorySlug' => $product->category->slug])}}'>{{ $product->category->name }}</a>
	<!-- third tier -->
	@if ($product->categoryCustom)
	/ <a href='{{URL::route('store-category', ['slug' => $store->slug, 'categorySlug' => $product->categoryCustom->slug])}}'>{{ $product->categoryCustom->name }}</a>
	@endif
</div>