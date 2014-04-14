<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class base extends CI_Controller {
	
	function __construct() {
		parent::__construct(); 
		$this->load->library('Template');
	}
	
	public function index() {
		if($this->session->userdata("logged") == TRUE)
			redirect('Domov','location');
		else redirect('Prijava','location');
	}
}

?>