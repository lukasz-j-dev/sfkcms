<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends MY_Controller
{
	function __construct()
	{
		parent ::__construct();
		$this->load->library('datatable'); // loaded my custom serverside datatable library
		$this->load->model('admin/location_model', 'location_model');
	}

	// ---------------------------------------------------
	//                     COUNTRY
	//-----------------------------------------------------
	public function index()
	{
		redirect(base_url('admin/location/country'));
	}

	public function country()
	{
		$data['title'] = 'Country List';
		$data['view'] = 'admin/location/country_list';
		$this->load->view('layout', $data);
	}

	//-------------------------------------------------------
	public function country_datatable_json()
	{				   					   
		$records = $this->location_model->get_all_countries();
		$data = array();
		$count=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['status'] == 0)? 'Deactive': 'Active'.'<span>';
			$data[]= array(
				++$count,
				$row['name'],
				'<span class="btn bg-blue  waves-effect" title="status">'.$status.'<span>',				
				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('admin/location/country/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>
            	 <a title="Delete" class="delete btn btn-sm btn-danger" href="'.base_url('admin/location/country/del/'.$row['id']).'" onclick="return confirm(\'Do you want to delete ?\')" > <i class="material-icons">delete</i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------
	public function country_add()
	{
		if($this->input->post()){
			$this->form_validation->set_rules('country', 'country', 'trim|is_unique[ci_countries.name]|required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			if ($this->form_validation->run() === FALSE) {
				$data['view'] = 'admin/location/country_add';
				$this->load->view('layout', $data);
				return;
			}

			$slug = make_slug($this->input->post('country'));
			$data = array(
				'name' => ucfirst($this->input->post('country')),
				'slug' => $slug
			);
			$data = $this->security->xss_clean($data);
			$result = $this->location_model->add_country($data);
			$this->session->set_flashdata('msg','Country has been added successfully');
			redirect(base_url('admin/location/country'));
		}
		else{
			$data['title'] = 'Add Country';
			$data['view'] = 'admin/location/country_add';
			$this->load->view('layout', $data);
		}
	}

	//-----------------------------------------------------
	public function country_edit($id=0)
	{

		if($this->input->post()){
			$this->form_validation->set_rules('country', 'country', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			if ($this->form_validation->run() === FALSE) {
				$data['view'] = 'admin/location/country_edit';
				$this->load->view('layout', $data);
				return;
			}

			$slug = make_slug($this->input->post('country'));
			$data = array(
				'name' => ucfirst($this->input->post('country')),
				'slug' => $slug,
				'status' => $this->input->post('status')
			);
			$data = $this->security->xss_clean($data);
			$result = $this->location_model->edit_country($data, $id);
			$this->session->set_flashdata('msg','Country has been updated successfully');
			redirect(base_url('admin/location/country'));
		}
		else{
			$data['title'] = 'Update Country';
			$data['country'] = $this->location_model->get_country_by_id($id);
			$data['view'] = 'admin/location/country_edit';
			$this->load->view('layout', $data);
		}
	}

	//-----------------------------------------------------
	public function country_del($id = 0)
	{
		$this->db->delete('ci_countries', array('id' => $id));
		$this->session->set_flashdata('msg', 'Country has been Deleted Successfully!');
		redirect(base_url('admin/location/country'));
	}

	// ---------------------------------------------------
	//                     STATE
	//-----------------------------------------------------

	function state()
	{
		$data['title'] = 'State List';
	$data['view'] = 'admin/location/state_list';
		$this->load->view('layout', $data);
	}

	//-------------------------------------------------------
	public function state_datatable_json()
	{				   					   
		$records = $this->location_model->get_all_states();
		$data = array();
		$count=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['status'] == 0)? 'Deactive': 'Active'.'<span>';
			$data[]= array(
				++$count,
				get_country_name($row['country_id']),
				$row['name'],
				'<span class="btn bg-blue  waves-effect" title="status">'.$status.'<span>',				
				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('admin/location/state/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>
            	 <a title="Delete" class="delete btn btn-sm btn-danger" href="'.base_url('admin/location/state/del/'.$row['id']).'" onclick="return confirm(\'Do you want to delete ?\')"> <i class="material-icons">delete</i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------
	public function state_add()
	{
		if($this->input->post()){
			$this->form_validation->set_rules('country', 'country', 'trim|required');
			$this->form_validation->set_rules('state', 'state', 'trim|is_unique[ci_states.name]|required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			if ($this->form_validation->run() === FALSE) {
				$data['view'] = 'admin/location/state_add';
				$this->load->view('layout', $data);
				return;
			}

			$data = array(
				'name' => ucfirst($this->input->post('state')),
				'slug' => make_slug($this->input->post('state')),
				'country_id' => $this->input->post('country'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->location_model->add_state($data);
			$this->session->set_flashdata('msg','State has been added successfully');
			redirect(base_url('admin/location/state'));
		}
		else{
			$data['countries'] = $this->location_model->get_countries_list(); 
			$data['title'] = 'Add State';
			$data['view'] = 'admin/location/state_add';
			$this->load->view('layout', $data);
		}
	}

	//-----------------------------------------------------
	public function state_edit($id=0)
	{

		if($this->input->post()){
			$this->form_validation->set_rules('country', 'country', 'trim|required');
			$this->form_validation->set_rules('state', 'state', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			if ($this->form_validation->run() === FALSE) {
				$data['view'] = 'admin/location/state_edit';
				$this->load->view('layout', $data);
				return;
			}

			$data = array(
				'name' => ucfirst($this->input->post('state')),
				'slug' => make_slug($this->input->post('state')),
				'country_id' => $this->input->post('country'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->location_model->edit_state($data, $id);

			if($result){
				$this->session->set_flashdata('msg','State has been updated successfully');
				redirect(base_url('admin/location/state'));
			}
			
		}
		else{
			$data['title'] = 'Update State';
			$data['countries'] = $this->location_model->get_countries_list(); 
			$data['state'] = $this->location_model->get_state_by_id($id);
			$data['view'] = 'admin/location/state_edit';
			$this->load->view('layout', $data);
		}
	}

	//-----------------------------------------------------
	public function state_del($id = 0)
	{
		$this->db->delete('ci_states', array('id' => $id));
		$this->session->set_flashdata('msg', 'State has been Deleted Successfully!');
		redirect(base_url('admin/location/state'));
	}

	// ---------------------------------------------------
	//                     CITY
	//-----------------------------------------------------

	function city()
	{
		$data['title'] = 'City List';
		$data['view'] = 'admin/location/city_list';
		$this->load->view('layout', $data);
	}

	//-------------------------------------------------------
	public function city_datatable_json()
	{				   					   
		$records = $this->location_model->get_all_cities();
		$data = array();
		$count=0;
		foreach ($records['data']  as $row) 
		{  
			$status = ($row['status'] == 0)? 'Deactive': 'Active'.'<span>';
			$data[]= array(
				++$count,
				get_state_name($row['state_id']),
				$row['name'],
				'<span class="btn bg-blue  waves-effect" title="status">'.$status.'<span>',				
				'<a title="Edit" class="update btn btn-sm btn-warning" href="'.base_url('admin/location/city/edit/'.$row['id']).'"> <i class="material-icons">edit</i></a>
				<a title="Delete" class="delete btn btn-sm btn-danger" href="'.base_url('admin/location/city/del/'.$row['id']).'" onclick="return confirm(\'Do you want to delete ?\')"> <i class="material-icons">delete</i></a>'
			);
		}
		$records['data']=$data;
		echo json_encode($records);						   
	}

	//-----------------------------------------------------
	public function city_add()
	{
		if($this->input->post()){
			$this->form_validation->set_rules('city', 'city', 'trim|is_unique[ci_cities.name]|required');
			$this->form_validation->set_rules('state', 'state', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			if ($this->form_validation->run() === FALSE) {
			$data['view'] = 'admin/location/city_add';
				$this->load->view('layout', $data);
				return;
			}

			$data = array(
				'name' => ucfirst($this->input->post('city')),
				'slug' => make_slug($this->input->post('city')),
				'state_id' => $this->input->post('state'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->location_model->add_city($data);
			$this->session->set_flashdata('msg','City has been added successfully');
			redirect(base_url('admin/location/city'));
		}
		else{
			$data['title'] = 'Add City';
			$data['states'] = $this->location_model->get_states_list();
			$data['view'] = 'admin/location/city_add';
			$this->load->view('layout', $data);
		}
	}

	//-----------------------------------------------------
	public function city_edit($id=0)
	{
		if($this->input->post()){
			$this->form_validation->set_rules('city', 'city', 'trim|required');
			$this->form_validation->set_rules('state', 'state', 'trim|required');
			$this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
			if ($this->form_validation->run() === FALSE) {
				$data['view'] = 'admin/location/city_edit';
				$this->load->view('layout', $data);
				return;
			}

			$data = array(
				'name' => ucfirst($this->input->post('city')),
				'slug' => make_slug($this->input->post('city')),
				'state_id' => $this->input->post('state'),
			);
			$data = $this->security->xss_clean($data);
			$result = $this->location_model->edit_city($data, $id);
			$this->session->set_flashdata('msg','City has been updated successfully');
			redirect(base_url('admin/location/city'));
		}
		else{
			$data['title'] = 'Update City';
			$data['states'] = $this->location_model->get_states_list();
			$data['city'] = $this->location_model->get_city_by_id($id);
			$data['view'] = 'admin/location/city_edit';
			$this->load->view('layout', $data);
		}
	}

	//-----------------------------------------------------
	public function city_del($id = 0)
	{
		$this->db->delete('ci_cities', array('id' => $id));
		$this->session->set_flashdata('msg', 'City has been Deleted Successfully!');
		redirect(base_url('admin/location/city'));
	}

}

?>