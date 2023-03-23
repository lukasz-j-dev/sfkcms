<?php defined('BASEPATH') OR exit('No direct script access allowed');

// Shang
use \Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

class Plates extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->model('admin/plates_model', 'plates_model');
		$this->load->model('admin/violation_model', 'violation_model');
		$this->load->model('admin/user_model', 'user_model');
		$this->load->model('activity_model','activity_model');

		$this->load->library('datatable');
		
		$this->load->helper('url');
		$this->load->helper('date');

	}

		//-----------------------------------------------------------------------

	public function index(){

		$data['view'] = 'admin/plates/plates_list';
		$this->load->view('layout', $data);

	}
	
	public function datatable_json(){				   					   
		$records = $this->plates_model->get_all_plates();
		$data = array();

		foreach ($records['data']  as $row) 
		{  
			$data[]= array(
				'<input type="checkbox" class="plate_check" name="plate_id[]" value="' . $row['id'] . '"/>',
				$row['id'],
				$row['plate'],
				$row['plate_type'],
				$row['city'],
				$row['state'],
				$row['zip_code'],
				$row['name'],
				$row['body'],
				$row['year'],
				$row['make'],
				$row['model'],
				$row['color'],
				$row['dmv_status'],
				$row['last_fetched_date'],
				'<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/plates/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/plates/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				',
			);
		}

		$records['data']=$data;
		echo json_encode($records);						   
	}
	
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('plate', 'plate', 'trim|required');
			$this->form_validation->set_rules('plate_type', 'plate_type', 'trim');
			$this->form_validation->set_rules('name', 'name', 'trim');
			$this->form_validation->set_rules('address', 'address', 'trim');
			$this->form_validation->set_rules('city', 'city', 'trim');
			$this->form_validation->set_rules('state', 'state', 'trim');
			$this->form_validation->set_rules('zip_code', 'zip_code', 'trim');
			$this->form_validation->set_rules('vin', 'vin', 'trim');
			$this->form_validation->set_rules('body', 'body', 'trim');
			$this->form_validation->set_rules('year', 'year', 'trim');
			$this->form_validation->set_rules('make', 'make', 'trim');
			$this->form_validation->set_rules('color', 'color', 'trim');
			$this->form_validation->set_rules('dmv_date_checked', 'dmv_date_checked', 'trim');
			$this->form_validation->set_rules('dmv_status', 'dmv_status', 'trim');
			$this->form_validation->set_rules('exp_date', 'exp_date', 'trim');
			$this->form_validation->set_rules('sex', 'sex', 'trim');
			$this->form_validation->set_rules('birth_date', 'birth_date', 'trim');
			$this->form_validation->set_rules('country', 'country', 'trim');
			$this->form_validation->set_rules('mid_number', 'mid_number', 'trim');
			$this->form_validation->set_rules('screenshot', 'screenshot', 'trim');
			if ($this->form_validation->run() == FALSE) {

				$data['view'] = 'admin/plates/plate_add';

				$this->load->view('layout', $data);

			}else{
				$plate = $this->input->post('plate');
				if($this->plates_model->plate_exist($plate)){
					$this->session->set_flashdata('msg1', 'Plate Number Exist');
					redirect(base_url('admin/plates'));
					exit;
				}
				$data = array(

					'plate' => $plate,

					'plate_type' => $this->input->post('plate_type'),

					'name' => $this->input->post('name'),

					'address' => $this->input->post('address'),

					'city' => $this->input->post('city'),

					'state' => $this->input->post('state'),
					
					'zip_code' => $this->input->post('zip_code'),
					'vin' => $this->input->post('vin'),
					'body' => $this->input->post('body'),
					'year' => $this->input->post('year'),
					'make' => $this->input->post('make'),
					'color' => $this->input->post('color'),
					
					'dmv_date_checked' =>  $this->input->post('dmv_date_checked'),

					'dmv_status' => $this->input->post('dmv_status'),
					'exp_date' => $this->input->post('exp_date'),
					'sex' => $this->input->post('sex'),
					'birth_date' => $this->input->post('birth_date'),
					'country' => $this->input->post('country'),
					'mid_number' => $this->input->post('mid_number'),
					'screenshot' => $this->input->post('screenshot'),
					'date_added' => date('Y-m-d H:i:s'),

				);
				$data = $this->security->xss_clean($data);

				$result = $this->plates_model->add_plate($data);
				if($result){
					// Add User Activity

					$this->activity_model->add(1);

					$this->session->set_flashdata('msg', 'Plate has been added successfully!');

					redirect(base_url('admin/plates'));

				}
			}

		}else{
			$data['view'] = 'admin/plates/plate_add';

			$this->load->view('layout', $data);

		}

	}
	public function add_ajax(){
		$json_resp = array();
		if($this->input->post('plate')){
			$plate = $this->input->post('plate');
			if($this->plates_model->plate_exist($plate)){
				$json_resp['exist'] = true;
			}else{
				$json_resp['exist'] = false;
				$data = array(
					'plate' => $plate,
					'date_added' => date('Y-m-d H:i:s'),
				);
				$data = $this->security->xss_clean($data);
				$result = $this->plates_model->add_plate($data);
				if($result) $json_resp['resp'] = true;
			}
			$json_resp['success'] = true;
		}else $json_resp['success'] = false;
		echo json_encode($json_resp);
		exit;
	}
	public function edit($id = 0){
		if($this->input->post('submit')){
			$this->form_validation->set_rules('plate_type', 'plate_type', 'trim');
			$this->form_validation->set_rules('name', 'name', 'trim');
			$this->form_validation->set_rules('address', 'address', 'trim');
			$this->form_validation->set_rules('city', 'city', 'trim');
			$this->form_validation->set_rules('state', 'state', 'trim');
			$this->form_validation->set_rules('zip_code', 'zip_code', 'trim');
			$this->form_validation->set_rules('vin', 'vin', 'trim');
			$this->form_validation->set_rules('body', 'body', 'trim');
			$this->form_validation->set_rules('year', 'year', 'trim');
			$this->form_validation->set_rules('make', 'make', 'trim');
			$this->form_validation->set_rules('color', 'color', 'trim');
			$this->form_validation->set_rules('dmv_date_checked', 'dmv_date_checked', 'trim');
			$this->form_validation->set_rules('dmv_status', 'dmv_status', 'trim');
			$this->form_validation->set_rules('exp_date', 'exp_date', 'trim');
			$this->form_validation->set_rules('sex', 'sex', 'trim');
			$this->form_validation->set_rules('birth_date', 'birth_date', 'trim');
			$this->form_validation->set_rules('country', 'country', 'trim');
			$this->form_validation->set_rules('mid_number', 'mid_number', 'trim');
			$this->form_validation->set_rules('screenshot', 'screenshot', 'trim');
			if ($this->form_validation->run() == FALSE) {

				$data['view'] = 'admin/plates/plate_edit';

				$this->load->view('layout', $data);

			}else{
				$data = array(

					'plate_type' => $this->input->post('plate_type'),

					'name' => $this->input->post('name'),

					'address' => $this->input->post('address'),

					'city' => $this->input->post('city'),

					'state' => $this->input->post('state'),
					
					'zip_code' => $this->input->post('zip_code'),
					'vin' => $this->input->post('vin'),
					'body' => $this->input->post('body'),
					'year' => $this->input->post('year'),
					'make' => $this->input->post('make'),
					'color' => $this->input->post('color'),
						'last_fetched_date' => $this->input->post('last_fetched_date'),
					
					'dmv_date_checked' =>  $this->input->post('dmv_date_checked'),

					'dmv_status' => $this->input->post('dmv_status'),
					'exp_date' => $this->input->post('exp_date'),
					'sex' => $this->input->post('sex'),
					'birth_date' => $this->input->post('birth_date'),
					'country' => $this->input->post('country'),
					'mid_number' => $this->input->post('mid_number'),
					'screenshot' => $this->input->post('screenshot'),

				);
				$data = $this->security->xss_clean($data);

				$result = $this->plates_model->edit_plate($data, $id);
				if($result){
					// Add User Activity

					$this->activity_model->add(1);

					$this->session->set_flashdata('msg', 'Plate has been added successfully!');

					redirect(base_url('admin/plates'));

				}
			}
		}
		else{
			$data['plate_details'] = $this->plates_model->get_plate_by_id($id);
			$data['view'] = 'admin/plates/plate_edit';
			$this->load->view('layout', $data);
		}
	}
	public function del($id = 0){
		$this->db->delete('ci_plates', array('id' => $id));

		// Add User Activity
		$this->activity_model->add(3);

		$this->session->set_flashdata('msg', 'Plates has been deleted successfully!');
		redirect(base_url('admin/plates'));
	}
	public function import(){
		$data['view'] = 'admin/plates/import';
		$this->load->view('layout', $data);
	}
	public function importcsv(){
		if($this->input->post('submit')){
			$handle = fopen($_FILES["plate_xlsx"]["tmp_name"], 'r');
			$plate_head = fgetcsv($handle, 1000, ",");
			while (($v = fgetcsv($handle, 1000, ",")) !== FALSE){
				if(!empty($v[array_search("Plate", $plate_head)])){
					$plate_details = $this->plates_model->get_plates_by_plate($v[array_search("Plate", $plate_head)]);
					if(!empty($plate_details['id'])){
						$up_data = array(

							'plate' => $v[array_search("Plate", $plate_head)],

							'plate_type' => $v[array_search("Plate type", $plate_head)],

							'name' => $v[array_search("Name", $plate_head)],

							'address' => $v[array_search("Address", $plate_head)],
							
							'city' => $v[array_search("City", $plate_head)],
							'state' => $v[array_search("State", $plate_head)],
							'zip_code' => $v[array_search("Zip code", $plate_head)],
							'vin' => $v[array_search("VIN", $plate_head)],
							'body' => $v[array_search("Body", $plate_head)],
							'year' => $v[array_search("Year", $plate_head)],
							
							'make' =>  $v[array_search("Make", $plate_head)],

							'color' => $v[array_search("Color", $plate_head)],
							'dmv_status' => $v[array_search("DMV Status", $plate_head)],
							'sex' => $v[array_search("Sex", $plate_head)],
							'country' => $v[array_search("County", $plate_head)],
							'mid_number' => $v[array_search("MID Number", $plate_head)],
							'screenshot' => $v[array_search("screenshot", $plate_head)],
							'date_added' => date('Y-m-d H:i:s'),

						);
						$dmv_date = $v[array_search("DMV Date checked", $plate_head)];
						$birth_date = $v[array_search("Birth Date", $plate_head)];
						$exp_date = $v[array_search("Expiration Date", $plate_head)];
						$up_data['dmv_date_checked'] = $dmv_date;
						$up_data['birth_date'] = $birth_date;
						$up_data['exp_date'] = $exp_date;
						$up_data = $this->security->xss_clean($up_data);
						//print_r($up_data);
						$this->plates_model->edit_plate($up_data, $plate_details['id']);
					}else{
						$ins_data = array(

							'plate' => $v[array_search("Plate", $plate_head)],

							'plate_type' => $v[array_search("Plate type", $plate_head)],

							'name' => $v[array_search("Name", $plate_head)],

							'address' => $v[array_search("Address", $plate_head)],
							
							'city' => $v[array_search("City", $plate_head)],
							'state' => $v[array_search("State", $plate_head)],
							'zip_code' => $v[array_search("Zip code", $plate_head)],
							'vin' => $v[array_search("VIN", $plate_head)],
							'body' => $v[array_search("Body", $plate_head)],
							'year' => $v[array_search("Year", $plate_head)],
							
							'make' =>  $v[array_search("Make", $plate_head)],

							'color' => $v[array_search("Color", $plate_head)],
							'dmv_status' => $v[array_search("DMV Status", $plate_head)],
							'sex' => $v[array_search("Sex", $plate_head)],
							'country' => $v[array_search("County", $plate_head)],
							'mid_number' => $v[array_search("MID Number", $plate_head)],
							'screenshot' => $v[array_search("screenshot", $plate_head)],
							'date_added' => date('Y-m-d H:i:s'),

						);
						$dmv_date = $v[array_search("DMV Date checked", $plate_head)];
						$birth_date = $v[array_search("Birth Date", $plate_head)];
						$exp_date = $v[array_search("Expiration Date", $plate_head)];
						$ins_data['dmv_date_checked'] = $dmv_date;
						$ins_data['birth_date'] = $birth_date;
						$ins_data['exp_date'] = $exp_date;
						$ins_data = $this->security->xss_clean($ins_data);
						if(!$this->plates_model->plate_exist($v[array_search("Plate", $plate_head)])) $result = $this->plates_model->add_plate($ins_data);
					}
				}
			}
			$this->session->set_flashdata('msg', 'Plates has been imported successfully!');
			redirect(base_url('admin/plates'));
			exit;
		}
		$data['view'] = 'admin/plates/import';
		$this->load->view('layout', $data);
	}
	public function exportcsv(){
		if(!empty($_REQUEST['plate_id'])){
			$plate_ids = $_REQUEST['plate_id'];
			$records = $this->db->where_in('id', $plate_ids)->get('ci_plates')->result_array();
			print_r($records);
			if(count($records) > 0){ 
				$delimiter = ","; 
				$filename = "Plates Report.csv"; 
				 
				// Create a file pointer 
				$f = fopen('php://memory', 'w'); 
				 
				// Set column headers 
				$fields = array('Id', 'Plate', 'Plate type', 'Name', 'Address', 'City', 'State', 'Zip code', 'VIN', 'Body', 'Year', 'Make', 'Color', 'DMV Date checked', 'DMV Status', 'Expiration Date', 'Sex', 'Birth Date', 'County', 'MID Number', 'screenshot'); 
				fputcsv($f, $fields, $delimiter); 
				 
				foreach ($records as $val){
					$lineData = array($val['id'], $val['plate'], $val['plate_type'], $val['name'], $val['address'], $val['city'], $val['state'], $val['zip_code'], $val['vin'], $val['body'], $val['year'], $val['make'], $val['color'], $val['dmv_date_checked'], $val['dmv_status'], $val['exp_date'], $val['sex'], $val['birth_date'], $val['country'], $val['mid_number'], $val['screenshot']); 
					fputcsv($f, $lineData, $delimiter); 
				} 
				 
				// Move back to beginning of file 
				fseek($f, 0); 
				 
				// Set headers to download file rather than displayed 
				header('Content-Type: text/csv'); 
				header('Content-Disposition: attachment; filename="' . $filename . '";'); 
				 
				//output all remaining data on a file pointer 
				fpassthru($f); 
			}
		}
	}
	public function exportallcsv(){
		$records = $this->plates_model->get_all_simple_plates();
		if(count($records) > 0){ 
			$delimiter = ","; 
			$filename = "Plates Report.csv"; 
			 
			// Create a file pointer 
			$f = fopen('php://memory', 'w'); 
			 
			// Set column headers 
			$fields = array('Id', 'Plate', 'Plate type', 'Name', 'Address', 'City', 'State', 'Zip code', 'VIN', 'Body', 'Year', 'Make', 'Color', 'DMV Date checked', 'DMV Status', 'Expiration Date', 'Sex', 'Birth Date', 'County', 'MID Number', 'screenshot'); 
			fputcsv($f, $fields, $delimiter); 
			 
			foreach ($records as $val){
				$lineData = array($val['id'], $val['plate'], $val['plate_type'], $val['name'], $val['address'], $val['city'], $val['state'], $val['zip_code'], $val['vin'], $val['body'], $val['year'], $val['make'], $val['color'], $val['dmv_date_checked'], $val['dmv_status'], $val['exp_date'], $val['sex'], $val['birth_date'], $val['country'], $val['mid_number'], $val['screenshot']); 
				fputcsv($f, $lineData, $delimiter); 
			} 
			 
			// Move back to beginning of file 
			fseek($f, 0); 
			 
			// Set headers to download file rather than displayed 
			header('Content-Type: text/csv'); 
			header('Content-Disposition: attachment; filename="' . $filename . '";'); 
			 
			//output all remaining data on a file pointer 
			fpassthru($f); 
		}
	}
	public function plate_search($plate){
		$json_resp = array();
		$json_resp['plate_details'] = $this->plates_model->get_plates_by_plate($plate);
		echo json_encode($json_resp);
		exit;
	}
	
	
	// Shang
	public function dmv() {
		$userinfo = $this->plates_model->get_platforms('secap.dmv.ny.gov');
		// echo json_encode($records['username']);

		$username = $userinfo['username'];
		$password = $userinfo['password'];

		$scrape_url = 'https://secap.dmv.ny.gov/unprotected/login.asp?TYPE=33554433&REALMOID=06-93023bcb-6c25-4aa3-a201-9f93831e5bb4&GUID=&SMAUTHREASON=0&METHOD=GET&SMAGENTNAME=-SM-K4n8LqMu7Cigm4zPM4qbXjq%2f61Tg9RG2zD8XN2Fv5DTpKL1rfVBO3wWEMRU0MACS&TARGET=-SM-https%3a%2f%2fsecap%2edmv%2eny%2egov%2fvpass%2fvpass_initial%2ecfm';
		$agent = 'Mozilla/5.0 (Ubuntu; Mobile) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36';

		$records = $this->plates_model->get_plates();
		if ( $username && $password && count($records) ) {
			foreach ($records as $record) {
				$plate_id = $record['plate'];
            	$exp_date = $record['exp_date'];
            	$today = date('m/d/Y');

				if ( empty($exp_date) || (strtotime($today) > strtotime($exp_date)) ) {
				// if ( empty($exp_date) ) {
					$client  = new Client(HttpClient::create(['timeout' => 60]));
					$client->setServerParameter('user-agent', $agent);
					$crawler = $client->request('GET', $scrape_url);
					$login_form = $crawler->selectButton('Login')->form();
					$crawler = $client->submit($login_form, [
						'USER'      => $username,
						'PASSWORD'  => $password
					]);
	
					rand(2, 5);
	
					// Find DMV Menu (VPass)
					if ( $crawler->filter("form[name='vpass_menu'] .left > a:nth-child(3)")->count() ) {
						$registration_inquiry_link = $crawler->selectLink(trim('PREED Registration Inquiry'))->link();
						$crawler = $client->click($registration_inquiry_link);
	
						rand(2, 5);
	
						// Electronic Terms of Service
						if ( $crawler->filter("form[name='emoupage1'] input[name='accept_agreement']")->count() ) {
							$form = $crawler->selectButton('Submit')->form();
							$form['accept_agreement']->select('Y');
							$crawler = $client->submit($form);
	
							rand(2, 5);
	
							// Agree form
							if ( $crawler->filter("#DPPAY")->count() ) {
								$form = $crawler->selectButton('I Agree')->form();
								$crawler = $client->submit($form);
	
								rand(2, 5);
	
								// Search plate information
								if ( $crawler->filter("input[name='plateIn']")->count() ) {
									$search_form = $crawler->selectButton('Search')->form();
									$crawler = $client->submit($search_form, [
										'plateIn' => $plate_id
									]);
	
									rand(1, 2);
									
									if ( $crawler->filter("#pgDetailArea .sectionDetails") ) {

										$arr_status = $crawler->filter('#pgDetailArea .sectionDetails .statusLine .flagText')->each(function ($node) use ($client) {
											return $node->text();
										});
										$status = isset($arr_status[0]) ? trim($arr_status[0]) : '';
	
										$arr_table0 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(0)->filter('.dataValue')->each(function ($node) use ($client) {
											return $node->text();
										});
										$plate_type      = isset($arr_table0[0]) ? explode(' - ', trim($arr_table0[0]))[1] : '';
										// $effective_date  = isset($arr_table0[1]) ? $arr_table0[1] : '';
										$expiration_date = isset($arr_table0[2]) ? trim($arr_table0[2]) : '';
	
										$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(0)->filter('.dataValue')->each(function ($node) use ($client) {
											return $node->text();
										});
										$name  = isset($arr_table1[0]) ? addslashes($arr_table1[0]) : '';
										$sex   = isset($arr_table1[1]) ? trim($arr_table1[1]) : '';
										$birth = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';
	
										$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(2)->filter('.dataValue')->each(function ($node) use ($client) {
											return $node->text();
										});
										$address = isset($arr_table1[0]) ? addslashes(trim($arr_table1[0])) : '';
										$county  = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';
	
										$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(3)->filter('.dataValue')->each(function ($node) use ($client) {
											return $node->text();
										});
										$arr_csz = isset($arr_table1[0]) ? trim($arr_table1[0]) : '';
										$city = ''; $state = ''; $zipcode = 0;
										if ( $arr_csz != '' ) {
											$temp    = explode(', ', $arr_csz);
											$city    = trim($temp[0]);
											$state   = explode(' ', trim($temp[1]))[0];
											$zipcode = explode(' ', trim($temp[1]))[1];
										}
										$mid_number = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';
	
										$arr_table2 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(2)->filter('.dataValue')->each(function ($node) use ($client) {
											return $node->text();
										});
										$vin   = isset($arr_table2[0]) ? trim($arr_table2[0]) : '';
										$body  = isset($arr_table2[1]) ? trim($arr_table2[1]) : '';
										$year  = isset($arr_table2[2]) ? trim($arr_table2[2]) : 0;
										$make  = isset($arr_table2[3]) ? trim($arr_table2[3]) : '';
										$color = isset($arr_table2[4]) ? trim($arr_table2[4]) : '';
	
										// $last_fetched_date = date('m/d/Y');

										$dvm_data = array(
											'status'          => $status,
											'plate_type'      => $plate_type,
											'expiration_date' => $expiration_date,
											'name'            => $name,
											'sex'             => $sex,
											'birth'           => $birth,
											'address'         => $address,
											'county'          => $county,
											'city'            => $city,
											'state'           => $state,
											'zipcode'         => $zipcode,
											'mid_number'      => $mid_number,
											'vin'             => $vin,
											'body'            => $body,
											'year'            => $year,
											'make'            => $make,
											'color'           => $color
										);
										// print_r($dvm_data);
										// die;
	
										// Update fetched data to the database
										echo $this->update_dvm( $dvm_data, $plate_id );
									}
								}
							}
						}
					}
					else if ( $crawler->filter("form[name='emoupage1'] input[name='accept_agreement']")->count() ) {	// Electronic Terms of Service
						$form = $crawler->selectButton('Submit')->form();
						$form['accept_agreement']->select('Y');
						$crawler = $client->submit($form);

						rand(2, 5);

						// Agree form
						if ( $crawler->filter("#DPPAY")->count() ) {
							$form = $crawler->selectButton('I Agree')->form();
							$crawler = $client->submit($form);

							rand(2, 5);

							// Search plate information
							if ( $crawler->filter("input[name='plateIn']")->count() ) {
								$search_form = $crawler->selectButton('Search')->form();
								$crawler = $client->submit($search_form, [
									'plateIn' => $plate_id
								]);

								rand(1, 2);
								
								if ( $crawler->filter("#pgDetailArea .sectionDetails") ) {

									$arr_status = $crawler->filter('#pgDetailArea .sectionDetails .statusLine .flagText')->each(function ($node) use ($client) {
										return $node->text();
									});
									$status = isset($arr_status[0]) ? trim($arr_status[0]) : '';

									$arr_table0 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(0)->filter('.dataValue')->each(function ($node) use ($client) {
										return $node->text();
									});
									$plate_type      = isset($arr_table0[0]) ? explode(' - ', trim($arr_table0[0]))[1] : '';
									// $effective_date  = isset($arr_table0[1]) ? $arr_table0[1] : '';
									$expiration_date = isset($arr_table0[2]) ? trim($arr_table0[2]) : '';

									$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(0)->filter('.dataValue')->each(function ($node) use ($client) {
										return $node->text();
									});
									$name  = isset($arr_table1[0]) ? addslashes($arr_table1[0]) : '';
									$sex   = isset($arr_table1[1]) ? trim($arr_table1[1]) : '';
									$birth = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

									$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(2)->filter('.dataValue')->each(function ($node) use ($client) {
										return $node->text();
									});
									$address = isset($arr_table1[0]) ? addslashes(trim($arr_table1[0])) : '';
									$county  = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

									$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(3)->filter('.dataValue')->each(function ($node) use ($client) {
										return $node->text();
									});
									$arr_csz = isset($arr_table1[0]) ? trim($arr_table1[0]) : '';
									$city = ''; $state = ''; $zipcode = 0;
									if ( $arr_csz != '' ) {
										$temp    = explode(', ', $arr_csz);
										$city    = trim($temp[0]);
										$state   = explode(' ', trim($temp[1]))[0];
										$zipcode = explode(' ', trim($temp[1]))[1];
									}
									$mid_number = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

									$arr_table2 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(2)->filter('.dataValue')->each(function ($node) use ($client) {
										return $node->text();
									});
									$vin   = isset($arr_table2[0]) ? trim($arr_table2[0]) : '';
									$body  = isset($arr_table2[1]) ? trim($arr_table2[1]) : '';
									$year  = isset($arr_table2[2]) ? trim($arr_table2[2]) : 0;
									$make  = isset($arr_table2[3]) ? trim($arr_table2[3]) : '';
									$color = isset($arr_table2[4]) ? trim($arr_table2[4]) : '';

									// $last_fetched_date = date('m/d/Y');

									$dvm_data = array(
										'status'          => $status,
										'plate_type'      => $plate_type,
										'expiration_date' => $expiration_date,
										'name'            => $name,
										'sex'             => $sex,
										'birth'           => $birth,
										'address'         => $address,
										'county'          => $county,
										'city'            => $city,
										'state'           => $state,
										'zipcode'         => $zipcode,
										'mid_number'      => $mid_number,
										'vin'             => $vin,
										'body'            => $body,
										'year'            => $year,
										'make'            => $make,
										'color'           => $color
									);
									// print_r($dvm_data);
									// die;

									// Update fetched data to the database
									echo $this->update_dvm( $dvm_data, $plate_id );
								}
							}
						}
					}
					else if ( $crawler->filter("#DPPAY")->count() ) {	// Agree form
						$form = $crawler->selectButton('I Agree')->form();
						$crawler = $client->submit($form);

						rand(2, 5);

						// Search plate information
						if ( $crawler->filter("input[name='plateIn']")->count() ) {
							$search_form = $crawler->selectButton('Search')->form();
							$crawler = $client->submit($search_form, [
								'plateIn' => $plate_id
							]);

							rand(1, 2);
							
							if ( $crawler->filter("#pgDetailArea .sectionDetails") ) {

								$arr_status = $crawler->filter('#pgDetailArea .sectionDetails .statusLine .flagText')->each(function ($node) use ($client) {
									return $node->text();
								});
								$status = isset($arr_status[0]) ? trim($arr_status[0]) : '';

								$arr_table0 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(0)->filter('.dataValue')->each(function ($node) use ($client) {
									return $node->text();
								});
								$plate_type      = isset($arr_table0[0]) ? explode(' - ', trim($arr_table0[0]))[1] : '';
								// $effective_date  = isset($arr_table0[1]) ? $arr_table0[1] : '';
								$expiration_date = isset($arr_table0[2]) ? trim($arr_table0[2]) : '';

								$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(0)->filter('.dataValue')->each(function ($node) use ($client) {
									return $node->text();
								});
								$name  = isset($arr_table1[0]) ? addslashes($arr_table1[0]) : '';
								$sex   = isset($arr_table1[1]) ? trim($arr_table1[1]) : '';
								$birth = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

								$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(2)->filter('.dataValue')->each(function ($node) use ($client) {
									return $node->text();
								});
								$address = isset($arr_table1[0]) ? addslashes(trim($arr_table1[0])) : '';
								$county  = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

								$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(3)->filter('.dataValue')->each(function ($node) use ($client) {
									return $node->text();
								});
								$arr_csz = isset($arr_table1[0]) ? trim($arr_table1[0]) : '';
								$city = ''; $state = ''; $zipcode = 0;
								if ( $arr_csz != '' ) {
									$temp    = explode(', ', $arr_csz);
									$city    = trim($temp[0]);
									$state   = explode(' ', trim($temp[1]))[0];
									$zipcode = explode(' ', trim($temp[1]))[1];
								}
								$mid_number = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

								$arr_table2 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(2)->filter('.dataValue')->each(function ($node) use ($client) {
									return $node->text();
								});
								$vin   = isset($arr_table2[0]) ? trim($arr_table2[0]) : '';
								$body  = isset($arr_table2[1]) ? trim($arr_table2[1]) : '';
								$year  = isset($arr_table2[2]) ? trim($arr_table2[2]) : 0;
								$make  = isset($arr_table2[3]) ? trim($arr_table2[3]) : '';
								$color = isset($arr_table2[4]) ? trim($arr_table2[4]) : '';

								// $last_fetched_date = date('m/d/Y');

								$dvm_data = array(
									'status'          => $status,
									'plate_type'      => $plate_type,
									'expiration_date' => $expiration_date,
									'name'            => $name,
									'sex'             => $sex,
									'birth'           => $birth,
									'address'         => $address,
									'county'          => $county,
									'city'            => $city,
									'state'           => $state,
									'zipcode'         => $zipcode,
									'mid_number'      => $mid_number,
									'vin'             => $vin,
									'body'            => $body,
									'year'            => $year,
									'make'            => $make,
									'color'           => $color
								);
								// print_r($dvm_data);
								// die;

								// Update fetched data to the database
								echo $this->update_dvm( $dvm_data, $plate_id );
							}
						}
					}
					else if ( $crawler->filter("input[name='plateIn']")->count() ) {		// Search plate information
						$search_form = $crawler->selectButton('Search')->form();
						$crawler = $client->submit($search_form, [
							'plateIn' => $plate_id
						]);

						rand(1, 2);
						
						if ( $crawler->filter("#pgDetailArea .sectionDetails") ) {

							$arr_status = $crawler->filter('#pgDetailArea .sectionDetails .statusLine .flagText')->each(function ($node) use ($client) {
								return $node->text();
							});
							$status = isset($arr_status[0]) ? trim($arr_status[0]) : '';

							$arr_table0 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(0)->filter('.dataValue')->each(function ($node) use ($client) {
								return $node->text();
							});
							$plate_type      = isset($arr_table0[0]) ? explode(' - ', trim($arr_table0[0]))[1] : '';
							// $effective_date  = isset($arr_table0[1]) ? $arr_table0[1] : '';
							$expiration_date = isset($arr_table0[2]) ? trim($arr_table0[2]) : '';

							$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(0)->filter('.dataValue')->each(function ($node) use ($client) {
								return $node->text();
							});
							$name  = isset($arr_table1[0]) ? addslashes($arr_table1[0]) : '';
							$sex   = isset($arr_table1[1]) ? trim($arr_table1[1]) : '';
							$birth = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

							$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(2)->filter('.dataValue')->each(function ($node) use ($client) {
								return $node->text();
							});
							$address = isset($arr_table1[0]) ? addslashes(trim($arr_table1[0])) : '';
							$county  = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

							$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(3)->filter('.dataValue')->each(function ($node) use ($client) {
								return $node->text();
							});
							$arr_csz = isset($arr_table1[0]) ? trim($arr_table1[0]) : '';
							$city = ''; $state = ''; $zipcode = 0;
							if ( $arr_csz != '' ) {
								$temp    = explode(', ', $arr_csz);
								$city    = trim($temp[0]);
								$state   = explode(' ', trim($temp[1]))[0];
								$zipcode = explode(' ', trim($temp[1]))[1];
							}
							$mid_number = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

							$arr_table2 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(2)->filter('.dataValue')->each(function ($node) use ($client) {
								return $node->text();
							});
							$vin   = isset($arr_table2[0]) ? trim($arr_table2[0]) : '';
							$body  = isset($arr_table2[1]) ? trim($arr_table2[1]) : '';
							$year  = isset($arr_table2[2]) ? trim($arr_table2[2]) : 0;
							$make  = isset($arr_table2[3]) ? trim($arr_table2[3]) : '';
							$color = isset($arr_table2[4]) ? trim($arr_table2[4]) : '';

							// $last_fetched_date = date('m/d/Y');

							$dvm_data = array(
								'status'          => $status,
								'plate_type'      => $plate_type,
								'expiration_date' => $expiration_date,
								'name'            => $name,
								'sex'             => $sex,
								'birth'           => $birth,
								'address'         => $address,
								'county'          => $county,
								'city'            => $city,
								'state'           => $state,
								'zipcode'         => $zipcode,
								'mid_number'      => $mid_number,
								'vin'             => $vin,
								'body'            => $body,
								'year'            => $year,
								'make'            => $make,
								'color'           => $color
							);
							// print_r($dvm_data);
							// die;

							// Update fetched data to the database
							echo $this->update_dvm( $dvm_data, $plate_id );
						}
					}
					else if ( $crawler->filter("#pgDetailArea .sectionDetails") ) {
						$arr_status = $crawler->filter('#pgDetailArea .sectionDetails .statusLine .flagText')->each(function ($node) use ($client) {
							return $node->text();
						});
						$status = trim($arr_status[0]);

						$arr_table0 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(0)->filter('.dataValue')->each(function ($node) use ($client) {
							return $node->text();
						});
						$plate_type      = isset($arr_table0[0]) ? explode(' - ', trim($arr_table0[0]))[1] : '';
						// $effective_date  = isset($arr_table0[1]) ? $arr_table0[1] : '';
						$expiration_date = isset($arr_table0[2]) ? trim($arr_table0[2]) : '';

						$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(0)->filter('.dataValue')->each(function ($node) use ($client) {
							return $node->text();
						});
						$name  = isset($arr_table1[0]) ? addslashes($arr_table1[0]) : '';
						$sex   = isset($arr_table1[1]) ? trim($arr_table1[1]) : '';
						$birth = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

						$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(2)->filter('.dataValue')->each(function ($node) use ($client) {
							return $node->text();
						});
						$address = isset($arr_table1[0]) ? addslashes(trim($arr_table1[0])) : '';
						$county  = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

						$arr_table1 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(1)->filter('tr')->eq(3)->filter('.dataValue')->each(function ($node) use ($client) {
							return $node->text();
						});
						$arr_csz = isset($arr_table1[0]) ? trim($arr_table1[0]) : '';
						$city = ''; $state = ''; $zipcode = '';
						if ( $arr_csz != '' ) {
							$temp    = explode(', ', $arr_csz);
							$city    = trim($temp[0]);
							$state   = explode(' ', trim($temp[1]))[0];
							$zipcode = explode(' ', trim($temp[1]))[1];
						}
						$mid_number = isset($arr_table1[2]) ? trim($arr_table1[2]) : '';

						$arr_table2 = $crawler->filter('#pgDetailArea .sectionDetails > table')->eq(2)->filter('.dataValue')->each(function ($node) use ($client) {
							return $node->text();
						});
						$vin   = isset($arr_table2[0]) ? trim($arr_table2[0]) : '';
						$body  = isset($arr_table2[1]) ? trim($arr_table2[1]) : '';
						$year  = isset($arr_table2[2]) ? trim($arr_table2[2]) : '';
						$make  = isset($arr_table2[3]) ? trim($arr_table2[3]) : '';
						$color = isset($arr_table2[4]) ? trim($arr_table2[4]) : '';

						// $last_fetched_date = date('m/d/Y');

						$dvm_data = array(
							'status'          => $status,
							'plate_type'      => $plate_type,
							'expiration_date' => $expiration_date,
							'name'            => $name,
							'sex'             => $sex,
							'birth'           => $birth,
							'address'         => $address,
							'county'          => $county,
							'city'            => $city,
							'state'           => $state,
							'zipcode'         => $zipcode,
							'mid_number'      => $mid_number,
							'vin'             => $vin,
							'body'            => $body,
							'year'            => $year,
							'make'            => $make,
							'color'           => $color
						);
						// print_r($dvm_data);
						// die;

						// Update fetched data to the database
						echo $this->update_dvm( $dvm_data, $plate_id );
					}

					$client  = null;
					$crawler = null;
				}
	
				rand(5, 8);
			}
			echo 'All information fetched';
		}
		else echo 'There is no data in your database';
	}
	
	public function bulk_update_dmv_status() {
		$datas = json_decode($this->input->post('data'));
		// print_r($datas);
		if ( is_array($datas) && count( $datas ) ) {
			foreach ( $datas as $data ) {
				if ( !empty($data->plate) ) {
					$record = $this->plates_model->get_plates_by_plate( $data->plate );

					// If plate exists already, but dmv_status is empty or blank
					if ( is_array($record) && isset($record['id']) ) {
						if ( is_null($record['dmv_status']) )
							$this->dmv_api( $data->plate, 0, $record['id'] );
					}
					else {	// If plate not exist, then add plate and check dmv_status
						$this->plates_model->add_plate( array('plate' => $data->plate) );
						$this->dmv_api( $data->plate );
					}
				}
			}
			
			echo 'success';
		}
		else 'err';
	}

	public function dmv_api( $plate = '', $violation_id = 0 ) {
		$userinfo = $this->plates_model->get_platforms('secap.dmv.ny.gov');
		$username = $userinfo['username'];
		$password = $userinfo['password'];

		$soapUrl = "https://wsc.dmv.ny.gov/sst/runtime.asvc/com.actional.intermediary.preed?WSDL"; // asmx URL of WSDL
		$records = null;

		$is_exist = $this->plates_model->plate_exist($plate);
		if ( $is_exist ) {
			$records = $this->plates_model->get_plates($plate);
		}
		else {
			if ( $plate && $violation_id ) {
				$this->plates_model->add_plate(array('plate' => $plate));
				$this->violation_model->edit_violation(array('plate' => $plate), $violation_id);
				$records = $this->plates_model->get_plates($plate);
			}
		}

		/*
		$records = $this->plates_model->get_plates($plate);
		// This is for DMV lookup in violation edit view.
		if ( !count($records) && $plate && $violation_id ) {
			$this->plates_model->add_plate(array('plate' => $plate));
			$this->violation_model->edit_violation(array('plate' => $plate), $violation_id);
			$records = $this->plates_model->get_plates($plate);
		}
		*/

		if ( $username && $password && count($records) ) {
// 			echo $username.$password.count($records);
			foreach ($records as $record) {
				$plate_id = $record['plate'];
            	$exp_date = $record['exp_date'];
            	$today = date('m/d/Y');

				if ( !empty($plate) || empty($exp_date) || (strtotime($today) > strtotime($exp_date)) ) {
				// if ( empty($exp_date) ) {
					// xml post structure
					$input_xml='
					<?xml version="1.0" encoding="utf-8"?>
					<soap:Envelope
						xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
						xmlns:xsd="http://www.w3.org/2001/XMLSchema"
						xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
						<soap:Body>
							<DmvPreedTransaction
								xmlns="http://tempuri.org/Preedweb/Preed">
								<TransXmlStruct>
									<user>'.$username.'</user>
									<password>'.$password.'</password>
									<IpAddress>'.$_SERVER['SERVER_ADDR'].'</IpAddress>
									<PlateNumber>'.$plate_id.'</PlateNumber>
									<TransactionCode>RCUR</TransactionCode>
								</TransXmlStruct>
							</DmvPreedTransaction>
						</soap:Body>
					</soap:Envelope>';
				// 	print_r($input_xml);

					$headers = array(
						"Content-type: text/xml;charset=\"utf-8\"",
						"Accept: text/xml",
						"Cache-Control: no-cache",
						"Pragma: no-cache",
						"SOAPAction: http://tempuri.org/Preedweb/Preed/DmvPreedTransaction", 
						"Content-length: " . strlen($input_xml),
					); //SOAPAction: your op URL
				// 	print_r($headers);

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $soapUrl);
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $input_xml); // the SOAP request
					curl_setopt($ch, CURLOPT_USERPWD, $username.":".$password); // username and password - declared at the top of the doc
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
					curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

					$response = curl_exec($ch); 
					curl_close($ch);

					// converting
					$response1 = str_replace("<soap:Body>" , "", $response);
					$response2 = str_replace("</soap:Body>", "", $response1);

					// convertingc to XML
					$parser = simplexml_load_string($response2);
					$array_data = json_decode(json_encode($parser), true);
				// 	print_r($array_data);
				// 	die;

					if ( is_array($array_data) && count($array_data) && $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['CompletionCde'] == 'SUCCESS' ) {
						// Status
						$status = '';
						if ( $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Status_Suspended'] == 'Y' )
							$status .= 'SUSPENDED, ';
						if ( $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Status_Revoked'] == 'Y' )
							$status .= 'REVOKED, ';
						if ( $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Status_Scofflaw'] == 'Y' )
							$status .= 'SCOFFLAW, ';
						if ( $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Status_Stolen'] == 'Y' )
							$status .= 'STOLEN, ';
						if ( $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Status_Surrendered'] == 'Y' )
							$status .= 'SURRENDERED, ';
						if ( $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Status_Reg_Expired'] == 'Y' )
							$status .= 'EXPIRED, ';
						if ( $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Status_Renewal_Denied'] == 'Y' )
							$status .= 'RENEWAL, DENIDED, ';
						if ( $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Status_History'] == 'Y' )
							$status .= 'HISTORY, ';
						if ( $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Status_Expired'] == 'Y' )
							$status .= 'EXPIRED, ';
						if ( $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Status_replaced'] == 'Y' )
							$status .= 'REPLACED, ';

						if ( $status == '' )
							$status = 'VALID';
						else
							$status = substr( $status, 0, strlen($status) - 2 );

						// Plate Type
						$plate_type = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Plate_Class_Out']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Plate_Class_Out']) )
							$plate_type = $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Plate_Class_Out'];

						// Expiration Date
						$expiration_date = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['expDate']) && 
							 is_numeric($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['expDate']) )
							$expiration_date = $this->convert_date_format($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['expDate']);

						// Name
						$name = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Name']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Name']) )
							$name = addslashes($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Name']);

						// Sex
						$sex = 'N/A';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['sex']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['sex']) )
							$sex = ($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['sex'] == 'F')?'FEMALE':'MALE';

						// Birthday
						$birth = 'N/A';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['DOB']) && 
							 is_numeric($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['DOB']) )
							$birth = $this->convert_date_format($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['DOB']);

						// address
						$address = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['street']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['street']) )
							$address = addslashes($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['street']);

						// City
						$city = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['City']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['City']) )
							$city = addslashes($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['City']);

						// State
						$state = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['State']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['State']) )
							$state = addslashes($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['State']);

						// Zip
						$zipcode = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Zip']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Zip']) )
							$zipcode = $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Zip'];

						// County
						$county = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['county']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['county']) )
							$county = $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['county'];

						// Mid number
						$mid_number = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['MIDNum']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['MIDNum']) )
							$mid_number = $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['MIDNum'];

						// Vin
						$vin = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VIN']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VIN']) )
							$vin = $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VIN'];

						// Body
						$body = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehBdyTypCde']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehBdyTypCde']) )
							$body = $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehBdyTypCde'];

						// Year
						$year = 0;
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehYear']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehYear']) )
							$year = $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehYear'];

						// Make
						$make = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehMake']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehMake']) )
							$make = $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehMake'];

						// Color
						$color = '';
						if ( !empty($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehColor']) && !is_array($array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehColor']) )
							$color = $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['VehColor'];

						$dvm_data = array(
							'status'          => $status,
							'plate_type'      => $plate_type,
							'expiration_date' => $expiration_date,
							'name'            => $name,
							'sex'             => $sex,
							'birth'           => $birth,
							'address'         => $address,
							'county'          => $county,
							'city'            => $city,
							'state'           => $state,
							'zipcode'         => $zipcode,
							'mid_number'      => $mid_number,
							'vin'             => $vin,
							'body'            => $body,
							'year'            => $year,
							'make'            => $make,
							'color'           => $color
						);
				// 		print_r($dvm_data);
				// 		echo '<br>';

						// Update fetched data to the database
						$this->update_dvm( $dvm_data, $plate_id );
					}
					else {
						$error = $array_data['DmvPreedTransactionResponse']['DmvPreedTransactionResult']['Errmsg'];
					    $query = "
                			update ci_plates 
                			set
                			
                			dmv_status = '$error',
                			last_fetched_date = '".date('m/d/Y')."'
                
                			where plate = '$plate_id'
                		";
                		$this->plates_model->update_dmv( $query );
					}
				}
				// sleep(0.5);
			}
		}
	}

	public function update_dvm( $dvm_data, $plate_id ) {
		$query = "
			update ci_plates 
			set
			
			plate_type = '".$dvm_data['plate_type']."',
			exp_date = '".$dvm_data['expiration_date']."',
			name = '".$dvm_data['name']."',
			address = '".$dvm_data['address']."',
			city = '".$dvm_data['city']."',
			state = '".$dvm_data['state']."',
			zip_code = '".$dvm_data['zipcode']."',
			vin = '".$dvm_data['vin']."',
			body = '".$dvm_data['body']."',
			year = '".$dvm_data['year']."',
			make = '".$dvm_data['make']."',
			color = '".$dvm_data['color']."',
			dmv_status = '".$dvm_data['status']."',
			sex = '".$dvm_data['sex']."',
			birth_date = '".$dvm_data['birth']."',
			country = '".$dvm_data['county']."',
			mid_number = '".$dvm_data['mid_number']."',
			last_fetched_date = '".date('m/d/Y')."'

			where plate = '$plate_id'
		";
// 		echo $query.'<br>';
// 		return $query;
		$this->plates_model->update_dmv( $query );
		return $plate_id . ' is updated.';
	}
	
	public function convert_date_format( $str ) {
		$temp_year  = substr($str, 0, 4);
		$temp_month = substr($str, 4, 2);
		$temp_day   = substr($str, -2);
		return $temp_month . '/' . $temp_day . '/' . $temp_year;
	}
	
	
	public function is_exist(){
		$json_resp = array();
		$plate = $this->input->post('plate');
		if(!empty($plate)){
			$json_resp['records'] = $this->plates_model->plate_exist($plate);
			$json_resp['success'] = true;
		}else $json_resp['success'] = false;
		echo json_encode($json_resp);
		exit;
	}
}

?>