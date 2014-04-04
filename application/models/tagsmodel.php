<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class TagsModel extends CI_Model {

	public function GetTags($PrispevekId) {
		$this->db->select("t.*");
		$this->db->from("vs_tags as t");
		$this->db->join("vs_tags_vsebina as tv","tv.id_tag = t.id");
		$this->db->where("tv.id_vsebine",$PrispevekId);
		$query = $this->db->get();
		
		return $query->result();
	}

	public function AddTags($Prispevek) {
		$Tags = explode(',',$Prispevek->tags);
		foreach($Tags as $Tag) {
			if($Tag != "" && $Tag != " ") {
			$Tag = trim($Tag);
			if($this->CheckIfTagExists($Tag));
				$this->db->insert("vs_tags",array("tag" => $Tag,"alias" => trim(urlencode($Tag))));
			}
		}
	}
	
	private function CheckIfTagExists($Tag) {
		$this->db->select("t.*");
		$this->db->from("vs_tags as t");
		$this->db->where("t.tag",$Tag);
		$this->db->limit(1);
		$query = $this->db->get();
		$Tag = $query->row();
		
		if(isset($Tag->id)) return false;
		else return true;
	}
	
}

?>