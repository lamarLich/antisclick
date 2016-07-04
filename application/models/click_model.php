<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Click_model extends CI_Model {

	var $idIP;
	var $userAgent;
	var $width_screen;
	var $height_screen;
	var $city;
	var $region;
	var $country;
	var $platform;
	var $time_in;
	var $time_out=0;
	

	function insert_click($arr)
	{
		/*$this->$id_ip=			$arr['id_ip'];
		$this->$userAgent=		$arr['userAgent'];
		$this->$width_screen=	$arr['width_screen'];
		$this->$height_screen=	$arr['height_screen'];
		$this->$city=			$arr['city'];
		$this->$region=			$arr['region'];
		$this->$country=		$arr['country'];
		$this->$platform=		$arr['platform'];
		$this->$time_in=		$arr['time'];
		*/
		$data['id_IP']=			$arr['id_ip'];
		$data['userAgent']=		$arr['userAgent'];
		$data['width_screen']=	$arr['width'];
		$data['height_screen']=	$arr['height'];
		$data['city']=			$arr['city'];
		$data['region']=		$arr['region'];
		$data['country']=		$arr['country'];
		$data['platform']=		$arr['platform'];
		$data['time_in']=		time();
		
        $this->db->insert('Click', $data);
        $idClick=$this->db->insert_id();
        $this->session->set_userdata('id_Click', $idClick);
        return $idClick;
	}

	function IsFirstClick($ip)
	{
		$qGetQuery = "SELECT * FROM Click INNER JOIN IP ON Click.`id_IP`=IP.id AND IP.IP=?;";
		$res = $this->db->query($qGetQuery,array($ip));
		$data = $res->result_array();
		if (count($data) < 2) {
			echo "true";
			return true;
		}
			echo "false";
		return false;
	}

	function GetTimeLastVisit($ip)
	{
		$qGetQuery = "SELECT Click.id, time_in FROM Click INNER JOIN IP ON Click.`id_IP`=IP.id AND IP.IP=? ORDER BY Click.id DESC;";
		$res = $this->db->query($qGetQuery,array($ip));
		$data = $res->result_array();
		if (count($data) == 0) {
			return array();
		}
		return $data[0]['time_in'];
	}

	function IsBeUserAgent($userAgent)
	{
		$qGetQuery = "SELECT userAgent FROM Click WHERE userAgent=?;";
		$res = $this->db->query($qGetQuery,array($userAgent));
		$data = $res->result_array();
		if (count($data) == 0) {
			return false;
		}
		return true;
	}

	function AddTimeOut($time_out)
	{
		$data = array(
               'time_out' => $time_out
            );
	 $idClick=	$this->session->userdata('id_Click');
		$this->db->where('id', $idClick);
		$this->db->update('Click', $data);
	}
	
	
}