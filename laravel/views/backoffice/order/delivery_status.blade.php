<div class='box box-primary @if( !isset($order_id) ) buyer-details @endif'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">9</span>
            <div class='stepper-header'>
                <h3 class='box-title required'>Delivery Status</h3>
                <p>Select Delivery Status.</p>
            </div>
        </div>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('delivery_status_id')">
            {!! Form::Label('delivery_status_id', 'Delivery Status', []) !!}
            <select id="delivery_status_id" class="form-control" name="delivery_status_id">
                <option value='' data-currency-id='-1'>Select the delivery status</option>
                <?php
                foreach($delivery_statuses As $status) {
                    if($status->id == $cur_order->delivery_status_id){
                        echo "<option value='$status->id' selected>$status->status</option>";
                    } else {
                        echo "<option value='$status->id'>$status->status</option>";
                    }
                }
                
                ?>
            </select>
            @showErrors('delivery_status_id')
        </div>
        
    </div>
</div>