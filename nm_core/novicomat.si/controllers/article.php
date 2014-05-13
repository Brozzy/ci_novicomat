<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class article extends base {

	function __construct() {
		parent::__construct();
	}
	
	public function Form() {
		$this->load->view('master/content/article/edit',$var);
	}
}