<div class='box box-primary @if( !isset($order_id) ) buyer-details @endif'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">10</span>
            <div class='stepper-header'>
                <h3 class='box-title required'>Payment Method</h3>
                <p>Select Payment Method.</p>
            </div>
        </div>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('payment_method_id')">
            {!! Form::Label('delivery_status_id', 'Delivery Status', []) !!}
            <select id="payment_method_id" class="form-control" name="payment_method_id">
                <option value='' data-currency-id='-1'>Select the delivery status</option>
                <?php
                foreach($payment_methods As $method) {
                    if($method->id == $cur_order->payment_method_id){
                        echo "<option value='$method->id' selected>$method->method</option>";
                    } else {
                        echo "<option value='$method->id'>$method->method</option>";
                    }
                }
                
                ?>
            </select>
            @showErrors('payment_method_id')
        </div>
        
    </div>
</div>