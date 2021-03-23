<div class="box box-primary">

	<div class='box-header with-border'>
        <h3 class='box-title'>Store Delivery Methods</h3>
    </div>

    <div class="box-body">
     	<div class="row mt-10">
     		 <div class="col-md-2 ">
                   <label class="control-label">Current Method:</label>
                </div>
             <div class="col-md-8">
                    <span class="pull-left">{{$store->deliveryMethods->method}}</span>
             </div>
     	</div>
     	
		<div class="form-group mt-10">
                <label for="store-type">Store Delivery Method</label> 
                <p class="text small">Select a storefront delivery method. This will impact your products delivery methods.</p>
                {!! Form::select('store_delivery', $storefront_delivery_method, 
                    (isset($store) && empty(old('store_delivery')) ) ? $store->store_delivery_method_id : old('store_delivery'),
                    ['class' => 'form-control', 'placeholder' => 'Select a store delivery method']); !!}    
                
            </div>

    </div>

</div>
<style type="text/css">
	.mt-10 {
    	margin-top: 10px;
	}
</style>