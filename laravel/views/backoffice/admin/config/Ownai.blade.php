@extends('backoffice/layout/default')

@section('content')
    @css('/css/backoffice.css')
<div class='box box-primary'>
    
    <div class='box-header with-border'>
        <h3 class='box-title'>Ownai  Settings</h3>
    </div>
   
   
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'admin.config.ownai.update']) !!}
    {!! Form::hidden('id', 
                \ViewHelper::showValue(old('id'), (!empty($ownai)) ? $ownai : null, 'id'),
                ['class' => 'form-control', 'id'=>'id'] ) !!}
    <div class='box-body'>
        <div class="form-group @hasError('url')">
            {!! Form::Label('url', 'URL', ['class' => '  ', 'id'=> 'url']) !!}
            {!! Form::text('url', 
                \ViewHelper::showValue(old('url'), (!empty($ownai)) ? $ownai : null, 'url'),
                ['class' => 'form-control', 'id'=>'url'] ) !!}    
            @showErrors('url')
        </div>       
       
        <div class="form-group ">
        {!! Form::submit('Update', ['class' => 'btn btn-primary pull-left', 'id' => 'saveButton']) !!}
        </div>
    </div> 
    {!! Form::close() !!}
    
</div>
@stop
