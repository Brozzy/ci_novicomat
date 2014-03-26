<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthModel extends CI_Model {
	
	public function HandleLogin($Password) {
		$Username = $this->input->post("Username");
		
		$User = $this->UserModel->GetByLogin($Username,$Password);
		
		if(isset($User->id)) {
			$Session = array(
				"UserId" => $User->id,
				"Name" => $User->name,
				"LoggedIn" => TRUE
			);
			
			$this->session->set_userdata($Session);

			return true;
		}
		else return false;
	}
	
	public function HandleRegister($Password) {
		$Username = $this->input->post("Username");
		$Name = $this->input->post("Name");
		$Email = $this->input->post("Email");
		
		$User = $this->UserModel->Create($Username, $Name, $Email, md5($Password));
		
		if(isset($User->id)) return true;
		else return false;
	}
}