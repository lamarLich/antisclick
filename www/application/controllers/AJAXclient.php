<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AJAXclient extends CI_Controller {

	public function index()
	{
		$data['title'] =  "AJAXclient";
		$this->load->view('templates/header',$data);
		echo "<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">";
		echo "<br>AJAXclient методы: ";
		echo "<br>";
		echo "<br>[getUserSitesStat()] ";
		echo "<br>метод принимает юзерайди, возвращает его сайты в виде айди, название, кол-во плохих айпи";
		echo "<br>Вернет json или ошибку";
		echo "<br>";
		echo "<br>[AddUserSite(json)]";
		echo "<br>метод принимает юзерайди, сайтнейм, массив из айди регионов, N и K, и складывает это все в бд, причем K и N могут быть нулом";
		echo "<br>Параметр 'json' передается в GET или POST";
		echo "<br> json = (sitename, regions[] [,K_min, N_sec])";
		echo "<br>Вернет ничего или ошибку";
		echo "<br>";
		echo "<br>[DeleteUserSite(siteId)]";
		echo "<br>метод на делет сайта по сайтайди";
		echo "<br>Параметр 'siteId' передается в GET или POST";
		echo "<br>Вернет результат удаления";
		echo "<br>";
		echo "<br>[UpdateUserSiteRegions(json)]";
		echo "<br>метод на апдейт региoнов сайта по сайтайди";
		echo "<br>Параметр 'json' передается в GET или POST";
		echo "<br> json = (siteId, regions[])";
		echo "<br>return '1' if all OK";
		echo "<br>";
		echo "<br>[GetCitysFromSiteID(id)]";
		echo "<br>Возвращает список регионов привязанных к выбранному сайту";
		echo "<br>Параметр 'id' передается в GET";
		echo "<br>Вернет json или ошибку";
		echo "<br>";
		echo "<br>[GetAllCitys()]";
		echo "<br>Возвращает весь список доступных регионов";
		echo "<br>Вернет json или ошибку";
		echo "<br>";
		echo "<br>[getStatSite(siteId)]";
		echo "<br>Возвращает список забаненых ip с флагом просмотрен\непросмотрен по выбранному сайту";
		echo "<br>Параметр 'siteId' передается в GET или POST";
		echo "<br>Вернет json или ошибку";
		echo "<br>";
		echo "<br>[seeIP(json)]";
		echo "<br>Записывает новые просмотренные ip в БД";
		echo "<br>Параметр 'json' передается в GET или POST";
		echo "<br> json = [id_ip]";
		echo "<br>Вернет 1 или ошибку";
		echo "</div>";
		$this->load->view('templates/footer');
	}

	public function getUserSitesStat()
	{
		$userId=1;//$this->session->userdata('userId');
		if (!isset($userId)) {
			echo "error: UnAuthorized User";
			die;
		}
		$this->load->model('site_model'); // загрузка модели

		$data = $this->site_model->GetSitesWhereIdUser($userId);
		if (!empty($data)) {
			echo json_encode($data);
		}
		else echo "error: empty result";
		exit;
	}

	public function getStatSite()
	{
		$userId=1;//$this->session->userdata('userId');
		if (!isset($userId)) {
			echo "error: UnAuthorized User";
			die;
		}
		$siteId;
		if (!isset($_GET['siteId']) && !isset($_POST['siteId'])) {
			echo "error: empty siteId";
  			die;
		}
		if (isset($_POST['siteId'])) {
			$siteId = $_POST['siteId'];
		}
		elseif (isset($_GET['siteId'])) {
		 	$siteId = $_GET['siteId'];
		}
		
		$this->load->model('site_model'); // загрузка модели

		$data = $this->site_model->GetAllIPWhereSite($userId, $siteId);
		if (!empty($data)) {
			echo json_encode($data);
		}
		else echo "error: empty result";
		exit;
	}

	public function seeIP()
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
		
		$json = json_decode($json, true);

		$userId=1;//$this->session->userdata('userId');
		if (!isset($userId)) {
			echo "error: UnAuthorized User";
			die;
		}

		$this->load->model('site_model'); // загрузка модели


		$this->site_model-> AddUser_ip($userId, $json);
		echo 1;
	}

	public function AddUserSite()
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
		
		$json = json_decode($json, true);

		$userId=1;//$this->session->userdata('userId');
		if (!isset($userId)) {
			echo "error: UnAuthorized User";
			die;
		}
		if (!isset($json['sitename'])) {
			echo "error: empty json[sitename]";
  			die;
		}
		if (!isset($json['regions'])) {
			echo "error: empty json[regions]";
  			die;
		}
		if (isset($json['K_min'])) {
			$K_min=$json['K_min'];
		}
		if (isset($json['N_sec'])) {
			$N_sec=$json['N_sec'];
		}
		$this->load->model('site_model'); // загрузка модели


		$idSite = $this->site_model->insert_site($json['sitename'],$json['userId'],$K_min,$N_sec);
		$this->site_model->AddCities($idSite, $json['regions']);
	}

	public function DeleteUserSite()
	{
		$siteId;
		if (!isset($_GET['siteId']) && !isset($_POST['siteId'])) {
			echo "error: empty siteId";
  			die;
		}
		if (isset($_POST['siteId'])) {
			$siteId = $_POST['siteId'];
		}
		elseif (isset($_GET['siteId'])) {
		 	$siteId = $_GET['siteId'];
		}

		$this->load->model('site_model'); // загрузка модели

		$result = $this->site_model->DeleteSite($siteId);
		if (isset($result) && !empty($result)) {
			echo $result;
		}
		exit;
	}

	public function UpdateUserSiteRegions()
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
		if (!isset($json['siteId'])) {
			echo "error: empty json[siteId]";
  			die;
		}
		if (!isset($json['regions'])) {
			echo "error: empty json[regions]";
  			die;
		}

		$this->load->model('site_model'); // загрузка модели

		$this->site_model->DeleteSite_CitiesWhereIdSite($json['siteId']);
		$this->site_model->AddCities($json['siteId'], $json['regions']);
		echo "1";
	}

	public function GetCitysFromSiteID()
	{
		$this->load->model('site_model');
		$arr = $this->site_model->GetCitysFromSiteID($_GET['id']);
		echo json_encode($arr);
		exit;
	}
	public function GetAllCitys()
	{
		$this->load->model('site_model');
		$arr = $this->site_model->GetAllCities();
		echo json_encode($arr);
		exit;
	}
}