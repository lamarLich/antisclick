<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site_model extends CI_Model
{
    
    var $name;
    var $id_User;
    
    function insert_site($name, $idUser)
    {
        $qGetQuery = "SELECT id FROM site WHERE name=?;";
        $res       = $this->db->query($qGetQuery, array(
            $name
        ));
        $data      = $res->result_array();
        if (count($data) != 0) {
            $this->session->set_userdata('id_Site', $data[0]['id']);
            return $data[0]['id'];
        }
        
        $this->db->insert('site', array(
            'name' => $name,
            'id_User' => $idUser
        ));
        return $this->db->insert_id();
    }
    
    function GetID_site($name)
    {
        $qGetQuery = "SELECT id FROM site WHERE name=?;";
        $res       = $this->db->query($qGetQuery, array(
            $name
        ));
        $data      = $res->result_array();
        if (count($data) != 0) {
            $this->session->set_userdata('id_Site', $data[0]['id']);
            return $data[0]['id'];
        } else
            return -1;
    }
}