<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Back-office Login</h3>
    </div>
    <div class="box-title" style="margin: 20px 20px">
        Access your Ownai classified account by logging in
    </div>
    <div class="alert alert-danger alert-dismissible non-selector error-login" style="margin: auto 20px; display: none">

    </div>
    {!! Form::open(['class' => 'login-form', 'role' => 'form', 'route' => 'store.user.migration']) !!}
    <div class='box-body'>
        <div class="form-group form-inline @hasError('username')">
            {!! Form::Label('username', 'Cellphone Number', []) !!}
            @addZimCell(['username', '', 
            ['id' => 'username', 'data-methys-valid' => 'phone-zim']])
            @showErrors('username')
        </div>
        <div class="form-group">
            {!! Form::Label('password', 'Password', ['class' => '']) !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password','style'=>" width:14%" ] ) !!}    
            @showErrors('password')
        </div>
        
        <div class='box-footer'>
            {!! Form::submit('Submit', ['class' => 'btn btn-primary btn-flat', 'id'=>'submit_btn']) !!}
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