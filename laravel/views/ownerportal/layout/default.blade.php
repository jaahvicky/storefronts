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
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWspmkzs7" crossorigin="anonymous">
        <link href="{{ asset('/plugins/bootstrap/css/bootstrap-3.3.6.css') }}" rel="stylesheet">
        
         <!-- custom css - NOTE: Overrides all other css-->
        <link href="{{ asset('/css/ownerportal.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/ownerportal_custom.css') }}" rel="stylesheet">

        <!-- font & icons-->
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,500,700' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- Helper rendered css links -->
        @cssRender

        <!-- primary javascript that needs to load with page -->
        <script type="text/javascript" src="{{ asset('plugins/jquery/jquery-2.2.3.min.js') }}"></script>
    </head>
    <body class="sp-store-setup sp-form-page">
        
        @include('ownerportal/layout/header')

        <!-- main container -->
        <div class="container">		
	
            <div class="main" role="main content">
                @yield('stepper')
                @yield('content')
            </div>
            
        </div>
        
        <!-- primary libraries -->
        <script type="text/javascript" src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>

        <!-- Custom scripts -->
        @js('/js/ownerportal/store/store-scripts.js')

        <!-- helper rendered JS scripts -->
        @jsRender

    </body>
</html>