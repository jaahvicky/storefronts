<div class='box box-primary @if( !isset($order_id) ) prod-ele @endif'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">3</span>
            <div class='stepper-header'>
                <h3 class='box-title required'>Product</h3>
                <p>Select the product you want to order.</p>
            </div>
        </div>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('product')">
            {!! Form::Label('product', 'Product', []) !!}
            <select id="product" class="form-control" name="product">
                <option value='' data-product-id='-1' prod-str='prod'>Select a product from your selected category</option>
                <?php
                if(isset($cur_order)){
                    foreach($cur_products As $product) {
                        
                        if($product->id == $cur_order->products_id){
                            echo "<option value='$product->id' class='product-option' selected>$product->title</option>";
                        } else {
                            echo "<option value='$product->id' class='product-option'>$product->title</option>";
                        }
                        
                    }
                } 
                ?>
            </select>
            @showErrors('product')
        </div>
        
    </div>
</div>