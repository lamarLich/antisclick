<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ip_model extends CI_Model
{
    
    var $IP;
    var $isBad = false;
    var $points = 0;
    
    function LoadPoints($ip)
    {
        $qGetQuery = "SELECT points FROM ip WHERE IP=?;";
        $res       = $this->db->query($qGetQuery, array(
            $ip
        ));
        $data      = $res->result_array();
        if (count($data) == 0) {
            return array();
        }
        return $data[0]['points'];
    }
    
    function InsertPoints($ip, $points)
    {
        $data = array(
            'points' => $points
        );
        if ($points > 5) {
            $data['isBad'] = true;
        }
        
        $this->db->where('IP', $ip);
        $this->db->update('ip', $data);
    }
    
    
    
    function insert_ip($ip)
    {
        $qGetQuery = "SELECT id FROM ip WHERE IP=?;";
        $res       = $this->db->query($qGetQuery, array(
            $ip
        ));
        $data      = $res->result_array();
        if (count($data) != 0) {
            return $data[0]['id'];
        }
        $this->db->insert('ip', array(
            'IP' => $ip
        ));
        return $this->db->insert_id();
    }
    
    function get_bad_ips()
    {
        $this->db->where('isBad', true);
        $query = $this->db->get('ip');
        return $query->result_array();
    }
    function get_all_ips()
    {
        $query = $this->db->get('ip');
        return $query->result_array();
    }
    function get_all_clicks()
    {
        $qGetClick = "SELECT *,click.id as id_Click FROM click INNER JOIN ip ON click.`id_IP`=ip.id INNER JOIN site ON click.`id_Site`=site.id;";
        $res       = $this->db->query($qGetClick);
        $data = $res->result_array();
        if (count($data) == 0) {
            return array();
        }
        foreach ($data as &$value) {
            $sec = $value['time_out']-$value['time_in'];
            $min =$sec/60;
            $value['time_all']    =  (integer)$min.":".$sec%60;
            $value['time_in']     = date('Y-m-d H:i:s', $value['time_in']);
            $value['time_out']    = date('Y-m-d H:i:s', $value['time_out']);
        }
        return $data;
    }
    function get_clicks_where_bad_ip()
    {
        $qGetClick = "SELECT *,click.id as id_Click FROM click INNER JOIN ip ON click.`id_IP`=ip.id  AND ip.isBad=true INNER JOIN site ON click.`id_Site`=site.id;";
        $res       = $this->db->query($qGetClick);
        $data = $res->result_array();
        if (count($data) == 0) {
            return array();
        }
        foreach ($data as &$value) {
            $sec = $value['time_out']-$value['time_in'];
            $min =$sec/60;
            $value['time_all']    =  (integer)$min.":".$sec%60;
            $value['time_in']     = date('Y-m-d H:i:s', $value['time_in']);
            $value['time_out']    = date('Y-m-d H:i:s', $value['time_out']);
        }
        return $data;
    }
    function get_clicks_where_strange_ip()
    {
        $qGetClick = "SELECT *,click.id as id_Click FROM click INNER JOIN ip ON click.`id_IP`=ip.id AND ip.points>0 INNER JOIN site ON click.`id_Site`=site.id;";
        $res       = $this->db->query($qGetClick);
        $data = $res->result_array();
        if (count($data) == 0) {
            return array();
        }
        foreach ($data as &$value) {
            $sec = $value['time_out']-$value['time_in'];
            $min =$sec/60;
            $value['time_all']    =  (integer)$min.":".$sec%60;
            $value['time_in']     = date('Y-m-d H:i:s', $value['time_in']);
            $value['time_out']    = date('Y-m-d H:i:s', $value['time_out']);
        }
        return $data;
    }

	function get_all_sites()
	{
		$qGetSite = "SELECT * FROM site";
		$res = $this->db->query($qGetSite);
		$SiteData = $res->result_array();
		if (count($SiteData) == 0) {
			return array();
		}
		return $SiteData;
	}
	

}