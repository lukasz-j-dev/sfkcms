<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cameras extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->model('admin/camera_model', 'camera_model');
		$this->load->model('admin/user_model', 'user_model');
		$this->load->model('admin/village_model', 'village_model');
		$this->load->model('activity_model','activity_model');

		$this->load->library('datatable');

		$this->load->helper('url');
		$this->load->helper('date');
	}

		//-----------------------------------------------------------------------

	public function index(){

		$data['view'] = 'admin/cameras/camera_list';

		$this->load->view('layout', $data);

	}
	public function datatable_json(){				   					   

		$records = $this->camera_model->get_all_cameras();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  

			$data[]= array(

				$row['id'],

				$row['village_court'],

				$row['camera_location'],
				
				$row['camera_zip'],
				
				$row['camera_model'],
				
				$row['date_installed'],
				
				'<a title="View" class="view btn btn-sm btn-info" href="'.base_url('admin/cameras/edit/'.$row['id']).'"> <i class="material-icons">visibility</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/cameras/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/cameras/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>

				',
				$row['date_installed_stamp']

			);

		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	public function add(){
		$data['village'] = $this->camera_model->get_all_villages();

		if($this->input->post('submit')){
			$this->form_validation->set_rules('village_court', 'village_court', 'trim');
			$this->form_validation->set_rules('camera_location', 'camera_location', 'trim|required');
			$this->form_validation->set_rules('camera_zip', 'camera_zip', 'trim|required');
			$this->form_validation->set_rules('camera_model', 'camera_model', 'trim');
			$this->form_validation->set_rules('date_installed', 'date_installed', 'trim');
			$this->form_validation->set_rules('gps', 'gps', 'trim|required');
			if ($this->form_validation->run() == FALSE) {

				$data['view'] = 'admin/cameras/camera_add';

				$this->load->view('layout', $data);

			}else{
				$data = array(

					'village_court' => $this->input->post('village_court'),

					'camera_location' => $this->input->post('camera_location'),

					'camera_zip' => $this->input->post('camera_zip'),

					'camera_model' => $this->input->post('camera_model'),

					'date_installed' => $this->input->post('date_installed'),

					'gps' =>  $this->input->post('gps'),
					
					'status' => 1,


				);
				$added_by = $this->session->userdata('admin_id');
				$n_date = strtotime(str_replace('-', ' ', $this->input->post('date_installed')));
				$data['date_installed_stamp'] = $n_date;
				$data['added_by'] = $added_by;
				$data['date_modified'] = now();

				$data = $this->security->xss_clean($data);

				$result = $this->camera_model->add_camera($data);
				if($result){

					// Add User Activity

					$this->activity_model->add(1);



					$this->session->set_flashdata('msg', 'Camera has been added successfully!');

					redirect(base_url('admin/cameras'));

				}
			}

		}else{
			$data['camera']['simple_villages'] = $this->village_model->get_all_active_villages();
			$data['view'] = 'admin/cameras/camera_add';

			$this->load->view('layout', $data);

		}

		

	}
	public function edit($id = 0){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('village_court', 'village_court', 'trim');
			$this->form_validation->set_rules('camera_location', 'camera_location', 'trim|required');
			$this->form_validation->set_rules('camera_zip', 'camera_zip', 'trim|required');
			$this->form_validation->set_rules('camera_model', 'camera_model', 'trim');
			$this->form_validation->set_rules('date_installed', 'date_installed', 'trim');
			$this->form_validation->set_rules('gps', 'gps', 'trim|required');
			if ($this->form_validation->run() == FALSE) {

				$data['view'] = 'admin/cameras/camera_edit';

				$this->load->view('layout', $data);

			}else{
				$data = array(

					'village_court' => $this->input->post('village_court'),

					'camera_location' => $this->input->post('camera_location'),

					'camera_zip' => $this->input->post('camera_zip'),

					'camera_model' => $this->input->post('camera_model'),

					'date_installed' => $this->input->post('date_installed'),

					'gps' =>  $this->input->post('gps'),
					
					'date_added' => $this->input->post('date_added'),
					
					'status' => $this->input->post('status'),


				);
				$data['date_modified'] = now();
				$data = $this->security->xss_clean($data);
				
				$result = $this->camera_model->edit_camera($data, $id);
				if($result){

					$this->activity_model->add(2);

					$this->session->set_flashdata('msg', 'Camera has been updated successfully!');
					redirect(base_url('admin/cameras'));
				}
			}
		}
		else{
			$data['camera'] = $this->camera_model->get_camera_by_id($id);
			$data['camera']['simple_villages'] = $this->village_model->get_all_active_villages();
			$user_details = $this->user_model->get_user_by_id($data['camera']['added_by']);
			$data['camera']['added_by_details'] = $user_details['firstname'] . ' ' . $user_details['lastname'];
			$data['view'] = 'admin/cameras/camera_edit';
			$this->load->view('layout', $data);
		}
	}
	public function del($id = 0){
		$this->db->delete('ci_cameras', array('id' => $id));

		// Add User Activity
		$this->activity_model->add(3);

		$this->session->set_flashdata('msg', 'Camera has been deleted successfully!');
		redirect(base_url('admin/cameras'));
	}
}

?>