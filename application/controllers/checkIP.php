<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class CheckIP extends CI_Controller {

	
	public function index()
	{
		$ip=$_SERVER['REMOTE_ADDR'];
		$json;

		if (!isset($_GET['json']) && !isset($_POST['json'])) {
			echo "error: empty json";
  			die;
		}
		if (isset($_POST['json'])) {
			$json = $_POST['json'];
		}
		elseif (isset($_GET['json'])) {
		 	$json = $_GET['json'];
		}
		
		$arr = json_decode($json, true);

		echo "ip = ".$ip."<br>";
  		var_dump($arr);
  		
  		if(isset($_SERVER['HTTP_REFERER']))
  		{
			$from =$_SERVER['HTTP_REFERER'];
			$arr['country'] = $from;
  		}
  		if ($arr['region']== null) {
  			$arr['region'] = "not_UTM_SOURCE";
  		}
		$this->load->model('ip_model'); // загрузка модели
		$this->load->model('click_model'); // загрузка модели
		$this->load->model('user_model'); // загрузка модели

		$idIP=$this->ip_model->insert_ip($ip);
		echo "<br> insert idIP = ".$idIP;
		$arr['id_ip']=$idIP;
		$idClick= $this->click_model->insert_click($arr);
		echo "<br> insert idClick = ".$idClick;


	}

	public function close()
	{
		$ip=$_SERVER['REMOTE_ADDR'];
		
		///////////////////////////////////////////////////////
		$this->load->model('ip_model'); // загрузка модели
		$this->load->model('click_model'); // загрузка модели
		$this->load->model('user_model'); // загрузка модели
		/*//
		$idIP=$this->ip_model->insert_ip($ip);
		echo "<br> insert IP = ".$idIP;
		$arr['id_ip'] = $idIP;
		$arr['time_in'] = date ("y.m.d H:m:s");
		//$idClick= $this->click_model->insert_click($arr);
		//echo "<br> insert Click = ".$idClick;
		echo "<br> lastVisit Click = "; 
		var_dump($this->click_model->GetTimeLastVisit($ip));
		//*/

		//$id_user =	$arr['region'];
		$arr = $this->click_model->GetClick();
		$points=0;
		$ourRegion= "Омск";//"Омская область";  //$this->user_model->Get_Regions($id_user);// TEST /////////////////////////////////////////////////////
		$clientRegion= $arr['city'];
		$isFirstClick= $this->click_model->IsFirstClick($ip); 
		$K_min= 2;//$this->user_model->Get_K_min($id_user); // TEST /////////////////////////////////////////////////////
		$N_sec= 20;//$this->user_model->Get_N_sec($id_user); // TEST /////////////////////////////////////////////////////
		$oldtime=$this->click_model->GetTimeLastVisit($ip);
		$timeOnSiteInSec = time()-strtotime($oldtime);
		$userAgent= $arr['userAgent'];
		if(!$isFirstClick)
		{
			echo "<br> it NOT first click";
			$points=$this->ip_model->LoadPoints($ip);
			echo "<br> points=$points";
			$lastTimeInMinutes=$timeOnSiteInSec/60;
			echo "<br> lastTimeInMinutes=$lastTimeInMinutes"
			."<br>timeOnSiteInSec=$timeOnSiteInSec;";
			
			if($lastTimeInMinutes > $K_min)
			{
				if($timeOnSiteInSec > $N_sec)
				{
					if ($clientRegion == $ourRegion)
					{
						$this->click_model->AddTimeOut(time());
						return;
					}
					else
					{
						$points++;
					}
				}
				else
				{
					if ($clientRegion == $ourRegion)
					{
						$points++;
					}
					else
					{
						$points+=2;
					}
				}
			}
			else
			{
				if($timeOnSiteInSec > $N_sec)
				{
					if ($this->click_model->IsBeUserAgent($userAgent))
					{
						if ($clientRegion == $ourRegion)
						{
							$points+=3;
						}
						else
						{
							$points=999;
						}
					}
					else
					{
						if ($clientRegion == $ourRegion)
						{
							$points++;
						}
						else
						{
							$points+=3;
						}
					}
				}
				else
				{
					if ($this->click_model->IsBeUserAgent($userAgent))
					{
						$points=999;						
					}
					else
					{
						if ($clientRegion == $ourRegion)
						{
							$points+=4;
						}
						else
						{
							$points=999;
						}
					}
				}
			}
		}
		else
		{
			if($timeOnSiteInSec > $N_sec)
			{
				if ($clientRegion == $ourRegion)
				{
					$this->ip_model->insert_ip($ip);
					return;
				}
				else
				{
					$points++;
				}
			}
			else
			{
				if ($clientRegion == $ourRegion)
				{
					$points++;
				}
				else
				{
					$points+=2;
				}
			}
			$this->ip_model->insert_ip($ip);
		}
		$this->ip_model->InsertPoints($ip,$points);
		$this->click_model->AddTimeOut(time());
		/////////////////////////////////////////////////////*/
	}
}
