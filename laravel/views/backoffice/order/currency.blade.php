<div class='box box-primary @if( !isset($order_id) ) buyer-details @endif'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">6</span>
            <div class='stepper-header'>
                <h3 class='box-title required'>Currency</h3>
                <p>Select buyer's currency.</p>
            </div>
        </div>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('currency')">
            {!! Form::Label('currency', 'Currency', []) !!}
            <select id="currency" class="form-control" name="currency">
                
                <option value='' data-currency-id='-1'>Select a currency</option>
                <?php
                foreach($currencies As $key => $value) {
                    if(isset($cur_order)){
                        if($key == $cur_order->currency){
                            echo "<option value='$key' selected>$key</option>";
                        } else {
                            echo "<option value='$key'>$key</option>";
                        }
                    } else {
                        echo "<option value='$key'>$key</option>";
                    }
                    
                }
                
                ?>
            </select>
            @showErrors('currency')
        </div>
        
    </div>
</div>