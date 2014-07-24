<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class base extends CI_Controller {
	
	function __construct() {
		parent::__construct(); 
		$this->load->library('Template');

        if(get_class($this) != "auth" && $this->session->userdata("logged") != TRUE)
            redirect('prijava','refresh');
	}
	
	public function index() {
        redirect('domov','refresh');
	}
}

?>