<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once($_SERVER['DOCUMENT_ROOT'] . '/slim-image-cropper/example/slim.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Violations extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('admin/violation_model', 'violation_model');
		$this->load->model('admin/plates_model', 'plates_model');
		$this->load->model('admin/mmc_model', 'mmc_model');   				// Shang
		$this->load->model('admin/village_model', 'village_model');
		$this->load->model('admin/camera_model', 'camera_model');
		$this->load->model('admin/user_model', 'user_model');
		$this->load->model('activity_model', 'activity_model');

		$this->load->library('datatable');
		$this->load->library('session');

		$this->load->helper(array('form', 'url', 'date'));
	}

	public function index()
	{
		$data['view'] = 'admin/violations/violation_list';
		$this->load->view('layout', $data);
	}

	public function all()
	{
		$data['view'] = 'admin/violations/violation_all';
		$this->load->view('layout', $data);
	}

	public function missingmedia()
	{
		$data['view'] = 'admin/violations/violation_missing_media';
		$this->load->view('layout', $data);
	}

	public function missingvideo()
	{
		$data['view'] = 'admin/violations/violation_missing_video';
		$this->load->view('layout', $data);
	}

	public function new()
	{
		$data['view'] = 'admin/violations/violation_new';
		$this->load->view('layout', $data);
	}

	public function duplicates()
	{
		$data['view'] = 'admin/violations/violation_duplicates';
		$this->load->view('layout', $data);
	}

	public function duplicates_new($type)
	{
		switch ($type) {
			case '6hours':
				$data['page_title'] = 'Violation List (Duplicates with 6 Hours range of violation date)';
				$data['page_sub_title'] = 'Showing a list of all violations that are duplicates, where the combination of plate number AND violation date AND violation time appears in at least one other violation ID, with violation date of duplicates are in 6 hours range. Violation status "Archived", "Dismissed" and Plate containing the word DEMO are excluded.';
				break;
			case 'exact_date':
				$data['page_title'] = 'Violation List (Duplicates with exact value of violation date)';
				$data['page_sub_title'] = 'Showing a list of all violations that are duplicates, where the combination of plate number AND violation date AND violation time appears in at least one other violation ID, with violation date of duplicates are excatly the same. Violation status "Archived", "Dismissed" and Plate containing the word DEMO are excluded.';
				break;
		}

		$data['cur_tab'] = 'pre-check';
		$data['sub_tab'] = $type;

		$data['type'] = $type;
		$data['view'] = 'admin/violations/new/violation_duplicates';
		$this->load->view('layout', $data);
	}

	public function duplicatemedia()
	{
		$data['view'] = 'admin/violations/violation_duplicate_media';
		$this->load->view('layout', $data);
	}

	public function duplicatemedia_new($type)
	{
		$data['type'] = $type;
		$data['cur_tab'] = 'pre-check';
		$data['sub_tab'] = $type;
		$data['view'] = 'admin/violations/new/violation_duplicate_media';
		$this->load->view('layout', $data);
	}

	public function prequalified()
	{
		$data['view'] = 'admin/violations/violation_prequalified';
		$this->load->view('layout', $data);
	}

	public function multiviolations()
	{
		$data['view'] = 'admin/violations/violation_multiviolations';
		$this->load->view('layout', $data);
	}

	public function notmailedyet()
	{
		$data['view'] = 'admin/violations/violation_notmailedyet';
		$this->load->view('layout', $data);
	}

	public function withinwarningperiod()
	{
		$data['view'] = 'admin/violations/violation_withinwarningperiod';
		$this->load->view('layout', $data);
	}

	public function reviewed()
	{
		$data['view'] = 'admin/violations/violation_reviewed';
		$this->load->view('layout', $data);
	}

	public function mailed()
	{
		$data['view'] = 'admin/violations/violation_mailed';
		$this->load->view('layout', $data);
	}

	public function disputed()
	{
		$data['view'] = 'admin/violations/violation_disputed';
		$this->load->view('layout', $data);
	}

	public function unpaid()
	{
		$data['view'] = 'admin/violations/violation_unpaid';
		$this->load->view('layout', $data);
	}

	public function paid()
	{
		$data['view'] = 'admin/violations/violation_paid';
		$this->load->view('layout', $data);
	}

	public function pastdue()
	{
		$data['view'] = 'admin/violations/violation_pastdue';
		$this->load->view('layout', $data);
	}

	public function warning()
	{
		$data['view'] = 'admin/violations/violation_warning';
		$this->load->view('layout', $data);
	}

	public function dismissed()
	{
		$data['view'] = 'admin/violations/violation_dismissed';
		$this->load->view('layout', $data);
	}

	public function archived()
	{
		$data['view'] = 'admin/violations/violation_archived';
		$this->load->view('layout', $data);
	}

	public function demo()
	{
		$data['view'] = 'admin/violations/violation_all_withdemo';
		$this->load->view('layout', $data);
	}

	public function bulk_edit()
	{
		$data['view'] = 'admin/violations/violation_bulk_edit';
		$this->load->view('layout', $data);
	}

	public function datatable_json_all()
	{
		// Shang
		$records = $this->violation_model->get_violations_all($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {

			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			if ($row['violation_type'] == 1) $row['violation_type'] = 'Violation';
			if ($row['violation_type'] == 2) $row['violation_type'] = 'Warning';
			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				$row['violation_type'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/all') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Duplicates
	public function datatable_json_duplicates()
	{
		// Shang
		$records = $this->violation_model->get_violations_duplicates($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {

			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			if ($row['violation_type'] == 1) $row['violation_type'] = 'Violation';
			if ($row['violation_type'] == 2) $row['violation_type'] = 'Warning';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total']))
			// 	$violation_total = $row['violation_total'];
			// else
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['camera_location'],
				$row['zip'],
				$row['total_violations'],
				$row['violation_type'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/all') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Duplicates new
	public function datatable_json_duplicates_new($type)
	{
		// Shang
		$records = $this->violation_model->get_violations_duplicates_new($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir'], $type);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {

			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			if ($row['violation_type'] == 1) $row['violation_type'] = 'Violation';
			if ($row['violation_type'] == 2) $row['violation_type'] = 'Warning';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total']))
			// 	$violation_total = $row['violation_total'];
			// else
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['camera_location'],
				$row['zip'],
				$row['total_violations'],
				$row['violation_type'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;

		header('Content-Type: application/json');
		echo json_encode($records);
	}

	// Duplicate Media
	public function datatable_json_duplicate_media($type)
	{
		// Shang
		$records = $this->violation_model->get_violations_duplicate_media_new($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir'], $type);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {

			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['date_added_new'] == '0000-00-00 00:00:00' || $row['date_added_new'] == null || date('Y', strtotime($row['date_added_new']))  == 1969) {
				$date_added_new = '';
			} else {
				$date_added_new = date('M d Y', strtotime($row['date_added_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			if ($row['violation_type'] == 1) $row['violation_type'] = 'Violation';
			if ($row['violation_type'] == 2) $row['violation_type'] = 'Warning';

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				'
					<a href="' . $row['violation_video'] . '" target="_blank">video link</a>
				',
				$violation_date_new . ' ' . $row['violation_time'],
				$date_added_new,
				$notice_date_new,
				$row['camera_location'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['dmv_status'],       // Shang
				$row['violation_type'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/all') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>'
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// With Demo
	public function datatable_json_withdemo()
	{
		$records = $this->violation_model->get_violations_withdemo();

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new,
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Paid
	public function datatable_json_paid()
	{
		// Shang
		$records = $this->violation_model->get_violations_paid($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/paid') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>
				',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Past due
	public function datatable_json_pastdue()
	{
		// Shang
		$records = $this->violation_model->get_violations_pastdue($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/paid') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>
				',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Warning
	public function datatable_json_warning()
	{
		// Shang
		$records = $this->violation_model->get_violations_warning($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/paid') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>
				',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Missing Media
	public function datatable_json_missing_media()
	{
		// Shang
		$records = $this->violation_model->get_violations_missing_media($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/missingmedia') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>
				',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Missing Video
	public function datatable_json_missing_video()
	{
		// Shang
		$records = $this->violation_model->get_violations_missing_video($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				'<video style="width: 184px; height: 84px;" controls>
					<source src="' . $row['violation_video'] . '" type="video/mp4">
				</video>',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/missingmedia') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>
				'
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Reviewed
	public function datatable_json_reviewed()
	{
		// Shang
		$records = $this->violation_model->get_violations_reviewed($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) { 
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'Reviewed';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			$violation_type = '';
			if ($row['violation_type'] == 1) $violation_type = 'Violation';
			else if ($row['violation_type'] == 2) $violation_type = 'Warning';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			// Warning period
			// $warning_period_text = 'Not mailed yet';
			// $period = $this->violation_model->get_warning_period( $row['id'] );
			// if ( $period['date_diff'] > 0 && $period['date_diff'] <= 14 ) {
			// 	$warning_period_text = 'Within warning period';
			// 	$this->violation_model->edit_violation( array('within_warning_period' => 1), $row['id'] );
			// }
			// else if ( $period['date_diff'] > 14 ) {
			// 	$warning_period_text = 'Outside warning period';
			// 	$this->violation_model->edit_violation( array('within_warning_period' => 0), $row['id'] );
			// }
			// else {
			// 	$first_notice_date  = date('M d Y', strtotime($period['first_notice_date']));
			// 	$notice_date_new    = date('M d Y', strtotime($period['notice_date_new']));
			// 	$violation_date_new = date('M d Y', strtotime($period['violation_date_new']));

			// 	if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date == $notice_date_new )
			// 		$warning_period_text = 'First violation';
			// 	else if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date != $notice_date_new && $first_notice_date > $violation_date_new )
			// 		$warning_period_text = 'Violation before first notice';
			// 	else
			// 		$warning_period_text = 'Not mailed yet';
			// 	$this->violation_model->edit_violation( array('within_warning_period' => 0), $row['id'] );
			// }

			// Warning period - https://a.cl.ly/GGuzgJ17
			$warning_period_text = '';
			if ( $row['within_warning_period'] == 0 ) $warning_period_text = 'Not mailed yet';
			else if ( $row['within_warning_period'] == 1 ) $warning_period_text = 'First violation';
			else if ( $row['within_warning_period'] == 2 ) $warning_period_text = 'Within warning period';
			else if ( $row['within_warning_period'] == 3 ) $warning_period_text = 'Outside warning period';
			else $warning_period_text = 'Violation before first notice';

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				$row['mmc_plate'],
				$row['plate_score'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$violation_type,
				$payment_status,
				$row['city'],
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				$row['first_notice_date'],
				$warning_period_text,
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/new') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Unpaid
	public function datatable_json_unpaid()
	{
		// Shang
		$records = $this->violation_model->get_violations_unpaid($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/unpaid') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>
				',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// New
	public function datatable_json_new()
	{
		// Shang
		$records = $this->violation_model->get_violations_new($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Violation total
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			// Warning period
			// $warning_period_text = 'Not mailed yet';
			// $period = $this->violation_model->get_warning_period( $row['id'] );
			// if ( $period['date_diff'] > 0 && $period['date_diff'] <= 14 ) {
			// 	$warning_period_text = 'Within warning period';
			// 	$this->violation_model->edit_violation( array('within_warning_period' => 1), $row['id'] );
			// }
			// else if ( $period['date_diff'] > 14 ) {
			// 	$warning_period_text = 'Outside warning period';
			// 	$this->violation_model->edit_violation( array('within_warning_period' => 0), $row['id'] );
			// }
			// else {
			// 	$first_notice_date  = date('M d Y', strtotime($period['first_notice_date']));
			// 	$notice_date_new    = date('M d Y', strtotime($period['notice_date_new']));
			// 	$violation_date_new = date('M d Y', strtotime($period['violation_date_new']));

			// 	if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date == $notice_date_new )
			// 		$warning_period_text = 'First violation';
			// 	else if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date != $notice_date_new && $first_notice_date > $violation_date_new )
			// 		$warning_period_text = 'Violation before first notice';
			// 	else
			// 		$warning_period_text = 'Not mailed yet';
			// 	$this->violation_model->edit_violation( array('within_warning_period' => 0), $row['id'] );
			// }

			// Warning period - https://a.cl.ly/GGuzgJ17
			$warning_period_text = '';
			if ( $row['within_warning_period'] == 0 ) $warning_period_text = 'Not mailed yet';
			else if ( $row['within_warning_period'] == 1 ) $warning_period_text = 'First violation';
			else if ( $row['within_warning_period'] == 2 ) $warning_period_text = 'Within warning period';
			else if ( $row['within_warning_period'] == 3 ) $warning_period_text = 'Outside warning period';
			else $warning_period_text = 'Violation before first notice';

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				$row['mmc_plate'],
				$row['plate_score'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['city'],
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				$row['first_notice_date'],
				$warning_period_text,
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/new') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Pre-qualified
	public function datatable_json_prequalified()
	{
		$records = $this->violation_model->get_violations_prequalified($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total']))
			// 	$violation_total = $row['violation_total'];
			// else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				$row['mmc_plate'],
				$row['plate_score'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['city'],
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/new') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Multi violations
	public function datatable_json_multiviolations()
	{
		$records = $this->violation_model->get_violations_multiviolations($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total']))
			// 	$violation_total = $row['violation_total'];
			// else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				$row['mmc_plate'],
				$row['plate_score'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['city'],
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/new') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Not mailed yet
	public function datatable_json_notmailedyet()
	{
		$records = $this->violation_model->get_violations_notmailedyet();

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				$row['mmc_plate'],
				$row['plate_score'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['city'],
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/new') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Within warning period
	public function datatable_json_withinwarningperiod()
	{
		$records = $this->violation_model->get_violations_withinwarningperiod();

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'New';
			if ($row['status'] == 2) $status_txt = 'Reviewed';
			if ($row['status'] == 3) $status_txt = 'Mailed';
			if ($row['status'] == 4) $status_txt = 'Archived';
			if ($row['status'] == 5) $status_txt = 'Dismissed';
			if ($row['status'] == 6) $status_txt = 'Disputed';
			if ($row['status'] == 7) $status_txt = 'Ready';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				$row['mmc_plate'],
				$row['plate_score'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['city'],
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/new') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Dismissed
	public function datatable_json_dismissed()
	{
		// Shang
		$records = $this->violation_model->get_violations_dismissed($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'Dismissed';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id'] . '/dismissed') . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id']) . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Mailed
	public function datatable_json_mailed()
	{
		// Shang
		$records = $this->violation_model->get_violations_mailed($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'Mailed';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			/*
			$violation_total = 0;
			if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
				$violation_total = $row['violation_total'];
			} else {
				if ($notice_date_new)
					$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			}
			*/

			// Warning period - https://a.cl.ly/GGuzgJ17
			$warning_period_text = '';
			if ( $row['within_warning_period'] == 0 ) $warning_period_text = 'Not mailed yet';
			else if ( $row['within_warning_period'] == 1 ) $warning_period_text = 'First violation';
			else if ( $row['within_warning_period'] == 2 ) $warning_period_text = 'Within warning period';
			else if ( $row['within_warning_period'] == 3 ) $warning_period_text = 'Outside warning period';
			else $warning_period_text = 'Violation before first notice';

			/*
			$warning_period_text = 'Not mailed yet';
			$period = $this->violation_model->get_warning_period( $row['id'] );
			if ( $period['date_diff'] > 0 && $period['date_diff'] <= 14 ) {
				$warning_period_text = 'Within warning period';
				$this->violation_model->edit_violation( array('within_warning_period' => 1), $row['id'] );
			}
			else if ( $period['date_diff'] > 14 ) {
				$warning_period_text = 'Outside warning period';
				$this->violation_model->edit_violation( array('within_warning_period' => 0), $row['id'] );
			}
			else {
				$first_notice_date  = date('M d Y', strtotime($period['first_notice_date']));
				$notice_date_new    = date('M d Y', strtotime($period['notice_date_new']));
				$violation_date_new = date('M d Y', strtotime($period['violation_date_new']));

				if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date == $notice_date_new )
					$warning_period_text = 'First violation';
				else if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date != $notice_date_new && $first_notice_date > $violation_date_new )
					$warning_period_text = 'Violation before first notice';
				else
					$warning_period_text = 'Not mailed yet';
				$this->violation_model->edit_violation( array('within_warning_period' => 0), $row['id'] );
			}
			*/

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				$row['first_notice_date'],
				$warning_period_text,	// https://a.cl.ly/GGuzgJ17
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/mailed') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>
				',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Disputed
	public function datatable_json_disputed()
	{
		// Shang
		$records = $this->violation_model->get_violations_disputed($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {
			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'Disputed';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/disputed') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>
				',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Archived
	public function datatable_json_archived()
	{
		// Shang
		$records = $this->violation_model->get_violations_archived($_GET['columns'][$_GET['order'][0]['column']]['name'], $_GET['order'][0]['dir']);

		$data = array();
		$i = 0;

		// Shang - For Previous and Next button
		$user_id = $this->session->userdata('admin_id');
		$this->violation_model->delete_violation_temp_id_by_userid($user_id);

		foreach ($records['data']  as $row) {

			if ($row['violation_date_new'] == '0000-00-00 00:00:00' || $row['violation_date_new'] == null || date('Y', strtotime($row['violation_date_new']))  == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($row['violation_date_new']));
			}
			if ($row['due_date_new'] == '0000-00-00 00:00:00' || $row['due_date_new'] == null || date('Y', strtotime($row['due_date_new']))  == 1969) {
				$due_date_new = '';
			} else {
				$due_date_new = date('M d Y', strtotime($row['due_date_new']));
			}
			if ($row['notice_date_new'] == '0000-00-00 00:00:00' || $row['notice_date_new'] == null || date('Y', strtotime($row['notice_date_new']))  == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($row['notice_date_new']));
			}

			$status_txt = 'Archived';

			$payment_status = 'Unpaid';
			if ($row['payment_status'] == 1) $payment_status = 'Paid';

			// Shang
			// $violation_total = 0;
			// if (!empty($sort_field) && $sort_field == 'violation_total' && isset($row['violation_total'])) {
			// 	$violation_total = $row['violation_total'];
			// } else {
			// 	if ($notice_date_new)
			// 		$violation_total = $this->violation_model->get_violations_count($row['plate'], $row['notice_date_new']);
			// }

			$data[] = array(
				'<input type="checkbox" class="violation_check" name="violation_ids[]" value="' . $row['id'] . '"/>',
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> ' . $row['id'] . '</a>',
				$row['violation_number'] . '-' . $row['pin'],
				$row['plate'],
				'<img src="' . $row['plate_photo'] . '" style="width: 84px;" />',
				$violation_date_new . ' ' . $row['violation_time'],
				$notice_date_new,
				$due_date_new,
				$row['amount_due'],
				$status_txt,
				$payment_status,
				$row['zip_code'],
				$row['total_violations'],       // Shang
				$row['dmv_status'],
				'<a title="View" class="view btn btn-sm btn-info" href="/violations/' . $row['violation_number'] . '-' . $row['pin'] . '"> <i class="material-icons">language</i></a>
				<a title="Edit" class="update btn btn-sm btn-primary" href="' . base_url('admin/violations/edit/' . $row['id']) . '"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" data-href="' . base_url('admin/violations/del/' . $row['id'] . '/archived') . '" data-toggle="modal" data-target="#confirm-delete"> <i class="material-icons">delete</i></a>
				<a href="/ticket/print_ticketpdf.php?violation_id=' . $row['id'] . '&pdf_template=3&nocache=' . str_pad(rand(0, pow(10, 10) - 1), 10, '0', STR_PAD_LEFT) . '" class="btn btn-primary btn-sm pdf_link">PDF</a>
				',
				$row['full_name'],
				$row['address1'],
				$row['address2'],
				$row['zip']
			);

			// Shang - For Previous and Next button
			$v_data = array(
				'v_id' => $row['id'],
				'user_id' => $user_id
			);
			$this->violation_model->add_violation_temp_id($v_data);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Other violations
	public function datatable_json_other_violations($id, $plate)
	{
		// Shang
		$records = $this->violation_model->get_violations_other($id, $plate);

		$data = array();
		$i = 0;

		foreach ($records['data']  as $record) {
			if ($record['violation_date_new'] == '0000-00-00 00:00:00' || $record['violation_date_new'] == null || date('Y', strtotime($record['violation_date_new'])) == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($record['violation_date_new']));
			}
			if ($record['notice_date_new'] == '0000-00-00 00:00:00' || $record['notice_date_new'] == null || date('Y', strtotime($record['notice_date_new'])) == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($record['notice_date_new']));
			}

			$status_txt = 'New';
			if ($record['status'] == 2) $status_txt = 'Reviewed';
			if ($record['status'] == 3) $status_txt = 'Mailed';
			if ($record['status'] == 4) $status_txt = 'Archived';
			if ($record['status'] == 5) $status_txt = 'Dismissed';
			if ($record['status'] == 6) $status_txt = 'Disputed';

			$payment_status = 'Unpaid';
			if ($record['payment_status'] == 1) $payment_status = 'Paid';

			// Warning period
			/*
			$warning_period_text = 'Not mailed yet';
			$period = $this->violation_model->get_warning_period( $record['id'] );
			
			if ( $period['date_diff'] > 0 && $period['date_diff'] <= 14 ) {
				// echo 'a';
				$warning_period_text = 'Within warning period';
				$this->violation_model->edit_violation( array('within_warning_period' => 1), $record['id'] );
			}
			else if ( $period['date_diff'] > 14 ) {
				// echo 'b';
				$warning_period_text = 'Outside warning period';
				$this->violation_model->edit_violation( array('within_warning_period' => 0), $record['id'] );
			}
			else {
				// echo 'c';
				// if ( status = 3,5,6 ) First violation
				// else Not mailed yet.
				// if first notice date is greater than violation date then should say "Violation before first notice date"

				$first_notice_date  = date('M d Y', strtotime($period['first_notice_date']));
				$notice_date_new    = date('M d Y', strtotime($period['notice_date_new']));
				$violation_date_new = date('M d Y', strtotime($period['violation_date_new']));

				if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date == $notice_date_new )
					$warning_period_text = 'First violation';
				else if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date != $notice_date_new && $first_notice_date > $violation_date_new )
					$warning_period_text = 'Violation before first notice';
				else
					$warning_period_text = 'Not mailed yet';
				$this->violation_model->edit_violation( array('within_warning_period' => 0), $record['id'] );
			}
			*/
			// die;

			// Warning period - https://a.cl.ly/GGuzgJ17
			$warning_period_text = '';
			if ( $record['within_warning_period'] == 0 ) $warning_period_text = 'Not mailed yet';
			else if ( $record['within_warning_period'] == 1 ) $warning_period_text = 'First violation';
			else if ( $record['within_warning_period'] == 2 ) $warning_period_text = 'Within warning period';
			else if ( $record['within_warning_period'] == 3 ) $warning_period_text = 'Outside warning period';
			else $warning_period_text = 'Violation before first notice';

			if ($record['violation_type'] == 1) $record['violation_type'] = 'Violation';
			else if ($record['violation_type'] == 2) $record['violation_type'] = 'Warning';

			$data[] = array(
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $record['id']) . '"> ' . $record['id'] . '</a>',
				'<img src="' . $record['plate_photo'] . '" style="width: 84px;" />',
				'<video style="width: 184px; height: 100px;" controls>
					<source src="' . $record['violation_video'] . '" type="video/mp4">
				</video>',
				$record['violation_number'] . '-' . $record['pin'],
				$record['plate'],
				$violation_date_new . ' / ' . $record['violation_time'],
				$notice_date_new,
				$status_txt . ' - ' . $payment_status,
				$record['camera_location'],
				$record['address'],
				$record['city'],
				$record['state'],
				$record['zip_code'],
				$record['first_notice_date'],
				$warning_period_text,
				$record['dmv_status'],
				$record['violation_type'],
				'<a title="Archive" class="archive btn btn-sm btn-primary" data-href="' . base_url('admin/violations/archive/' . $record['id'] . '/' . $id) . '" data-toggle="modal" data-target="#confirm-archive"><i class="material-icons">update</i></a>'
			);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	// Other violations
	public function datatable_json_duplicates_by_violation($id)
	{
		// Shang
		$records = $this->violation_model->get_duplicates_by_violation($id);

		$data = array();
		$i = 0;

		foreach ($records['data']  as $record) {
			if ($record['violation_date_new'] == '0000-00-00 00:00:00' || $record['violation_date_new'] == null || date('Y', strtotime($record['violation_date_new'])) == 1969) {
				$violation_date_new = '';
			} else {
				$violation_date_new = date('M d Y', strtotime($record['violation_date_new']));
			}
			if ($record['notice_date_new'] == '0000-00-00 00:00:00' || $record['notice_date_new'] == null || date('Y', strtotime($record['notice_date_new'])) == 1969) {
				$notice_date_new = '';
			} else {
				$notice_date_new = date('M d Y', strtotime($record['notice_date_new']));
			}

			$status_txt = 'New';
			if ($record['status'] == 2) $status_txt = 'Reviewed';
			if ($record['status'] == 3) $status_txt = 'Mailed';
			if ($record['status'] == 4) $status_txt = 'Archived';
			if ($record['status'] == 5) $status_txt = 'Dismissed';
			if ($record['status'] == 6) $status_txt = 'Disputed';

			$payment_status = 'Unpaid';
			if ($record['payment_status'] == 1) $payment_status = 'Paid';

			// Warning period
			/*
			$warning_period_text = 'Not mailed yet';
			$period = $this->violation_model->get_warning_period( $record['id'] );

			if ( $period['date_diff'] > 0 && $period['date_diff'] <= 14 ) {
				// echo 'a';
				$warning_period_text = 'Within warning period';
				$this->violation_model->edit_violation( array('within_warning_period' => 1), $record['id'] );
			}
			else if ( $period['date_diff'] > 14 ) {
				// echo 'b';
				$warning_period_text = 'Outside warning period';
				$this->violation_model->edit_violation( array('within_warning_period' => 0), $record['id'] );
			}
			else {
				// echo 'c';
				// if ( status = 3,5,6 ) First violation
				// else Not mailed yet.
				// if first notice date is greater than violation date then should say "Violation before first notice date"

				$first_notice_date  = date('M d Y', strtotime($period['first_notice_date']));
				$notice_date_new    = date('M d Y', strtotime($period['notice_date_new']));
				$violation_date_new = date('M d Y', strtotime($period['violation_date_new']));

				if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date == $notice_date_new )
					$warning_period_text = 'First violation';
				else if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date != $notice_date_new && $first_notice_date > $violation_date_new )
					$warning_period_text = 'Violation before first notice';
				else
					$warning_period_text = 'Not mailed yet';
				$this->violation_model->edit_violation( array('within_warning_period' => 0), $record['id'] );
			}
			*/
			// die;

			// Warning period - https://a.cl.ly/GGuzgJ17
			$warning_period_text = '';
			if ( $record['within_warning_period'] == 0 ) $warning_period_text = 'Not mailed yet';
			else if ( $record['within_warning_period'] == 1 ) $warning_period_text = 'First violation';
			else if ( $record['within_warning_period'] == 2 ) $warning_period_text = 'Within warning period';
			else if ( $record['within_warning_period'] == 3 ) $warning_period_text = 'Outside warning period';
			else $warning_period_text = 'Violation before first notice';

			if ($record['violation_type'] == 1) $record['violation_type'] = 'Violation';
			else if ($record['violation_type'] == 2) $record['violation_type'] = 'Warning';


			$data[] = array(
				'<a title="Edit" href="' . base_url('admin/violations/edit/' . $record['id']) . '"> ' . $record['id'] . '</a>',
				'<img src="' . $record['plate_photo'] . '" style="width: 84px;" />',
				'<video style="width: 184px; height: 100px;" controls>
					<source src="' . $record['violation_video'] . '" type="video/mp4">
				</video>',
				$record['violation_number'] . '-' . $record['pin'],
				$record['plate'],
				$violation_date_new . ' / ' . $record['violation_time'],
				$notice_date_new,
				$status_txt . ' - ' . $payment_status,
				$record['camera_location'],
				$record['address'],
				$record['city'],
				$record['state'],
				$record['zip_code'],
				$record['first_notice_date'],
				$warning_period_text,
				$record['dmv_status'],
				$record['violation_type'],
				'<a title="Archive" class="archive btn btn-sm btn-primary" data-href="' . base_url('admin/violations/archive/' . $record['id'] . '/' . $id) . '" data-toggle="modal" data-target="#confirm-archive"><i class="material-icons">update</i></a>'
			);

			$i++;
		}

		$records['data'] = $data;
		echo json_encode($records);
	}

	public function add()
	{
		if ($this->input->post('submit')) {
			$this->form_validation->set_rules('notice_date_new', 'notice_date_new', 'trim|required');
			$this->form_validation->set_rules('village_court', 'village_court', 'trim');
			$this->form_validation->set_rules('camera', 'camera', 'trim|required');
			$this->form_validation->set_rules('plate', 'plate', 'trim|required');
			$this->form_validation->set_rules('state', 'state', 'trim|required');
			$this->form_validation->set_rules('type', 'type', 'trim');
			$this->form_validation->set_rules('violation_date_new', 'violation_date_new', 'trim|required');
			$this->form_validation->set_rules('violation_time', 'violation_time', 'trim|required');
			$this->form_validation->set_rules('due_date_new', 'due_date_new', 'trim|required');
			$this->form_validation->set_rules('plate_photo', 'plate_photo', 'trim');
			$this->form_validation->set_rules('violation_video', 'violation_video', 'trim');

			if ($this->form_validation->run() == FALSE) {
				$data['view'] = 'admin/violations/violation_add';
				$this->load->view('layout', $data);
			} else {
				$data = array(
					'notice_date_new' => $this->input->post('notice_date_new'),
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
					'violation_date_new' =>  $this->input->post('violation_date_new'),
					'violation_time' => $this->input->post('violation_time'),
					'status' => 1,
					'due_date_new' => $this->input->post('due_date_new'),
					'plate_photo' => $this->input->post('plate_photo'),
					'violation_video' => $this->input->post('violation_video')
				);

				$pin = mt_rand(101, 998);
				$added_by = $this->session->userdata('admin_id');
				$v_date = strtotime(str_replace('-', ' ', $this->input->post('violation_date_new')));
				$n_month = date("m", $v_date);
				$n_day = date("d", $v_date);
				$n_year = date("y", $v_date);
				$data['pin'] = $pin;
				$data['added_by'] = $added_by;
				$data['date_modified_new'] = date('Y-m-d H:i:s');
				$data = $this->security->xss_clean($data);

				$result = $this->violation_model->add_violation($data);
				if ($result) {
					$violation_number = $n_year . $n_month . $n_day . $result;
					$data['violation_number'] = $violation_number;
					$result = $this->violation_model->edit_violation($data, $result);

					$this->activity_model->add(1);
					$this->session->set_flashdata('msg', 'Violation has been added successfully!');

					redirect(base_url('admin/violations'));
				}
			}
		} else {
			$data['violation']['simple_villages'] = $this->village_model->get_all_active_villages();
			$data['violation']['simple_cameras'] = $this->camera_model->get_all_simple_cameras();
			$data['view'] = 'admin/violations/violation_add';
			$this->load->view('layout', $data);
		}
	}

	public function edit($id = 0)
	{
		if ($this->input->post('violation_date_new')) {
			$this->load->helper('url', 'form');
			$this->form_validation->set_rules('notice_date_new', 'notice_date_new', 'trim|required');
			$this->form_validation->set_rules('violation_type', 'violation_type', 'trim|required');
			$this->form_validation->set_rules('village_court', 'village_court', 'trim');
			$this->form_validation->set_rules('camera', 'camera', 'trim|required');
			$this->form_validation->set_rules('plate', 'plate', 'trim|required');
			$this->form_validation->set_rules('violation_date_new', 'violation_date_new', 'trim|required');
			$this->form_validation->set_rules('violation_time', 'violation_time', 'trim|required');
			$this->form_validation->set_rules('due_date_new', 'due_date_new', 'trim|required');

			if ($this->form_validation->run() == FALSE) {
				$data['view'] = 'admin/violations/violation_edit';
				$violation = $this->violation_model->get_violation_by_id($id);
				$data['violation'] = array_merge($violation, $_POST);
				$data['violation']['simple_villages'] = $this->village_model->get_all_active_villages();
				$data['violation']['simple_cameras'] = $this->camera_model->get_all_simple_cameras();
				$user_details = $this->user_model->get_user_by_id($data['violation']['added_by']);
				$data['violation']['added_by_details'] = $user_details['firstname'] . ' ' . $user_details['lastname'];
				$this->load->view('layout', $data);
			} else {
				if ($this->input->post('violation_date_new') == '0000-00-00 00:00:00' || $this->input->post('violation_date_new') == null || date('Y', strtotime($this->input->post('violation_date_new')))  == 1969) {
					$violation_date_new = '0000-00-00 00:00:00';
				} else {
					$violation_date_new = date('Y-m-d H:i:s', strtotime($this->input->post('violation_date_new')));
				}
				if ($this->input->post('due_date_new') == '0000-00-00 00:00:00' || $this->input->post('due_date_new') == null || date('Y', strtotime($this->input->post('due_date_new')))  == 1969) {
					$due_date_new = '0000-00-00 00:00:00';
				} else {
					$due_date_new = date('Y-m-d H:i:s', strtotime($this->input->post('due_date_new')));
				}
				if ($this->input->post('notice_date_new') == '0000-00-00 00:00:00' || $this->input->post('notice_date_new') == null || date('Y', strtotime($this->input->post('notice_date_new')))  == 1969) {
					$notice_date_new = '0000-00-00 00:00:00';
				} else {
					$notice_date_new = date('Y-m-d H:i:s', strtotime($this->input->post('notice_date_new')));
				}
				if ($this->input->post('date_paid_new') == '0000-00-00 00:00:00' || $this->input->post('date_paid_new') == null || date('Y', strtotime($this->input->post('date_paid_new')))  == 1969) {
					$date_paid_new = '0000-00-00 00:00:00';
				} else {
					$date_paid_new = date('Y-m-d H:i:s', strtotime($this->input->post('date_paid_new')));
				}
				if ($this->input->post('date_added_new') == '0000-00-00 00:00:00' || $this->input->post('date_added_new') == null || date('Y', strtotime($this->input->post('date_added_new')))  == 1969) {
					$date_added_new = '0000-00-00 00:00:00';
				} else {
					$date_added_new = date('Y-m-d H:i:s', strtotime($this->input->post('date_added_new')));
				}

				$data = array(
					'notice_date_new' => $notice_date_new,
					'dismissreason' => $this->input->post('dismissreason'),
					'violation_date_new' => $violation_date_new,
					'due_date_new' => $due_date_new,
					'date_paid_new' => $date_paid_new,
					'violation_type' => $this->input->post('violation_type'),
					'village_court' => $this->input->post('village_court'),
					'camera' => $this->input->post('camera'),
					'plate' => $this->input->post('plate'),
					'violation_time' => $this->input->post('violation_time'),
					'plate_photo' => $this->input->post('plate_photo'),
					'violation_video' => $this->input->post('violation_video'),
					'date_added_new' => $date_added_new,
					'date_modified_new' => date('Y-m-d H:i:s'),
					'amount_due' => $this->input->post('amount_due'),
					'amount_paid' => $this->input->post('amount_paid'),
					'status' => $this->input->post('status'),
					'payment_method' => $this->input->post('payment_method'),
					'payment_status' => $this->input->post('payment_status'),
					'stop_classification' => $this->input->post('stop_classification'),
				);

				// Shang
				if ($this->input->post('status') == 5) {
					$data['dismissed_date'] = date('Y-m-d H:i:s');
				}

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

				$data['date_modified_new'] = date('Y-m-d H:i:s');

				$data = $this->security->xss_clean($data);
				$result = $this->violation_model->edit_violation($data, $id);
				if ($result) {
					$this->violation_model->recalculate_totals( $this->input->post('plate') );		// recalculate total count
					$this->activity_model->add(2);
					if ($this->input->get('save')) {
						$this->session->set_flashdata('msg', 'Violation has been saved successfully!');
						redirect(base_url('admin/violations/all'));
					} else {
						$this->session->set_flashdata('msg', 'Violation has been updated successfully!');
						redirect(base_url('admin/violations/edit/' . $id));
					}
				}
			}
		} else {
			$violation = $this->violation_model->get_violation_by_id($id);
			$plate_details = $this->plates_model->get_plates_by_plate($violation['plate']);

			// Shang
			$data['total'] = isset($plate_details['total_violations']) ? $plate_details['total_violations'] : 0;
			$data['sixty_days'] = (isset($plate_details['violations_60days']) && $plate_details['violations_60days'] == 1) ? $plate_details['violations_60days'] : 0;

			$up_data = array();
			if ((empty($violation['state']) && !empty($plate_details['state'])) || ($plate_details['state'] != $violation['state'])) $up_data['state'] = addslashes($plate_details['state']);
			if ((empty($violation['type']) && !empty($plate_details['plate_type'])) || ($plate_details['plate_type'] != $violation['type'])) $up_data['type'] = $plate_details['plate_type'];
			if ((empty($violation['full_name']) && !empty($plate_details['name'])) || ($plate_details['name'] != $violation['full_name'])) $up_data['full_name'] = addslashes($plate_details['name']);
			if ((empty($violation['address1']) && !empty($plate_details['address'])) || ($plate_details['address'] != $violation['address1'])) $up_data['address1'] = addslashes($plate_details['address']);
			if ((empty($violation['city']) && !empty($plate_details['city'])) || ($plate_details['city'] != $violation['city'])) $up_data['city'] = addslashes($plate_details['city']);
			if ((empty($violation['zip']) && !empty($plate_details['zip_code'])) || ($plate_details['zip_code'] != $violation['zip'])) $up_data['zip'] = $plate_details['zip_code'];

			if (count($up_data) > 0) {
				$up_data = $this->security->xss_clean($up_data);
				$this->violation_model->edit_violation($up_data, $id);
				$violation = $this->violation_model->get_violation_by_id($id);
			}
			$data['violation'] = $violation;
			$data['next_violation'] = $this->violation_model->get_adjacent_violations_details($id, true);
			$data['prev_violation'] = $this->violation_model->get_adjacent_violations_details($id, false);
			$data['plate_details'] = $plate_details;

			// $data['mmc_details'] = $this->mmc_model->get_mmcs_by_mmc($data['violation']['plate']);		// Shang
			$filename = basename($data['violation']['plate_photo']);
			$data['mmc_details'] = $this->mmc_model->get_mmcs_by_image_file_name($filename);		// Shang

			// Get similar MMC plates
			$data['similar_mmc_plates'] = $this->mmc_model->get_mmcs_by_keys($data['mmc_details']['vehicle_type'], $data['mmc_details']['make'], $data['mmc_details']['model']);

			// Get similar DMV plates
			$data['similar_dmv_plates'] = '';
			if (is_array($data['similar_mmc_plates']) && count($data['similar_mmc_plates'])) {
				$sp = '';
				foreach ($data['similar_mmc_plates'] as $plate)
					$sp .= 'plate="' . $plate['plate'] . '" or ';
				if (strlen($sp)) $sp = substr($sp, 0, -3) . ' order by plate';
				$data['similar_dmv_plates'] = $this->plates_model->get_similar_plates($sp);
			}

			// Warning period
			/*
			$warning_period_text = 'Not mailed yet';
			$period = $this->violation_model->get_warning_period( $id );
			if ( $period['date_diff'] > 0 && $period['date_diff'] <= 14 ) {
				$warning_period_text = 'Within warning period';
				// $this->violation_model->edit_violation( array('within_warning_period' => 1), $id );
			}
			else if ( $period['date_diff'] > 14 ) {
				$warning_period_text = 'Outside warning period';
				// $this->violation_model->edit_violation( array('within_warning_period' => 0), $id );
			}
			else {
				$first_notice_date  = date('M d Y', strtotime($period['first_notice_date']));
				$notice_date_new    = date('M d Y', strtotime($period['notice_date_new']));
				$violation_date_new = date('M d Y', strtotime($period['violation_date_new']));

				if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date == $notice_date_new )
					$warning_period_text = 'First violation';
				else if ( ($period['status'] == 3 || $period['status'] == 5 || $period['status'] == 6) && $first_notice_date != $notice_date_new && $first_notice_date > $violation_date_new )
					$warning_period_text = 'Violation before first notice';
				else
					$warning_period_text = 'Not mailed yet';
				// $this->violation_model->edit_violation( array('within_warning_period' => 0), $id );
			}
			*/

			// Warning period - https://a.cl.ly/GGuzgJ17
			$warning_period_text = '';
			if ( $violation['within_warning_period'] == 0 ) $warning_period_text = 'Not mailed yet';
			else if ( $violation['within_warning_period'] == 1 ) $warning_period_text = 'First violation';
			else if ( $violation['within_warning_period'] == 2 ) $warning_period_text = 'Within warning period';
			else if ( $violation['within_warning_period'] == 3 ) $warning_period_text = 'Outside warning period';
			else $warning_period_text = 'Violation before first notice';
			$data['warning_period'] = $warning_period_text;

			$data['violation']['simple_villages'] = $this->village_model->get_all_active_villages();
			$data['violation']['simple_cameras'] = $this->camera_model->get_all_simple_cameras();
			$user_details = $this->user_model->get_user_by_id($data['violation']['added_by']);
			$data['violation']['added_by_details'] = $user_details['firstname'] . ' ' . $user_details['lastname'];
			$data['view'] = 'admin/violations/violation_edit';
			$this->load->view('layout', $data);
		}
	}

	public function del($id = array(), $type = 'all') // Shang added $type
	{
		$this->db->delete('ci_violations', array('id' => $id));

		// Add User Activity
		$this->activity_model->add(3);

		$this->session->set_flashdata('msg', 'Violation has been deleted successfully!');
		redirect(base_url('admin/violations/' . $type));
	}

	public function delete() {
		$violation_ids = $this->input->post('violation_ids');

		if (count($violation_ids)) {
			foreach ($violation_ids as $violation_id) {
				$this->db->delete('ci_violations', array('id' => $violation_id));
			}
			// Add User Activity
			$this->activity_model->add(3);

			$this->session->set_flashdata('msg', 'Violation(s) has been deleted successfully!');

		}
		else $this->session->set_flashdata('error', 'Oops something went wrong');

		redirect(base_url($this->input->post('current_uri')));
	}

	public function archive($archive_id = 0, $id = 0)
	{
		if ( $archive_id > 0 && $id > 0 ) {
			$data = array(
				'status' => 4
			);
			$this->db->where('id', $archive_id);
			$this->db->update('ci_violations', $data);
	
			// Add User Activity
			$this->activity_model->add(3);
	
			$this->session->set_flashdata('msg', 'Archived successfully!');
			redirect(base_url('admin/violations/edit/' . $id));
		}
	}

	public function print_ticket($id = 0)
	{
		$data['violation'] = $this->violation_model->get_violation_by_id($id);
		$this->load->view('admin/violations/print_ticket', $data);
	}

//	public function importcsv($type = 'all')   // Shang added $type parameter
//	{
//		$handle = fopen($_FILES["file"]["tmp_name"], 'r');
//
//		if ($handle) {
//			$violation_head = fgetcsv($handle, 1000, ",");
//			while (($v = fgetcsv($handle, 1000, ",")) !== FALSE) {
//				// Shang
//				$data = array();
//
//				$data['violation_number'] = '';
//				if (is_numeric(array_search("violation_number", $violation_head)) &&  array_search("violation_number", $violation_head) >= 0 && !empty($v[array_search("violation_number", $violation_head)]))
//					$data['violation_number'] = $v[array_search("violation_number", $violation_head)];
//
//				$data['date_added_new'] = date('Y-m-d H:i:s');
//				if (is_numeric(array_search("date_added_new", $violation_head)) && array_search("date_added_new", $violation_head) >= 0 && !empty($v[array_search("date_added_new", $violation_head)]) && $v[array_search("date_added_new", $violation_head)] != NULL && $v[array_search("date_added_new", $violation_head)] != '0000-00-00 00:00:00')
//					$data['date_added_new'] = date('Y-m-d H:i:s', strtotime($v[array_search("date_added_new", $violation_head)]));
//
//				$data['notice_date_new'] = NULL;
//				if (is_numeric(array_search("notice_date_new", $violation_head)) && array_search("notice_date_new", $violation_head) >= 0 && !empty($v[array_search("notice_date_new", $violation_head)]) && $v[array_search("notice_date_new", $violation_head)] != NULL && $v[array_search("notice_date_new", $violation_head)] != '0000-00-00 00:00:00')
//					$data['notice_date_new'] = date('Y-m-d H:i:s', strtotime($v[array_search("notice_date_new", $violation_head)]));
//
//				$data['violation_date_new'] = NULL;
//				if (is_numeric(array_search("violation_date_new", $violation_head)) && array_search("violation_number", $violation_head) >= 0 && !empty($v[array_search("violation_date_new", $violation_head)]) && $v[array_search("violation_date_new", $violation_head)] != NULL && $v[array_search("violation_date_new", $violation_head)] != '0000-00-00 00:00:00')
//					$data['violation_date_new'] = date('Y-m-d H:i:s', strtotime($v[array_search("violation_date_new", $violation_head)]));
//
//				$data['due_date_new'] = NULL;
//				if (is_numeric(array_search("due_date_new", $violation_head)) && array_search("due_date_new", $violation_head) >= 0 && !empty($v[array_search("due_date_new", $violation_head)]) && $v[array_search("due_date_new", $violation_head)] != NULL && $v[array_search("due_date_new", $violation_head)] != '0000-00-00 00:00:00')
//					$data['due_date_new'] = date('Y-m-d H:i:s', strtotime($v[array_search("due_date_new", $violation_head)]));
//
//				$data['violation_time'] = '';
//				if (is_numeric(array_search("violation_time", $violation_head)) && array_search("violation_time", $violation_head) >= 0)
//					$data['violation_time'] = $v[array_search("violation_time", $violation_head)];
//
//				$data['plate'] = '';
//				if (is_numeric(array_search("plate", $violation_head)) && array_search("plate", $violation_head) >= 0 && !empty($v[array_search("plate", $violation_head)]))
//					$data['plate'] = $v[array_search("plate", $violation_head)];
//
//				$data['village_court'] = 0;
//				if (is_numeric(array_search("village_court", $violation_head)) && array_search("village_court", $violation_head) >= 0 && $v[array_search("village_court", $violation_head)]) {
//					$village_details = $this->village_model->get_village_by_name($v[array_search("village_court", $violation_head)]);
//					if (isset($village_details['id']) && $village_details['id'] > 0)
//						$data['village_court'] = $village_details['id'];
//				}
//
//				$data['camera'] = 0;
//				if (is_numeric(array_search("camera_location", $violation_head)) && array_search("camera_location", $violation_head) >= 0 && $v[array_search("camera_location", $violation_head)]) {
//					$camera_details = $this->camera_model->get_camera_by_name($v[array_search("camera_location", $violation_head)]);
//					if (isset($camera_details['id']) && $camera_details['id'] > 0)
//						$data['camera'] = $camera_details['id'];
//				}
//
//				$data['amount_due'] = 0.00;
//				if (is_numeric(array_search("amount_due", $violation_head)) && array_search("amount_due", $violation_head) >= 0 && $v[array_search("amount_due", $violation_head)])
//					$data['amount_due'] = $v[array_search("amount_due", $violation_head)];
//
//				$data['status'] = 1;
//				if (is_numeric(array_search("status", $violation_head)) && array_search("status", $violation_head) >= 0 && $v[array_search("status", $violation_head)]) {
//					if ($v[array_search("status", $violation_head)] == 'Reviewed') 	   $data['status'] = 2;
//					else if ($v[array_search("status", $violation_head)] == 'Mailed')    $data['status'] = 3;
//					else if ($v[array_search("status", $violation_head)] == 'Archived')  $data['status'] = 4;
//					else if ($v[array_search("status", $violation_head)] == 'Dismissed') $data['status'] = 5;
//					else if ($v[array_search("status", $violation_head)] == 'Disputed')  $data['status'] = 6;
//				}
//
//				$data['payment_status'] = 0;
//				if (is_numeric(array_search("payment_status", $violation_head)) && array_search("payment_status", $violation_head) >= 0 && $v[array_search("payment_status", $violation_head)]) {
//					if ($v[array_search("payment_status", $violation_head)] == 'Unpaid')    $data['payment_status'] = 0;
//					else if ($v[array_search("payment_status", $violation_head)] == 'Paid') $data['payment_status'] = 1;
//				}
//
//				$data['plate_photo'] = '';
//				if (is_numeric(array_search("plate_photo", $violation_head)) && array_search("plate_photo", $violation_head) >= 0 && $v[array_search("plate_photo", $violation_head)])
//					$data['plate_photo'] = $v[array_search("plate_photo", $violation_head)];
//
//				$data['violation_video'] = '';
//				if (is_numeric(array_search("violation_video", $violation_head)) && array_search("violation_video", $violation_head) >= 0 && $v[array_search("violation_video", $violation_head)])
//					$data['violation_video'] = $v[array_search("violation_video", $violation_head)];
//
//				$data['date_modified_new'] = date("Y-m-d H:i:s");
//				$data['added_by'] = 43;
//
//				$data = $this->security->xss_clean($data);
//
//				// print_r($data);
//				// die;
//
//				// if (is_numeric(array_search("ID", $violation_head)) && array_search("ID", $violation_head) >= 0 && !empty($v[array_search("ID", $violation_head)])) {
//				$vid = trim($v[array_search("ID", $violation_head)]);
//				if (is_numeric($vid) && $vid >= 0) {
//					// Update
//					$v_details = $this->violation_model->get_violation_by_id($vid);
//					if ($v_details['id'] > 0) {
//						$this->violation_model->edit_violation($data, $v_details['id']);
//					}
//				} else {
//					// Insert
//					// $data = $this->security->xss_clean($data);
//					$insert_id = $this->violation_model->add_violation($data);
//					if ($insert_id) {
//						$insert_data = array();
//
//						$d = date('y-m-d', strtotime($v[array_search("violation_date_new", $violation_head)]));
//						$d_arr = explode('-', $d);
//						$violation_number = $d_arr[0] . $d_arr[1] . $d_arr[2] . $insert_id;
//
//						$insert_data['violation_number'] = $violation_number;
//						$insert_data['pin'] = mt_rand(101, 998);
//						$insert_data = $this->security->xss_clean($insert_data);
//						$this->violation_model->edit_violation($insert_data, $insert_id);
//					}
//				}
//			}
//
//			if ($handle)
//				fclose($handle);
//
//			$this->violation_model->recalculate_totals();		// recalculate total count
//			$this->session->set_flashdata('msg', 'Violation has been imported successfully!');
//			// redirect(base_url('admin/violations/'.$type));
//		} else {
//			$data['view'] = 'admin/violations/import';
//			$data['type'] = $type;
//			$this->load->view('layout', $data);
//		}
//	}

	public function importcsv ()
	{
		$this->load->library('upload');
		$result = $this->upload->do_upload('file');
		var_dump($result);
	}

	public function quick_import($type = 'all')   // Shang added $type parameter
	{
		$data['view'] = 'admin/violations/quick_import';
		$data['villages'] = $this->village_model->get_all_active_villages();
		$data['cameras']  = $this->camera_model->get_all_simple_cameras();
		$data['type'] = $type;		// Shang
		$this->load->view('layout', $data);
	}

	public function import()
	{
		$data['view'] = 'admin/violations/new/violation_import';
		$data['cur_tab'] = 'pre-check';
		$data['sub_tab'] = 'import';
		$this->load->view('layout', $data);
	}

	public function import_save() {
		$data = $violations = $violations_validated = $violations_skipped = array();

		// Upload file library initialization
		$config['upload_path'] = FCPATH . '/uploads/violation_csv';
		$config['allowed_types'] = 'csv';

		$this->load->library('upload', $config);
		if ($this->upload->do_upload('violation_csv'))
		{
			// If file in uploaded, get the file and extract information from it.
			$upload_data = $this->upload->data();

			$file_path = $upload_data['full_path'];

			// Open the file
			$file = fopen($file_path, 'r');

			// Read the header row and use it as the keys for the associative array
			$header = fgetcsv($file);

			// Read the rest of the rows and store them as values
			while (($row = fgetcsv($file)) !== FALSE)
			{
				$violations[] = array_combine($header, $row);;
			}

			// Close the file
			fclose($file);

			// delete stored file when done.
			unlink($upload_data['full_path']);

			foreach ($violations as $violation)
			{
				// Data validation for violation fields.
				if (
					!isset($violation['uuid']) ||
					!isset($violation['mmc_uuid']) ||
					!isset($violation['stop_sign_location']) ||
					!isset($violation['violation_date']) ||
					!isset($violation['violation_video']) ||
					!isset($violation['plate_photo']) ||
					!isset($violation['threshold_limit']) ||
					!isset($violation['threshold_time']) ||
					!isset($violation['plate'])
					)
				{
					//skip record
					$violations_skipped[] = $violation;
					continue; // move to the next iteration
				}

				// Get camera record from stop_sign_location
				$camera = $this->camera_model->get_camera_by_stop_sign_location($violation['stop_sign_location']);
				// Check the correct value of each column
				if (!is_numeric($violation['threshold_limit']) || // threshold_limit must be a number
					!is_numeric($violation['threshold_time']) || // threshold_time must be a number
					!strtotime($violation['violation_date']) || // violation_date must be a valid date format
					empty($camera))
				{
					//skip record
					$violations_skipped[] = $violation;
					continue; // move to the next iteration
				}

				$violation['violation_date'] = date('Y-m-d H:i:s', strtotime($violation['violation_date']));

				// skip violation if exists
				$violation_exists = $this->violation_model->is_exist_violation_by_params_new($violation['plate'], $violation['violation_date'], date('H:i a', strtotime($violation['violation_date'])));

				// Get village record from camera record.
				$village = $this->village_model->get_village_by_id($camera['village_court']);

				if ($violation_exists ||
					empty($village))
				{
					$violations_skipped[] = $violation;
					continue;
				}

				// Fill the violation record's fields
				$violation['camera'] = $camera['id'];
				$violation['camera_zip'] = $camera['camera_zip'];
				$violation['amount_due'] = $village['fine_amount'];
				$violation['village_court'] = $village['id'];

				// static fields
				$violation['status'] = 1;
				$violation['sent_status'] = 0;
				$violation['date_added_new'] = date('Y-m-d h:i:s');
				$violation['notice_date_new'] = date('Y-m-d', strtotime('+2 days', time()));
				$violation['due_date_new'] = date('Y-m-d', strtotime('+32 days', time()));;
				$violation['payment_status'] = 0;
				$violation['violation_type'] = 1;
				$violation['added_by'] = $this->session->userdata('admin_id');
				$violation['pin'] = mt_rand(101, 998);
				$violation['stop_classification'] = '';

				// other tweaks to meet the old code and logic :'(
				$violation['violation_date_new'] = $violation['violation_date'];
				$violation['violation_time'] = date('H:i a', strtotime($violation['violation_date']));

				// add violation record to the database
				$violation_id = $this->violation_model->add_violation($violation);

				if (!$violation_id)
				{
					// if the query fails for somereason, skip the record
					$violations_skipped[] = $violation;
					continue;
				}

				// generate violation_number from now's date + violation ID.
				// example: 221224123 with 22 is the year of 2022, 12 is the month, 24 is the day, 123 is the violation ID.
				else $this->violation_model->edit_violation(['violation_number' => date('ymd', strtotime($violation['violation_date'])) . $violation_id], $violation_id);

				// store the new record in $violations_validated array.
				$violations_validated[] = $violation;
			}

			// build the result feedback.
			$data['violation_total_count'] = count($violations);
			$data['violation_skipped_count'] = count($violations_skipped);
			$data['violation_validated_count'] = count($violations_validated);
			$data['file_name'] = $upload_data['file_name'];

			// generate skipped violations csv file
			if ($data['violation_skipped_count']) {
				// Create csv file and store it in /uploads/violation_csv folder
				$this->load->helper('file');

				$skipped_violations_csv_file_name = 'violations_skipped_' . date('Y-m-d H-i-s') . '_' . $upload_data['file_name'];
				$skipped_violations_csv_file_path = './uploads/violation_csv/' . $skipped_violations_csv_file_name;
				$violations_skipped = array_merge(array($header), $violations_skipped);

				// create the csv file
				$skipped_violation_csv_string = array_to_csv($violations_skipped);

				write_file($skipped_violations_csv_file_path, $skipped_violation_csv_string);

				$data['violation_skipped_url'] = base_url('uploads/violation_csv/'.$skipped_violations_csv_file_name);
			}
		}
		else {
			// handle the upload failure
			$data['errors'] = array($this->upload->display_errors());
		}

		$data['view'] = 'admin/violations/new/violation_import';
		$this->load->view('layout', $data);
	}

	public function download_sample_csv() {
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="import_violation_sample.csv"');

		readfile('uploads/violation_csv/import_violation_sample.csv');
	}

	public function quick_import_csv($type = 'all') // Shang added $type param
	{
		// Shang
		if ($this->input->post('submit')) {
			$this->load->helper('url', 'form');
			$this->form_validation->set_rules('village_court', 'village_court', 'trim|required');
			$this->form_validation->set_rules('camera_location', 'camera_location', 'trim|required');
			$this->form_validation->set_rules('notice_date_new', 'notice_date_new', 'trim|required');
			$this->form_validation->set_rules('due_date_new', 'due_date_new', 'trim|required');
			if ($this->form_validation->run() == FALSE) {
				$data['view'] = 'admin/violations/quick_import';
				$data['type'] = $type;
				$data['villages'] = $this->village_model->get_all_active_villages();
				$data['cameras']  = $this->camera_model->get_all_simple_cameras();
				$this->load->view('layout', $data);
			} else {
				$handle = fopen($_FILES["file"]["tmp_name"], 'r');
				if ($handle) {
					// fgetcsv($handle, 10000, ",");
					$idx = 0;
					while (! feof($handle)) {
						$data = array();
						$row = fgetcsv($handle);
						
						if ( $idx == 0 ) {
							$idx ++;
							continue;
						}

						if ( trim($row[0]) != 'plate' && trim($row[0]) != 'Plate' ) {
							$data['plate'] = $row[0];
							$data['violation_date_new'] = date('Y-m-d H:i:s', strtotime($row[1]));
							$data['violation_time'] = $row[2];
							$data['violation_video'] = $row[3];
							$data['plate_photo'] = $row[4];
	
							$data['notice_date_new'] = date('Y-m-d H:i:s', strtotime($this->input->post('notice_date_new')));
							$data['due_date_new']	 = date('Y-m-d H:i:s', strtotime($this->input->post('due_date_new')));
							$data['village_court'] = $this->input->post('village_court');
	
							$data['camera'] = $this->input->post('camera_location');
	
							$vd = $this->village_model->get_village_by_id($this->input->post('village_court'));
							
							$data['amount_due'] = $vd['fine_amount'];
							$data['status'] = 1;
							$data['payment_status'] = 0;
							$data['date_modified_new'] = date("Y-m-d H:i:s");
							$data['added_by'] = 43;
	
							// Insert
							$data['date_paid_new'] = NULL;
							$data['date_added_new'] = date("Y-m-d H:i:s");
							$data = $this->security->xss_clean($data);
	
							$insert_id = $this->violation_model->add_violation($data);
							if ($insert_id) {
								$insert_data = array();
	
								// $violation_number = date('y').date('m').date('d') . $insert_id;
								$d = date('y-m-d', strtotime($row[1]));
								$d_arr = explode('-', $d);
								$violation_number = $d_arr[0] . $d_arr[1] . $d_arr[2] . $insert_id; //date('y').date('m').date('d') . $insert_id;
	
								$insert_data['violation_number'] = $violation_number;
								$insert_data['pin'] = mt_rand(101, 998);
								$insert_data = $this->security->xss_clean($insert_data);
								$this->violation_model->edit_violation($insert_data, $insert_id);
							}
						}

						$idx ++;
					}

					if ( $handle )
						fclose($handle);

					$this->violation_model->recalculate_totals();		// recalculate total count

					$this->session->set_flashdata('msg', 'Violation has been imported successfully!');
					redirect(base_url('admin/violations/' . $type)); // Shang added $type parameter
					exit;
				} else {
					$data['view'] = 'admin/violations/quick_import';
					$data['type'] = $type;
					$this->load->view('layout', $data);
				}
			}
		} else {
			$data['view'] = 'admin/violations/quick_import';
			$data['type'] = $type;
			$this->load->view('layout', $data);
		}
	}

	public function exportall()
	{
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
		$sheet->setCellValue('A1', 'notice_date_new');
		$sheet->setCellValue('B1', 'village_court');
		$sheet->setCellValue('C1', 'camera_location');
		$sheet->setCellValue('D1', 'plate');
		$sheet->setCellValue('E1', 'state');
		$sheet->setCellValue('F1', 'type');
		$sheet->setCellValue('G1', 'violation_date_new');
		$sheet->setCellValue('H1', 'full_name');
		$sheet->setCellValue('I1', 'address1');
		$sheet->setCellValue('J1', 'address2');
		$sheet->setCellValue('K1', 'city');
		$sheet->setCellValue('L1', 'zip');
		$sheet->setCellValue('M1', 'violation_time');
		$sheet->setCellValue('N1', 'due_date_new');
		$sheet->setCellValue('O1', 'plate_photo');
		$sheet->setCellValue('P1', 'violation_video');
		$sheet->setCellValue('Q1', 'violation_number');
		$sheet->setCellValue('R1', 'pin');
		$sheet->setCellValue('S1', 'camera_zip');
		$sheet->setCellValue('T1', 'amount_due');
		$sheet->setCellValue('U1', 'date_paid_new');
		$sheet->setCellValue('V1', 'amount_paid');
		$sheet->setCellValue('W1', 'payment_method');
		$sheet->setCellValue('X1', 'status');
		$rows = 2;
		//var_dump($excel_format_data);
		//exit;
		$records = $this->violation_model->get_all_simple_violations();
		foreach ($records as $val) {
			if ($val['status'] == 2) $status_txt = 'Reviewed';
			elseif ($val['status'] == 3) $status_txt = 'Mailed';
			elseif ($val['status'] == 4) $status_txt = 'Archived';
			elseif ($val['status'] == 5) $status_txt = 'Dismissed';
			elseif ($val['status'] == 6) $status_txt = 'Disputed';
			else $status_txt = 'New';

			$payment_status = 'Unpaid';
			if ($val['payment_status'] == 1) $payment_status = 'Paid';

			$sheet->setCellValue('A' . $rows, $val['notice_date_new']);
			$sheet->setCellValue('B' . $rows, $val['village_court']);
			$sheet->setCellValue('C' . $rows, $val['camera_location']);
			$sheet->setCellValue('D' . $rows, $val['plate']);
			$sheet->setCellValue('E' . $rows, $val['state']);
			$sheet->setCellValue('F' . $rows, $val['type']);
			$sheet->setCellValue('G' . $rows, $val['violation_date_new']);
			$sheet->setCellValue('H' . $rows, $val['full_name']);
			$sheet->setCellValue('I' . $rows, $val['address1']);
			$sheet->setCellValue('J' . $rows, $val['address2']);
			$sheet->setCellValue('K' . $rows, $val['city']);
			$sheet->setCellValue('L' . $rows, $val['zip']);
			$sheet->setCellValue('M' . $rows, $val['violation_time']);
			$sheet->setCellValue('N' . $rows, $val['due_date_new']);
			$sheet->setCellValue('O' . $rows, $val['plate_photo']);
			$sheet->setCellValue('P' . $rows, $val['violation_video']);
			$sheet->setCellValue('Q' . $rows, $val['violation_number']);
			$sheet->setCellValue('R' . $rows, $val['pin']);
			$sheet->setCellValue('S' . $rows, $val['camera_zip']);
			$sheet->setCellValue('T' . $rows, $val['amount_due']);
			$sheet->setCellValue('U' . $rows, $val['date_paid_new']);
			$sheet->setCellValue('V' . $rows, $val['amount_paid']);
			$sheet->setCellValue('W' . $rows, $val['payment_method']);
			$sheet->setCellValue('X' . $rows, $status_txt);
			$sheet->setCellValue('X' . $rows, $payment_status);
			$rows++;
		}
		$writer = new Xlsx($spreadsheet);
		$writer->save('uploads/excel/' . $fileName . '.xlsx');
		force_download('uploads/excel/' . $fileName . '.xlsx', NULL);
	}

	public function export()
	{
		if (!empty($_REQUEST['violation_id'])) {
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
			$sheet->setCellValue('A1', 'notice_date_new');
			$sheet->setCellValue('B1', 'village_court');
			$sheet->setCellValue('C1', 'camera_location');
			$sheet->setCellValue('D1', 'plate');
			$sheet->setCellValue('E1', 'state');
			$sheet->setCellValue('F1', 'type');
			$sheet->setCellValue('G1', 'violation_date_new');
			$sheet->setCellValue('H1', 'full_name');
			$sheet->setCellValue('I1', 'address1');
			$sheet->setCellValue('J1', 'address2');
			$sheet->setCellValue('K1', 'city');
			$sheet->setCellValue('L1', 'zip');
			$sheet->setCellValue('M1', 'violation_time');
			$sheet->setCellValue('N1', 'due_date_new');
			$sheet->setCellValue('O1', 'plate_photo');
			$sheet->setCellValue('P1', 'violation_video');
			$sheet->setCellValue('Q1', 'violation_number');
			$sheet->setCellValue('R1', 'pin');
			$sheet->setCellValue('S1', 'camera_zip');
			$sheet->setCellValue('T1', 'amount_due');
			$sheet->setCellValue('U1', 'date_paid_new');
			$sheet->setCellValue('V1', 'amount_paid');
			$sheet->setCellValue('W1', 'payment_method');
			$sheet->setCellValue('X1', 'status');
			$rows = 2;
			//var_dump($excel_format_data);
			//exit;
			$records = $query = $this->db->where_in('id', $violation_ids)->get('ci_violations')->result_array();
			foreach ($records as $val) {
				if ($val['status'] == 2) $status_txt = 'Reviewed';
				elseif ($val['status'] == 3) $status_txt = 'Mailed';
				elseif ($val['status'] == 4) $status_txt = 'Archived';
				elseif ($val['status'] == 5) $status_txt = 'Dismissed';
				elseif ($val['status'] == 6) $status_txt = 'Disputed';
				else $status_txt = 'New';

				$payment_status = 'Unpaid';
				if ($val['payment_status'] == 1) $payment_status = 'Paid';
				$sheet->setCellValue('A' . $rows, $val['notice_date_new']);
				$sheet->setCellValue('B' . $rows, $val['village_court']);
				$sheet->setCellValue('C' . $rows, $val['camera_location']);
				$sheet->setCellValue('D' . $rows, $val['plate']);
				$sheet->setCellValue('E' . $rows, $val['state']);
				$sheet->setCellValue('F' . $rows, $val['type']);
				$sheet->setCellValue('G' . $rows, $val['violation_date_new']);
				$sheet->setCellValue('H' . $rows, $val['full_name']);
				$sheet->setCellValue('I' . $rows, $val['address1']);
				$sheet->setCellValue('J' . $rows, $val['address2']);
				$sheet->setCellValue('K' . $rows, $val['city']);
				$sheet->setCellValue('L' . $rows, $val['zip']);
				$sheet->setCellValue('M' . $rows, $val['violation_time']);
				$sheet->setCellValue('N' . $rows, $val['due_date_new']);
				$sheet->setCellValue('O' . $rows, $val['plate_photo']);
				$sheet->setCellValue('P' . $rows, $val['violation_video']);
				$sheet->setCellValue('Q' . $rows, $val['violation_number']);
				$sheet->setCellValue('R' . $rows, $val['pin']);
				$sheet->setCellValue('S' . $rows, $val['camera_zip']);
				$sheet->setCellValue('T' . $rows, $val['amount_due']);
				$sheet->setCellValue('U' . $rows, $val['date_paid_new']);
				$sheet->setCellValue('V' . $rows, $val['amount_paid']);
				$sheet->setCellValue('W' . $rows, $val['payment_method']);
				$sheet->setCellValue('X' . $rows, $status_txt);
				$sheet->setCellValue('z' . $rows, $payment_status);
				$rows++;
			}
			$writer = new Xlsx($spreadsheet);
			$writer->save('uploads/excel/' . $fileName . '.xlsx');
			force_download('uploads/excel/' . $fileName . '.xlsx', NULL);
		}
	}

	public function exportcsv()
	{
		if (!empty($_REQUEST['violation_id'])) {
			$violation_ids = implode(',', $_REQUEST['violation_id']);
			$records = $this->db->query("select a.*, b.camera_location, c.village_court as Village_Court from ci_violations a left join ci_cameras b on b.id = a.camera left join ci_villages c on a.village_court = c.id where a.id in ($violation_ids)")->result_array();
			if (count($records) > 0) {
				$delimiter = ",";
				$filename = "Violation Report.csv";

				// Create a file pointer 
				$f = fopen('php://memory', 'w');

				// Set column headers 
				$fields = array('notice_date_new', 'village_court', 'camera_location', 'plate', 'state', 'type', 'violation_date_new', 'full_name', 'address1', 'address2', 'city', 'zip', 'violation_time', 'due_date_new', 'plate_photo', 'violation_video', 'violation_number', 'pin', 'amount_due', 'date_paid_new', 'amount_paid', 'payment_method', 'status');
				fputcsv($f, $fields, $delimiter);

				// Output each row of the data, format line as csv and write to file pointer 
				foreach ($records as $val) {
					if ($val['status'] == 2) $status_txt = 'Reviewed';
					elseif ($val['status'] == 3) $status_txt = 'Mailed';
					elseif ($val['status'] == 4) $status_txt = 'Archived';
					elseif ($val['status'] == 5) $status_txt = 'Dismissed';
					elseif ($val['status'] == 6) $status_txt = 'Disputed';
					else $status_txt = 'New';
					$camera_location = !empty($val['camera_location']) ? $val['camera_location'] : '';
					$lineData = array($val['notice_date_new'], $val['Village_Court'], $camera_location, $val['plate'], $val['state'], $val['type'], $val['violation_date_new'], $val['full_name'], $val['address1'], $val['address2'], $val['city'], $val['zip'], $val['violation_time'], $val['due_date_new'], $val['plate_photo'], $val['violation_video'], $val['violation_number'], $val['pin'], $val['amount_due'], $val['date_paid_new'], $val['amount_paid'], $val['payment_method'], $status_txt);
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

	public function exportallcsv($type)
	{
		// Shang
		$results = $this->violation_model->get_csv_data($type);
		if (is_array($results) && count($results)) {
			$delimiter = ",";
			$file_name = "Violation Report(" . $type . ").csv";

			// Create a file pointer 
			$f = fopen('php://memory', 'w');

			// Set column headers 
			$fields = array(
				'ID',
				'violation_number',
				'date_added_new',
				'notice_date_new',
				'violation_date_new',
				'violation_time',
				'due_date_new',
				'plate',
				'village_court',
				'camera_location',
				'amount_due',
				'status',
				'payment_status',
				'plate_photo',
				'violation_video'
			);
			fputcsv($f, $fields, $delimiter);

			// Output each row of the data, format line as csv and write to file pointer 
			foreach ($results as $result) {

				$id = $result['id'];

				$violation_number = $result['violation_number'];
				if (empty($violation_number)) {
					$m = date("m");
					$d = date("d");
					$y = date("y");
					$violation_number = $y . $m . $d . $id;
				}

				$status = 'New';
				switch ($result['status']) {
					case '2':
						$status = 'Reviewed';
						break;
					case '3':
						$status = 'Mailed';
						break;
					case '4':
						$status = 'Archived';
						break;
					case '5':
						$status = 'Dismissed';
						break;
					case '6':
						$status = 'Dismissed';
						break;
				}

				$payment_status = 'Unpaid';
				if ($result['payment_status'] == 1) $payment_status = 'Paid';

				$amount_due = $result['amount_due'];
				if ($amount_due == 0.00 || empty($amount_due) || $amount_due == NULL)
					$amount_due = $result['fine_amount'];

				$lineData = array(
					$id,
					$violation_number,
					date('M d Y', strtotime($result['date_added_new'])),
					date('M d Y', strtotime($result['notice_date_new'])),
					date('M d Y', strtotime($result['violation_date_new'])),
					$result['violation_time'],
					date('M d Y', strtotime($result['due_date_new'])),
					$result['plate'],
					$result['village_court'],
					$result['camera_location'],
					$amount_due,
					$status,
					$payment_status,
					$result['plate_photo'],
					$result['violation_video']
				);
				fputcsv($f, $lineData, $delimiter);
			}

			// Move back to beginning of file 
			fseek($f, 0);

			// Set headers to download file rather than displayed 
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="' . $file_name . '";');

			//output all remaining data on a file pointer 
			fpassthru($f);
		}
	}

	// Tooltip
	public function tooltip($plate)
	{
		$result = $this->violation_model->get_violation_by_plate($plate);
		// print_r($result);
		// die;

		$html = "<h1>No result.</h1>";
		if (is_array($result) && count($result)) {
			$violation_date_new = date('M d Y', strtotime($result['violation_date_new']));
			$violation_time = $result['violation_time'];
			$date = $violation_date_new . ', ' . $violation_time;

			$status_txt = 'New';
			if ($result['status'] == 2) $status_txt = 'Reviewed';
			if ($result['status'] == 3) $status_txt = 'Mailed';
			if ($result['status'] == 4) $status_txt = 'Archived';
			if ($result['status'] == 5) $status_txt = 'Dismissed';
			if ($result['status'] == 6) $status_txt = 'Disputed';

			$payment_status = 'Unpaid';
			if ($result['payment_status'] == 1) $payment_status = 'Paid';

			$html = '
				<div style="width: 60%;">
					<img src="' . $result['plate_photo'] . '" style="border-radius: 10px 0 0 10px; width: 100%;"/>
				</div>
				<div style="width: 40%; background-color: #f0efed; border-radius: 0 10px 10px 0; padding: 15px;">
					<div class="text-left" style="width: 100%; padding: 10px 5px 5px 10px;">
						<b>Status:</b> ' . $status_txt . ' - ' . $payment_status . '
					</div>
					<div class="text-left" style="width: 100%; padding: 0 5px 10px 10px;">
						<b>Violation date:</b> ' . $date . '
					</div>
					<div class="text-left" style="width: 100%; padding: 0 5px 10px 10px;">
						<b>Total definition:</b>
						<div style="padding-left: 10px;">
							<p style="margin: 3px !important;">1. Get today date</p>
							<p style="margin: 3px !important;">2. Get notice date</p>
							<p style="margin: 3px !important;">3. Calculate diff between today and notice date</p>
							<p style="margin: 3px !important;">4. Filter records less than 60 and status is not archived</p>
						</div>
					</div>
				</div>
			';
		}
		echo $html;
	}

	// Status bulk update
	public function bulk_update_violation_status()
	{
		if (isset($_POST['violation_ids'])) {
			$data['data']     = $_POST['violation_ids'];
			$data['cameras']  = $this->camera_model->get_all_simple_cameras();
			$data['villages'] = $this->village_model->get_all_villages_without_stripe_key();
			echo json_encode($data);
		} else echo 'noids';
	}

	// Status bulk DMV update
	public function bulk_update_dmv_status()
	{
		if (is_array($this->input->post('violation_ids')) && count($this->input->post('violation_ids'))) {
			$ids = $this->input->post('violation_ids');
			foreach ($ids as $id) {
				$plate = $this->violation_model->get_violation_by_id($id);
				if (is_array($plate) && count($plate) && $plate['plate'] != 'DEMO')
					$this->plates_model->dmv_api($plate['plate'], $id);
			}

			echo 'success';
		} else {
			echo 'err';
		}
	}

	// Violation bulk edit
	public function violation_bulk_edit($type = 'all')
	{
		$data = array();

		if (!empty(trim($this->input->post('village_court'))) && is_numeric(trim($this->input->post('village_court'))))
			$data['village_court'] = trim($this->input->post('village_court'));
		if (!empty(trim($this->input->post('camera_location'))) && is_numeric(trim($this->input->post('camera_location'))))
			$data['camera'] = trim($this->input->post('camera_location'));
		if (!empty(trim($this->input->post('violation_status'))) && is_numeric(trim($this->input->post('violation_status'))))
			$data['status'] = trim($this->input->post('violation_status'));
		if (!empty(trim($this->input->post('payment_status'))) && is_numeric(trim($this->input->post('payment_status'))))
			$data['payment_status'] = trim($this->input->post('payment_status'));
		if (!empty(trim($this->input->post('notice_date_new')))) {
			$notice_date_new = date('Y-m-d H:i:s', strtotime($this->input->post('notice_date_new')));
			$data['notice_date_new'] = $notice_date_new;
		}
		if (!empty(trim($this->input->post('due_date_new')))) {
			$due_date_new = date('Y-m-d H:i:s', strtotime($this->input->post('due_date_new')));
			$data['due_date_new'] = $due_date_new;
		}

		if (is_array($data) && count($data))
			foreach ($_POST as $key => $id)
				if (is_numeric($key))
					$this->violation_model->edit_violation($data, $id);

		$this->session->set_flashdata('msg', 'Violation info has been bulk edited successfully!');
		redirect(base_url('admin/violations/' . $type));
	}

	public function update_first_notice_date()
	{
		// 1. Check each plate number and see how many violations of any status you can find. Update plate table with that total count.
		// 2. For each violation, check if status is 3, 5 or 6, then update sent_status = 1
		// 3. Update first notice date
		$this->violation_model->update_totalviolationscount_sentstatus_firstnoticedate_from_violation();
		$this->violation_model->update_warning_period();
		
		echo 'First violation dates are updated successfully.';
	}

	public function recalculate_totals( $plate = '' )
	{
		if ( $this->violation_model->recalculate_totals( $plate ) )
			echo 'Total violations are recaculated successfully.';
	}
}
