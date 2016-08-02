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

    function LoadHistory($ip)
    {
        $qGetQuery = "SELECT history FROM ip WHERE IP=?;";
        $res       = $this->db->query($qGetQuery, array(
            $ip
        ));
        $data      = $res->result_array();
        if (count($data) == 0) {
            return array();
        }
        return $data[0]['history'];
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
    function InsertHistory($ip, $history)
    {
        echo "<br>history= $history<br>";
        $data = array(
            'history' => $history
        );
        
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

        $hostname= gethostbyaddr($ip);
        $json = file_get_contents("http://api.2ip.com.ua/provider.json?ip=".$ip);
        $providerJSON = json_decode($json, true);
        $provider= $providerJSON["name_ripe"];
        $arr = array(
            'IP' => $ip,
            'provider'=> $provider,
            'hostname'=> $hostname
        );
        $this->db->insert('ip', $arr);
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
	
    function getStatBadIP($ip)
    {
        ////////////// Выгрузить hostname, provider, points, history + bad_clicks
        $qGetClick = "SELECT *,ip.hostname,ip.provider, click.id as id_Click FROM click INNER JOIN ip ON click.`id_IP`=ip.id AND ip.ip=?;";
        $res       = $this->db->query($qGetClick,array($ip));
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

// узнать провайдера и хостнэйм для всех ip (блочит api.2ip)
    function LoadAllProvider()
    {
        $qGetQuery = "SELECT * FROM ip WHERE provider IS NULL;";
        $res       = $this->db->query($qGetQuery);
        $data      = $res->result_array();
        if (count($data) == 0) {
            return array("Все пусто");
        }
        echo "<br>всего ".count($data)."<br>";
        $qUpdateQuery = "UPDATE ip SET provider=?, hostname=? WHERE id=?;";
        foreach ($data as $row) {
            $ip= $row['IP'];
            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => 'http://ip-whois.net/host_ip.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query(array("T1"=> $ip))
            ));
            $response = curl_exec($myCurl);
            curl_close($myCurl);
            $result = explode("<h2>", $response);
            //var_dump($result);
            $result = explode("</h2>", $result[1]);
            $result = explode(":", $result[0]);
            $hostname = substr($result[1],2);
            echo "<br>http://api.2ip.com.ua/provider.json?ip=".$ip;
            $json = file_get_contents("http://api.2ip.com.ua/provider.json?ip=".$ip);
            $providerJSON = json_decode($json, true);
            $provider= $providerJSON["name_ripe"];

            $res       = $this->db->query($qUpdateQuery,array(
                $provider, 
                $hostname,
                $row['id']
                ));
            $res->result_array();
        }
        $qGetQuery = "SELECT * FROM ip WHERE provider IS NULL;";
        $res       = $this->db->query($qGetQuery);
        if (count($data) == 0) {
            return array("Все пусто");
        }
        else
        {
            return $data;
        }

    }

// узнать провайдера и хостнэйм для 1 ip 
    function LoadProviderForCurrentIP($ip)
    {
            $myCurl = curl_init();
            curl_setopt_array($myCurl, array(
                CURLOPT_URL => 'http://ip-whois.net/host_ip.php',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query(array("T1"=> $ip))
            ));
            $response = curl_exec($myCurl);
            curl_close($myCurl);
            $result = explode("<h2>", $response);
            $result = explode("</h2>", $result[1]);
            $result = explode(":", $result[0]);
            $hostname = substr($result[1],2);
            $json = file_get_contents("http://api.2ip.com.ua/provider.json?ip=".$ip);
            $providerJSON = json_decode($json, true);
            $provider= $providerJSON["name_ripe"];
            if (!isset($provider) || empty($provider)) {
                $provider="undefined";
            }
            $data = array(
                "provider"=> $provider, 
                "hostname"=>$hostname
            );
            
            $this->db->where('IP', $ip);
            $this->db->update('ip', $data);
            return "ok";

    }
}