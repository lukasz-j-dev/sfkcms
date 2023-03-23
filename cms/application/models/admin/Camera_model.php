<?php

	class Camera_model extends CI_Model{

		public function add_camera($data){
			
			$this->db->insert('ci_cameras', $data);
			$insert_id = $this->db->insert_id();

			return  $insert_id;

		}

		//---------------------------------------------------
		public function get_all_villages(){

			
			$query = $this->db->get('ci_villages');

			return $result = $query->result_array();

		}

		public function get_all_cameras(){

			$wh =array();

			$SQL ='SELECT * FROM ci_cameras';

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

		public function get_all_simple_cameras(){

			$this->db->order_by('date_added', 'desc');

			$query = $this->db->get('ci_cameras');

			return $result = $query->result_array();

		}



		//---------------------------------------------------

		public function count_all_cameras(){

			return $this->db->count_all('ci_cameras');

		}



		//---------------------------------------------------
		
		public function get_all_cameras_for_pagination($limit, $offset){

			$wh =array();	

			$this->db->order_by('date_added', 'desc');

			$this->db->limit($limit, $offset);



			if(count($wh)>0){

				$WHERE = implode(' and ',$wh);

				$query = $this->db->get_where('ci_cameras', $WHERE);

			}

			else{

				$query = $this->db->get('ci_cameras');

			}

			return $query->result_array();

			//echo $this->db->last_query();

		}




		//---------------------------------------------------

		public function get_camera_by_id($id){

			$query = $this->db->get_where('ci_cameras', array('id' => $id));

			return $result = $query->row_array();

		}
		
		public function get_camera_by_name($camera_location){

			$query = $this->db->get_where('ci_cameras', array('camera_location' => $camera_location));

			return $result = $query->row_array();

		}

		public function get_camera_by_stop_sign_location($stop_sign_location){

			$query = $this->db->get_where('ci_cameras', array('stop_sign_location' => $stop_sign_location));

			return $result = $query->row_array();

		}



		//---------------------------------------------------

		public function edit_camera($data, $id){

			$this->db->where('id', $id);

			$this->db->update('ci_cameras', $data);

			return true;

		}



	}



?>
