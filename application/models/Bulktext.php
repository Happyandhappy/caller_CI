<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bulktext extends CI_Model {
	
	function __construct()
    {
        parent::__construct();
    }

    function add_group($number_id,$name,$cid) 
    {
    	$data = array(
	        'client_id' => $cid,
	        'number_id' => $number_id,
	        'name' => $name
		);

		$this->db->insert('ct_bulktext_group', $data);

    }

    function update_count($bid,$newsmsc) 
    {
    	$data = array(
	        'sent_count' => $newsmsc
		);
		$this->db->where('id',$bid)->update('ct_bulktext_list', $data);

    }
    function edit_group($bid,$name,$cid) 
    {
    	$data = array(
	        'name' => $name,
		);
		$this->db->where('id',$bid)->where('client_id',$cid)->update('ct_bulktext_group', $data);

    }
    function delete_group($bid)
    {
		$this->db->where('id', $bid);
		$this->db->delete('ct_bulktext_group');
		return true;
    }

    function get_group($bid)
    {
		return $this->db
		->where('id', $bid)
		->get('ct_bulktext_group')
		->row(); 
    }

    function get_group_count($gropid,$number_id) {
		return $this->db
		->where('number_id',$number_id)
		->from('ct_bulktext_group')
		->count_all_results();
    }

    function get_group_list($number_id) {
		return $this->db
		->where('number_id',$number_id)
		->get('ct_bulktext_group')
		->result();
    }

    /* group items */

    function add_item($gropid,$cid, $substo_id, $number, $first_name, $last_name, $optin=1, $moreinfo = array())
    {
    	$data = array(
	        'client_id' => $cid,
	        'group_id' => $gropid,
	        'number_id' => $substo_id,
	        'user_number' => $number,
	        'optout' => 0,
	        'user_fname' => $first_name,
	        'user_lname' => $last_name,
	        'user_moreinfo' => json_encode($moreinfo),
	        'added' => time()
		);

		$this->db->insert('ct_bulktext_list', $data);
    }

    function optout_vialink($gropid,$linkarr)
    {

    	$data = array('optout' => 1);
		$this->db->where('group_id',$gropid)->where('added',$linkarr)->update('ct_bulktext_list', $data);
    
    }
    
    function edit_item($gropid,$rid, $substo_id, $number, $first_name, $last_name,  $optin=null, $moreinfo = array())
    {
    	$data = array(
	        'number_id' => $substo_id,
	        'group_id' => $gropid,
	        'user_number' => $number,
	        'user_fname' => $first_name,
	        'user_lname' => $last_name
		);
		if(!empty($moreinfo)) {
			$data['user_moreinfo'] = json_encode($moreinfo);
		}

		$this->db->where('id',$rid)->update('ct_bulktext_list', $data);
    }

    function delete_item($bid)
    {
		$this->db->where('id', $bid);
		$this->db->delete('ct_bulktext_list');
		return true;
    }

    function get_item($bid)
    {
		return $this->db
		->where('id', $bid)
		->get('ct_bulktext_list')
		->row(); 
    } 

    function is_in_list($gropid,$number_id,$number) {
		return $this->db
		->where('user_number',$number)
		->where('group_id',$gropid)
		->where('number_id',$number_id)
		->from('ct_bulktext_list')
		->count_all_results();

    }

    function get_list_count($gropid,$number_id) {
		return $this->db
		->where('group_id',$gropid)
		->where('number_id',$number_id)
		->from('ct_bulktext_list')
		->count_all_results();
    }

    function get_list($gropid,$number_id) {
		return $this->db
		->where('group_id',$gropid)
		->where('number_id',$number_id)
		->get('ct_bulktext_list')
		->result();
    }

    function get_list_optinonly($gropid,$number_id='') {
		return $this->db
		->where('optout',0)
		->where('group_id',$gropid)
		->get('ct_bulktext_list')
		->result();
    }
}