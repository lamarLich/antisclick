<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Controller {

	public function index()
	{

			$data['title'] =  "Регистрация";
			$this->load->view('templates/header',$data);
			$this->load->view('auth/registration');
			$this->load->view('templates/footer');
		
	}

}
