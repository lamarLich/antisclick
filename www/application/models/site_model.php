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
        $qGetQuery = "SELECT site.id, site.name,ip.isBad, ip.id as count_badip "
        ."FROM site "
        ."INNER JOIN click ON click.id_Site = site.id "
        ."INNER JOIN ip ON click.`id_IP`=ip.id  WHERE site.`id_User` = ?";
        $res       = $this->db->query($qGetQuery, array(
            $IdUser
        ));
        $data      = $res->result_array();
        if (count($data) != 0) {
            $result=array();
            $id = $data[0]['id'];
            $sitename=$data[0]['name'];
            $i=0;
            foreach ($data as $key => $row) {
                if($row['name']!=$sitename)
                {
                    $result[] = array(
                    'id'=>$id,
                    'name'=>$sitename,
                    'count_badip'=> $i
                    );
                    $sitename=$row['name'];
                    $id = $row['id'];
                    $i=0;
                }
                else{
                    if ($row['isBad']==1) {
                        $i++;
                    }
                }
            }
            $result[] = array(
                    'id'=>$data[count($data)-1]['id'],
                    'name'=>$data[count($data)-1]['name'],
                    'count_badip'=> $i
                    );
            
            return $result;
        } else
            array();
    }

    function GetAllIPWhereSite($idUser, $siteId)
    {
        $query = $this->db->get('user_ip');
        $arr = $query->result_array();

        $qGetQuery = "SELECT ip.id, ip.IP"
        ." FROM ip"
        ." INNER JOIN click ON click.`id_IP` = ip.id"
        ." INNER JOIN site ON click.`id_Site` = site.id"
        ." WHERE site.id= ?"
        ." AND ip.isBad = TRUE;";
        $res       = $this->db->query($qGetQuery, array(
            $siteId
        ));
        $data      = $res->result_array();
        if (count($data) != 0) {
            foreach ($data as &$row) {
                if (in_array($arr, array('id_ip'=> $row['id'], 'id_user' =>$idUser ))) {
                   $row['flag']=true;
                }
                else{
                    $row['flag']=false;
                }
            }
            return $data;
        }
        else 
            return array();
    }
    function AddUser_ip($idUser, $arrIP)
    {
        $query = $this->db->get('user_ip');
        $data = $query->result_array();

        foreach ($arrIP as $value) {
            $isNew=true;
            if (in_array($data, array('id_ip'=> $value, 'id_user' =>$idUser ))) {
                   $isNew=false;
            }
            if ($isNew==true) {
                $this->db->insert('user_ip', array(
                'id_ip' => $idUser,
                'id_user' => $value
                ));
            }
        }
    }
}