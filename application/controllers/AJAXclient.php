<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AJAXclient extends CI_Controller {

	public function index()
	{
		$data['title'] =  "AJAXclient";
		$this->load->view('templates/header',$data);
		echo "<div class=\"col-lg-12 col-md-12 col-sm-12 col-xs-12\">";
		echo "<br>AJAXclient методы: ";
		echo "<br>";
		echo "<br>[getUserSitesStat(userId)] ";
		echo "<br>метод принимает юзерайди, возвращает его сайты в виде айди, название, кол-во плохих айпи";
		echo "<br>Параметр 'userId' передается в GET или POST";
		echo "<br>Вернет json или ошибку";
		echo "<br>";
		echo "<br>[AddUserSite(json)]";
		echo "<br>метод принимает юзерайди, сайтнейм, массив из айди регионов, N и K, и складывает это все в бд, причем K и N могут быть нулом";
		echo "<br>Параметр 'json' передается в GET или POST";
		echo "<br> json = (userId, sitename, regions[] [,K_min, N_sec])";
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
		echo "</div>";
		$this->load->view('templates/footer');
	}

	//метод принимает юзерайди, возвращает его сайты в виде айди, название, кол-во плохих айпи
	public function getUserSitesStat()
	{
		$userId;
		if (!isset($_GET['userId']) && !isset($_POST['userId'])) {
			echo "error: empty userId";
  			die;
		}
		if (isset($_POST['userId'])) {
			$userId = $_POST['userId'];
		}
		elseif (isset($_GET['userId'])) {
		 	$userId = $_GET['userId'];
		}

		$this->load->model('site_model'); // загрузка модели

		$data = $this->site_model->GetSitesWhereIdUser($userId);
		if (!empty($data)) {
			echo json_encode($data);
		}
		else echo "error: empty result";
		exit;
	}

	/*//метод принимает сайт айди, возвращает строки, 
	//которые пользователь должен видеть в стате по своим сайтам, я не помню какие там точно
	public function getStat()
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

		//$data = $this->site_model->($siteId);
		if (!empty($data)) {
			echo json_encode($data);
		}
		else echo "error: empty result";
		exit;
	}
	*/

	//метод принимает юзерайди, сайтнейм, массив из айди регионов, 
	//N и K, и складывает это все в бд, причем K и N могут быть нулом
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

		if (!isset($json['userId'])) {
			echo "error: empty json[userId]";
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
		$this->load->model('ip_model'); // загрузка модели
		$this->load->model('click_model'); // загрузка модели
		$this->load->model('user_model'); // загрузка модели
		$this->load->model('site_model'); // загрузка модели


		$idSite = $this->site_model->insert_site($json['sitename'],$json['userId'],$K_min,$N_sec);
		$this->site_model->AddCities($idSite, $json['regions']);
	}

	//метод на делет сайта по сайтайди
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

	//метод на апдейт региoнов сайта по сайтайди
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
}