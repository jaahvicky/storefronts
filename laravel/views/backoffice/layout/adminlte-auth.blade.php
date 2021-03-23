<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Ownai Storefronts Login</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

		<!-- favicon -->
		<link rel="shortcut icon" href="{{asset('images/favicon/favicon-48.png')}}">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('images/favicon/favicon-144.png')}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('images/favicon/favicon-114.png')}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('images/favicon/favicon-72.png')}}">
		<link rel="apple-touch-icon-precomposed" href="{{asset('images/favicon/favicon-57.png')}}">
		<link rel="shortcut icon" href="{{asset('images/favicon/favicon.ico')}}">

		@css('plugins/bootstrap/css/bootstrap.min.css')
		@css('plugins/adminlte-2.3.0/css/AdminLTE.css')
		@css('plugins/adminlte-2.3.0/css/skins/skin-blue.css')
		@css('plugins/font-awesome-4.6.2/css/font-awesome.min.css')
		@css('plugins/iCheck/square/blue.css')
		@css('css/app.css')
		@cssRender


		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-page">
		@yield('content')

		@js('plugins/jquery/jquery-1.12.3.min.js')
		@js('plugins/bootstrap/js/bootstrap.min.js')
		@js('plugins/adminlte-2.3.0/js/app.min.js')
		@js('plugins/iCheck/icheck.min.js')
		@jsRender

		<script>
			$(function () {
				$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%' // optional
				});
			});
		</script>
	</body>
</html>