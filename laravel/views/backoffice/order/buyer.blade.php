<div class='box box-primary @if( !isset($order_id) ) buyer-details @endif'>
    
    <div class='box-header with-border'>
        <div class='stepper-container'>
            <span class="stepper-circle left">5</span>
            <div class='stepper-header'>
                <h3 class='box-title'>Buyer Details</h3>
                <p>Please complete the user details below. </p>
            </div>
        </div>
    </div>
    
    <div class='box-body'>
        <div class="form-group ">
            <label for="buyer_firstname" class="required">First Name</label>
            <input class="form-control" placeholder="Buyer Last Name" name="buyer_firstname" type="text" 
            value="@if(isset($cur_order)){{ $cur_order->buyer_firstname }}@endif" id="buyer_firstname">    
        </div>
        <div class="form-group ">
            <label for="buyer_lastname" class="required">Last Name</label>
            <input class="form-control" placeholder="Buyer Last Name" name="buyer_lastname" type="text" 
            value="@if(isset($cur_order)){{ $cur_order->buyer_lastname }}@endif" id="buyer_lastname">    
        </div>
        <div class="form-group ">
            <label for="buyer_address_line_1" class="required">Buyer Address Line 1</label>
            <textarea class="form-control" placeholder="Buyer Address Line 1" name="buyer_address_line_1" cols="50" rows="10" id="buyer_address_line_1">@if(isset($cur_order)){{ $cur_order->buyer_address_line_1 }}@endif
            </textarea>    
        </div>
        <div class="form-group ">
            <label for="buyer_address_line_2" class="required">Buyer Address Line 2</label>
            <textarea class="form-control" placeholder="Buyer Address Line 2" name="buyer_address_line_2" cols="50" rows="10" id="buyer_address_line_2">@if(isset($cur_order)){{ $cur_order->buyer_address_line_2 }}@endif
            </textarea>    
        </div>
        <div class="form-group ">
            <label for="buyer_suburb" class="required">Buyer Surburb</label>
            <input class="form-control" placeholder="Buyer Surburb Name" name="buyer_suburb" type="text" 
            value="@if(isset($cur_order)){{ $cur_order->buyer_suburb }}@endif" id="buyer_suburb">    
        </div>
        <div class="form-group ">
            <label for="buyer_city" class="required">Buyer City</label>
            <input class="form-control" placeholder="Buyer City" name="buyer_city" type="text" 
            value="@if(isset($cur_order)){{ $cur_order->buyer_city }}@endif" id="buyer_city">    
        </div>
        <!-- <div class="form-group ">
            <label for="buyer_country" class="required">Buyer Country</label>
            <input class="form-control" placeholder="Buyer Country" name="buyer_country" type="text" 
            value="@if(isset($cur_order)){{ $cur_order->buyer_city }}@endif" id="buyer_country">    
        </div> -->
        <div class="form-group @hasError('buyer_country')">
            {!! Form::Label('buyer_country', 'Buyer Country', []) !!}
            <select id="buyer_country" class="form-control" name="buyer_country">
                <option value='' data-store-id='-1'>Select a Country</option>
                <?php
                foreach($countries As $key => $value) {
                    if(isset($cur_order)){
                        if($key == $cur_order->buyer_country){
                            echo "<option value='$key' selected>$value</option>";
                        } else {
                            echo "<option value='$key'>$value</option>";
                        }
                    } else {
                        echo "<option value='$key'>$value</option>";
                    }
                    
                }
                
                ?>
            </select>
            @showErrors('buyer_country')
        </div>
        <div class="form-group ">
            <label for="buyer_province_state" class="required">Buyer Province/State</label>
            <input class="form-control" placeholder="Buyer Province/State" name="buyer_province_state" type="text" 
            value="@if(isset($cur_order)){{ $cur_order->buyer_province_state }}@endif" id="buyer_province_state">    
        </div>
        <div class="form-group ">
            <label for="buyer_postal_code" class="required">Buyer Postal Code</label>
            <input class="form-control" placeholder="Buyer Postal Code" name="buyer_postal_code" type="text" 
            value="@if(isset($cur_order)){{ $cur_order->buyer_postal_code }}@endif" id="buyer_postal_code">    
        </div>
        <div class="form-group ">
            <label for="buyer_email" class="required">Buyer Email</label>
            <input class="form-control" placeholder="Buyer Email Address" name="buyer_email" type="text" 
            value="@if(isset($cur_order)){{ $cur_order->buyer_email }}@endif" id="buyer_email">    
        </div>
        @if(isset($cur_order))
        <div class="form-group ">
            <label for="buyer_phone" class="required">Buyer Phone</label>
            <input class="form-control" placeholder="Buyer Phone Number" name="buyer_phone" type="text" 
            value="@if(isset($cur_order)){{ $cur_order->buyer_phone }}@endif" id="buyer_phone">    
        </div>
        @else
        <div class="form-group ">
            <label for="buyer_code" class="required">Buyer Country Dial Code</label>
            <select id="buyer_code" class="form-control" name="buyer_code">
                <?php
                foreach($country_codes As $code) {
                    $name = $code['name'];
                    $coder = $code['code'];
                    echo "<option value='$coder'>$name(+$coder)</option>";
                }
                ?>
            </select>   
        </div>
        <div class="form-group ">
            <label for="buyer_phone" class="required">Buyer Phone Number(No Dial Code)</label>    
            <input type="text" class="form-control" id="buyer_phone" name="buyer_phone" placeholder="phone number">
            
        </div>
        @endif
        <div class="form-group ">
            <label for="order_notes" class="">Order Notes</label>
            <textarea class="form-control" placeholder="Order Notes" name="order_notes" cols="50" rows="10" id="order_notes">@if(isset($cur_order)){{ $cur_order->order_notes }}@endif
            </textarea>    
        </div>
        
        <?php
        
        $price = old('price');
        if (isset($product)) {
            $price = $product->price/100;
        }
        
        ?>
        
       <!--  <div class="form-group @hasError('price')">
            {!! Form::Label('price', 'Price', ['class' => '']) !!}
            <div class="input-group">
                <span class="input-group-addon">$</span>
                {!! Form::text('price', $price, ['class' => 'form-control', 'placeholder' => '$'] ) !!}    
            </div>
            @showErrors('price')
        </div> -->
        
    </div>
    
</div>