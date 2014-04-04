<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vsebine extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("UserModel");
		$this->load->model("VsebineModel");
		$this->load->model("PortaliModel");
		$this->load->model("TagsModel");
		$this->load->library('Template');
		$this->template->set_template("master");
	}
	
	public function Create() {
		$Prispevek = $this->VsebineModel->CreatePrispevek();
		$User = $this->UserModel->GetById($this->session->userdata("UserId")); 
		$Var = array("Prispevek" => $Prispevek, "User" => $User);

		$this->template->write('Title', 'Nov prispevek | novicomat.com');
		$this->template->write_view('Header', '_Header',$Var);
		
		if($User->level > 6 && isset($_GET["view"]))
			$User->level = $_GET["view"];
		
		$this->template->write_view('Panel', '_Panel');
		$this->template->write_view('Content', "Vsebine/Prispevek/_Edit",$Var);
		$this->template->write_view('Footer', '_Footer');
		$this->template->render();
	}
	
	public function Update() {
		$Prispevek = (object) $this->input->post("Prispevek");
		$Updated = $this->VsebineModel->Update($Prispevek);
	}
	
	public function View($PrispevekId) {
		$Prispevek = $this->VsebineModel->GetById($PrispevekId);
		$User = $this->UserModel->GetById($this->session->userdata("UserId"));

		$Var = array("Prispevek" => $Prispevek, "User" => $User);

		if($Prispevek->state > 2 || $Prispevek->created_by == $User->id) {
			 
			$this->template->write('Title', $Prispevek->title.' | novicomat.com');
			$this->template->write_view('Header', '_Header',$Var);

			if($User->level > 6 && isset($_GET["view"]))
				$User->level = $_GET["view"];

			$this->template->write_view('Panel', '_Panel');
			$this->template->write_view('Content', "Vsebine/Prispevek/_View",$Var);
			$this->template->write_view('Footer', '_Footer');
			$this->template->render();
		}
		else redirect(base_url()."Home","refresh");
	}
	
	public function Edit($PrispevekId) {
		$Prispevek = $this->VsebineModel->GetById($PrispevekId);
		$User = $this->UserModel->GetById($this->session->userdata("UserId"));
		$Portali = $this->PortaliModel->GetUserAproved($User->id);
		$Var = array("Prispevek" => $Prispevek, "Portali" => $Portali, "User" => $User);
		
		if($Prispevek->created_by == $User->id) {
			$this->template->write('Title', $Prispevek->title.' | novicomat.com');
			$this->template->write_view('Header', '_Header',$Var);

			if($User->level > 6 && isset($_GET["view"]))
				$User->level = $_GET["view"];

			$this->template->write_view('Panel', '_Panel');
			$this->template->write_view('Content', "Vsebine/Prispevek/_Edit",$Var);
			$this->template->write_view('Footer', '_Footer');
			$this->template->render();
		}
		else redirect(base_url()."Home","refresh");
	}
	
	public function Delete($PrispevekId) {
		$this->db->delete('vs_vsebine', array('id' => $PrispevekId));
		redirect(base_url()."Home","refresh");
	}
}

?>