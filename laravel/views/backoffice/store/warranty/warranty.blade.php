<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <p>Define your warranty policy. Customers will follow this if they experience any issues with '{!! $store->name !!}' products.</p>
    </div>
    
    <div class='box-body'>
        
        <div class="form-group @hasError('warranty')">
            <textarea cols="80" id="warranty" name="warranty" rows="10" >
                {!! \ViewHelper::showValue(old('warranty'), $store->warranty, 'warranty') !!}
            </textarea>
            @showErrors('warranty')
        </div>
 
    </div>
        
</div>