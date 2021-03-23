<div class="modal-dialog">
	<div class="modal-content">
            {!! Form::open(['route' => 'shopping.product.remove', 'id' => 'form-delete']) !!}
            {!! Form::hidden('id', $product->id) !!}
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Remove Product</h4>
		</div>
		<div class="modal-body">
			<p>Are you sure you would like to remove this product from the shopping cart?</p>
			<p><b>{{ $product->title }}</b></p>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
			<button type="submit" class="btn btn-primary">Okay</a>
		</div>
	</div>
</div>
