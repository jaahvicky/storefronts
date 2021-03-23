
<div id="{{ $modal_info['mod_id'] . '-modal' }}" class="modal fade">

<div class="modal-dialog">
	<div class="modal-content">

		{{ Form::model($order, ['route' => ['orders.updatestatus', $order->id], 'id' => 'form-change-order-status', 'method' => 'put']) }}

		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">{{ $modal_info['title'] }}</h4>
		</div>

		<div class="modal-body">
			<p>{{ $modal_info['body'] }}</p>
			<input type="hidden" name="next" value ="{{ $modal_info['mod_id'] }}" />

			<?php
			// 1. if the next method is cancel, show the reason fields
			// 2. If the user chose Other, the desc field is required
			// 3. in php, if the method is cancel, save the cancel order reasons
			?>

			@if($modal_info['mod_id'] === 'cancel')

				<?php $order_options = LookupHelper::getOrderCancelOptions(); ?>

				<p><strong>Please provide a cancellation reason: </strong></p>
				<div class="form-group @hasError('cancellation_reason')">

				@showErrors('cancellation_reason')

					@foreach($order_options as $k => $option)
					
					<div class="checkbox">
						<label>
							{{ Form::checkbox('cancellation_reason['.$option['id'].']', 1, null, ['id' => 'cancellation_' . $k, 'style' => 'margin-top: 4px;']) }}
							{{ $option['options'] }}
						</label>
					</div>
					
					@endforeach

				</div>

				<p><strong>Please specify</strong></p>

				<div class="form-group @hasError('other_reason')">
					{{ Form::textarea('other_reason', null, ['rows' => '5', 'style' => 'min-width: 100%; max-width: 100%; ']) }}
					<h6 class="pull-right" id="count_255">&nbsp;</h6>
				</div>

				@showErrors('other_reason')

			@endif

		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
			{{ Form::submit($modal_info['main_btn_text'], ['class' => 'btn btn-primary']) }}
		</div>

		{{ Form::close() }}

	</div>
</div>

</div>