<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Colours</h3>
        <p>Define brand colours by using the colour pickers. Leave fields blank for default colours.</p>
    </div>
    
    <div class='box-body'>
        
        <div class='row'>
            <div class="form-group @hasError('primary-colour') col-lg-6 col-xs-11">

                {!! Form::Label('primary-colour', 'Primary', ['class' => '']) !!}
                <div class="input-group colorpicker-component" id="colorpicker-primary">
                    {!! Form::text('primary-colour',
                    \ViewHelper::showValue(old('primary-colour'), $store->appearance, 'primary_colour', '#009eff'), 
                    ['class' => 'form-control', 'placeholder' => '#009eff'] ) !!}  
                    <span class="input-group-addon"><i></i></span>
                </div>
                @showErrors('primary-colour')
                <div>
                    <a class='colorpicker-reset-link' id='color-reset-primary'>Reset to default</a>
                </div>
            </div>
        </div>
        
        <div class='row'>
            <div class="form-group @hasError('secondary-colour') col-lg-6 col-xs-11">

                {!! Form::Label('secondary-colour', 'Secondary', ['class' => '']) !!}
                <div class="input-group colorpicker-component" id="colorpicker-secondary">
                    {!! Form::text('secondary-colour', 
                    \ViewHelper::showValue(old('secondary-colour'), $store->appearance, 'secondary_colour', '#22d497'), 
                    ['class' => 'form-control', 'placeholder' => '#22d497'] ) !!}    
                    <span class="input-group-addon"><i></i></span>
                </div>
                @showErrors('secondary-colour')
                <div>
                    <a class='colorpicker-reset-link' id='color-reset-secondary'>Reset to default</a>
                </div>
            </div>
        </div>
        
        
    </div>
        
</div>






