<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model {
	
	public function GetByLogin($Username,$Password) {
		$this->db->select("id,name");
		$this->db->from("vs_users");
		$this->db->where("username",$Username);
		$this->db->where("password",$Password);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->row();
	}
	
	public function GetById($UserId) {
		$this->db->select("*");
		$this->db->from("vs_users");
		$this->db->where("id",$UserId);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->row();
	}
	
	public function Create($Username, $Name, $Email, $Password) {
		$New = array(
			"name" => $Name,
			"username" => $Username,
			"password" => $Password,
			"email" => $Email
		);
		
		$this->db->insert("vs_users",$New);
		return $this->GetById($this->db->insert_id());
	}
	
	public function GetByUsername() {
		
	}
}