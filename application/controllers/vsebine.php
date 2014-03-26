<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vsebine extends CI_Controller {
	
	function __construct() {
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("UserModel");
		$this->load->library('Template');
		$this->template->set_template("master");
	}
	
	public function NovPrispevek() {
		$Var = array("User" => $this->UserModel->GetById($this->session->userdata("UserId")));
		
		$this->template->write('Title', 'Dodaj prispevek | novicomat.com');
		$this->template->write_view('Header', '_Header',$Var);
		$this->template->write_view('Panel', '_Panel');
		$this->template->write_view('Sidebar', '_Sidebar');
		$this->template->write_view('Content', "Vsebine/Prispevek",$Var);
		$this->template->write_view('Footer', '_Footer');
		$this->template->render();
	}
	
	public function NovaLokacija() {
		$this->load->view("Vsebine/Lokacija");
	}
}

?>