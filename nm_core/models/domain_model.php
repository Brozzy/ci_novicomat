<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Domain_model extends CI_Model {

	function __construct() {
		parent::__construct();
	}
	
	public function GetCurrent() {
		$domain = preg_replace("/^www\./", "", $_SERVER['HTTP_HOST']);
		$domain = preg_replace("/^test\./", "", $_SERVER['HTTP_HOST']);
		
		$this->db->select("d.*");
		$this->db->from("vs_domains as d");
		$this->db->where("d.domain",$domain);
		$this->db->limit(1);
		$query = $this->db->get();
		$domain = $query->row();
		
		return $domain;
	}
	
	public function GetUserAproved($userId) {

		$this->db->select("d.*");
		$this->db->from("vs_domains as d");
		$this->db->join("vs_users_level as ul","ul.domain_id = d.id");
		$this->db->where("ul.user_id",$userId);
		$this->db->where("ul.level >",3);
		$this->db->group_by("d.id");
		$query = $this->db->get();

		return $query->result();
	}
	
	public function AddToArticle($article) {
		$this->db->delete('vs_domains_content', array('id_content' => $article->id)); 
		
		foreach($article->domains as $domainsd) {
			$this->db->insert("vs_domains_content",array("id_content" => $article->id, "id_portala" => $domainsd, "status" => $article->state));
		}
	}
	
	public function GetByArticle($articleId) {
		$this->db->select("d.*");
		$this->db->from("vs_domains as d");
		$this->db->join("vs_domains_content as dc","dc.content_id = d.id");
		$this->db->where("dc.content_id",$articleId);
		$query = $this->db->get();
		
		return $query->result();
	}

}

?>