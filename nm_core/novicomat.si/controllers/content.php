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
		$article = $this->content_model->CreateArticle();
		$user = $this->user_model->GetById($this->session->userdata("userId"));
		$domains = $this->domain_model->GetUserAproved($user->id);
		
		$var = array("article" => $article, "domains" => $domains, "user" => $user);

		$this->template->load_tpl('master','Nov prispevek','content/article/edit',$var);
	}
	
	public function update() {
		$article = (object) $this->input->post("article");		
		$updated = $this->content_model->update($article);

		if($this->input->post("Save"))
			redirect(base_url()."Domov","location");
	}
	
	public function view($articleId) {
		$article = $this->content_model->GetById($articleId);
		$user = $this->user_model->GetById($this->session->userdata("userId"));

		$Var = array("article" => $article, "user" => $user);

		if($article->state > 2 || $article->created_by == $user->id)
			$this->template->load_tpl('master',$article->title,'content/article/view',$Var);

		else redirect(base_url()."Domov","refresh");
	}
	
	public function edit($articleId) {
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
	
	public function delete($articleId) {
		$this->db->delete('vs_content', array('id' => $articleId));
		redirect(base_url()."Domov","refresh");
	}
	
	public function RemoveTagFromarticle() {
		$articleId = $this->input->post("articleId");
		$Tag = $this->tag_model->GetTag($this->input->post("Tag"));
		
		$this->tag_model->RemoveTagLink($articleId,$Tag->id);
	}
	
	public function AutocompleteTags() {
		$Json = array();
		
		array_push($Json,array( "id" => "hihihi", "label" => "huhu", "value" => "huhu" ));
		array_push($Json,array( "id" => "dfhdf", "label" => "fgfg", "value" => "fgfg" ));
		array_push($Json,array( "id" => "dddd", "label" => "kkk", "value" => "kkk" ));
		
		echo json_encode($Json);
	}
}

?>