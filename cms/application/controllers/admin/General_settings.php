<?php defined('BASEPATH') OR exit('No direct script access allowed');

class General_settings extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/setting_model', 'setting_model');
		$this->load->model('activity_model','activity_model');
		$this->load->library('functions');
	}

	//-------------------------------------------------------------------------
	// General Setting View
	public function index()
	{
		$data['general_settings'] = $this->setting_model->get_general_settings();

		$data['title'] = 'General Setting';
		$data['view'] = 'admin/general_settings/setting';
		$this->load->view('layout', $data);
	}

	//-------------------------------------------------------------------------
	public function add()
	{
		$data = array(
			'application_name' => $this->input->post('application_name'),
			'timezone' => $this->input->post('timezone'),
			'currency' => $this->input->post('currency'),
			'copyright' => $this->input->post('copyright'),
			'email_from' => $this->input->post('email_from'),
			'smtp_host' => $this->input->post('smtp_host'),
			'smtp_port' => $this->input->post('smtp_port'),
			'smtp_user' => $this->input->post('smtp_user'),
			'smtp_pass' => $this->input->post('smtp_pass'),
			'facebook_link' => $this->input->post('facebook_link'),
			'twitter_link' => $this->input->post('twitter_link'),
			'google_link' => $this->input->post('google_link'),
			'youtube_link' => $this->input->post('youtube_link'),
			'linkedin_link' => $this->input->post('linkedin_link'),
			'instagram_link' => $this->input->post('instagram_link'),
			'recaptcha_status' => $this->input->post('recaptcha_status'),
			'recaptcha_secret_key' => $this->input->post('recaptcha_secret_key'),
			'recaptcha_site_key' => $this->input->post('recaptcha_site_key'),
			'recaptcha_lang' => $this->input->post('recaptcha_lang'),
			'paypal_is_sandbox' => $this->input->post('paypal_is_sandbox', true),
			'paypal_sandbox_url' => $this->input->post('paypal_sandbox_url', true),
			'paypal_live_url' => $this->input->post('paypal_live_url', true),
			'paypal_email' => $this->input->post('paypal_email', true),
			'paypal_cur_code' => $this->input->post('paypal_cur_code', true),
			'stripe_secret_key' => $this->input->post('stripe_secret_key', true),
			'stripe_publish_key' => $this->input->post('stripe_publish_key', true),
			'created_date' => date('Y-m-d : h:m:s'),
			'updated_date' => date('Y-m-d : h:m:s')
		);

		$old_logo = $this->input->post('old_logo');
		$old_favicon = $this->input->post('old_favicon');

		$path="public/images/";

		if(!empty($_FILES['logo']['name']))
		{
			$this->functions->delete_file($old_logo);

			$result = $this->functions->file_insert($path, 'logo', 'image', '9097152');
			if($result['status'] == 1){
				$data['logo'] = $path.$result['msg'];
			}
			else{
				$this->session->set_flashdata('error', $result['msg']);
				redirect(base_url('admin/general_settings'), 'refresh');
			}
		}

		// favicon
		if(!empty($_FILES['favicon']['name']))
		{
			$this->functions->delete_file($old_favicon);

			$result = $this->functions->file_insert($path, 'favicon', 'image', '197152');
			if($result['status'] == 1){
				$data['favicon'] = $path.$result['msg'];
			}
			else{
				$this->session->set_flashdata('error', $result['msg']);
				redirect(base_url('admin/general_settings'), 'refresh');
			}
		}

		$data = $this->security->xss_clean($data);
		$result = $this->setting_model->update_general_setting($data);

		if($result){
			// Add User Activity
			$this->activity_model->add(11);

			$this->session->set_flashdata('msg', 'Setting has been changed Successfully!');
			redirect(base_url('admin/general_settings'), 'refresh');
		}
	}

}

?>	