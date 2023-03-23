<?php
class MY_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if(!$this->session->has_userdata('is_admin_login'))
		{
			redirect('auth/login');
		}

		//general settings
        $global_data['general_settings'] = $this->setting_model->get_general_settings();
        $this->general_settings = $global_data['general_settings'];

        //set timezone
        date_default_timezone_set($this->general_settings['timezone']);
	}
}

class UR_Controller extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if(!$this->session->has_userdata('is_user_login'))
		{
			redirect('auth/login');
		}

		//general settings
        $global_data['general_settings'] = $this->setting_model->get_general_settings();
        $this->general_settings = $global_data['general_settings'];

        //set timezone
        date_default_timezone_set($this->general_settings['timezone']);

        //recaptcha status
        $global_data['recaptcha_status'] = true;
        if (empty($this->general_settings['recaptcha_site_key']) || empty($this->general_settings['recaptcha_secret_key']) || $this->$global_data['recaptcha_status'] == '0') {
            $global_data['recaptcha_status'] = false;
        }
        $this->recaptcha_status = $global_data['recaptcha_status'];
	}
}

?>