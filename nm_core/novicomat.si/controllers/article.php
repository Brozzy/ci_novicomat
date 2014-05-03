<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class article extends base {

	function __construct() {
		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("content_model");
		$this->load->model("domain_model");
		$this->load->model("tag_model");
	}
	
	public function Form() {
		$this->load->view('master/content/article/edit',$var);
	}
}