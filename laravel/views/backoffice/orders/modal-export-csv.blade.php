<?php 

/*
 * Copyright (c) 2017 Methys Digital
 * All rights reserved.
 *
 * This software is the confidential and proprietary information of Methys Digital.
 * ("Confidential Information"). You shall not disclose such
 * Confidential Information and shall use it only in accordance with
 * the terms of the license agreement you entered into with Methys Digital.
 */

?>

<div id="order-export-modal" class="modal fade" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">

			{{ Form::open([ 'route' => ['orders.csv'], 'id' => 'form-change-order-billing', 'method' => 'post' ]) }}

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Choose Date Range</h4>
				<p>Please optionally fill in from and/or to date for the desired results</p>
			</div>
			<div class="modal-body">

				<div class="form-group @hasError('from_date')">
					{!! Form::label('from_date', 'From Date(optional)') !!}
				    {!! Form::text('from_date', 
				        (old('from_date')) ? old('from_date') : null,
				        ['class' => 'form-control', 'placeholder' => "From Date(DD/MM/YYYY)"] ) !!}    
				    <?php \ViewHelper::showErrors(('from_date')) ?>
				</div>

				<div class="form-group @hasError('to_date')">
					{!! Form::label('to_date', 'To Date(optional)') !!}
				    {!! Form::text('to_date', 
				        (old('to_date')) ? old('to_date') : null,
				        ['class' => 'form-control', 'placeholder' => "To Date(DD/MM/YYYY)"] ) !!}    
				    <?php \ViewHelper::showErrors(('to_date')) ?>
				</div>

				
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>

				{{ Form::submit('Create CSV', ['class' => 'btn btn-primary btn-flat', 'style' => 'margin-left:10px;', 'id' => 'saveButton']) }}

			</div>

			{{ Form::close() }}

		</div>
	</div>

</div>