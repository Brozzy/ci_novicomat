<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function UserLogin($password) {
		$user = $this->user_model->GetByUsername($this->input->post("username"));
		
		if(isset($user->id) && $this->user_model->CheckPassword($user,$password)) {
			$session = array(
				"userId" => $user->id,
				"name" => $user->name,
				"logged" => TRUE
			);
			
			$this->session->set_userdata($session);
			return true;
		}
		else return false;
	}
	
	public function HandleRegister($Password) {
		$username = $this->input->post("username");
		$Name = $this->input->post("Name");
		$Email = $this->input->post("Email");
		
		$user = $this->user->Create($username, $Name, $Email, md5($Password));
		
		if(isset($user->id)) return true;
		else return false;
	}
}