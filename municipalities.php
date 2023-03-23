<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>STOP FOR KIDS - Stop Sign Cameras For Municipalities</title>
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

        *,
        *:before,
        *:after {
            -webkit-box-sizing: inherit;
            -moz-box-sizing: inherit;
            box-sizing: inherit;
        }

        body {
            margin: 0px;
            padding: 0px;
            background: #f1f1f1;
        }

        .header {
            border-radius: 4px;
            background-color: #FFFFFF;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.14), 0 2px 1px -1px rgba(0, 0, 0, 0.12), 0 1px 3px 0 rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }

        .header h3 {
            color: rgba(0, 0, 0, 0.87);
            font-family: 'Roboto', sans-serif;
            font-size: 24px;
            letter-spacing: 0.18px;
            line-height: 24px;
            text-align: center;
            padding-top: 16.43px;
            margin: 0px !important;
        }

        .header h4 {
            color: rgba(0, 0, 0, 0.87);
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
            letter-spacing: 0.15px;
            line-height: 24px;
            text-align: center;
            padding-bottom: 16px;
            margin-top: 8px;
            margin-bottom: 0px;
        }

        .tickt-stop-text {
            margin: 32px 0 16px 0;
        }

        .tickt-stop-text p {
            font-size: 16px;
            line-height: 24px;
            letter-spacing: 0.15px;
            color: rgba(0, 0, 0, 0.87);
            font-family: Roboto;
            font-weight: 500;
        }

        .ticket-plate-box {
            border-radius: 4px;
            background-color: #FFFFFF;
            box-shadow: 0 1px 1px 0 rgba(0, 0, 0, 0.14), 0 2px 1px -1px rgba(0, 0, 0, 0.12), 0 1px 3px 0 rgba(0, 0, 0, 0.2);
            position: relative;

        }

        .ticket-plate {
            padding-top: 32px;
        }

        .ticket-plate-inner {
            text-align: center;
        }

        form {
            position: relative;
        }

        .formInput {
            border-radius: 4px 4px 0 0;
            background-color: #f1f1f1 !important;
            border: none;
            margin-right: 40px;
            padding: 22px 0px 10px 18px !important;
            letter-spacing: 0.15px;
            width: 202px;

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

        .formInput.formInput-right {
            margin: 0;
            width: 72px;
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
            left: 10px;
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

        .required-violation,
        .required-pin {
            color: #00000099;
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            letter-spacing: 0.4px;
            line-height: 16px;
        }

        .ticket-plate .sunmit-button-inner {
            padding-top: 44px !important;
            position: relative;
            text-align: center;
            padding-top: 32px;
            position: relative;
            text-align: center;
            /*width: 300px;*/
            /* margin: 0 auto;*/
        }

        .sunmit-button-inner input[type="submit"] {
            width: 292px;
            background: #0091ff;
            padding: 16px 67px 17px 67px;
            border: 1px solid #0091ff;
            border-radius: 4px;
            text-align: center;
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

        .floating-input.formInput:focus/*,
        .floating-input.formInput:not([value=""]):valid*/ {
            outline: none;
            border-bottom: 2px solid #0091FF;
        }

        .floating-label {
            position: relative;
        }

        .floating-input:focus~label,
        .floating-input:not(:placeholder-shown)~label {
            top: -32px;
            font-size: 12px;
            color: #0091FF;
        }

        .floating-select:focus~label,
        .floating-select:not([value=""]):valid~label {
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
        .floating-input:focus~.bar:before,
        .floating-input:focus~.bar:after,
        .floating-select:focus~.bar:before,
        .floating-select:focus~.bar:after {
            width: 50%;
        }

        .search-by-plate {
            margin-top: 32px;
            text-align: center;
        }

        .search-by-plate-inner {
            text-align: center;
            margin-top: 32px;
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

        .floating-label-first::after {
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

        .plate_link:hover {
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

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        span.required-firstname,
        span.required-email,
        span.required-phone {
            position: absolute;
            z-index: 999;
            top: 38px;
            left: 10px;
            /*right: 137px;*/
            text-align: left;
        }

        .required-firstname,
        .required-email,
        .required-phone {
            color: #00000099;
            font-family: 'Roboto', sans-serif;
            font-size: 12px;
            letter-spacing: 0.4px;
            line-height: 16px;
        }

        .form {
            padding: 0 180px;
        }

        .input-block {
            margin-top: 50px;
            width: 100%;
            display: flex;
            column-gap: 30px;
        }

        .input-block input,
        .floating-label.floating-label-last {
            width: 100%;
        }

        .input-block .left,
        .input-block .right {
            width: 50%;
        }

        .floating-input.formInput {
            width: 100%;
        }

        label.label-comment {
            top: -82px;
        }

        #comment:focus~label,
        #comment:not(:placeholder-shown)~label {
            top: -97px;
            font-size: 12px;
            color: #0091FF;
        }
        
        @media only screen and (min-width: 800px) {
            .container {
                width: 900px !important;
                padding: 15px;
            }
        }

        @media only screen and (max-width: 425px) {
            .formInput {
                width: 138px;
            }

            label {
                font-size: 14px;
            }

            .label-violation-no {
                left: 13px;
            }

            .sunmit-button-inner input[type="submit"] {
                width: 264px;
            }

            span.required-firstname,
            span.required-email,
            span.required-phone {
                right: 80px;
            }

            lable.continue {
                left: 27px;
            }
        }
        
        @media screen and (max-width: 767px) {
            .form {
                padding: 0 10px;
            }
        }
    </style>

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KFG5D94');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body class="theme-red">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KFG5D94" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="container">
        <div class="header">
            <h3>Stop for Kids</h3>
            <h4>Stop Sign Enforcement for Protecting Our Children</h4>
        </div>

        <div class="tickt-stop-text">
            <h3>For Municipalities</h3>
            <p>If you are a municipality interested in piloting the Stop for Kids program, please fill out the form below. We will get back to you to discuss your needs and our solution in further detail.</p>
        </div>

        <div class="ticket-plate-box">
            <div class="ticket-plate">
                <div class="ticket-plate-inner">
                    <form class="form" novalidate onsubmit="event.preventDefault(); validate_input();">
                        <div class="form-input-field">
                            <span class="floating-label floating-label-last">
                                <input type="text" class="floating-input formInput" id="municipality_name" name="municipality_name" placeholder=" " />
                                <label>Name of municipality</label>
                            </span>
                            <div class="input-block">
                                <div class="left">
                                    <span class="floating-label floating-label-last">
                                        <input type="text" class="floating-input formInput" id="first_name" name="first_name" placeholder=" " required />
                                        <label>First name</label>
                                        <span class="required-firstname">Required</span>
                                    </span>
                                </div>
                                <div class="right">
                                    <span class="floating-label floating-label-last">
                                        <input type="text" class="floating-input formInput" id="last_name" name="last_name" placeholder=" " />
                                        <label>Last name</label>
                                    </span>
                                </div>
                            </div>
                            <div class="input-block">
                                <div class="left">
                                    <span class="floating-label floating-label-last">
                                        <input type="email" class="floating-input formInput" id="email" name="email" placeholder=" " required />
                                        <label>Email</label>
                                        <span class="required-email">Required</span>
                                    </span>
                                </div>
                                <div class="right">
                                    <span class="floating-label floating-label-last">
                                        <input type="text" class="floating-input formInput" id="phone" name="phone" placeholder=" " required />
                                        <label>Phone</label>
                                        <span class="required-phone">Required</span>
                                    </span>
                                </div>
                            </div>
                            <div class="input-block" style="display: block;">
                                <span class="floating-label floating-label-last">
                                    <input type="text" class="floating-input formInput" id="city" name="city" placeholder=" " />
                                    <label>City</label>
                                </span>
                            </div>
                            <div class="input-block">
                                <div class="left">
                                    <span class="floating-label floating-label-last">
                                        <input type="text" class="floating-input formInput" id="state" name="state" placeholder=" " />
                                        <label>State</label>
                                    </span>
                                </div>
                                <div class="right">
                                    <span class="floating-label floating-label-last">
                                        <input type="text" class="floating-input formInput" id="zip" name="zip" placeholder=" " />
                                        <label>Zip</label>
                                    </span>
                                </div>
                            </div>
                            <div class="input-block" style="display: block;">
                                <span class="floating-label floating-label-last">
                                    <input type="text" class="floating-input formInput" id="role" name="role" placeholder=" " />
                                    <label>Your role</label>
                                </span>
                            </div>
                            <div class="input-block" style="display: block;">
                                <span class="floating-label floating-label-last">
                                    <textarea class="floating-input formInput" id="comment" name="comment" placeholder=" " rows="3"></textarea>
                                    <label class="label-comment">Comment</label>
                                </span>
                            </div>
                        </div>
                        <div class="sunmit-button">
                            <div class="sunmit-button-inner">
                                <input type="submit" value="SUBMIT" name="btn_validate" />
                            </div>
                        </div>
                    </form>
                </div>
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
        function ValidateEmail(input) {
            var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
            if ( input.match(validRegex) ) return true;
            return false;
        }

        function ValidatePhoneNumber(input) {
            var phoneno = /^\d{10}$/;
            if ( input.match(phoneno) ) return true;
            return false;
        }

        function validate_input() {
            var municipality_name = $("#municipality_name").val();
            var first_name = $("#first_name").val();
            var last_name  = $("#last_name").val();
            var email = $("#email").val();
            var phone = $("#phone").val();
            var city = $("#city").val();
            var state = $("#state").val();
            var zip = $("#zip").val();
            var role = $("#role").val();
            var comment = $("#comment").val();

            if (first_name.length === 0) {
                $(".required-firstname").text("Enter your first name");
                $(".required-firstname").css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
                $("#first_name").focus();
                return false;
            }
            else {
                $(".required-firstname").text("");
            }

            if (email.length === 0) {
                $(".required-email").text("Enter your email");
                $(".required-email").css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
                $("#email").focus();
                return false;
            }
            else {
                $(".required-email").text("");
                if ( !ValidateEmail(email) ) {
                    $(".required-email").text("Enter valid email");
                    $(".required-email").css({
                        "color": "#DC0300",
                        "white-space": "nowrap"
                    });
                    $("#email").focus();
                    return false;
                }
            }

            if (phone.length === 0) {
                $(".required-phone").text("Enter your phone number");
                $(".required-phone").css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
                $("#phone").focus();
                return false;
            }
            else {
                $(".required-phone").text("");
                /*
                if ( !ValidatePhoneNumber(phone) ) {
                    $(".required-phone").text("Enter valid phone number");
                    $(".required-phone").css({
                        "color": "#DC0300",
                        "white-space": "nowrap"
                    });
                    $("#phone").focus();
                    return false;
                }
                */
            }

            $('input[type="submit"]').prop('disabled', true);
            $('input[type="submit"]').val('SENDING...');

            $.ajax({
                type: "POST",
                url: "municipalities-email.php",
                data: {
                    municipality_name: municipality_name,
                    first_name: first_name,
                    last_name: last_name,
                    email: email,
                    phone: phone,
                    city: city,
                    state: state,
                    zip: zip,
                    role: role,
                    comment: comment,
                    file: 'municipalities.php'
                },
                dataType: 'json',
                success: function(result) {
                    if ( result == 'Sent' ) {
                        $('input[type="submit"]').after('<h4 style="color: green; text-align: center;">Email sent successfully</h4>');
                        $(".form-input-field").css('display', 'none');
                    } 
                    else {
                        $('input[type="submit"]').after('<h4 style="color: red; text-align: center;">Email send failed</h4>');
                        $('input[type="submit"]').prop('disabled', false);
                    }
                },
                error: function(err) {
                    if (err.status == 200 && err.responseText == 'Sent') {
                        $('input[type="submit"]').after('<h4 style="color: green; text-align: center;">Email sent successfully</h4>');
                        $(".form-input-field").css('display', 'none');
                    }
                    else {
                        $('input[type="submit"]').after('<h4 style="color: red; text-align: center;">Email send failed</h4>');
                        $('input[type="submit"]').prop('disabled', false);
                    }
                },
                complete: function(res) {
                    $('input[type="submit"]').val('SUBMIT');
                }
            });
        }
    </script>

</body>
</html>