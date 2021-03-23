@extends('backoffice/layout/adminlte-auth')

@section('content')
<div class="login-box">
	<div class="login-logo">
		<a href="{{ URL::route('admin.login')}}"><b>Ownai</b> Storefronts</a>
	</div><!-- /.login-logo -->
	<div class="login-box-body">
		<p style="font-weight: bold;">Set Up Your Password</p>
		<p>Please enter your unique password to access the Ownai Storefronts back-end.</p>
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
		<form action="{{ URL::route('admin.password.forgot') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="token" value="{{ $token }}">
			<input type="hidden" name="email" value="{{ $email }}">

			<div class="form-group has-feedback">
				<input name="password" type="password" class="form-control" placeholder="Password" />
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input name="password_confirmation" type="password" class="form-control" placeholder="Password Confirmation" />
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<a href="{{ URL::route('admin.login')}}">Cancel</a><br>
				</div><!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Confirm</button>
				</div><!-- /.col -->
			</div>
		</form>
	</div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@stop