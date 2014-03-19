<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AuthModel extends CI_Model {
	
	public function HandleLogin() {
		$Username = $this->input->post("Username");
		$Password = $this->input->post("Password");
		
		$User = $this->UserModel->Get($Username,md5($Password));
		
		if(isset($User["id"])) {
			$Session = array(
				"UserId" => $Result["User"]->UserId,
				"Fullname" => $Result["User"]->Firstname." ".$Result["User"]->Surname
			);
			
			$this->session->set_userdata("LoggedIn",$Session);

			return true;
		}
		else
			return false;
	}
	
}