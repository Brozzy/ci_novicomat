<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class content extends base {

	function __construct() {
		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("content_model");
		$this->load->model("domain_model");
		$this->load->model("tag_model");
	}
	
	public function Create() {
		$content = new content_model();
		$content->CreateOrUpdate();
		
		return $content;
	}
	
	public function CreateArticle() {
		$content = $this->Create();
		
		$article = new article($content);
		$article->CreateOrUpdate();
		
		$user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));
		$data = array("article" => $article, "user" => $user);
		
		$this->template->load_tpl('master','Nov prispevek','content/article/edit',$data);
	}
	
	public function Update() {
		$content = (object) $this->input->post("content");

		switch($content->type) {
			case "article":
				$article = new article($content);
				$article->CreateOrUpdate();
				break;
			case "image":
				$image = new image($content);
				$image->CreateOrUpdate();
				break;
			case "event":
				$event = new event($content);
				$event->CreateOrUpdate();
				break;
		}
	}
	
	public function View($articleId) {
		$article = $this->content_model->GetById($articleId);
		$user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));

		$var = array("article" => $article, "user" => $user);

		if($article->state > 2 || $article->created_by == $user->id)
			$this->template->load_tpl('master',$article->title,'content/article/view',$var);
		else redirect(base_url()."Domov","refresh");
	}
	
	public function Edit($contentId) {
		$content = $this->content_model->GetById($contentId);
		$user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));
		
		$var = array("article" => $content, "user" => $user);
		
		if($content->created_by == $user->id) {
			$this->template->load_tpl('master','Urejanje','content/edit',$var);
		}
		else redirect(base_url()."Domov","refresh");
	}
	
	public function Delete($contentId) {
		$content = $this->content_model->GetById($contentId);
		
		$this->db->delete('vs_'.$content->type,array('id' => $content->ref_id));
		$this->db->delete('vs_content', array('id' => $content->id));
	}
	
	public function RemoveTagFromarticle() {
		$articleId = $this->input->post("articleId");
		$Tag = $this->tag_model->GetTag($this->input->post("Tag"));
		
		$this->tag_model->RemoveTagLink($articleId,$Tag->id);
	}
}

?>