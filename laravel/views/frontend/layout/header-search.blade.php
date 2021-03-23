
@if(!empty($store))
{{ Form::open( [ 'route' => ['store-search', 'slug' => $store->slug], 'method' => 'post' ] ) }}

<div class='header-search-wrapper @if(Session::has('search-error')) search-error @endif'>

	<div class="input-group">
		<input type="text" class="form-control" name="term" placeholder="Search the store">
		<span class="input-group-btn">
		@if (isset($appearance))
			<button class="btn btn-primary" style="background-color: {{ $appearance->primary_colour  }}" type="submit">Search</button>
		@else
			<button class="btn btn-primary" type="submit">Search</button>
		@endif
			
		</span>
	</div><!-- /input-group -->

	@if(Session::has('search-error'))
		<p class="error">{{ Session::get('search-error') }}</p>
	@endif
	
</div>

{{ Form::close() }}
@endif