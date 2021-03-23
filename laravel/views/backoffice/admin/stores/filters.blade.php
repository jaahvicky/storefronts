<div class='row row-vertical-margin row-filters' data-methys-filter="container" 
	 data-methys-filter-url="{{URL::route('ajax-filters-queue', ['tag'=>'stores'])}}">
	<!-- search customer -->
	<div class='col-xs-12'>
		<div class='form-inline'>


			<!-- status -->
			<div class="btn-group" data-methys-filter='dropdown-toggle'>
				<button class="btn btn-default btn-label">Filter by status </button>
				<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Any <span class="caret"></span></button>
				<ul class="dropdown-menu noclose">
					<li>
						<input type="radio" 
							   id="storeStatusTypeany" 
							   name="storeStatus[]" 
							   value="any"
							   {{ SortFilterHelper::isFilterArrayValueSet('storeStatus', 'any', 'stores') ? 'checked="checked"':'' }}
							   >
							   <label for="storeStatusTypeany">Any</label>
					</li>
					@foreach (LookupHelper::getStoreStatusTypes() as $type)
					<li>
						<input type="radio" 
							   id="storeStatusType{{$type->label}}" 
							   name="storeStatus[]" 
							   value="{{$type->label}}"
							   {{ SortFilterHelper::isFilterArrayValueSet('storeStatus', $type->label, 'stores') ? 'checked="checked"':'' }}
							   >
							   <label for="storeStatusType{{$type->label}}">{{$type->label}}</label>
					</li>
					@endforeach
				</ul>
			</div> 

			<!-- Payment status -->
			<div class="btn-group" data-methys-filter='dropdown-toggle'>
				<button class="btn btn-default btn-label">Filter by Payment Status </button>
				<button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Any <span class="caret"></span></button>
				<ul class="dropdown-menu noclose">
					<li>
						<input type="radio" 
							   id="storeStatuspaymentany" 
							   name="storeStatusPayment[]" 
							   value="any"
							   {{ SortFilterHelper::isFilterArrayValueSet('storeStatusPayment', 'any', 'stores') ? 'checked="checked"':'' }}
							   >
							   <label for="storeStatuspaymentany">Any</label>
					</li>
					<li>
						<input type="radio" 
							   id="storeStatuspaymentlatepayment" 
							   name="storeStatusPayment[]" 
							   value="pending"
							   {{ SortFilterHelper::isFilterArrayValueSet('storeStatusPayment', 'pending', 'stores') ? 'checked="checked"':'' }}
							   >
							   <label for="storeStatuspaymentlatepayment">Late Payment</label>
					</li>
					<li>
						<input type="radio" 
							   id="storeStatuspaymentpaid" 
							   name="storeStatusPayment[]" 
							   value="complete"
							   {{ SortFilterHelper::isFilterArrayValueSet('storeStatusPayment', 'complete', 'stores') ? 'checked="checked"':'' }}
							   >
							   <label for="storeStatuspaymentpaid">Paid</label>
					</li>
					
				</ul>
			</div>
		</div>
	</div>
</div>

@js('plugins/methys-javascript/methys.filters.js')
@js('plugins/bootstrap-dropdowns-enhancement/v3.1.1-beta/dropdowns-enhancement.js')
@css('plugins/bootstrap-dropdowns-enhancement/v3.1.1-beta/dropdowns-enhancement.css')
@css('css/backoffice.css')
