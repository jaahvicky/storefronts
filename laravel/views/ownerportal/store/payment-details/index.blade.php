@extends('ownerportal/layout/default')

@section('stepper')
    @include('ownerportal.layout.stepper')
@stop

@section('content')

    @css('/css/ownerportal.css')
    @js('/js/ownerportal/store/payment-details.js')
    
    {!! Form::open(['class' => 'form', 'role' => 'form', 'route' => 'store.setup.payment-details.update', 'id' => 'form-update-payment-details']) !!}

    @include('ownerportal.store.payment-details.details')
   <div class="col-sm-8 col-sm-offset-2">
        <div class="row">
            <div class="col-sm-12 accept-terms @hasError('terms_conditions')">
                <input type="checkbox" class="form-control" id="terms_conditions" name="terms_conditions" required /> 
                <label for="terms_conditions">
                        I accept the <a title="Terms and Conditions" href='{{URL::route('content-page', ['storeslug' => 'ownai', 'pageslug' => 'terms-and-conditions'])}}'>User Agreement</a> and have read the <a title="Privacy" href='{{URL::route('content-page', ['storeslug' => 'ownai', 'pageslug' => 'privacy'])}}'>Privacy Policy</a>
                        .
                </label>
            </div>       
         </div>        
    </div>
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">Register Store <i class="material-icons sp-btn-ic">arrow_forward</i></button>
    </div>	
    
    {!! Form::close() !!}
    <br/><br/>

@stop

