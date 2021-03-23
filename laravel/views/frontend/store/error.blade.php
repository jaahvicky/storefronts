@extends('backoffice/layout/adminlte-auth')

@section('content')
<style type="text/css">
	.errorbanner{
		background: url("{{asset("/storage/bg_error.png")}}") 0 0 no-repeat;
		margin: -27px auto;
	    width: 28%;
	    padding: 40px 0;
	    border-top: 0;
	    height: 222px;
	}
	.error-word{
		padding: 2em;
    	text-align: center;
    	margin: 57px 0;
    	font-style: italic;
	}
	.error-word span{
		font-size: 25px;
    	color: #444;
    	font-weight: 400;
    	margin: 2.6em 0em 0.9em 0em; 
    	/*#ff7e27*/
	}
	@media (max-width: 1400px){
		 .errorbanner{
		 	width: 40%;
		 }
	}
	@media (max-width: 1024px){
		.errorbanner{
			background:#DCDFE6;
			border: 4px solid #BEC2C9;
			height: 100px;
    		margin: 10px auto;
    		padding: 0px;
    		width: 90%;
		}
		.error-word{
			margin:10px;
		}
		.error-word span{
			font-size: 14px;
		}
		
	}
	
	
	.error-logo{
		font-size: 35px;
	    text-align: center;
	    margin-bottom: 12px;
	    font-weight: 300;
	    margin: 50px auto 0px auto;
	    width:50%;
	    
	}
	.error-logo a{
		color: #444;
	}
	.error-box{
		width: 100%
		margin:7% auto;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<div class="error-box">
			<div class="error-logo">
		            <a href="#"><b>Ownai</b> Storefronts</a>
			</div>
			<div class="errorbanner"> 
		    	<div class='error-word'>
		    		<span>{{ $Storenote }}</span>
		    	</div>
			</div>
		</div>
	</div>
</div>

@endsection
