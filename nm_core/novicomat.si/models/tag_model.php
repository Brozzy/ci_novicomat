<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tag_model extends CI_Model {

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
			$Tag = trim($Tag);
			
			if($Tag != "" && $Tag != " ") {
				if(!$this->CheckIfTagExists($Tag))
					$this->Create($Tag);

				$Tag = $this->GetTag($Tag);
				
				if(!$this->CheckIfLinkExists($Prispevek->id,$Tag->id))
					$this->LinkTagAndVsebina($Prispevek->id,$Tag->id);
			}
		}
	}
	
	public function Create($Tag) {
		$Alias = str_replace('+','_',urlencode($Tag));
		$New = array("tag" => $Tag,"alias" => trim($Alias));
		$this->db->insert("vs_tags",$New);
		
		return $this->db->insert_id();
	}
	
	public function GetTag($Tag) {
		$this->db->select("t.*");
		$this->db->from("vs_tags as t");
		$this->db->where("t.tag",$Tag);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->row();
	}
	
	private function CheckIfTagExists($Tag) {
		$this->db->select("t.*");
		$this->db->from("vs_tags as t");
		$this->db->where("t.tag",$Tag);
		$this->db->limit(1);
		$query = $this->db->get();
		$Tag = $query->row();
		
		if(isset($Tag->id)) return true;
		else return false;
	}
	
	private function CheckIfLinkExists($PrispevekId,$TagId) {
		$this->db->select("tv.*");
		$this->db->from("vs_tags_vsebina as tv");
		$this->db->where("tv.id_tag",$TagId);
		$this->db->where("tv.id_vsebine",$PrispevekId);
		$this->db->limit(1);
		$query = $this->db->get();
		$Link = $query->row();
		
		if(isset($Link->id_tag)) return true;
		else return false;
	}
	
	private function LinkTagAndVsebina($PrispevekId,$TagId) {
		$Tags_Vsebina = array("id_tag" => $TagId,"id_vsebine" => $PrispevekId);
		$this->db->insert("vs_tags_vsebina",$Tags_Vsebina);
	}
	
	public function RemoveTagLink($PrispevekId,$TagId) {
		$this->db->delete('vs_tags_vsebina', array('id_tag' => $TagId, 'id_vsebine' => $PrispevekId)); 
	}
	
}

?>