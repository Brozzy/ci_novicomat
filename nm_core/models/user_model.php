<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_Model {

	public $id;
	public $name;
	public $username;
	public $password;
	public $email;
	public $level;
    public $level_name;
	
	function __construct($user = array()) {
		parent::__construct();
		$this->id = (isset($user->id) ? $user->id : 0 );
		$this->name = (isset($user->name) ? $user->name : "" );
		$this->username = (isset($user->username) ? $user->username : "" );
		$this->password = (isset($user->password) ? $user->password : "" );
		$this->email = (isset($user->email) ? $user->email : "" );
		$this->level =  $this->GetUserLevel();
        $this->level_name = (isset($this->level) ? $this->GetLevelName() : 'uporabnik');
		//$this->domains = (isset($this->domains) ? $this->domains : array());
	}

    // PRIVATE
    private function GetLevelName() {
        switch($this->level) {
            case 1: return 'javno';
            case 2: return 'uporabnik';
            case 3: return 'avtor';
            case 4: return 'urednik';
            case 5: return 'založnik';
            case 6: return 'upravitelj';
            case 7: return 'administrator';
            default: return 'javno';
        }
    }

	private function GetUserLevel() {
		$this->load->model("media_model");
		$currentPortal = $this->media_model->GetCurrent();
        if($currentPortal == "local") return 7;
        $row = array();

		if(isset($currentPortal->id)) {
			$this->db->select("ul.level");
			$this->db->from("vs_users_level as ul");
			$this->db->where("ul.user_id",$this->id);
			$this->db->where("ul.media_id",$currentPortal->id);
			$this->db->limit(1);
			$query = $this->db->get();
			$row = $query->row();
		}
		
		return (isset($row->level) ? $row->level : 2);
	}

	private function GetCryptedPassword($plaintext, $salt = '', $encryption = 'md5-hex', $show_encrypt = false)
	{
		// Get the salt to use.
		$salt = $this->getSalt($encryption, $salt, $plaintext);

		// Encrypt the password.
		switch ($encryption)
		{
			case 'plain' :
				return $plaintext;

			case 'sha' :
				$encrypted = base64_encode(mhash(MHASH_SHA1, $plaintext));
				return ($show_encrypt) ? '{SHA}'.$encrypted : $encrypted;

			case 'crypt' :
			case 'crypt-des' :
			case 'crypt-md5' :
			case 'crypt-blowfish' :
				return ($show_encrypt ? '{crypt}' : '').crypt($plaintext, $salt);

			case 'md5-base64' :
				$encrypted = base64_encode(mhash(MHASH_MD5, $plaintext));
				return ($show_encrypt) ? '{MD5}'.$encrypted : $encrypted;

			case 'ssha' :
				$encrypted = base64_encode(mhash(MHASH_SHA1, $plaintext.$salt).$salt);
				return ($show_encrypt) ? '{SSHA}'.$encrypted : $encrypted;

			case 'smd5' :
				$encrypted = base64_encode(mhash(MHASH_MD5, $plaintext.$salt).$salt);
				return ($show_encrypt) ? '{SMD5}'.$encrypted : $encrypted;

			case 'aprmd5' :
				$length = strlen($plaintext);
				$context = $plaintext.'$apr1$'.$salt;
				$binary = $this->_bin(md5($plaintext.$salt.$plaintext));

				for ($i = $length; $i > 0; $i -= 16) {
					$context .= substr($binary, 0, ($i > 16 ? 16 : $i));
				}
				for ($i = $length; $i > 0; $i >>= 1) {
					$context .= ($i & 1) ? chr(0) : $plaintext[0];
				}

				$binary = $this->_bin(md5($context));

				for ($i = 0; $i < 1000; $i ++) {
					$new = ($i & 1) ? $plaintext : substr($binary, 0, 16);
					if ($i % 3) {
						$new .= $salt;
					}
					if ($i % 7) {
						$new .= $plaintext;
					}
					$new .= ($i & 1) ? substr($binary, 0, 16) : $plaintext;
					$binary = $this->_bin(md5($new));
				}

				$p = array ();
				for ($i = 0; $i < 5; $i ++) {
					$k = $i +6;
					$j = $i +12;
					if ($j == 16) {
						$j = 5;
					}
					$p[] = $this->_toAPRMD5((ord($binary[$i]) << 16) | (ord($binary[$k]) << 8) | (ord($binary[$j])), 5);
				}

				return '$apr1$'.$salt.'$'.implode('', $p).$this->_toAPRMD5(ord($binary[11]), 3);

			case 'md5-hex' :
			default :
				$encrypted = ($salt) ? md5($plaintext.$salt) : md5($plaintext);
				return ($show_encrypt) ? '{MD5}'.$encrypted : $encrypted;
		}
	}
	
	private function getSalt($encryption = 'md5-hex', $seed = '', $plaintext = '')
	{
		// Encrypt the password.
		switch ($encryption)
		{
			case 'crypt' :
			case 'crypt-des' :
				if ($seed) {
					return substr(preg_replace('|^{crypt}|i', '', $seed), 0, 2);
				} else {
					return substr(md5(mt_rand()), 0, 2);
				}
				break;

			case 'crypt-md5' :
				if ($seed) {
					return substr(preg_replace('|^{crypt}|i', '', $seed), 0, 12);
				} else {
					return '$1$'.substr(md5(mt_rand()), 0, 8).'$';
				}
				break;

			case 'crypt-blowfish' :
				if ($seed) {
					return substr(preg_replace('|^{crypt}|i', '', $seed), 0, 16);
				} else {
					return '$2$'.substr(md5(mt_rand()), 0, 12).'$';
				}
				break;

			case 'ssha' :
				if ($seed) {
					return substr(preg_replace('|^{SSHA}|', '', $seed), -20);
				} else {
					return mhash_keygen_s2k(MHASH_SHA1, $plaintext, substr(pack('h*', md5(mt_rand())), 0, 8), 4);
				}
				break;

			case 'smd5' :
				if ($seed) {
					return substr(preg_replace('|^{SMD5}|', '', $seed), -16);
				} else {
					return mhash_keygen_s2k(MHASH_MD5, $plaintext, substr(pack('h*', md5(mt_rand())), 0, 8), 4);
				}
				break;

			case 'aprmd5' :
				/* 64 characters that are valid for APRMD5 passwords. */
				$APRMD5 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

				if ($seed) {
					return substr(preg_replace('/^\$apr1\$(.{8}).*/', '\\1', $seed), 0, 8);
				} else {
					$salt = '';
					for ($i = 0; $i < 8; $i ++) {
						$salt .= $APRMD5 {
							rand(0, 63)
							};
					}
					return $salt;
				}
				break;

			default :
				$salt = '';
				if ($seed) {
					$salt = $seed;
				}
				return $salt;
				break;
		}
	}
	
	private function _bin($hex)
	{
		$bin = '';
		$length = strlen($hex);
		for ($i = 0; $i < $length; $i += 2) {
			$tmp = sscanf(substr($hex, $i, 2), '%x');
			$bin .= chr(array_shift($tmp));
		}
		return $bin;
	}
	
	private function _toAPRMD5($value, $count)
	{
		/* 64 characters that are valid for APRMD5 passwords. */
		$APRMD5 = './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

		$aprmd5 = '';
		$count = abs($count);
		while (-- $count) {
			$aprmd5 .= $APRMD5[$value & 0x3f];
			$value >>= 6;
		}
		return $aprmd5;
	}

    // PUBLIC
    public function Create($username, $Name, $Email, $Password, $SaltPassword) {
        $New = array(
            "name" => $Name,
            "username" => $username,
            "password" => $Password,
            "password_SALT" => $SaltPassword,
            "email" => $Email
        );

        $this->db->insert("vs_users",$New);
        //return $this->GetById($this->db->insert_id());
        //does not return any values only works as a void function
    }

    public function GetByUsername($username) {
        $this->db->select("*");
        $this->db->from("vs_users");
        $this->db->where("username",$username);
        $this->db->limit(1);
        $query = $this->db->get();
        $user = new user_model($query->row());

        return $user;
    }

    public function GetByEmail($email)
    {
        $this->db->select("*");
        $this->db->from("vs_users");
        $this->db->where("email",$email);
        $this->db->limit(1);
        $query = $this->db->get();
        $user = new user_model($query->row());

        return $user;
    }

    public function UpdatePassword($token, $password, $password_SALT)
    {
        $this->db->select("id");
        $this->db->from("vs_token");
        $this->db->join("vs_users", "vs_users.id = vs_token.user_id");
        $this->db->where("token",$token);
        $this->db->limit(1);

        $query = $this->db->get();
        $query = $query->row();

        $update = array(
            "id" => $query->id,
            "password" => $password,
            "password_SALT" => $password_SALT
        );

        $this->db->where("id", $query->id);
        $this->db->update("vs_users",$update);



    }

    public function CheckPassword($user,$password) {
        $parts	= explode( ':', $user->password );
        $crypt	= $parts[0];
        $salt	= @$parts[1];

        $testcrypt = $this->GetCryptedPassword($password, $salt);
        if ($crypt == $testcrypt) {
            return true;
        } else {
            return false;
        }
    }

    public function checkEmail($emailCheck)
    {

        $this->db->select("u.id, u.name, u.username, u.email");
        $this->db->from("vs_users as u");
        $this->db->where("u.email", $emailCheck);
        $this->db->limit(1);
        $query = $this->db->get();
        $user = $query->row();
        if(isset($user->id))
            return  $user;
        else
            return false;
    }

    public function Get($criteria = array()) {
        $this->db->select("u.*");
        $this->db->from("vs_users as u");
        $this->db->where("u.".$criteria['criteria'],$criteria["value"]);
        if(isset($criteria['limit']))
            $this->db->limit($criteria['limit']);
        $query = $this->db->get();

        $user = new user_model($query->row());

        return $user;
    }
}