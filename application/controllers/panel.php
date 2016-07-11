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
		$id_Site=$this->site_model->GetID_site($arr["name"]);
     	$data['sites'] = $this->site_model->AddCities($id_Site, $arr["cities"]);  
     	echo "<br><br>all OK";
	}
}