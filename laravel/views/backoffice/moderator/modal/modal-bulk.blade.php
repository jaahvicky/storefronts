 <div class="modal-dialog">
	<div class="modal-content">
            {!! Form::open(['route' => 'admin.moderator.bulk.status', 'id' => 'form-delete']) !!}
            {!! Form::hidden('actionid', $status->id) !!}
            <input type="hidden" name="selected_ids" id="selected_ids" value="{{ $selectedid }}">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Bulk Actions</h4>
		</div>
		<div class="modal-body">
			<p>Are you sure you would like to {{ (($status->id == 1)? 'set to awaits moderation to ' : $status->name)}} this products?</p>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
			<button type="submit" class="btn btn-primary">Okay</a>
		</div>
	</div>
</div>