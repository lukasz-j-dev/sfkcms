<?php
	class Ci_example_model extends CI_Model{

		//---------------------------------------------------
		// get all users for server-side datatable processing (ajax based)
		public function get_all_users(){
			$wh =array();
			$SQL ='SELECT * FROM ci_users';
			$wh[] = " is_admin = 0";
			if(count($wh)>0)
			{
				$WHERE = implode(' and ',$wh);
				return $this->datatable->LoadJson($SQL,$WHERE); // datatable->LoadJson() is a function in datatables custom library
			}
			else
			{
				return $this->datatable->LoadJson($SQL);
			}
		}

		//---------------------------------------------------
		// get all user records for simple datatable example
		public function get_all_simple_users(){

			$this->db->where('is_admin', 0);
			$this->db->order_by('created_at', 'desc');
			$query = $this->db->get('ci_users');
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// get users for csv export
		public function get_users_for_csv(){
			$this->db->where('is_admin', 0);
			$this->db->select('id, username, firstname, lastname, email, mobile_no, created_at');
			$this->db->from('ci_users');
			$query = $this->db->get();
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// Count total users
		public function count_all_users(){
			$this->db->where('is_admin', 0);
			return $this->db->count_all('ci_users');
		}

		//---------------------------------------------------
		// Get all users for pagination example
		public function get_all_users_for_pagination($limit, $offset){
			$wh =array();	
			$this->db->where('is_admin', 0);
			$this->db->order_by('created_at','desc');
			$this->db->limit($limit, $offset);

			if(count($wh)>0){
				$WHERE = implode(' and ',$wh);
				$query = $this->db->get_where('ci_users', $WHERE);
			}
			else{
				$query = $this->db->get('ci_users');
			}
			return $query->result_array();
			//echo $this->db->last_query();
		}


		//---------------------------------------------------
		// get all users for server-side datatable with advanced search
		public function get_all_users_by_advance_search(){
			$wh =array();
			$SQL ='SELECT * FROM ci_users';
			if($this->session->userdata('user_search_type')!='')
			$wh[]="is_active = '".$this->session->userdata('user_search_type')."'";
			if($this->session->userdata('user_search_from')!='')
			$wh[]=" `created_at` >= '".date('Y-m-d', strtotime($this->session->userdata('user_search_from')))."'";
			if($this->session->userdata('user_search_to')!='')
			$wh[]=" `created_at` <= '".date('Y-m-d', strtotime($this->session->userdata('user_search_to')))."'";

			$wh[] = " is_admin = 0";
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





		//---------------------------------------------------
		// Get user detial by ID
		public function get_user_by_id($id){
			return $this->db->get_where('ci_users', array(
			'id' => $id))->row_array();
		}

		//---------------------------------------------------
		// Edit user Record
		public function edit_user($data, $id){
			$this->db->where('id', $id);
			$this->db->update('ci_users', $data);
			return true;
		}

		//---------------------------------------------------
		// Get User Role/Group
		public function get_user_groups(){
			$query = $this->db->get('ci_user_groups');
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// Add Multiple Files
		public function add_multiple_files($data)
		{
			$this->db->insert('ci_uploaded_files',$data);
			return true;
		}

		//---------------------------------------------------
		// Get Multiple Files
		public function get_uploaded_files()
		{
			$this->db->order_by('id','desc');
			$query = $this->db->get('ci_uploaded_files');
			return $result = $query->result_array();
		}

		//---------------------------------------------------
		// Delete File
		public function delete_file($id)
		{
			$this->db->where('id', $id);
			$file = $this->db->get('ci_uploaded_files')->row_array()['name'];

			unlink($file);

			$this->db->where('id', $id);
			$this->db->delete('ci_uploaded_files');
			return true;
		}

		//---------------------------------------------------
		// Country, State & City
		public function get_countries_list()
		{
			$this->db->order_by('name','asc');
			$query = $this->db->get('ci_countries');
			return $result = $query->result_array();
		}

		//  Charts
		public function get_user_record_by_groups()
		{
			$this->db->select('ci_user_groups.group_name as label,COUNT(*) as value');
			$this->db->join('ci_user_groups','ci_user_groups.id = ci_users.role');
			$this->db->group_by('role');
			return $this->db->get('ci_users')->result_array();
		}

		public function get_user_record_by_year()
		{
			$this->db->select('YEAR(created_at) as period,COUNT(*) as users');
			$this->db->group_by('YEAR(created_at)');
			$this->db->order_by('YEAR(created_at)','asc');
			return $this->db->get('ci_users')->result_array();
		}

		public function get_user_activity_by_month()
		{
			$this->db->select('COUNT(*) as y,MONTHNAME(created_at) as x');
			$this->db->group_by('MONTH(created_at)');
			$this->db->order_by('MONTH(created_at)','asc');
			return $this->db->get('ci_activity_log')->result_array();
		}

		public function get_user_activity_by_month_line_chart()
		{
			$this->db->select('YEAR(created_at) as period,COUNT(*) as activity');
			$this->db->group_by('YEAR(created_at)');
			$this->db->order_by('YEAR(created_at)','asc');
			return $this->db->get('ci_activity_log')->result_array();
		}

	}

?>