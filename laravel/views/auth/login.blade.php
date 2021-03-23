@extends('backoffice/layout/adminlte-auth')

@section('content')
<div class="login-box">
	<div class="login-logo">
            <a href="{{ URL::route('admin.login')}}"><b>Ownai</b> Storefronts</a>
	</div><!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Sign in to start your session</p>
		@if (count($errors) > 0)
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif
		<form action="{{ URL::route('admin.login.post') }}" method="post">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<div class="form-group has-feedback">
				<input name="username" type="text" class="form-control" placeholder="Username" value='{{ old('username') }}'/>
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input name="password" type="password" class="form-control" placeholder="Password" />
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<div class="col-xs-8">
					<div class="checkbox icheck">
						<label>
							<input type="checkbox" name="remember"> Remember Me
						</label>
					</div>
				</div><!-- /.col -->
				<div class="col-xs-4">
					<button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
				</div><!-- /.col -->
			</div>
		</form>

		<a href="{{ URL::route('admin.password.email')}}">I forgot my password</a><br>

	</div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection
