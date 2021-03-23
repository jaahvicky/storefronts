<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">4</span>
            <div class='stepper-header'>
                <h3 class='box-title'>Visibility</h3>
            </div>
        </div>
    </div>
    
    <div class='box-body'>
        
        <div class="form-group @hasError('visibility')">
            {!! Form::Label('visibility', 'Visibility', ['class' => '  ']) !!}
            {!! Form::select('visibility', $visibilities, 
                \ViewHelper::showValue(old('visibility'), (isset($product) && !is_null($product->productStatus)) ? $product->productStatus : null, 'name'),
                ['class' => 'form-control', 'id' => 'visibility']); !!}    
            @showErrors('visibility')
        </div>
        
    </div>
    
</div>