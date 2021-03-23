<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Notification Preferences</h3>
        <p>When an order is placed, Ownai will notify via the following means</p>
    </div>
    
    <div class='box-body'>
        
        <?php

            if(isset($store->details)){
                $email_enabled = (isset($store->details) && isset($store->details->email) && !empty($store->details->email));
            } else {
               $email_enabled = (isset($store->contactDetails) && isset($store->contactDetails->email) && !empty($store->contactDetails->email)); 
            }
            
            $disabled_msg = "To enable email notifications, please <a href='#email' onclick='setFocused(\"#email\");'>provide an email address</a>";
        ?>
        
        <div class="form-group ">
            {!! Form::checkbox('preference_sms', true, \ViewHelper::showValue(old('preference_sms'), $store->preferences, 'notification_order_sms'), ['id' => 'preference_sms']) !!}
            {!! Form::Label('preference_sms', 'SMS') !!}
        </div>
        
        <div class="form-group">

            {!! Form::checkbox('preference_email', true, \ViewHelper::showValue(old('preference_email'), $store->preferences, 'notification_order_email'), ['checked' => $email_enabled, 'id' => 'preference_email']) !!}    
            {!! Form::Label('preference_email', 'Email') !!}<br/><em id='disabled-message' class='small'>{!! $disabled_msg !!}</em><br/>
            
        </div>
        
    </div>
    
</div>