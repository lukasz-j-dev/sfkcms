<?php
require_once('vendor/autoload.php');

$stripe = new \Stripe\StripeClient('sk_test_dZdyCXZwkvboHzXrKh8AVBR300SMR7gaeH');
try{
	$paymentIntent = $stripe->paymentIntents->create([
	  'amount' => 10000,
	  'currency' => 'usd',
	  'transfer_group' => '1000002'
	]);
	print_r('succ_intent');
	print_r($paymentIntent);
}catch(Exception $e){
	print_r('err_intent');
	print_r($e);
}
try{
	$transfer = $stripe->transfers->create([
	  'amount' => 7000,
	  'currency' => 'usd',
	  'destination' => 'acct_1LY73gRjkP71FrXO',
	  'transfer_group' => '1000002'
	]);
	print_r('succ_trans1');
	print_r($transfer);
}catch(Exception $e){
	print_r('succ_trans1');
	print_r($e);
}
try{
	$transfer = $stripe->transfers->create([
	  'amount' => 2000,
	  'currency' => 'usd',
	  'destination' => 'acct_1LY6jlReuGKtMsXn',
	  'transfer_group' => '1000002',
	]);
	print_r('succ_trans2');
	print_r($transfer);
}catch(Exception $e){
	print_r('succ_trans2');
	print_r($e);
}