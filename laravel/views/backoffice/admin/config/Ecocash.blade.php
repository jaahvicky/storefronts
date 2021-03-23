@extends('backoffice/layout/default')

@section('content')
    @css('/css/backoffice.css')
<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>EcoCash  Settings</h3>
    </div>
   
   
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.config.ecocash.update']) !!}
    {!! Form::hidden('id', 
                \ViewHelper::showValue(old('id'), (!empty($config)) ? $config : null, 'id'),
                ['class' => 'form-control', 'id'=>'id'] ) !!}
    <div class='box-body'>
        <div class="form-group @hasError('ecocash_endpoint')">
            {!! Form::Label('ecocash_endpoint', 'EcoCash End Point', ['class' => '  ', 'id'=> 'ecocash_endpoint']) !!}
            {!! Form::text('ecocash_endpoint', 
                \ViewHelper::showValue(old('ecocash_endpoint'), (!empty($config)) ? $config : null, 'ecocash_endpoint'),
                ['class' => 'form-control', 'id'=>'ecocash_endpoint'] ) !!}    
            @showErrors('ecocash_endpoint')
        </div> 
        <div class="form-group @hasError('ecocash_endpoint_query')">
            {!! Form::Label('ecocash_endpoint_query', 'EcoCash End Point Query name', ['class' => '  ', 'id'=> 'ecocash_endpoint_query']) !!}
            {!! Form::text('ecocash_endpoint_query', 
                \ViewHelper::showValue(old('ecocash_endpoint_query'), (!empty($config)) ? $config : null, 'ecocash_endpoint_query'),
                ['class' => 'form-control', 'id'=>'ecocash_endpoint_query'] ) !!}    
            @showErrors('ecocash_endpoint_query')
        </div> 
        <div class="form-group @hasError('ecocash_endpoint_query_user')">
            {!! Form::Label('ecocash_endpoint_query_user', 'EcoCash End Point Query User', ['class' => '  ', 'id'=> 'ecocash_endpoint_query_user']) !!}
            {!! Form::text('ecocash_endpoint_query_user', 
                \ViewHelper::showValue(old('ecocash_endpoint_query_user'), (!empty($config)) ? $config : null, 'ecocash_endpoint_query_user'),
                ['class' => 'form-control', 'id'=>'ecocash_endpoint_query_user'] ) !!}    
            @showErrors('ecocash_endpoint_query_user')
        </div> 
        <div class="form-group @hasError('ecocash_channel')">
            {!! Form::Label('ecocash_channel', 'EcoCash Channel', ['class' => '  ', 'id'=> 'ecocash_channel']) !!}
            {!! Form::text('ecocash_channel', 
                \ViewHelper::showValue(old('ecocash_channel'), (!empty($config)) ? $config : null, 'ecocash_channel'),
                ['class' => 'form-control', 'id'=>'ecocash_channel'] ) !!}    
            @showErrors('ecocash_channel')
        </div> 
        <div class="form-group @hasError('ecocash_merchant_code')">
            {!! Form::Label('ecocash_merchant_code', 'EcoCash Merchant Code', ['class' => '  ', 'id'=> 'ecocash_merchant_code']) !!}
            {!! Form::number('ecocash_merchant_code', 
                \ViewHelper::showValue(old('ecocash_merchant_code'), (!empty($config)) ? $config : null, 'ecocash_merchant_code'),
                ['class' => 'form-control', 'id'=>'ecocash_merchant_code'] ) !!}    
            @showErrors('ecocash_merchant_code')
        </div> 
        <div class="form-group @hasError('ecocash_merchant_pin')">
            {!! Form::Label('ecocash_merchant_pin', 'EcoCash Merchant Pin', ['class' => '  ', 'id'=> 'ecocash_merchant_pin']) !!}
            {!! Form::number('ecocash_merchant_pin', 
                \ViewHelper::showValue(old('ecocash_merchant_pin'), (!empty($config)) ? $config : null, 'ecocash_merchant_pin'),
                ['class' => 'form-control', 'id'=>'ecocash_merchant_pin'] ) !!}    
            @showErrors('ecocash_merchant_pin')
        </div> 
        <div class="form-group @hasError('ecocash_merchant_number')">
            {!! Form::Label('ecocash_merchant_number', 'EcoCash Merchant Number', ['class' => '  ', 'id'=> 'ecocash_merchant_number']) !!}
            {!! Form::number('ecocash_merchant_number', 
                \ViewHelper::showValue(old('ecocash_merchant_number'), (!empty($config)) ? $config : null, 'ecocash_merchant_number'),
                ['class' => 'form-control', 'id'=>'ecocash_merchant_number'] ) !!}    
            @showErrors('ecocash_merchant_number')
        </div> 
        <div class="form-group @hasError('ecocash_username')">
            {!! Form::Label('ecocash_username', 'EcoCash Username', ['class' => '  ', 'id'=> 'ecocash_name']) !!}
            {!! Form::text('ecocash_username', 
                \ViewHelper::showValue(old('ecocash_username'), (!empty($config)) ? $config : null, 'ecocash_username'),
                ['class' => 'form-control', 'id'=>'ecocash_username'] ) !!}    
            @showErrors('ecocash_username')
        </div> 
        <div class="form-group @hasError('ecocash_password')">
            {!! Form::Label('ecocash_password', 'EcoCash Password', ['class' => '  ', 'id'=> 'ecocash_name']) !!}
            {!! Form::text('ecocash_password', 
                \ViewHelper::showValue(old('ecocash_password'), (!empty($config)) ? $config : null, 'ecocash_password'),
                ['class' => 'form-control', 'id'=>'ecocash_password'] ) !!}    
            @showErrors('ecocash_password')
        </div> 
       
        <div class="form-group ">
        {!! Form::submit('Update', ['class' => 'btn btn-primary pull-left', 'id' => 'saveButton']) !!}
        </div>
    </div> 
    {!! Form::close() !!}
    
</div>
@stop
