<div class="modal-dialog">
	<div class="modal-content">
            {!! Form::open(['route' => 'admin.moderator.status', 'id' => 'form-delete']) !!}
            {!! Form::hidden('id', $product->id) !!}
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Change Status</h4>
		</div>
		<div class="modal-body">
			<p>Change the status for <b>{!! $product->title !!}</b> from <b>{!! $product->productModerationType->name !!}</b>.</p>
			<div class="form-group">
                {!! Form::Label('store_status', 'Status', ['class' => '']) !!}
                <select id="status_id" name="status_id" class="form-control">
                 @foreach($statuses as $status)
                 	@if($status->id != $product->product_moderation_type_id)
                 	   <option value="{{$status->id}}">
                 	     {{ ( ($status->id == 1)? 'Approve' : 'Reject') }}
                 	   </option>
                 	@endif
                @endforeach	
                </select>

            </div>
		
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
			<button type="submit" class="btn btn-primary">Okay</a>
		</div>
	</div>
</div>