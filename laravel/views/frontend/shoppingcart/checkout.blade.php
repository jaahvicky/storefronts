@extends('frontend/layout/default')

@section('content')

{{--main header with search input--}}
@include('frontend.layout.header')
        <!-- breadcrumbs -->
{{--@include('frontend.product.product-header-crumbs')--}}
        <!-- Main content -->
<section class="container product-container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p class="lead">Contact Information</p>
                    <p>Testing</p>
                    <hr>
                    {!! Form::open() !!}
                    <div class="form-group">
                        {!! Form::label('firstname', 'Name*', ['class' => 'control-label']) !!}
                        {!! Form::text('firstname', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('lastname', 'Surname*', ['class' => 'control-label']) !!}
                        {!! Form::text('lastname', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('contact_number', 'Econet Cellphone Number *', ['class' => 'control-label']) !!}
                        {!! Form::text('contact_number', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('email', 'Email Address:', ['class' => 'control-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('home_address', 'Home Address:', ['class' => 'control-label']) !!}
                        {!! Form::text('home_address', null, ['class' => 'form-control']) !!}
                    </div>
                    <div id="map"></div>
                    {!! Form::submit('Continue', ['class' => 'btn btn-primary']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
{{--store footer--}}
@include('frontend.layout.store-footer')

{{--website footer--}}
@include('frontend.layout.footer')

@stop
