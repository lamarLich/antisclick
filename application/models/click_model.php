<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Click_model extends CI_Model
{
    
    var $idIP;
    var $userAgent;
    var $width_screen;
    var $height_screen;
    var $city;
    var $region;
    var $country;
    var $platform;
    var $time_in;
    var $time_out = 0;
    var $id_Site;
    
    
    function insert_click($arr)
    {
        $data['id_IP']         = $arr['id_ip'];
        $data['userAgent']     = $arr['userAgent'];
        $data['width_screen']  = $arr['width'];
        $data['height_screen'] = $arr['height'];
        $data['city']          = $arr['city'];
        $data['region']        = $arr['region'];
        $data['country']       = $arr['country'];
        $data['platform']      = $arr['platform'];
        $data['time_in']       = time();//date('Y-m-d H:i:s', time());
        $data['time_out']      = time();
        $data['id_Site']       = $arr['id_Site'];
        
        $this->db->insert('click', $data);
        $idClick = $this->db->insert_id();
        $this->session->set_userdata('id_Click', $idClick);
        return $idClick;
    }
    function GetClick()
    {
        $idClick   = $this->session->userdata('id_Click');
        $qGetQuery = "SELECT * FROM click WHERE id = ?;";
        $res       = $this->db->query($qGetQuery, array(
            $idClick
        ));
        $data      = $res->result_array();
        if (count($data) == 0) {
            return array();
        }
        /*
        $data[0]['time_in']     = date('Y-m-d H:i:s', $data[0]['time_in']);
        $data[0]['time_out']    = date('Y-m-d H:i:s', $data[0]['time_out']);

        */
        return $data[0];
    }
    
    function IsFirstClick($ip)
    {
        $qGetQuery = "SELECT * FROM click INNER JOIN ip ON click.`id_IP`=ip.id AND ip.IP=?;";
        $res       = $this->db->query($qGetQuery, array(
            $ip
        ));
        $data      = $res->result_array();
        if (count($data) < 2) {
            return true;
        }
        return false;
    }
    
    function GetTimeLastVisit($ip)
    {
        $qGetQuery = "SELECT click.id, time_in FROM click INNER JOIN ip ON click.`id_IP`=ip.id AND ip.IP=? ORDER BY click.id DESC;";
        $res       = $this->db->query($qGetQuery, array(
            $ip
        ));
        $data      = $res->result_array();
        if (count($data) == 0) {
            return array();
        }
        return $data[0]['time_in'];
    }
    
    function IsBeUserAgent($userAgent)
    {
        $qGetQuery = "SELECT userAgent FROM click WHERE userAgent=?;";
        $res       = $this->db->query($qGetQuery, array(
            $userAgent
        ));
        $data      = $res->result_array();
        if (count($data) == 0) {
            return false;
        }
        return true;
    }
    
    function AddTimeOut($time_out)
    {
        $idClick = $this->session->userdata('id_Click');
        echo "idClick = " . $idClick;
        if (!isset($idClick)) {
            echo "empty session";
        }
        $data = array(
            'time_out' => time()//date('Y-m-d H:i:s', time())
        );
        
        $this->db->where('id', $idClick);
        $this->db->update('click', $data);
        $this->session->unset_userdata('id_Click');
    }

    function AddTimeOutIteration()
    {
        $idClick = $this->session->userdata('id_Click');
        if (!isset($idClick)) {
            return false;
        }
        $data = array(
            'time_out' =>  time()//date('Y-m-d H:i:s', time())
        );
        
        $this->db->where('id', $idClick);
        $this->db->update('click', $data);
        return true;
        //$this->session->unset_userdata('id_Click');
    }
    function AddTimeOutIterationWhereIP($ip)
    {
        $qGetQuery = "SELECT click.id FROM click INNER JOIN ip ON click.`id_IP`=ip.id AND ip.IP=? ORDER BY click.id DESC;";
        $res       = $this->db->query($qGetQuery, array(
            $ip
        ));
        $data      = $res->result_array();
        if (count($data) == 0) {
            return array();
        }
        $idClick   = $data[0]["id"];

        $data = array(
            'time_out' =>  time()
        );
        
        $this->db->where('id', $idClick);
        $this->db->update('click', $data);
        //$this->session->unset_userdata('id_Click');
    }
    function GetLastClickWhereIP($ip)
    {
        $qGetQuery = "SELECT click.id FROM click INNER JOIN ip ON click.`id_IP`=ip.id AND ip.IP=? ORDER BY click.id DESC;";
        $res       = $this->db->query($qGetQuery, array(
            $ip
        ));
        $data      = $res->result_array();
        if (count($data) == 0) {
            return array();
        }
        $idClick   = $data[1]["id"];
        $qGetQuery = "SELECT * FROM click WHERE id = ?;";
        $res       = $this->db->query($qGetQuery, array(
            $idClick
        ));
        $data      = $res->result_array();
        if (count($data) == 0) {
            return array();
        }
        return $data[0];
    }
}