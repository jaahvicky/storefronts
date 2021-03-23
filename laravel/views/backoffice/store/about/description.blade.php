<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Description</h3>
        <p>Tell people all about your store. The text will be displayed on the About page.</p>
    </div>
    
    <div class='box-body'>
 
        <div class="form-group @hasError('description')">
            <textarea cols="80" id="description" name="description" rows="10" >
                {!! \ViewHelper::showValue(old('description'), $store->about, 'description') !!}
            </textarea>
            @showErrors('description')
        </div>

    </div>
        
</div>