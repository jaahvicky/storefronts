@extends('backoffice/layout/default')

@section('content')
    @css('/css/backoffice.css')
<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Ownai Logistics Booking Service  Settings</h3>
    </div>
   
   
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.config.logistics.bookservice.update']) !!}
    {!! Form::hidden('id', 
                \ViewHelper::showValue(old('id'), (!empty($bookservice)) ? $bookservice : null, 'id'),
                ['class' => 'form-control', 'id'=>'id'] ) !!}
    {!! Form::hidden('method', 
                \ViewHelper::showValue(old('method'), (!empty($bookservice)) ? $bookservice : 'bookservice', 'method'),
                ['class' => 'form-control'] ) !!}
    <div class='box-body'>
        <div class="form-group @hasError('bookservice_url')">
            {!! Form::Label('url', 'URL', ['class' => '  ', 'id'=> 'url']) !!}
            {!! Form::text('bookservice_url', 
                \ViewHelper::showValue(old('bookservice_url'), (!empty($bookservice)) ? $bookservice : null, 'url'),
                ['class' => 'form-control', 'id'=>'url'] ) !!}    
            @showErrors('bookservice_url')
        </div> 
         <div class="form-group @hasError('bookservice_token')">
            {!! Form::Label('bookservice_token', 'Token', ['class' => '  ', 'id'=> 'url']) !!}
            {!! Form::text('bookservice_token', 
                \ViewHelper::showValue(old('bookservice_token'), (!empty($bookservice)) ? $bookservice : null, 'token'),
                ['class' => 'form-control', 'id'=>'url'] ) !!}    
            @showErrors('bookservice_token')
        </div>         
       
        <div class="form-group ">
        {!! Form::submit('Update', ['class' => 'btn btn-primary pull-left', 'id' => 'saveButton']) !!}
        </div>
    </div> 
    {!! Form::close() !!}
    
</div>

<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Ownai Logistics Get Quote  Settings</h3>
    </div>
   
   
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.config.logistics.getQuote.update']) !!}
    {!! Form::hidden('id', 
                \ViewHelper::showValue(old('id'), (!empty($getQuote)) ? $getQuote : null, 'id'),
                ['class' => 'form-control', 'id'=>'id'] ) !!}
    {!! Form::hidden('method', 
                \ViewHelper::showValue(old('method'), (!empty($getQuote)) ? $getQuote : 'getQuote', 'method'),
                ['class' => 'form-control'] ) !!}
    <div class='box-body'>
        <div class="form-group @hasError('getQuote_url')">
            {!! Form::Label('getQuote_url', 'URL', ['class' => '  ', 'id'=> 'getQuote_url']) !!}
            {!! Form::text('getQuote_url', 
                \ViewHelper::showValue(old('getQuote_url'), (!empty($getQuote)) ? $getQuote : null, 'url'),
                ['class' => 'form-control', 'id'=>'url'] ) !!}    
            @showErrors('getQuote_url')
        </div> 
        <div class="form-group @hasError('getQuote_token')">
            {!! Form::Label('token', 'Token', ['class' => '  ', 'id'=> 'url']) !!}
            {!! Form::text('getQuote_token', 
                \ViewHelper::showValue(old('getQuote_token'), (!empty($getQuote)) ? $getQuote : null, 'token'),
                ['class' => 'form-control', 'id'=>'url'] ) !!}    
            @showErrors('getQuote_token')
        </div>        
       
        <div class="form-group ">
        {!! Form::submit('Update', ['class' => 'btn btn-primary pull-left', 'id' => 'saveButton']) !!}
        </div>
    </div> 
    {!! Form::close() !!}
    
</div>
@stop
