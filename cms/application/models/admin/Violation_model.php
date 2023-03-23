<?php
class Violation_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();

		/* Load Models - Model_1 */
		$this->load->model('admin/plates_model', 'plates_model');
	}

	public function add_violation($data)
	{
		if ( isset($data['plate']) && isset($data['violation_date_new']) && isset($data['violation_time']) && $data['plate'] && $data['violation_date_new'] && $data['violation_time'] ) {
			if ( !$this->plates_model->plate_exist($data['plate']) )
				$this->plates_model->add_plate(array('plate' => $data['plate']));

			$is_exist = $this->is_exist_violation_by_params($data['plate'], $data['violation_date_new'], $data['violation_time']);
			if ( isset($is_exist) && isset($is_exist[0]) && !$is_exist[0]['cnt'] ) {
				$this->db->insert('ci_violations', $data);
				$insert_id = $this->db->insert_id();
		
				if ( isset($data['status']) && ($data['status'] == 3 || $data['status'] == 5 || $data['status'] == 6) ) {
					$sent_status = array('sent_status' => 1);
					$this->db->where('id', $insert_id);
					$this->db->update('ci_violations', $sent_status);
				}
		
				return  $insert_id;
			}
		}

		return 0;
	}

	// Shang - For Previous and Next button
	public function delete_violation_temp_id_by_userid($id)
	{
		$this->db->delete('ci_violations_temp_id', array('user_id' => $id));
	}

	public function add_violation_temp_id($v_data)
	{
		$this->db->insert('ci_violations_temp_id', $v_data);
		return $this->db->insert_id();
	}

	public function get_violations_list()
	{
		$wh = array();
		$SQL = 'SELECT * FROM ci_violations';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			return $this->datatable->LoadJson($SQL, $WHERE);
		} else {
			return $this->datatable->LoadJson($SQL);
		}
	}

	public function get_violations_withdemo()
	{
		$wh = array("plate = 'DEMO'");
		$SQL = 'SELECT * FROM ci_violations';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			return $this->datatable->LoadJson($SQL, $WHERE);
		} else {
			return $this->datatable->LoadJson($SQL);
		}
	}

	public function get_adjacent_violations_details($id, $next = true)
	{
		// Shang - For Previous and Next button
		$violation_id_hash  = array();
		$violation_idx_hash = array();

		$this->db->select('v_id');
		$this->db->from('ci_violations_temp_id');
		$this->db->where('user_id', $this->session->userdata('admin_id'));
		$query = $this->db->get();
		if ($query->num_rows() > 0) {
			$violations_list = $query->result();
			foreach ($violations_list as $idx => $violation) {
				$violation_id_hash[ $violation->v_id ] = $idx;
				$violation_idx_hash[ $idx ] = $violation->v_id;
			}

			if (isset($violation_id_hash[ $id ])) {
				$cur_idx = $violation_id_hash[ $id ];
				if ($next) {
					$tmp_idx = $cur_idx + 1;
					if ( isset($violation_idx_hash[ $tmp_idx ]) && $tmp_idx < count( $violation_idx_hash ) )
						$id  = $violation_idx_hash[$tmp_idx];
					else $id = $violation_idx_hash[ count( $violation_idx_hash ) - 1 ];
				} else {
					$tmp_idx = $cur_idx - 1;
					if ( isset( $violation_idx_hash[ $tmp_idx ] ) && $tmp_idx >= 0 )
						$id  = $violation_idx_hash[ $tmp_idx ];
					else $id = $violation_idx_hash[ 0 ];
				}

				$query = $this->db->where("id", $id)->get('ci_violations');
				return $query->row_array();
			}
		}

		/*
		$sym = $next ? ' >' : ' <';
		$order = $next ? 'asc' : 'desc';
		$query = $this->db->where("id" . $sym,  $id)->limit(1, 0)->order_by('id', $order)->get('ci_violations');

		return $result = $query->row_array();
		*/
	}

	// All
	public function get_violations_all($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh  = array('a.status != 4', "a.plate != 'DEMO'");
		$SQL = '
			select b.dmv_status, b.zip_code, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			// return $this->datatable->LoadJson($SQL,$WHERE);
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ');
		} else {
			// return $this->datatable->LoadJson($SQL);
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
		// 	// if ( is_array($results) && count($results) ) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		// }

		return $results;
	}

	// Duplicates
	public function get_violations_duplicates($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh  = array('a.status != 4', 'a.status != 5', "a.plate not like '%DEMO%'");
		$SQL = '
			SELECT count(a.id) as cnt, group_concat(a.id) as duplicated_ids, a.*, b.total_violations, c.camera_location
			FROM ci_violations as a
			INNER JOIN
			(
				SELECT count(id) as cnt, group_concat(id), id, plate, violation_video, plate_photo, violation_date_new, violation_time
				FROM ci_violations
				where status <> 4 and status <> 5 and plate not like "%DEMO%"
				GROUP BY plate
				having cnt > 1
			) temp ON a.plate = temp.plate and a.violation_date_new = temp.violation_date_new and  abs(timestampdiff(minute, STR_TO_DATE(concat("2022-11-29 ", a.violation_time), "%Y-%m-%d %h:%i %p"), STR_TO_DATE(concat("2022-11-29 ", temp.violation_time), "%Y-%m-%d %h:%i %p"))) <= 360
			inner join ci_plates as b on a.plate = b.plate
			inner join ci_cameras as c on a.camera = c.id
		';

		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			$results = $this->datatable->LoadJson($SQL, $WHERE, 'group by a.plate having cnt > 1 ', ' a.plate, a.violation_date_new, a.violation_time, a.id desc ');
		} else {
			$results = $this->datatable->LoadJson($SQL);
		}

		$duplicated_results = array();
		$duplicated_record_cnt = 0;

		if (is_array($results) && count($results)) {
			foreach ($results['data'] as $result) {
				if ($result['cnt'] > 1) {
					$ids = $result['duplicated_ids'];
					$ids_arr = explode(',', $ids);
					if (is_array($ids_arr) && count($ids_arr)) {
						foreach ($ids_arr as $id) {
							$duplicated_record_cnt++;
							$query = '
								select b.dmv_status, b.zip_code, a.*, c.camera_location
								from ci_violations as a
								left join ci_plates as b on a.plate = b.plate
								inner join ci_cameras as c on a.camera = c.id
								where a.id = ' . $id . '
							';
							$res = $this->db->query($query)->result_array();
							$duplicated_results[] = $res[0];
						}
					}
				}
			}

			$results['data'] = $duplicated_results;
			$results['recordsTotal'] = $duplicated_record_cnt;
			$results['recordsFiltered'] = $duplicated_record_cnt;
		}

		return $results;
	}

	// Duplicates new
	public function get_violations_duplicates_new($sort_field = '', $sort_order = '', $type)
	{
		$results = array();
		$where = '';
		$group_by = '';
		$order = ' v.plate, v.violation_date_new, v.violation_time, v.id desc ';
		// WHERE condition based on type of page: 6hours / exact_date
		switch ($type) {
			case '6hours':
				$query = '
					select count(a.id) as cnt, group_concat(a.id) as duplicated_ids, b.total_violations, c.camera_location
					from ci_violations as a, ci_violations temp, ci_plates b, ci_cameras c';
				$where = 'a.id <> temp.id and a.status not in (4, 5) AND a.plate NOT LIKE "%DEMO%" and temp.status not in (4, 5) AND temp.plate NOT LIKE "%DEMO%" and a.plate = temp.plate and abs(timestampdiff(minute, STR_TO_DATE(concat(SUBSTRING(a.violation_date_new from 1 for 11), a.violation_time), "%Y-%m-%d %h:%i %p"), STR_TO_DATE(concat(SUBSTRING(temp.violation_date_new from 1 for 11), temp.violation_time), "%Y-%m-%d %h:%i %p"))) <= 360
				and a.plate = b.plate and a.camera = c.id';
				$group_by = 'group by a.plate having cnt > 1';
				break;
			case 'exact_date':
				$query = '
					select  count(a.id) as cnt, group_concat(a.id) as duplicated_ids, STR_TO_DATE(CONCAT(SUBSTRING(a.violation_date_new FROM 1 FOR 11), a.violation_time), "%Y-%m-%d %h:%i %p") as full_date, b.total_violations, c.camera_location
					from ci_violations a, ci_plates b, ci_cameras c';
				$where = 'a.status not in (4, 5) AND a.plate NOT LIKE "%DEMO%" 
				and a.plate = b.plate and a.camera = c.id';
				$group_by = 'group by a.plate, full_date having cnt > 1';
				break;
		}

		// Build the query


		// Fetch duplicates from DB
		$results = $this->datatable->LoadJson($query, $where, $group_by, $order);

		// Search for fetched duplicated informations for display
		$duplicated_results = array();
		$duplicated_record_cnt = 0;
		if (is_array($results) && count($results)) {
			foreach ($results['data'] as $result) {
				if ($result['cnt'] > 1) {
					$ids = $result['duplicated_ids'];
					$ids_arr = explode(',', $ids);
					if (is_array($ids_arr) && count($ids_arr)) {
						foreach ($ids_arr as $id) {
							$duplicated_record_cnt++;
							$query = '
								select b.dmv_status, b.zip_code, a.*, c.camera_location
								from ci_violations as a
								left join ci_plates as b on a.plate = b.plate
								inner join ci_cameras as c on a.camera = c.id
								where a.id = ' . $id . '
							';
							$res = $this->db->query($query)->result_array();
							$duplicated_results[] = $res[0];
						}
					}
				}
			}

			$results['data'] = $duplicated_results;
			$results['recordsTotal'] = $duplicated_record_cnt;
			$results['recordsFiltered'] = $duplicated_record_cnt;
		}

		return $results;
	}

	// Duplicate media
	public function get_violations_duplicate_media()
	{
		$results = array();
		$wh  = array("tbl.plate not like '%DEMO%'");
		$SQL = '
			select tbl.id, tbl.plate, tbl.violation_number, tbl.pin, tbl.plate_photo, tbl.violation_video, tbl.violation_date_new, tbl.violation_time, tbl.date_added_new, tbl.notice_date_new, tbl.status, tbl.payment_status, tbl.camera,
			b.zip_code, b.dmv_status, d.camera_location, c.plate_score
			from 
			(
				(
					select count(id) as cnt, id, plate, violation_number, pin, plate_photo, violation_video, violation_date_new, violation_time, date_added_new, notice_date_new, status, payment_status, camera
					from ci_violations
					where 1 and plate not like "%DEMO%"
					group by id, plate_photo
					having cnt > 1
					order by plate_photo
				)
				union all
				(
					select count(id) as cnt, id, plate, violation_number, pin, plate_photo, violation_video, violation_date_new, violation_time, date_added_new, notice_date_new, status, payment_status, camera
					from ci_violations 
					where 1 and plate not like "%DEMO%"
					group by id, violation_video
					having cnt > 1
					order by violation_video
				)
			) as tbl
			left join ci_plates as b on tbl.plate = b.plate
			left join ci_mmc as c on tbl.plate = c.plate
			left join ci_cameras as d on tbl.camera = d.id
		';

		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			// echo $WHERE;
			$results = $this->datatable->LoadJson($SQL, $WHERE, 'group by tbl.id, tbl.plate, tbl.violation_number, tbl.plate_photo, tbl.violation_video, tbl.violation_date_new, tbl.violation_time, tbl.date_added_new, tbl.notice_date_new, tbl.status, tbl.payment_status, tbl.camera ', ' tbl.id desc ');
		} else {
			$results = $this->datatable->LoadJson($SQL);
		}

		return $results;
	}

	// Duplicate media new
	public function get_violations_duplicate_media_new($sort_field = '', $sort_order = '', $type) {
		$results = array();

		$query = '
					select count(a.id) as cnt, group_concat(a.id) as duplicated_ids, 
					       SUBSTRING_INDEX(a.plate_photo, "/", -1) as file_name_duplicate, SUBSTRING_INDEX(a.violation_video, "/", -1) as video_name_duplicate, a.*,
					       b.total_violations, b.zip_code, b.dmv_status, d.camera_location
					from ci_violations a, ci_plates b, ci_cameras d';
		// a.status in (1, 2, 7) and a.plate not like "%DEMO%"
		$where = ' a.plate = b.plate and a.camera = d.id';
		switch ($type) {
			case 'images':
				$group_by = ' group by file_name_duplicate having cnt > 1';
				$order = ' file_name_duplicate, a.id desc ';
				break;
			case 'videos':
				$group_by = ' group by video_name_duplicate having cnt > 1';
				$order = ' video_name_duplicate, a.id desc ';
				break;
		}

		// Fetch duplicates from DB
		$results = $this->datatable->LoadJson($query, $where, $group_by, $order);

		$duplicated_results = array();
		$duplicated_record_cnt = 0;
		if (is_array($results) && count($results)) {
			foreach ($results['data'] as $result) {
				if ($result['cnt'] > 1) {
					$ids = $result['duplicated_ids'];
					$ids_arr = explode(',', $ids);
					if (is_array($ids_arr) && count($ids_arr)) {
						foreach ($ids_arr as $id) {
							$duplicated_record_cnt++;
							$query = '
								select b.dmv_status, b.zip_code, a.*, c.camera_location
								from ci_violations as a
								left join ci_plates as b on a.plate = b.plate
								inner join ci_cameras as c on a.camera = c.id
								where a.id = ' . $id . '
							';
							$res = $this->db->query($query)->result_array();
							$duplicated_results[] = $res[0];
						}
					}
				}
			}

			$results['data'] = $duplicated_results;
			$results['recordsTotal'] = $duplicated_record_cnt;
			$results['recordsFiltered'] = $duplicated_record_cnt;
		}

		return $results;
	}

	// Missing Media
	public function get_violations_missing_media($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh = array("a.plate_photo = ''", "a.plate_photo is null", "a.violation_video = ''", "a.violation_video is null");
		$EXTRA_WHERE_AND = array('a.status != 4');

		$SQL = '
			select b.dmv_status, b.zip_code, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' or ', $wh);
			$whereand = implode($EXTRA_WHERE_AND);
			$whereand .= " and a.plate != 'DEMO'";
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ', $whereand);
		} else {
			//return $this->datatable->LoadJsoncus($SQL);
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
		// 	// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		// }

		return $results;
	}

	// Missing Video
	public function get_violations_missing_video($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh = array("a.status != 4", "a.plate != 'DEMO'");

		$SQL = '
			select b.dmv_status, b.zip_code, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ', 'a.id desc');
		} else {
			$results = $this->datatable->LoadJson($SQL);
		}

		return $results;
	}

	// Reviewed
	public function get_violations_reviewed($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh = array('a.status = 2', "a.plate != 'DEMO'", 'a.violation_type = 1');
		$SQL = '
			select b.zip_code, b.dmv_status, b.first_notice_date, b.total_violations, c.plate as mmc_plate, c.plate_score, a.*, b.city
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
			left join ci_mmc as c on a.plate = c.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			// return $this->datatable->LoadJson($SQL,$WHERE, ' group by a.id');
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id');
		} else {
			// return $this->datatable->LoadJson($SQL);
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
		// 	// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		// }

		return $results;
	}

	// New
	public function get_violations_new($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh = array('a.status = 1', "a.plate != 'DEMO'");
		$SQL = '
			select b.city, b.zip_code, b.dmv_status, b.first_notice_date, b.total_violations, c.plate as mmc_plate, c.plate_score,
			a.violation_date_new, a.due_date_new, a.notice_date_new, a.payment_status, a.within_warning_period,
			a.id, a.violation_number, a.pin, a.plate, a.plate_photo, a.violation_time, a.amount_due, 
			a.full_name, a.address1, a.address2, a.zip
			from ci_violations as a
			left join ci_mmc as c on a.plate = c.plate
			left join ci_plates as b on a.plate = b.plate
		';
		// echo $SQL;
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			//return $this->datatable->LoadJson($SQL,$WHERE, ' group by a.id');
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id');
		} else {
			//return $this->datatable->LoadJson($SQL);
			$results = $this->datatable->LoadJson($SQL);
		}

		/*
		$wh  = array('a.status != 4', "a.plate != 'DEMO'");
		$SQL = '
			select b.dmv_status, b.zip_code, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			// return $this->datatable->LoadJson($SQL,$WHERE);
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ');
		} else {
			// return $this->datatable->LoadJson($SQL);
			$results = $this->datatable->LoadJson($SQL);
		}
		*/

		// Shang
		// if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
		// 	// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		// }

		return $results;
	}

	// Pre-qualified
	public function get_violations_prequalified($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh = array('a.status = 1', "a.plate != 'DEMO'");
		$SQL = '
			select b.zip_code, b.dmv_status, b.total_violations, c.plate as mmc_plate, c.plate_score, a.*, b.city
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
			left join ci_mmc as c on a.plate = c.plate
		';
		if (count($wh) > 0) {
			$WHERE  = implode(' and ', $wh);
			$WHERE .= ' and c.plate_score >= 85';
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id');
		} else {
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);

		// 	$results['data'] = array_filter(
		// 		$results['data'],
		// 		function ($obj) {
		// 			return $obj['violation_total'] == 1;
		// 		}
		// 	);
		// }

		return $results;
	}

	// Multi violations
	public function get_violations_multiviolations($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh = array('a.status = 1', "a.plate != 'DEMO'");
		$SQL = '
			select b.zip_code, b.dmv_status, b.total_violations, c.plate as mmc_plate, c.plate_score, a.*, b.city
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
			left join ci_mmc as c on a.plate = c.plate
		';
		if (count($wh) > 0) {
			$WHERE  = implode(' and ', $wh);
			$WHERE .= ' and c.plate_score >= 85';
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id');
		} else {
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);

		// 	$results['data'] = array_filter(
		// 		$results['data'],
		// 		function ($obj) {
		// 			return $obj['violation_total'] > 1;
		// 		}
		// 	);
		// }

		return $results;
	}

	// Not mailed yet
	public function get_violations_notmailedyet()
	{
		$results = array();
		$wh = array('a.status = 1', "a.plate != 'DEMO'", 'a.within_warning_period = 0');
		$SQL = '
			select b.zip_code, b.dmv_status, b.total_violations, c.plate as mmc_plate, c.plate_score, a.*, b.city
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
			left join ci_mmc as c on a.plate = c.plate
		';
		if (count($wh) > 0) {
			$WHERE  = implode(' and ', $wh);
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id');
		} else {
			$results = $this->datatable->LoadJson($SQL);
		}

		return $results;
	}

	// Within warning period
	public function get_violations_withinwarningperiod()
	{
		$results = array();
		$wh = array('a.status = 1', "a.plate != 'DEMO'", 'a.within_warning_period = 2');
		$SQL = '
			select b.zip_code, b.dmv_status, b.total_violations, c.plate as mmc_plate, c.plate_score, a.*, b.city
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
			left join ci_mmc as c on a.plate = c.plate
		';
		if (count($wh) > 0) {
			$WHERE  = implode(' and ', $wh);
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id');
		} else {
			$results = $this->datatable->LoadJson($SQL);
		}

		return $results;
	}

	// Shang
	public function get_violations_count($plate, $notice_date_new)
	{
		$today = date('Y-m-d') . ' 00:00:00';
		$query = "
			select count(*) as cnt 
			from ci_violations
			where plate = '" . $plate . "' and DATEDIFF('" . $today . "', '" . $notice_date_new . "') < 60  and status <> 4
			group by plate
		";
		$res = $this->db->query($query)->result_array();
		if (isset($res[0]['cnt']) && is_numeric($res[0]['cnt']) && $res[0]['cnt'] > 0) {
			$data = array(
				'violations_30days' => 1,
				'violations_60days' => 1
			);
			$this->plates_model->update_by_plate($data, $plate);
			return $res[0]['cnt'];
		}

		return 0;
	}

	// Dismissed
	public function get_violations_dismissed($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh = array('a.status = 5', "a.plate != 'DEMO'");
		$SQL = '
			select b.dmv_status, b.zip_code, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			//return $this->datatable->LoadJson($SQL,$WHERE);
			$results = $results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ');
		} else {
			//return $this->datatable->LoadJson($SQL);
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
		// 	// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		// }

		return $results;
	}

	// Paid
	public function get_violations_paid($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh = array('a.payment_status = 1', "a.plate != 'DEMO'");
		$SQL = '
			select b.dmv_status, b.zip_code, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			// return $this->datatable->LoadJson($SQL,$WHERE);
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ');
		} else {
			//return $this->datatable->LoadJson($SQL);
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
		// 	// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		// }

		return $results;
	}

	// Unpaid
	public function get_violations_unpaid($sort_field = '', $sort_order = '')
	{
		$results = array();
		$cur_time = time();
		$wh = array("a.status in (3,6)", "a.payment_status=0", "a.plate != 'DEMO'");

		$SQL = '
			select b.dmv_status, b.zip_code, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			//return $this->datatable->LoadJson($SQL,$WHERE);
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ');
		} else {
			//return $this->datatable->LoadJson($SQL);
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
		// 	// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		// }

		return $results;
	}

	// Past due
	public function get_violations_pastdue($sort_field = '', $sort_order = '')
	{
		$today = date('Y-m-d') . ' 00:00:00';
		$wh = array('a.status != 4', 'a.status != 5', 'a.payment_status = 0', "a.plate not like '%DEMO%'", "DATEDIFF('" . $today . "', a.due_date_new) > 8", 'a.violation_type = 1', 'a.violation_type = 1');

		$SQL = '
			select b.dmv_status, b.zip_code, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ');
		} else {
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
		// 	// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		// }

		return $results;
	}

	// Warning
	public function get_violations_warning($sort_field = '', $sort_order = '')
	{
		$today = date('Y-m-d') . ' 00:00:00';
		$wh = array('(a.status = 1 or a.status = 2)', "a.plate not like '%DEMO%'", "a.violation_type = 2");

		$SQL = '
			select b.dmv_status, b.zip_code, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ');
		} else {
			$results = $this->datatable->LoadJson($SQL);
		}

		return $results;
	}

	// Mailed
	public function get_violations_mailed($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh  = array('a.status = 3', "a.plate != 'DEMO'");
		$SQL = '
			select b.dmv_status, b.zip_code, b.first_notice_date, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			// return $this->datatable->LoadJson($SQL,$WHERE, ' group by a.id');
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id');
		} else {
			// return $this->datatable->LoadJson($SQL);
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		/*
		if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
			// if (is_array($results) && count($results)) {
			$new_array = array();
			foreach ($results['data'] as $result) {
				$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
				$result['violation_total'] = $violation_total;
				$new_array[] = $result;
			}
			$results['data'] = $new_array;

			$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
			array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		}
		*/

		return $results;
	}

	// Archived
	public function get_violations_archived($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh = array('a.status = 4', "a.plate != 'DEMO'");

		$SQL = '
			select b.dmv_status, b.zip_code, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			//return $this->datatable->LoadJson($SQL,$WHERE);
			$results = $results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ');
		} else {
			//return $this->datatable->LoadJson($SQL);
			$results = $results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
		// 	// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		// }

		return $results;
	}

	// Disputed
	public function get_violations_disputed($sort_field = '', $sort_order = '')
	{
		$results = array();
		$wh = array('a.status = 6', "a.plate != 'DEMO'");
		$SQL = '
			select b.dmv_status, b.zip_code, b.total_violations, a.*
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
		';
		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			//return $this->datatable->LoadJson($SQL,$WHERE);
			$results = $this->datatable->LoadJson($SQL, $WHERE, ' group by a.id ');
		} else {
			//return $this->datatable->LoadJson($SQL);
			$results = $this->datatable->LoadJson($SQL);
		}

		// Shang
		// if (is_array($results) && count($results) && !empty($sort_field) && $sort_field == 'violation_total') {
		// 	// if (is_array($results) && count($results)) {
		// 	$new_array = array();
		// 	foreach ($results['data'] as $result) {
		// 		$violation_total = $this->get_violations_count($result['plate'], $result['notice_date_new']);
		// 		$result['violation_total'] = $violation_total;
		// 		$new_array[] = $result;
		// 	}
		// 	$results['data'] = $new_array;

		// 	$sort_order = $sort_order == 'asc' ? SORT_ASC : SORT_DESC;
		// 	array_multisort(array_column($results['data'], 'violation_total'), $sort_order, $results['data']);
		// }

		return $results;
	}

	// Other violations
	public function get_violations_other($id, $plate)
	{
		$results = array();
		$where   = array("t.status != 4", "t.plate != 'DEMO'");

		$res_plate = $this->plates_model->get_plates_by_plate( $plate );

		if ( is_array( $res_plate ) && count( $res_plate ) ) {

			$address  = trim($res_plate[ 'address' ]);
			$city     = trim($res_plate[ 'city' ]);
			$state 	  = trim($res_plate[ 'state' ]);
			$zip_code = trim($res_plate[ 'zip_code' ]);

			$SQL = "
				select t.*, b.plate, b.address, b.city, b.state, b.zip_code, b.dmv_status, b.first_notice_date, c.camera_location
				from
				(
					select tbl.*
					from 
					(
						(
							select id, plate, violation_number, pin, violation_date_new, violation_time, notice_date_new, violation_video, plate_photo, status, payment_status, camera, within_warning_period, violation_type
							from ci_violations
							where plate = '$plate' and plate <> 'DEMO' and id <> '$id'
						)
						UNION
						(
							select a.id, b.plate, a.violation_number, a.pin, a.violation_date_new, a.violation_time, a.notice_date_new, a.violation_video, a.plate_photo, a.status, a.payment_status, a.camera, a.within_warning_period, a.violation_type
							from ci_violations as a
							left join ci_plates as b on a.plate = b.plate
							where b.plate <> 'DEMO' and a.id <> '$id' and b.address = '$address' and b.city = '$city' and b.state = '$state' and b.zip_code = '$zip_code'
						)
					) as tbl
					group by tbl.id
				) as t
				left join ci_plates as b on t.plate = b.plate
				left join ci_cameras as c on t.camera = c.id

				/*group by t.id
				order by t.plate, t.violation_date_new desc, t.violation_time desc, t.id desc*/
			";
		}
		else {
			$SQL = "
				select t.*, b.plate, b.address, b.city, b.state, b.zip_code, b.dmv_status, b.first_notice_date, c.camera_location
				from
				(
					select tbl.*
					from 
					(
						select id, plate, violation_number, pin, violation_date_new, violation_time, notice_date_new, violation_video, plate_photo, status, payment_status, camera, within_warning_period, violation_type
						from ci_violations
						where plate = '$plate' and plate <> 'DEMO' and id <> '$id'
					) as tbl
					group by tbl.id
				) as t
				left join ci_plates as b on t.plate = b.plate
				left join ci_cameras as c on t.camera = c.id

				/*group by t.id
				order by t.plate, t.violation_date_new desc, t.violation_time desc, t.id desc*/
			";
		}

		$WHERE = implode(' and ', $where);
		$results = $this->datatable->LoadJson($SQL, $WHERE, 'group by t.id');

		return $results;
	}

	public function get_duplicates_by_violation($id) {
		// get the violation
		$violation = $this->db->get_where('ci_violations', array('id' => $id))->first_row();
		if ($violation) {
			$query = 'select t.*, b.plate, b.address, b.city, b.state, b.zip_code, b.dmv_status, b.first_notice_date, c.camera_location
			from ci_violations t
			inner join ci_plates as b on t.plate = b.plate
			inner join ci_cameras as c on t.camera = c.id';
			$WHERE = ' t.id <> '.$violation->id.' and (SUBSTRING_INDEX(t.plate_photo, "/", -1) = ' . 'SUBSTRING_INDEX("'.$violation->plate_photo.'", "/", -1)
			or SUBSTRING_INDEX(t.violation_video, "/", -1) = ' . 'SUBSTRING_INDEX("'.$violation->violation_video.'", "/", -1)
			or (abs(timestampdiff(minute, STR_TO_DATE(concat(SUBSTRING(t.violation_date_new from 1 for 11), t.violation_time), "%Y-%m-%d %h:%i %p"), STR_TO_DATE(concat(SUBSTRING("'.$violation->violation_date_new.'" from 1 for 11), "'.$violation->violation_time.'"), "%Y-%m-%d %h:%i %p"))) <= 360) and t.plate = "'.$violation->plate.'")';
			return $this->datatable->LoadJson($query, $WHERE, 'group by t.id');
		}
		else return array();
	}

	public function get_all_simple_violations()
	{
		$this->db->order_by('date_added', 'desc');
		$query = $this->db->get('ci_violations');
		return $query->result_array();
	}

	public function count_all_violations()
	{
		return $this->db->count_all('ci_violations');
	}

	public function get_all_violations_for_pagination($limit, $offset)
	{
		$wh = array();
		$this->db->order_by('date_added', 'desc');
		$this->db->limit($limit, $offset);

		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			$query = $this->db->get_where('ci_violations', $WHERE);
		} else {
			$query = $this->db->get('ci_violations');
		}

		return $query->result_array();
	}

	public function get_violation_by_id($id)
	{
		$query = $this->db->get_where('ci_violations', array('id' => $id));
		return $query->row_array();
	}

	public function get_violation_by_id_palte($plate, $plate_video, $plate_photo)
	{
		/*$query = $this->db->get_where('ci_violations', array('plate' => $plate,'violation_video'=>$plate_video,'plate_photo'=>$plate_photo));
		return $result = $query->row_array();*/

		$sql = "select * from ci_violations where plate='" . $plate . "' or violation_video='" . $plate_video . "' or plate_photo='" . $plate_photo . "'";
		$query = $this->db->query($sql);
		return $query->row_array();
	}

	public function get_violation_by_id_all()
	{
		/*$query = $this->db->get_where('ci_violations', array('plate' => $plate,'violation_video'=>$plate_video,'plate_photo'=>$plate_photo));
		return $result = $query->row_array();*/

		$sql = "select * from ci_violations";
		$query = $this->db->query($sql);
		return $query->result_array();
	}

	public function get_violation_by_num_pin($violation_number, $pin)
	{
		$query = $this->db->get_where('ci_violations', array('violation_number' => $violation_number, 'pin' => $pin));
		return $query->row_array();
	}

	public function edit_violation($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('ci_violations', $data);

		if ( isset($data['status']) && ($data['status'] == 3 || $data['status'] == 5 || $data['status'] == 6) ) {
			$sent_status = array('sent_status' => 1);
			$this->db->where('id', $id);
			$this->db->update('ci_violations', $sent_status);
		}

		return true;
	}

	// Shang
	public function get_csv_data($type)
	{
		$condition = "";

		switch ($type) {
			case "all":
				$condition = "";
				break;
			case "missing_media":
				$condition = "and a.plate_photo = '' or a.plate_photo is null or a.violation_video = '' or a.violation_video is null and  a.plate != 'DEMO'";
				break;
			case "new":
				$condition = "and a.status = 1 and a.plate != 'DEMO'";
				break;
			case "reviewed":
				$condition = "and a.status = 2 and a.plate != 'DEMO'";
				break;
			case "mailed":
				$condition = "and a.status = 3 and a.plate != 'DEMO'";
				break;
			case "disputed":
				$condition = "and a.status = 6 and a.plate != 'DEMO'";
				break;
			case "unpaid":
				$condition = "and a.status in (3, 6) and a.payment_status = 0 and a.plate != 'DEMO'";
				break;
			case "paid":
				$condition = "and a.payment_status = 1 and a.plate != 'DEMO'";
				break;
			case "dismissed":
				$condition = "and a.status = 5 and a.plate != 'DEMO'";
				break;
			case "archived":
				$condition = "and a.status = 4 and a.plate != 'DEMO'";
				break;
		}

		$query = "
			select a.*, b. camera_location, c.village_court, c.fine_amount
			from ci_violations as a
			left join ci_cameras as b on a.camera = b.id
			left join ci_villages as c on a.village_court = c.id
			where 1 $condition
		";
		return $this->db->query($query)->result_array();
	}

	public function get_violation_by_plate($plate)
	{
		$this->db->select('plate_photo, status, payment_status, violation_date_new, violation_time');
		$this->db->from('ci_violations');
		$this->db->where('plate', $plate);
		$this->db->limit(1, 0);
		$this->db->order_by('id', 'desc');
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function bulk_update_violation_status($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('ci_violations', $data);
		return true;
	}

	public function is_exist_violation_by_params($plate, $date, $time) // $plate, $video, $image, $date, $time
	{
		if ( $plate && $date && $time ) {
			$time_arr = explode(':', $time);
			$h = $time_arr[0];

			$query = 'select count(*) as cnt from ci_violations where plate="'.$plate.'" and violation_date_new="'.$date.'" and violation_time like "'.$h.'%"';
			return $this->db->query($query)->result_array();
		}

		return array();
	}

	public function is_exist_violation_by_params_new($plate, $date, $time) // $plate, $video, $image, $date, $time
	{

		if ( $plate && $date && $time ) {

			$time_arr = explode(':', $time);
			$h = $time_arr[0];

			$query = 'select id from ci_violations where plate="'.$plate.'" and violation_date_new="'.$date.'" and violation_time like "'.$h.'%"';

			return $this->db->query($query)->num_rows();
		}

		return false;
	}

	public function get_first_notice_date()
	{
		$query = '
			select id, plate, notice_date_new
			from ci_violations
			where id in (
				select min(a.id)
				from ci_violations as a
				left join ci_plates as b on a.plate = b.plate
				where (a.status = 3 or a.status = 5 or a.status = 6) and b.plate not like "%DEMO%"
				group by b.plate
				order by a.id
			)
			group by plate
			order by plate
		';
		return $this->db->query($query)->result_array();
	}

	public function get_warning_period( $id )
	{
		$query = '
			/*select DATEDIFF(a.violation_date_new, b.first_notice_date) as date_diff, a.status, a.notice_date_new, a.violation_date_new, b.first_notice_date*/
			select DATEDIFF(b.first_notice_date, a.violation_date_new) as date_diff, a.status, a.notice_date_new, a.violation_date_new, b.first_notice_date
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
			where a.id = '.$id;

		$result = $this->db->query($query);
		return $result->row_array();
	}

	public function recalculate_totals( $plate_number = '' ) {
		$where_str = '';
		if ( $plate_number ) $where_str = ' and plate="'.$plate_number.'"';

		// Check each plate number and see how many violations of any status you can find. Update plate table with that total count.
		$query = 'select plate, count(*) as violation_total_count from ci_violations where 1 '.$where_str.' and plate not like "%DEMO%" group by plate order by plate';
		$v_lists = $this->db->query($query)->result_array();
		foreach ($v_lists as $list) {
			$plate = $list['plate'];
			$violation_total_count = $list['violation_total_count'];
			$data = array('total_violations' => $violation_total_count);
			$this->plates_model->update_by_plate($data, $plate);
		}

		return true;
	}

	public function update_warning_period( $plate_number = '' ) {
		// Update warning period
		// 0-Not mailed yet, 1-First violation, 2-Within warning period, 3-Outside warning period, 4-Violation before first notice
		$where_str = '';
		if ( $plate_number ) $where_str = ' and a.plate="'.$plate_number.'"';

		$query = '
			select a.id, a.violation_date_new, a.is_first_violation, b.first_notice_date
			from ci_violations as a
			left join ci_plates as b on a.plate = b.plate
			where 1 '.$where_str.' and a.plate not like "%DEMO%" 
			order by a.plate desc
		';
		$v_lists = $this->db->query($query)->result_array();

		foreach ($v_lists as $list) {
			$first_notice_date  = $list['first_notice_date'];
			$violation_date	    = $list['violation_date_new'];
			$is_first_violation = $list['is_first_violation'];
			$id			   	    = $list['id'];

			$data = null;

			if ( is_null($first_notice_date) || empty($first_notice_date) ) {
				$data = array('within_warning_period' => 0);  // Not mailed yet
			}
			else {
				if ( !$is_first_violation ) {
					$violation_date = new DateTime($violation_date);
					$first_notice_date = new DateTime($first_notice_date);
					$interval = $first_notice_date->diff($violation_date);
					// $diff = $interval->days;
					$diff = (int) $interval->format('%R%a');
					if ( $diff != FALSE ) {
						if ( $diff > 8 )
							$data = array('within_warning_period' => 3);
						else {
							if ( $diff >= 0 && $diff < 8 )
								$data = array('within_warning_period' => 2);
							else
								$data = array('within_warning_period' => 4);
						}
					}
					else $data = array('within_warning_period' => 0);
				}
			}

			$this->db->where('id', $id);
			$this->db->update('ci_violations', $data);
		}
	}

	public function update_totalviolationscount_sentstatus_firstnoticedate_from_violation( $plate_number = '' ) {
		$where_str = '';
		if ( $plate_number ) $where_str = ' and plate="'.$plate_number.'"';

		// Check each plate number and see how many violations of any status you can find. Update plate table with that total count.
		$query = 'select plate, count(*) as violation_total_count from ci_violations where 1 '.$where_str.' and plate not like "%DEMO%" group by plate order by plate';
		$v_lists = $this->db->query($query)->result_array();
		foreach ($v_lists as $list) {
			$plate = $list['plate'];
			$violation_total_count = $list['violation_total_count'];

			// Check if plate exists in plate table
			if ( !$this->plates_model->plate_exist($plate) )
				$this->plates_model->add_plate(array('plate' => $plate));
				
			$data = array('total_violations' => $violation_total_count);
			$this->plates_model->update_by_plate($data, $plate);
		}

		// For each violation, check if status is 3, 5 or 6, then update sent_status = 1
		$query = 'select id, status, plate, sent_status from ci_violations where 1 '.$where_str.' and plate not like "%DEMO%" order by plate';
		$v_lists = $this->db->query($query)->result_array();
		foreach ($v_lists as $list) {
			$id = $list['id'];
			$plate = $list['plate'];
			$status = $list['status'];
			// $sent_status = $list['sent_status'];
			if ( $status == 3 || $status == 5 || $status == 6 ) {
				$data = array('sent_status' => 1);
				$this->db->where('id', $id);
				$this->db->update('ci_violations', $data);
			}
		}

		// Update first notice date
		$query = 'select plate from ci_violations where 1 '.$where_str.' and plate not like "%DEMO%" group by plate order by plate';
		$v_lists = $this->db->query($query)->result_array();
		foreach ($v_lists as $list) {
			$plate = $list['plate'];

			$query = 'select id, notice_date_new from ci_violations where 1 and plate = "'.$plate.'" and sent_status = 1 order by notice_date_new limit 1';
			$d_lists = $this->db->query($query)->result_array();
			foreach ( $d_lists as $d ) {
				$d_id = $d['id'];
				$d_notice_date = $d['notice_date_new'];

				$this->plates_model->update_by_plate(array('first_notice_date' => $d_notice_date), $plate);

				$this->db->where('id', $d_id);
				$this->db->update('ci_violations', array('within_warning_period' => 1, 'is_first_violation' => 1));
			}
		}

		return true;
	}
}
