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

    function GetAllSites()
    {
        $query = $this->db->get('site');
        return $query->result_array();
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

    function GetCitysFromSiteID($id)
    {
        $qGetQuery = "SELECT city.name "
        ."FROM city "
        ."INNER JOIN site_city    ON city.id = site_city.id_City "
        ."INNER JOIN site         ON site_city.id_Site = site.id "
        ."WHERE site.id = ?;";
        $res       = $this->db->query($qGetQuery, array(
            $id
        ));
        $data      = $res->result_array();
        if (count($data) != 0) {
            return $data;
        } else
            array();
    }
    function AddCities($id_Site, $arrCities)
    {
        foreach ($arrCities as $key => $value) {
            $qGetQuery = "SELECT id FROM city WHERE name=?;";
            $res       = $this->db->query($qGetQuery, array(
                $value
            ));
            $data      = $res->result_array();
            if (count($data) == 0) {
                echo "<br>//////////////////<br> Don't know city: ".$value." <br>//////////////////<br>";
                return;
            }
            
            $this->db->insert('site_city', array(
                'id_Site' => $id_Site,
                'id_City' => $data[0]["id"]
            ));
        }
    }
}