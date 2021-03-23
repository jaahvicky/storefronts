<div class="modal-dialog">
	<div class="modal-content">
		{!! Form::open(['route' => 'admin.product.variant.add', 'id'=>'variant-post']) !!}
		{!! Form::hidden('store_id', $store->id) !!}
		
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			<h4 class="modal-title">Add Product Attribute</h4>
		</div>
		
		<div class="modal-body">
			<div class="alert alert-danger"></div>
			<div class="form-group ">
				<label for="variant_name">Attribute name</label>
				 <input type="text" name="variant_name" id="variant_name" class="form-control" />
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <a id="submit-status" class="btn btn-sm btn-primary pull-right"> Add Attribute</a>
		</div>
		{!! Form::close() !!}
	</div>
</div>
<script type='text/javascript'>
    
    $(function() {
    	$('.alert-danger').hide();
        $("#submit-status").on('click', function() {
        	$('.alert-danger').hide();
        	$('#variant-post').find('#variant_name').each(function() {
        		if($(this).val().trim().length < 4){
					$('.alert-danger').html('Variant name cannot be less that 3 characters').show();
        		}else{
        			$('#variant-post').submit();
        		}
			});
            
        });
    
    });
    
</script>