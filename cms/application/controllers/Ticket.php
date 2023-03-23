<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ticket extends CI_Controller {

	public function __construct(){

		parent::__construct();
		
		$this->load->model('activity_model','activity_model');

		$this->load->library('datatable');
		
		$this->load->helper('url');
		$this->load->helper('date');

	}

		//-----------------------------------------------------------------------

	public function index(){

		$this->load->view('ticket/index');

	}
}

?>