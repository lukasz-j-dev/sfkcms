<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once($_SERVER['DOCUMENT_ROOT'] . '/slim-image-cropper/example/slim.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Datechnage extends MY_Controller {

	public function __construct(){

		parent::__construct();

		$this->load->model('admin/violation_model', 'violation_model');
		
		$this->load->model('admin/plates_model', 'plates_model');
		
		$this->load->model('admin/mmc_model', 'mmc_model');   // Shang
		
		$this->load->model('admin/village_model', 'village_model');
		
		$this->load->model('admin/camera_model', 'camera_model');

		$this->load->model('admin/user_model', 'user_model');
		
		$this->load->model('activity_model','activity_model');

		$this->load->library('datatable');
		
		$this->load->helper('url');
		$this->load->helper('date');

	}

		//-----------------------------------------------------------------------

	public function index(){

		$data['view'] = 'admin/violations/violation_list';
		$this->load->view('layout', $data);

	}
	
	public function Datechnage(){

		$datas=	$this->violation_model->get_violation_by_id_all();
		
		foreach($datas as $d)
		{
		    
		    	$notice_date = date('Y-m-d H:i:s', strtotime($d['notice_date']));	
		    	$up_data=array('notice_date_new'=>$notice_date );
		    		$this->violation_model->edit_violation($up_data, $d['id']);
		    		
		    	
		    		
		    		
		    
		}

	}
	
	public function all(){

		$data['view'] = 'admin/violations/violation_all';
		$this->load->view('layout', $data);

	}
	public function new(){

		$data['view'] = 'admin/violations/violation_unpaid';
		$this->load->view('layout', $data);

	}
		public function paid(){

		$data['view'] = 'admin/violations/violation_paypaid';
		$this->load->view('layout', $data);

	}
	
		public function unpaid(){

		$data['view'] = 'admin/violations/payunpaid';
		$this->load->view('layout', $data);

	}
   public function mailed(){

		$data['view'] = 'admin/violations/violation_mailed';
		$this->load->view('layout', $data);

	}
	public function disputed(){

		$data['view'] = 'admin/violations/violation_disputed';
		$this->load->view('layout', $data);

	}
	public function reviewed(){

		$data['view'] = 'admin/violations/violation_paid';
		$this->load->view('layout', $data);

	}
	public function dismissed(){

		$data['view'] = 'admin/violations/violation_dismissed';
		$this->load->view('layout', $data);

	}
	public function archived(){

		$data['view'] = 'admin/violations/violation_archived';
		$this->load->view('layout', $data);

	}
	public function pastdue(){

		$data['view'] = 'admin/violations/violation_pastdue';
		$this->load->view('layout', $data);

	}
	public function missingmedia(){

		$data['view'] = 'admin/violations/violation_missing_media';
		$this->load->view('layout', $data);

	}
	public function datatable_json(){				   					   

		$records = $this->violation_model->get_violations_list();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
			$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
			if($row['status'] == 6)$status_txt = 'Disputed';
			
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_id[]" value="' . $row['id'] . '"/>',
				$row['id'],

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	public function datatable_json_all(){				   					   

		$records = $this->violation_model->get_violations_all();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
			$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
			if($row['status'] == 6)$status_txt = 'Disputed';
				$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
					$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	
	public function paypaind_json_all(){				   					   

		$records = $this->violation_model->paypaind_json_all();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
			$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
			if($row['status'] == 6)$status_txt = 'Disputed';
				$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
					$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	public function datatable_json_missing_media(){				   					   

		$records = $this->violation_model->get_violations_missing_media();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
			$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
					$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
				$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	public function datatable_json_unpaid(){				   					   

		$records = $this->violation_model->get_violations_unpaid();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
		$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
				$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
				$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
		public function datatable_json_payunpaid(){				   					   

		$records = $this->violation_model->datatable_json_payunpaid();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
		$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
				$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
				$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	public function datatable_json_paid(){				   					   

		$records = $this->violation_model->get_violations_paid();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
			$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
				$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
				$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	public function datatable_json_dismissed(){				   					   

		$records = $this->violation_model->get_violations_dismissed();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
		$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
					$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
				$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	
	public function datatable_json_dispute(){				   					   

		$records = $this->violation_model->datatable_json_dispute();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
		$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
				$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
				$payment_status,
				
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	
	public function datatable_json_mail(){				   					   

		$records = $this->violation_model->datatable_json_mail();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
		$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
					$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
				$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	public function datatable_json_archived(){				   					   

		$records = $this->violation_model->get_violations_archived();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
		$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
				$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
					$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	
		public function get_violations_dismissed(){				   					   

		$records = $this->violation_model->get_violations_dismissed();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
		$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
				$payment_status = 'Paid';
			if($row['payment_status'] == 1)$payment_status = 'Unpaid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
					$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	public function get_violations_disputed(){				   					   

		$records = $this->violation_model->get_violations_disputed();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
		$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
				$payment_status = 'Paid';
			if($row['payment_status'] == 1)$payment_status = 'Unpaid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
					$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	public function datatable_json_pastdue(){				   					   

		$records = $this->violation_model->get_violations_pastdue();

		$data = array();

		$i = 0;

		foreach ($records['data']  as $row) 

		{  
			$date = str_replace('-', ' ', $row['violation_date']);
			$violation_date = date('Y/m/d', strtotime($date));	
		$status_txt = 'New';
			if($row['status'] == 2)$status_txt = 'Reviewed';
			if($row['status'] == 3)$status_txt = 'Mailed';
			if($row['status'] == 4)$status_txt = 'Archived';
			if($row['status'] == 5)$status_txt = 'Dismissed';
				if($row['status'] == 6)$status_txt = 'Disputed';
					$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			$data[]= array(

				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="'.base_url('admin/violations/edit/'.$row['id']).'"> '.$row['id'].'</a>',

				$row['violation_number'] . '-' . $row['pin'],
				
				$row['plate'],
				
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				
				$row['violation_date'],
				
				$row['notice_date'],
				
				$row['due_date'],
				
				$row['amount_due'],
				
				$status_txt,
				$payment_status,
				
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/'.$row['violation_number'] . '-' . $row['pin'].'"> <i class="material-icons">language</i></a>

				<a title="Edit" class="update btn btn-sm btn-primary" href="'.base_url('admin/violations/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>

				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="'.base_url('admin/violations/del/'.$row['id']).'" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&nocache=' . str_pad(rand(0, pow(10, 10)-1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>

				',
				$row['violation_date_stamp'],
				$row['due_date_stamp'],
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']

			);
		$i++;
		}

		$records['data']=$data;

		echo json_encode($records);						   

	}
	public function add(){

		if($this->input->post('submit')){
			$this->form_validation->set_rules('notice_date', 'notice_date', 'trim|required');
			$this->form_validation->set_rules('village_court', 'village_court', 'trim');
			$this->form_validation->set_rules('camera', 'notice_date', 'trim|required');
			$this->form_validation->set_rules('plate', 'plate', 'trim|required');
			$this->form_validation->set_rules('state', 'state', 'trim|required');
			$this->form_validation->set_rules('type', 'type', 'trim');
			$this->form_validation->set_rules('violation_date', 'violation_date', 'trim|required');
			$this->form_validation->set_rules('violation_time', 'violation_time', 'trim|required');
			$this->form_validation->set_rules('due_date', 'due_date', 'trim|required');
			$this->form_validation->set_rules('plate_photo', 'plate_photo', 'trim');
			$this->form_validation->set_rules('violation_video', 'violation_video', 'trim');
			if ($this->form_validation->run() == FALSE) {

				$data['view'] = 'admin/violations/violation_add';

				$this->load->view('layout', $data);

			}else{
				$data = array(

					'notice_date' => $this->input->post('notice_date'),

					'village_court' => $this->input->post('village_court'),

					'camera' => $this->input->post('camera'),

					'plate' => $this->input->post('plate'),

					'state' => $this->input->post('state'),

					'type' => $this->input->post('type'),
					
					'full_name' => $this->input->post('full_name'),
					'address1' => $this->input->post('address1'),
					'address2' => $this->input->post('address2'),
					'city' => $this->input->post('city'),
					'zip' => $this->input->post('zip'),
					'amount_due' => $this->input->post('amount_due'),
					
					'violation_date' =>  $this->input->post('violation_date'),

					'violation_time' => $this->input->post('violation_time'),
					'status' =>1,
					'due_date' => $this->input->post('due_date'),
					'plate_photo' => $this->input->post('plate_photo'),
					'violation_video' => $this->input->post('violation_video'),

				);
				$pin = mt_rand(101, 998);
				$added_by = $this->session->userdata('admin_id');
				$n_date = strtotime(str_replace('-', ' ', $this->input->post('notice_date')));
				$d_date = strtotime(str_replace('-', ' ', $this->input->post('due_date')));
				$v_date = strtotime(str_replace('-', ' ', $this->input->post('violation_date')));
				$n_month=date("m",$v_date);
				$n_day=date("d",$v_date);
				$n_year=date("y",$v_date);
				$data['notice_date_stamp'] = $n_date;
				$data['due_date_stamp'] = $d_date;
				$data['violation_date_stamp'] = $v_date;
				$data['pin'] = $pin;
				$data['added_by'] = $added_by;
				$data['date_modified'] = now();
				$data = $this->security->xss_clean($data);

				$result = $this->violation_model->add_violation($data);
				if($result){
					$violation_number = $n_year . $n_month . $n_day . $result;
					$data['violation_number'] = $violation_number;
					$result = $this->violation_model->edit_violation($data, $result);
					// Add User Activity

					$this->activity_model->add(1);



					$this->session->set_flashdata('msg', 'Violation has been added successfully!');

					redirect(base_url('admin/violations'));

				}
			}

		}else{
			$data['violation']['simple_villages'] = $this->village_model->get_all_active_villages();
			$data['violation']['simple_cameras'] = $this->camera_model->get_all_simple_cameras();
			$data['view'] = 'admin/violations/violation_add';

			$this->load->view('layout', $data);

		}

	}
	public function edit($id = 0){
		if($this->input->post('violation_date')){
			$this->load->helper('url', 'form');
			$this->form_validation->set_rules('notice_date', 'notice_date', 'trim|required');
			$this->form_validation->set_rules('village_court', 'village_court', 'trim');
			$this->form_validation->set_rules('camera', 'notice_date', 'trim|required');
			$this->form_validation->set_rules('plate', 'plate', 'trim|required');
		/*	$this->form_validation->set_rules('state', 'state', 'trim|required');*/
		/*	$this->form_validation->set_rules('type', 'type', 'trim');*/
			$this->form_validation->set_rules('violation_date', 'violation_date', 'trim|required');
			$this->form_validation->set_rules('violation_time', 'violation_time', 'trim|required');
			$this->form_validation->set_rules('due_date', 'due_date', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['view'] = 'admin/violations/violation_edit';
				$violation = $this->violation_model->get_violation_by_id($id);
				$data['violation'] = array_merge($violation, $_POST);
				$data['violation']['simple_villages'] = $this->village_model->get_all_active_villages();
				$data['violation']['simple_cameras'] = $this->camera_model->get_all_simple_cameras();
				$user_details = $this->user_model->get_user_by_id($data['violation']['added_by']);
				$data['violation']['added_by_details'] = $user_details['firstname'] . ' ' . $user_details['lastname'];

				$this->load->view('layout', $data);

			}else{
				$data = array(

					'notice_date' => $this->input->post('notice_date'),
					'dismissreason' => $this->input->post('dismissreason'),

					'village_court' => $this->input->post('village_court'),

					'camera' => $this->input->post('camera'),

					'plate' => $this->input->post('plate'),

				/*	'state' => $this->input->post('state'),

					'type' => $this->input->post('type'),
					'full_name' => $this->input->post('full_name'),
					'address1' => $this->input->post('address1'),
					'address2' => $this->input->post('address2'),
					'city' => $this->input->post('city'),
					'zip' => $this->input->post('zip'),*/

					'violation_date' =>  $this->input->post('violation_date'),

					'violation_time' => $this->input->post('violation_time'),

					'due_date' => $this->input->post('due_date'),
					'plate_photo' => $this->input->post('plate_photo'),
					'violation_video' => $this->input->post('violation_video'),
					'date_added' => $this->input->post('date_added'),
					'date_paid' => $this->input->post('date_paid'),
					'amount_due' => $this->input->post('amount_due'),
					'status' => $this->input->post('status'),
					'payment_method' => $this->input->post('payment_method'),
					'payment_status' => $this->input->post('payment_status'),

				);
				$n_date = strtotime(str_replace('-', ' ', $this->input->post('notice_date')));
				$d_date = strtotime(str_replace('-', ' ', $this->input->post('due_date')));
				$v_date = strtotime(str_replace('-', ' ', $this->input->post('violation_date')));
				$n_month=date("m",$v_date);
				$n_day=date("d",$v_date);
				$n_year=date("y",$v_date);
				$data['notice_date_stamp'] = $n_date;
				$data['due_date_stamp'] = $d_date;
				$data['violation_date_stamp'] = $v_date;
				$violation_number = $n_year . $n_month . $n_day . $id;
				$data['violation_number'] = $violation_number;
				/* $config['upload_path'] = './public/images/violations';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('check_mo_copy')) {
					$this->upload->display_errors();
				} else {
					$upload_data = $this->upload->data();
					$data['check_mo_copy'] = $upload_data['file_name'];
				} */
				$images = Slim::getImages('check_mo_copy');
				if ($images != false) {
					foreach ($images as $image) {
						if (isset($image['output']['data'])) {
							$img_name = $image['output']['name'];
							$img_data = $image['output']['data'];
							$input = Slim::saveFile($img_data, $img_name, './public/images/violations');
							$data['check_mo_copy'] = $input['name'];
						}
					}
				}
				$data['date_modified'] = now();
				$data = $this->security->xss_clean($data);
				
				$result = $this->violation_model->edit_violation($data, $id);
				if($result){

					$this->activity_model->add(2);

				
				if($this->input->get('save'))
					{
					    	$this->session->set_flashdata('msg', 'Violation has been save successfully!');
					redirect(base_url('admin/violations'));
				}else
				{
				    	$this->session->set_flashdata('msg', 'Violation has been updated successfully!');
				    redirect(base_url('admin/violations/edit/'.$id));
				}
				}
			}
		}
		else{
			$violation = $this->violation_model->get_violation_by_id($id);
			$plate_details = $this->plates_model->get_plates_by_plate($violation['plate']);
			$up_data = array();
			if((empty($violation['state']) && !empty($plate_details['state'])) || ($plate_details['state'] != $violation['state'])) $up_data['state'] = $plate_details['state'];
			if((empty($violation['type']) && !empty($plate_details['plate_type'])) || ($plate_details['plate_type'] != $violation['type'])) $up_data['type'] = $plate_details['plate_type'];
			if((empty($violation['full_name']) && !empty($plate_details['name'])) || ($plate_details['name'] != $violation['full_name'])) $up_data['full_name'] = $plate_details['name'];
			if((empty($violation['address1']) && !empty($plate_details['address'])) || ($plate_details['address'] != $violation['address1'])) $up_data['address1'] = $plate_details['address'];
			if((empty($violation['city']) && !empty($plate_details['city'])) || ($plate_details['city'] != $violation['city'])) $up_data['city'] = $plate_details['city'];
			if((empty($violation['zip']) && !empty($plate_details['zip_code'])) || ($plate_details['zip_code'] != $violation['zip'])) $up_data['zip'] = $plate_details['zip_code'];
			if(count($up_data) > 0){
				$up_data = $this->security->xss_clean($up_data);
				$this->violation_model->edit_violation($up_data, $id);
				$violation = $this->violation_model->get_violation_by_id($id);
			}
			$data['violation'] = $violation;
			$data['next_violation'] = $this->violation_model->get_adjacent_violations_details($id, true);
			$data['prev_violation'] = $this->violation_model->get_adjacent_violations_details($id, false);
			$data['plate_details'] = $plate_details;
			$data['mmc_details'] = $this->mmc_model->get_mmcs_by_mmc($data['violation']['plate']);		// Shang
			$data['violation']['simple_villages'] = $this->village_model->get_all_active_villages();
			$data['violation']['simple_cameras'] = $this->camera_model->get_all_simple_cameras();
			$user_details = $this->user_model->get_user_by_id($data['violation']['added_by']);
			$data['violation']['added_by_details'] = $user_details['firstname'] . ' ' . $user_details['lastname'];
			$data['view'] = 'admin/violations/violation_edit';
			$this->load->view('layout', $data);
		}
	}
	public function edit1($id = 0){
		if($this->input->post('violation_date')){
			$this->load->helper('url', 'form');
			$this->form_validation->set_rules('notice_date', 'notice_date', 'trim|required');
			$this->form_validation->set_rules('village_court', 'village_court', 'trim');
			$this->form_validation->set_rules('camera', 'notice_date', 'trim|required');
			$this->form_validation->set_rules('plate', 'plate', 'trim|required');
		/*	$this->form_validation->set_rules('state', 'state', 'trim|required');*/
		/*	$this->form_validation->set_rules('type', 'type', 'trim');*/
			$this->form_validation->set_rules('violation_date', 'violation_date', 'trim|required');
			$this->form_validation->set_rules('violation_time', 'violation_time', 'trim|required');
			$this->form_validation->set_rules('due_date', 'due_date', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['view'] = 'admin/violations/violation_edit';
				$violation = $this->violation_model->get_violation_by_id($id);
				$data['violation'] = array_merge($violation, $_POST);
				$data['violation']['simple_villages'] = $this->village_model->get_all_active_villages();
				$data['violation']['simple_cameras'] = $this->camera_model->get_all_simple_cameras();
				$user_details = $this->user_model->get_user_by_id($data['violation']['added_by']);
				$data['violation']['added_by_details'] = $user_details['firstname'] . ' ' . $user_details['lastname'];

				$this->load->view('layout', $data);

			}else{
				$data = array(

					'notice_date' => $this->input->post('notice_date'),
					'dismissreason' => $this->input->post('dismissreason'),

					'village_court' => $this->input->post('village_court'),

					'camera' => $this->input->post('camera'),

					'plate' => $this->input->post('plate'),

				/*	'state' => $this->input->post('state'),

					'type' => $this->input->post('type'),
					'full_name' => $this->input->post('full_name'),
					'address1' => $this->input->post('address1'),
					'address2' => $this->input->post('address2'),
					'city' => $this->input->post('city'),
					'zip' => $this->input->post('zip'),*/

					'violation_date' =>  $this->input->post('violation_date'),

					'violation_time' => $this->input->post('violation_time'),

					'due_date' => $this->input->post('due_date'),
					'plate_photo' => $this->input->post('plate_photo'),
					'violation_video' => $this->input->post('violation_video'),
					'date_added' => $this->input->post('date_added'),
					'date_paid' => $this->input->post('date_paid'),
					'amount_due' => $this->input->post('amount_due'),
					'status' => $this->input->post('status'),
					'payment_method' => $this->input->post('payment_method'),
					'payment_status' => $this->input->post('payment_status'),

				);
				$n_date = strtotime(str_replace('-', ' ', $this->input->post('notice_date')));
				$d_date = strtotime(str_replace('-', ' ', $this->input->post('due_date')));
				$v_date = strtotime(str_replace('-', ' ', $this->input->post('violation_date')));
				$n_month=date("m",$v_date);
				$n_day=date("d",$v_date);
				$n_year=date("y",$v_date);
				$data['notice_date_stamp'] = $n_date;
				$data['due_date_stamp'] = $d_date;
				$data['violation_date_stamp'] = $v_date;
				$violation_number = $n_year . $n_month . $n_day . $id;
				$data['violation_number'] = $violation_number;
				/* $config['upload_path'] = './public/images/violations';
				$config['allowed_types'] = 'gif|jpg|png|jpeg';
				$this->load->library('upload', $config);
				if (!$this->upload->do_upload('check_mo_copy')) {
					$this->upload->display_errors();
				} else {
					$upload_data = $this->upload->data();
					$data['check_mo_copy'] = $upload_data['file_name'];
				} */
				$images = Slim::getImages('check_mo_copy');
				if ($images != false) {
					foreach ($images as $image) {
						if (isset($image['output']['data'])) {
							$img_name = $image['output']['name'];
							$img_data = $image['output']['data'];
							$input = Slim::saveFile($img_data, $img_name, './public/images/violations');
							$data['check_mo_copy'] = $input['name'];
						}
					}
				}
				$data['date_modified'] = now();
				$data = $this->security->xss_clean($data);
				
				$result = $this->violation_model->edit_violation($data, $id);
				if($result){

					$this->activity_model->add(2);

				
				if($this->input->get('save'))
					{
					    	$this->session->set_flashdata('msg', 'Violation has been save successfully!');
					redirect(base_url('admin/violations'));
				}else
				{
				    	$this->session->set_flashdata('msg', 'Violation has been updated successfully!');
				    redirect(base_url('admin/violations/edit/'.$id));
				}
				}
			}
		}
		else{
			$violation = $this->violation_model->get_violation_by_id($id);
			$plate_details = $this->plates_model->get_plates_by_plate($violation['plate']);
			$up_data = array();
			if((empty($violation['state']) && !empty($plate_details['state'])) || ($plate_details['state'] != $violation['state'])) $up_data['state'] = $plate_details['state'];
			if((empty($violation['type']) && !empty($plate_details['plate_type'])) || ($plate_details['plate_type'] != $violation['type'])) $up_data['type'] = $plate_details['plate_type'];
			if((empty($violation['full_name']) && !empty($plate_details['name'])) || ($plate_details['name'] != $violation['full_name'])) $up_data['full_name'] = $plate_details['name'];
			if((empty($violation['address1']) && !empty($plate_details['address'])) || ($plate_details['address'] != $violation['address1'])) $up_data['address1'] = $plate_details['address'];
			if((empty($violation['city']) && !empty($plate_details['city'])) || ($plate_details['city'] != $violation['city'])) $up_data['city'] = $plate_details['city'];
			if((empty($violation['zip']) && !empty($plate_details['zip_code'])) || ($plate_details['zip_code'] != $violation['zip'])) $up_data['zip'] = $plate_details['zip_code'];
			if(count($up_data) > 0){
				$up_data = $this->security->xss_clean($up_data);
				$this->violation_model->edit_violation($up_data, $id);
				$violation = $this->violation_model->get_violation_by_id($id);
			}
			$data['violation'] = $violation;
			$data['next_violation'] = $this->violation_model->get_adjacent_violations_details($id, true);
			$data['prev_violation'] = $this->violation_model->get_adjacent_violations_details($id, false);
			$data['plate_details'] = $plate_details;
			$data['mmc_details'] = $this->mmc_model->get_mmcs_by_mmc($data['violation']['plate']);		// Shang
			$data['violation']['simple_villages'] = $this->village_model->get_all_active_villages();
			$data['violation']['simple_cameras'] = $this->camera_model->get_all_simple_cameras();
			$user_details = $this->user_model->get_user_by_id($data['violation']['added_by']);
			$data['violation']['added_by_details'] = $user_details['firstname'] . ' ' . $user_details['lastname'];
			$data['view'] = 'admin/violations/violation_edit';
			$this->load->view('layout', $data);
		}
	}
	public function del($id = 0){
		$this->db->delete('ci_violations', array('id' => $id));

		// Add User Activity
		$this->activity_model->add(3);

		$this->session->set_flashdata('msg', 'Violation has been deleted successfully!');
		redirect(base_url('admin/violations'));
	}
	
	public function print_ticket($id = 0){
		$data['violation'] = $this->violation_model->get_violation_by_id($id);
		$this->load->view('admin/violations/print_ticket', $data);
	}
	public function import(){
		if($this->input->post('submit')){
			$this->load->library('simplexlsx');
			$this->simplexlsx->load_initialize($_FILES["violation_xlsx"]["tmp_name"]);
			if ($this->simplexlsx->success()){
				$cnt = 0;
				$results=$this->simplexlsx->rows();
				$violation_head = array();
				foreach($results as $k=>$v){
					if($cnt > 0){
						if(!empty($v[array_search("violation_number", $violation_head)]) && !empty($v[array_search("pin", $violation_head)])){
							$violation_details = $this->violation_model->get_violation_by_num_pin($v[array_search("violation_number", $violation_head)], $v[array_search("pin", $violation_head)]);
							$date = DateTime::createFromFormat('Y-m-d H:i:s', $v[array_search("violation_time", $violation_head)]);
							if(!empty($violation_details['id'])){
								$up_data = array(

									'notice_date' => $v[array_search("notice_date", $violation_head)],

									'plate' => $v[array_search("plate", $violation_head)],

									'state' => $v[array_search("state", $violation_head)],

									'type' => $v[array_search("type", $violation_head)],
									
									'full_name' => $v[array_search("full_name", $violation_head)],
									'address1' => $v[array_search("address1", $violation_head)],
									'address2' => $v[array_search("address2", $violation_head)],
									'city' => $v[array_search("city", $violation_head)],
									'zip' => $v[array_search("zip", $violation_head)],
									'amount_due' => $v[array_search("amount_due", $violation_head)],
									
									'violation_date' =>  $v[array_search("violation_date", $violation_head)],

									'violation_time' => $date->format('h:i A'),
									'due_date' => $v[array_search("due_date", $violation_head)],
									'plate_photo' => $v[array_search("plate_photo", $violation_head)],
									'violation_video' => $v[array_search("violation_video", $violation_head)],

								);
								$n_date = strtotime(str_replace('-', ' ', $v[array_search("notice_date", $violation_head)]));
								$d_date = strtotime(str_replace('-', ' ', $v[array_search("due_date", $violation_head)]));
								$v_date = strtotime(str_replace('-', ' ', $v[array_search("violation_date", $violation_head)]));
								$n_month=date("m",$v_date);
								$n_day=date("d",$v_date);
								$n_year=date("y",$v_date);
								$village_details = $this->village_model->get_village_by_name($v[array_search("village_court", $violation_head)]);
								if(!empty($village_details['id'])) $up_data['village_court'] = $village_details['id'];
								$camera_details = $this->camera_model->get_camera_by_name($v[array_search("camera_location", $violation_head)]);
								if(!empty($camera_details['id'])) $up_data['camera'] = $camera_details['id'];
								if($v[array_search("status", $violation_head)] == 'Paid') $up_data['status'] = 2;
								elseif($v[array_search("status", $violation_head)] == 'In dispute') $up_data['status'] = 3;
								elseif($v[array_search("status", $violation_head)] == 'Archived') $up_data['status'] = 4;
								else $up_data['status'] = 1;
								$up_data['notice_date_stamp'] = $n_date;
								$up_data['due_date_stamp'] = $d_date;
								$up_data['violation_date_stamp'] = $v_date;
								$up_data['added_by'] = 43;
								$up_data['date_modified'] = now();
								$up_data = $this->security->xss_clean($up_data);
								//print_r($up_data);
								$this->violation_model->edit_violation($up_data, $violation_details['id']);
							}
						}else{
							$ins_data = array(

								'notice_date' => $v[array_search("notice_date", $violation_head)],

								'plate' => $v[array_search("plate", $violation_head)],

								'state' => $v[array_search("state", $violation_head)],

								'type' => $v[array_search("type", $violation_head)],
								
								'full_name' => $v[array_search("full_name", $violation_head)],
								'address1' => $v[array_search("address1", $violation_head)],
								'address2' => $v[array_search("address2", $violation_head)],
								'city' => $v[array_search("city", $violation_head)],
								'zip' => $v[array_search("zip", $violation_head)],
								'amount_due' => $v[array_search("amount_due", $violation_head)],
								
								'violation_date' =>  $v[array_search("violation_date", $violation_head)],

								'violation_time' => $date->format('h:i A'),
								'status' =>1,
								'due_date' => $v[array_search("due_date", $violation_head)],
								'plate_photo' => $v[array_search("plate_photo", $violation_head)],
								'violation_video' => $v[array_search("violation_video", $violation_head)],

							);
							$n_date = strtotime(str_replace('-', ' ', $v[array_search("notice_date", $violation_head)]));
							$d_date = strtotime(str_replace('-', ' ', $v[array_search("due_date", $violation_head)]));
							$v_date = strtotime(str_replace('-', ' ', $v[array_search("violation_date", $violation_head)]));
							$n_month=date("m",$v_date);
							$n_day=date("d",$v_date);
							$n_year=date("y",$v_date);
							$pin = mt_rand(101, 998);
							$village_details = $this->village_model->get_village_by_name($v[array_search("village_court", $violation_head)]);
							if(!empty($village_details['id'])) $ins_data['village_court'] = $village_details['id'];
							$camera_details = $this->camera_model->get_camera_by_name($v[array_search("camera_location", $violation_head)]);
							if(!empty($camera_details['id'])) $ins_data['camera'] = $camera_details['id'];
							/* if($v[array_search("status", $violation_head)] == 'Paid') $ins_data['status'] = 2;
							elseif($v[array_search("status", $violation_head)] == 'In dispute') $ins_data['status'] = 3;
							elseif($v[array_search("status", $violation_head)] == 'Archived') $ins_data['status'] = 4;
							else $ins_data['status'] = 1; */
							$ins_data['notice_date_stamp'] = $n_date;
							$ins_data['due_date_stamp'] = $d_date;
							$ins_data['violation_date_stamp'] = $v_date;
							$ins_data['added_by'] = 43;
							$ins_data['pin'] = $pin;
							$ins_data['date_modified'] = now();
							$ins_data = $this->security->xss_clean($ins_data);
							//print_r($ins_data);
							$result = $this->violation_model->add_violation($ins_data);
							if($result){
								$violation_number = $n_year . $n_month . $n_day . $result;
								$ins_data['violation_number'] = $violation_number;
								$this->violation_model->edit_violation($ins_data, $result);
							}
						}
					}else{
						$violation_head = $v;
					}
					$cnt++;
				}
				$this->session->set_flashdata('msg', 'Violation has been imported successfully!');
				redirect(base_url('admin/violations'));
				exit;
			}		
			else{
				/* echo 'xlsx error: '.$this->simplexlsx->error(); */
				$this->session->set_flashdata('msg', 'Violation has been imported failed!');
				redirect(base_url('admin/violations'));
				exit;
			}
		}
		$data['view'] = 'admin/violations/import';
		$this->load->view('layout', $data);
	}
	public function importcsv(){
		if($this->input->post('submit')){
			$handle = fopen($_FILES["violation_xlsx"]["tmp_name"], 'r');
			$violation_head = fgetcsv($handle, 1000, ",");
			while (($v = fgetcsv($handle, 1000, ",")) !== FALSE){
			    
						$dataaa=$this->violation_model->get_violation_by_id_palte($v[array_search("plate", $violation_head)],$v[array_search("violation_video", $violation_head)],$v[array_search("plate_photo", $violation_head)]);
					
				if(!empty($dataaa)){
					$violation_details = $this->violation_model->get_violation_by_num_pin($v[array_search("violation_number", $violation_head)], $v[array_search("pin", $violation_head)]);
					if($dataaa['id']){
					    $old_datet = str_replace('/', '-', $v[array_search("notice_date", $violation_head)]);         
$old_date_timestampy = strtotime($old_datet);
 $notice_date = date('F d Y', $old_date_timestampy); 
 
   $old_datetv = str_replace('/', '-', $v[array_search("violation_date", $violation_head)]);            
$old_date_timestampv = strtotime($old_datetv);
 $violation_date = date('F d Y', $old_date_timestampv); 
 
  $old_datetdue = str_replace('/', '-', $v[array_search("due_date", $violation_head)]);            
$old_date_timestampdue = strtotime($old_datetdue);
 $due_date = date('F d Y', $old_date_timestampdue); 
						$up_data = array(

							'notice_date' =>$notice_date ,

							'plate' => $v[array_search("plate", $violation_head)],

							'state' => $v[array_search("state", $violation_head)],

							'type' => $v[array_search("type", $violation_head)],
							
							'full_name' => $v[array_search("full_name", $violation_head)],
							'address1' => $v[array_search("address1", $violation_head)],
							'address2' => $v[array_search("address2", $violation_head)],
							'city' => $v[array_search("city", $violation_head)],
							'zip' => $v[array_search("zip", $violation_head)],
							'amount_due' => $v[array_search("amount_due", $violation_head)],
							
							'violation_date' => $violation_date,

							'violation_time' => $v[array_search("violation_time", $violation_head)],
							'due_date' => $due_date ,
							'plate_photo' => $v[array_search("plate_photo", $violation_head)],
							'violation_video' => $v[array_search("violation_video", $violation_head)],

						);
						$n_date = strtotime(str_replace('/', '-', $v[array_search("notice_date", $violation_head)]));
						$d_date = strtotime(str_replace('/', '-', $v[array_search("due_date", $violation_head)]));
						$v_date = strtotime(str_replace('/', '-', $v[array_search("violation_date", $violation_head)]));
						$n_month=date("m",$v_date);
						$n_day=date("d",$v_date);
						$n_year=date("y",$v_date);
						$village_details = $this->village_model->get_village_by_name($v[array_search("village_court", $violation_head)]);
						if(!empty($village_details['id'])) $up_data['village_court'] = $village_details['id'];
						$camera_details = $this->camera_model->get_camera_by_name($v[array_search("camera_location", $violation_head)]);
						if(!empty($camera_details['id'])) $up_data['camera'] = $camera_details['id'];
						if($v[array_search("status", $violation_head)] == 'Reviewed') $up_data['status'] = 2;
						elseif($v[array_search("status", $violation_head)] == 'Mailed') $up_data['status'] = 3;
						elseif($v[array_search("status", $violation_head)] == 'Archived') $up_data['status'] = 4;
							elseif($v[array_search("status", $violation_head)] == 'Dismissed') $up_data['status'] = 5;
								elseif($v[array_search("status", $violation_head)] == 'Disputed') $up_data['status'] = 6;
						else $up_data['status'] = 1;
						
							if($v[array_search("payment_status", $violation_head)] == 'unpaid') $up_data['payment_status'] = 0;
							elseif($v[array_search("payment_status", $violation_head)] == 'paid') $up_data['payment_status'] = 1;
							
								if($v[array_search("payment_status", $violation_head)] == 'Unpaid') $up_data['payment_status'] = 0;
							elseif($v[array_search("payment_status", $violation_head)] == 'Paid') $up_data['payment_status'] = 1;
							
 $n_date = date('F d Y', $n_date); 
 

 
 
 $d_date = date('F d Y', $d_date);
 
 $v_date = date('F d Y', $v_date);

						$up_data['notice_date_stamp'] = $n_date;
						$up_data['due_date_stamp'] = $d_date;
						$up_data['violation_date_stamp'] = $v_date;
						$up_data['added_by'] = 43;
						$up_data['date_modified'] = now();
						$up_data = $this->security->xss_clean($up_data);
						
					
						$this->violation_model->edit_violation($up_data, $violation_details['id']);
					}
				}else{
					$ins_data = array(

						'notice_date' => $v[array_search("notice_date", $violation_head)],

						'plate' => $v[array_search("plate", $violation_head)],

						'state' => $v[array_search("state", $violation_head)],

						'type' => $v[array_search("type", $violation_head)],
						
						'full_name' => $v[array_search("full_name", $violation_head)],
						'address1' => $v[array_search("address1", $violation_head)],
						'address2' => $v[array_search("address2", $violation_head)],
						'city' => $v[array_search("city", $violation_head)],
						'zip' => $v[array_search("zip", $violation_head)],
						'amount_due' => $v[array_search("amount_due", $violation_head)],
						
						'violation_date' =>  $v[array_search("violation_date", $violation_head)],

						'violation_time' => $v[array_search("violation_time", $violation_head)],
						'status' =>1,
						'payment_status' =>0,
						'due_date' => $v[array_search("due_date", $violation_head)],
						'plate_photo' => $v[array_search("plate_photo", $violation_head)],
						'violation_video' => $v[array_search("violation_video", $violation_head)],

					);
					$n_date = strtotime(str_replace('-', ' ', $v[array_search("notice_date", $violation_head)]));
					$d_date = strtotime(str_replace('-', ' ', $v[array_search("due_date", $violation_head)]));
					$v_date = strtotime(str_replace('-', ' ', $v[array_search("violation_date", $violation_head)]));
					$n_month=date("m",$v_date);
					$n_day=date("d",$v_date);
					$n_year=date("y",$v_date);
					$pin = mt_rand(101, 998);
					$village_details = $this->village_model->get_village_by_name($v[array_search("village_court", $violation_head)]);
					if(!empty($village_details['id'])) $ins_data['village_court'] = $village_details['id'];
					$camera_details = $this->camera_model->get_camera_by_name($v[array_search("camera_location", $violation_head)]);
					if(!empty($camera_details['id'])) $ins_data['camera'] = $camera_details['id'];
					/* if($v[array_search("status", $violation_head)] == 'Paid') $ins_data['status'] = 2;
					elseif($v[array_search("status", $violation_head)] == 'In dispute') $ins_data['status'] = 3;
					elseif($v[array_search("status", $violation_head)] == 'Archived') $ins_data['status'] = 4;
					else $ins_data['status'] = 1; */
					$ins_data['notice_date_stamp'] = $n_date;
					$ins_data['due_date_stamp'] = $d_date;
					$ins_data['violation_date_stamp'] = $v_date;
					$ins_data['added_by'] = 43;
					$ins_data['pin'] = $pin;
					$ins_data['date_modified'] = now();
					$ins_data = $this->security->xss_clean($ins_data);
					//print_r($ins_data);
					$result = $this->violation_model->add_violation($ins_data);
					if($result){
						$violation_number = $n_year . $n_month . $n_day . $result;
						$ins_data['violation_number'] = $violation_number;
						$this->violation_model->edit_violation($ins_data, $result);
					}
				}
			}
			$this->session->set_flashdata('msg', 'Violation has been imported successfully!');
			redirect(base_url('admin/violations'));
			exit;
		}
		$data['view'] = 'admin/violations/import';
		$this->load->view('layout', $data);
	}
	public function exportall(){
		$this->load->helper('download');
		$fileName = "Violation Report";  
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
		$style = array(
			'alignment' => array(
				'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			)
		);
		$sheet->setCellValue('A1', 'notice_date');
		$sheet->setCellValue('B1', 'village_court');
		$sheet->setCellValue('C1', 'camera_location');
		$sheet->setCellValue('D1', 'plate');
		$sheet->setCellValue('E1', 'state');      
		$sheet->setCellValue('F1', 'type');    
		$sheet->setCellValue('G1', 'violation_date');  
		$sheet->setCellValue('H1', 'full_name');  
		$sheet->setCellValue('I1', 'address1');  
		$sheet->setCellValue('J1', 'address2');  
		$sheet->setCellValue('K1', 'city');  
		$sheet->setCellValue('L1', 'zip');  
		$sheet->setCellValue('M1', 'violation_time');  
		$sheet->setCellValue('N1', 'due_date');
		$sheet->setCellValue('O1', 'plate_photo');  
		$sheet->setCellValue('P1', 'violation_video');  
		$sheet->setCellValue('Q1', 'violation_number');  
		$sheet->setCellValue('R1', 'pin');  
		$sheet->setCellValue('S1', 'camera_zip');  
		$sheet->setCellValue('T1', 'amount_due');  
		$sheet->setCellValue('U1', 'date_paid');  
		$sheet->setCellValue('V1', 'amount_paid');  
		$sheet->setCellValue('W1', 'payment_method');  
		$sheet->setCellValue('X1', 'status');
		$rows = 2;
		//var_dump($excel_format_data);
		//exit;
		$records = $this->violation_model->get_all_simple_violations();
		foreach ($records as $val){
			if($val['status'] == 2) $status_txt = 'Reviewed';
			elseif($val['status'] == 3) $status_txt = 'Mailed';
			elseif($val['status'] == 4) $status_txt = 'Archived';
			elseif($row['status'] == 5)$status_txt = 'Dismissed';
				elseif($row['status'] == 6)$status_txt = 'Disputed';
			else $status_txt = 'New';
			
				$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
			
			$sheet->setCellValue('A' . $rows, $val['notice_date']);
			$sheet->setCellValue('B' . $rows, $val['village_court']);
			$sheet->setCellValue('C' . $rows, $val['camera_location']);
			$sheet->setCellValue('D' . $rows, $val['plate']);
			$sheet->setCellValue('E' . $rows, $val['state']);      
			$sheet->setCellValue('F' . $rows, $val['type']);    
			$sheet->setCellValue('G' . $rows, $val['violation_date']);  
			$sheet->setCellValue('H' . $rows, $val['full_name']);  
			$sheet->setCellValue('I' . $rows, $val['address1']);  
			$sheet->setCellValue('J' . $rows, $val['address2']);  
			$sheet->setCellValue('K' . $rows, $val['city']);  
			$sheet->setCellValue('L' . $rows, $val['zip']);  
			$sheet->setCellValue('M' . $rows, $val['violation_time']);  
			$sheet->setCellValue('N' . $rows, $val['due_date']);
			$sheet->setCellValue('O' . $rows, $val['plate_photo']);  
			$sheet->setCellValue('P' . $rows, $val['violation_video']);  
			$sheet->setCellValue('Q' . $rows, $val['violation_number']);  
			$sheet->setCellValue('R' . $rows, $val['pin']);  
			$sheet->setCellValue('S' . $rows, $val['camera_zip']);  
			$sheet->setCellValue('T' . $rows, $val['amount_due']);  
			$sheet->setCellValue('U' . $rows, $val['date_paid']);  
			$sheet->setCellValue('V' . $rows, $val['amount_paid']);  
			$sheet->setCellValue('W' . $rows, $val['payment_method']);  
			$sheet->setCellValue('X' . $rows, $status_txt);
				$sheet->setCellValue('X' . $rows, $payment_status);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save('uploads/excel/'.$fileName.'.xlsx');
		force_download('uploads/excel/'.$fileName.'.xlsx', NULL);
	}
	public function export(){
		if(!empty($_REQUEST['violation_id'])){
			$violation_ids = $_REQUEST['violation_id'];
			$this->load->helper('download');
			$fileName = "Violation Report";  
			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();
			$sheet->getStyle('A1')->getFont()->setBold(true)->setName('Arial')->SetSize(10);
			$style = array(
				'alignment' => array(
					'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
				)
			);
			$sheet->setCellValue('A1', 'notice_date');
			$sheet->setCellValue('B1', 'village_court');
			$sheet->setCellValue('C1', 'camera_location');
			$sheet->setCellValue('D1', 'plate');
			$sheet->setCellValue('E1', 'state');      
			$sheet->setCellValue('F1', 'type');    
			$sheet->setCellValue('G1', 'violation_date');  
			$sheet->setCellValue('H1', 'full_name');  
			$sheet->setCellValue('I1', 'address1');  
			$sheet->setCellValue('J1', 'address2');  
			$sheet->setCellValue('K1', 'city');  
			$sheet->setCellValue('L1', 'zip');  
			$sheet->setCellValue('M1', 'violation_time');  
			$sheet->setCellValue('N1', 'due_date');
			$sheet->setCellValue('O1', 'plate_photo');  
			$sheet->setCellValue('P1', 'violation_video');  
			$sheet->setCellValue('Q1', 'violation_number');  
			$sheet->setCellValue('R1', 'pin');  
			$sheet->setCellValue('S1', 'camera_zip');  
			$sheet->setCellValue('T1', 'amount_due');  
			$sheet->setCellValue('U1', 'date_paid');  
			$sheet->setCellValue('V1', 'amount_paid');  
			$sheet->setCellValue('W1', 'payment_method');  
			$sheet->setCellValue('X1', 'status');
			$rows = 2;
			//var_dump($excel_format_data);
			//exit;
			$records = $query = $this->db->where_in('id', $violation_ids)->get('ci_violations')->result_array();
			foreach ($records as $val){
				if($val['status'] == 2) $status_txt = 'Reviewed';
			elseif($val['status'] == 3) $status_txt = 'Mailed';
			elseif($val['status'] == 4) $status_txt = 'Archived';
			elseif($row['status'] == 5)$status_txt = 'Dismissed';
				elseif($row['status'] == 6)$status_txt = 'Disputed';
			else $status_txt = 'New';
			
				$payment_status = 'Unpaid';
			if($row['payment_status'] == 1)$payment_status = 'Paid';
				$sheet->setCellValue('A' . $rows, $val['notice_date']);
				$sheet->setCellValue('B' . $rows, $val['village_court']);
				$sheet->setCellValue('C' . $rows, $val['camera_location']);
				$sheet->setCellValue('D' . $rows, $val['plate']);
				$sheet->setCellValue('E' . $rows, $val['state']);      
				$sheet->setCellValue('F' . $rows, $val['type']);    
				$sheet->setCellValue('G' . $rows, $val['violation_date']);  
				$sheet->setCellValue('H' . $rows, $val['full_name']);  
				$sheet->setCellValue('I' . $rows, $val['address1']);  
				$sheet->setCellValue('J' . $rows, $val['address2']);  
				$sheet->setCellValue('K' . $rows, $val['city']);  
				$sheet->setCellValue('L' . $rows, $val['zip']);  
				$sheet->setCellValue('M' . $rows, $val['violation_time']);  
				$sheet->setCellValue('N' . $rows, $val['due_date']);
				$sheet->setCellValue('O' . $rows, $val['plate_photo']);  
				$sheet->setCellValue('P' . $rows, $val['violation_video']);  
				$sheet->setCellValue('Q' . $rows, $val['violation_number']);  
				$sheet->setCellValue('R' . $rows, $val['pin']);  
				$sheet->setCellValue('S' . $rows, $val['camera_zip']);  
				$sheet->setCellValue('T' . $rows, $val['amount_due']);  
				$sheet->setCellValue('U' . $rows, $val['date_paid']);  
				$sheet->setCellValue('V' . $rows, $val['amount_paid']);  
				$sheet->setCellValue('W' . $rows, $val['payment_method']);  
				$sheet->setCellValue('X' . $rows, $status_txt);
					$sheet->setCellValue('z' . $rows, $payment_status);
				$rows++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/'.$fileName.'.xlsx');
			force_download('uploads/excel/'.$fileName.'.xlsx', NULL);
		}
	}
	public function exportcsv(){
		if(!empty($_REQUEST['violation_id'])){
			$violation_ids = implode(',', $_REQUEST['violation_id']);
			$records = $this->db->query("select a.*, b.camera_location, c.village_court as Village_Court from ci_violations a left join ci_cameras b on b.id = a.camera left join ci_villages c on a.village_court = c.id where a.id in ($violation_ids)")->result_array();
			if(count($records) > 0){ 
				$delimiter = ","; 
				$filename = "Violation Report.csv"; 
				 
				// Create a file pointer 
				$f = fopen('php://memory', 'w'); 
				 
				// Set column headers 
				$fields = array('notice_date', 'village_court', 'camera_location', 'plate', 'state', 'type', 'violation_date', 'full_name', 'address1', 'address2', 'city', 'zip', 'violation_time', 'due_date', 'plate_photo', 'violation_video', 'violation_number', 'pin', 'amount_due', 'date_paid', 'amount_paid', 'payment_method', 'status'); 
				fputcsv($f, $fields, $delimiter); 
				 
				// Output each row of the data, format line as csv and write to file pointer 
				foreach ($records as $val){
					if($val['status'] == 2) $status_txt = 'Reviewed';
			elseif($val['status'] == 3) $status_txt = 'Mailed';
			elseif($val['status'] == 4) $status_txt = 'Archived';
			elseif($row['status'] == 5)$status_txt = 'Dismissed';
				elseif($row['status'] == 6)$status_txt = 'Disputed';
			else $status_txt = 'New';
					$camera_location = !empty($val['camera_location']) ? $val['camera_location'] : '';
					$lineData = array($val['notice_date'], $val['Village_Court'], $camera_location, $val['plate'], $val['state'], $val['type'], $val['violation_date'], $val['full_name'], $val['address1'], $val['address2'], $val['city'], $val['zip'], $val['violation_time'], $val['due_date'], $val['plate_photo'], $val['violation_video'], $val['violation_number'], $val['pin'], $val['amount_due'], $val['date_paid'], $val['amount_paid'], $val['payment_method'], $status_txt); 
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
		$records = $this->db->query("select a.*, b.camera_location, c.village_court as Village_Court from ci_violations a left join ci_cameras b on b.id = a.camera left join ci_villages c on a.village_court = c.id")->result_array();
		if(count($records) > 0){ 
			$delimiter = ","; 
			$filename = "Violation Report.csv"; 
			 
			// Create a file pointer 
			$f = fopen('php://memory', 'w'); 
			 
			// Set column headers 
			$fields = array('notice_date', 'village_court', 'camera_location', 'plate', 'state', 'type', 'violation_date', 'full_name', 'address1', 'address2', 'city', 'zip', 'violation_time', 'due_date', 'plate_photo', 'violation_video', 'violation_number', 'pin', 'amount_due', 'date_paid', 'amount_paid', 'payment_method', 'status','payment_status'); 
			fputcsv($f, $fields, $delimiter); 
			 
			// Output each row of the data, format line as csv and write to file pointer 
			foreach ($records as $val){
				if($val['status'] == 2) $status_txt = 'Reviewed';
			elseif($val['status'] == 3) $status_txt = 'Mailed';
			elseif($val['status'] == 4) $status_txt = 'Archived';
			elseif($val['status'] == 5)$status_txt = 'Dismissed';
				elseif($val['status'] == 6)$status_txt = 'Disputed';
			else $status_txt = 'New';
					$payment_status = 'Unpaid';
			if($val['payment_status'] == 1)$payment_status = 'Paid';
				$camera_location = !empty($val['camera_location']) ? $val['camera_location'] : '';
				$lineData = array($val['notice_date'], $val['Village_Court'], $camera_location, $val['plate'], $val['state'], $val['type'], $val['violation_date'], $val['full_name'], $val['address1'], $val['address2'], $val['city'], $val['zip'], $val['violation_time'], $val['due_date'], $val['plate_photo'], $val['violation_video'], $val['violation_number'], $val['pin'], $val['amount_due'], $val['date_paid'], $val['amount_paid'], $val['payment_method'], $status_txt,$payment_status); 
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

?>