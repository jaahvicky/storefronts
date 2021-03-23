<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">1</span>
            <div class='stepper-header'>
                <h3 class='box-title required'>Store</h3>
                <p>Select the store you want to shop in.</p>
            </div>
        </div>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('store')">
            {!! Form::Label('store', 'Store', []) !!}
            <select id="store" class="form-control" name="store">
                <option value='' data-store-id='-1'>Select a store</option>
                <?php
                foreach($stores As $store) {
                    if(isset($cur_order)){
                        if($store->store_id == $cur_order->store_id){
                            echo "<option value='$store->store_id' selected>$store->name</option>";
                        } else {
                            echo "<option value='$store->store_id'>$store->name</option>";
                        }
                    } else {
                        echo "<option value='$store->store_id'>$store->name</option>";
                    }
                    
                    
                }
                
                ?>
            </select>
            @showErrors('order')
        </div>
        
    </div>
</div>