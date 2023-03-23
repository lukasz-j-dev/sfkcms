<?php
class Village_model extends CI_Model{

	public function add_village($data){

		$this->db->insert('ci_villages', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}

	public function get_all_villages(){

		$wh =array();
		$SQL ='SELECT * FROM ci_villages';

		if(count($wh)>0)
		{
			$WHERE = implode(' and ',$wh);
			return $this->datatable->LoadJson($SQL,$WHERE);
		}
		else
		{
			return $this->datatable->LoadJson($SQL);
		}
	}

	public function get_all_simple_villages(){

		$this->db->order_by('date_added', 'desc');
		$query = $this->db->get('ci_villages');
		return $query->result_array();
	}

	public function get_all_active_villages(){

		$this->db->order_by('date_added', 'desc');
		$this->db->where('status', 1);
		$query = $this->db->get('ci_villages');
		return $query->result_array();
	}

	public function count_all_villages(){

		return $this->db->count_all('ci_villages');
	}

	public function get_all_villages_for_pagination($limit, $offset){

		$wh =array();	
		$this->db->order_by('date_added', 'desc');
		$this->db->limit($limit, $offset);

		if(count($wh)>0){
			$WHERE = implode(' and ',$wh);
			$query = $this->db->get_where('ci_villages', $WHERE);
		}
		else{
			$query = $this->db->get('ci_villages');
		}

		return $query->result_array();
	}

	public function get_village_by_id($id){

		$query = $this->db->get_where('ci_villages', array('id' => $id));
		return $query->row_array();
	}
	
	public function get_village_by_name($village_court){

		$query = $this->db->get_where('ci_villages', array('village_court' => $village_court));
		return $query->row_array();
	}

	public function edit_village($data, $id){

		$this->db->where('id', $id);
		$this->db->update('ci_villages', $data);
		return true;
	}

	public function get_all_villages_without_stripe_key() {
		
		$query = "select id, village_court from ci_villages where status = 1 order by id";
		return $this->db->query($query)->result_array();
	}
}
