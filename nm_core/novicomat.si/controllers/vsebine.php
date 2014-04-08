<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class vsebine extends base {

	function __construct() {
		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("vsebine_model");
		$this->load->model("portal_model");
		$this->load->model("tag_model");
	}
	
	public function Create() {
		$Prispevek = $this->vsebine_model->CreatePrispevek();
		$User = $this->user_model->GetById($this->session->userdata("UserId")); 
		$Var = array("Prispevek" => $Prispevek, "User" => $User);

		$this->template->load_tpl('master','Nov prispevek','vsebine/prispevek/edit',$Var);
	}
	
	public function Update() {
		$Prispevek = (object) $this->input->post("Prispevek");
		$Updated = $this->vsebine_model->Update($Prispevek);
	}
	
	public function View($PrispevekId) {
		$Prispevek = $this->vsebine_model->GetById($PrispevekId);
		$User = $this->user_model->GetById($this->session->userdata("UserId"));

		$Var = array("Prispevek" => $Prispevek, "User" => $User);

		if($Prispevek->state > 2 || $Prispevek->created_by == $User->id)
			$this->template->load_tpl('master',$Prispevek->title,'vsebine/prispevek/view',$Var);

		else redirect(base_url()."Domov","refresh");
	}
	
	public function Edit($PrispevekId) {
		$Prispevek = $this->vsebine_model->GetById($PrispevekId);
		$User = $this->user_model->GetById($this->session->userdata("UserId"));
		$Portali = $this->portal_model->GetUserAproved($User->id);
		$var = array("Prispevek" => $Prispevek, "Portali" => $Portali, "User" => $User);
		
		if($Prispevek->created_by == $User->id) {
			$this->template->load_tpl('master','Urejanje','vsebine/prispevek/edit',$var);
		}
		else redirect(base_url()."Domov","refresh");
	}
	
	public function Delete($PrispevekId) {
		$this->db->delete('vs_vsebine', array('id' => $PrispevekId));
		redirect(base_url()."Domov","refresh");
	}
	
	public function RemoveTagFromPrispevek() {
		$PrispevekId = $this->input->post("PrispevekId");
		$Tag = $this->tag_model->GetTag($this->input->post("Tag"));
		
		$this->tag_model->RemoveTagLink($PrispevekId,$Tag->id);
	}
}

?>