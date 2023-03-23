<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
class Activity extends MY_Controller {

	public function __construct(){

		parent::__construct();
		$this->load->model('Activity_model', 'activity_model');
	}

	public function index()
	{
		$data['title'] = 'User Activity Log';
		$data['view'] = 'admin/activity/activity-list';
		$this->load->view('layout',$data);
	}

	public function datatable_json()
	{
		$records['data'] = $this->activity_model->get_activity_log();

		$data = array();
		$i=0;
		foreach ($records['data']  as $row) 
		{  
			$data[]= array(
				++$i,
				$row['username'],
				$row['group_name'],
				$row['description'],
				date('F d, Y H:i',strtotime($row['created_at'])),	
			);
		}
		$records['data'] = $data;
		echo json_encode($records);
	}
}

?>	