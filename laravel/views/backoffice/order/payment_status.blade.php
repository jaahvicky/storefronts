<div class='box box-primary @if( !isset($order_id) ) buyer-details @endif'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">8</span>
            <div class='stepper-header'>
                <h3 class='box-title required'>Payment Status</h3>
                <p>Select Payment Status.</p>
            </div>
        </div>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('payment_status_id')">
            {!! Form::Label('payment_status_id', 'Payment Status', []) !!}
            <select id="payment_status_id" class="form-control" name="payment_status_id">
                <option value='' data-currency-id='-1'>Select the payment status</option>
                <?php
                foreach($payment_statuses As $status) {
                    if($status->id == $cur_order->payment_status_id){
                        echo "<option value='$status->id' selected>$status->status</option>";
                    } else {
                        echo "<option value='$status->id'>$status->status</option>";
                    }
                }
                
                ?>
            </select>
            @showErrors('payment_status_id')
        </div>
        
    </div>
</div>