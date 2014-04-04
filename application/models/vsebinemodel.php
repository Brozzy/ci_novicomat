<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VsebineModel extends CI_Model {

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
	public $portali;
	public $tags;
	public $publish_up;
	public $publish_down;
	public $created;
	public $created_by;
	public $frontpage;
	
	function __construct($Prispevek = array()) {
		parent::__construct();
		$this->id = (isset($Prispevek->id) ? $Prispevek->id : 0);
		$this->title = (isset($Prispevek->title) ? $Prispevek->title : "Nov prispevek");
		$this->title_url = (isset($Prispevek->title_url) ? $Prispevek->title_url : "");
		$this->introtext = (isset($Prispevek->introtext) ? $Prispevek->introtext : "");
		$this->fulltext = (isset($Prispevek->fulltext) ? $Prispevek->fulltext : "");
		$this->state = (isset($Prispevek->state) ? $Prispevek->state : 0);
		$this->author_alias = (isset($Prispevek->author_alias) ? $Prispevek->author_alias : "");
		$this->video = (isset($Prispevek->video) ? $Prispevek->video : "");
		$this->slika = (isset($Prispevek->slika) && $Prispevek->slika != "" ? $Prispevek->slika : base_url()."style/images/image_upload.png");
		$this->lokacija = (isset($Prispevek->lokacija) ? $Prispevek->lokacija : "");
		$this->portali = (isset($Prispevek->portali) ? $Prispevek->portali : array());
		$this->tags = (isset($Prispevek->tags) ? $Prispevek->tags : array());
		$this->publish_up = (isset($Prispevek->publish_up) ? $Prispevek->publish_up : date(" H:i:s", time()));
		$this->publish_down = (isset($Prispevek->publish_down) && $Prispevek->publish_down != "0000-00-00" ? $Prispevek->publish_down : "");
		$this->created_by = (isset($Prispevek->created_by) ? $Prispevek->created_by : $this->session->userdata("UserId"));
		$this->created = (isset($Prispevek->created) ? $Prispevek->created : date(" H:i:s", time()));
		$this->frontpage = (isset($Prispevek->frontpage) ? $Prispevek->frontpage : 0);
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
		
		$Prispevek = new VsebineModel($query->row());
		$Prispevek->tags = $this->TagsModel->GetTags($Prispevek->id);
		$Prispevek->portali = $this->PortaliModel->GetByPrispevek($Prispevek->id);
		
		return $Prispevek;
	}

	public function GetDrafts($UserId) {
		$this->db->select("v.*");
		$this->db->from("vs_vsebine as v");
		$this->db->where("v.created_by",$UserId);
		$this->db->where("v.state",0);
		$this->db->order_by("v.created","DESC");
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function Update($Prispevek) {
		$Update = new VsebineModel($Prispevek);
		$this->PortaliModel->AddToPrispevek($Update);
		$this->TagsModel->AddTags($Update);
		
		$this->db->where('id', $Update->id);
 		$this->db->update('vs_vsebine', $Update);
		
		return $Update;
	}	
}