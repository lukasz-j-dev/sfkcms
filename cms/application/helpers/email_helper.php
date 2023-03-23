<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function sendEmail($to = '', $subject  = '', $body = '', $attachment = '', $cc = '')
{
		$controller =& get_instance();
       	$controller->load->helper('path'); 
		
		$config = array();
        //$config['useragent']            = "CodeIgniter";
        //$config['mailpath']             = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
        $config['protocol']             = "smtp";
        $config['smtp_host']            = "smtp.mandrillapp.com";
        $config['smtp_crypto']          = "tls";
        $config['smtp_port']            = "587";
		$config['smtp_timeout'] 		= '30';
		$config['smtp_user']    		= "info@scbw.com";
		$config['smtp_pass']    		= "kBruSz95lM7aBKQaddSd7A";
        $config['mailtype'] 			= 'html';
        $config['charset']  			= 'utf-8';
        $config['newline']  			= "\r\n";
        $config['wordwrap'] 			= TRUE;
      
        $controller->load->library('email');

        $controller->email->initialize($config);
       
			
		$controller->email->from( 'notify@alert.stopforkids.com' , 'Village of Saddle Rock Court ' );
		
		$controller->email->to($to);
		
		$controller->email->subject($subject);
		
		$controller->email->message($body);
		
		
		
 		if($cc != '') 
 		{	
 			$controller->email->cc($cc);
 		}	
 		if($attachment != '')
		{
			$controller->email->attach(base_url()."pdfs/" . $attachment );
		 
 		}
 		if($controller->email->send()){
 			return true;
 		}
		else
		{
		  return false;
		}
    }
?>