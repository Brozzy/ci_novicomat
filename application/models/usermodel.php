<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class UserModel extends CI_Model {
	
	public function Get($Username,$Password) {
		$this->db->select("*");
		$this->db->from("j3_users");
		$this->db->where("username",$Username);
		$this->db->where("password",$Password);
		$this->db->limit(1);
		$query = $this->db->get();
		
		return $query->row();
	}
}