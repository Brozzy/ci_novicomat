<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class content_model extends CI_Model {

	public $id;
	public $name;
	public $slug;
	public $description;
	public $ref_id;
	public $type;
	public $created;
	public $created_by;
	public $updated;
	public $updated_by;
	public $author;
	public $owner;
	public $domains;
	public $tags;
	public $attachments;
	
	function __construct($content = array()) {
		parent::__construct();
		
		$this->id = (isset($content->id) ? $content->id : 0);
		$this->name = (isset($content->name) ? $content->name : "Nova vsebina");
		$this->slug = (isset($content->name) ? $this->GetAlias($this->name) : "nova-vsebina");
		$this->description = (isset($content->description) ? $content->description : "");
		$this->type = (isset($content->type) ? $content->type : 'content');
		$this->created_by = (isset($content->created_by) ? $content->created_by : $this->session->userdata("userId"));
		$this->created = (isset($content->created) ? $content->created : date('Y-m-d H:i:s', time() ));
		$this->updated = (isset($content->updated) ? $content->updated : "0000-00-00");
		$this->author = (isset($content->created_by) ? $this->user_model->Get(array("criteria" => "id", "value" => $this->created_by, "limit" => 1)) : "");
		$this->owner = (isset($content->created_by) ? $this->CheckOwner() : FALSE);
		$this->ref_id = (isset($content->ref_id) ? $content->ref_id : 0);
		$this->tags = (isset($content->tags) ? $this->HandleTags($content->tags) : $this->GetTags());
	}
	
	private function HandleTags($tags) {
		$tags = explode(',',$tags);
		foreach($tags as $tag) {
			$tag = trim($tag);
			if($tag != "" && $tag != " ") {
				$tag_id = $this->CheckIfTagsExists($tag);
				$this->CheckIfTagLinked($tag_id);
			}
		}
	}
	
	private function GetTags() {
		$this->db->select("t.name");
		$this->db->from("vs_tags as t");
		$this->db->join("vs_tags_content as tc","tc.tag_id = t.id");
		$this->db->where("tc.content_id",$this->id);
		$query = $this->db->get();
		$tags = array();
		
		foreach($query->result() as $tag) array_push($tags,$tag->name);
		
		return implode(',',$tags);
	}
	
	private function CheckIfTagLinked($tag_id) {
		$this->db->select("tc.id");
		$this->db->from("vs_tags_content as tc");
		$this->db->where("tc.content_id",$this->id);
		$this->db->where("tc.tag_id",$tag_id);
		$this->db->limit(1);
		$query = $this->db->get();
		$selected = $query->row();
		
		if(!isset($selected->id))
			$this->db->insert("vs_tags_content",array("tag_id" => $tag_id, "content_id" => $this->id));
	}
	
	private function CheckIfTagsExists($tag) {
		$this->db->select("t.id");
		$this->db->from("vs_tags as t");
		$this->db->where("t.name",$tag);
		$this->db->limit(1);
		$query = $this->db->get();
		$selected = $query->row();
		
		if(isset($selected->id))
			return $selected->id;
		else {
			$this->db->insert("vs_tags",array("name" => $tag, "alias" => $this->CreateSlug($tag)));
			return $this->db->insert_id();
		}
	}
	
	private function CreateSlug($name) {
		$string = strtolower($name);    

		$string = preg_replace("/[\/\.]/", " ", $string);
		$string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
		$string = preg_replace("/[\s-]+/", " ", $string);
		$string = preg_replace("/[\s_]/", '-', $string);
		$string = substr($string, 0, 100);

		return $string; 
	}
	
	public function CreateOrUpdate() {
		$content = array(
			"name" => $this->name,
			"description" => $this->description,
			"type" => $this->type,
			"created_by" => $this->created_by,
			"updated" => $this->updated,
			"updated_by" => $this->updated_by,
			"ref_id" => $this->ref_id
		);
		
		if($this->id > 0) {
			$this->db->where("id",$this->id);
			$this->db->update("vs_content",$content);
		}
		else {
			$this->db->insert("vs_content",$content);
			$this->id = $this->db->insert_id();
		}
	}
	
	private function CheckOwner() {
		return ($this->created_by == $this->session->userdata("userId") ? TRUE : FALSE);
	}
	
	protected function image_resize($src, $dst, $width, $height, $crop=0){

		if(!list($w, $h) = getimagesize($src)) return "Unsupported picture type!";

		$type = strtolower(substr(strrchr($src,"."),1));
		if($type == 'jpeg') $type = 'jpg';
		switch($type){
			case 'bmp': $img = imagecreatefromwbmp($src); break;
			case 'gif': $img = imagecreatefromgif($src); break;
			case 'jpg': $img = imagecreatefromjpeg($src); break;
			case 'png': $img = imagecreatefrompng($src); break;
			default : return "Unsupported picture type!";
		}

		// resize
		if($crop){
			if($w < $width or $h < $height) return "Picture is too small!";
			$ratio = max($width/$w, $height/$h);
			$h = $height / $ratio;
			$x = ($w - $width / $ratio) / 2;
			$w = $width / $ratio;
		}
		else{
			if($w < $width and $h < $height) return "Picture is too small!";
			$ratio = min($width/$w, $height/$h);
			$width = $w * $ratio;
			$height = $h * $ratio;
			$x = 0;
		}

		$new = imagecreatetruecolor($width, $height);

		// preserve transparency
		if($type == "gif" or $type == "png"){
			imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
			imagealphablending($new, false);
			imagesavealpha($new, true);
		}

		imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

		switch($type){
			case 'bmp': imagewbmp($new, $dst); break;
			case 'gif': imagegif($new, $dst); break;
			case 'jpg': imagejpeg($new, $dst); break;
			case 'png': imagepng($new, $dst); break;
		}
		return true;
	}
	
	private function HandleImage($Type) {
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$temp = explode(".", $_FILES["article"]["name"][$Type]);
		$extension = end($temp);
		
		if ((($_FILES["article"]["type"][$Type] == "image/gif")
			|| ($_FILES["article"]["type"][$Type] == "image/jpeg")
			|| ($_FILES["article"]["type"][$Type] == "image/jpg")
			|| ($_FILES["article"]["type"][$Type] == "image/pjpeg")
			|| ($_FILES["article"]["type"][$Type] == "image/x-png")
			|| ($_FILES["article"]["type"][$Type] == "image/png"))
			&& in_array($extension, $allowedExts) && $this->id != 0) {

				if ($_FILES["article"]["error"][$Type] > 0)
					return base_url()."style/images/image_upload.png";
				else {
					if(!file_exists("./upload/".$this->id))
						mkdir("./upload/".$this->id,0777,true);
					
					if (file_exists("./upload/".$this->id."/" . $_FILES["article"]["name"][$Type]))
						unlink("./upload/".$this->id."/" . $_FILES["article"]["name"][$Type]);
     				
					move_uploaded_file($_FILES["article"]["tmp_name"][$Type],
						"./upload/".$this->id."/" . $_FILES["article"]["name"][$Type]);
					
					return base_url()."upload/".$this->id."/".$_FILES["article"]["name"][$Type];
     			}
   		}
		else return base_url()."style/images/image_upload.png"; 
	}
	
	private function GetAlias($Title) {
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
	
	public function GetUserContent($userId) {
		$this->db->select("c.*");
		$this->db->from("vs_content as c");
		$this->db->where("c.created_by",$userId);
		$this->db->where("c.type","article");
		$this->db->order_by("c.id","DESC");
		$query = $this->db->get();
		$contents = array();
		
		foreach($query->result() as $content) 
			array_push($contents,new content_model($content));

		
		return (object) $contents;
	}
	
	public function GetById($content_id,$type = "article") {
		$this->db->select("ref.*,c.*");
		$this->db->from("vs_content as c");
		$this->db->join('vs_'.$type.'s as ref','c.ref_id = ref.id');
		$this->db->where("c.id",$content_id);
		$this->db->limit(1);
		$query = $this->db->get();
		$content = $query->row();
		
		if(isset($content->type)) {
			switch($content->type) {
				case "article":
					$content = new article($query->row());
					break;
				case "image":
					$content = new image($query->row());
					break;
				case "event":
					$content = new event($query->row());
					break;
				default:
					break;
			}
		}
		
		return $content;
	}
	
	protected function CreateOrUpdateContentAsoc($content_id, $ref_id, $correlation) {
		$this->db->select("cc.id");
		$this->db->from("vs_content_content as cc");
		$this->db->where("cc.content_id",$content_id);
		$this->db->where("cc.ref_content_id",$ref_id);
		$this->db->where("cc.correlation",$correlation);
		$this->db->limit(1);
		$query=$this->db->get();
		$cc = $query->row();
		
		if(!isset($cc->id))
		$this->db->insert("vs_content_content",array("content_id" => $content_id, "ref_content_id" => $ref_id, "correlation" => $correlation));
	}
	
	protected function disect_image($tmp_name, $file) {
		$dir2 = "upload/images/thumbnails/".$this->id;
		$dir3 = "upload/images/300_300/".$this->id;
		$dir4 = "upload/images/500_500/".$this->id;

		$target2 = $dir2."/".basename($file);
		$target3 = $dir3."/".basename($file);
		$target4 = $dir4."/".basename($file);

		if(!is_dir($dir2)) mkdir($dir2,0777);
		if(!is_dir($dir3)) mkdir($dir3,0777);
		if(!is_dir($dir4)) mkdir($dir4,0777);
		
		$this->image_resize($tmp_name, $target2, 100, 100);
		$this->image_resize($tmp_name, $target3, 300, 300);
		$this->image_resize($tmp_name, $target4, 500, 500);
	}
	
	protected function CheckIfExists($url,$loop = 1) {
		if(file_exists($url)) {
			$url .= "_".$loop;
			$this->CheckIfExists($url,$loop+1);
		}
		else return $url;
	}

	protected function GetHeaderImage() {
		$this->db->select("cc.ref_content_id");
		$this->db->from("vs_content_content as cc");
		$this->db->where("cc.content_id",$this->id);
		$this->db->where("cc.correlation","header-image");
		$this->db->limit(1);
		$query = $this->db->get();
		$content = $query->row();
		
		if(isset($content->ref_content_id))
			$content = $this->GetById($content->ref_content_id,"image");
		
		$image = new image($content);
		return $image;
	}
	
	protected function HandleHeaderImage() {
		$image = new image();
		$image->header = true;
		$image->asoc_id = $this->id;
		$image->CreateOrUpdate();
	}
}

class article extends content_model  {
	
	public $text;
	public $state;
	public $author_name;
	public $image;
	
	public $publish_up;
	public $publish_down;
	public $frontpage;
	public $attachments;
	
	function __construct($article = array()) {
		parent::__construct($article);
		parent::CreateOrUpdate();
		
		$this->text = (isset($article->text) ? $article->text : "");
		$this->state = (isset($article->state) ? $article->state : 0);
		$this->author_name = (isset($article->author_name) ? $article->author_name : $this->session->userdata("name"));
		$this->publish_up = (isset($article->publish_up) && $article->publish_down != "0000-00-00" ? $article->publish_up : date(" Y-d-m", time()));
		$this->publish_down = (isset($article->publish_down) && $article->publish_down != "0000-00-00" ? $article->publish_down : "");
		$this->frontpage = (isset($article->frontpage) ? $article->frontpage : 1);
		$this->type = "article";
		$this->image = (isset($_FILES["content"]["name"]["image"]) ? parent::HandleHeaderImage() : parent::GetHeaderImage() );
		$this->attachments = (isset($article->attachments) ? $article->attachments : $this->GetAttachments());
	}

	public function CreateOrUpdate() {
		$article = array(
			"text" => $this->text,
			"state" => $this->state,
			"author_name" => $this->author_name,
			"publish_up" => $this->publish_up,
			"publish_down" => $this->publish_down,
			"frontpage" => $this->frontpage
		);
		
		if($this->ref_id > 0) {
			$this->db->where("id",$this->ref_id);
			$this->db->update("vs_articles",$article);
		}
		else {
			$this->db->insert("vs_articles",$article);
			$this->ref_id = $this->db->insert_id();
		}
		
		parent::CreateOrUpdate();
	}
	
	private function GetAttachments() {
		$this->db->select("cc.ref_content_id, cc.correlation");
		$this->db->from("vs_content_content as cc");
		$this->db->where("cc.content_id",$this->id);
		$this->db->where("cc.correlation","image");
		$this->db->or_where("cc.correlation","video");
		$this->db->or_where("cc.correlation","location");
		$this->db->or_where("cc.correlation","event");
		$query = $this->db->get();
		$attachments = array();
		
		foreach($query->result() as $attachment) {
			$content = $this->GetById($attachment->ref_content_id, $attachment->correlation);
			array_push($attachments,$content);
		}

		return (object) $attachments;
	}
}

class image extends content_model {
	public $url;
	public $format;
	public $thumbnail;
	public $medium;
	public $large;
	public $asoc_id;
	public $header;
	
	function __construct($image = array()) {
		parent::__construct($image);
		parent::CreateOrUpdate();
		
		$this->type = "image";
		$this->url = (isset($image->url) ? $image->url : base_url()."style/images/image_upload.png" );
		$this->large = (isset($image->url) ? $this->GetDiferrentSize("500_500") : base_url()."style/images/image_upload.png" );
		$this->medium = (isset($image->url) ? $this->GetDiferrentSize("300_300") : base_url()."style/images/image_upload.png" );
		$this->thumbnail = (isset($image->url) ? $this->GetDiferrentSize("thumbnails") : base_url()."style/images/image_upload.png" );
		$this->asoc_id = (isset($image->asoc_id) ? $image->asoc_id : 0 );
		$this->header = (isset($image->header) ? $image->header : false );
		
		if(isset($_FILES['content']['name']["image"]))
			$this->url = $this->HandleUpload();
			
		$this->format = (isset($image->format) ? $image->format : $this->GetFormat() );
	}
	
	private function GetDiferrentSize($size = "300_300") {
		$url = explode('/',$this->url);
		$url[2] = $size;
		$url = implode('/',$url);
		
		if(file_exists($url))
			return $url;
		else {
			switch($size) {
				case "thumbnails":
					return $this->GetDiferrentSize("300_300");
				case "300_300":
					return $this->GetDiferrentSize("500_500");
				case "500_500":
					return $this->url;
				default:
					return "chuck norris?";
			}
		}
	}
	
	private function GetFormat() {
		$format = explode('.',$this->url);
		return strtolower(end($format));
	}
	
	private function HandleUpload() {
		$dir = "upload/images/full_size/".$this->id;
		if(!is_dir($dir)) mkdir($dir,0777);
		
		$target = $dir."/".basename( $_FILES['content']['name']["image"]);
		move_uploaded_file($_FILES['content']['tmp_name']["image"], $target);

		parent::disect_image($target, $_FILES['content']['name']['image']);
		return $target;
	}
	
	public function CreateOrUpdate() {
		$image = array(
			"url" => $this->url,
			"format" => $this->format
		);
		
		if($this->ref_id > 0) {
			$this->db->where("id",$this->ref_id);
			$this->db->update("vs_images",$image);
		}
		else {
			$this->db->insert("vs_images",$image);
			$this->ref_id = $this->db->insert_id();
		}
		
		if($this->asoc_id > 0) {
			$header_image = ($this->header == true ? "header-image" : "image");
			parent::CreateOrUpdateContentAsoc($this->asoc_id, $this->id, $header_image);
		}
		
		parent::CreateOrUpdate();
	}
	
}

class event extends content_model {
	public $start_date;
	public $end_date;
	public $fee;
	public $event_type;
	public $image;
	public $asoc_id;
	
	function __construct($event = array()) {
		parent::__construct($event);
		parent::CreateOrUpdate();
		
		$this->start_date = (isset($event->start_date) ? $event->start_date : date('Y-m-d H:i:s', time()) );
		$this->end_date = (isset($event->end_date) ? $event->end_date : date('0000-00-00 00:00:00', time()) );
		$this->fee = (isset($event->fee) ? $event->fee : 0 );
		$this->asoc_id = (isset($event->asoc_id) ? $event->asoc_id : 0 );
		$this->event_type = (isset($event->event_type) ? $event->event_type : "" );
		$this->image = (isset($_FILES["content"]["name"]["image"]) ? parent::HandleHeaderImage() : parent::GetHeaderImage() );
	}
	
	public function CreateOrUpdate() {
		$event = array(
			"start_date" => $this->start_date,
			"end_date" => $this->end_date,
			"fee" => $this->fee,
			"type" => $this->event_type
		);
		
		if($this->ref_id > 0) {
			$this->db->where("id",$this->ref_id);
			$this->db->update("vs_events",$event);
		}
		else {
			$this->db->insert("vs_events",$event);
			$this->ref_id = $this->db->insert_id();
		}
		
		if($this->asoc_id > 0) {
			parent::CreateOrUpdateContentAsoc($this->asoc_id, $this->id, "event");
		}
		
		parent::CreateOrUpdate();
	}
}

class location extends content_model {
	public $post_number;
	public $house_number;
	public $country;
	public $region;
	public $city;
	public $street_village;
	public $asoc_id;
	
	function __construct($location = array()) {
		parent::__construct($location);
		parent::CreateOrUpdate();
		
		$this->country = (isset($location->country) ? $location->country : "Slovenija" );
		$this->region = (isset($location->region) ? $location->region : "" );
		$this->city = (isset($location->city) ? $location->city : "" );
		$this->street_village = (isset($location->street_village) ? $location->street_village : "" );
		$this->post_number = (isset($location->post_number) ? $location->post_number : "" );
		$this->house_number = (isset($location->house_number) ? $location->house_number : "" );
		$this->asoc_id = (isset($location->asoc_id) ? $location->asoc_id : 0 );
	}
	
	public function CreateOrUpdate() {
		$location = array(
			"country" => $this->country,
			"region" => $this->region,
			"city" => $this->city,
			"street_village" => $this->street_village,
			"post_number" => $this->post_number,
			"house_number" => $this->house_number
		);
		
		if($this->ref_id > 0) {
			$this->db->where("id",$this->ref_id);
			$this->db->update("vs_locations",$location);
		}
		else {
			$this->db->insert("vs_locations",$location);
			$this->ref_id = $this->db->insert_id();
		}
		
		if($this->asoc_id > 0) {
			parent::CreateOrUpdateContentAsoc($this->asoc_id, $this->id, "location");
		}
		
		parent::CreateOrUpdate();
	}
}