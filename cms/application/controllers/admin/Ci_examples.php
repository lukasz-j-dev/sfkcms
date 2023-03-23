<?php defined('BASEPATH') OR exit('No direct script access allowed');
	class Ci_examples extends MY_Controller {
		public function __construct(){
			parent::__construct();
			$this->load->model('admin/ci_example_model', 'ci_example_model');
			$this->load->library('pagination'); // loaded codeigniter pagination liberary
			$this->load->library('datatable'); // loaded my custom 'serverside datatable' library
			$this->load->library('functions'); // loaded my custom 'functions' library 
		}
		//---------------------------------------------------
		// Calling Server-side processing View
		public function ajax_datatable(){
			$data['title'] = 'Server-side Datatable';
			$data['view'] = 'admin/ci_examples/ajax_datatable';
			$this->load->view('layout', $data);
		}
		//---------------------------------------------------
		// Server-side processing Datatable Example
		public function datatable_json(){				   					   
			$records = $this->ci_example_model->get_all_users();
	        $data = array();
	        $i =0;
	        foreach ($records['data']  as $row) 
			{  
				$status = ($row['is_active'] == 0)? 'inactive': 'active'.'<span>';
				$disabled = ($row['is_admin'] == 1)? 'disabled': ''.'<span>';
				$data[]= array(
					++$i,
					$row['username'],
					$row['email'],
					date('F j, Y',strtotime($row['created_at'])),
					'<span class="btn bg-teal  waves-effect" title="status">'.getGroupyName($row['role']).'<span>',	// get Group name by ID (getGroupyName() is a helper function)
					'<span class="btn bg-blue waves-effect" title="status">'.$status.'<span>'
				);
	        }
			$records['data']=$data;
	        echo json_encode($records);						   
		}
		//---------------------------------------------------	
		// simple datatable example
		public function simple_datatable(){
			$data['all_users'] =  $this->ci_example_model->get_all_simple_users();
			$data['title'] = 'Simple Datatable';
			$data['view'] = 'admin/ci_examples/simple_datatable';
			$this->load->view('layout', $data);
		}
		//---------------------------------------------------
		// Pagination Example
		public function pagination(){
			$count = $this->ci_example_model->count_all_users();
			$per_page_record = 10;
			$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
			$url= base_url("admin/ci_examples/pagination/");

			$config = $this->functions->pagination_config($url,$count,$per_page_record);
			$config['uri_segment'] = 4;		
			$this->pagination->initialize($config);

			$data['all_users']=$this->ci_example_model->get_all_users_for_pagination($per_page_record,$page);

			$data['title'] = 'Pagination Example';
			$data['view'] = 'admin/ci_examples/pagination';
			$this->load->view('layout', $data);
		}
		//---------------------------------------------------
		// File Upload
		public function file_upload(){
			if($this->input->post('submit')){
				$config = array(
					'upload_path' => "./uploads/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'overwrite' => TRUE,
					'max_size' => "2048000", // Can be set to particular file size , here it is 2 MB(2048 Kb)
					'max_height' => "1200",
					'max_width' => "1900"
					);
				$this->load->library('upload', $config);
				if($this->upload->do_upload())
				{
					$data = array('upload_data' => $this->upload->data());
					$data['view'] = 'admin/ci_examples/file_upload';
					$this->load->view('layout', $data);
				}
				else
				{
					$data['error'] = array('error' => $this->upload->display_errors());
					$data['view'] = 'admin/ci_examples/file_upload';
					$this->load->view('layout', $data);
				}
			}
			else{
				$data['title'] = 'File Upload';
				$data['view'] = 'admin/ci_examples/file_upload';
				$this->load->view('layout', $data);
			}
		}
		//---------------------------------------------------
		// Multiple File Upload
		public function multi_file_upload()
		{
			if($_FILES)
			{
				$config = array(
					'upload_path' => "./uploads/",
					'allowed_types' => "gif|jpg|png|jpeg|pdf",
					'encrypt_name' => TRUE,
					'overwrite' => TRUE,
					'max_size' => "2048000", // It is 2 MB(2048 Kb)
					'max_height' => "1200",
					'max_width' => "1900"
				);
				$this->load->library('upload', $config);

				if($this->upload->do_upload('file'))
				{
					$path = 'uploads/';

					$data = array(
						'name' => $path.$this->upload->data('file_name'),
						'created_at' => date('Y-m-d H:i:s')
					);

					$data = $this->security->xss_clean($data);

					$this->ci_example_model->add_multiple_files($data);

					$this->session->set_flashdata('msg','Files have been uploaded successfully');

					$return = array('status' => 'success' , 'message' => 'File Uploaded');

					echo json_encode($return);
				}
				else
				{
					$this->session->set_flashdata('error',$this->upload->display_errors());
					$return = array('status' => 'error' , 'message' => '');

					echo json_encode($return);
				}
			}
			else{
					$data['title'] = 'Multiple Files Upload';
					$data['files'] = $this->ci_example_model->get_uploaded_files();
					$data['view'] = 'admin/ci_examples/multi_file_upload';
					$this->load->view('layout', $data);
				}
		}

		public function delete_file($id ='')
		{
		$this->ci_example_model->delete_file($id);

		$this->session->set_flashdata('msg','File has been deleted successfully');
		redirect(base_url('admin/ci_examples/multi_file_upload'));
		}

		//---------------------------------------------------------------
		//  Export Users PDF 
		public function create_users_pdf(){
			$this->load->helper('pdf_helper'); // loaded pdf helper
			$data['all_users'] = $this->ci_example_model->get_all_simple_users();
			$this->load->view('admin/ci_examples/users_pdf', $data);
		}	
		//---------------------------------------------------------------	
		// Export data in CSV format 
		public function export_csv(){ 
		   // file name 
		   $filename = 'users_'.date('Y-m-d').'.csv'; 
		   header("Content-Description: File Transfer"); 
		   header("Content-Disposition: attachment; filename=$filename"); 
		   header("Content-Type: application/csv; ");
		   
		   // get data 
		   $user_data = $this->ci_example_model->get_users_for_csv();

		   // file creation 
		   $file = fopen('php://output', 'w');
		 
		   $header = array("ID", "Username", "First Name", "Last Name", "Email", "Mobile_no", "Created Date"); 
		   fputcsv($file, $header);
		   foreach ($user_data as $key=>$line){ 
		     fputcsv($file,$line); 
		   }
		   fclose($file); 
		   exit; 
		}

		// Get Country. State and City
		//------------------------------------------------
		public function location($value='')
		{
			$data['countries'] = $this->ci_example_model->get_countries_list();
			$data['title'] = 'Country, State & City';
			$data['view'] = 'admin/ci_examples/locations';
			$this->load->view('layout', $data);
		}

		// Get Country. State and City
		//----------------------------------------
		public function get_country_states()
		{
			$states = $this->db->select('*')->where('country_id',$this->input->post('country'))->get('ci_states')->result_array();
		    $options = array('' => 'Select State') + array_column($states,'name','id');
		    $html = form_dropdown('state',$options,'','class="form-control show-tick state" required');
			$error =  array('msg' => $html);
			echo json_encode($error);
		}

		//----------------------------------------
		public function get_state_cities()
		{
			$cities = $this->db->select('*')->where('state_id',$this->input->post('state'))->get('ci_cities')->result_array();
		    $options = array('' => 'Select City') + array_column($cities,'name','id');
		    $html = form_dropdown('city',$options,'','class="form-control show-tick city" required');
			$error =  array('msg' => $html);
			echo json_encode($error);
		}

		// Dynamic Charts

		public function charts()
		{
			$data['donut_chart'] = $this->ci_example_model->get_user_record_by_groups();
			$data['bar_chart'] = $this->ci_example_model->get_user_activity_by_month();
			$data['line_chart'] = $this->ci_example_model->get_user_activity_by_month_line_chart();
			$data['area_chart'] = $this->ci_example_model->get_user_record_by_year();
			$data['title'] = 'Dynamic Charts';
			$data['view'] = 'admin/ci_examples/charts';
			$this->load->view('layout', $data);
		}

		//---------------------------------------------------
		// Advanced Search Example
		public function advance_search(){

			$this->session->unset_userdata('user_search_type');
			$this->session->unset_userdata('user_search_from');
			$this->session->unset_userdata('user_search_to');
			$data['title'] = 'Advanced Search with Datatable';
			$data['view'] = 'admin/ci_examples/advance_search';
			$this->load->view('layout',$data);
		}

		//-------------------------------------------------------
		public function search(){
			$this->session->set_userdata('user_search_type',$this->input->post('user_search_type'));
			$this->session->set_userdata('user_search_from',$this->input->post('user_search_from'));
			$this->session->set_userdata('user_search_to',$this->input->post('user_search_to'));
		}

		//---------------------------------------------------
		// Server-side processing Datatable Example with Advance Search
		public function advance_datatable_json(){	

			$records = $this->ci_example_model->get_all_users_by_advance_search();
			$data = array();
			$i=0;
			foreach ($records['data']  as $row) 
			{  
				$status = ($row['is_active'] == 1)? 'Active': 'Inactive';
				$data[]= array(
					++$i,
					$row['username'],
					$row['email'],
					$row['mobile_no'],
					date('F d, Y ',strtotime($row['created_at'])),	
					'<span class="btn bg-blue  waves-effect" title="status">'.$status.'</span>',
				);
			}
			$records['data']=$data;
			echo json_encode($records);						   
		}

	}
?>