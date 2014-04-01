<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {
		 
	function __construct() {
		parent::__construct();

		$this->load->model("AuthModel");
		$this->load->model("UserModel");
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->library('Template');
		$this->template->set_template("auth");
	}
		 
	public function index() {
		redirect(base_url()."Auth/Login");
	}
	
	/* Funkcija, ki bo prenesla privilegije registriranega uporabnika iz stare tabele v novo */
	public function Base() {
		$this->db->select("um.*");
		$this->db->from("j3_user_usergroup_map AS um");
		$query = $this->db->get();
		
		foreach($query->result() as $UserLevel) {
			$User = array("level" => $UserLevel->group_id);
			
			$this->db->where('id', $UserLevel->user_id);
			$this->db->update("vs_users",$User);
		}
	}
	
	
	public function Login() {
		
		if($this->input->post("Login") == 1) {
			$this->form_validation->set_rules('Username', 'Uporabniško ime', 'trim|required|xss_clean'); 
			$this->form_validation->set_rules('Password', 'Geslo', 'trim|required|xss_clean|callback_CheckIfUserExists');
			
			if($this->form_validation->run())
				redirect(base_url()."Home","refresh");
		}
		
		
		$this->template->write('Title', 'Prijava | novicomat.com');
		$this->template->write('Header', 'Prijava');
		$this->template->write_view('Content', 'Auth/Login');
		$this->template->write_view('Footer', '_Footer');
		$this->template->render();
	}
	
	public function CheckIfUserExists($Password) {
		if($this->AuthModel->HandleLogin($Password))
			return true;
		else {
			$this->form_validation->set_message('CheckIfUserExists', 'Uporabniško ime ali geslo je napačno');
			return false;
		}
	}
	
	public function Register() {
		if($this->input->post("Register") == 1) {
			$this->form_validation->set_rules('Username', 'Uporabniško ime', 'trim|min_length[3]|max_length[25]|is_unique[vs_users.username]|required|xss_clean'); 
			$this->form_validation->set_rules('Name', 'Ime', 'trim|required|xss_clean'); 
			$this->form_validation->set_rules('Email', 'E-naslov', 'trim|required|valid_email|xss_clean'); 
			$this->form_validation->set_rules('Password', 'Geslo', 'trim|required|min_length[3]|max_length[16]|matches[PasswordConfirm]');
			$this->form_validation->set_rules('PasswordConfirm', 'Ponovi geslo', 'trim|min_length[3]|max_length[16]|required|callback_RegisterNewUser');
			
			if($this->form_validation->run())
				redirect(base_url()."Auth/Login","refresh");
		}
		
		$this->template->write('Title', 'Registracija | novicomat.com');
		$this->template->write('Header', 'Registracija');
		$this->template->write_view('Content', 'Auth/Register');
		$this->template->write_view('Footer', '_Footer');
		$this->template->render();
	}
	
	public function RegisterNewUser($Password) {
		if($this->AuthModel->HandleRegister($Password))
			return true;
		else return false;
	}
	
	public function Logout() {
		$this->session->unset_userdata('UserId');
		$this->session->unset_userdata('Name');
		$this->session->unset_userdata('LoggedIn');
		$this->session->sess_destroy();
		redirect(base_url()."Auth/Login","refresh");
	}
}
