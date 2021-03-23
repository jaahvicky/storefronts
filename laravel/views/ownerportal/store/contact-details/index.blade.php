@extends('ownerportal/layout/default')

@section('stepper')
    @include('ownerportal.layout.stepper')
@stop

@section('content')

    @css('/css/ownerportal.css')
    @js('plugins/methys-javascript/methys.ownai-validator.js')
    @js('/js/ownerportal/store/contact-details.js')
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'store.setup.contact-details.update']) !!}

    @include('ownerportal.store.contact-details.details')
    
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">Continue <i class="material-icons sp-btn-ic">arrow_forward</i></button>
    </div>	
    
    {!! Form::close() !!}
    <br/><br/>

@stop

