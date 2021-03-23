<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Excerpt</h3>
        <p>A short introduction about your store, displayed on the store landing page (max 100 characters).</p>
    </div>
    
    <div class='box-body'>
 
        <div class="form-group @hasError('exerpt')">
            {!! Form::textarea('exerpt', 
                \ViewHelper::showValue(old('exerpt'), $store->about, 'exerpt'),
                ['class' => 'form-control'] ) !!}    
            @showErrors('exerpt')
        </div>

    </div>
        
</div>