<div class="modal-dialog">
	<div class="modal-content">
		{!! Form::open(['route' => 'admin.manage.order.change-status', 'id' => 'form-change-status']) !!}
		{!! Form::hidden('id', $order->id) !!}
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Change Delivery Status</h4>
		</div>
		<div class="modal-body">

                    <p>Change the delivery status for order number <b>{!! $order->invoice_number !!}</b> from <b>{!! $order->DeliveryStatus->status !!}</b>.</p>
			<div class="form-group">
                            {!! Form::Label('order_status', 'Delivery Status', ['class' => '']) !!}
                            {!! Form::select('order_status', $statuses, [$order->delivery_status_id], ['class' => 'form-control', 'id' => 'select-order-status']) !!}    
                        </div>
		
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button type="submit" id="submit-status" class="btn btn-sm btn-primary pull-right"'> Change Status </button>
		</div>
		{!! Form::close() !!}
	</div>
</div>

<script type='text/javascript'>
    
   
    
</script>
