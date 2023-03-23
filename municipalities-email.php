<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

include_once('violations/header.php'); 
require_once('libs/vendor/autoload.php');

if ( isset($_POST['first_name']) && isset($_POST['email']) && isset($_POST['phone']) ) {
    $municipality_name = trim($_POST['municipality_name']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $city = trim($_POST['city']);
    $state = trim($_POST['state']);
    $zip = trim($_POST['zip']);
    $role = trim($_POST['role']);
    $comment = trim($_POST['comment']);
    $file = trim($_POST['file']);

    $general_settings = $db->fetch_row("SELECT * FROM `ci_general_settings`");

    $msg  = "A new request was submitted with the following details. \n\n";
    $msg .= "Name of municipality: $municipality_name \n";
    $msg .= "First name: " . $first_name . " \n";
    $msg .= "Last name: " . $last_name . " \n";
    $msg .= "Email: " . $email . " \n";
    $msg .= "Phone: $phone \n";
    $msg .= "City: $city \n";
    $msg .= "State: $state \n";
    $msg .= "Zip: $zip \n";
    $msg .= "Your role: $role \n";
    $msg .= "Comment: \n";
    $msg .= $comment . " \n\n\n";
    $msg .= "IP address: " . $_SERVER['REMOTE_ADDR'] . " \n";
    $msg .= "Submission date: " . date('M d Y') . " \n";

    $url = 'http://';
    if ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' )
        $url = "https://";
    $url .= $_SERVER['HTTP_HOST'] . '/' . $file; 
         
    $msg .= "URL: " . $url . " \n\n";

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = false;
        $mail->isSMTP();
        $mail->Host       = $general_settings['smtp_host'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $general_settings['smtp_user'];
        $mail->Password   = $general_settings['smtp_pass'];
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $general_settings['smtp_port'];

        //Recipients
        $mail->setFrom($general_settings['email_from'], 'STOP FOR KIDS', true);
        $mail->addAddress('gov@stopforkids.com');
        $mail->addReplyTo('gov@stopforkids.com', 'STOP FOR KIDS');

        // Content
        //$mail->isHTML(true);
        $mail->Subject = 'New request from municipality';
        $mail->Body    = $msg;
        $mail->send();
        echo "Sent";
    } catch (Exception $e) {
        echo $e->errorMessage(); //Pretty error messages from PHPMailer
    }
}