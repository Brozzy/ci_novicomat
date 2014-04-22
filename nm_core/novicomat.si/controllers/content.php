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
		$content->Create();
		
		return $content;
	}
	
	public function CreateArticle() {
		$content = $this->Create();
		
		$article = new article($content);
		$article->Create();
		
		$user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));
		$data = array("article" => $article, "user" => $user);
		
		$this->template->load_tpl('master','Nov prispevek','content/article/edit',$data);
	}
	
	public function Update() {
		$update = (object) $this->input->post("article");		
		$article = new article($update);

		if($this->input->post("Save"))
			redirect(base_url()."Domov","location");
	}
	
	public function View($articleId) {
		$article = $this->content_model->GetById($articleId);
		$user = $this->user_model->GetById($this->session->userdata("userId"));

		$var = array("article" => $article, "user" => $user);

		if($article->state > 2 || $article->created_by == $user->id)
			$this->template->load_tpl('master',$article->title,'content/article/view',$var);
		else redirect(base_url()."Domov","refresh");
	}
	
	public function Edit($articleId) {
		$article = $this->content_model->GetById($articleId);
		$user = $this->user_model->GetById($this->session->userdata("userId"));
		$domains = $this->portal_model->GetUserAproved($user->id);
		$publicImages = $this->content_model->GetPublic();
		
		$var = array("article" => $article, "GalleryImage" => $GalleryImage, "domains" => $domains, "user" => $user);
		
		if($article->created_by == $user->id) {
			$this->template->load_tpl('master','Urejanje','content/article/edit',$var);
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