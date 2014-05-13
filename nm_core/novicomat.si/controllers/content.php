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
			case "location":
				$event = new location($content);
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
	
	public function CropImage() {
		$crop = (object) $this->input->post("crop");
		
		$dir = "./upload/images/cropped/".$crop->content_id;
		if(!is_dir($dir)) mkdir($dir,0777);
		
		list($width, $height, $type, $attr) = getimagesize($crop->url);
		$type = explode(".",basename($crop->url));
		$type = ($type[1]=="jpeg"?"jpg":$type[1]);
		
		$name = $this->token(rand(8,12)).".".$type;
		$upload = $dir."/".$name;
		
		if(file_exists($upload)) unlink($upload);
		
		$dst_x = 0; 
		$dst_y = 0;
		$src_x = $crop->x;
		$src_y = $crop->y;
		$dst_w = $crop->w;
		$dst_h = $crop->h;
		$src_w = $crop->w;
		$src_h = $crop->h;

		$dst_image = imagecreatetruecolor($dst_w,$dst_h);
		$src_image = imagecreatefromjpeg($crop->url);
		
		imagecopyresampled($dst_image, $src_image, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		imagejpeg($dst_image, $upload, 90);
		
		echo base_url()."upload/images/cropped/".$crop->content_id."/".$name;
	}
	
	private function token($length) {
		$characters = array(
		"A","B","C","D","E","F","G","H","J","K","L","M",
		"N","P","Q","R","S","T","U","V","W","X","Y","Z",
		"a","b","c","d","e","f","g","h","i","j","k","m",
		"n","o","p","q","r","s","t","u","v","w","x","y","z",
		"1","2","3","4","5","6","7","8","9");
	
		//make an "empty container" or array for our keys
		$keys = array();
		$random = "";
	
		//first count of $keys is empty so "1", remaining count is 1-6 = total 7 times
		while(count($keys) < $length) {
			//"0" because we use this to FIND ARRAY KEYS which has a 0 value
			//"-1" because were only concerned of number of keys which is 32 not 33
			//count($characters) = 33
			$x = mt_rand(0, count($characters)-1);
			if(!in_array($x, $keys)) {
			   $keys[] = $x;
			}
		}
	
		foreach($keys as $key){
			$random .= $characters[$key];
		}
	
		return $random;
	} 
}

?>