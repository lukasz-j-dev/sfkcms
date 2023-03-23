<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Activity_model extends CI_Model{

	public function get_activity_log(){
		$this->db->select('
			ci_activity_log.id,
			ci_activity_log.activity_id,
			ci_activity_log.user_id,
			ci_activity_log.created_at,
			ci_activity_status.description,
			ci_users.id as uid,
			ci_users.username,
			ci_users.role,
			ci_user_groups.group_name,
		');
		$this->db->join('ci_activity_status','ci_activity_status.id=ci_activity_log.activity_id');
		$this->db->join('ci_users','ci_users.id=ci_activity_log.user_id');
		$this->db->join('ci_user_groups','ci_user_groups.id=ci_users.role');
		$this->db->order_by('ci_activity_log.id','desc');
		return $this->db->get('ci_activity_log')->result_array();
	}

	//--------------------------------------------------------------------
	public function add($activity){
		$data = array(
			'activity_id' => $activity,
			'user_id' => ($this->session->userdata('user_id') != '') ? $this->session->userdata('user_id') : $this->session->userdata('admin_id'),
			'created_at' => date('Y-m-d H:i:s')
		);
		$this->db->insert('ci_activity_log',$data);
		return true;
	}
	

	
}

?>