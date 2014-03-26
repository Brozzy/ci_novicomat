<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		if(!$this->session->userdata('LoggedIn'))
			redirect(base_url()."Auth/Login");
			
		$this->load->model("UserModel");
		$this->load->library('Template');
		$this->template->set_template("master");
	}
	
	public function index() {
		$User = $this->UserModel->GetById($this->session->userdata("UserId"));

		$this->db->select("v.*");
		$this->db->from("vs_vsebine as v");
		$this->db->where("v.state",3);
		$this->db->limit(40);
		$query = $this->db->get();
		
		$Var = array("User" => $User, "Vsebine" => $query->result());
		
		$this->template->write('Title', 'Domov | novicomat.com');
		$this->template->write_view('Header', '_Header',$Var);
		$this->template->write_view('Panel', '_Panel');
		$this->template->write_view('Sidebar', '_Sidebar');
		$this->template->write_view('Content', 'Home/Front');
		$this->template->write_view('Footer', '_Footer');
		$this->template->render();
	}
}