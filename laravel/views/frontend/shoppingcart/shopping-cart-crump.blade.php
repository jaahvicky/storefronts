<div class="container">
	<ol class=" breadcrumb">
  		<li class="breadcrumb-item"><a href="{{URL::route('store', ['slug' => $store->slug])}}">Home</a></li>
  		<li class="breadcrumb-item active">Shopping Cart</li>
	</ol>
	@include('frontend.layout.flash-header')
</div>

