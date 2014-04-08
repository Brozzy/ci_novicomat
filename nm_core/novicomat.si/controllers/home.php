<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class home extends base {
	
	function __construct() {
		parent::__construct();
			
		$this->load->model("user_model");
		$this->load->model("vsebine_model");
	}
	
	public function index() {
		if($this->session->userdata("LoggedIn") == FALSE)
			redirect('Prijava','location');

		$User = $this->user_model->GetById($this->session->userdata("UserId"));
		$Osnutki = $this->vsebine_model->GetDrafts($User->id);
		$Vsebine = $this->vsebine_model->Get($User->id);

		$var = array("Osnutki" => $Osnutki, "User" => $User, "Vsebine" => $Vsebine);
		
		$this->template->load_tpl('master','Domov','front',$var);
	}
}