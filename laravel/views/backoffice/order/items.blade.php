<div class='box box-primary @if( !isset($order_id) ) item-ele @endif'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">4</span>
            <div class='stepper-header'>
                <h3 class='box-title required'>Number of Items</h3>
                <p>Select the number of items </p>
            </div>
        </div>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('category')">
            {!! Form::Label('product', 'Slide or Click', []) !!}
            <div class="col-sm-12">
	           	<div class="col-sm-3">
	          		<span class="irs js-irs-2">
		          		<span class="irs-grid"></span>
		          		<span class="irs-shadow shadow-single" style="display: none;"></span>
	          		</span>
                    @if(isset($cur_order))
                        <input id="item_count" type="text" name="item_count" value="{{ $cur_order->item_count }}" class="irs-hidden-input" readonly="">
                    @else
                        <input id="item_count" type="text" name="item_count" value="" class="irs-hidden-input" readonly="">
                    @endif
	          		
	        	</div>
        	</div>
            @showErrors('product')
        </div>
        
    </div>
</div>