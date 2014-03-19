<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
		 
	function __construct() {
		parent::__construct();
		
		if($this->session->userdata('LoggedIn'))
			redirect(base_url()."Home");

		$this->load->model("AuthModel");
		$this->load->model("UserModel");
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
		 
	public function index() {
		redirect(base_url()."Auth/Login");
	}
	
	public function Login() {
		
		$Var = array('Title' => "Login | novicomat.com");
		
		if($this->input->post("Username")) {
			$this->form_validation->set_rules('Username', 'Uporabniško ime', 'trim|required|xss_clean'); 
			$this->form_validation->set_rules('Password', 'Geslo', 'trim|required|xss_clean');
			
			if($this->form_validation->run() && $this->AuthModel->HandleLogin())
				redirect(base_url()."Home","refresh");
			else
				$Var["Error"] = "Napačno uporabniško ime ali geslo.";
		}
		
		$this->load->view('head',$Var);
		$this->load->view('Auth/Login',$Var);
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
