<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class home extends base {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));
		$contents = $this->content_model->GetUserContent($user->id);

		$var = array("contents" => $contents, "user" => $user);
		$this->template->load_tpl('home','Domov','front',$var);
	}

    public function Test() {

    }
}