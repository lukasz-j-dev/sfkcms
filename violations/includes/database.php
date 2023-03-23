<?php
	global $db;
	class database{
		function __construct(){
			
			global $servername;
			global $username;
			global $password;
			global $database;

			$this->servername = $servername;
			$this->username = $username;
			$this->password = $password;
			$this->db = $database;

			$con = mysqli_connect($this->servername, $this->username, $this->password, $this->db);
			$this->con = $con;
		}
		function query($query){
			$result = mysqli_query($this->con, $query) or die(mysqli_error($this->con));
			$this->num_rows = ((strpos($query, 'insert') !== false || strpos($query, 'update') !== false || strpos($query, 'delete') !== false) ? 0: mysqli_num_rows($result));
			$this->last_insert_id = ((strpos($query, 'insert') !== false) ? mysqli_insert_id($this->con): 0); 
			$this->result = $result;
			return $result;
		}
		function fetch_array($query = ''){
			if(!empty($query)) $result = $this->query($query);
			else $result = $this->result;
			$results = array();
			if(!empty($result)){
				while($row = mysqli_fetch_array($result, MYSQLI_BOTH)){
					array_push($results, $row);
				}
			}
			return $results;
		}
		function fetch_assoc($query = ''){
			if(!empty($query)) $result = $this->query($query);
			else $result = $this->result;
			$results = array();
			if(!empty($result)){
				while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
					array_push($results, $row);
				}
			}
			return $results;
		}
		function fetch_rows($query = ''){
			if(!empty($query)) $result = $this->query($query);
			else $result = $this->result;
			$results = array();
			if(!empty($result)){
				while($row = mysqli_fetch_array($result, MYSQLI_NUM)){
					array_push($results, $row);
				}
			}
			return $results;
		}
		function fetch_row($query = ''){
			if(!empty($query)) $result = $this->query($query);
			else $result = $this->result;
			$row = array();
			if(!empty($result))  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			return $row;
		}
	}
	$db = new database();
?>