<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class auth extends base {
		 
	function __construct() {
		parent::__construct();

		$this->load->model("auth_model");
		$this->load->model("user_model");
		$this->load->helper('form');
		$this->load->library('form_validation');
	}
		 
	public function index() {
		$this->Login();
	}	
	
	public function Login() {
		
		if($this->input->post("login") == 1) {
			$this->form_validation->set_rules('username', 'Uporabniško ime', 'trim|required|xss_clean'); 
			$this->form_validation->set_rules('password', 'Geslo', 'trim|required|xss_clean');
			
			if($this->form_validation->run() && $this->auth_model->UserLogin($this->input->post("password")))
				redirect(base_url()."Domov","refresh");
			else $this->form_validation->set_message('HandleLogin', 'Uporabniško ime ali geslo je napačno');
		}

		$this->template->load_tpl('auth','Prijava','login');
	}

	/*public function Register() {
		if($this->input->post("Register") == 1) {
			$this->form_validation->set_rules('username', 'Uporabniško ime', 'trim|min_length[3]|max_length[25]|is_unique[vs_users.username]|required|xss_clean'); 
			$this->form_validation->set_rules('Name', 'Ime', 'trim|required|xss_clean'); 
			$this->form_validation->set_rules('Email', 'E-naslov', 'trim|required|valid_email|xss_clean'); 
			$this->form_validation->set_rules('Password', 'Geslo', 'trim|required|min_length[3]|max_length[16]|matches[PasswordConfirm]');
			$this->form_validation->set_rules('PasswordConfirm', 'Ponovi geslo', 'trim|min_length[3]|max_length[16]|required|callback_RegisterNewuser');
			
			if($this->form_validation->run())
				redirect(base_url()."auth/Login","refresh");
		}
		
		$this->template->load_tpl('auth','Registracija','register');
	}
	
	public function RegisterNewuser($Password) {
		if($this->AuthModel->HandleRegister($Password))
			return true;
		else return false;
	}*/
	
	public function Logout() {
		$this->session->unset_userdata('userId');
		$this->session->unset_userdata('Name');
		$this->session->unset_userdata('LoggedIn');
		$this->session->sess_destroy();
		redirect(base_url()."Domov","refresh");
	}
}
