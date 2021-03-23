<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Store Status</h3>
    </div>   
 	<div class='box-body'>
 		<div class="form-group">
	    	<label>{{ (($status == 'approved')? 'OPEN' : 'Pending') }}</label>
	    </div>
 		{!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.billing.store']) !!}
    	{!! Form::hidden('account_status', 
                (($status == 'approved')? '2' : '3'),
                ['class' => 'form-control', 'id'=>'account_status'] ) !!}
    	{!! Form::hidden('store_id', $store->id,['class' => 'form-control', 'id'=>'store_id'] ) !!} 
 	    <div class="form-group ">

        {!! Form::submit((($status == 'approved')? 'CLOSE STORE' : 'RE-OPEN STORE'), ['class' => (($status == 'approved')? 'btn pull-left btn-danger' : 'btn pull-left btn-primary') , 'id' => 'saveButton']) !!}
        </div>
        {!! Form::close() !!}
    </div> 
</div>