<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dispute extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('mailer');
		$this->load->library('recaptcha');
		$this->load->model('auth_model', 'auth_model');
		$this->load->model('activity_model', 'activity_model');
		$this->load->model('admin/violation_model', 'violation_model');// Shang
	}
	//-------------------------------------------------------------------------

	//-------------------------------------------------------------------------	


	//-------------------------------------------------------------------------
	public function Index()
	{

		$files = '';

		if (isset($_FILES['filed'])) {

			$path = '/home/videoenforcement/public_html/cms/pdfs/';
			$location = $path . $_FILES['filed']['name'];
			$files = $_FILES['filed']['name'];
			move_uploaded_file($_FILES['filed']['tmp_name'], $location);
		}
		$fullname = $this->input->post('fname');
		$semail = $this->input->post('semail');
		$palte = $this->input->post('palte');
		$voll = $this->input->post('voll');
		$pin = $this->input->post('pin');       // Shang
		$link = $this->input->post('link');
		$res = $this->input->post('explain');
		$body = $this->mailer->Tpl_Dispute($fullname, $semail, $res, $link);
		$this->load->helper('emailv_helper');
		$to[0] = 'support@stopforkidscom.zendesk.com';	// disputes@stopforkids.com 
		if (!empty($semail)) $to[1] = $semail;

		$subject = 'Dispute Stop Sign Violation ' . $voll . ' - ' . $palte;
		$message =  $body;
		$email = sendEmail($to, $subject, $message, $file = $files, $cc = $semail, $fullname);
		$email = true;
		
		
		// Shang - Update Status in violations table to 6(Disputed) and update date_disputed field.
		$res = $this->violation_model->get_violation_by_num_pin($voll, $pin);
		if ( !empty($res['id']) ) {
		    $data = array(
		        'status' => 6,
		        'date_disputed' => date('Y-m-d H:i:s')
		    );
		    $this->violation_model->edit_violation($data, $res['id']);
		}
		
		
		if ($email) {
			echo json_encode(1);
			exit;
		} else {
			echo json_encode(0);
			exit;
		}
	}
	//----------------------------------------------------------	

	//--------------------------------------------------		


}  // end class
