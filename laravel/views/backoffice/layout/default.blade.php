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
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<!-- primary library css -->
		<link href="{{ asset('/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/plugins/font-awesome-4.6.2/css/font-awesome.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
		
		<!-- Theme style -->
		<link href="{{ asset('/plugins/adminlte-2.3.0/css/AdminLTE.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/plugins/adminlte-2.3.0/css/skins/skin-blue.min.css') }}" rel="stylesheet">
		
		<!-- Helper rendered css links -->
		@cssRender

		<!-- custom css - NOTE: Overrides all other css-->
		<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
		<link href="{{ asset('/css/backoffice.css') }}" rel="stylesheet">

		<!-- primary javascript that needs to load with page -->
		<script type="text/javascript" src="{{ asset('plugins/jquery/jquery-2.2.3.min.js') }}"></script>
		
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body class="hold-transition skin-blue">
		
		<!-- Site wrapper -->

		<div class="wrapper">
			@include('backoffice/layout/header')
	
			@if(Gate::check('admin.stores') || Gate::check('admin.moderator.products'))
				@include('backoffice/admin/navigation')
			@else
				@include('backoffice/layout/navigation')
			@endif
                        
			<!-- Content Wrapper. Contains page content -->
			<div class="content-wrapper">
				<!-- Content Header (Page header) -->
				<section class="content-header">
					<h1>
                                            @pageContentTitle
					</h1>
					@if(isset($actions))
						@foreach($actions As $href => $label)
							<a href="{!! $href !!}"><button class="btn btn-primary" value="{!! $label !!}" >{!! $label !!}</button></a>
						@endforeach
					@endif
				</section>

				<!-- Main content -->
				<section class="content">
                                    @include('backoffice.layout.flash')
                                    @yield('content')
				</section><!-- /.content -->
			</div><!-- /.content-wrapper -->

			@include('backoffice/layout/footer')
			 
		</div><!-- ./wrapper -->

		<!-- primary libraries -->
		<script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
		<script type="text/javascript" src="{{ asset('plugins/adminlte-2.3.0/js/app.js') }}"></script>
		<script type="text/javascript" src="{{ asset('plugins/methys-javascript/methys.logger.js') }}"></script>
		<script type="text/javascript" src="{{ asset('plugins/methys-javascript/methys.events.js') }}"></script>
		<script type="text/javascript" src="{{ asset('plugins/methys-javascript/methys.modals.js') }}"></script>
		<script type="text/javascript" src="{{ asset('plugins/moment/moment.js') }}"></script>
		<script type="text/javascript" src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
		<script type="text/javascript" src="{{ asset('plugins/methys-javascript/methys.ownai-validator.js') }}"></script>
		<script type="text/javascript" src="{{ asset('plugins/methys-javascript/methys.ajaxforms.js') }}?v={{ time() }}"></script>

		<!-- Custom scripts -->
		@js('/js/ownerportal/store/store-scripts.js')
		
		<!-- helper rendered JS scripts -->
		@jsRender
		
	</body>
</html>