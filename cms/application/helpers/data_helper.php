<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	// -----------------------------------------------------------------------------
    function getGroupyName($id){
    	
    	$ci = & get_instance();
    	return $ci->db->get_where('ci_user_groups', array('id' => $id))->row_array()['group_name'];
    }

    // -----------------------------------------------------------------------------
    // Make Slug Function    
    if (!function_exists('make_slug'))
    {
        function make_slug($string)
        {
            $lower_case_string = strtolower($string);
            $string1 = preg_replace('/[^a-zA-Z0-9 ]/s', '', $lower_case_string);
            return strtolower(preg_replace('/\s+/', '-', $string1));        
        }
    }

    // -----------------------------------------------------------------------------
    // Get General Setting
    if (!function_exists('get_general_settings')) {
        function get_general_settings()
        {
            $ci =& get_instance();
            $ci->load->model('admin/setting_model');
            return $ci->setting_model->get_general_settings();
        }
    }

    // -----------------------------------------------------------------------------
    // Get country list
    function get_country_list()
    {
        $ci = & get_instance();
        return $ci->db->get('ci_countries')->result_array();
    }

    // -----------------------------------------------------------------------------
    // Get country name by ID
    function get_country_name($id)
    {
        $ci = & get_instance();
        return $ci->db->get_where('ci_countries', array('id' => $id))->row_array()['name'];
    }

    // -----------------------------------------------------------------------------
    // Get City ID by Name
    function get_country_id($title)
    {
        $ci = & get_instance();
        return $ci->db->get_where('ci_countries', array('slug' => $title))->row_array()['id'];
    }

    // -----------------------------------------------------------------------------
    // Get country slug
    function get_country_slug($id)
    {
        $ci = & get_instance();
        return $ci->db->get_where('ci_countries', array('id' => $id))->row_array()['slug'];
    }

    // -----------------------------------------------------------------------------
    // Get country's states
    function get_country_states($country_id)
    {
        $ci = & get_instance();
        return $ci->db->select('*')->where('country_id',$country_id)->get('ci_states')->result_array();
    }

    // -----------------------------------------------------------------------------
    // Get state's cities
    function get_state_cities($state_id)
    {
        $ci = & get_instance();
        return $ci->db->select('*')->where('state_id',$state_id)->get('ci_cities')->result_array();
    }

    // Get state name by ID
    function get_state_name($id)
    {
        $ci = & get_instance();
        return $ci->db->get_where('ci_states', array('id' => $id))->row_array()['name'];
    }

    // -----------------------------------------------------------------------------
    // Get city name by ID
    function get_city_name($id)
    {
        $ci = & get_instance();
        return $ci->db->get_where('ci_cities', array('id' => $id))->row_array()['name'];
    }

    // -----------------------------------------------------------------------------
    // Get city ID by title
    function get_city_slug($id)
    {
        $ci = & get_instance();
        return $ci->db->get_where('ci_cities', array('id' => $id))->row_array()['slug'];
    }

?>    