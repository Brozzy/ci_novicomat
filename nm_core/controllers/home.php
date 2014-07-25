<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class home extends base {
	
	function __construct() {
		parent::__construct();
	}
	
	public function index() {
		$user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));
		$var = array("user" => $user);

		$this->template->load_tpl('home','Domov','front',$var);
	}

    public function view($title = 'Prispevki') {
        switch(strtolower($title)) {
            case 'slike':
                $type = 'images';
                break;
            case 'video':
                $type = 'video';
                break;
            case 'audio':
                $type = 'audio';
                break;
            case 'lokacije':
                $type = 'locations';
                break;
            case 'dogodki':
                $type = 'events';
                break;
            case 'mediji':
                $type = 'media';
                break;
            case 'kljucne-besede':
                $type = 'tags';
                break;
            case 'dokumenti':
                $type = 'documents';
                break;
            case 'napake':
                $type = 'bugs';
                break;
            default:
                $type = 'articles';
                break;
        }

        $user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));
        $contents = $this->content_model->GetUserContent($user->id);
        $var = array("contents" => $contents, "user" => $user);

        $this->template->load_tpl('home',strtolower($title),'list/'.$type,$var);
    }
}