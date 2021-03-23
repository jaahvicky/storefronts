<!-- backoffice details -->
<section id="sp-backoffice-login" role="backoffice login credentials">
    <h2 class="text-center">Backoffice Login Details</h2>

    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">					  	
                
            <div class="form-group @hasError('username')">
                <label for="username">Store Username <span class="accent-orange bold-text">*</span></label>
                <small>Please enter the username you would like to use to access your store</small>
                {!! Form::text('username', 
                    (isset($user) && empty(old('username')) ) ? $user->username : old('username'),
                    ['class' => 'form-control', 'placeholder' => 'Username'] ) !!}    
                @showErrors('username')
            </div>
                      

            <div class="row">
                <div class="form-group col-sm-6 change-password-form @hasError('password')">
                    {!! Form::Label('password', 'Password', ['class' => '']) !!}
                    {!! Form::password('password',  ['class' => 'form-control', 'placeholder' => 'Password' ] ) !!}    
                    @showErrors('password')
                </div>

                <div class="form-group col-sm-6 change-password-form @hasError('password_confirm')">
                    {!! Form::Label('password_confirm', 'Confirm Password', ['class' => '']) !!}
                    {!! Form::password('password_confirm', ['class' => 'form-control', 'placeholder' => 'Password Again'] ) !!} 
                    @showErrors('password_confirm')
                </div>
            </div>
        </div>
    </div>
</section>	
<!-- backoffice details end -->