<?php
include_once('header.php');
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

function url() {
    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        $url = "https://";
    else
        $url = "http://";

    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];

    // Append the requested resource location to the URL   
    // $url.= $_SERVER['REQUEST_URI'];    

    return $url;
}

// global $db;
$query = "SELECT a.*, b.village_court as village_court_text, b.email as village_email, b.village_logo, b.fine_amount, b.address1 as vil_address1, b.address2 as vil_address2, b.city as vil_city, b.state as vil_state, b.zip as vil_zip, (select camera_location from  `ci_cameras` b where a.camera = b.id) as camera_location FROM `ci_violations` a  left join ci_villages b on a.village_court = b.id ";

if (!empty($_REQUEST['vio_num'])) {
    $vio_num = !empty($_REQUEST['vio_num']) ? trim($_REQUEST['vio_num']) : '';
    //$vio_num = 2001141013;  
    $vio_num_arr = explode('-', $vio_num);
    $violation_number = !empty($vio_num_arr[0]) ? $vio_num_arr[0] : '';
    $pin = !empty($vio_num_arr[1]) ? $vio_num_arr[1] : '';
    //$pin = 742;

    $query .= "where a.violation_number = '$violation_number'";
    $violation_details = $db->fetch_row( $query );
} else {
    $plate_num = !empty($_REQUEST['plate_num']) ? trim($_REQUEST['plate_num']) : '';
    $plate_num_arr = explode('-', $plate_num);
    $plate = !empty($plate_num_arr[0]) ? $plate_num_arr[0] : '';
    $state = !empty($plate_num_arr[1]) ? $plate_num_arr[1] : '';

    $query .= "where a.plate = '$plate'";
    $violation_records_by_plate = $db->fetch_array( $query );
    // setup latest record array.
    $violation_details = array_pop($violation_records_by_plate);
    
    $violation_number = $violation_details['violation_number'];
    $pin = $violation_details['pin'];
}

// Violation or warning
$violation_type = ($violation_details['violation_type'] == 1 ? 'Violation' : 'Warning');
?>
<!DOCTYPE html>
<html lang="en-US">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>V-<?php echo $violation_details['violation_number'] . ' ' . $violation_details['plate'] . ' ' . $violation_details['zip']; ?></title>
    <!--<meta name="viewport" content="width=device-width, initial-scale=1">-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Tangerine" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

    <?php $style_url = url()."/violations/style.css"; ?>
    <link rel="stylesheet" href="<?php echo $style_url; ?>">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <!-- (Optional) Latest compiled and minified JavaScript translation files -->
    <!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.12.4/dist/js/i18n/defaults-*.min.js"></script>-->

    <?php
    if ($violation_details['status'] == 5) {
    ?>
        <style type="text/css">
            .panel-group,
            .pay-now {
                display: none;
            }

            .dismissed {
                padding-left: 14px;
            }

            .dismissed p {
                font-family: 'Roboto', sans-serif;
                font-size: 14px;
                font-weight: 700;
                letter-spacing: 1.5px;
                line-height: 1;
                text-transform: uppercase;
                padding-top: 20px;
                padding-bottom: 7px;
                margin-bottom: 0px;
            }

            .dismissed h3 {
                margin-top: 0px;
                font-size: 20px;
            }

            .dismissed h3 b {
                font-weight: 500;
            }
        </style>
    <?php } ?>

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

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-KFG5D94" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <div class="container" id="customecliktop">
        <div class="header">
            <h3>StopForKids.com</h3>

            <h4>Stop Sign Enforcement</h4>
        </div>

        <?php
        $violation_date = $violation_details['violation_date_new'];
        $violation_datesa = strtotime($violation_date);
        $violation_date = date('M d Y', $violation_datesa);
        ?>

        <div class="violation-info-mobile">
            <div class="violation-info-mobile-inner">
                <div class="violation-info-mobile-container">
                    <span class="mobile-label violation-number-mobile-label"><?= $violation_type; ?> number:</span>
                    <span class="mobile-value violation-number-mobile"><?= $violation_details['violation_number']; ?></span>
                </div>
                <div class="violation-info-mobile-container">
                    <span class="mobile-label plate-number-label">Plate:</span>
                    <span class="mobile-value plate-number"><?= $violation_details['plate']; ?></span>
                </div>
                <div class="violation-info-mobile-container">
                    <span class="mobile-label violation-date-mobile-label">Violation date:</span>
                    <span class="mobile-value violation-date-mobile"><?= $violation_date; ?></span>
                </div>
                <?php
                if ($violation_details['violation_type'] == 1) {
                ?>
                <div class="violation-info-mobile-container">
                    <span class="mobile-label amount-due-mobile-label">Amount due:</span>
                    <span class="mobile-value amount-due-mobile"><?= (($violation_details['payment_status'] == 1) ? 'Due Amount Paid on:' .  $violation_details['date_paid'] : '$' . $violation_details['amount_due']); ?></span>
                </div>
                <?php
                $duedue = $violation_details['due_date_new'];
                $violation_datesadue = strtotime($duedue);
                $due_date = date('M d Y', $violation_datesadue);
                ?>
                <div class="violation-info-mobile-container">
                    <span class="mobile-label due-date-label">Due date:</span>
                    <span class="mobile-value due-date"><?= $due_date; ?></span>
                </div>
                <?php if ($violation_details['status'] == 5) { ?>
                    <div>
                        <span class="mobile-label due-date-label">Status:</span>
                        <span class="mobile-value due-date">Dismissed</span>
                    </div>
                <?php
                    }
                }
                ?>

            </div>
        </div>
        <?php
        if ($violation_details['violation_type'] == 1) {
        ?>
        <div class="mobile-pay-button">
            <div class="pay-now"><?= (($violation_details['payment_status'] == 1) ? '<a href="javascript:void(0);" class="btn btn-success" style="">PAID</a>' : '<a data-toggle="collapse" href="#pay-online-body" aria-expanded="false" class="collapse in collapsed btn btn-info" style="">PAY NOW</a>'); ?></div>
        </div>
        <?php
        }
        ?>

        <div class="violations-information">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="violation-number">
                        <p><b><?= strtoupper($violation_type); ?></b></p>

                        <h3><b><?= $violation_details['violation_number']; ?></b></h3>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4">
                    <div class="violation-plate">
                        <p><b>PLATE</b></p>

                        <h3><b><?= $violation_details['plate']; ?></b></h3>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4">
                    <div class="violation-date">
                        <p><b>VIOLATION DATE</b></p>

                        <h3><b><?= $violation_date; ?></b></h3>
                    </div>
                </div>
            </div>
        </div>
        <!--End of violations-information-->
        <?php
        if ($violation_details['violation_type'] == 1) {
        ?>
            <div class="amount-due">
                <div class="row">
                    <div class="col-md-4">
                        <div class="due-date">
                            <?php
                            $duedue = $violation_details['due_date_new'];
                            $violation_datesadue = strtotime($duedue);
                            $due_date = date('M d Y', $violation_datesadue);
                            ?>
                            <p><b>DUE DATE</b></p>

                            <h3><b><?= $due_date; ?></b></h3>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="Total-due-amount">
                            <p><b>AMOUNT DUE</b></p>

                            <h3><b>$<?= $violation_details['amount_due']; ?></b></h3>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <?php if ($violation_details['status'] == 5) { ?><div class="dismissed">
                            <p>Status</p>
                            <h3><b>Dismissed</b></h3>
                        </div><?php } ?>
                        <div class="pay-now"><?= (($violation_details['payment_status'] == 1) ? '<a href="javascript:void(0);" class="btn btn-success" style="">PAID</a>' : '<a data-toggle="collapse" href="#pay-creditcard" aria-expanded="false" class="collapse in collapsed btn btn-info" style="">PAY NOW</a>'); ?></div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
        <?php
        if ($violation_details['payment_status'] == 1 || $violation_details['status'] == 5) { ?>
            <div class="paid_text">
                <div class="row">
                    <div class="col-md-7">
                        <span>
                            <?php
                            if ($violation_details['status'] == 5)
                                echo 'This ticket has been dismissed.';
                            else
                                echo 'This ticket has been paid in full.';
                            ?>
                        </span>
                    </div>
                </div>
            </div>
        <?php
        }

        if ($violation_details['payment_status'] == 0 && $violation_details['status'] != 5) {
            if ($violation_details['violation_type'] == 1) {
        ?>
                <div class="panel-group pay-online-main">
                    <div class="pay-online">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title for-moibile">
                                    <span>Pay</span>
                                    <span class="credit-cards">
                                    <img src="/cms/public/images/ticket/images/35x25.png" />
                                </span>
                                    <a class="pay-online-open pay-online-open-mobile" data-toggle="collapse" href="#pay-creditcard">OPEN</a>
                                </h4>
                            </div>

                            <div class="panel-collapse collapse" id="pay-creditcard">
                                <div class="panel-body">
                                    <div class="online-payment">
                                        <form action="" id="floating-form" class="stripe_form form-validate" method="post" novalidate>
                                            <div class="floating-label">
                                                <input class="floating-input formInput text" id="cardname" required type="text" placeholder=" " />
                                                <label>Name on card</label>
                                                <span class="required">Required</span>
                                            </div>

                                            <div class="floating-label">
                                                <input class="floating-input formInput credit-card" id="cardnumber" data-stripe="number" required name="cardnumber" type="text" placeholder=" " />
                                                <label>Card number</label>
                                                <span class="required">Required</span>
                                            </div>

                                            <div class="row card-details">
                                                <div class="col-md-4 col-xs-4">
                                                    <div class="expiry-month">
                                                        <select class="selectpicker floating-input formInput " id="month" name="month" data-stripe="exp_month" data-width="100%" data-style="btn-primary-outline" style="text-align: left;">
                                                            <option value="0" disabled selected>--</option>
                                                            <option value="01">JAN</option>
                                                            <option value="02">FEB</option>
                                                            <option value="03">MAR</option>
                                                            <option value="04">APR</option>
                                                            <option value="05">MAY</option>
                                                            <option value="06">JUN</option>
                                                            <option value="07">JUL</option>
                                                            <option value="08">AUG</option>
                                                            <option value="09">SEP</option>
                                                            <option value="10">OCT</option>
                                                            <option value="11">NOV</option>
                                                            <option value="12">DEC</option>
                                                        </select>
                                                        <label class="custom-month-label month-label">Month</label>
                                                        <span class="required">Required</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-4">
                                                    <div class="year">
                                                        <select class="floating-input formInput selectpicker" id="year" name="year" data-stripe="exp_year" data-width="100%" data-style="btn-primary-outline">
                                                            <option value="" disabled selected>--</option>
                                                            <?php
                                                            for ($y = 0; $y < 20; $y++) {
                                                                echo ("<option value=\"" . (20 + $y) . "\">" . (2020 + $y) . "</option>");
                                                            }
                                                            ?>
                                                        </select>
                                                        <label class="month-year-label">Year</label>
                                                        <span class="required">Required</span>
                                                    </div>
                                                </div>

                                                <div class="col-md-4 col-xs-4">
                                                    <div class="cvv">
                                                        <input class="floating-input formInput text" data-stripe="cvc" required id="cvv" name="cvv" placeholder=" " />
                                                        <label>cvv</label>
                                                        <span class="required">Required</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--End of row-->

                                            <div class="floating-label floating-label-last">
                                                <input class="floating-input formInput" id="email" name="email" placeholder=" " type="email" required />
                                                <label>Email address</label>
                                                <span class="required">Enter email address to receive payment confirmation</span>
                                            </div>

                                            <input class="pay-amountbtn" name="pay-fine-amount" type="submit" value="PAY $<?php echo $violation_details['amount_due']; ?>" />
                                            <p class="payment-errors"></p>
                                        </form>
                                    </div>
                                    <!--End of online pay-->
                                </div>
                                <!--End of panel body-->
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        ?>
            <!--End of pay-online-->
            <!-- start of video recording -->
            <div class="panel-group video-recording">
                <div class="video-recording">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><span>Video recording</span> <a data-toggle="collapse" id="customeclik" href="#video-recording-body">OPEN</a></h4>
                        </div>

                        <div class="panel-collapse collapse" id="video-recording-body">
                            <div class="video-of-evidence">
                                <?php
                                //echo $violation_details['violation_video'];
                                $URL = $violation_details['violation_video'];

                                if (strpos($violation_details['violation_video'], 'https://s3.amazonaws.com/scbw-openalpr-policy/') !== false) {
                                    $URL = str_replace("https://s3.amazonaws.com/scbw-openalpr-policy/", "https://scbw.mo.cloudinary.net/", $violation_details['violation_video']);
                                }
                                if (strpos($violation_details['violation_video'], 'https://scbw-openalpr-policy.s3.amazonaws.com/') !== false) {
                                    $URL = str_replace("https://scbw-openalpr-policy.s3.amazonaws.com/", "https://scbw.mo.cloudinary.net/", $violation_details['violation_video']);
                                }
                                if (strpos($violation_details['violation_video'], 'https://sfk-output.s3.amazonaws.com/') !== false) {
                                    $URL = str_replace("https://sfk-output.s3.amazonaws.com/", "https://scbw.mo.cloudinary.net/", $violation_details['violation_video']);
                                }
                                ?>
                                <video controls="" width="100%" poster="<?= $violation_details['plate_photo']; ?>">
                                    <source src="<?= $URL; ?>" type="video/mp4" /> Your browser does not support HTML5 video.
                                </video>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of video-recording-->
            <?php
            if ($violation_details['violation_type'] == 1) {
            ?>
                <div class="panel-group">
                    <div class="pay-by-mail">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title"><span>Pay by mail</span> <a data-toggle="collapse" href="#pay-mail">OPEN</a></h4>
                            </div>
                            <div class="panel-collapse collapse" id="pay-mail">
                                <div class="panel-body">
                                    <div class="padding-34">
                                        <div class="request-of-copy mail-body">
                                            <p>Follow the instructions on the ticket. Enclose a check or
                                                money order for the full amount due. Do NOT send cash.
                                                Don&rsquo;t include any correspondence in the envelope other than
                                                your payment. To ensure proper credit please include the
                                                stub with your payment which includes the violation number.</p>
                                        </div>

                                        <div class="address">
                                            <h4 class="payable-to"><b>Make Payable to</b></h4>
                                            <p>
                                                <?php /* StopForKids.com<br /> */ ?>
                                                <b><?= $violation_details['village_court_text']; ?></b><br />
                                                <?= !empty($violation_details['vil_address1']) ? $violation_details['vil_address1'] . '<br />' : ''; ?>
                                                <?= !empty($violation_details['vil_address2']) ? $violation_details['vil_address2'] . '<br />' : ''; ?>
                                                <?= !empty($violation_details['vil_city']) ? $violation_details['vil_city'] . ', ' : ''; ?><?= !empty($violation_details['vil_state']) ? $violation_details['vil_state'] . ' ' : ''; ?> <?= !empty($violation_details['vil_zip']) ? $violation_details['vil_zip'] : ''; ?>
                                            </p>
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
            <?php
            }
            ?>

            <div class="panel-group">
                <div class="pay-by-mail">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title"><span>Dispute violation</span> <a data-toggle="collapse" href="#dispute">OPEN</a></h4>
                        </div>
                        <div class="panel-collapse collapse" id="dispute">
                            <div class="panel-body">
                                <div class="padding-34">
                                    <div class="request-of-copy mail-body">
                                        <p>Use the form below to dispute a violation. The decision will be emailed back to the email address you supplied.</p>
                                    </div>

                                    <form action="https://stopforkids.com/cms/auth/disputemail" method="post" enctype="multipart/form-data" id="disputedd">
                                        <div class="message_sucess" id="message_sucess" style="color: green; display:none;">
                                            <p>Form submitted successfully. The decision will be sent to swisscam@icloud.com within 14 days.</p>
                                        </div>
                                        <div class="message_erro" id="message_erro" style="color: red; display:none;"><b>Something went wrong in data</b></div>
                                        <div class="address">
                                            <input type="hidden" value="<?= $violation_details['violation_number']; ?>" name="voll">
                                            <input type="hidden" value="<?= $violation_details['pin']; ?>" name="pin">
                                            <input type="hidden" value="<?= $violation_details['plate']; ?>" name="palte">
                                            <input type="hidden" value="<?= $actual_link; ?>" name="link">

                                            <h4 class="payable-to"><b>Dispute Violation [ <?= $violation_details['violation_number']; ?> ]</b></h4>
                                            <div class="floating-label">
                                                <input class="floating-input formInput text" id="firstnn" name="fname" type="text" placeholder=" " />
                                                <label>Your full name:</label>
                                                <span class="required"></span>
                                            </div>
                                            <div class="floating-label">
                                                <input class="floating-input formInput text" id="semail" name="semail" type="text" placeholder=" " />
                                                <label>Email address:</label>
                                                <span class="required"></span>
                                            </div>

                                            <div class="floating-label">
                                                <textarea id="explain" name="explain" rows="4" cols="50"></textarea>
                                                <p><span>Please explain why you should be found not guilty of the stop sign violation.</span></p>
                                                <span class="required"></span>
                                            </div>

                                            <div class="floating-label">
                                                <input type="file" accept="image/png,image/jpeg,image/jpg,application/pdf" id="file" name="filed">
                                                <p><span>Attach file (jpg, png, pdf only):</span></p>
                                                <span class="required"></span>
                                            </div>
                                            <p><input class="pay-amountbtn" name="dispute-submit" type="submit" value="Submit"></p>
                                    </form>
                                </div>

                                <div class="common-issues" style="border-top: 1px solid #979797;">
                                    <h3><b>COMMON REASONS FOR DISPUTING A TICKET</b></h3>
                                    <h4>Vehicle or plates were stolen, lost, sold or transferred</h4>
                                    <p class="enclose-copy">Enclose a copy of either 1) the Police Stolen Vehicle Report
                                        or the Police Stolen/Lost Plate(s) Report obtainable at the police precinct
                                        where the theft/loss was reported, or 2) provide proof of sale including name
                                        and address of the new owner and (if applicable), proof of insurance
                                        cancellation or transfer for that vehicle or proof of plate surrender.
                                        (Voluntary Surrender of Plate(s) Report can be obtained from your local DMV).
                                        NOTE: If you are submitting either of the police reports or proof of sale to
                                        support your claim, then ONLY the violations listed on the notice issued on or
                                        after the date you made the official report or sold your vehicle may be
                                        dismissed. If a violation was issued PRIOR to the report date and you are
                                        disclaiming responsibility, then we require a fully detailed statement plus the
                                        subsequent police report(s), as well as proof of insurance cancellation when
                                        applicable.</p>
                                    <h4>My vehicle but I was not the driver</h4>
                                    <p class="enclose-copy">Please note the vehicle identified bears a license plate
                                        registered or leased in your name. All registered owners are legally responsible
                                        for this violation. Points will not be assessed against the registered owner or
                                        the designated driver for this violation.</p>
                                    <h4>Death of the registrant</h4>
                                    <p class="enclose-copy">The death of the registrant prior to or within 90 days of
                                        the issuance of the ticket is a total defense to any ticket. You will need to
                                        submit the death certificate as proof.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    <!--End of Dispute-->

    <div class="panel-group" style="display:none;">
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
                                <p>
                                    <?php /* StopForKids.com<br /> */ ?>
                                    <b><?= $violation_details['village_court_text']; ?></b><br />
                                    <?= !empty($violation_details['vil_address1']) ? $violation_details['vil_address1'] . '<br />' : ''; ?>
                                    <?= !empty($violation_details['vil_address2']) ? $violation_details['vil_address2'] . '<br />' : ''; ?>
                                    <?= !empty($violation_details['vil_city']) ? $violation_details['vil_city'] . ', ' : ''; ?><?= !empty($violation_details['vil_state']) ? $violation_details['vil_state'] . ' ' : ''; ?> <?= !empty($violation_details['vil_zip']) ? $violation_details['vil_zip'] : ''; ?>
                                </p>
                            </div>

                            <div class="brief-note">
                                <p>Please note: The address is for mailing correspondence through postal mail. Walk-ins will not be seen at this location.</p>
                            </div>

                            <div class="common-issues">
                                <h3><b>COMMON REASONS FOR DISPUTING A TICKET</b></h3>

                                <h4>Vehicle or plates was stolen, lost, sold, transferred vehicle defense</h4>

                                <p class="enclose-copy">Enclose a copy of either 1) the Police Stolen Vehicle Report or the Police Stolen/Lost Plate(s) Report obtainable at the police precinct where the theft/loss was reported, or 2) provide proff of sale
                                    including name and address of the new owner and (if applicable),
                                    proof of insurance cancellation or transfer for that vehicle or proof of plate surrender. (Voluntary Surrender of Plate(s) Report can be
                                    obtained from your local DMV). NOTE: If you are submitting either of
                                    the police reports or proof of sale to support your claim, then ONLY
                                    the violations listed on the notice issued on or after the date you
                                    made the official report or sold your vehicle may be dismissed. If a
                                    violation was issued PRIOR to the report date and you are
                                    disclaiming responsibility, then we require a fully detailed statement
                                    plus the subsequent police report(s), as well as proof of insurance
                                    cancellation when applicable.</p>

                                <h4>My vehicle but I was not the driver</h4>

                                <p class="enclose-copy">Please note, the vehicle identified bears a license plate registered or leased in your name. All registered ownsers are legally responsible
                                    for this violation. Points will not be assessed agaist the registered
                                    owner or the designated driver for this violation.</p>

                                <h4>Death of the registrant</h4>

                                <p class="enclose-copy">The death of the registrant prior to or within 90 days of the issuance of the ticket is a total defense to any ticket. You will need to submit the death certificate as proof.</p>

                                <?php /* <h4>Repeat violations</h4>

<p class="enclose-copy padding-bottom-100">This defense may be available to dismiss a duplicate ticket if the duplicate ticket was issued on the same day, for the same violation, at the same location, within three hours of this first ticket. You can receive a similar ticket every three hours.</p> */ ?>
                            </div>
                        </div>
                        <!--main-body-class-reqest-in person-->
                    </div>
                    <!--End of panel body-->
                </div>
            </div>
        </div>
    </div>
    <!--End of request-in-person-hearing-->

    <?php
    if ($violation_details['violation_type'] == 2) {
    ?>
        <div class="panel-group">
            <div class="pay-by-mail">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title"><span>Warning notice</span> <a data-toggle="collapse" aria-expanded="true" href="#warning-notice">OPEN</a></h4>
                    </div>
                    <div class="panel-collapse collapse" id="warning-notice">
                        <div class="panel-body">
                            <div class="padding-34">
                                <div class="request-of-copy mail-body">
                                    <p>This notice serves to inform you that the vehicle identified above failed to come
                                        to a complete stop at the designated stop sign. Please be advised that this
                                        notice serves as a warning only and does not carry a fine or require a court
                                        appearance. This warning has been extended to you as a courtesy by
                                        the <b><?= $violation_details['village_court_text']; ?></b>.
                                        <br>
                                        Please note that simply activating the brake lights or slowing down is not
                                        sufficient grounds for dismissal of this violation. The law requires vehicles to
                                        come to a complete stop before proceeding through a stop sign. To avoid future
                                        violations, please be mindful of this requirement.
                                        <br>
                                        No action or payment is required in response to this warning. If you believe
                                        that the license plate displayed in the accompanying photo and video is not
                                        registered to you, please dispute this notice online or contact the
                                        <b><?= $violation_details['village_court_text']; ?></b> at
                                        <b><?= $violation_details['village_email']; ?></b>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>

    <?php
        $stripe_pub_key = $db->fetch_row("SELECT b.stripe_pub_key FROM `ci_violations` a left join ci_villages b on a.village_court = b.id where violation_number = '$violation_number'");
        /* <div class="panel-group">
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
        </div> */
    ?>

    <?php if (isset($violation_records_by_plate) and !empty($violation_records_by_plate)) : ?>
            <div class="panel-group">
                <div class="pay-by-mail">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <span>Previous violations</span>
                                <a data-toggle="collapse" href="#previous-violations">OPEN</a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse" id="previous-violations">
                            <div class="panel-body">
                                <?php foreach($violation_records_by_plate as $previous_violation):
                                    // skip non mailed violations
                                    if ($previous_violation['status'] != 3) continue;

                                    // skip paid violations
                                    if ($previous_violation['payment_status'] != 0) continue;
                                ?>
                                    <div class="padding-34">
                                        <div class="request-of-copy mail-body">
                                            <p>Violation from <b><?= /* TODO: use violation_date instead */ date('M d Y', strtotime($previous_violation['violation_date_new'])) . ' ' . strtoupper($previous_violation['violation_time']) ?></b>. <a href="https://<?= $_SERVER['HTTP_HOST'] . '/violations/' . $previous_violation['violation_number'] . '-' . $previous_violation['pin'] ?>" target="_blank">View</a></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php endif; ?>

    <!--End of faqs-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
    <script src="https://videoenforcement.com/cms/public/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <script>
        function validate_input() {
            alert('');
            return false;
        }

        $('.panel-collapse').on('shown.bs.collapse', function() {
            //$(this).text('CLOSE');
            $(".panel-collapse").removeClass('in');
            $(this).addClass('in');
            $('.panel-title a').text('OPEN');
            $(this).parent('.panel-default').find('.panel-title a').text('CLOSE');
        });
        $('.panel-collapse').on('hidden.bs.collapse', function() {
            //$('#panelbtn').text('OPEN');
            $(this).parent('.panel-default').find('.panel-title a').text('OPEN');
        });

        /*  $('.text').on('keyup', function() {
          var card_number = $(this).val().split(" ").join("");
          if (card_number.length > 0) {
            card_number = card_number.match(new RegExp('.{1,4}', 'g')).join(" ");
          }
          $(this).val(card_number);
        }); */

        $('.panel-heading').click(function() {
            $('.panel-heading').removeClass('active');
            $(this).addClass('active');
            $('.question').removeClass('active');
            $(this).addClass('active');
        });

        $(function() {
            var hash = window.location.hash;
            hash && $('ul.nav a[href="' + hash + '"]').collapse('show');
            $('.panel-heading a').click(function(e) {
                $(this).collapse('show');
                var scrollmem = $('body').scrollTop() || $('html').scrollTop();
                window.location.hash = this.hash;
                $('html,body').scrollTop(scrollmem);
            });
        });

        $(document).ready(function() {
            $(".btn-info").click(function() {
                $(".pay-online-open").trigger("click");
            });
        });

        $(document).ready(function() {
            $(".pay-amountbtn").click(function() {
                if (!$("#cardname").val()) {
                    $(".validation-error").show();
                }
            });
        });

        // $('.btn-info').click(function(){
        //   if($('#myMessage').val() == ''){
        //       alert('Input can not be left blank');
        //   }
        // });

        $(document).ready(function() {
            $(window).on("resize", function(e) {
                checkScreenSize();
            });

            checkScreenSize();

            function checkScreenSize() {
                var newWindowWidth = $(window).width();
                if (newWindowWidth < 568) {
                    $(document).ready(function() {
                        // Hide div by setting display to none
                        $(".mobile-pay-button-child").click(function() {
                            $(".mobile-pay-button-child").hide();
                            $(".pay-online-main .panel-heading").show();
                        });
                    });

                    $(document).ready(function() {
                        // Hide div by setting display to none
                        $(".for-moibile .pay-online-open-mobile").click(function() {
                            $(".pay-online-main .panel-heading").hide();
                            $(".mobile-pay-button-child").show();

                        });
                    });
                } else {
                    $('.left').insertBefore('.right');
                }
            }
        });

        function url_reload(elm) {
            var url_arr = location.href.split("#");
            url_arr[1] = elm;
            url = url_arr.join('#');
            console.log(url_arr);
            window.location.href = url;
            location.reload();
        }

        var $form = $('.stripe_form');

        function stripeResponseHandler(status, response) {
            console.log(status);
            console.log(response);
            if (status == 200) {
                if (response.error) {
                    $form.find('.payment-errors').text(response.error.message);
                    $('.pay-amountbtn').prop('disabled', false);
                    $('.pay-amountbtn').val('PAY <?= $violation_details['amount_due']; ?>');
                } else {
                    var token = response.id;
                    var email = $('#email').val();
                    $.ajax({
                        type: 'POST',
                        url: window.location.origin + "/violations/payment_process.php",
                        data: {
                            violation_number: <?= $violation_number; ?>,
                            stripeToken: token,
                            email: email
                        },
                        dataType: 'json',
                        success: function(result) {
                            console.log('result');
                            console.log(result);
                            if (result.result == 'success') {
                                $('.pay-amountbtn').after('<h4 style="color: green; text-align: center;">Successfully Paid</h4>');
                                url_reload('success');
                            } else {
                                $('.pay-amountbtn').after('<h4 style="color: red; text-align: center;">Your Payment Failed</h4>');
                                $('.pay-amountbtn').prop('disabled', false);
                                $('.pay-amountbtn').val('PAY <?= $violation_details['amount_due']; ?>');
                            }
                        },
                        error: function(err) {
                            console.log('err');
                            console.log(err);
                            $('.pay-amountbtn').prop('disabled', false);
                            $('.pay-amountbtn').val('PAY <?= $violation_details['amount_due']; ?>');
                        }
                    });
                }
            } else {
                $form.find('.payment-errors').text(response.error.message);
                $('.pay-amountbtn').prop('disabled', false);
                $('.pay-amountbtn').val('PAY <?= $violation_details['amount_due']; ?>');
            }
        }

        $(function() {
            if (window.location.hash) {
                $(window.location.hash).addClass('in');
                $(window.location.hash).parent().find('.panel-heading').addClass('active');
                // $(window.location.hash).parent().find('a').addClass('in').text('CLOSE');
                $(window.location.hash).parent().find('.panel-heading a').addClass('in').text('CLOSE');
            }

            Stripe.setPublishableKey(<?php echo '"' . $stripe_pub_key['stripe_pub_key'] . '"'; ?>);
            // $('body').find('.credit-card').inputmask('9999 9999 9999 999', {
            //     placeholder: '____ ____ ____ ___'
            // });
            $form.submit(function() {
                console.log($form);
                var cardname = $("#cardname").val();
                if (cardname.length === 0) {
                    var required = $("#cardname").parent().find(".required");
                    required.text("Enter valid Name");
                    required.css({
                        "color": "#DC0300",
                        "white-space": "nowrap"
                    });
                    $("#cardname").focus();
                    return false;
                }

                var cardnumber = $("#cardnumber").val();
                if (cardnumber.length === 0) {
                    var required = $("#cardnumber").parent().find(".required");
                    required.text("Enter valid Card number");
                    required.css({
                        "color": "#DC0300",
                        "white-space": "nowrap"
                    });
                    $("#cardnumber").focus();
                    return false;
                }

                var month = $("#month").val();
                if (month === null) {
                    var required = $("#month").parent().parent().find("span.required");
                    console.log(required);
                    required.text("Select month");
                    required.css({
                        "color": "#DC0300",
                        "white-space": "nowrap"
                    });
                    $("#month").focus();
                    return false;
                }

                var year = $("#year").val();
                if (year === null) {
                    var required = $("#year").parent().parent().find(".required");
                    required.text("Select year");
                    required.css({
                        "color": "#DC0300",
                        "white-space": "nowrap"
                    });
                    $("#year").focus();
                    return false;
                }

                var cvv = $("#cvv").val();
                if (cvv.length === 0) {
                    var required = $("#cvv").parent().find(".required");
                    required.text("Enter valid CVV");
                    required.css({
                        "color": "#DC0300",
                        "white-space": "nowrap"
                    });
                    $("#cvv").focus();
                    return false;
                }

                var email = $("#email").val();
                if (!validateEmail(email)) {
                    var required = $("#email").parent().find(".required");
                    required.text("Enter valid Email address");
                    required.css({
                        "color": "#DC0300",
                        "white-space": "nowrap"
                    });
                    $("#cvv").focus();
                    return false;
                }

                $('.pay-amountbtn').prop('disabled', true);
                $('.pay-amountbtn').val('Processing.......');
                $form.find('.payment-errors').text('');
                Stripe.card.createToken($form, stripeResponseHandler);
                // console.log(token);
                return false;
            });

            $("#month").on('change', function() {
                console.log("selected");
                var required = $(this).parent().parent().find(".required");
                required.text("Required");
                required.css({
                    "color": "#00000099",
                    "white-space": "nowrap"
                });
            });

            $("#year").on('change', function() {
                var required = $(this).parent().parent().find(".required");
                required.text("Required");
                required.css({
                    "color": "#00000099",
                    "white-space": "nowrap"
                });
            });
        });


        function validateEmail(email) {
            var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }

        $("#cardname").change(function() {
            var val = $(this).val();
            var required = $(this).parent().find(".required");
            if (val.length === 0) {
                required.text("Enter valid Name");
                required.css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
            } else {
                required.text("Required");
                required.css({
                    "color": "#00000099",
                    "white-space": "nowrap"
                });
            }
        });

        $("#cardnumber").change(function() {
            var val = $(this).val();
            var required = $(this).parent().find(".required");
            if (val.length === 0) {
                required.text("Enter valid Card number");
                required.css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
            } else {
                required.text("Required");
                required.css({
                    "color": "#00000099",
                    "white-space": "nowrap"
                });
            }
        });


        $("#cvv").change(function() {
            var val = $(this).val();
            var required = $(this).parent().find(".required");
            if (val.length === 0) {
                required.text("Enter valid CVV");
                required.css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
            } else {
                required.text("Required");
                required.css({
                    "color": "#00000099",
                    "white-space": "nowrap"
                });
            }
        });

        $("#email").change(function() {
            var val = $(this).val();
            var required = $(this).parent().find(".required");
            if (!validateEmail(val)) {
                required.text("Enter valid Email address");
                required.css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
            } else {
                required.text("Enter email address to receive payment confirmation");
                required.css({
                    "color": "#00000099",
                    "white-space": "nowrap"
                });
            }
        });
    </script>
<?php } ?>
</div>
<script>
    /*  $(document).ready(function () {
    $("#disputedd").submit(function (event) {
        var formData = {
        name: $("#name").val(),
        email: $("#email").val(),
        superheroAlias: $("#superheroAlias").val(),
        };

        $.ajax({
        type: "POST",
        url: "process.php",
        data: formData,
        dataType: "json",
        encode: true,
        }).done(function (data) {
        console.log(data);
        });

        event.preventDefault();
    });
    });
    */
    $(document).ready(function(e) {
        $("#disputedd").on('submit', (function(e) {
            $("#message_sucess").css("display", "none");
            $("#message_erro").css("display", "none");
            e.preventDefault();
            var firstnn = $("#firstnn").val();
            if (firstnn.length === 0) {
                var required = $("#firstnn").parent().find(".required");
                required.text("Enter a valid name");
                required.css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
                $("#firstnn").focus();
                return false;
            } else {
                var required = $("#firstnn").parent().find(".required");
                required.text("");
            }

            var semail = $("#semail").val();
            if (semail.length === 0) {
                var required = $("#semail").parent().find(".required");
                required.text("Enter a valid email address");
                required.css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
                $("#semail").focus();
                return false;
            } else {
                var required = $("#semail").parent().find(".required");
                required.text("");
            }

            if (!validateEmail(semail)) {
                var required = $("#semail").parent().find(".required");
                required.text("Enter valid Email address");
                required.css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
                $("#semail").focus();
                return false;
            } else {
                var required = $("#semail").parent().find(".required");
                required.text("");
            }

            var explain = $("#explain").val();

            if (explain.length === 0) {
                var required = $("#explain").parent().find(".required");
                required.text("Enter a short explanation");
                required.css({
                    "color": "#DC0300",
                    "white-space": "nowrap"
                });
                $("#explain").focus();
                return false;
            } else {
                var required = $("#explain").parent().find(".required");
                required.text("");
            }
            /* var ext = $('#file').val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['png','pdf','jpg','jpeg']) == -1) {
                
                var required = $("#file").parent().find(".required");
                        required.text("Please upload jpg,png and pdf file");
                        required.css({"color":"#DC0300", "white-space":"nowrap"});
                        $("#explain").focus();
                        return false;

            }else
            {
            var required = $("#file").parent().find(".required");
                        required.text(" ");    
            }*/
            $.ajax({
                url: "https://stopforkids.com/cms/dispute",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {},
                success: function(data) {
                    if (data == 1) {
                        var stringg = 'Form submitted successfully. The decision will be sent to ' + semail + ' within 14 days.';
                        $("#message_sucess p").html(stringg);
                        $("#message_sucess").css("display", "block");
                        $("#message_erro").css("display", "none");
                        $("#dispute .address").css("display", "none");
                    } else {
                        $("#message_sucess").css("display", "none");
                        $("#message_erro").css("display", "block");
                    }
                },
                error: function(e) {
                    $("#message_erro").css("display", "block");
                }
            });
        }));
    });
    $(document).ready(function(e) {
        var type = window.location.hash.substr(1);
        if (type == '') {
            $('html, body').animate({
                'scrollTop': $("#customecliktop").position().top
            });
            $("#customeclik").trigger("click");
        }
    });
</script>
<!--End of container-->
</body>

</html>