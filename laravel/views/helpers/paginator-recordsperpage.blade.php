<div>
	<select data-pagination='rpp'>
		@foreach($paginationDropdownOptions as $paginationOption)
			<option value='{{$paginationOption}}' {{ PaginationHelper::isRppSelected($paginationOption) ? 'SELECTED' : '' }} >{{$paginationOption}}</option>
		@endforeach
	</select>
	{!! isset($listingName) ? $listingName : "Entries" !!} per page
</div>