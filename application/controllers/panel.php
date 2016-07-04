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
		$this->load->view('panel_stat',$data);
		
		$this->load->view('templates/footer');
	}
}