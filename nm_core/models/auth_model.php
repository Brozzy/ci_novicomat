<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function UserLogin($password, $user) {
		$user = $this->user_model->GetByUsername($user);

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

    public function EmailLogin($password, $email){

        $user = $this->user_model->GetByEmail($email, $password);

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

    /**
     * @param $Password
     * String type password
     * @return bool
     * FALSE
     * If Create function form user_model returns $used->id
     * TRUE
     * If Create function doesnt return $user ID
     * @usage
     * Takes inputs from register form and inserts the newly created used into vs_users table
     *
     * TODO, currently not working cleared return value in Create function
     */
    public function HandleRegister($Password) {

        $username = $this->input->post('username');
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        //Using SALTed password for better protection in the future, for now all users will have both created
        $user = $this->user->Create($username, $name, $email, md5($password), md5($password.SALT));

        if(isset($user->id)) return true;
        else return false;
    }
}