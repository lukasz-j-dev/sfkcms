<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends UR_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('user/user_model', 'user_model');
	}
	//-------------------------------------------------------------------------
	public function index(){
		if($this->input->post('submit')){
			$data = array(
				'username' => $this->input->post('username'),
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'email' => $this->input->post('email'),
				'mobile_no' => $this->input->post('mobile_no'),
				'updated_at' => date('Y-m-d : h:m:s'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->user_model->update_user($data);
			if($result){
				$this->session->set_flashdata('msg', 'Profile has been Updated Successfully!');
				redirect(base_url('user/profile'), 'refresh');
			}
		}
		else{
			$data['user'] = $this->user_model->get_user_detail();
			$data['title'] = 'User Profile';
			$data['view'] = 'user/profile';
			$this->load->view('layout', $data);
		}
	}

	//-------------------------------------------------------------------------
	public function change_pwd(){
		$id = $this->session->userdata('user_id');
		if($this->input->post('submit')){
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			$this->form_validation->set_rules('confirm_pwd', 'Confirm Password', 'trim|required|matches[password]');
			if ($this->form_validation->run() == FALSE) {
				$data['user'] = $this->user_model->get_user_detail();
				$data['view'] = 'user/profile';
				$this->load->view('layout', $data);
			}
			else{
				$data = array(
					'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT)
				);
				$data = $this->security->xss_clean($data);
				$result = $this->user_model->change_pwd($data, $id);
				if($result){
					$this->session->set_flashdata('msg', 'Password has been changed successfully!');
					redirect(base_url('user/profile'));
				}
			}
		}
		else{
			$data['user'] = $this->user_model->get_user_detail();
			$data['title'] = 'Change Password';
			$data['view'] = 'user/profile';
			$this->load->view('layout', $data);
		}
	}
}

?>	