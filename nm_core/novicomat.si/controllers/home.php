<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class home extends base {
	
	function __construct() {
		parent::__construct();
			
		$this->load->model("user_model");
		$this->load->model("content_model");
	}
	
	public function index() {
		if($this->session->userdata("logged") == FALSE)
			redirect('Prijava','location');

		$user = $this->user_model->GetById($this->session->userdata("userId"));
		$content = $this->content_model->GetUserContent($user->id);

		$var = array("content" => $content, "user" => $user);
		
		$this->template->load_tpl('master','Domov','front',$var);
	}
}