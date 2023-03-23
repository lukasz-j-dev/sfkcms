<?php
class Plates_model extends CI_Model
{
	public function add_plate($data)
	{
		$this->db->insert('ci_plates', $data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	public function get_all_plates()
	{
		$wh = array();
		$SQL = '
			select a.*, b.model
			from ci_plates as a
			left join ci_mmc as b on a.plate = b.plate
		';

		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			return $this->datatable->LoadJson($SQL, $WHERE);
		} else {
			return $this->datatable->LoadJson($SQL);
		}
	}

	public function get_all_simple_plates()
	{
		$this->db->order_by('date_added', 'desc');
		$query = $this->db->get('ci_plates');
		return $query->result_array();
	}

	public function count_all_plates()
	{
		return $this->db->count_all('ci_plates');
	}

	public function get_all_plates_for_pagination($limit, $offset)
	{
		$wh = array();
		$this->db->order_by('date_added', 'desc');
		$this->db->limit($limit, $offset);

		if (count($wh) > 0) {
			$WHERE = implode(' and ', $wh);
			$query = $this->db->get_where('ci_plates', $WHERE);
		} else {
			$query = $this->db->get('ci_plates');
		}

		return $query->result_array();
	}

	public function get_plate_by_id($id)
	{
		$query = $this->db->get_where('ci_plates', array('id' => $id));
		return $query->row_array();
	}

	public function plate_exist($plate)
	{
		$query = $this->db->get_where('ci_plates', array('plate' => $plate));
		if ($query->num_rows() > 0) return true;
		else return false;
	}

	public function get_plates_by_plate($plate)
	{
		$query = $this->db->get_where('ci_plates', array('plate' => $plate));
		return $query->row_array();
	}

	public function edit_plate($data, $id)
	{
		$this->db->where('id', $id);
		$this->db->update('ci_plates', $data);
		return true;
	}

	// Shang
	public function get_platforms($platform)
	{
		$result = $this->db->get_where('ci_platforms', array('platform' => $platform));
		return $result->row_array();
	}

	public function get_similar_plates($params)
	{
		$query = "select * from ci_plates where 1 and " . $params;
		return $this->db->query($query)->result_array();
	}

	public function get_plates($plate = '')
	{
		if ($plate)
			$this->db->where('plate', $plate);
		$this->db->order_by('id', 'asc');
		$query = $this->db->get('ci_plates');
		return $query->result_array();
	}

	public function update_dmv($query)
	{
		$this->db->query($query);
	}

	public function update_by_plate($data, $plate)
	{
		$this->db->where('plate', $plate);
		$this->db->update('ci_plates', $data);
		return true;
	}
}
