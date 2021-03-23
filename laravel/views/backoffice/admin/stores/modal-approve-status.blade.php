<div class="modal-dialog">
	<div class="modal-content">
		{!! Form::open(['route' => 'admin.stores.change-status', 'id' => 'form-change-status']) !!}
		{!! Form::hidden('id', $store->id) !!}
                {!! Form::hidden('store_status', "Approved") !!}
                {!! Form::hidden('send_email', 1, ['id' => 'send-email']) !!}
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Approve Storefront</h4>
		</div>
		<div class="modal-body">
                    
                    <p>Do you want to send the Storeowner of <b>{!! $store->name !!}</b> the Get started email?</p>
		
		</div>
		<div class="modal-footer">
			<button id="status-dont-send" type="button" class="btn btn-default pull-left">Don't send</button>
			{!! Form::submit('Send email', ['class'=>'btn btn-primary']) !!}
		</div>
		{!! Form::close() !!}
	</div>
</div>

<script type='text/javascript'>
    
    $(function() {
        
        $("#status-dont-send").on('click', function() {
            $('#send-email').val(0);
            $('#form-change-status').submit();
        });
    
    });
    
</script>
