<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vsebine_model extends CI_Model {

	public $id;
	public $title;
	public $title_url;
	public $fulltext;
	public $introtext;
	public $state;
	public $author_alias;
	public $video;
	public $slika;
	public $lokacija;
	public $tags;
	public $publish_up;
	public $publish_down;
	public $portali;
	public $created;
	public $created_by;
	public $frontpage;
	
	function __construct($Prispevek = array()) {
		parent::__construct();
		$this->id = (isset($Prispevek->id) ? $Prispevek->id : 0);
		$this->title = (isset($Prispevek->title) ? $Prispevek->title : "Nov prispevek");
		$this->title_url = (isset($Prispevek->title) ? $this->HandleAlias($Prispevek->title) : "");
		$this->introtext = (isset($Prispevek->introtext) ? $Prispevek->introtext : "");
		$this->fulltext = (isset($Prispevek->fulltext) ? $Prispevek->fulltext : "");
		$this->state = (isset($Prispevek->state) ? $Prispevek->state : 0);
		$this->author_alias = (isset($Prispevek->author_alias) ? $Prispevek->author_alias : "");
		$this->video = (isset($Prispevek->video) ? $Prispevek->video : "");
		$this->slika = (isset($Prispevek->slika) ? $Prispevek->slika : base_url()."style/images/image_upload.png" );
		$this->lokacija = (isset($Prispevek->lokacija) ? $Prispevek->lokacija : "");
		$this->portali = (isset($Prispevek->portali) ? $Prispevek->portali : array());
		$this->tags = (isset($Prispevek->tags) ? $Prispevek->tags : array());
		$this->publish_up = (isset($Prispevek->publish_up) && $Prispevek->publish_down != "0000-00-00" ? $Prispevek->publish_up : date(" Y-d-m", time()));
		$this->publish_down = (isset($Prispevek->publish_down) && $Prispevek->publish_down != "0000-00-00" ? $Prispevek->publish_down : "");
		$this->created_by = (isset($Prispevek->created_by) ? $Prispevek->created_by : $this->session->userdata("UserId"));
		$this->created = (isset($Prispevek->created) ? $Prispevek->created : date(" H:i:s", time()));
		$this->frontpage = (isset($Prispevek->frontpage) ? $Prispevek->frontpage : 0);
	}
	
	private function HandleImage($Type) {
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["Prispevek"]["name"][$Type]);
		$extension = end($temp);
		
		if ((($_FILES["Prispevek"]["type"][$Type] == "image/gif")
			|| ($_FILES["Prispevek"]["type"][$Type] == "image/jpeg")
			|| ($_FILES["Prispevek"]["type"][$Type] == "image/jpg")
			|| ($_FILES["Prispevek"]["type"][$Type] == "image/pjpeg")
			|| ($_FILES["Prispevek"]["type"][$Type] == "image/x-png")
			|| ($_FILES["Prispevek"]["type"][$Type] == "image/png"))
			&& in_array($extension, $allowedExts) && $this->id != 0) {

				if ($_FILES["Prispevek"]["error"][$Type] > 0)
					return base_url()."style/images/image_upload.png";
				else {
					if(!file_exists("./upload/".$this->id))
						mkdir("./upload/".$this->id,0777,true);
					
					if (file_exists("./upload/".$this->id."/" . $_FILES["Prispevek"]["name"][$Type]))
						unlink("./upload/".$this->id."/" . $_FILES["Prispevek"]["name"][$Type]);
     				
					move_uploaded_file($_FILES["Prispevek"]["tmp_name"][$Type],
						"./upload/".$this->id."/" . $_FILES["Prispevek"]["name"][$Type]);
					
					return base_url()."upload/".$this->id."/".$_FILES["Prispevek"]["name"][$Type];
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
	
	public function Get($UserId) {
		$this->db->select("v.*");
		$this->db->from("vs_vsebine as v");
		$this->db->where("v.state",3);
		$this->db->limit(40);
		$this->db->order_by("v.id","DESC");
		$query = $this->db->get();
		
		return $query->result();
	}

	public function CreatePrispevek() {
		$this->db->insert("vs_vsebine",$this);
		$this->id = $this->db->insert_id();
		
		return $this->GetById($this->id);
	}
	
	public function GetById($PrispevekId) {
		$this->db->select("p.*");
		$this->db->from("vs_vsebine as p");
		$this->db->where("p.id",$PrispevekId);
		$this->db->limit(1);
		$query = $this->db->get();
		
		$Prispevek = new Vsebine_model($query->row());
		$Prispevek->portali = $this->portal_model->GetByPrispevek($Prispevek->id);
		$Prispevek->tags = $this->tag_model->GetTags($Prispevek->id);
		
		return $Prispevek;
	}

	public function GetDrafts($UserId) {
		$this->db->select("v.*");
		$this->db->from("vs_vsebine as v");
		$this->db->where("v.created_by",$UserId);
		$this->db->where("v.state",0);
		$this->db->order_by("v.id","DESC");
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function Update($Prispevek) {
		$Update = new Vsebine_model($Prispevek);
		$this->portal_model->AddToPrispevek($Update);
		$this->tag_model->AddTags($Update);
		
		if(isset($_FILES["Prispevek"]['name']['slika']))
			$Update->slika = $Update->HandleImage('slika');
		
		$this->db->where('id', $Update->id);
 		$this->db->update('vs_vsebine', $Update);
		
		return $Update;
	}	
}