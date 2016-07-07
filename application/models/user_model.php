<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model
{
    
    function insert_user($arr)
    {
        $data['login']    = $arr['login'];
        $data['password'] = $arr['password'];
        $data['K_min']    = $arr['K_min'];
        $data['N_sec']    = $arr['N_sec'];
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }
}