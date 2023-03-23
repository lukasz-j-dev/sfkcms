<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once '../PHPMailer/src/Exception.php';
require_once '../PHPMailer/src/PHPMailer.php';
require_once '../PHPMailer/src/SMTP.php';
include_once('header.php'); 
require_once('../libs/vendor/autoload.php');

// global $db;
if(!empty($_REQUEST['stripeToken']) && !empty($_REQUEST['violation_number'])){
	$violation_number = trim($_REQUEST['violation_number']);
	$myCard = trim($_REQUEST['stripeToken']);
	$stripe_email = trim($_REQUEST['email']);
	$results = array();
	$violation_details = $db->fetch_row("SELECT *, b.fine_amount, b.village_court as village_name, b.email FROM `ci_violations` a left join ci_villages b on a.village_court = b.id where violation_number = '$violation_number'");
	$general_settings = $db->fetch_row("SELECT * FROM `ci_general_settings`");
	if($violation_details['amount_due'] > 0){
		$amount = bcmul($violation_details['amount_due'], 100);

		// require_once('stripe_key.php');

		$stripe_sec_key = $db->fetch_row("SELECT b.stripe_sec_key FROM `ci_violations` a left join ci_villages b on a.village_court = b.id where violation_number = '$violation_number'");
		
		if ( !empty($stripe_sec_key['stripe_sec_key']) && $stripe_sec_key['stripe_sec_key'] != Null ) {
			$stripe_description = "Violation #$violation_number due amount \n License plate: " . $violation_details['plate'];
			$customer_description = "License plate: " . $violation_details['plate'];
			$update = 'no';
			if($amount > 0 && !empty($myCard)){
				try {
					$stripe = new \Stripe\StripeClient($stripe_sec_key['stripe_sec_key']);
					
					//$stripe = new \Stripe\StripeClient($stripe_test_key);
					$charge = $stripe->charges->create([
					  'amount' => $amount,
					  'currency' => 'usd',
					  'source' => $myCard,
					  'description' => $stripe_description,
					  'receipt_email' => $stripe_email
					]);
					/* $charge = \Stripe\Charge::create(array('customer' => $stripe_cust_id, 'card' => $stripe_card_id, 'amount' => $amount, 'currency' => 'usd', 'description' => $stripe_description, 'capture' => false, "receipt_email" => $stripe_email)); */
					$results['result'] = 'success';
					$status = '1';
				}
				catch(\Stripe\Error\Card $e) {  // \Customer
					$body = $e->getJsonBody();
					$err  = $body['error'];
					$results['result'] = $err['code'];
				} 
				catch (\Stripe\Error\InvalidRequest $e) {
					$results['result'] = '1';
				} 
				catch (\Stripe\Error\Authentication $e) {
					$results['result'] = '2';
				}
				catch (\Stripe\Error\ApiConnection $e) {
					$results['result'] = '3';
				} 
				catch (\Stripe\Error\Base $e) {
					$results['result'] = '4';
				} 
				catch (Exception $e) {
					$results['result'] = '5';
				}
			}

			// Update table with paid
			$date_paid = date("Y-m-d H:i:s");
			$db->query("update ci_violations set receipt_email = '$stripe_email', payment_status = 1, amount_paid = " . $violation_details['amount_due'] . ", date_paid_new = '$date_paid' where violation_number = '$violation_number'");

			// echo json_encode($results);
			// exit;

			$msg  = "This email confirms that payment has been made successfully. No further action is required. \n\n";
			$msg .= "Violation Number: $violation_number \n";
			$msg .= "License plate: " . $violation_details['plate'] . " \n";
			$msg .= "Full name: " . $violation_details['full_name'] . " \n";
			$msg .= "Violation date: " .   date('M d Y', strtotime($violation_details['violation_date_new'])). " \n";
			$msg .= "Notice date: " .   date('M d Y', strtotime($violation_details['notice_date_new'])). " \n";
			$msg .= "Payment date: $date_paid \n\n";
			$msg .= "Amount: " . $violation_details['amount_due'] . " \n\n";
			$msg .= $violation_details['village_name']." \n";
			
			$mail = new PHPMailer(true);
			$mail->SMTPDebug = false;
			$mail->isSMTP();
			$mail->Host       = $general_settings['smtp_host'];
			$mail->SMTPAuth   = true;
			$mail->Username   = $general_settings['smtp_user'];
			$mail->Password   = $general_settings['smtp_pass'];
			$mail->SMTPSecure = 'tls';
			$mail->Port       = $general_settings['smtp_port'];
	
			//Recipients
			$mail->setFrom($general_settings['email_from'], $violation_details['village_name'], true);
			$mail->addCC('info@scbw.com');
			$mail->addCC($violation_details['email']);
			$mail->addBCC('gov@stopforkids.com');
			$mail->addAddress($stripe_email);
			$mail->addReplyTo($violation_details['email'], $violation_details['village_name']);
	
			// Content
			//$mail->isHTML(true);
			$mail->Subject = "Receipt from ".$violation_details['village_name']." (" . $violation_details['violation_number'] . '-' . $violation_details['pin'] . ")";
			$mail->Body    = $msg;
			$mail->send();
			echo json_encode($results);
			exit;
		}
	}
}/* else{
	$violation_details = $db->fetch_row("SELECT * FROM `ci_violations` where id = 1013");
	$general_settings = $db->fetch_row("SELECT * FROM `ci_general_settings`");
	$date_paid = date("M-d-y");
	$msg = "Successfully Paid the due amount of Violation\n";
	$msg .= "Here the details:\n";
	$msg .= "Violation Number: $violation_number \n";
	$msg .= "Violation Date: " . $violation_details['violation_date'] . " \n";
	$msg .= "Due Amount: " . $violation_details['fine_amount'] . " \n";
	$msg .= "Date Paid: $date_paid \n";
	$mail = new PHPMailer(true);
	try {
		//Server settings
		$mail->SMTPDebug = true;
		$mail->isSMTP();
		$mail->Host       = $general_settings['smtp_host'];
		$mail->SMTPAuth   = true;
		$mail->Username   = $general_settings['smtp_user'];
		$mail->Password   = $general_settings['smtp_pass'];
		$mail->SMTPSecure = 'tls';
		$mail->Port       = $general_settings['smtp_port'];

		//Recipients
		$mail->setFrom($general_settings['email_from']);
		$mail->addAddress('jack@scbw.com');
		$mail->addReplyTo('contact@videoenforcement.com', 'Contact');

		// Content
		//$mail->isHTML(true);
		$mail->Subject = "Violation Due Amount";
		$mail->Body    = $msg;
		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
} */
