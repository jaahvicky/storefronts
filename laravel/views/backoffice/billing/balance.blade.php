<div class='box box-primary'>
<?php $balance = LookupHelper::checkStoreBalance($store); ?>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>My Balance</h3>
    </div>
    
    
    
    <div class='box-body'> 
        <div class="form-group">
            <label class="text"> ${{ (($balance->status)? $balance->amount : '0')}}.00</label>
        </div>
        <div class="form-group">
            <label for="">{{ $balance->message}}</label>
        </div>
        
        <div class="form-group">
            @if($balance->status)
                 <a class="btn btn-primary pull-left" href="{{ URL::route('admin.billing.modal') }}" data-modal='true'> PAY NOW </a>
            @endif
            <a href="{{ URL::route('admin.billing.invoice')}}" class="btn btn-primary pull-left" style="margin-left: 10px;"> INVOICE LIST</a>
        </div>
       
    </div>   
</div>


