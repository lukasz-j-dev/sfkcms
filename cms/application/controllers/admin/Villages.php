<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
require_once($_SERVER['DOCUMENT_ROOT'] . '/slim-image-cropper/example/slim.php');

class Villages extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->model('admin/village_model', 'village_model');
		$this->load->model('admin/user_model', 'user_model');
		$this->load->model('activity_model','activity_model');

		$this->load->library('datatable');

		$this->load->helper('url');
		$this->load->helper('date');
	}

	public function index(){

		$data['view'] = 'admin/villages/village_list';

		$this->load->view('layout', $data);

	}

	public function datatable_json(){				   					   

		$records = $this->village_model->get_all_villages();
		$data = array();

		foreach ($records['data']  as $row) 
		{  
			$status_arr = array('', 'Active', 'Inactive', 'Archived');
			$status = !empty($row['status']) ? $status_arr[$row['status']] : '';
			$data[] = array(
				$row['id'],
				$row['village_court'],
				$row['fine_amount'],
				$status,
				$row['payable_to'],
				'<a title="View" class="view btn btn-sm btn-info" href="'.base_url('admin/villages/edit/'.$row['id']).'"> <i class="material-icons">visibility</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/villages/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/villages/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				'
			);
		}

		$records['data']=$data;
		echo json_encode($records);						   
	}

	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('village_court', 'village_court', 'trim|required');
			$this->form_validation->set_rules('fine_amount', 'fine_amount', 'trim|required');
			$this->form_validation->set_rules('payable_to', 'payable_to', 'trim|required');
			$this->form_validation->set_rules('notes', 'notes', 'trim');
			$this->form_validation->set_rules('notes', 'address1', 'trim');
			$this->form_validation->set_rules('notes', 'address2', 'trim');
			$this->form_validation->set_rules('notes', 'state', 'trim');
			$this->form_validation->set_rules('notes', 'city', 'trim');
			$this->form_validation->set_rules('notes', 'zip', 'trim');
			$this->form_validation->set_rules('stripe_pub_key', 'stripe_pub_key', 'trim');
			$this->form_validation->set_rules('stripe_sec_key', 'stripe_sec_key', 'trim');

			if ($this->form_validation->run() == FALSE) {
				$data['view'] = 'admin/users/user_add';
				$this->load->view('layout', $data);
			} else {
				$data = array(
					'village_court' => $this->input->post('village_court'),
					'fine_amount' => $this->input->post('fine_amount'),
					'payable_to' => $this->input->post('payable_to'),
					'notes' => $this->input->post('notes'),
					'state' => $this->input->post('state'),
					'address1' => $this->input->post('address1'),
					'address2' => $this->input->post('address2'),
					'city' => $this->input->post('city'),
					'zip' => $this->input->post('zip'),
					'status' => 1,
					'stripe_pub_key' => $this->input->post('stripe_pub_key'),
					'stripe_sec_key' => $this->input->post('stripe_sec_key')
				);

				/* $config['upload_path'] = './public/images/villages';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('village_logo')) {
					$this->upload->display_errors();
				} else {
					$upload_data = $this->upload->data();
					$data['village_logo'] = $upload_data['file_name'];
				} */

				$images = Slim::getImages('village_logo');
				if ($images != false) {
					foreach ($images as $image) {
						if (isset($image['output']['data'])) {
							$img_name = $image['output']['name'];
							$img_data = $image['output']['data'];
							$input = Slim::saveFile($img_data, $img_name, './public/images/villages');
							$data['village_logo'] = $input['name'];
						}
					}
				}

				$added_by = $this->session->userdata('admin_id');
				$data['added_by'] = $added_by;
				$data['date_modified'] = now();

				$data = $this->security->xss_clean($data);
				$result = $this->village_model->add_village($data);
				if($result){
					// Add User Activity
					$this->activity_model->add(1);
					$this->session->set_flashdata('msg', 'Village has been added successfully!');
					redirect(base_url('admin/villages'));
				}
			}
		} else {
			$data['view'] = 'admin/villages/village_add';
			$this->load->view('layout', $data);
		}
	}

	public function edit($id = 0) {

		if($this->input->post('submit')) {
			$this->form_validation->set_rules('village_court', 'village_court', 'trim|required');
			$this->form_validation->set_rules('fine_amount', 'fine_amount', 'trim|required');
			$this->form_validation->set_rules('payable_to', 'payable_to', 'trim|required');
			$this->form_validation->set_rules('notes', 'notes', 'trim');
			$this->form_validation->set_rules('notes', 'state', 'trim');
			$this->form_validation->set_rules('notes', 'address1', 'trim');
			$this->form_validation->set_rules('notes', 'address2', 'trim');
			$this->form_validation->set_rules('notes', 'city', 'trim');
			$this->form_validation->set_rules('notes', 'zip', 'trim');
			$this->form_validation->set_rules('stripe_pub_key', 'stripe_pub_key', 'trim');
			$this->form_validation->set_rules('stripe_sec_key', 'stripe_sec_key', 'trim');

			if ($this->form_validation->run() == FALSE) {
				$data['view'] = 'admin/villages/village_edit';
				$this->load->view('layout', $data);
			} else {
				$data = array(
					'village_court' => $this->input->post('village_court'),
					'fine_amount' => $this->input->post('fine_amount'),
					'payable_to' => $this->input->post('payable_to'),
					'state' => $this->input->post('state'),
					'address1' => $this->input->post('address1'),
					'address2' => $this->input->post('address2'),
					'city' => $this->input->post('city'),
					'zip' => $this->input->post('zip'),
					'date_added' => $this->input->post('date_added'),
					'status' => $this->input->post('status'),
					'stripe_pub_key' => $this->input->post('stripe_pub_key'),
					'stripe_sec_key' => $this->input->post('stripe_sec_key')
				);
				
				/* $config['upload_path'] = './public/images/villages';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('village_logo')) {
					$this->upload->display_errors();
				} else {
					$upload_data = $this->upload->data();
					$data['village_logo'] = $upload_data['file_name'];
				} */

				$images = Slim::getImages('village_logo');
				if ($images != false) {
					foreach ($images as $image) {
						if (isset($image['output']['data'])) {
							$img_name = $image['output']['name'];
							$img_data = $image['output']['data'];
							$input = Slim::saveFile($img_data, $img_name, './public/images/villages');
							$data['village_logo'] = $input['name'];
						}
					}
				}

				$data['date_modified'] = now();

				$data = $this->security->xss_clean($data);
				$result = $this->village_model->edit_village($data, $id);
				if($result){
					$this->activity_model->add(2);
					$this->session->set_flashdata('msg', 'Village has been updated successfully!');
					redirect(base_url('admin/villages'));
				}
			}
		}
		else{
			$data['village'] = $this->village_model->get_village_by_id($id);
			$user_details = $this->user_model->get_user_by_id($data['village']['added_by']);
			$data['village']['added_by_details'] = $user_details['firstname'] . ' ' . $user_details['lastname'];
			$data['view'] = 'admin/villages/village_edit';
			$this->load->view('layout', $data);
		}
	}

	public function del($id = 0){
		$this->db->delete('ci_villages', array('id' => $id));

		// Add User Activity
		$this->activity_model->add(3);

		$this->session->set_flashdata('msg', 'Village has been deleted successfully!');
		redirect(base_url('admin/villages'));
	}

	public function get_village_due($id = 0){
		$violation = $this->village_model->get_village_by_id($id);
		echo json_encode(array('violation' => $violation));
		exit;
	}
}