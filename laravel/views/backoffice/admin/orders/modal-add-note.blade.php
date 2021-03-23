<div class="modal-dialog">
	<div class="modal-content">
		{!! Form::open(['route' => 'admin.manage.order.change-note', 'id' => 'form-change-status']) !!}
		{!! Form::hidden('id', $order->id) !!}
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">{{((empty($order->order_notes)? 'Add' : 'Update'))}} Order Note</h4>
		</div>
		<div class="modal-body">
                 <p>{{((empty($order->order_notes)? 'Add' : 'Update'))}} note for order number <b>{!! $order->invoice_number !!}</b>.</p>
			<div class="form-group">
                 {!! Form::Label('order_status', 'Order Note', ['class' => '']) !!}
                  {!! Form::textarea('note', 
                \ViewHelper::showValue(old('note'), (isset($order)) ? $order : null, 'order_notes'),
                ['class' => 'form-control', 'id'=>'note', 'required'] ) !!}               
             </div>
		
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
            <button id="submit-status" class="btn btn-sm btn-primary pull-right"'> Change Status </button>
		</div>
		{!! Form::close() !!}
	</div>
</div>

<script type='text/javascript'> 
   
    
</script>
