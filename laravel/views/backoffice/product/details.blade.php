<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">2</span>
            <div class='stepper-header'>
                <h3 class='box-title'>Product Details</h3>
                <p>Add item details and upload photos.</p>
            </div>
        </div>
    </div>
    
    <div class='box-body'>
        
        <div class="form-group @hasError('title')">
            {!! Form::Label('title', 'Product Title', ['class' => '  ']) !!}
            {!! Form::text('title', 
                \ViewHelper::showValue(old('title'), (isset($product)) ? $product : null, 'title'),
                ['class' => 'form-control', 'placeholder' => 'The Product Name'] ) !!}    
            @showErrors('title')
        </div>
        
        <div class="form-group @hasError('description')">
            {!! Form::Label('description', 'Item Description', ['class' => '']) !!}
            {!! Form::textarea('description', 
                \ViewHelper::showValue(old('description'), (isset($product)) ? $product : null, 'description'),
                ['class' => 'form-control', 'placeholder' => ""] ) !!}    
            @showErrors('description')
        </div>
        
        <?php
        
        $price = old('price');
        if (isset($product)) {
            $price = $product->price/100;
        }
        
        ?>
        
        <div class="form-group @hasError('price')">
            {!! Form::Label('price', 'Price', ['class' => '']) !!}
            <div class="input-group">
                <span class="input-group-addon">$</span>
                {!! Form::text('price', $price, ['class' => 'form-control', 'placeholder' => '$'] ) !!}    
            </div>
            @showErrors('price')
        </div>
        
    </div>
    
</div>