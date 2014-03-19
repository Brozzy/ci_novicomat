<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		if(!$this->session->userdata('LoggedIn'))
			redirect(base_url()."Auth/Login");
			
		$this->load->model("UserModel");
	}
	
	public function index() {
		$User = $this->UserModel->GetById($this->session->userdata("UserId"));
		$Var = array("Title" => "Domov | novicomat.com","User" => $User);
		
		$this->load->view("head",$Var);
		$this->load->view("Home/Front",$Var);
		$this->load->view("foot");
	}
}