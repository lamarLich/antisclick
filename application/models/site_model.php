<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Site_model extends CI_Model
{
    
    var $name;
    var $id_User;
    var $K_min;
    var $N_sec;
    
    function insert_site($name, $idUser,$K_min,$N_sec)
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
            'id_User' => $idUser,
            'K_min' => $K_min,
            'N_sec' => $N_sec
        ));
        return $this->db->insert_id();
    }

    function DeleteSite($idSite)
    {
        return $this->db->delete('site', array('id' => $idSite));
    }
    function DeleteSite_CitiesWhereIdSite($idSite)
    {
        return $this->db->delete('site_city', array('id_Site' => $idSite));
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
            /*$qGetQuery = "SELECT id FROM city WHERE name=?;";
            $res       = $this->db->query($qGetQuery, array(
                $value
            ));
            $data      = $res->result_array();
            if (count($data) == 0) {
                echo "<br>//////////////////<br> Don't know city: ".$value." <br>//////////////////<br>";
                return;
            }*/
            
            $this->db->insert('site_city', array(
                'id_Site' => $id_Site,
                'id_City' => $value
            ));
        }
    }
    function GetAllCities() {
        $query = $this->db->get('city');
        return $query->result_array();
    }
    function GetSitesWhereIdUser($IdUser)
    {
        $qGetQuery = "SELECT site.id, site.name, COUNT(ip.id) as count_badip "
        ."FROM site "
        ."INNER JOIN click ON click.id_Site = site.id "
        ."INNER JOIN ip ON click.`id_IP`=ip.id  AND ip.isBad=true WHERE site.`id_User` = ?";
        $res       = $this->db->query($qGetQuery, array(
            $IdUser
        ));
        $data      = $res->result_array();
        if (count($data) != 0) {
            return $data;
        } else
            array();
    }
}