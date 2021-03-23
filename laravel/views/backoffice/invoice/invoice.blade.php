<!DOCTYPE html>
<html>
	<head>
		<title>Storefront Billing | Invoice</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		<link href="{{ asset('/css/frontend.css') }}" rel="stylesheet">

		<style type="text/css">
			body {
			    font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
			    font-size: 14px;
			    line-height: 1.42857143;
			    color: #333;
			    background-color: #fff;
			    margin: 0 auto;
    			width: 750px;
			}
			.header .header-logo {
				width: 160px;
				height: 90px;
				
			}
			.container{
				width:100%;
				padding-right: 15px;
    			padding-left: 15px;
    			margin-right: auto;
    			margin-left: auto;
			}
			.row{
				margin-right: -15px;
				margin-left: -15px;


			}
			.col-md-8{
				width:35.666%;
			}
			.col-md-4{
				width:53.333%;
			}
			.col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9 {
    			float: left;
			}
			.col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
			    position: relative;
			    min-height: 1px;
			    padding-right: 15px;
			    padding-left: 15px;
			}
			.text-right {
			    text-align: right;
			    /*line-height: 2.0;*/
			}

			.h4, h4 {
			    font-size: 18px;
			}
			.h4, .h5, .h6, h4, h5, h6 {
			    margin-top: 10px;
			    margin-bottom: 10px;
			}
			.h1, .h2, .h3, .h4, .h5, .h6, h1, h2, h3, h4, h5, h6 {
			    font-family: inherit;
			    font-weight: 500;
			    line-height: 1.1;
			    color: inherit;
			}
			.text-left {
    			text-align: left;
    			line-height: 2.0;
			}
			.col-xs-12 {
    			width: 100%;
			}
			.col-xs-2 {
    			width: 16.66666667%;
			}
			.col-xs-4 {
    			width: 33.33333333%;
			}
			.col-md-6 {
    			width:50%;
			}
			.col-xs-6{
				width: 30%;

			}
			.margin-align{
				margin-top: -8px;
			}
			.col-xs-8 {
    			width: 33.66666667%;
			}
			.header {
    			padding: 25px 15px;
    			background: #fff;
    		
			}
			.col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9 {
    			float: left;
			}
			table{
				width:100%;
			}
			.clear{
				clear:both;
				
				
			}
			.panel-body {
    			/*padding: 15px 0;*/
			}
			.img-responsive{
				display: block;
    			max-width: 100%;
    			height: auto;
			}
			.col-xs-5 {
    			width: 32.8%;
			}
			.methys_border_left {
    			border: 1px solid #ddd;
    			padding: 10px;
    			margin: 10px 0px;
    			height: 160px;
			}
			.methys_border_right {
    			border: 1px solid #ddd;
    			padding: 10px;
    			margin: 10px 0px;
    			height: 160px;
    			margin-top: -2px;
			}
			.product-div{
				border-bottom:1px solid #ddd;
				margin-bottom: 10px;

			}
			.clear_too{
				clear: both;
				padding-top: 55px;
			}
			.methys_border{
				border: 1px solid #ddd;
				padding: 5px 0;
				height: 150px;
				margin:10px 0; 
			}
			.clear_3{
				clear: both;
			}
			.text-center {
    			margin:0 auto;
    			width:50%;
			}
			.store-footer {
    			padding-top: 25px;
    			padding-bottom: 25px;
    			margin-top: 25px;
    			border: 0px solid #ccc;
    			
			}
			ul.store-footer-nav {
    			list-style: none;
    			padding: 0px;
    			margin: 0px;
			}
			ul.store-footer-nav > li {
    			display: inline-block;
    			margin-right: 50px;
			}
			ul.store-footer-nav > li > a {
    			text-decoration: none;
    			color: #333;
    			font-size: 1.3rem;
			}
			.bodyTable{
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                /*height: 100%;*/
                margin: 0 auto;
                padding: 0;
                width: 100%;
                background-color: #FAFAFA;
            }
            .bodyCell{
                mso-line-height-rule: exactly;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                /*height: 100%;*/
                margin: 0 auto;
                /*padding: 10px;*/
                width: 100%;
                border-top: 0;
            }

             .mcnPreviewText{
                display:none;
                font-size:0px;
                line-height:0px;
                max-height:0px; 
                max-width:0px; 
                opacity:0; 
                overflow:hidden; 
                visibility:hidden; 
                mso-hide:all;
            }
 			.templateContainer{
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                border: 0;
                max-width: 600px !important;
            }
            .con_tain{
                /*background-image: url(https://gallery.mailchimp.com/705efb01732985cc7e77c239f/images/2eef77dd-f207-431c-b989-89f8d1c1235e.jpg);
                background-repeat: no-repeat;
               	width: 750px;
               	height: 800px;*/
                /*background-attachment: cover;*/
                /*background-size: cover;*/
    			/*overflow: hidden;*/
    			/*position: absolute;*/
    			/*background-image:url("{{ asset('images/store/ownai-invoice.jpg') }}");*/
  				/*background-size: 100%;*/
  				/*background-repeat: no-repeat;*/
            }
            #templateHeader{
                mso-line-height-rule: exactly;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                background-image: none;
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                border-top: 0;
                border-bottom: 0;
                padding-top: 9px;
                padding-bottom: 0;
            }
            .mcnTextBlock{
                min-width: 100%;
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            .mcnTextBlockInner{
                padding-top: 9px;
                mso-line-height-rule: exactly;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            .mcnTextContentContainer{
                max-width: 100%;
                min-width: 100%;
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            .mcnTextContent{
                padding-top: 0;padding-right: 18px;
                padding-bottom: 9px;
                padding-left: 18px;
                mso-line-height-rule: exactly;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                word-break: break-word;
                color: #202020;
                font-family: Helvetica;
                font-size: 16px;
                line-height: 150%;
                text-align: left;
            }
            #templateBody{
                mso-line-height-rule: exactly;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                background-image: none;
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
                border-top: 0;
                padding-top: 0;
                padding-bottom: 9px;
            }
            .ltr{
                text-align: left; 
                float: right;
    			margin-top: 19px;
    			margin-right: 120px;
            }
            p, h2, h3{
                line-height: 0.5;
            }
            .table{
                border: solid 1px #222;
                width: 100%;
                border-collapse: collapse;
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }
            .table thead, .table th{
                border:solid 1px #222
            }
            .table td{
                border: solid 1px #222;
                mso-line-height-rule: exactly;
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
            }	
            .header, .container{
            	/*background-color: #F2F9D8;*/
            	background-color: transparent;
            	/*margin-top: 10px;*/
            }
            .container{
            	/*padding-top: 130px;
            	padding-bottom: 130px;*/
                    /*margin-top: -100%; */
            }
            .text-left{
            	text-align: left;
            }
            .ltrs{
                text-align: left; 
                float: right;
    			/*margin-top: 19px;*/
    			margin-right:170px;
            }
            .img_rep{
                width:97%;
                height: 1000px;
                margin-top:-10px;
               margin-bottom: -850px

            }	
		</style>
	</head>
	<body class="">
		<!-- <div class=""> -->
		<img src="{{ asset('images/store/ownai-invoice.jpg') }}" class="img_rep">
	 		<div class="container  ">
                <div class='header'>
                    <div class="row">
                        <div class="col-md-8">                  
                        </div>
                        <div class="col-md-4">
                            <div dir="ltr" class="ltr" style="">
                                <p>2 Old Mature Road</p>
                                <p>Msasa, Harare</p>
                                <p>Tel: +263-772 023 000/166</p>
                                <p>VAT NO: 10003121</p>
                                <p>BP NO: 200002652</p>
                            </div>
                        </div>
                    </div>
                    <div class="clear">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-8 text-left">
                            <h2><b>INVOICE TO</b></h2>
                            <h3><b>Account # :{{ $transaction->bill->contactDetails->phone }}</b></h3>
                            <p>{{ $transaction->bill->name }}</p>
                            <p>{{ $transaction->bill->contactDetails->street_address_1 }}</p>
                            <p>{{ $transaction->bill->contactDetails->suburb->name }}, {{ $transaction->bill->contactDetails->city->name }}</p>
                            <p>Zimbabwe</p>
                            <p>{{ $transaction->bill->contactDetails->email }}</p>                  
                        </div>
                        <div class="col-md-4">
                            <div class="ltrs" style="">
                                    <p><b>Date:</b> {{ date('F d, Y')}}</p>
                                    <p><b>INVOICE #<small>{{ substr($transaction->correlator, 0, 8) }}</small></b></p>
                            </div>
                         
                        </div>
                    </div>
                    <div class="clear">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-12 text-left">
                                <p><b>Customer VAT # :10003123</b></p>          
                        </div>
                    </div>
                    <div class="clear">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <p><b>Client:</b></p>           
                        </div>
                    </div>
                    <div class="clear">&nbsp;</div>
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextContentContainer">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top" class="mcnTextContent">
                                                                        <table class="table" >
                                                                            <thead>
                                                                                <tr>
                                                                                    <th >Date</th>
                                                                                    <th>Description</th>
                                                                                    <th>&nbsp;</th>
                                                                                    <th >Amount</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td >{{ CronHelper::getDateRange($transaction->bill) }}</td>
                                                                                    <td >Ownai Storefront subscriptions</td>
                                                                                    <td >&nbsp;</td>
                                                                                    <td >${{ number_format( ($transaction->amount - (($transaction->amount * 15) / 100) ), 2,'.','') }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td >&nbsp;</td>
                                                                                    <td >VAT @ 15%</td>
                                                                                    <td >&nbsp;</td>
                                                                                    <td >${{ number_format((($transaction->amount * 15) / 100),2,'.','')  }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td >&nbsp;</td>
                                                                                    <td ></td>
                                                                                    <td >Total</td>
                                                                                    <td >${{ number_format(($transaction->amount),2,'.','')  }}</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td >&nbsp;</td>
                                                                                    <td ></td>
                                                                                    <td >Total Paid</td>
                                                                                    <td >${{ number_format(($transaction->amount),2,'.','')  }}</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                        </div>
                    </div>      
            </div>

		<!-- </div> -->
	</body>
</html>