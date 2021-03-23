<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Store Closed - Store Name</title>
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

        <!-- Helper rendered css links -->
        @cssRender

        <!-- custom css - NOTE: Overrides all other css-->
        <link href="{{ asset('/css/frontend.css') }}" rel="stylesheet">

        <!-- primary javascript that needs to load with page -->
        <script type="text/javascript" src="{{ asset('plugins/jquery/jquery-2.2.3.min.js') }}"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="header-outter">
            @include('frontend.layout.header')
        </div>
        
        <div class="container">
            <div class="row error-content">
                <div class="col-sm-12">
                    <img src="/images/samples/find_page.svg" class="error-image" alt="page find"/>
 
                    <h1 class="error-title">Store Closed</h1>
                    <p class="error-message">The page you are looking has been closed and is no longer accessible.</p>
                    <p class="error-code">Error type: <strong class="clossed">Closed</strong></p>
                    
                    <div class="error-options">
                        <a class="btn btn-primary btn-lg">Back to Storefronts</a><a class="btn btn-default btn-lg">Contact Ownai</a>                       
                    </div>
                </div>         
            </div>  
        </div>


        @yield('content')

        <!-- primary libraries -->
        <script src="{{ asset('plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('plugins/methys-javascript/methys.logger.js') }}"></script>
        <script src="{{ asset('plugins/methys-javascript/methys.events.js') }}"></script>

        <!-- helper rendered JS scripts -->
        @jsRender

    </body>
</html>