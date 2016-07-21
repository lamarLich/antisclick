<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller {

	public function index()
	{
		echo "index";
		$data['title'] =  "Статистика";
		$this->load->view('templates/header',$data);
		$this->load->view('user_stat');
		$this->load->view('templates/footer');
	}

	public function edit()
	{
		echo "edit";
		$data['title'] =  "Редактирование профиля";
		$this->load->view('templates/header',$data);
		$this->load->view('user_edit');
		$this->load->view('templates/footer');
	}

	public function panel()
	{
		echo "panel";
		$data['title'] =  "Управление сайтами";
		$this->load->view('templates/header',$data);
		$this->load->view('user_panel');
		$this->load->view('templates/footer');
	}

	public function help()
	{
		echo "help";
		$data['title'] =  "Помощь";
		$this->load->view('templates/header',$data);
		$this->load->view('user_help');
		$this->load->view('templates/footer');
	}
}