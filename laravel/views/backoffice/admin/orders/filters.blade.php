<div class='row row-vertical-margin row-filters' data-methys-filter="container" 
	 data-methys-filter-url="{{URL::route('ajax-filters-queue', ['tag'=>'orders'])}}">
	<!-- search customer -->
	<div class='col-xs-12'>
		<div class='form-inline'>


			<!-- status -->
			<div class="btn-group" data-methys-filter='dropdown-toggle'>
				<button class="btn btn-default btn-label">Filter by delivery status </button>
				<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Any <span class="caret"></span></button>
				<ul class="dropdown-menu noclose">
					<li>
						<input type="radio" 
							   id="orderDeliveryStatusany" 
							   name="orderstatus[]" 
							   value="any"
							   {{ SortFilterHelper::isFilterArrayValueSet('orderstatus', 'any', 'orders') ? 'checked="checked"':'' }}
							   >
							   <label for="orderDeliveryStatusany">Any</label>
					</li>
					@foreach ($StatusFilters as $status)
					<li>
						<input type="radio" 
							   id="orderDeliveryStatus{{$status->status}}" 
							   name="orderstatus[]" 
							   value="{{$status->id}}"
							   {{ SortFilterHelper::isFilterArrayValueSet('orderstatus', $status->id, 'orders') ? 'checked="checked"':'' }}
							   >
							   <label for="orderDeliveryStatus{{$status->status}}">{{$status->status}}</label>
					</li>
					@endforeach
				</ul>
			</div> 
			<!-- search store name -->
			<div class="form-group" data-methys-filter='input-search-group'>
				<label>Store Name</label> 
			
				<input type="text" name="store_name" id="store_name" value ="{{ SortFilterHelper::isFilterTextValue('store_name', 'orders')}}" class="form-control">
				<button class="btn btn-primary btn-label" id="store_btn">Search Store</button>
			</div>
			
			<!-- search order id -->
			<div class="form-group" data-methys-filter='input-search-group'>
				<label>Order ID</label>
			
				<input type="text" name="Order_id" id="Order_id" value ="{{ SortFilterHelper::isFilterTextValue('Order_id', 'orders')}}" class="form-control">
				<button class="btn btn-primary btn-label" id="order_btn">Search Order ID</button>
			</div>
			
		</div>
		
		
	</div>
	<div class='col-xs-4 search-tag'>
		
		
	</div>
</div>
<style type="text/css">
	.search-tag{
		margin-top: 10px;
	}
</style>
@js('plugins/methys-javascript/methys.filters.js')
@js('plugins/bootstrap-dropdowns-enhancement/v3.1.1-beta/dropdowns-enhancement.js') 
@css('plugins/bootstrap-dropdowns-enhancement/v3.1.1-beta/dropdowns-enhancement.css')
@css('css/backoffice.css')
