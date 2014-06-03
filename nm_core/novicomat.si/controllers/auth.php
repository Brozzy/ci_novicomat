<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class auth extends base {
		 
	function __construct() {
		parent::__construct();

        //Array of configs for the email, currently set to an old email
        //We should use something like noreply@novicomat.si
        /* Current mail
        *   Ime: novicko
        *   Priimek: mat
        *   email: novicko.no.reply@gmail.com
        *   geslo: novicomat789
        *   datum rojstva: 31. Maj 1980
        *   Spol: drugo
        *
        */
        $email_config = Array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => 'novicko.no.reply@gmail.com',
            'smtp_pass' => 'novicomat789',
            'starttls'  => true,
            'newline'   => "\r\n",
            //Use, when we will design the structure of the email
            //'mailtype' => 'html'
        );

		$this->load->model("auth_model");
		$this->load->model("user_model");
		$this->load->helper('form');
		$this->load->library('form_validation');
        $this->load->library('email', $email_config);

    }
	//random comment for test
	public function index() {
		$this->Login();
	}	
	
	public function Login() {
		
		if($this->input->post("login") == 1) {
			$this->form_validation->set_rules('username', 'Uporabniško ime', 'trim|required|xss_clean'); 
			$this->form_validation->set_rules('password', 'Geslo', 'trim|required|xss_clean');
			
			if($this->form_validation->run() && $this->auth_model->UserLogin($this->input->post("password")))
				redirect(base_url()."Domov","refresh");
			else $this->form_validation->set_message('HandleLogin', 'Uporabniško ime ali geslo je napačno');
		}

		$this->template->load_tpl('auth','Prijava','login');
	}


    //TODO WORK IN PROGRESS, AJAX NEEDS TO BE ADDED TO VIEW
    public function Register() {

        if($this->input->post("register") == 1)
        {
            $username = $this->input->post("username");
            $name = $this->input->post("name");
            $email = $this->input->post("email");
            $password = $this->input->post("password");

            $this->form_validation->set_rules('username', 'Uporabniško ime', 'trim|min_length[3]|max_length[25]|is_unique[vs_users.username]|required|xss_clean');
            $this->form_validation->set_rules('name', 'Ime', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', 'E-naslov', 'trim|min_length[4]|max_length[99]|is_unique[vs_users.email]|required|valid_email|xss_clean');
            $this->form_validation->set_rules('password', 'Geslo', 'trim|required|min_length[3]|max_length[16]|matches[rep_password]');

            //Validation fails
            if($this->form_validation->run() == false)
            {
                //ERROR HANDLING?
            }
            //Validation successfull
            else
            {
                //Registering
                $this->user_model->Create($username, $name, $email, md5($password), md5($password.SALT));

                $user_data = $this->user_model->checkEmail($email);

                $this->email->from('','no reply');
                $this->email->to($email);
                $this->email->subject('Ekipa Novicomat');
                //TODO, HTML MSG
                $this->email->message(  "Zdravo, ".$user_data->name."\r\n\r\n".
                                        "Hvala za Vašo registracijo v sistem Novicomat.\r\n".
                                        "Naj vam dobro služi pri širjenju vaših novic.\r\n".
                                        "V primeru morebitnih vprašanj se obrnite na info@novicomat.si.\r\n\r\n".
                                        "Vaše uporabniško ime: ".$user_data->username."\r\n".
                                        "Račun ste registrirali na email: ".$user_data->email."\r\n\r\n".
                                        "Lep Pozdrav,\r\n\r\n".
                                        "Ekipa Novicomata :)");
                /*
                //TODO, HTML message
                $this->email->message(  "Your registration data is: \r\n".
                    "Registered name: ".$user_data->name."\r\n".
                    "Registered username: ".$user_data->username."\r\n".
                    "Registered email: ".$user_data->email);
                */
                if($this->email->send())
                    redirect(base_url()."auth/success_register", "refresh");
                else
                    redirect(base_url()."Domov", "refresh");

            }
        }

        $this->template->load_tpl('auth','Registracija','register');
    }

    /*
     * NOT NEEDED
	private function RegisterNewuser($Password) {
		if($this->AuthModel->HandleRegister($Password))
			return true;
		else return false;
	}
    */

    //TODO WORK IN PROGRESS, TOKEN NEEDS TO BE ADDED
    public function Lost_Password()
    {
        if($this->input->post('lost_pass') == 1)
        {
            $email = $this->input->post('email');
            //email validation doesn't include unique, because of security reasons.
            $this->form_validation->set_rules('email', 'E-MAIL','trim|required|xss_clean');
            $user_data = $this->user_model->checkEmail($email);

            if($this->form_validation->run() == true)
            {
                //User is redirected to success_email even if he enters a mail that doesn't exist in the db, this is done to discourage data mining.
                if(is_object($user_data))
                {
                    $this->email->from('','no reply');
                    $this->email->to($email);
                    $this->email->subject('testni email');
                    //displaying data for testing purposes, we will display the password token here later on
                    $this->email->message(  $user_data->id."\r\n".
                        $user_data->username."\r\n".
                        $user_data->email."\r\n".
                        $user_data->name
                    );

                    $this->email->send();

                }

                redirect(base_url()."auth/success_email", "refresh");

            }
        }
        $this->template->load_tpl('auth', 'Pozabljeno Geslo', 'lost_password');
    }

    /**
     * @usage
     * Open success_mail view
     */
    public function Success_Email()
    {
        $this->template->load_tpl('auth', 'Email uspesno poslan', 'success_mail');
    }

    public function Success_Register()
    {
        $this->template->load_tpl('auth', 'Registracija uspesna', 'success_register');
    }

    public function Error()
    {
        $this->template->load_tpl('auth','Ups, nekaj je slo narobe','fail_view');
    }

	
	public function Logout() {
		$this->session->unset_userdata('userId');
		$this->session->unset_userdata('Name');
		$this->session->unset_userdata('LoggedIn');
		$this->session->sess_destroy();
		redirect(base_url()."Domov","refresh");
	}
}
