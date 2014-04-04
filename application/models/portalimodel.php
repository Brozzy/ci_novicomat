<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PortaliModel extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	public function GetCurrent() {
		$domain = preg_replace("/^www\./", "", $_SERVER['HTTP_HOST']);
		$domain = preg_replace("/^test\./", "", $_SERVER['HTTP_HOST']);
		
		$this->db->select("p.*");
		$this->db->from("vs_portali as p");
		$this->db->where("p.domena",$domain);
		$this->db->limit(1);
		$query = $this->db->get();
		$Portal = $query->row();
		
		return $Portal;
	}
	
	public function GetUserAproved($UserId) {

		$this->db->select("p.id,p.domena");
		$this->db->from("vs_portali as p");
		$this->db->join("vs_users_level as ul","ul.portal_id = p.id");
		$this->db->where("p.tip",1);
		$this->db->or_where("ul.user_id",$UserId);
		$this->db->where("ul.level >",3);
		$this->db->group_by("p.id");
		$query = $this->db->get();

		return $query->result();
	}
	
	public function AddToPrispevek($Prispevek) {
		$this->db->delete('vs_portali_vsebine', array('id_vsebine' => $Prispevek->id)); 
		
		foreach($Prispevek->portali as $PortalId) {
			$this->db->insert("vs_portali_vsebine",array("id_vsebine" => $Prispevek->id, "id_portala" => $PortalId, "status" => $Prispevek->state));
		}
	}
	
	public function GetByPrispevek($PrispevekId) {
		$this->db->select("p.*");
		$this->db->from("vs_portali as p");
		$this->db->join("vs_portali_vsebine as pv","pv.id_portala = p.id");
		$this->db->where("pv.id_vsebine",$PrispevekId);
		$query = $this->db->get();
		
		return $query->result();
	}

}

?>