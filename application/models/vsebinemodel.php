<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VsebineModel extends CI_Model {
	
	/* bolj ali manj vse lastnosti vsebine */
	public $id;
	public $title;
	public $title_url;
	public $introtext;
	public $fulltext;
	public $state;
	public $author;
	public $video;
	public $slika;
	public $lokacija;
	public $site_id;
	public $tags;
	public $frontpage;
	public $created;
	public $created_by;
	
	/* ko kličemo konstruktor naj se nastavijo vse lastnosti na privzeto vrednost */
	function __construct() {
		parent::__construct();
		$this->title = "Nov prispevek";
		$this->title_url = "";
		$this->introtext = "";
		$this->fulltext = "";
		$this->state = 0;
		$this->author = "";
		$this->video = "";
		$this->slika = "";
		$this->lokacija = 0;
		$this->site_id = 0;
		$this->frontpage = 0;
		$this->tags = array();
		$this->created_by = $this->session->userdata("UserId");
		$this->created = date(" H:i:s", time());
	}
	
	/* funkcija ki ustvari nov prispevek */
	public function CreatePrispevek() {
		/* ker v konstruktorju že nastavimo privzete lasnosti lahko v bazo shranimo $this ki vsebuje npr. $this->title == "Nov prispevek */
		$this->db->insert("vs_vsebine",$this);
		/* po vnosu vzamemo njegov auto increment id */
		$this->id = $this->db->insert_id();
		
		/* naredimo nov osnutek */
		$Draft = new VsebineDraft();
		/* potrebujemo id od že nastalega prispevka in string, ki nam pove za kakšen tip gre (npr. "lokacija", "prispevek"..) */
		$Draft->Create($this->id,"prispevek");
		
		/* vrnemo novo nastali prispevek */
		return $this->GetById($this->id);
	}
	
	/* vrnemo prispevek po njegovem id-ju. */
	public function GetById($PrispevekId) {
		$this->db->select("p.*");
		$this->db->from("vs_vsebine as p");
		$this->db->where("p.id",$PrispevekId);
		$this->db->limit(1);
		$query = $this->db->get();
		
		$Prispevek = new VsebineModel();
		$Prispevek = $query->row();
		
		/* za prispevek je potrebno pogledati še v vs_tags_vsebina in iz tabele pridobiti vse ključne besede */
		$Prispevek->tags = $this->GetTags($Prispevek->id);
		
		return $Prispevek;
	}
	
	/* funkcija, ki za določen prispevek vrne vse ključne besede */
	private function GetTags($PrispevekId) {
		$this->db->select("t.tag");
		$this->db->from("vs_tags as t");
		$this->db->join("vs_tags_vsebina as tv","tv.id_tag = t.id");
		$this->db->where("tv.id_vsebine",$PrispevekId);
		$query = $this->db->get();
		
		return $query->result();
	}
	
	/* funkcija, ki vrne vse osnutke določenega uporabnika */
	public function GetUserDrafts($UserId) {
		$this->db->select("o.*,p.title");
		$this->db->from("vs_osnutki as o");
		$this->db->join("vs_vsebine as p","o.prispevek_id = p.id");
		$this->db->where("o.user_id",$UserId);
		$this->db->order_by("o.created","DESC");
		$query = $this->db->get();
		
		return $query->result();
	}
	
}

/* Razred za osnutke, ki deduje od vsebin. */
class VsebineDraft extends VsebineModel {
	
	public $user_id;
	public $prispevek_id;
	public $type;
	public $status;
	
	function __construct() {
		parent::__construct();
		$this->user_id = $this->created_by;
		$this->prispevek_id = $this->id;
	}
	
	public function Create($PrispevekId,$Type) {
		$this->type = $this->ResolveType($Type);	
		
		$NewDraft = array(
			"user_id" => $this->user_id,
			"prispevek_id" => $PrispevekId,
			"type" => $this->type,
			"status" => 0
		);
		
		$this->db->insert("vs_osnutki",$NewDraft);
	}
	
	private function ResolveType($Type) {
		switch($Type) {
			case "prispevek":
				return 1;
			case "lokacija":
				return 2;
			case "dogodek":
				return 3;
			case "slika":
				return 4;
			default: return 0;
		}
	}
}