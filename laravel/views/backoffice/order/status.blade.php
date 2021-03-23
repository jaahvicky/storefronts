<div class='box box-primary @if( !isset($order_id) ) buyer-details @endif'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">7</span>
            <div class='stepper-header'>
                <h3 class='box-title required'>Order Status</h3>
                <p>Select buyer's currency.</p>
            </div>
        </div>
    </div>
        
    <div class='box-body'>
        
        <div class="form-group @hasError('order_status_id')">
            {!! Form::Label('order_status_id', 'Status', []) !!}
            <select id="order_status_id" class="form-control" name="order_status_id">
                <option value='' data-currency-id='-1'>Select the order status</option>
                <?php
                foreach($order_status As $status) {
                    if($status->id == $cur_order->order_status_id){
                        echo "<option value='$status->id' selected>$status->status</option>";
                    } else {
                        echo "<option value='$status->id'>$status->status</option>";
                    }
                }
                
                ?>
            </select>
            @showErrors('order_status_id')
        </div>
        
    </div>
</div>