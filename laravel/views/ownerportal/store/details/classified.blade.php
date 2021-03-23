<!-- contact person details -->
<section id="sp-store-details" role="store details">
    <h2 class="sp-title text-center">Ownai Classified Account Details</h2>
    <div class="row">
    <div class="col-sm-8 col-sm-offset-2">

        <small class="text-center">We will link your existing Ownai account to your store profile, or we will create a new account for you.</small>
        
        <div class="row">
        <input type="hidden" name="ownai_account" id="ownai_account" value="{{ ((isset($storeDetail) && empty(old('ownai_account')) ) ? $storeDetail->ownai_account : old('ownai_account'))}}">
        <input type="hidden" name="account_verifd" id="account_verifd" value="{{ ((isset($storeDetail) && empty(old('account_verifd')) ) ? $storeDetail->account_verifd : old('account_verifd'))}}">
            <div class="form-group col-sm-6 text-center @hasError('ownai_account')">
                <div class="radio">
                    <label>
                        {{ Form::radio('account_ownai', 'account_available', false, ['id'=>'account_available']) }}
                        I have an existing Ownai Classifieds account 
                    </label>
                </div>
            </div>		
            <div class="form-group col-sm-6 text-center @hasError('ownai_account')">
                <div class="radio">
                    <label>
                        {{ Form::radio('account_ownai', 'account_notavailable', false, ['id'=>'account_notavailable']) }}
                        I don't have an Ownai Classifieds account yet
                    </label>
                </div>
            </div>

        </div>
        <div class="form-group text-center @hasError('ownai_account')">
             
             @if (count($errors) > 0 && !empty($errors->get('ownai_account')))
               <span class='help-block' style="font-size: 11pt;">Please select one option above</span>
            @endif
        </div>
        <div class="alert alert-danger alert-dismissible non-selector errordiv" style="margin: auto 20px; display: none"></div>
        <div class="alert alert-success alert-dismissible non-selector successdiv" style="margin: auto 20px; display: none">Verified</div>
        <span id="section-ownaiexist">
            
            <div class="form-group @hasError('username_ownai')">
                
                <label for="name">Username <span class="accent-orange bold-text">*</span></label>
                <small>Enter the same Econet mobile number you use when accessing your Ownai account</small>
                <div class="input-group">
                    <span class="input-group-addon" id="basic-addon3">+263</span>
                    <input type="text" class="form-control" id="username_ownai" name="username_ownai" placeholder="cellphone" value="{{ ((isset($storeDetail) && empty(old('username_ownai')) ) ? $storeDetail->username_ownai : old('username_ownai'))}}">
                </div>
                @showErrors('username_ownai')
            </div>					
            <div class="form-group @hasError('password_ownai')">

                <label for="number">Password <span class="accent-orange bold-text">*</span></label>
                <small>Enter your Ownai account password</small>
               
                <input type="password"  class="form-control" name="password_ownai" id="password_ownai" value="{{ ((isset($storeDetail) && empty(old('password_ownai')) ) ? $storeDetail->password_ownai : old('password_ownai'))}}">
                
               
                @showErrors('password_ownai')
                
            </div>
            <div class="form-group">
                <div class="signup-btn-group">
                    <div class="">
                        <button  class="btn btn-primary pull-left" id="validate_btn">confirm </button>
                    </div>
                    <div class="pull-left">
                         <a class="btn btn-link" href="{{ LookupHelper::generateRecoverLink() }}" target="_blank">Recover Password</a>
                    </div>
                    <div class="pull-left">
                        <a class="btn btn-link" href="{{ LookupHelper::generateActivateLink() }}" target="_blank">Activate Account</a>
                    </div>
                
                </div>
                
               
                
            </div>  
             	
            
        </span>
        
        <span id="section-ownaiNotexist">
            
            <div class="form-group">
                <label for="number">We will create an Ownai account for you using the Store Contact number you provided above. Your password for Ownai will be the same as used on Storefronts.</label>
               
            </div>
            
            
        </span>
        
    </div>
    </div>
</section>
<div class="modal fade" id="load-modal" role="dialog">
  <div class="modal-dialog">
  
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"></button>
        <h4 class="modal-title">Loading ...</h4>
      </div>
      <div class="modal-body">
        <div class="progress">
          <div class="progress-bar progress-bar-primary loading-migrate" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
            <span class="sr-only">40% Complete (success)</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
       
      </div>
    </div>
    
  </div>
</div>
<script type="text/javascript">
    $(function(){

        $('#section-ownaiexist').hide();
        $('#section-ownaiNotexist').hide();
        console.log('loaded');
       
        
        $('#account_notavailable').on('click',()=>{
            $('#section-ownaiexist').hide();
           
            var number = $("#phone").val();
            console.log(number);
            if(isEmpty(number)){
                $('#account_notavailable').attr('checked', false);
                $('#submit_btn').prop('disabled', true);
                $('.errordiv').append('<p>Please Store Contact Number first</p>');
                $("#phone").css('border-color', '#a94442');
                $('.errordiv').show(); //.css('margin-bottom', '20px')
                setTimeout(function(){ $('.errordiv').hide().html(''); $("#phone").css('border-color', '#ccc'); }, 3000);  
            }else{
                validate(number);
                
            }
            
        });
        function validate(cell){
            var formData = {
            username:cell,
            
            _token: $("input[name*='_token']").val(),

            };
            $.ajax({
              url: "details/number",
              data: formData,
              method: "POST",
              
            }).done(function( data ) {
                console.log(data);
                switch(data.success){
                    case 1:
                            $('#section-ownaiNotexist').show();
                            $('#submit_btn').prop('disabled', false);
                            $('#ownai_account').val('account_notavailable');
                        break;
                    case 2:
                            $("#username_ownai").val(cell);
                            $('#section-ownaiNotexist').hide();
                            $('#section-ownaiexist').show();
                            $('#submit_btn').prop('disabled', true);
                            $('#account_notavailable').attr('checked', false);
                            $('#account_available').prop('checked', true);
                            $('#ownai_account').val('account_available');
                            $('.errordiv').append('<p>'+data.message+'</p>');
                            $('.errordiv').show();
                            setTimeout(function(){ $('.errordiv').hide().html('');}, 3000);    
                        break;

                    case 3:
                            $('#account_notavailable').attr('checked', false);
                            $('#submit_btn').prop('disabled', true);
                            $('.errordiv').append('<p>Please Store Contact Number first</p>');
                            $("#phone").css('border-color', '#a94442');
                            $('.errordiv').show(); //.css('margin-bottom', '20px')
                            setTimeout(function(){ $('.errordiv').hide().html(''); $("#phone").css('border-color', '#ccc'); }, 3000);  
                        break;
                    default:
                        break
                }
               
            });
        }
        $('#account_available').on('click',()=>{
            $('#section-ownaiNotexist').hide();
            $('#section-ownaiexist').show();
            $('#submit_btn').prop('disabled', true);
             $('#ownai_account').val('account_available');
            
        })
        var input = $('#ownai_account').val();
        if(input == 'account_notavailable'){
            $('#section-ownaiNotexist').show();
        }else if(input =='account_available'){
            $('#section-ownaiexist').show();
            $('#submit_btn').prop('disabled', true);
            if($('#account_verifd').val() == 'verified'){
                $("input#username_ownai").attr('readonly',true);
                $("input#password_ownai").attr('readonly',true);
                $('#submit_btn').prop('disabled', false);
            }
        }else{

        }

        function isEmpty(value) {
        return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
        }

        $('#validate_btn').on('click', (e)=>{
            e.preventDefault();
            var formData = {
            username:$('#username_ownai').val(),
            password:$('#password_ownai').val(),
            _token: $("input[name*='_token']").val(),

            };

            $('#load-modal').modal('show');
            $('.loading-migrate').animate({ width: '90%' }, 'slow');
            

            $.ajax({
              url: "details/validate",
              data: formData,
              method: "POST",
              
            }).done(function( data ) {
                  //console.log(data);
                if(data.success){
                    $("input#username_ownai").attr('readonly',true);
                    $("input#password_ownai").attr('readonly',true);
                    $('#submit_btn').prop('disabled', false);
                    $("#account_verifd").val('Verified');
                    $("input[name='phone']").attr('readonly',true);
                    $("input[name='phone']").val($("input#username_ownai").val());
                    $('.successdiv').show();
                    if(data.data.s_email_address !=''){
                         $("input[name='email']").attr('readonly',true);
                         $("input[name='email']").val(data.data.s_email_address);
                    }
                    setTimeout(function(){ $('.successdiv').hide(); }, 3000);   
                }else{
                    var error = data.message;
                    $.each(data.message, (index, value)=>{
                            console.log(index, value);
                        $('.errordiv').append('<p>'+value+'</p>');
                    })
                    $('.errordiv').show();
                     setTimeout(function(){ $('.errordiv').hide().html(''); }, 3000);   
                }
                $('#load-modal').modal('hide');
                
            });
        })
    });
</script>