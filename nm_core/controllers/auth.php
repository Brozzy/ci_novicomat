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
        $this->load->model("token_model");
		$this->load->helper('form');
		$this->load->library('form_validation');
        $this->load->library('email', $email_config);

    }
	public function index() {
		$this->Login();
	}

	public function Login() {

        $login = (object)$this->input->post("login");

        if(isset($login->username) && !empty($login))
        {
            $this->form_validation->set_rules('login[username]', 'E-MAIL', 'trim|required|xss_clean');
            $this->form_validation->set_rules('login[password]', 'Geslo', 'trim|required|xss_clean');

            //if email is entered
            if(filter_var($login->username, FILTER_VALIDATE_EMAIL))
            {
                if($this->form_validation->run() && $this->auth_model->EmailLogin($login->password, $login->username))
                    redirect(base_url()."Domov","refresh");
                else $this->form_validation->set_message('HandleLogin', 'Uporabniško ime ali geslo je napačno');
            }
            else
            {
                if($this->form_validation->run() && $this->auth_model->UserLogin($login->password, $login->username))
                    redirect(base_url()."Domov","refresh");
                else $this->form_validation->set_message('HandleLogin', 'Uporabniško ime ali geslo je napačno');
            }
        }


		$this->template->load_tpl('auth','Prijava','login');
	}

    /**
     * @usage
     *
     * Registration controler, checks and validates form data and sends email upon completion
     */
    //TODO WORK IN PROGRESS, AJAX NEEDS TO BE ADDED TO VIEW
    public function Register() {

        $user = (object) $this->input->post("user");
        $data = array();
        if(isset($user->username) && !empty($user))
        {

            $this->form_validation->set_rules('user[username]', 'Uporabniško ime', 'trim|min_length[3]|max_length[25]|is_unique[vs_users.username]|required|xss_clean');
            $this->form_validation->set_rules('user[name]', 'Ime', 'trim|required|xss_clean');
            $this->form_validation->set_rules('user[email]', 'E-naslov', 'trim|min_length[4]|max_length[99]|is_unique[vs_users.email]|required|valid_email|xss_clean');
            $this->form_validation->set_rules('user[password]', 'Geslo', 'trim|required|min_length[3]|max_length[16]|matches[rep_password]');

            //Validation fails
            if($this->form_validation->run() == false)
            {
                $data = array(
                    'username' => form_error('user[username]'),
                    'name' => form_error('user[name]'),
                    'email' => form_error('user[email]'),
                    'password' => form_error('user[password]'),
                );
                //TODO error handling without ajax
            }
            //Validation successfull
            else
            {
                //Registering
                $this->user_model->Create($user->username, $user->name, $user->email, md5($user->password), md5($user->password.SALT));

                $this->email->from('','no reply');
                $this->email->to($user->email);
                $this->email->subject('Ekipa Novicomat');

                //TODO, HTML MSG
                $this->email->message(  "Zdravo, ".$user->name."\r\n\r\n".
                                        "Hvala za Vašo registracijo v sistem Novicomat.\r\n".
                                        "Naj vam dobro služi pri širjenju vaših novic.\r\n".
                                        "V primeru morebitnih vprašanj se obrnite na info@novicomat.si.\r\n\r\n".
                                        "Vaše uporabniško ime: ".$user->username."\r\n".
                                        "Račun ste registrirali na email: ".$user->email."\r\n\r\n".
                                        "Lep Pozdrav,\r\n\r\n".
                                        "Ekipa Novicomata :)");

                $this->email->send();
            }
            echo json_encode($data);

        }
    }

    /**
     * @usage sends reset password token if email exists in our database
     */
    //TODO WORK IN PROGRESS, TOKEN NEEDS TO BE ADDED
    public function Lost_Password()
    {
        $email = $this->input->post('email');
        if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            $this->form_validation->set_rules('email', 'E-MAIL','trim|required|xss_clean');

            $user_data = $this->user_model->checkEmail($email);

            if($this->form_validation->run() == true)
            {
                //Does the e-mail exist?
                //User is redirected to success_email even if he enters a mail that doesn't exist in the db, this is done to discourage data mining.
                if(is_object($user_data))
                {
                    //gets new token value if its not older than 4 hours
                    $token = $this->token_model->CheckToken($user_data->id, 4);
                    $this->email->from('','no reply');
                    $this->email->to($email);
                    $this->email->subject('Pozabljeno geslo | Novicomat.si');
                    //displaying data for testing purposes, we will display the password token here later on
                    $this->email->message(  "Zdravo, ".$user_data->name."\r\n\r\n".
                                            "S klikom na spodnjo povezavo si boste lahko ponovno nastavili geslo za Novicomat.\r\n\r\n".
                                            base_url()."Auth/Redeem/token/".$token."\r\n\r\n".
                                            "Če spremembe gesla niste zahtevali, lahko to sporočilo mirne vesti ignorirate.\r\n\r\n".
                                            "Lep Pozdrav,\r\n\r\n".
                                            "Ekipa Novicomata :)");
                    $this->email->send();
                }

                redirect(base_url()."auth/success_email", "refresh");
            }

        }

        $this->template->load_tpl('auth', 'Pozabljeno Geslo', 'lost_password');
    }



    public function Redeem()
    {
        //token object from url
        $data = $this->uri->uri_to_assoc(3);
        $password = $this->input->post("password");


        $this->form_validation->set_rules('password', 'Spremenjeno geslo', 'trim|required|min_length[3]|max_length[16]|matches[rep_password]');

        //if nothing can be associated form uri
        if(!empty($data))
        {
            //if there is no data under token
            if(isset($data['token']))
            {
                $token = $data['token'];
                //TOKEN USED OR EXPIRED
                if($this->token_model->TokenUsed($token) || $this->token_model->TokenExpired($token, 4))
                {
                    //TODO, NEED VIEW FOR BEFORE REDIRECTING TO LOST PASSWORD VIEW SO PEOPLE KNOW THEY ENTERED AN INVALID TOKEN
                    redirect(base_url()."auth/Lost_Password","refresh");
                }
                else
                {
                    //IF FORM VALIDATED
                    if($this->form_validation->run() == true)
                    {
                        //UPDATE PASSWORD
                        $this->user_model->UpdatePassword($token, md5($password), md5($password.SALT));
                        //USE TOKEN
                        $this->token_model->useToken($token);
                        redirect(base_url()."Prijava","refresh");
                    }
                    else
                    {
                        //throw form_data errors
                    }

                }

            }
            else
                redirect(base_url()."auth/Lost_Password","refresh");

        }
        $this->template->load_tpl('auth','Posljite novo geslo','redeem');
    }

    /**
     * @usage opens success_mail view
     */
    public function Success_Email()
    {
        $this->template->load_tpl('auth', 'Email uspesno poslan', 'success_mail');
    }

    /**
     * @usage opens success_register view
     *
     */
    public function Success_Register()
    {
        $this->template->load_tpl('auth', 'Registracija uspesna', 'success_register');
    }

    /**
     * @usage opens fail_view
     */
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
