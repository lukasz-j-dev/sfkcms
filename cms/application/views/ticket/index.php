<!DOCTYPE html>
<html lang="en-US">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Ticket View</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Tangerine" rel="stylesheet" />
	<style type="text/css">@import url('https://fonts.googleapis.com/css?family=Roboto:400,400i,500,700&display=swap');	
html {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
*, *:before, *:after {
  -webkit-box-sizing: inherit;
  -moz-box-sizing: inherit;
  box-sizing: inherit;
  }	
body{
	margin: 0px;
	padding: 0px;
	background: #f1f1f1;
}
.container {
	width: 530px;
	
	padding:15px;
}
.header {
    border-radius: 4px;
    background-color: #FFFFFF;
    box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.2);
 }
.header h3 {
    color: rgba(0,0,0,0.87);
    font-family: 'Roboto', sans-serif;
    font-size: 24px;
    letter-spacing: 0.18px;
    line-height: 24px;
    text-align: center;
    padding-top: 16.43px;
    margin: 0px!important;
}
.header h4 {
    color: rgba(0,0,0,0.87);
    font-family:  'Roboto', sans-serif;
    font-size: 16px;
    letter-spacing: 0.15px;
    line-height: 24px;
    text-align: center;
    padding-bottom: 16px;
    margin-top: 8px;
    margin-bottom: 0px;
}
.violation-number,.violation-plate,.violation-date {
    border-radius: 4px;
    background-color: #FFFFFF;
    box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.2);
    margin-top: 8px;
    text-align: left;
    /*margin: 12px;
    padding: 15px 0px 13px 16px;*/
}
.violation-number p,.violation-plate p,.violation-date p {
    color: rgba(0,0,0,0.87);
    font-family: 'Roboto', sans-serif;
    font-size: 10px;
    font-weight: 500;
    letter-spacing: 1.5px;
    line-height: 16px;
    margin-bottom: 0px!important;
    padding: 16px 0px 4px 16px;
}
.violation-number h3, .violation-plate h3, .violation-date h3 {
    color: rgba(0,0,0,0.87);
    font-family: 'Roboto', sans-serif;
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 0.15px;
    line-height: 24px;
    margin: 0px!important;
    padding: 1px 0px 28px 16px;
}
.amount-due {
    border-radius: 4px;
    background-color: #FFFFFF;
    box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.2);
    margin-top: 8px;
    
}
.due-date p,.Total-due-amount p {
    /* color: #DC0300; */
    font-family: 'Roboto', sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1.5px;
    line-height: 16px;
   margin-bottom: 0px!important;
   padding: 28.18px 0px 0px 22px;
}
.due-date p {
    color: #DC0300;
    padding-top: 22px;
}
.Total-due-amount p {
    padding-top: 19px;
    
}
.due-date h3, .Total-due-amount h3 {
    font-family: 'Roboto', sans-serif;
    font-size: 20px;
    font-weight: 700;
    letter-spacing: 0.15px;
    line-height: 24px;
    margin: 0px;
    padding: 4px 0px 0px 22px;
}
.due-date h3 {
    color: #DC0300;
}
.pay-now a.btn.btn-info {
    margin: 22px 22px 22px 12px;
    border-radius: 4px;
    color: #FFFFFF;
    font-family:  'Roboto', sans-serif;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 1.25px;
    line-height: 16px;
    text-align: center;
    padding: 14px 17.33px 14px 20px;
    background-color: dodgerblue;
}
.panel-default > .panel-heading {
    background-color: #ffffff;
}
.video-recording {
    /* background-color: #FFFFFF!important; */
    margin-top: 10px;
}
.video-recording a ,.pay-by-mail a,.request-in-person-hearing a,.faqs a,.pay-online a{
    float: right;
    color: #0091FF;
    font-family:  'Roboto', sans-serif;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 1.25px;
    line-height: 16px;
    margin-right: 9px;
    margin-top: 4px;
}
h4.panel-title {
    padding: 16px 0px 16px 0 px;
}
.panel-heading {
   padding: 17px 16px 17px 16px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
}
.padding-34 {
      padding: 16px 10px 0px 10px;
    color: rgba(0,0,0,0.87);
    font-family: 'Roboto',sans-serif;
    letter-spacing: 0.15px;
    line-height: 24px;
        font-size: 16px;
}
.video-recording span,.pay-by-mail span,.request-in-person-hearing span,.faqs span,.pay-online span {
    color: rgba(0,0,0,0.6);
    font-family:  'Roboto', sans-serif;
    font-size: 14px;
    letter-spacing: 0.25px;
    line-height: 20px;
}
.panel-title a
{
	text-decoration: none!important;
}
img.secure-icon {
    margin-left: 8px;
    margin-top: -3px;
}
.pay-online span.credit-cards
{
    padding-left: 117px
}
	

.formInput {
    background-color: #f1f1f1;
    border: 1px solid #f1f1f1;
    border-bottom: 2px solid #0091FF;
    padding: 16px 0px 15px 16px;
    width: 100%;
    color: rgba(0,0,0,0.38);
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    letter-spacing: 0.15px;
    line-height: 24px;
    border-radius: 4px 4px 0 0;
}
.cardDetails {
    background-color: #f1f1f1;
    border: 1px solid #f1f1f1;
    border-bottom: 2px solid #0091FF;
    padding: 16px;
    width: 100%;
    color: rgba(0,0,0,0.5);
    font-family: 'Roboto', sans-serif;
    font-size: 12px;
    letter-spacing: 0.4;
    line-height: 24px;
    letter-spacing: 0.4px;
    line-height: 16px;
    border-radius: 4px 4px 0 0;
}
.online-payment .required {
    color: rgba(0,0,0,0.6);
    font-family: 'Roboto', sans-serif;
    font-size: 12px;
    letter-spacing: 0.4px;
    line-height: 16px;
    margin-left: 16px;
    margin-bottom: 13px!important;
    display: block;
    margin-top: 3px;
}
.online-payment span.valid-card-number {
    color: #B00020;
    font-family: 'Roboto', sans-serif;
    font-size: 12px;
    letter-spacing: 0.4px;
    line-height: 16px;
    margin-bottom: 13px!important;
    display: block;
    margin-top: 3px;
    margin-left: 16px;
    font-weight: bold
}
.online-payment input.pay-amountbtn {
    background-color: dodgerblue;
    border: 1px solid dodgerblue;
    width: 100%;
    padding: 16px 67px 17px 67px;
    color: #FFFFFF;
    font-family:'Roboto', sans-serif;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 1.25px;
    line-height: 16px;
    text-align: center;
    border-radius: 4px;
}
.main-body-class-reqest-in-person {
    padding: 7px 1px 16px 1px;
}
.main-body-class-reqest-in-person .request-of-copy p, .address p {
    color: rgba(0,0,0,0.87);
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    letter-spacing: 0.15px;
    line-height: 24px;
}
.request-of-copy,.mail-body {
    margin-bottom: 30px;
}
.address {
    margin-bottom: 32px;
}
.brief-note p,.brief-note2 p {
    color: #000000;
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    letter-spacing: 0.25px;
    line-height: 20px;
   
}
.brief-note
{
	 padding-bottom: 31px;
	 border-bottom: 1px solid #979797;
}
.common-issues h3{
    color: #000000;
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    letter-spacing: 0.25px;
    line-height: 20px;
    margin-top: 38px;
    margin-bottom:20px;
}
.common-issues p.enclose-copy{
    color: #000000;
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    letter-spacing: 0.25px;
    line-height: 22px;
    margin-top: 7px;
    margin-bottom:24px;
}
.common-issues h4 {
    color: #000000;
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    font-weight: bold;
    letter-spacing: 0.25px;
    line-height: 20px;
    margin-bottom: 7px;
}
h4.payable-to {
    color: rgba(0,0,0,0.87);
    font-family: 'Roboto', sans-serif;
    font-size: 16px;
    letter-spacing: 0.15px;
    line-height: 24px;
    margin-bottom: 22px;
}
.main-body-class-reqest-in-person {
    /* padding: 7px 1px 16px 1px; */
    padding: 10px;
}
.panel-group {
    margin-bottom: 16px!important;
}
.panel-body {
    padding: 16px!important;
    box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.2);
}
.padding-bottom-100 {
    padding-bottom: 100px;
}


@media screen and (-webkit-min-device-pixel-ratio:0) 
{ /* Safari only override */ 
	::i-block-chrome, .violation-number h3, .violation-plate h3, .violation-date h3

	{ 
		font-weight: 500;
		
	} 
	.due-date p, .Total-due-amount p 
	{
		font-weight: 500;
	}
	.due-date h3, .Total-due-amount h3
	{
		font-weight: 500;
	}
}
	</style>
</head>
<body>
<div class="container">
<div class="header">
<h3>VIDEO ENFORCEMENT</h3>

<h4>Automated Stop Sign Enforcement Violation</h4>
</div>

<div class="violations-information">
<div class="row">
<div class="col-md-4">
<div class="violation-number">
<p><b>VIOLATION</b></p>

<h3><b>1910060000</b></h3>
</div>
</div>

<div class="col-md-4">
<div class="violation-plate">
<p><b>PLATE</b></p>

<h3><b>HKV3140</b></h3>
</div>
</div>

<div class="col-md-4">
<div class="violation-date">
<p><b>VIOLATION DATE</b></p>

<h3><b>SEP 16 19</b></h3>
</div>
</div>
</div>
</div>
<!--End of violations-information-->

<div class="amount-due">
<div class="row">
<div class="col-md-4">
<div class="due-date">
<p><b>DUE DATE</b></p>

<h3><b>FEB 23 2020</b></h3>
</div>
</div>

<div class="col-md-4">
<div class="Total-due-amount">
<p><b>AMOUNT DUE</b></p>

<h3><b>$50.00</b></h3>
</div>
</div>

<div class="col-md-4">
<div class="pay-now"><a class="btn btn-info" href="#">PAY NOW</a></div>
</div>
</div>
</div>
<!--End of amount due-->

<div class="panel-group video-recording">
<div class="video-recording">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><span>Video recording</span> <a data-toggle="collapse" href="#video-recording-body">OPEN</a></h4>
</div>

<div class="panel-collapse collapse" id="video-recording-body">
<div class="video-of-evidence">
<video controls="" width="100%"><source src="mov_bbb.mp4" type="video/mp4" /> <source src="video/evidence-video.ogg" type="video/ogg" /> Your browser does not support HTML5 video.</video>
</div>
</div>
</div>
</div>
</div>
<!--End of video recording-->

<div class="panel-group">
<div class="pay-online">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><span>Pay online<img class="secure-icon" src="/cms/public/images/ticket/images/secure.png" /></span> <span class="credit-cards"><img src="/cms/public/images/ticket/images/35x25.png" /></span> <a data-toggle="collapse" href="#pay-online-body">OPEN</a></h4>
</div>

<div class="panel-collapse collapse" id="pay-online-body">
<div class="panel-body">
<div class="online-payment">
<form action="#" method="post"><input class="formInput" id="cardname" name="cardname" placeholder="Name on card" type="text" /><br />
<span class="required">Required</span> <input class="formInput" id="cardnumber" name="cardnumber" placeholder="Card number" type="text" /><br />
<span class="valid-card-number">Enter a valid card number</span>

<div class="row card-details">
<div class="col-md-4">
<div class="expiry-month"><input class="cardDetails" id="month" name="month" placeholder="Expration month" type="text" /><br />
<span class="required">Required</span></div>
</div>

<div class="col-md-4">
<div class="year"><input class="cardDetails" id="year" name="year" placeholder="Expration year" type="text" /><br />
<span class="required">Required</span></div>
</div>

<div class="col-md-4">
<div class="cvv"><input class="cardDetails" id="cvv" name="cvv" placeholder="CVV" type="text" /><br />
<span class="required">Required</span></div>
</div>
</div>
<!--End of row--> <input class="formInput" name="cardname" placeholder="Email address" type="email" /><br />
<span class="required">Enter email address to receive payment confirmation</span> <input class="pay-amountbtn" name="pay-fine-amount" type="submit" value="PAY $50.00" /></form>
</div>
<!--End of online pay--></div>
<!--End of panel body---></div>
</div>
</div>
</div>
<!--End of pay-online-->

<div class="panel-group">
<div class="pay-by-mail">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><span>Pay by mail</span> <a data-toggle="collapse" href="#pay-by-mail-body">OPEN</a></h4>
</div>

<div class="panel-collapse collapse" id="pay-by-mail-body">
<div class="panel-body">
<div class="padding-34">
<div class="request-of-copy mail-body">
<p>Follow the instructions on the ticket. Enclose a check or<br />
money order for the full amount due. Do NOT send cash.<br />
Don&rsquo;t include any correspondence in the envelope other than<br />
your payment. To ensure proper credit please include the<br />
stub with your payment which includes the violation number.</p>
</div>

<div class="address">
<h4 class="payable-to"><b>Make Payable to</b></h4>

<p><b>VILLAGE OF GREAT NECK</b><br />
P.O. BOX 2222<br />
GREAT NECK, NY 11021</p>
</div>

<div class="brief-note2">
<p>Please note: The address is for mailing correspondence through postal mail. Walk-ins will not be seen at this location.</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!--End of pay-by-mail-->

<div class="panel-group">
<div class="request-in-person-hearing">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><span>Request in-person hearing date</span> <a data-toggle="collapse" href="#request-in-person-hearing-body">OPEN</a></h4>
</div>

<div class="panel-collapse collapse" id="request-in-person-hearing-body">
<div class="panel-body">
<div class="main-body-class-reqest-in-person">
<div class="request-of-copy">
<p>Return a copy of your ticket and a letter explaining why you should be found not guilty of the violation.</p>
&nbsp;

<p>Attach copies of any evidence that you wish to present.</p>
&nbsp;

<p>Make sure to keep copies of everything that you send for your own records and mail your request to:</p>
</div>

<div class="address">
<p><b>VILLAGE OF GREAT NECK</b><br />
P.O. BOX 2222<br />
GREAT NECK, NY 11021</p>
</div>

<div class="brief-note">
<p>Please note: The address is for mailing correspondence through postal mail. Walk-ins will not be seen at this location.</p>
</div>

<div class="common-issues">
<h3><b>COMMON REASONS FOR DISPUTING A TICKET</b></h3>

<h4>Vehicle or plates was stolen, lost, sold, transferred vehicle defense</h4>

<p class="enclose-copy">Enclose a copy of either 1) the Police Stolen Vehicle Report or the Police Stolen/Lost Plate(s) Report obtainable at the police precinct where the theft/loss was reported, or 2) provide proff of sale<br />
including name and address of the new owner and (if applicable),<br />
proof of insurance cancellation or transfer for that vehicle or proof of plate surrender. (Voluntary Surrender of Plate(s) Report can be<br />
obtained from your local DMV). NOTE: If you are submitting either of<br />
the police reports or proof of sale to support your claim, then ONLY<br />
the violations listed on the notice issued on or after the date you<br />
made the official report or sold your vehicle may be dismissed. If a ,<br />
violation was issued PRIOR to the report date and you are<br />
disclaiming responsibility, then we require a fully detailed statement<br />
plus the subsequent police report(s), as well as proof of insurance<br />
cancellation when applicable.</p>

<h4>My vehicle but I was not the driver</h4>

<p class="enclose-copy">Please note, the vehicle identified bears a license plate registered or leased in your name. All registered ownsers are legally responsible<br />
for this violation. Points will not be assessed agaist the registered<br />
owner or the designated driver for this violation.</p>

<h4>Death of the registrant</h4>

<p class="enclose-copy">The death of the registrant prior to or within 90 days of the issuance of the ticket is a total defense to any ticket. You will need to submit the death certificate as proof.</p>

<h4>Repeat violations</h4>

<p class="enclose-copy padding-bottom-100">This defense may be available to dismiss a duplicate ticket if the duplicate ticket was issued on the same day, for the same violation, at the same location, within three hours of this first ticket. You can receive a similar ticket every three hours.</p>
</div>
</div>
<!--main-body-class-reqest-in person--></div>
<!--End of panel body---></div>
</div>
</div>
</div>
<!--End of request-in-person-hearing-->

<div class="panel-group">
<div class="faqs">
<div class="panel panel-default">
<div class="panel-heading">
<h4 class="panel-title"><span>Frequently asked questions</span> <a data-toggle="collapse" href="#faqs-body">OPEN</a></h4>
</div>

<div class="panel-collapse collapse" id="faqs-body">
<div class="panel-body">Panel Body</div>
</div>
</div>
</div>
</div>
<!--End of faqs--></div>
<!--End of container--><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script><script type="text/javascript">
		$('.panel-collapse').on('shown.bs.collapse',function(){
	    	//$(this).text('CLOSE');
	    	 $( this ).parent('.panel-default').find('.panel-title a').text('CLOSE');
		});
		$('.panel-collapse').on('hidden.bs.collapse',function(){
		    //$('#panelbtn').text('OPEN');
		    $( this ).parent('.panel-default').find('.panel-title a').text('OPEN');
	    });
	</script></body>
</html>