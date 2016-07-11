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
  		
		$this->load->model('ip_model'); // загрузка модели
		$this->load->model('click_model'); // загрузка модели
		$this->load->model('user_model'); // загрузка модели
		$this->load->model('site_model'); // загрузка модели

  		if(isset($_SERVER['HTTP_REFERER']))
  		{
			$from =$_SERVER['HTTP_REFERER'];
			$from = explode("/", $from)[2];
			echo "<br>HTTP_REFERER = ".$from.";<br>";

			$data['login']=			"test";
			$data['password']=		"test";
			$data['K_min']=			2;
			$data['N_sec']=			20;
			$idUser = $this->user_model->insert_user($data);
			$arr['id_Site'] = $this->site_model->insert_site($from,$idUser);
  		}
  		else{
  			echo "empty HTTP_REFERER";
  			die;
  		}
  		
  		if ((strpos($_SERVER['HTTP_USER_AGENT'],"Googlebot") !== false) 
			|| (strpos($_SERVER['HTTP_USER_AGENT'],"AdsBot-Google") !== false)) {
  			return;
  		}
  		
		$idIP=$this->ip_model->insert_ip($ip);
		$arr['id_ip']=$idIP;
		$idClick= $this->click_model->insert_click($arr);
		if($this->click_model->IsFirstClick($ip) ==true)
		{
			return;
		}	

		$arr = $this->click_model->GetLastClickWhereIP($ip);
		$points=0;
		$history;
		$ourRegion= $this->site_model->GetCitysFromSiteID($arr['id_Site']);//"Омск";//"Омская область";  //$this->user_model->Get_Regions($id_user);// TEST /////////////////////////////////////////////////////
		$clientRegion= $arr['city'];
		$isFirstClick= false;//$this->click_model->IsFirstClick($ip); 
		$K_min= 2;//$this->user_model->Get_K_min($id_user); // TEST /////////////////////////////////////////////////////
		$N_sec= 20;//$this->user_model->Get_N_sec($id_user); // TEST /////////////////////////////////////////////////////
		$oldtime=$this->click_model->GetTimeLastVisit($ip);
		$timeOnSiteInSec = time()-$oldtime;
		$userAgent= $arr['userAgent'];
		if($isFirstClick==false)
		{
			echo "<br> it NOT first click";
			$points=$this->ip_model->LoadPoints($ip);
			$history=$this->ip_model->LoadHistory($ip);
			echo "<br> points=$points";
			$lastTimeInMinutes=$timeOnSiteInSec/60;
			echo "<br> lastTimeInMinutes=$lastTimeInMinutes"
			."<br>timeOnSiteInSec=$timeOnSiteInSec;";
			
			if($lastTimeInMinutes > $K_min)
			{
				if($timeOnSiteInSec > $N_sec)
				{
					if (in_array($clientRegion, $ourRegion))
					{
						$history=$history."<br>(5) N&gt;min &gt;sec city=Y good";
						$this->ip_model->InsertHistory($ip,$history);
						//$this->click_model->AddTimeOut(time());
						return;
					}
					else
					{
						$history=$history."<br>(6) N&gt;min &gt;sec city=N +1";
						$points++;
					}
				}
				else
				{
					if (in_array($clientRegion, $ourRegion))
					{
						$history=$history."<br>(7) N&gt;min &lt;sec city=Y +1";
						$points++;
					}
					else
					{
						$history=$history."<br>(8) N&gt;min &lt;sec city=N +2";
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
						if (in_array($clientRegion, $ourRegion))
						{
							$history=$history."<br>(9) N&lt;min &gt;sec UA=Y city=Y +3";
							$points+=3;
						}
						else
						{
							$history=$history."<br>(10) N&lt;min &gt;sec UA=Y city=N BAD";
							$points=999;
						}
					}
					else
					{
						if (in_array($clientRegion, $ourRegion))
						{
							$history=$history."<br>(11) N&lt;min &gt;sec UA=N city=Y +1";
							$points++;
						}
						else
						{
							$history=$history."<br>(12) N&lt;min &gt;sec UA=N city=N +3";
							$points+=3;
						}
					}
				}
				else
				{
					if ($this->click_model->IsBeUserAgent($userAgent))
					{
						$history=$history."<br>(13) N&lt;min &lt;sec UA=Y BAD";
						$points=999;						
					}
					else
					{
						if (in_array($clientRegion, $ourRegion))
						{
							$history=$history."<br>(14) N&lt;min &lt;sec UA=N city=Y +4";
							$points+=4;
						}
						else
						{
							$history=$history."<br>(15) N&lt;min &lt;sec UA=N city=N BAD";
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
				if (in_array($clientRegion, $ourRegion))
				{
					$history=$history."<br>(1) Y&gt;sec city=Y GOOD";
					$this->ip_model->insert_ip($ip);
					$this->ip_model->InsertHistory($ip,$history);
					return;
				}
				else
				{
					$history=$history."<br>(2) Y&gt;sec city=N +1";
					$points++;
				}
			}
			else
			{
				if (in_array($clientRegion, $ourRegion))
				{
					$history=$history."<br>(3) Y&lt;sec city=Y +1";
					$points++;
				}
				else
				{
					$history=$history."<br>(4) Y&lt;sec city=N +2";
					$points+=2;
				}
			}
			$this->ip_model->insert_ip($ip);
		}
		$this->ip_model->InsertPoints($ip,$points);
		$this->ip_model->InsertHistory($ip,$history);

	}

	public function stillhere()
	{
		$ip=$_SERVER['REMOTE_ADDR'];
		$this->load->model('click_model'); // загрузка модели

		$result = $this->click_model->AddTimeOutIteration(); 
		if ($result == false) {
			$this->click_model->AddTimeOutIterationWhereIP($ip);
		}
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
