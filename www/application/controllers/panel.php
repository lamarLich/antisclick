<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Panel extends CI_Controller {

	public function index()
	{
		
		$data['title'] =  "Панель управления";
		$this->load->view('templates/header',$data);
		$this->load->view('panel');
		
		$this->load->view('templates/footer');
	}
	public function stat()
	{
		$data['title'] =  "Панель управления";
		$this->load->view('templates/header',$data);

		$data['arr']=array();
		$data['arra']=array();
		$this->load->model('ip_model'); // загрузка модели
     	$data['bad_IP'] = $this->ip_model->get_bad_ips();  
     	$data['all_IP'] = $this->ip_model->get_all_ips();  
     	$data['all_clicks'] = $this->ip_model->get_all_clicks();  
     	$data['clicks_bad_ip'] = $this->ip_model->get_clicks_where_bad_ip();  
     	$data['clicks_strange_ip'] = $this->ip_model->get_clicks_where_strange_ip(); 
     	$data['all_sites'] = $this->ip_model->get_all_sites(); 
		$this->load->view('panel_stat',$data);
		
		$this->load->view('templates/footer');
	}

	public function statyandex()
	{
		$data['title'] =  "Панель управления";
		$this->load->view('templates/header',$data);

		$data['arr']=array();
		$data['arra']=array();
		$this->load->model('ip_model'); // загрузка модели
     	$data['bad_IP'] = null;// $this->ip_model->get_bad_ips();  
     	$data['all_IP'] = null;//$this->ip_model->get_all_ips();  
     	$data['all_clicks'] = $this->ip_model->get_all_clicks();  
     	$data['clicks_bad_ip'] = $this->ip_model->get_clicks_where_bad_ip();  
     	$data['clicks_strange_ip'] = $this->ip_model->get_clicks_where_strange_ip(); 
     	$data['all_sites'] = $this->ip_model->get_all_sites(); 

     	foreach ($data['all_clicks'] as $key => $value) {
     		if($value['utm'] != "yandex")
     		{
     			unset($data['all_clicks'][$key]);
     		}
     	}
     	foreach ($data['clicks_bad_ip'] as $key => $value) {
     		if($value['utm'] != "yandex")
     		{
     			unset($data['clicks_bad_ip'][$key]);
     		}
     	}
     	foreach ($data['clicks_strange_ip'] as $key => $value) {
     		if($value['utm'] != "yandex")
     		{
     			unset($data['clicks_strange_ip'][$key]);
     		}
     	}
		$this->load->view('panel_stat',$data);
		
		$this->load->view('templates/footer');
	}

	public function Regions()
	{
		$data['title'] =  "Управление целевыми регионами";
		$this->load->view('templates/header',$data);

		$this->load->model('site_model'); // загрузка модели
     	$data['sites'] = $this->site_model->GetAllSites(); 
     	$data['cities'] = $this->site_model->GetAllCities();
		$this->load->view('panel_regions',$data);
     	
		$this->load->view('templates/footer');
	}
	public function GetCitysFromSiteID()
	{
		$this->load->model('site_model');
		$arr = $this->site_model->GetCitysFromSiteID($_GET['id']);
		echo json_encode($arr);
		/*foreach ($arr as $val) {
			echo $val['name'] . "&nbsp;";
		}*/
		exit;
	}
	public function AddRegion()
	{
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
  		var_dump($arr);

		$this->load->model('site_model'); // загрузка модели
		//$id_Site=$this->site_model->GetID_site($arr["name"]);
     	$data['sites'] = $this->site_model->AddCities($arr["name"], $arr["cities"]);  
     	echo "<br><br>all OK";
	}
	public function GetStatBadIP()
	{
		$ip;

		if (!isset($_GET['ip']) && !isset($_POST['ip'])) {
			echo "error: empty ip";
  			die;
		}
		if (isset($_POST['ip'])) {
			$ip = $_POST['ip'];
		}
		elseif (isset($_GET['ip'])) {
		 	$ip = $_GET['ip'];
		}

		$this->load->model('ip_model'); // загрузка модели
		$data= $this->ip_model->getStatBadIP($ip);
		if ($data[0]['hostname'] == null) {
		 	$data[0]['hostname']= "Не известен";
		} 
		if ($data[0]['provider'] == null) {
		 	$data[0]['provider']= "Не известен";
		} 
		echo "
		<table class=\"simple-little-table\" cellspacing='0'>
			<tr>
				<td>hostname:</td>
				<td>".$data[0]['hostname']."</td>
				<td>Провайдер:</td>
				<td>".$data[0]['provider']."</td>
				<td>История:</td>
				<td>".$data[0]['history']."</td>
			</tr>
			<tr>
				<th>id</th>
				<th>Город</th>
				<th>Регион</th>
				<th>points</th>
				<th>время всего</th>
				<th>дата входа</th>
			</tr>";
		foreach ($data as $value) {
			echo "<tr>";
				echo "<td>";
				echo $value["id_Click"];
				echo "</td>";

				echo "<td>";
				echo $value["city"];
				echo "</td>";

				echo "<td>";
				echo $value["region"];
				echo "</td>";

				echo "<td>";
				echo $value["points"];
				echo "</td>";

				echo "<td>";
				echo $value["time_all"];
				echo "</td>";

				echo "<td>";
				echo $value["time_in"];
				echo "</td>";

			echo "</tr>";
		}
		echo "</table>";
		//echo json_encode($data);
		/////////////// Выгрузить hostname,provider,points, history + bad_clicks
	}
	public function LoadAllProvider()
	{
		$this->load->model('ip_model');
     	$data = $this->ip_model->LoadAllProvider();  
     	var_dump($data);
	}

	// узнать провайдера и хостнэйм для 1 ip 
	public function LoadProviderForCurrentIP()
	{
		$ip;

		if (!isset($_GET['ip']) && !isset($_POST['ip'])) {
			echo "error: empty ip";
  			die;
		}
		if (isset($_POST['ip'])) {
			$ip = $_POST['ip'];
		}
		elseif (isset($_GET['ip'])) {
		 	$ip = $_GET['ip'];
		}
		$this->load->model('ip_model');
     	echo $this->ip_model->LoadProviderForCurrentIP($ip);  
	}
}