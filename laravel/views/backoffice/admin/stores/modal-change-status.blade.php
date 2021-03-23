<div class="modal-dialog">
	<div class="modal-content">
		{!! Form::open(['route' => 'admin.stores.change-status', 'id' => 'form-change-status']) !!}
		{!! Form::hidden('id', $store->id) !!}
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Change Status</h4>
		</div>
		<div class="modal-body">

                    <p>Change the status for <b>{!! $store->name !!}</b> from <b>{!! $store->status->label !!}</b>.</p>
			<div class="form-group">
                            {!! Form::Label('store_status', 'Status', ['class' => '']) !!}
                            {!! Form::select('store_status', $statuses, [$store->status->label], ['class' => 'form-control', 'id' => 'select-store-status']) !!}    
                        </div>
		
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <a id="submit-status" class="btn btn-sm btn-primary pull-right" data-modal='true'> Change Status </a>
		</div>
		{!! Form::close() !!}
	</div>
</div>

<script type='text/javascript'>
    
    $(function() {
        
        $('#select-store-status').change(function() {
            var status = $(this).val();
            if (status == 'Approved') {
                $('#submit-status').attr('href', '{{ URL::route('admin.stores.modal-approve-status', ['id' => $store->id]) }}');
            }
            else {
                $('#submit-status').removeAttr('href');
            }
        });
        
        $("#submit-status").on('click', function() {
            var status =  $('#select-store-status').val();
            if (status != 'Approved') {
                $('#form-change-status').submit();
            }
            else {
                $('.modal').modal('hide');
            }
        });
    
    });
    
</script>
