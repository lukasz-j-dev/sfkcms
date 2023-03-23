<?php
$html = '<!DOCTYPE html>







	<html lang="en-US">







	<head>







		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">







		<title>Ticket PDF</title>







		<meta name="viewport" content="width=device-width, initial-scale=1">















		<style>







		@font-face {







		  font-family: "Arial";  font-style: normal;  font-weight: normal;  src: url(Arial.ttf) format("truetype");







		}







		@font-face {







		  font-family: "Arial Narrow";  font-style: normal;  font-weight: normal;  src: url(arialn.ttf) format("truetype");







		}







		@font-face {







		  font-family: "Arial-BoldMT";







		  src: url("Arial-BoldMT.eot?#iefix") format("embedded-opentype"),  url("Arial-BoldMT.woff") format("woff"), url("Arial-BoldMT.ttf")  format("truetype"), url("Arial-BoldMT.svg#Arial-BoldMT") format("svg");







		  font-weight: normal;







		  font-style: normal;







		}







		@font-face {







	  font-family: "CreditCard";







	  src: url("CreditCard.eot?#iefix") format("embedded-opentype"),  url("CreditCard.woff") format("woff"), url("CreditCard.ttf")  format("truetype"), url("CreditCard.svg#CreditCard") format("svg");







	  font-weight: normal;







	  font-style: normal;







	}







	@font-face {







	  font-family: "ArialNarrow";







	  src: url("ArialNarrow.eot?#iefix") format("embedded-opentype"),  url("ArialNarrow.woff") format("woff"), url("ArialNarrow.ttf")  format("truetype"), url("ArialNarrow.svg#ArialNarrow") format("svg");







	  font-weight: normal;







	  font-style: normal;







	}







	@font-face {







	  font-family: "ArialNarrow-Bold";







	  src: url("ArialNarrow-Bold.eot?#iefix") format("embedded-opentype"),  url("ArialNarrow-Bold.woff") format("woff"), url("ArialNarrow-Bold.ttf")  format("truetype"), url("ArialNarrow-Bold.svg#ArialNarrow-Bold") format("svg");







	  font-weight: normal;







	  font-style: normal;







	}







		.automated-stop-sign{







			font-family: "Arial-BoldMT";







		}







		.village-of-great-neck{







			font-family: "Arial-BoldMT";







		}







		.baker-hill-road{







			font-family: "Arial";







		}







		.automated-stop-sign{







			font-family: "Arial Narrow";







		}







	html {







	  -webkit-box-sizing: border-box!important;







	  -moz-box-sizing: border-box!important;







	  box-sizing: border-box!important;







	padding:0;







	margin:0;







	}







	*, *:before, *:after {







	  -webkit-box-sizing: inherit;







	  -moz-box-sizing: inherit;







	  box-sizing: inherit;







	padding:0;







	margin:0;







	  } 











	@page { margin: 0px; }



	body{







		/*margin-left:3%!important;*/







		padding: 0px;







		background: #FFFFFF;







		margin:0;







	}







	.container {







		/*width: 632px;*/







		background-color: #FFFFFF!important;







		width: 216mm;







		/* padding:2%; */







		margin:0 auto;







		height: auto;







	}







	.header {







		margin:0 auto;







		background-color: #DC0300; 







		padding-bottom:7px; 







	}







	.col-md-12.logoimg {







		margin: 0;







		padding-top: 5px;







		padding-bottom: 5px;







		min-height: 100px;







	}







		







	.logo { 







		padding-left: 5px;



		max-width: 120px;



		float: left;



		padding-left: 5px;



		max-width: 60px;



		max-height: 60px;



		position: relative;



		top: 22px;







	}















	p.automated-stop-sign  {







		margin: 0 0 0px;







		padding: 0px;







		color: #FFFFFF;







		/*font-family: Arial;*/







		font-family: "Arial-BoldMT";







		/*font-size: 14px;*/







		font-size:18px;      







		text-align: right;







		letter-spacing: -0.02px;    







		line-height: 18px;  



		padding-top: 15px;







	}   











	.evidence, .violations{



		margin: 0 20px;



	}



	.main-chq .chq-payable{







		font-family: \'Arial-BoldMT\';



		text-transform: uppercase;



		color: #000000;







		font-size: 13px;







		line-height: 14px;







	}















	.footer-notice-info .title-violation







	{







		font-family: "Arial-BoldMT";







	}















	.footer-notice-info td{







		font-family: "Arial";







	}















	p.village-of-great-neck {







		margin: 0px;







		padding: 0px;







		color: #FFFFFF;







		font-family: Arial;







		/*font-size: 12px;*/







		font-size:16px;







		letter-spacing: 0.3px;







		line-height: 15px;







		padding-bottom:8px;







	}







	p.baker-hill-road {     







		margin: 0px;







		padding: 0px;   







		color: #FFFFFF; 







		font-family: Arial; 







		font-size: 11px; 







		letter-spacing: 0.2px;  







		line-height: 11px;  







	}















	p.video-url







	{







		font-family:"Arial-BoldMT";







		line-height:11px;







		font-size:11px;







		text-align:right;







		margin:0;







		padding-bottom:2px;







		letter-spacing: 1px;







		color:#ffffff;







	}















	.vio-details{







	padidng:0;







	margin:0;















	}















	.headerqrcode{







		margin: 0px;







		padding: 0px;







	}















	.notice-box .notice{







		margin-top:10px;







		padding: 3px!important;







		box-sizing: border-box;







		border: 2px solid #000000;







		margin-left: 0px;







		max-width: 255px;







	}







	.notice p {







		margin: 0px;







		padding: 0px;







		color: #000000;







		font-family: "Arial-BoldMT";







		font-size: 12px;







		letter-spacing: 0.8px;







		line-height: 14px;







		white-space: nowrap;























	}















	.notice-box .notice span {







		width: 120px;







		display: inline-block;







	}







	.qr-code







	{







		text-align: center;







		padding-top: 40px;







	}















	p.address {







	   







		color: #000000;



		font-family: Arial;



		font-size: 13px;



		letter-spacing: 1px;



		line-height: 13px;



		margin-left: 37px;



		max-width: 280px;



		/* background: #D8D8D8; */



		min-height: 80px;



		padding: 20px 12px;



		box-sizing: border-box;















	}















	p.scanqr {







		







		color: #000000;







		font-family: Arial;







		font-size: 11px;







		line-height: 11px;







		text-align: center;







		margin: 0 auto;







	}







	.name {







		margin-top: 39px;







		margin-left: 10px;







		margin-right: 10px;







	}















	.you-must-pay{







		margin-top: 10px;
		margin-bottom: 35px;







		padding-left: 0px;







		text-align: right;















	}







	p.youmust {







		color: #000;







		font-family: "Arial-BoldMT";







		font-size: 15px;







		line-height: 15px;







		margin-bottom: 1px;







	}







	.finedate{







		background-color:rgba(153, 192, 233,0.6);







		text-align:center;







		padding:5px;







		margin-top:0px;







	}







	p.date-main {







		margin: 0px;







		padding: 0px;







		color: #000000; 







		font-family:"Arial-BoldMT";







		font-size: 24px;     







		letter-spacing: -0.21px;    







		line-height: 24px;







		padding-bottom:5px;







	}







	.finedate p.visit {







		margin: 0px;







		padding:0px; 







		color: #000000;







		font-family: "Arial-BoldMT";







		font-size: 12px;







		/*font-weight: bold;*/







		line-height: 12px;







	}







	.carddetails {







		color: #000000;







		font-family: "Arial-BoldMT";







		font-size: 10px;







		padding-top:5px;







		/*font-weight: bold;*/







		line-height: 12px;







		margin: 0 0 5px;







	}















	.creditcard-images{ margin-top:2px;}







	.failure-to-stop {







		background-color: #DC0300!important;







		color: #FFFFFF;







		font-family: Arial;







		font-size: 11px;







		line-height: 11px;







		padding: 4px 10px;















		







	}







	.title-violation1 {
		color: #000000;
		font-family: "Arial-BoldMT";
		font-size: 13px;
		line-height: 12px;
		padding-bottom: 0px;
		text-align: center;
	}







	.violation-info {







		border: 2px solid #000000;







		margin-left: 2px!important;







		padding: 14px;







	}















	.vio-title{







		color: #000000;







		font-family:"Arial-BoldMT";







		font-size: 12px;







		letter-spacing: 0.2px;







		line-height: 12px;







		margin-bottom: 19px;







	}







	.violation-info p {







		color: #000000;







		font-family: "Arial-BoldMT";







		font-size: 12px;







		letter-spacing: 0.2px;







		line-height: 12px;







		margin-bottom: 24px;







	}







	/* .violation-info p.vio-title {







		color: #000000;







		font-family: "Arial";







		font-weight: bold;







		font-size: 12px;







		letter-spacing: 0.2px;







		line-height: 12px;







		margin-bottom: 24px;







	} */







	span.count-of-violation-info-src {







		padding: 4px 0px;







		border-radius: 70%;







		width: 25px;







		font-size: 10px;







		background-color: #000000;







		color: #FFFFFF;







		margin-right: 6px;







		display: inline-block;







		text-align: center;







		font-family:Arial;







	}















	.paying-or-contesting span{







		font-family:"Arial-BoldMT";







	}







	.violation-info span.second-violation-info {







		







		color: #000000;







		font-family: "CreditCard";







		font-size: 8px;







		letter-spacing: 1px;







		line-height: 11px;







	}







	.evidence p.info-about-evidence {







		margin-top: 10px;







		color: #000000;







		font-family: Arial;







		font-size: 11px;







		line-height: 10px;







		margin-bottom: 15px;







	}







	.points-to-assess {







		box-sizing: border-box!important;







		border: 2px solid #000000;







		/* padding: 0px% 1% 24px !important; */







		margin-left: 1%!important;







		padding-top: 10px !important;







		padding-bottom: 25px !important;







	}







	.eveidence







	{







		position:relative;  /* This fixes the IE7 overflow hidden bug */







		clear:both;







		display: inline-block;







		width:100%;   







	}







	.eve-img 







	{







		float:left;







		width:33.33%;         /* width of page */







		position:relative;















	}















	.vio-info{







	width:33.33%;







	float:left;







	position:relative;







	 /* no left and right padding on columns, we just make them narrower instead 







					only padding top and bottom is included here, make it whatever value you need */







	}







	.points-to-assess







	{







	  width:29%;







	float:left;







	position:relative;  







	}







	.evidence-info







	{







		position:relative;  







		clear:both;







		display: inline-block;







		width:100%; 







	}







	.credit-cards







	{







		padding-bottom:8px;







	}







	img.evidenceimg {







		/* max-width: 109%; */







		width: 100%!important;







	}







	.stub-notice p{







		color: #FFFFFF;







		font-family: Arial;







		font-size: 11px;







		letter-spacing: 0.8px;







		line-height: 11px;







		padding-top: 0px;







		padding-left: 5px;







		padding-bottom: 3px;







		background-color: #DC0300;







		padding-right: 30px;







	}







	.payment-options p {







		color: #000000;







		font-family: "ArialNarrow";







		font-size: 11px;







		line-height: 11px;







	}



	.logoimg{



		margin-top: 23px;



	}











	.payment-options span.pay-main{







	font-family: "ArialNarrow-Bold";







	}







	 







	 .due-date-fine-amount h3







	 { color: #000000;







		font-family: Arial;







		font-size: 20px;







		font-weight: bold;







		letter-spacing: -0.21px;







		line-height: 23px;







		text-align: center;







		margin-top: 2px;







		margin-bottom: 1px!important;







	}







	p.second-row-of-due-date span {







		color: #000000;







		font-family: "Arial-BoldMT";







		font-size: 13px;







		letter-spacing: 0.15px;







		line-height: 13px;







		padding-right: 8px;







	}







	.violations {







		margin-top: 3px;







		margin-left: 16px;







		margin-bottom: 5px;







	}







	.violation-info-table







	{







		width: 100%!important;







		font-family: Arial;







	}















	.title-violation{ font-family:Arial;}















	.payable-check-info .main-chq {







		color: #000000;







		font-family: Arial;







		font-size: 11px;







		line-height: 11px;







	}















	.payable-check-info .main-chq1 {







		color: #000000;







		font-family: "Arial-BoldMT";







		font-size: 8px;







		line-height: 9px;







	}















	.padding-8 {







		padding-left: 5px!important;







	   















	}







	.padding-0{







		padding: 0px;







	}







	.stub-notice, .stub{







		display: inline-block;







	}







	ul.more-info-about-notice li span {







		display: inline-block;







	}







	.padding-right0{







		padding-right: 0px;







	}







	.padding-left0{







		padding-left: 0px;







	}























	/*****************/







	.footer-table th {







		







		color: #000000;







		font-family: Arial;







		font-size: 9px;







		font-weight: bold;







		line-height: 10px;







		padding-bottom: 4px;







		text-align: center;







	}







	.violations td,.footer-table td {







	   







		color: #000000;







		/*font-family: Arial;*/







		font-size: 12px;







		/* font-weight: bold; */







		line-height: 12px;







		padding-right: 14px;







	}















	.violations td,.violations th,.footer-table td,.footer-table th







	{







	padding-left:1px!important;







		text-align: left;







	}







	.footer-table th,.footer-table td







	{







		margin-right: 5px!important;







	}















	.violation-info p.view-images {







		







		color: #000000;







		font-family: Arial;







		font-size: 9px;







		font-weight: bold;







		line-height: 10px;







		text-align: center;







		margin: 12px 6px 1px;







	}







	.violation-info p.steps-to-get-info {







		margin-top: 13px;







		margin-right: 4px;







	}















	.violation-info p.steps-to-get-info {







		color: #000000;







		font-family: Arial;







		font-size: 9px;







		font-weight: bold;







		letter-spacing: 0.2px;







		line-height: 10px;







		margin-bottom: 24px!important;







	}















	.third-step







	{







		margin-top:24px!important;







	}















	.points-to-assess p.points-will-be-note {







		color: #000000;







		font-family: Arial;







		font-size: 11px;







		line-height: 11px;







	}







	.paying-or-contesting p {







		color: #000000;







		font-family: Arial;







		font-size: 12px;







		line-height: 12px;







		padding-top: 5px;







		margin: 0 0 7px;







	}







	.stub-notice p.violation-stub {







		height: 16px;







		width: 209px;







		background-color: #DC0300;







		color: #FFFFFF;







		font-family: Arial;







		font-size: 8px;







		letter-spacing: 0.8px;







		line-height: 9px;







		padding-top: 4px;







		padding-left: 6px;







		padding-bottom: 3px;







		/* padding-right: 30px; */







	}































	.stub p.stub-no {







		color: #000000;







		font-family: "CreditCard";







		font-size: 10px;







		/*font-weight: 800;*/







		margin-left: 51px;







		letter-spacing: 1.55px;







		line-height: 10px;







	}















	.col-md-4.notice-date-info p {







	   







	}







	.notice-date-info p {







		 height: 11px;







		/* width: 52.59px; */







		color: #000000;







		font-family: Arial;







		font-size: 9px;







		font-weight: bold;







		line-height: 11px;







	}







	ul.more-info-about-notice li {







		







		color: #000000;







		font-family: "Arial-BoldMT";







		font-size: 12px;







		/*font-weight: bold;*/







		line-height: 12px;







	}







	.Date-notice {







		background-color: #FFF;







		width: 31%;







		font-family:"Arial-BoldMT";







	}







	.noticeDate, .noticeDate2 {







		display: block;







		background-color: #F3CBCB;







		margin-left: 0px!important;







		letter-spacing: 1.2px;







		font-family:Arial;







	}







	span.noticeDate, .noticeDate2 {







		padding-top: 3px;







		padding-left: 9px;







		width: 61%;







	}







	img.arrow {







		float: right;







			margin-top: 2%;







	}







	.payable-to p.make-payment {







		height: 9px;







		width: 165px;







		color: #000000;







		font-family: Arial;







		font-size: 8px;







		line-height: 9px;







			margin-bottom: 5px!important;







		}







	  .payable-to  p.Villagename {







		height: 9px;







		width: 104px;







		color: #000000;







		font-family: Arial;







		font-size: 8px;







		font-weight: bold;







		line-height: 9px;







	}







	  .payable-to p.post-address1 {







	 















		color: #000000;







		font-family: Arial;







		font-size: 9px;







		font-weight: bold;







		line-height: 9px;







		margin-bottom: 3px;







	}







	.payable-to p.great-neck {







	   







		color: #000000;







		font-family: Arial;







		font-size: 9px;







		font-weight: bold;







		line-height: 9px;







	}







	p.second-row-of-due-date {







		margin-bottom: 5px!important;







	}















	.p.pay-by-circle span{ width:200px; float:right;}















	.various-payment-methods p.pay-by-circle {







		color: #000000;







		font-family: "ArialNarrow-Bold";







		font-size: 13px;







		/*font-weight: bold;*/







		line-height: 14px;







		text-align: right;







		margin:0;







		padding:0;







	}















	.Date-notice1{







	font-family:"Arial";







	}















	.noticeDate{







	font-family:"Arial-BoldMT";







	}







	.various-payment-methods p.in-person {







		color: #000000;







		font-family: "ArialNarrow-Bold";







		font-size: 13px;







		line-height: 13px;







		padding-top: 15px;







		letter-spacing:0.5;







	}







	/*.various-payment-methods p.in-person span {







		//display: inline-block;







		//float: left;







	}*/







	.various-payment-methods span.right-arrow-image {







		padding-right: 4px;







		padding-left:0px;







	}















	.various-payment-methods span.right-arrow-image2 {







		padding-left: 2px;







	}







	.due-date-section p.total-amount-due {







		background-color: #DC0300;







		font-family: Arial;







		font-size: 12px;







		line-height: 10px;







		text-align: center;







		color: #fff;







		/* padding-left: 3px; */







		/* padding-top: 2px; */







		padding: 2px 3px 2px 3px;







	}







	.main-div-of-notice-info ul.more-info-about-notice {







		width: 100%;







	}







	.main-div-of-notice-info ul.more-info-about-notice li {







		list-style-type: none;



		width: 100%;







	}







	.col-md-4.due-date-section {







		margin-top: -9px;







	}















	.col-md-4.due-date-section {







		text-align: center;







	}







	.due-date-fine-amount span.feb {







		color: #000000;







		font-family: Arial;







		font-size: 10px;







		font-weight: bold;







		letter-spacing: 0.15px;







		line-height: 11px;







		margin-left: 10px;







	}







	.due-date-fine-amount span.due-date-text {







		color: #000000;







		font-family: Arial;







		font-size: 10px;







		font-weight: bold;







		letter-spacing: 0.15px;







		line-height: 11px;







	}







	.due-date-fine-amount {







		border: 1px solid #000000;







		margin-top: -5px;







	}















	.newdate3{







		font-family:"Arial-BoldMT";







	}















	.price-bottom{







		color: #000000;







		font-family: "Arial-BoldMT";







		font-size: 24px;







		letter-spacing: -0.21px;







		line-height: 24px;







		text-align: center;







		margin-top: 2px;







		margin-bottom: 0px;







	}















	.notice-date-info span.noticeDate {







		color: #000000;







		font-family: Arial;







		font-size: 9px;







		letter-spacing: 1px;







		line-height: 10px;







	}







	table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th, table>tr>td {







		/* padding-top: 3px!important; */







		padding-right: 0px;



		line-height: 17px;



		padding-left: 0px;



		vertical-align: top;



		border-top: none!important;



		font-size: 12px;







	}















	.third-section-of-footer.row {







		padding-top: 8px;







	}







	.col-md-4.payable-check-info {







		padding-top: 7px!important;







	}







	.col-md-8.payment-intructions p {







		color: #000000;







		font-family: "Arial-BoldMT";







		font-size: 13px;







		letter-spacing: 0.22px;







		line-height: 13px;







	   







	}







	.col-md-8.payment-intructions {







		padding-left: 0px;







		padding-right: 0px;







	}















	@media screen and (-webkit-min-device-pixel-ratio:0) { 







	/* Safari and Chrome */







	::i-block-chrome,.right-arrow-image2







		{







			margin-top: -20px;







			margin-left: 80%;







		}







	}







	.failure {







		background-color: #DC0300!important;



		text-transform: uppercase;



		color: #FFFFFF;



		font-family: "Arial-BoldMT";



		font-size: 14px;



		line-height: 14px;



		padding: 6px 30px;



		letter-spacing: 0.1px;



		clear: both;



		display: block;



		width: 100%;



		position: relative;







	}























	/******************************for pdf ***********************************************/







	.headerqrcode{







	position:relative;  /* This fixes the IE7 overflow hidden bug */







	clear:both;







	display: inline-block;







	width:100%;          /* width of whole page */















	}







	.notice-box







	 {







	float:left;







	width:62%;       /* width of page */







	position:relative;







	}







	.qr-code







	{







		float:left;







		width:33.33%;         /* width of page */







		position:relative;















	}







	.qr_text{







		color: #000000;







		font-family: "Arial-BoldMT";







		font-weight: bold;







		font-size: 12px;







		line-height: 12px;







		margin-bottom: 24px;







		text-align: center;







		max-width: 210px;







		margin: auto;







		margin-top: 42px;







	}







	.you-must-pay {



		width: 32%;



		float: left;



		position: relative;



		margin-right: 14px;



	}















	.stubBymail







	{







			position:relative;  /* This fixes the IE7 overflow hidden bug */







			clear:both;







			display: inline-block;







			width:100%; 







	}







	.parent-of-stub-notice







	{







			float:left;







			width: 66.66666667%!important;      /* width of page */







			position:relative;







	}















	.stub-notice







	{







			width:33.33%!important;







			position:relative;  /* This fixes the IE7 overflow hidden bug */







			







	}







	.stub







	{







			width:33.33%!important;







			position:relative;  /* This fixes the IE7 overflow hidden bug */







			







	}







	.scan_qr{







		text-align: center;







		position: relative;







	}







	.qr_frame{







		position: absolute;







		top: 3px;







		left: 13px;







		width: 190px;







	}







	.main-chq .chq_address{







		font-family: "Arial-BoldMT";



		font-weight: Bold;







		color: #000000;







		font-size: 13px;



		text-transform: uppercase;







	}



	/* .top-notice{



		float: left;



		width: 40%;



		position: relative;



	} */



	/* .logoimg{



		float: left;



		width: 60%;



		position: relative;



	} */



	.top-notice .notice{







		margin-top:10px;







		box-sizing: border-box;







		border: 2px solid #fff;







		margin-left: 0px;







		max-width: 255px;



		color: #fff;



		margin: 10px auto 0;







	}



	.img_past_due{



		position: absolute;



		right: 255px;



		width: 128px;



		top: 26px;



	}



	.header{



		position: relative;



		top: 0px;



	}



	/* p.video-url{



		position: absolute;



		right: 19px;



		top: 8px;



	} */



	.youmust{



		text-align: right;



		width: 100%;



		color: #fff;



		margin-bottom: 4px;



	}



	.top-notice table tr td{



		font-family: "Arial-BoldMT";



	}



	.mn_due_date, .mn_fine_amount{



		display: block;



	}



	.mn_due_date{



		margin-bottom: 5px;



	}



	.top-notice{



		max-width: 250px;



		margin: auto 0 auto auto;



	}



	/********************************************************************/















		</style>







		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" rel="stylesheet" media="print">







	<!--<link href="ticketpdf-style.css" rel="stylesheet">-->







		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" media="print">







	</head>







	<body>







	<div class="container" style="background-color:white;">







		<div class="header">



					<table style="width: 100%;">



						<tr>



							<td style="width:55%;padding-left: 40px;">



								<div class="logoimg">



									<img class="logo" src="../cms/public/images/villages/' . $violation_details['village_logo'] . '" >



									<div style="position: relative;top: 0px;text-transform: uppercase;">



										<p class="village-of-great-neck">' . $violation_details['village_court_text'] . '</p>







										<p class="baker-hill-road">' . $vil_address . '</p><p class="baker-hill-road">' . $violation_details['vil_city'] . ', ' . $violation_details['vil_state'] . ' ' . $violation_details['vil_zip'] . '</p>



									</div>



								</div>



							</td>



							<td style="width:43%;padding-right: 48px;%!important;">



								<p class="automated-stop-sign">STOP SIGN VIOLATION</p>



								<div class="top-notice">







									<div class="notice">



										<table style="width: 100%;max-width: 350px;">



											<tr>



												<td>Notice Date:</td><td style="text-transform: uppercase;">' . $notice_date . '</td>



											</tr>







											<tr>



												<td><span>Violation Number:</td><td>' . $violation_details['violation_number'] . '</td>



											</tr>







											<tr>



												<td><span>Pin Number:</td><td>' . $violation_details['pin'] . '</td>



											</tr>



										</table>



									</div>



								</div>



							</td>



						</tr>



					</table>



			</div><!--end of header-->







		<div class="headerqrcode">



		<div class="row">







				<div class="col-md-4">







					<div class="notice-box">







						<div class="name">







							<p class="address">' . $violation_details['full_name'] . '<br />







							' . $vio_address . '<br />







							' . $violation_details['city'] . ', ' . $violation_details['state'] . ' ' . $violation_details['zip'] . '</p>







						</div>







				</div>







			</div>







			<!--notice-box-->







			<div class="col-md-4">



			<div class="you-must-pay">



				<p class="youmust">YOU MUST PAY OR CONTEST BY</p>



				<div class="finedate" >







						<p class="date-main"><span class="mn_due_date" style="text-transform: uppercase;">' . $due_date . '</span><span class="mn_fine_amount">$' . $violation_details['fine_amount'] . '</span></p>



						<p class="visit">VISIT STOPFORKIDS.COM</p>







					</div>















				<p class="carddetails" style="text-align:left;margin-bottom:1%!important;"><span style="margin-left:1%!important;margin-bottom:1%!important;">Payment can be made online by credit card or debit card. Subject to $15 late fee per month.</span></p>







			</div>







			</div>



		</div><!--row-->







	</div><!--End of headercode-->







	<div class="clearfix"></div>







	<div class="failure">Failure to stop at a traffic signal - no points</div>















	<div class="violations">







	<table class="violation-info-table">







		<tbody>







			<tr>







				<td class="title-violation1">VIOLATION</td>







				<td class="title-violation1">PLATE</td>







				<td class="title-violation1">STATE</td>







				<td class="title-violation1">MAKE/TYPE</td>







				<td class="title-violation1" style="width: 100px;">DATE & TIME</td>







				<td class="title-violation1">CODE</td>







				<td class="title-violation1" style="width: 140px;">LOCATION</td>







			</tr>







			<tr>







				<td>' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . '</td>







				<td>' . $violation_details['plate'] . '</td>







				<td>' . $violation_details['state'] . '</td>







				<td>' . $plate_details['make'] . '<br>' . $violation_details['type'] . '</td>







				<td style="text-transform: uppercase;">' . $violation_date . '<br>' . $violation_time . '</td>







				<td>STOP SIGN</td>







				<td style="text-transform: uppercase">' . $violation_details['camera_location'] . '<br>' . $violation_details['camera_zip'] . '</td>







			</tr>







		</tbody>







	</table>







	</div>







	<div class="evidence"> 







		<div class="row">







			<div class="col-md-4 eve-img padding-0">







				<div class="evidence-image"><img class="evidenceimg" src="data:image/png;base64, ' . $plate_photo . '"></div>







			</div>















			<div class="col-md-4 vio-info padding-8">







				<div class="violation-info">







				<p style="text-align: center;" class="vio-title">You can view full color images<br>







				and video for this violation at</p>















				<p style="vertical-align:middle;letter-spacing: 0.3px;" class="vio-details"><span class="count-of-violation-info-src">1</span>STOPFORKIDS.COM</p>







				<p style="vertical-align:middle;" class="vio-details"><span class="count-of-violation-info-src">2</span>ENTER<span class="second-violation-info" style="padding:0; vertical-align:middle; margin:0;"> ' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . '</span></p>







				<p style="vertical-align:middle;" class="vio-details"><span class="count-of-violation-info-src">3</span>PAY OR CONTEST TICKET</p>







				<p style="text-align:center; padding:0; margin:0;"><img class="credit-cards" src="images/card-svg1.svg" width="180" /></p></div>







			</div>















			<div class="col-md-4 points-to-assess padding-0 ">







				<div class="scan_qr">







					<img class="qrcode" src="' . $qr_url . '" width="162"/>







					<img class="qr_frame" src="images/qrcode_21538626_@2x.png"/>







					<p class="qr_text">Scan QR code with your mobile camera to view, pay or dispute fine.</p>







				</div>







			</div>







		</div>







		<!--End of row of evedence-->















		<div class="clearfix"></div>







		   <div class="evidence-info">







			<p class="info-about-evidence" style="margin-bottom: 5px;">These recorded images and videos are evidence of a violation of failure to stop at a stop sign. Please note, the vehicle identified above bears a license plate registered or leased in your name. All registered owners are legally responsible for this violation. If you believe the license plate displayed in the photo above is not registered to you, please dispute online or contact ' . $violation_details['village_court_text'] . ' at ' . $violation_details['village_email'] . '</p>







			</div>







		<div class="clearfix"></div>







			<div class="row">







				<div class="col-md-12 divide-parent">







				 <div class="divide" style="border: 1px dashed #979797;"></div>







				</div>







				</div>















	<div class="clearfix"></div>







	<div class="row">







	<div class="paying-or-contesting">







		<p><span>PAYING OR CONTESTING BY MAIL:</span> TO ENSURE PROPER CREDIT PLEASE RETURN THIS STUB WITH YOUR PAYMENT.</p>







	</div>







	</div>







	<div class="clearfix"></div>































	<div class="main-class-notice-of-stub">







	<div class="stubBymail" style="position:relative; clear:both;display:inline-block;width:100%; ">







	 <div class="row">







						<div class="col-md-4 stub-notice" style="display:inline-block;width:35%!important;position:relative;" >







							<p>NOTICE OF VIOLATION STUB BY MAIL</p>







						</div>















						<div class="col-md-4 stub" style="display:inline-block;width:31%!important;position:relative;text-align:left;">







							<p class="stub-no" style="vertical-align:middle;">' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . '</p>







						</div>







					<div class="col-md-4 notice-date-info" style="display:inline-block;width:34%!important;position:relative;">







						<div class="main-div-of-notice-info row">







							<ul class="more-info-about-notice">







								<li class="notice-date-info"><span class="Date-notice">Notice Date:</span> <span class="noticeDate newdate3" style="font-family:Arial-BoldMT; font-size:12px; text-transform: uppercase;">' . $notice_date . '</span></li>







								<li class="notice-date-info"><span class="Date-notice">Violation:</span> <span class="noticeDate2 violation-notice-number newdate3">' . $violation_details['violation_number'] . '-' .  $violation_details['pin'] . '</span></li>







							</ul>







						</div>







					</div>







	</div>







	</div>







	</div>























	<div class="row" >







		<div class="second-section" style="margin-top:-20px!important;">







		<div class="row" style="position:relative; clear:both;display:inline-block;width:100%; ">







				<div class="col-md-8 pay" style="display:inline-block;width:60%!important;position:relative;">







	<div class="row">







								<div class="col-md-8 payment-options padding-right0" style="float:left;width:70.66%!important;position:relative;">
								</div>















								<div class="col-md-4 various-payment-methods" style="float:left;width:29%!important;"></div>







							</div>







						</div>















						<div class="col-md-4 due-date-section" style="float:right;width:33.33%!important;position:relative;">







								<p class="total-amount-due">TOTAL AMOUNT DUE<br />







								<span>FOR THE TICKET LISTED ON THIS NOTICE</span></p>















								<div class="due-date-fine-amount">







										<p class="price-bottom">$' . $violation_details['fine_amount'] . '</p>















										<p style="margin-top:-10px;" class="second-row-of-due-date"><span style="padding-right:15px;">DUE DATE </span><span style="text-transform: uppercase;">' . $due_date . '</span></p>







								</div>







						</div>







					







		</div>







		</div>







	</div>







	<div class="row">







	<div class="third-section-of-footer row" style="position:relative;  clear:both;display: inline-block;width:100%;">







		<div class="col-md-8 third-section-info" style="float:left;width:66.66%;position:relative;">







			<div class="row">







				<div style="margin-top:-15px;" class="col-md-7 footer-table">







					<table class="footer-notice-info table" width="65%">







						<tbody>







							<tr>







								<td class="title-violation">TICKET</td>







								<td class="title-violation">PLATE</td>







								<td class="title-violation">STATE</td>







								<td class="title-violation" style="width: 90px;">NOTICE DATE</td>







							</tr>







							<tr>







								<td>' . $violation_details['violation_number'] . '</td>







								<td>' . $violation_details['plate'] . '</td>







								<td class="ny">' . $violation_details['state'] . '</td>







								<td style="width: 90px; text-transform: uppercase;">' . $notice_date . '</td>







							</tr>







						</tbody>







					</table>







				</div>







				<!--end-of footer-table-->















				<div class="col-md-1"></div>







			</div>







		<!-- end of row -->







		</div>







		<!----end-of third-section-info-->















		<div class="col-md-4 payable-check-info" style="float:left;width:33.33%;position:relative;">







			<div class="main-chq">Make check payable to:<br />







			<span class="chq-payable">' . $violation_details['payable_to'] . '</span><br />







			<br />







			<span class="chq_address" style="font-family: \'Arial-BoldMT\';font-weight: Bold;color: #000000;font-size: 13px;">' . $vil_address . '</span><br />







			<span class="chq_address" style="font-family: \'Arial-BoldMT\';font-weight: Bold;color: #000000;font-size: 13px;">' . $violation_details['vil_city'] . ', ' . $violation_details['vil_state'] . ' ' . $violation_details['vil_zip'] . '</span>







			</div>







		</div>







	</div>







	</div>







	<div class="row">







	<div class="col-md-12 fourth-section-of-div" style="position:relative;  clear:both;display:block; width:100%;">







		<div class="col-md-8 video-and-imginfo payment-intructions" style="float:left;width:50%;position:relative; margin-top:-10px;">







			







				<p>SEE VIDEO, OR PAY BY CREDIT CARD, OR<br />







				DISPUTE AT STOPFORKIDS.COM	 <img class="creditcard-img" src="images/card-svg1.svg" width="160" style="display:inline-block;margin-left:85%!important;margin-top:-20px!important;"/></p>















		</div>















	</div><!--fourth-section-of-div row-->







	</div>















	</div>







	<!--End of evedence-->







	</div><!--End of container-->







































	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script></body>















	</html>';
