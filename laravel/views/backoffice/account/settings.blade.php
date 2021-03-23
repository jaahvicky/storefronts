<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Store URL</h3>
    </div>
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.account.update']) !!}
    
    <div class='box-body'>
        
        <div class="form-group @hasError('domain')">
            {!! Form::Label('domain', 'URL', ['class' => '']) !!}
            {!! Form::text('domain', URL::route('store', ['store' => $store->slug]), ['class' => 'form-control', 'placeholder' => 'http://www.mystorename.ownai.co.zw', 'readonly' => 'true'] ) !!}
            @showErrors('domain')
        </div>
        
    </div>
    
</div>



