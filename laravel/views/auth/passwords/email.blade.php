@extends('backoffice/layout/adminlte-auth')

@section('content')
<div class="login-box">
	<div class="login-logo">
		<a href="{{ URL::route('admin.login')}}"><b>Ownai</b> Storefronts</a>
	</div><!-- /.login-logo -->
	<div class="login-box-body">
		<p style="font-weight: bold;">Forgot Password?</p>
		<p>Please enter your email address and you will be sent instructions on how to access your account.</p>
		@if (Session::has('status'))
		<div class="alert alert-success">
			{{ Session::get('status') }}
		</div>
		@endif
		
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		<form action="{{ URL::route('admin.password.email.send') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group has-feedback">
				<input name="email" type="email" class="form-control" placeholder="Email" value='{{ old('email') }}'/>
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<a href="{{ URL::route('admin.login')}}">Cancel</a><br>
				</div><!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Reset</button>
				</div><!-- /.col -->
			</div>
		</form>



	</div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@stop
