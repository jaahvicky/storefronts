@if(LookupHelper::checkbalance($store))
    <div class="alert alert-warning">
    <strong>Warning!</strong> this store will be taken offline if your account balance is not settled.
    </div>
@endif
<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>EcoCash  Account</h3>
    </div>
    <div class="row" style="margin-left: 0px; margin-top: 5px;">
    <div class="[ col-xs-12 col-sm-6 ]">
        <div class="[ form-group ]">
           <input type="checkbox" name="subscriber-account" id="subscriber-account" autocomplete="off" />
            <div class="[ btn-group ]">
                <label for="subscriber-account" class="[ s_label btn btn-primary ]">
                    <span class="[ glyphicon glyphicon-ok ]"></span>
                    <span> </span>
                </label>
                <label for="subscriber-account" class="[ btn btn-default active ]">
                    EcoCash Subscriber Account
                </label>
            </div>
        </div>
    </div>
    <div class="[ col-xs-12 col-sm-6 ]">
            <div class="[ form-group ]">
                <input type="checkbox" name="merchant-account" id="merchant-account" autocomplete="off" />
                <div class="[ btn-group ]">
                    <label for="merchant-account" class="[ me_label btn btn-primary ]">
                        <span class="[ glyphicon glyphicon-ok ]"></span>
                        <span> </span>
                    </label>
                    <label for="merchant-account" class="[ btn btn-default active ]">
                        EcoCash Merchant Account
                    </label>
                </div>
            </div>
        </div>
    
    </div>
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.billing.account.add']) !!}
    {!! Form::hidden('account_type', 
                \ViewHelper::showValue(old('account_type'), (!empty($account)) ? $account : null, 'account_type'),
                ['class' => 'form-control', 'id'=>'account_type'] ) !!}
    {!! Form::hidden('store_id', $store->id,['class' => 'form-control', 'id'=>'store_id'] ) !!}    
    <div class='box-body'>
        {{-- <div class="form-group @hasError('merchant_name')">
            {!! Form::Label('merchant_name', 'EcoCash Merchant name', ['class' => '  ', 'id'=> 'ecocash_name']) !!}
            {!! Form::text('merchant_name', 
                \ViewHelper::showValue(old('merchant_name'), (!empty($account)) ? $account : null, 'name'),
                ['class' => 'form-control', 'id'=>'merchant_name'] ) !!}    
            @showErrors('merchant_name')
        </div> --}}
        <div class="form-group form-inline @hasError('merchant_number')">
            {!! Form::Label('merchant_number', 'EcoCash Merchant Number', ['class' => '  ', 'id'=> 'ecocash_number']) !!}
            @addZimCell(['merchant_number', \ViewHelper::showValue(old('merchant_number'), $account, 'number'), 
            ['id' => 'merchant_number', 'data-methys-valid' => 'phone-zim']])
            @showErrors('merchant_number')
        </div>
        <div class="form-group ">
        {!! Form::submit('Update', ['class' => 'btn btn-primary pull-left', 'id' => 'saveButton']) !!}
        </div>
    </div> 
    {!! Form::close() !!}
    
</div>

<script type="text/javascript">
    $(function() {
        var ecocash = {
            //ecocash_name: $('#ecocash_name'),
            ecocash_number: $('#ecocash_number'),
            ecocash_account_type:$('#account_type'),

            subsciber_details:{
                name:'EcoCash Subscriber Name',
                number:'EcoCash Subscriber Number',
                tag:$('#subscriber-account'),
                label_tag: $('.s_label')
            },
            merchant_details:{
                name:'EcoCash Merchant Name',
                number:'EcoCash Merchant Number',
                tag:$('#merchant-account'),
                label_tag: $('.me_label')
            },
            update:function(id){
                if(id == 0){
                    this.ecocash_name.html(this.merchant_details.name);
                    this.ecocash_number.html(this.merchant_details.number);
                    this.subsciber_details.tag.prop('checked', false);
                    this.ecocash_account_type.val(id);
                    this.merchant_details.label_tag.removeClass('btn-primary').addClass('btn-success');
                    this.subsciber_details.label_tag.removeClass('btn-success').addClass('btn-primary');

                 }else{
                   //this.ecocash_name.html(this.subsciber_details.name);
                    this.ecocash_number.html(this.subsciber_details.number);
                    this.merchant_details.tag.prop('checked', false);
                    this.ecocash_account_type.val(id);
                    this.merchant_details.label_tag.removeClass('btn-success').addClass('btn-primary');
                    this.subsciber_details.label_tag.removeClass('btn-primary').addClass('btn-success');
                }
            },
            set_check:function(id){
                if(id == 0){
                    this.merchant_details.tag.prop('checked', true);
                    this.update(id);
                }else{
                    this.subsciber_details.tag.prop('checked', true);
                    this.update(id);
                }
            }
        };
        
       ecocash.set_check($('#account_type').val());
       $(ecocash.merchant_details.tag).click(function(){
            if($(this).is(':checked')){
                ecocash.update(0);
            }else{
                $(this).prop('checked', true);
            }

       });
       $(ecocash.subsciber_details.tag).click(function(){
            if($(this).is(':checked')){
                ecocash.update(1);
            }else{
                $(this).prop('checked', true);
            }
            
       });

    });
</script>