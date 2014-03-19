<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthModel extends CI_Model {
	
	public function HandleLogin() {
		$Username = $this->input->post("Username");
		$Password = $this->input->post("Password");
		
		$User = $this->UserModel->GetByLogin($Username,md5($Password));
		
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
	
}