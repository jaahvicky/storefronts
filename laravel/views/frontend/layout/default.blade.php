<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>@pageTitle</title>
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

		<!-- favicon -->
		<link rel="shortcut icon" href="{{asset('images/favicon/favicon-48.png')}}">
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{asset('images/favicon/favicon-144.png')}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{asset('images/favicon/favicon-114.png')}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{asset('images/favicon/favicon-72.png')}}">
		<link rel="apple-touch-icon-precomposed" href="{{asset('images/favicon/favicon-57.png')}}">
		<link rel="shortcut icon" href="{{asset('images/favicon/favicon.ico')}}">

		<!-- primary library css -->
		<link href="{{ asset('/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/plugins/font-awesome-4.6.2/css/font-awesome.min.css') }}" rel="stylesheet">

		<!-- Helper rendered css links -->
		@cssRender

		<!-- custom css - NOTE: Overrides all other css-->
		<link href="{{ asset('/css/frontend.css') }}" rel="stylesheet">

		<!-- primary javascript that needs to load with page -->
		<script type="text/javascript" src="{{ asset('plugins/jquery/jquery-2.2.3.min.js') }}"></script>

		{{-- <script type="text/javascript">
			jQuery(document).on("mobileinit", function() {
    			jQuery.mobile.autoInitializePage = false;
			});
		</script> --}}

		<script src="{{ asset('plugins/jquery-mobile/jquery.mobile.custom-1.4.5.min.js') }}"></script>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
		<script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
		@yield('content')

		<!-- modals - site wide -->
		@include('frontend.shoppingcart.modal.empty-cart')

		<!-- primary libraries -->
		
		<script src="{{ asset('plugins/methys-javascript/methys.logger.js') }}"></script>
		<script src="{{ asset('plugins/methys-javascript/methys.events.js') }}"></script>
		

		<!-- custom script -->
		<script src="{{ asset('js/frontend/frontend-script.js') }}"></script>

		<!-- helper rendered JS scripts -->
		@jsRender

	</body>
</html>