<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>STOP FOR KIDS - Stop Sign Enforcement for Protecting Our Children</title>
    <!-- Favicon-->
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
    <!-- Bootstrap Core Css -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://videoenforcement.com/cms/public/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!--<link href="./style.css" rel="stylesheet">-->
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css?family=Roboto:400,400i,500,700&display=swap');
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
        .header {
            border-radius: 4px;
            background-color: #FFFFFF;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.2);
            margin-top: 20px;
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
        .tickt-stop-text{
            margin:32px 0 16px 0;
        }
        .tickt-stop-text p{
            font-size: 16px;
            line-height: 24px;
            letter-spacing: 0.15px;
            color: rgba(0,0,0,0.87);
            font-family: Roboto;
            font-weight: 500;
        }
        .ticket-plate-box{
            border-radius: 4px;
            background-color: #FFFFFF;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.2);
            position:relative;

        }
        .ticket-plate{
            padding-top:32px;
        }
        .ticket-plate-inner{
            text-align:center;
        }
        form{
            position: relative;
        }
        .formInput{
            border-radius: 4px 4px 0 0;
            background-color: #f1f1f1 !important;
            border: none;
            margin-right: 40px;
            padding: 22px 0px 10px 18px !important;
            letter-spacing: 0.15px;
            width:202px;
            
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            line-height: 24px;
        }
        span.required-violation {
            position: absolute;
            z-index: 999;
            top: 38px;
            left: 10px;
            /*right: 137px;*/
            text-align: left;
        }
        span.required-pin {
            position: absolute;
            z-index: 999;
            top: 39px;
            left: 10px;
            /*right: 12px;*/
            text-align: left;
            /* width: 73px; */
        }
        .formInput.formInput-right{
            margin:0;
            width:72px;
        }
        .sunmit-button-inner {
            text-align: left;
        }
        .sunmit-button {
            /* margin-bottom: 32px; */
            padding-bottom: 32px;
        }
        lable.continue {
            position: absolute;
            left:10px;
            padding-left: 10px;
            padding-top: 15px;

            color: #FFFFFF;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 1.25px;
            line-height: 16px;
        }
        lable.continue span {
            padding-left: 6px;
            padding-right: 6px;
            font-weight: 600;
        }

        .required-violation, .required-pin {
            color: #00000099;
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            letter-spacing: 0.4px;
            line-height: 16px;
        }
        .ticket-plate .sunmit-button-inner {
            padding-top: 44px !important;
            position:relative;
            text-align:center;
            padding-top: 32px;
            position: relative;
            text-align: center;
            /*width: 300px;*/
            /* margin: 0 auto;*/
        }
        .sunmit-button-inner input[type="submit"] {
            width: 292px;
            background: #0091ff;
            padding: 11px;
            border: 1px solid #0091ff;
            border-radius: 4px;
            text-align: left;
            font-size: 14px;
            color: #fff;
            font-weight: 500;
            letter-spacing: 1.25px;
            line-height: 16px;
        }
        .plate-dash.line {
            height: 5px;
            width: 22.5px;
            background: #000;
            display: inline-block;
            margin-right: 10px;
        }

        label {
            color: #999;
            font-size: 16px;
            font-weight: normal;
            position: absolute;
            pointer-events: none;
            left: 18px;
            top: -15px;
            transition: 0.2s ease all;
            -moz-transition: 0.2s ease all;
            -webkit-transition: 0.2s ease all;
            margin-top: 10px;
            font-size: 16px;
            letter-spacing: 0.4px;
            line-height: 16px;
            margin-top: 10px;
        }

        input.floating-input.formInput:focus, input.floating-input.formInput:not([value=""]):valid {
            outline: none;
            border-bottom: 2px solid #0091FF;
        }
        .floating-label{
            position:relative;
        }
        .floating-input:focus ~ label, .floating-input:not(:placeholder-shown) ~ label {
            top:-32px;
            font-size:12px;
            color: #0091FF;
        }

        .floating-select:focus ~ label , .floating-select:not([value=""]):valid ~ label {
            top: -29px;
            font-size: 14px;
            color: #0091FF;
            /*color: rgba(0,0,0,0.6);*/
            font-family: Roboto;
            font-size: 13px;
            letter-spacing: 0.4px;
            line-height: 16px;
        }
        /* active state */
        .floating-input:focus ~ .bar:before, .floating-input:focus ~ .bar:after, .floating-select:focus ~ .bar:before, .floating-select:focus ~ .bar:after {
            width:50%;
        }
        .search-by-plate {
            margin-top: 32px;
            text-align: center;
        }
        .search-by-plate-inner {
            text-align: center;
            margin-top: 32px;
            margin-bottom: 15px;
            text-align: center;
            color: #0091FF;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 1.25px;
            line-height: 16px;
        }
        .search-by-plate-inner i.fa.fa-search {
            padding-right: 10px;
        }
        .error {
            position: absolute;
            /* top: 201px; */
            top: 93px;
            left: 294px;
            color: red;
        }
        .floating-label-first::after{
            background: black;
            position: absolute;
            content: "";
            width: 21px;
            height: 5px;
            /* left: 102px; */
            right: 12px;
            top: 5px;
        }
        
        .plate_link {
            padding: 0 5px;
        }
        
		.plate_link:hover{
			text-decoration: none;
		}
		
		.footer {
            height: 100px;
            margin-top: 30px;
        }

        .footer .content {
            margin-top: auto;
            margin-bottom: auto;
            display: flex;
            align-items: center;
            justify-content: center;
            /* height: 100%; */
            width: 100%;
        }

        .footer div.content:nth-child(1) {
            height: 10px;
        }

        .footer div.content:nth-child(2) {
            height: 50px;
        }
        
        .container {
            min-height: 90vh;
        }
        
        @media only screen and (min-width: 800px){
            .container {
                width: 900px !important;
                padding:15px;
            }
        }
        @media only screen and (max-width: 425px){
            .formInput{
                width:138px;
            }
            label{
                font-size:14px;
            }
            .label-violation-no{
                left: 13px;
            }
            .sunmit-button-inner input[type="submit"]{
                width:264px;
            }
            span.required-violation {
                right: 80px;
            }
            lable.continue {
                left: 27px;
            }
        }
        
        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

    </style>
	<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-KFG5D94');</script>
<!-- End Google Tag Manager -->
</head>

<body class="theme-red">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KFG5D94"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="container">
        <div class="header">
            <h3>Stop for Kids</h3>
            <h4>Stop Sign Enforcement for Protecting Our Children</h4>
        </div>

        <div class="tickt-stop-text">
            <p>Welcome to Stop for Kids. This site is a service provided to your local municipality to prevent injury and death due to STOP sign violations.</p>
            <p>If you received a STOP sign ticket, you can pay or dispute it online here, or by mail. To avoid penalties, we must receive your ticket payment within 30 days of the notice date.</p>

        </div>

        <div class="ticket-plate-box">
            <div class="ticket-plate">
                <div class="ticket-plate-inner">
                    <form  novalidate  onsubmit="event.preventDefault(); validate_input();">
                        <span class="floating-label floating-label-last floating-label-first">
                            <input type="text" class="floating-input formInput" required name="plate_number" placeholder=" " id="plate_number"/>
                            <label class="label-violation-no">Plate</label>
                            <span class="required-violation">Enter plate number</span>
                        </span>
                        <span class="floating-label floating-label-last">
							<?php $states = array("AL", "AK", "AZ","AR", "CA", "CO", "CT", "DE","FL", "GA","HI", "ID", "IL","IN", "IA", "KS", "KY", "LA","ME", "MD","MA", "MI", "MN","MS", "MO", "MT", "NE", "NV","NH", "NJ","NM", "NY", "NC","ND", "OH", "OK", "OR", "PA","RI", "SC", "SD", "TN", "TX","UT", "VT", "VA", "WA", "WV","WI", "WY"); ?>
							<select required class="floating-input formInput formInput-right" name="state" id="state">
								<?php foreach($states as $state){ ?>
								<option value="<?= $state; ?>"<?=  ($state == 'NY' ? ' selected="selected"' : ''); ?>><?= $state; ?></option>
								<?php
								}
								?>
							</select>
                            <label>State</label>
                            <span class="required-pin">State</span>
                        </span>
                        <div class="sunmit-button">
                            <div class="sunmit-button-inner">
                                <input type="submit" Value=" > CONTINUE" name="btn_validate" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="search-by-plate">
            <div class="search-by-plate-inner">
                <a href="index.php" class="plate_link"><i class="fa fa-search"></i>SEARCH BY VIOLATION NUMBER</a>
            </div>
        </div>
    </div>
    
    <footer class='footer'>
        <div class='content'>
            <?php echo date('Y'); ?> Copyright STOP FOR KIDS ®
        </div>
        <div class="content">
            <a href="/index" class="plate_link"><i class="fa fa-search"></i>Home</a> | <a href="/about" class="plate_link"><i class="fa fa-search"></i>About</a> | <a href="/municipalities" class="plate_link"><i class="fa fa-search"></i>For Municipalities</a>
        </div>
    </footer>

    <script type="text/javascript">
    $(function(){
        $('#violation_number').inputmask('9999999999', {placeholder:''});
        $('#pin').inputmask('999', {placeholder:''});
    });
        function validate_input() {
            var plate_number = $("#plate_number").val();
            var state = $("#state").val();
            
                $(".required-violation").text("Enter plate number");
                $(".required-violation").css({"color":"#00000099", "white-space":"nowrap"});
                $(".required-pin").text("State");
                $(".required-pin").css({"color":"#00000099", "white-space":"nowrap"});         
				$(".required-pin").show();
                
            if(plate_number.length === 0) {
                $(".required-violation").text("Enter valid plate number");
                $(".required-violation").css({"color":"#DC0300", "white-space":"nowrap"});
                $("#plate_number").focus();
                return false;
            }

            if(state.length === 0) {
                // document.getElementById("pin").setCustomValidity("Enter valid pin number");
                $(".required-pin").text("Select State");
                $(".required-pin").css({"color":"#DC0300", "white-space":"nowrap"});
                $("#state").focus();
                return false;
            }

            $.ajax({
                type: "POST",
                url: "validate.php",
                data : {
                    'action': 'plate_no',
                    'plate_number': plate_number,
                    'state': state
                },
                success: function(result) {
                    result = jQuery.parseJSON(result);
                    if(result.validate === false) {
                        $(".required-violation").text("Enter a valid Plate number");
                        $(".required-violation").css({"color":"#DC0300", "white-space":"nowrap"});
                        $(".required-pin").hide();
                        return false;
                    }
                    else {
                        var url = "/violations/plate/" + plate_number + "-" + state + "";
                        if(result.status == 2) {
                            url += '#decision';
                        } else {
                            url += '#video-recording-body';
                        }
                        location.href = url;
                    }

                },
                error: function(error) {
                }
            });

            return false;
        }

        $("#violation_number").change(function() {
            var number = $("#violation_number").val();
            console.log(number);
            if(number.length === 0) {
                $(".required-violation").text("Enter valid violation number");
                $(".required-violation").css({"color":"#DC0300", "white-space":"nowrap"});
                $("#violation_number").focus();
            } else {
                $(".required-violation").text("10 digit number");
                $(".required-violation").css({"color":"#00000099", "white-space":"nowrap"});
            }
        });

        $("#pin").change(function() {
            var number = $("#pin").val();
            console.log(number);
            if(number.length === 0) {
                $(".required-pin").text("Enter valid pin");
                $(".required-pin").css({"color":"#DC0300", "white-space":"nowrap"});
                $("#pin").focus();
            } else {
                $(".required-pin").text("3 digit number");
                $(".required-pin").css({"color":"#00000099", "white-space":"nowrap"});
            }
        });


    </script>
</div>

</body>
</html>