<?php
class Datatable 
{	
	function __construct()
	{
		$this->obj =& get_instance();
	}
	//--------------------------------------------
	function LoadJson($SQL,$EXTRA_WHERE='',$GROUP_BY='', $order_by = '')
	{
		if(!empty($EXTRA_WHERE))
		{
			// $SQL.= " WHERE ( $EXTRA_WHERE )";
			$SQL.= " WHERE $EXTRA_WHERE ";
		}
		else
		{
			$SQL.= " WHERE 1 ";
		}
		$query = $this->obj->db->query($SQL);
		$total = $query->num_rows();
		//------------------------------------------------
		if(!empty($_GET['search']['value']))
		{
			$qry = array();
			foreach($_GET['columns'] as $cl)
			{
				if($cl['searchable']=='true' && !empty($cl['name']))  // Shang
					$qry[] =" ".$cl['name']." like '%".$_GET['search']['value']."%' ";
			}
			
            // Shang
			if ( is_array($qry) && count($qry) ) {
				$SQL.= "AND ( ";
				$SQL.= implode("OR",$qry);
				$SQL.= " ) ";	
			}
		}
        //------------------------------------------------
		if(!empty($GROUP_BY))
		{
			$SQL.= $GROUP_BY;
		}
	 	//------------------------------------------------
		$query = $this->obj->db->query($SQL);
		// $filtered = $query->num_rows();
		
		// Shang
		$filtered = 0;
		if ( $query !== FALSE && $query->num_rows() > 0 )
			$filtered = $query->num_rows();

        
		$SQL.= " ORDER BY ";
		$SQL.= $_GET['columns'][$_GET['order'][0]['column']]['name']." ";
		$SQL.= $_GET['order'][0]['dir'];/*
		$SQL.= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start']." ";
		*/
		
        // Shang
        // if ( $_GET['columns'][$_GET['order'][0]['column']]['name'] !== 'violation_total' ) {
		// 	$SQL.= " ORDER BY ";
		// 	if ( $order_by ) $SQL.= $order_by;
		// 	else {
		// 		$SQL.= $_GET['columns'][$_GET['order'][0]['column']]['name']." ";
		// 		$SQL.= $_GET['order'][0]['dir'];
		// 	}
		// }
		
		$SQL.= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start']." ";
		// print_r($SQL);
		// die;

		$query = $this->obj->db->query($SQL);
		
		// Shang
		$data = [];
		if ( $query !== false && $query->result_array() )
			$data = $query->result_array();
		
		return array("recordsTotal"=>$total,"recordsFiltered"=>$filtered,'data' => $data);
	}	
	
	function LoadJsoncus($SQL,$EXTRA_WHERE='',$GROUP_BY='',$EXTRA_WHERE_AND='')
	{
		if(!empty($EXTRA_WHERE))
		{
			$SQL.= " WHERE ( $EXTRA_WHERE )";
		}
		else
		{
			$SQL.= " WHERE 1 ";
		}
		
		if(!empty($EXTRA_WHERE_AND))
		{
		 	$SQL.= " and ( $EXTRA_WHERE_AND )";   
		}
		
	
		$query = $this->obj->db->query($SQL);
		$total = $query->num_rows();
		//------------------------------------------------
		if(!empty($_GET['search']['value']))
		{
			$qry = array();
			foreach($_GET['columns'] as $cl)
			{
				if($cl['searchable']=='true' && !empty($cl['name']))  // Shang
					$qry[] =" ".$cl['name']." like '%".$_GET['search']['value']."%' ";
			}
			
            // Shang
			if ( is_array($qry) && count($qry) ) {
				$SQL.= "AND ( ";
				$SQL.= implode("OR",$qry);
				$SQL.= " ) ";	
			}
		}
        //------------------------------------------------
		if(!empty($GROUP_BY))
		{
			$SQL.= $GROUP_BY;
		}
	 	//------------------------------------------------
		$query = $this->obj->db->query($SQL);
		// $filtered = $query->num_rows();
		
		// Shang
		$filtered = 0;
		if ( $query !== FALSE && $query->num_rows() > 0 )
			$filtered = $query->num_rows();

		$SQL.= " ORDER BY ";
		$SQL.= $_GET['columns'][$_GET['order'][0]['column']]['name']." ";
		$SQL.= $_GET['order'][0]['dir'];
		$SQL.= " LIMIT ".$_GET['length']." OFFSET ".$_GET['start']." ";
// 		print_r($SQL);
// 		die;

		$query = $this->obj->db->query($SQL);
		
		// Shang
		$data = [];
		if ( $query !== false && $query->result_array() )
			$data = $query->result_array();
		
		return array("recordsTotal"=>$total,"recordsFiltered"=>$filtered,'data' => $data);
	}	
}
?>