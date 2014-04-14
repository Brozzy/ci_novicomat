<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class content_model extends CI_Model {

	public $id;
	public $name;
	public $description;
	public $ref_id;
	public $type;
	public $created_by;
	public $updated;
	public $updated_by;
	
	function __construct($content = array()) {
		parent::__construct();
		
		$this->id = (isset($content->id) ? $content->id : 0);
		$this->name = (isset($content->name) ? $content->name : "Nov prispevek");
		$this->description = (isset($content->description) ? $content->description : "");
		$this->ref_id = (isset($content->id) ? $content->id : 0);
		$this->type = (isset($content->type) ? $content->type : 1);
		$this->created_by = (isset($content->created_by) ? $content->created_by : $this->session->userdata("userId"));
		$this->updated = (isset($content->updated) ? $content->updated : "0000-00-00");
		$this->updated_by = (isset($content->updated_by) ? $content->updated_by : NULL);		
	}
	
	private function HandleImage($Type) {
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["article"]["name"][$Type]);
		$extension = end($temp);
		
		if ((($_FILES["article"]["type"][$Type] == "image/gif")
			|| ($_FILES["article"]["type"][$Type] == "image/jpeg")
			|| ($_FILES["article"]["type"][$Type] == "image/jpg")
			|| ($_FILES["article"]["type"][$Type] == "image/pjpeg")
			|| ($_FILES["article"]["type"][$Type] == "image/x-png")
			|| ($_FILES["article"]["type"][$Type] == "image/png"))
			&& in_array($extension, $allowedExts) && $this->id != 0) {

				if ($_FILES["article"]["error"][$Type] > 0)
					return base_url()."style/images/image_upload.png";
				else {
					if(!file_exists("./upload/".$this->id))
						mkdir("./upload/".$this->id,0777,true);
					
					if (file_exists("./upload/".$this->id."/" . $_FILES["article"]["name"][$Type]))
						unlink("./upload/".$this->id."/" . $_FILES["article"]["name"][$Type]);
     				
					move_uploaded_file($_FILES["article"]["tmp_name"][$Type],
						"./upload/".$this->id."/" . $_FILES["article"]["name"][$Type]);
					
					return base_url()."upload/".$this->id."/".$_FILES["article"]["name"][$Type];
     			}
   		}
		else return base_url()."style/images/image_upload.png"; 
	}
	
	private function HandleAlias($Title) {
		$Alias = trim($Title);
		$Alias = mb_strtolower($Alias);
		
		$search = array('š','č','ž','đ','Ș', 'Ț', 'ş', 'ţ', 'Ş', 'Ţ', 'ș', 'ț', 'î', 'â', 'ă', 'Î', 'Â', 'Ă', 'ë', 'Ë');
		$replace = array('s','c','z','dz','s', 't', 's', 't', 's', 't', 's', 't', 'i', 'a', 'a', 'i', 'a', 'a', 'e', 'E');
		$Alias = str_ireplace($search, $replace, strtolower(trim($Alias)));
		$Alias = preg_replace('/[^\w\d\-\ ]/', '', $Alias);
		$Alias = preg_replace("/\W+/", "-", $Alias);
		$Alias = str_replace(' ', '-', $Alias);
		$Alias = str_replace('+','-',$Alias);
		
		$Alias = ($Alias[strlen($Alias)-1] == '-' ? $Alias = substr($Alias,0,strlen($Alias)-1) : $Alias ); 
		$Alias = ($Alias[0] == '-' ? $Alias = substr($Alias,1,strlen($Alias)-1) : $Alias ); 
		
		return $Alias;
	}
	
	public function GetUserContent($userId) {
		$this->db->select("c.*");
		$this->db->from("vs_content as c");
		$this->db->where("c.created_by",$userId);
		$this->db->order_by("c.id","DESC");
		$query = $this->db->get();
		
		return $query->result();
	}

	public function CreateArticle() {
		$article = new article();
		$this->ref_id = $article->id;
		
		$this->db->insert("vs_content",$this);
		$this->id = $this->db->insert_id();

		return $this->GetById($this->id);
	}
	
	public function GetById($contentId) {
		$this->db->select("c.*");
		$this->db->from("vs_content as c");
		$this->db->where("c.id",$contentId);
		$this->db->limit(1);
		$query = $this->db->get();
		
		$content = new content_model($query->row());
		$content->domains = $this->domain_model->GetByArticle($content->id);
		$content->tags = $this->tag_model->GetTags($content->id);
		
		return $content;
	}

	public function GetDrafts($userId) {
		$this->db->select("v.*");
		$this->db->from("vs_content as v");
		$this->db->where("v.created_by",$userId);
		$this->db->where("v.state",0);
		$this->db->order_by("v.id","DESC");
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function Update($article) {
		$Update = new content_model($article);
		$this->portal_model->AddToarticle($Update);
		$this->tag_model->AddTags($Update);
		
		if(isset($_FILES["article"]['name']['slika']))
			$Update->slika = $Update->HandleImage('slika');
			
		if(isset($_FILES["article"]['name']['slike'])) {
			foreach($_FILES["article"]['name']['slike'] as $File) {
				$Update->slika = $Update->HandleImage('slike');
			}
		}
		
		$this->db->where('id', $Update->id);
 		$this->db->update('vs_content', $Update);
		
		return $Update;
	}
	
	public function GetGalleryImages() {
		$this->db->select("g.*");
		$this->db->from("vs_gallery as g");
		$query = $this->db->get();
		
		return $query->result();
	}
}

class article extends CI_Model  {
	
	public $id;
	public $text;
	public $state;
	public $author_name;
	public $publish_up;
	public $publish_down;
	public $frontpage;
	
	function __construct($article = array()) {
		$this->text = (isset($article->text) ? $article->text : "");
		$this->state = (isset($article->state) ? $article->state : 0);
		$this->author_name = (isset($article->author_name) ? $article->author_name : $this->session->userdata("name"));
		$this->publish_up = (isset($article->publish_up) && $article->publish_down != "0000-00-00" ? $article->publish_up : date(" Y-d-m", time()));
		$this->publish_down = (isset($article->publish_down) && $article->publish_down != "0000-00-00" ? $article->publish_down : "");
		$this->frontpage = (isset($article->frontpage) ? $article->frontpage : 1);
		
		$this->id =  (isset($article->id) ? $article->id : $this->Create());
	}
	
	private function Create() {
		$this->db->insert("vs_articles",$this);
		$this->id = $this->db->insert_id();
		
		return $this->id;
	}
	
	
}