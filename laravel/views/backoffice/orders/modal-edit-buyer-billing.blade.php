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

<div id="order-billing-modal" class="modal fade" aria-hidden="true">

	<div class="modal-dialog">
		<div class="modal-content">

			{{ Form::model($order, [ 'route' => ['orders.update-billing', $order->id], 'id' => 'form-change-order-billing', 'method' => 'put' ]) }}

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
				<h4 class="modal-title">Edit Details</h4>
			</div>
			<div class="modal-body">

				<div class="form-group @hasError('buyer_firstname')">
				    {!! Form::text('buyer_firstname', 
				        \ViewHelper::showValue(old('buyer_firstname'), (isset($order)) ? $order : null, 'buyer_firstname'),
				        ['class' => 'form-control', 'placeholder' => "Buyer First Name"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_firstname')) ?>
				</div>

				<div class="form-group @hasError('buyer_lastname')">
				    {!! Form::text('buyer_lastname', 
				        \ViewHelper::showValue(old('buyer_lastname'), (isset($order)) ? $order : null, 'buyer_lastname'),
				        ['class' => 'form-control', 'placeholder' => "Buyer Last Name"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_lastname')) ?>
				</div>

				<div class="form-group @hasError('buyer_address_line_1')">
				    {!! Form::text('buyer_address_line_1', 
				        \ViewHelper::showValue(old('buyer_address_line_1'), (isset($order)) ? $order : null, 'buyer_address_line_1'),
				        ['class' => 'form-control', 'placeholder' => "Buyer Address Line 1"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_address_line_1')) ?>
				</div>

				<div class="form-group @hasError('buyer_address_line_2')">
				    {!! Form::text('buyer_address_line_2', 
				        \ViewHelper::showValue(old('buyer_address_line_2'), (isset($order)) ? $order : null, 'buyer_address_line_2'),
				        ['class' => 'form-control', 'placeholder' => "Buyer Address Line 2"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_address_line_2')) ?>
				</div>

				<div class="form-group @hasError('buyer_suburb')">
				    {!! Form::text('buyer_suburb', 
				        \ViewHelper::showValue(old('buyer_suburb'), (isset($order)) ? $order : null, 'buyer_suburb'),
				        ['class' => 'form-control', 'placeholder' => "Buyer Suburb"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_suburb')) ?>
				</div>

				<div class="form-group @hasError('buyer_city')">
				    {!! Form::text('buyer_city', 
				        \ViewHelper::showValue(old('buyer_city'), (isset($order)) ? $order : null, 'buyer_city'),
				        ['class' => 'form-control', 'placeholder' => "Buyer City"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_city')) ?>
				</div>

				<div class="form-group @hasError('buyer_province_state')">
				    {!! Form::text('buyer_province_state', 
				        \ViewHelper::showValue(old('buyer_province_state'), (isset($order)) ? $order : null, 'buyer_province_state'),
				        ['class' => 'form-control', 'placeholder' => "Buyer State/Province"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_province_state')) ?>
				</div>

				<div class="form-group @hasError('buyer_country')">
				    {!! Form::text('buyer_country', 
				        \ViewHelper::showValue(old('buyer_country'), (isset($order)) ? $order : null, 'buyer_country'),
				        ['class' => 'form-control', 'placeholder' => "Buyer Country"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_country')) ?>
				</div>

				<div class="form-group @hasError('buyer_postal_code')">
				    {!! Form::text('buyer_postal_code', 
				        \ViewHelper::showValue(old('buyer_postal_code'), (isset($order)) ? $order : null, 'buyer_postal_code'),
				        ['class' => 'form-control', 'placeholder' => "Buyer Postal Code"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_postal_code')) ?>
				</div>

				<div class="form-group @hasError('buyer_email')">
				    {!! Form::text('buyer_email', 
				        \ViewHelper::showValue(old('buyer_email'), (isset($order)) ? $order : null, 'buyer_email'),
				        ['class' => 'form-control', 'placeholder' => "Buyer Postal Code"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_email')) ?>
				</div>

				<div class="form-group @hasError('buyer_phone')">
				    {!! Form::text('buyer_phone', 
				        \ViewHelper::showValue(old('buyer_phone'), (isset($order)) ? $order : null, 'buyer_phone'),
				        ['class' => 'form-control', 'placeholder' => "Buyer Contact Number"] ) !!}    
				    <?php \ViewHelper::showErrors(('buyer_phone')) ?>
				</div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>

				{{ Form::submit('Save', ['class' => 'btn btn-primary btn-flat', 'style' => 'margin-left:10px;', 'id' => 'saveButton']) }}

			</div>

			{{ Form::close() }}

		</div>
	</div>

</div>