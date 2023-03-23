<?php
include_once('../violations/header.php');
require_once 'vendor/autoload.php';
require_once 'dompdf/autoload.inc.php';

global $db;

use Dompdf\Dompdf;
use iio\libmergepdf\Merger;
use iio\libmergepdf\Pages;


$template = (!empty($_REQUEST['pdf_template']) ? trim($_REQUEST['pdf_template']) : 1);
if (!empty($_REQUEST['violation_id'])) {

	$violation_id = (!empty($_REQUEST['violation_id']) ? trim($_REQUEST['violation_id']) : '');
	$query = "SELECT a.*, b.village_court as village_court_text,b.payable_to, b.email as village_email, b.village_logo, b.fine_amount, b.address1 as vil_address1, b.address2 as vil_address2, b.city as vil_city, b.state as vil_state, b.zip as vil_zip, c.camera_location, c.camera_zip FROM `ci_violations` a  left join ci_villages b on a.village_court = b.id left join `ci_cameras` c on a.camera = c.id where a.id = '$violation_id'";
	$violation_details = $db->fetch_row($query);
	$query1 = "SELECT * from ci_plates where plate = '" . $violation_details['plate'] . "'";
	$plate_details = $db->fetch_row($query1);

	$dompdf = new Dompdf(['isHtml5ParserEnabled' => true]);
	$qr_ico = file_get_contents('https://chart.googleapis.com/chart?chs=175x175&cht=qr&chl=https://stopforkids.com/violations/' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . '#video-recording-body');
	$qr_url = 'images/' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . 'jpg';
	file_put_contents($qr_url, $qr_ico);

	$plate_photo = base64_encode(file_get_contents($violation_details['plate_photo']));
	$vio_address = $violation_details['address1']; 
	$notice_date = $violation_details['notice_date_new'];
	$notice_datetimestampdue = strtotime($notice_date);
	$notice_date = date('M d Y', $notice_datetimestampdue);

	$violation_date = $violation_details['violation_date_new'];
    $violation_time = date('h:i A', strtotime($violation_details['violation_date']));
	$violation_datesa = strtotime($violation_date);
	$violation_date = date('M d Y', $violation_datesa);

	$duedue = $violation_details['due_date_new'];
	$violation_datesadue = strtotime($duedue);
	$due_date = date('M d Y', $violation_datesadue);

	if (!empty($violation_details['address2'])) $vio_address .= '</br>' . $violation_details['address2'];
	$vil_address = $violation_details['vil_address1'];
	if (!empty($violation_details['vil_address2'])) $vil_address .= '</br>' . $violation_details['vil_address2'];

	include 'template_' . $template . '.php';

	$filename = 'Violation-' . $violation_details['camera_zip'] . '-' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . '-' . $violation_details['plate'];
//	var_dump($html); die;
    $dompdf->loadHtml($html);
	$dompdf->loadHtml($html);

	//$dompdf->set_option('isHtml5ParserEnabled', true);

	// (Optional) Setup the paper size and orientation
	$dompdf->setPaper('DEFAULT_PDF_PAPER_SIZE', 'A4');
    ob_end_clean();
	// Render the HTML as PDF
	$dompdf->render();

	// Output the generated PDF to Browser
	$dompdf->stream($filename);
} elseif (!empty($_REQUEST['violation_ids'])) {

	$violation_ids = (!empty($_REQUEST['violation_ids']) ? implode(',', $_REQUEST['violation_ids']) : '');
	/* $violation_ids = '1021,1020,1022,1023'; */
	$page = (!empty($_REQUEST['page']) ? $_REQUEST['page'] : 1);
	$limit = (!empty($_REQUEST['limit']) ? $_REQUEST['limit'] : 1);
	$json_resp = array();
	$start = ($page - 1) * $limit;
	$json_resp['start'] = $start;
	$json_resp['limit'] = $limit;
	$trans_year = 2022;
	$sub_month = $trans_year . '-03';

	$query = "SELECT count(*) as num_rows FROM `ci_violations` a  left join ci_villages b on a.village_court = b.id left join `ci_cameras` c on a.camera = c.id where a.id in ($violation_ids)";
	// 	echo $query;
	$violations_row = $db->fetch_row($query);
	$violations = $violations_row['num_rows'];
	$total_page = ceil($violations / $limit);
	$json_resp['total_page'] = $total_page;
	$json_resp['cur_page'] = $page;
	if (($page + 1) <= $total_page) $json_resp['next_page'] = $page + 1;
	$json_resp['violations'] = $violations;
	$json_resp['percent'] = number_format(($page * 100) / $total_page, 2);
	$json_resp['msg'] = $json_resp['percent'] . '% completed';

	$query = "SELECT a.*, b.village_court as village_court_text,b.payable_to, b.email as village_email, b.village_logo, b.fine_amount, b.address1 as vil_address1, b.address2 as vil_address2, b.city as vil_city, b.state as vil_state, b.zip as vil_zip, c.camera_location, c.camera_zip FROM `ci_violations` a  left join ci_villages b on a.village_court = b.id left join `ci_cameras` c on a.camera = c.id where a.id in ($violation_ids) order by a.id limit $start, $limit";
	$violations_details = $db->fetch_assoc($query);
	if (count($violations_details) > 0) {
		foreach ($violations_details as $violation_details) {
			$query1 = "SELECT * from ci_plates where plate = '" . $violation_details['plate'] . "'";
			$plate_details = $db->fetch_row($query1);

			$dompdf = new Dompdf(['isHtml5ParserEnabled' => true]);
			$qr_ico = file_get_contents('https://chart.googleapis.com/chart?chs=175x175&cht=qr&chl=https://stopforkids.com/violations/' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . '#video-recording-body');
			$qr_url = 'images/' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . 'jpg';
			file_put_contents($qr_url, $qr_ico);

			$plate_photo = base64_encode(file_get_contents($violation_details['plate_photo']));
			$vio_address = $violation_details['address1'];
			if (!empty($violation_details['address2'])) $vio_address .= '</br>' . $violation_details['address2'];
			$vil_address = $violation_details['vil_address1'];
			if (!empty($violation_details['vil_address2'])) $vil_address .= '</br>' . $violation_details['vil_address2'];
			$notice_date = $violation_details['notice_date_new'];
			$notice_datetimestampdue = strtotime($notice_date);
			$notice_date = date('M d Y', $notice_datetimestampdue);

			$violation_date = $violation_details['violation_date_new'];
			$violation_datesa = strtotime($violation_date);
			$violation_date = date('M d Y', $violation_datesa);

			$duedue = $violation_details['due_date_new'];
			$violation_datesadue = strtotime($duedue);
			$due_date = date('M d Y', $violation_datesadue);

			include 'template_' . $template . '.php';

			$filename = 'pdf/Violation-' . $violation_details['camera_zip'] . '-' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . '.pdf';
			$dompdf->loadHtml($html);

			//$dompdf->set_option('isHtml5ParserEnabled', true);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('DEFAULT_PDF_PAPER_SIZE', 'A4');

			// Render the HTML as PDF
			$dompdf->render();

			//$dompdf->stream($filename);
			fopen($filename, 'a');
			file_put_contents($filename, $dompdf->output());
		}
	}

	$type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : 'multi';
	// 	echo $type.'/'.$page.'/'.$total_page;
	if ($page >= $total_page) {
		if ($type == 'single') {
			//  echo '--------------------';
			//  echo 'SINGLE FILE';
			//  echo '--------------------';
			//  echo '<br>';
			$query = "SELECT a.*, b.village_court as village_court_text,b.payable_to, b.email as village_email, b.village_logo, b.fine_amount, b.address1 as vil_address1, b.address2 as vil_address2, b.city as vil_city, b.state as vil_state, b.zip as vil_zip, c.camera_location, c.camera_zip FROM `ci_violations` a  left join ci_villages b on a.village_court = b.id left join `ci_cameras` c on a.camera = c.id where a.id in ($violation_ids) order by a.id";
			//  echo $query;

			$violations_details = $db->fetch_assoc($query);
			if (count($violations_details) > 0) {
				$fileArray = [];
				foreach ($violations_details as $violation_details)
					$fileArray[] = 'pdf/Violation-' . $violation_details['camera_zip'] . '-' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . '.pdf';

				$created_time = time();
				$file_name = 'Violation_Ticket_' . $created_time . '.zip';
				$new_filename = 'zip/' . $file_name;
				try {
					// echo $new_filename.' file deleted'.'<br>';
					unlink($new_filename);
				} catch (Exception $e) {
					// echo 'error'.'<br>';
					// echo 'Message: ' .$e->getMessage();
				}
				// die;

				$zip = new ZipArchive;
				$zip->open($new_filename, ZipArchive::CREATE);
				// print_r($fileArray);

				foreach ($fileArray as $file) {
					// print_r($file);
					// echo '<br>';
					$zip->addFile($file);
				}
				$zip->close();
				$json_resp['download_file'] = 'zip/' . $file_name;
			}
		} else {
			//  echo '--------------------';
			//  echo 'MULTI FILES';
			//  echo '--------------------';
			$violations_details = $db->fetch_assoc("SELECT a.*, b.village_court as village_court_text,b.payable_to, b.village_logo, b.fine_amount, b.address1 as vil_address1, b.address2 as vil_address2, b.city as vil_city, b.state as vil_state, b.zip as vil_zip, c.camera_location, c.camera_zip FROM `ci_violations` a  left join ci_villages b on a.village_court = b.id left join `ci_cameras` c on a.camera = c.id where a.id in ($violation_ids) order by a.id");
			if (count($violations_details) > 0) {
				foreach ($violations_details as $violation_details) $fileArray[] = 'pdf/Violation-' . $violation_details['camera_zip'] . '-' . $violation_details['violation_number'] . '-' . $violation_details['pin'] . '.pdf';
				$merger = new Merger;
				$merger->addIterator($fileArray);
				$createdPdf = $merger->merge();
				$new_filename = "pdf_save/violation_list_" . time() . ".pdf";
				$myfile = fopen($new_filename, "w") or die("Unable to open file!");
				$txt = $createdPdf;
				fwrite($myfile, $txt);
				fclose($myfile);
				$json_resp['download_file'] = $new_filename;
			}
		}
	}

	$json_resp['type'] = $type;
	$json_resp['ids'] = $_REQUEST['violation_ids'];
	echo json_encode($json_resp);
	die;
}
