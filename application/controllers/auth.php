<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
		 
	function __construct() {
		parent::__construct();
		$this->load->model("AuthModel");
		$this->load->helper('form');
	}
		 
	public function index() {
		if($this->session->userdata('LoggedIn') == TRUE)
			redirect(base_url()."Home");
		else
			redirect(base_url()."Auth/Login");
	}
	
	public function Login() {
		
		if($this->input->post("Login")) {
			$this->form_validation->set_rules('Username', 'Uporabniško ime', 'trim|required|xss_clean'); 
			$this->form_validation->set_rules('Password', 'Geslo', 'trim|required|xss_clean');
			
			if($this->form_validation->run() && $this->AuthModel->HandleLogin())
				redirect(base_url()."Home","refresh");
			else
				$this->form_validation->set_message("PerformLogin",$Result["Error"]);
		}
		
		$this->load->view('head');
		$this->load->view('Auth/Login');
		$this->load->view('foot');
	}
	
	public function Registration() {
		
		if($this->input->post("Registration")) {
			if($this->AuthModel->HandleRegistration())
				redirect(base_url()."Auth/Login","refresh");
		}
		
		$this->load->view('head');
		$this->load->view('Auth/Register');
		$this->load->view('foot');
	}
}
