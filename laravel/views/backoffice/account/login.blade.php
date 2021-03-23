<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Back-office Login</h3>
    </div>
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.user.update']) !!}
    
    <div class='box-body'>
    
        <div class="form-group">
            {!! Form::Label('username', 'Username', ['class' => '']) !!}
            {!! Form::text('username', Auth::user()->username, ['class' => 'form-control', 'readonly' => 'true'] ) !!}  
        </div>
        
        <div class='box-footer'>
            
            <div class="form-group" id='change-password-hidden'>
                {!! Form::button('Change Password', ['class' => 'btn btn-primary btn-flat', 'id' => 'change-password-button', 'onclick' => 'togglePasswordDisplay()']) !!}
            </div>
            
            <div class="form-group change-password-form @hasError('password')">
                {!! Form::Label('password', 'Current Password', ['class' => '']) !!}
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Current Password' ] ) !!}    
                @showErrors('password')
            </div>

            <div class="form-group change-password-form @hasError('new_password')">
                {!! Form::Label('new_password', 'New Password', ['class' => '']) !!}
                {!! Form::password('new_password',  ['class' => 'form-control', 'placeholder' => 'Password', 'value' => old('new_password') ] ) !!}    
                @showErrors('new_password')
            </div>
            
            <div class="form-group change-password-form @hasError('new_password_confirm')">
                {!! Form::Label('new_password_confirm', 'Confirm New Password', ['class' => '']) !!}
                {!! Form::password('new_password_confirm', ['class' => 'form-control', 'placeholder' => 'Password Again'] ) !!} 
                @showErrors('new_password_confirm')
            </div>

            <div class='change-password-form'>
                {!! Form::button('Cancel', ['class' => 'btn btn-inverse btn-flat', 'id' => 'change-password-cancel', 'onclick' => 'togglePasswordDisplay()']) !!}
                {!! Form::submit('Save', ['class' => 'btn btn-primary btn-flat']) !!}
            </div>
            
        </div>
    </div>
    
    {!! Form::close() !!}
    
</div>

<script type="text/javascript">
    
    $(function() {
    
        $(".change-password-form").each(function() {
            <?php if (!isset($errors) || (empty($errors->get('new_password')) && empty($errors->get('new_password_confirm')) && empty($errors->get("password"))) ): ?>
                $(this).css('display', 'none'); 
            <?php else: ?>
                $("#change-password-hidden").css('display', 'none');    
            <?php endif; ?>
        });
        
    });
    
</script>