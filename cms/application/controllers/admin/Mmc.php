<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class MMC extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->model('admin/mmc_model', 'mmc_model');
		$this->load->model('admin/user_model', 'user_model');
		$this->load->model('activity_model','activity_model');

		$this->load->library('datatable');
		
		$this->load->helper('url');
		$this->load->helper('date');
	}

	public function index(){

		$data['view'] = 'admin/mmc/mmc_list';
		$this->load->view('layout', $data);
	}

	public function datatable_json() {				   					   

		$records = $this->mmc_model->get_all_mmcs();
		$data = array();

		foreach ( $records['data'] as $row ) 
		{  
			$data[]= array(
				'<input type="checkbox" class="mmc_check" name="mmc_id[]" value="' . $row['id'] . '"/>',
				$row['id'],
				$row['video_name'],
				$row['image_name'],
				$row['plate'],
				$row['plate_region'],
				$row['plate_coordinates'],
				$row['plate_score'],
				$row['vehicle_type'],
				$row['make'],
				$row['model'],
				$row['color'],
				$row['vehicle_orientation'],
				$row['date'],
				$row['time'],
				'<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/mmc/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/mmc/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>',
			);
		}
		$records['data'] = $data;

		echo json_encode($records);						   
	}

	public function add() {

		if ( $this->input->post('submit') ) {
			$this->form_validation->set_rules('video_name', 'video_name', 'trim|required');
			$this->form_validation->set_rules('image_name', 'image_name', 'trim|required');
			$this->form_validation->set_rules('plate', 'plate', 'trim|required');
			$this->form_validation->set_rules('plate_region', 'plate_region', 'trim');
			$this->form_validation->set_rules('plate_coordinates', 'plate_coordinates', 'trim');
			$this->form_validation->set_rules('plate_score', 'plate_score', 'trim');
			$this->form_validation->set_rules('vehicle_type', 'vehicle_type', 'trim');
			$this->form_validation->set_rules('make', 'make', 'trim');
			$this->form_validation->set_rules('model', 'model', 'trim');
			$this->form_validation->set_rules('color', 'color', 'trim');
			$this->form_validation->set_rules('vehicle_orientation', 'vehicle_orientation', 'trim');
			$this->form_validation->set_rules('date', 'date', 'trim');
			$this->form_validation->set_rules('time', 'time', 'trim');

			if ( $this->form_validation->run() == FALSE ) {
				$data['view'] = 'admin/mmc/mmc_add';
				$this->load->view('layout', $data);
			} else {
				$data = array(
					'video_name' => $this->input->post('video_name'),
					'image_name' => $this->input->post('image_name'),
					'plate' => $this->input->post('plate'),
					'plate_region' => $this->input->post('plate_region'),
					'plate_coordinates' => $this->input->post('plate_coordinates'),
					'plate_score' => $this->input->post('plate_score'),
					'vehicle_type' => $this->input->post('vehicle_type'),
					'make' => $this->input->post('make'),
					'model' => $this->input->post('model'),
					'color' => $this->input->post('color'),
					'vehicle_orientation' => $this->input->post('vehicle_orientation'),
					'date' => $this->input->post('date'),
					'time' => $this->input->post('time'),
					'time_stamp' => $this->input->post('date') . '---' . $this->input->post('time')
				);
				$data = $this->security->xss_clean($data);
				$result = $this->mmc_model->add_mmc($data);
				if ( $result ) {
					// Add User Activity
					$this->activity_model->add(1);
					$this->session->set_flashdata('msg', 'MMC has been added successfully!');
					redirect(base_url('admin/mmc'));
				}
			}
		} else {
			$data['view'] = 'admin/mmc/mmc_add';
			$this->load->view('layout', $data);
		}
	}

	public function edit($id = 0) {

		if ( $this->input->post('submit') ) {
			$this->form_validation->set_rules('video_name', 'video_name', 'trim|required');
			$this->form_validation->set_rules('image_name', 'image_name', 'trim|required');
			$this->form_validation->set_rules('plate', 'plate', 'trim|required');
			$this->form_validation->set_rules('plate_region', 'plate_region', 'trim');
			$this->form_validation->set_rules('plate_coordinates', 'plate_coordinates', 'trim');
			$this->form_validation->set_rules('plate_score', 'plate_score', 'trim');
			$this->form_validation->set_rules('vehicle_type', 'vehicle_type', 'trim');
			$this->form_validation->set_rules('make', 'make', 'trim');
			$this->form_validation->set_rules('model', 'model', 'trim');
			$this->form_validation->set_rules('vehicle_orientation', 'vehicle_orientation', 'trim');
			$this->form_validation->set_rules('date', 'date', 'trim');
			$this->form_validation->set_rules('time', 'time', 'trim');
			$this->form_validation->set_rules('color', 'color', 'trim');

			if ( $this->form_validation->run() == FALSE ) {
				$data['view'] = 'admin/mmc/mmc_edit';
				$this->load->view('layout', $data);
			} else {
				$data = array(
					'video_name' => $this->input->post('video_name'),
					'image_name' => $this->input->post('image_name'),
					'plate' => $this->input->post('plate'),
					'plate_region' => $this->input->post('plate_region'),
					'plate_coordinates' => $this->input->post('plate_coordinates'),
					'plate_score' => $this->input->post('plate_score'),
					'vehicle_type' => $this->input->post('vehicle_type'),
					'make' => $this->input->post('make'),
					'model' => $this->input->post('model'),
					'color' => $this->input->post('color'),
					'vehicle_orientation' => $this->input->post('vehicle_orientation'),
					'date' => $this->input->post('date'),
					'time' => $this->input->post('time'),
					'time_stamp' => $this->input->post('date') . '---' . $this->input->post('time')
				);
				$data = $this->security->xss_clean($data);
				$result = $this->mmc_model->edit_mmc($data, $id);
				if ( $result ) {
					// Add User Activity
					$this->activity_model->add(1);
					$this->session->set_flashdata('msg', 'MMC has been added successfully!');
					redirect(base_url('admin/mmc'));
				}
			}
		}
		else {
			$data['mmc_details'] = $this->mmc_model->get_mmc_by_id($id);
			$data['view'] = 'admin/mmc/mmc_edit';
			$this->load->view('layout', $data);
		}
	}

	public function del($id = 0) {

		$this->db->delete('ci_mmc', array('id' => $id));

		// Add User Activity
		$this->activity_model->add(3);
		$this->session->set_flashdata('msg', 'MMC has been deleted successfully!');
		redirect(base_url('admin/mmc'));
	}

	public function import() {

		$data['view'] = 'admin/mmc/import';
		$this->load->view('layout', $data);
	}
	
	public function importcsv() {

		$handle = fopen($_FILES["file"]["tmp_name"], 'r');

		if ( $handle ) {
			$i = 0;
			while ( ($v = fgetcsv($handle, 1000, ",")) !== FALSE ) {

				// Skip header
				if ( $i == 0 ) {
					$i ++;
					continue;
				}

				if ( !empty($v[0]) && !empty($v[2]) ) {
					$mmc_details = $this->mmc_model->get_mmcs_by_pv(trim($v[2]), trim($v[0]));
	
					$data = array(
						'video_name' => trim($v[0]),
						'image_name' => trim($v[1]),
						'plate' => trim($v[2]),
						'plate_region' => trim($v[3]),
						'plate_coordinates' => trim($v[4]),
						'plate_score' => trim($v[5]),
						'vehicle_type' => trim($v[6]),
						'make' => trim($v[7]),
						'model' => trim($v[8]),
						'color' => trim($v[9]),
						'vehicle_orientation' => trim($v[10]),
						'date' => trim($v[11]),
						'time' =>  trim($v[12]),
						'time_stamp' => trim($v[13])
					);
	
					$data = $this->security->xss_clean($data);

					if ( isset($mmc_details['id']) && is_numeric($mmc_details['id']) == 1 )
						$this->mmc_model->edit_mmc($data, $mmc_details['id']);
					else
						$this->mmc_model->add_mmc($data);
				}
			}

			$this->session->set_flashdata('msg', 'MMC has been imported successfully!');
			//redirect(base_url('admin/mmc'));
		}
		else {
			$data['view'] = 'admin/mmc/import';
			$this->load->view('layout', $data);
		}

		/*
		if ( $this->input->post('submit') ) {
			$handle = fopen($_FILES["mmc_xlsx"]["tmp_name"], 'r');
			$mmc_head = fgetcsv($handle, 1000, ",");

			while ( ($v = fgetcsv($handle, 1000, ",")) !== FALSE ) {
				if ( !empty($v[0]) && !empty($v[2]) ) {
					$mmc_details = $this->mmc_model->get_mmcs_by_pv(trim($v[2]), trim($v[0]));

					$data = array(
						'video_name' => trim($v[0]),
						'image_name' => trim($v[1]),
						'plate' => trim($v[2]),
						'plate_region' => trim($v[3]),
						'plate_coordinates' => trim($v[4]),
						'plate_score' => trim($v[5]),
						'vehicle_type' => trim($v[6]),
						'make' => trim($v[7]),
						'model' => trim($v[8]),
						'color' => trim($v[9]),
						'vehicle_orientation' => trim($v[10]),
						'date' => trim($v[11]),
						'time' =>  trim($v[12]),
						'time_stamp' => trim($v[13])
					);

					$data = $this->security->xss_clean($data);
					
					if ( is_numeric($mmc_details['id']) == 1 ) {
						$this->mmc_model->edit_mmc($data, $mmc_details['id']);
					} else {
						$this->mmc_model->add_mmc($data);
					}
				}
				   
			}
			$this->session->set_flashdata('msg', 'MMC has been imported successfully!');
			redirect(base_url('admin/mmc'));
			exit;
		}
		
		$data['view'] = 'admin/mmc/import';
		$this->load->view('layout', $data);
		*/
	}

	public function exportcsv() {

		if ( !empty($_REQUEST['plate_id']) ) {
			$plate_ids = $_REQUEST['plate_id'];
			$records = $this->db->where_in('id', $plate_ids)->get('ci_plates')->result_array();
			if ( count($records) > 0) {
				$delimiter = ","; 
				$filename = "Plates Report.csv"; 
				 
				// Create a file pointer 
				$f = fopen('php://memory', 'w'); 
				 
				// Set column headers 
				$fields = array('Id', 'Plate', 'Plate type', 'Name', 'Address', 'City', 'State', 'Zip code', 'VIN', 'Body', 'Year', 'Make', 'Color', 'DMV Date checked', 'DMV Status', 'Expiration Date', 'Sex', 'Birth Date', 'County', 'MID Number', 'screenshot'); 
				fputcsv($f, $fields, $delimiter); 
				 
				foreach ( $records as $val ) {
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

	public function exportallcsv() {

		$records = $this->mmc_model->get_all_simple_mmcs();
		if ( count($records) > 0 ) {
			$delimiter = ","; 
			$filename = "MMC Report.csv"; 
			 
			// Create a file pointer 
			$f = fopen('php://memory', 'w'); 
			 
			// Set column headers 
			$fields = array('Id', 'Video Name', 'Image Name', 'Plate', 'Plate Region', 'Plate Coordinates', 'Score Plate', 'Vehicle Type', 'Make', 'Model', 'Color', 'Vehicle Orientation', 'Date', 'Time', 'Time Stamp'); 
			fputcsv($f, $fields, $delimiter); 
			 
			foreach ( $records as $val ) {
				$lineData = array($val['id'], $val['video_name'], $val['image_name'], $val['plate'], $val['plate_region'], $val['plate_coordinates'], $val['plate_score'], $val['vehicle_type'], $val['make'], $val['model'], $val['color'], $val['make'], $val['vehicle_orientation'], $val['date'], $val['time'], $val['time_stamp']); 
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

	public function plate_search($plate) {
		
		$json_resp = array();
		$json_resp['plate_details'] = $this->mmc_model->get_plates_by_plate($plate);
		echo json_encode($json_resp);
		exit;
	}
}
