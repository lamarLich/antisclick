<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ip_model extends CI_Model {

	var $IP;
	var $isBad=false;
	var $points=0;
	
	function LoadPoints($ip)
	{
		$qGetQuery = "SELECT points FROM IP WHERE IP=?;";
		$res = $this->db->query($qGetQuery,array($ip));
		$data = $res->result_array();
		if (count($data) == 0) {
			return array();
		}
		return $data[0]['points'];
	}

	function InsertPoints($ip,$points)
	{
		$data = array(
               'points' => $points
            );
		if ($points > 5) {
			$data['isBad']=true;
		}
		
		$this->db->where('IP', $ip);
		$this->db->update('IP', $data);
	}



	function insert_ip($ip)
	{
		$qGetQuery = "SELECT id FROM IP WHERE IP=?;";
		$res = $this->db->query($qGetQuery,array($ip));
		$data = $res->result_array();
		if (count($data) != 0) {
			return $data[0]['id'];
		}
        $this->db->insert('IP',  array('IP' => $ip ));
        return $this->db->insert_id();
	}
	
    function get_bad_ips()
    {
		$this->db->where('isBad',true);  
        $query = $this->db->get('IP'); 
        return $query->result_array();  
    }
    function get_all_ips()
    {
        $query = $this->db->get('IP'); 
        return $query->result_array();  
    }
    function get_all_clicks()
    {
        $query = $this->db->get('Click'); 
        return $query->result_array();  
    }
    function get_clicks_where_bad_ip()
    {
        $qGetClick = "SELECT * FROM Click INNER JOIN IP ON Click.`id_IP`=IP.id  AND IP.isBad=true;";
		$res = $this->db->query($qGetClick);
		$ClickData = $res->result_array();
		if (count($ClickData) == 0) {
			return array();
		}
		return $ClickData;
    }
    function get_clicks_where_strange_ip()
    {
        $qGetClick = "SELECT * FROM Click INNER JOIN IP ON Click.`id_IP`=IP.id AND IP.points>0;";
		$res = $this->db->query($qGetClick);
		$ClickData = $res->result_array();
		if (count($ClickData) == 0) {
			return array();
		}
		return $ClickData;
    }
	
	
}