<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	function insert_user($arr)
	{
		
		
       return $this->db->insert('User', $this);
	}
}