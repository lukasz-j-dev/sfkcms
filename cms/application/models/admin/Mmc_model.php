<?php

class Mmc_model extends CI_Model{

	public function add_mmc($data){

		$result = $this->db->insert('ci_mmc', $data);
		$insert_id = $this->db->insert_id();
		return  $insert_id;
	}

	public function get_all_mmcs(){

		$wh = array();

		$SQL ='SELECT * FROM ci_mmc';
		if(count($wh)>0)
		{
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
		}
		else
		{
		  //  die('a');
			return $this->datatable->LoadJson($SQL);
		}
	}

	public function get_all_simple_mmcs(){

		$this->db->order_by('id', 'asc');
		$query = $this->db->get('ci_mmc');
		return $result = $query->result_array();
	}

	public function count_all_mmcs(){

		return $this->db->count_all('ci_mmc');
	}

	public function get_all_mmcs_for_pagination($limit, $offset){

		$wh = array();	
		$this->db->order_by('id', 'desc');
		$this->db->limit($limit, $offset);

		if(count($wh)>0){
			$WHERE = implode(' and ',$wh);
			$query = $this->db->get_where('ci_mmc', $WHERE);
		}
		else{
			$query = $this->db->get('ci_mmc');
		}

		return $query->result_array();
	}

	public function get_mmc_by_id($id){

		$query = $this->db->get_where('ci_mmc', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_mmcs_by_mmc($plate){

		$query = $this->db->get_where('ci_mmc', array('plate' => $plate));
		return $query->row_array();
	}
	
	public function get_mmcs_by_image_file_name($filename){

		$this->db->select('*');
		$this->db->from('ci_mmc');
		$this->db->like('image_name', $filename);
		$query = $this->db->get();
		return $query->row_array();
	}
	
	public function get_mmcs_by_keys($type, $make, $model) {
		$query = 'select plate from ci_mmc where vehicle_type="'.$type.'" and make="'.$make.'" and model="'.$model.'" group by id order by plate';
		return $this->db->query($query)->result_array();
	}

	public function get_mmcs_by_pv($plate, $video_name){

		$where_array = array(
			'plate' => $plate, 
			'video_name' => $video_name
		);
		$query = $this->db->get_where('ci_mmc', $where_array);
		return $query->row_array();
	}
	
	public function edit_mmc($data, $id){

		$this->db->where('id', $id);
		$this->db->update('ci_mmc', $data);
		return true;
	}
	
	// Shang
	public function get_mmcs() {

		$this->db->order_by('time_stamp', 'desc');
		$query = $this->db->get('ci_mmc');
		return $query->result_array();
	}
}