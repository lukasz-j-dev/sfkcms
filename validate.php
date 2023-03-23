<?php
include_once('violations/header.php');
session_start();
global $db;
if(!empty($_REQUEST['action'])){
	$action = !empty($_REQUEST['action']) ? trim($_REQUEST['action']) : '';
	if(!isset($_SESSION['last_attempt'])) $_SESSION['last_attempt'] = 0;
	if(!isset($_SESSION['attempt_time'])) $_SESSION['attempt_time'] = 0;
	if($action == 'vio_number'){
		$violation_number = !empty($_REQUEST['violation_number']) ? trim($_REQUEST['violation_number']) : '';
		$pin = !empty($_REQUEST['pin']) ? trim($_REQUEST['pin']) : '';
		$data['violation_number'] = $violation_number;
		$data['pin'] = $violation_number;
		$data['time'] = time();
		if($data['time'] >= ($_SESSION['attempt_time'] + 4500)){
			$db->query("SELECT * FROM `ci_violations` where violation_number = '$violation_number'");
			if($db->num_rows > 0){
				$results = $db->fetch_row();
				if($data['time'] >= ($results['attempt_time'] + 4500)){
					if($pin == $results['pin']){
						$_SESSION['last_attempt'] = 0;
						$_SESSION['attempt_time'] = 0;
						$db->query("update `ci_violations` set last_attempt = 0 where id = " . $results['id']);
						$ret = Array('status'=>$results['status'], 'validate'=> true, 'more_req'=> false);
					}else{
						$ses_last_attempt = $_SESSION['last_attempt'] % 3;
						$_SESSION['last_attempt'] = $ses_last_attempt + 1;
						if($_SESSION['last_attempt'] == 3) $_SESSION['attempt_time'] = $data['time'];
						$last_attempt = $results['last_attempt'] % 3;
						$up_data['last_attempt'] = $last_attempt + 1;
						if($up_data['last_attempt'] == 3){
							$db->query("update `ci_violations` set last_attempt = " . $up_data['last_attempt'] . ", attempt_time = " . $data['time'] . " where id = " . $results['id']);
						}else{
							$db->query("update `ci_violations` set last_attempt = " . $up_data['last_attempt'] . " where id = " . $results['id']);
						}
						$ret = Array('status'=> -1, 'validate'=> false, 'more_req'=> false);
					}
				}else{
					$ret = Array('status'=> -1, 'validate'=> false, 'more_req'=> true);
				}
			}
			else {
				$ses_last_attempt = $_SESSION['last_attempt'] % 3;
				$_SESSION['last_attempt'] = $ses_last_attempt + 1;
				if($_SESSION['last_attempt'] == 3) $_SESSION['attempt_time'] = $data['time'];
				$ret = Array('status'=> -1, 'validate'=> false, 'more_req'=> false);
			}
		}else {
			$ret = Array('status'=> -1, 'validate'=> false, 'more_req'=> true);
		}
	
	}elseif($action == 'plate_no'){
		$plate_number = !empty($_REQUEST['plate_number']) ? trim($_REQUEST['plate_number']) : '';
		$state = !empty($_REQUEST['state']) ? trim($_REQUEST['state']) : '';
		$db->query("SELECT * FROM `ci_violations` where plate = '$plate_number' and state = '$state'");
		if($db->num_rows > 0){
			$results = $db->fetch_row();
			$ret = Array('status'=>$results['status'], 'validate'=> true);
		}else {
			$ret = Array('status'=> -1, 'validate'=> false);
		}
	}
	echo json_encode($ret);}
?>

