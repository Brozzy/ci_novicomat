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
	public $tags;
	
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
        $this->db->delete("vs_tags_content",array("content_id" => $this->id));

		$tags = explode(',',$tags);
		foreach($tags as $tag) {
			$tag = trim($tag);
			if($tag != "" && $tag != " " && strlen($tag) > 2) {
				$tag_id = $this->CheckIfTagsExists($tag);
                $this->db->insert("vs_tags_content",array("tag_id" => $tag_id, "content_id" => $this->id));
			}
		}

        return true;
	}
	
	private function GetTags() {
		$this->db->select("t.name");
		$this->db->from("vs_tags as t");
		$this->db->join("vs_tags_content as tc","tc.tag_id = t.id");
		$this->db->where("tc.content_id",$this->id);
		$query = $this->db->get();
		$tags = array();
		
		foreach($query->result() as $tag) array_push($tags,$tag->name);

		return (count($tags) > 0 ? implode(', ',$tags).", " : implode(',',$tags));
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
        if($this->type != "content") {
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
	}
	
	private function CheckOwner() {
		return ($this->created_by == $this->session->userdata("userId") ? TRUE : FALSE);
	}
	
	protected function image_resize($src, $dst, $width, $height, $crop=0){

		if(file_exists($src)) list($w, $h) = getimagesize($src);
        else return false;

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
			if($w < $width and $h < $height) {

                switch($type){
                    case 'bmp': imagewbmp($src, $dst); break;
                    case 'gif': imagegif($src, $dst); break;
                    case 'jpg': imagejpeg($src, $dst); break;
                    case 'png': imagepng($src, $dst); break;
                }

                return true;
            }
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
	
	public function GetById($content_id) {
        $this->db->select("c.type,c.ref_id");
        $this->db->from("vs_content as c");
        $this->db->where("c.id",$content_id);
        $this->db->limit(1);
        $query = $this->db->get();
        $row = $query->row();

        if($row->ref_id != 0) $this->db->select("ref.*,c.*"); else $this->db->select("c.*");
		$this->db->from("vs_content as c");
		if($row->ref_id != 0) $this->db->join('vs_'.$row->type.'s as ref','c.ref_id = ref.id');
		$this->db->where("c.id",$content_id);
		$this->db->limit(1);
		$query = $this->db->get();
		$content = $query->row();
		
		if(isset($content->type)) {
			switch($content->type) {
				case "article":
					$content = new article($query->row());
					break;
                case "location":
                    $content = new location($query->row());
                    break;
				case "multimedia":
					$content = new image($query->row());
					break;
                case "gallery":
                    $content = new gallery($query->row());
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
        if($correlation != "header-image")
		$this->db->where("cc.ref_content_id",$ref_id);
		$this->db->where("cc.correlation",$correlation);
		$this->db->limit(1);
		$query=$this->db->get();
		$cc = $query->row();
		
		if(!isset($cc->id)) {
            $cc = array("content_id" => $content_id, "ref_content_id" => $ref_id, "correlation" => $correlation);
		    $this->db->insert("vs_content_content",$cc);
        }
        else {
            $this->db->where("id",$cc->id);
            $this->db->update("vs_content_content",array("ref_content_id" => $ref_id));
        }
	}
	
	protected function disect_image($tmp_name, $file) {
		$dir2 = "upload/images/thumbnails/".$this->id;
		$dir3 = "upload/images/300_250/".$this->id;
		$dir4 = "upload/images/500_500/".$this->id;

		$target2 = $dir2."/".basename($file);
		$target3 = $dir3."/".basename($file);
		$target4 = $dir4."/".basename($file);

		if(!is_dir($dir2)) mkdir($dir2,0777);
		if(!is_dir($dir3)) mkdir($dir3,0777);
		if(!is_dir($dir4)) mkdir($dir4,0777);
		
		$this->image_resize($tmp_name, $target2, 100, 100);
		$this->image_resize($tmp_name, $target3, 300, 250);
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
		$this->db->select("m.*,cc.ref_content_id as 'asoc_id'");
		$this->db->from("vs_multimedias as m");
        $this->db->join("vs_content as c","c.ref_id = m.id");
        $this->db->join("vs_content_content as cc","cc.ref_content_id = c.id");
		$this->db->where("cc.content_id",$this->id);
		$this->db->where("cc.correlation","header-image");
		$this->db->limit(1);
		$query = $this->db->get();
		$content = $query->row();

        $image = new image($content);
		return $image;
	}
	
	protected function HandleHeaderImage($file) {
        $data = (object) array("asoc_id" => $this->id, "header" => true, "type" => "multimedia");
		$image = new image($data,$file);
		$image->CreateOrUpdate();

        return $image;
	}

    public function RandomString( $length ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";

        $size = strlen( $chars );
        for( $i = 0; $i < $length; $i++ ) {
            $str .= $chars[ rand( 0, $size - 1 ) ];
        }

        return $str;
    }
}

class article extends content_model  {
	
	public $text;
	public $state;
	public $author_name;
	public $image;
	
	public $publish_up;
	public $publish_down;
	public $attachments;
	public $domains;

	function __construct($article = array(), $file = array()) {
		parent::__construct($article);
		parent::CreateOrUpdate();
		
		$this->text = (isset($article->text) ? $article->text : "");
		$this->state = (isset($article->state) ? $article->state : 0);
		$this->author_name = (isset($article->author_name) ? $article->author_name : $this->session->userdata("name"));
		$this->publish_up = (isset($article->publish_up) && $article->publish_up != "0000-00-00" ? $article->publish_up : date(" Y-m-d", time()));
		$this->publish_down = (isset($article->publish_down) && $article->publish_down != "0000-00-00" ? $article->publish_down : "");
		$this->type = "article";
		$this->image = (isset($file["name"]) && $file["name"] != "" ? parent::HandleHeaderImage($file) : parent::GetHeaderImage() );
		$this->attachments = $this->GetAttachments();
        $this->domains = (isset($article->domains) ? $this->HandleDomains($article->domains) : $this->GetDomains());
	}

	public function CreateOrUpdate() {
		$article = array(
			"text" => $this->text,
			"state" => $this->state,
			"author_name" => $this->author_name,
			"publish_up" => $this->publish_up,
			"publish_down" => $this->publish_down
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
        $this->db->where("cc.correlation !=","header-image");
		$query = $this->db->get();
		$attachments = array();
		
		foreach($query->result() as $attachment) {
            $correlation = ($attachment->correlation == "header-image" ? "multimedia" : $attachment->correlation);

			$content = parent::GetById($attachment->ref_content_id, $correlation);
			array_push($attachments,$content);
		}

		return (object) $attachments;
	}

    private function HandleDomains($domains) {
        // TODO
        return array();
    }

    private function GetDomains() {
        $this->db->select("t.id as 'tag_id',t.name,d.id as 'domain_id', d.domain");
        $this->db->from("vs_tags as t");
        $this->db->join("vs_tags_domains as td","t.id = td.tag_id");
        $this->db->join("vs_domains as d","d.domain = t.name","left");
        $this->db->where("td.parent_id",0);
        $query = $this->db->get();
        $domains = array();

        foreach($query->result() as $row) {
            $item = new domain($row);
            array_push($domains,$item);
        }

        return (object) $domains;
    }
}

class domain extends CI_Model {
    public $tag_id;
    public $tag;
    public $domain;
    public $id;
    public $menu;

    public function __construct($domain = array()) {
        $this->id = (isset($domain->domain_id) ? $domain->domain_id : 0);
        $this->tag_id = (isset($domain->tag_id) ? $domain->tag_id : 0);
        $this->domain = (isset($domain->domain) ? $domain->domain : "chucknorris.com");
        $this->tag = (isset($domain->name) ? $domain->name : "chucknorris.com");

        $this->menu = $this->GetMenu($this->tag_id);
    }

    private function GetMenu($tag_id) {
        $this->db->select("t.id as 'tag_id',t.name");
        $this->db->from("vs_tags as t");
        $this->db->join("vs_tags_domains as td","t.id = td.tag_id");
        $this->db->where("td.parent_id",$tag_id);
        $query = $this->db->get();
        $menu = array();

        foreach($query->result() as $row) {
            array_push($menu,$row->name);
            $children = $this->GetMenu($row->tag_id);
            if(!empty($children)) array_push($menu,$children);
        }

        return $menu;
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
    public $width;
    public $height;
    public $cropped;
	
	function __construct($image = array(), $file = array()) {
        $this->load->library('image_lib');
        parent::__construct($image);
		parent::CreateOrUpdate();
		
		$this->type = "multimedia";
		$this->url = (isset($image->url) ? $image->url : "style/images/image_upload.png" );
		$this->large = (isset($image->url) ? $this->GetDiferrentSize("500_500") : "style/images/image_upload.png" );
		$this->medium = (isset($image->url) ? $this->GetDiferrentSize("300_250") : "style/images/image_upload.png" );
		$this->thumbnail = (isset($image->url) ? $this->GetDiferrentSize("thumbnails") : "style/images/image_upload.png" );
        $this->cropped = (isset($image->url) ? $this->GetDiferrentSize("cropped") : "style/images/image_upload.png");
        $this->width = (isset($image->url) ? $this->GetInfo("width") : 0);
        $this->height = (isset($image->url) ? $this->GetInfo("height") : 0);
		$this->asoc_id = (isset($image->asoc_id) ? $image->asoc_id : 0 );
		$this->header = (isset($image->header) ? $image->header : false );
        $this->url = (isset($file["name"]) && $file["name"] != "" ? $this->UploadImage($file) : $this->url);
		$this->format = (!isset($image->format) ? $this->GetInfo("type") : $image->format );
	}

    private function GetInfo($ax = "type") {
        list($width, $height, $type, $attr) = getimagesize($this->url);

        switch($ax) {
            case "width": return $width;
            case "height": return $height;
            case "type": return $type;
        }
    }

    public function Crop($data) {
        $x = $data->x;
        $y = $data->y;
        $w = $data->x2-$data->x;
        $h = $data->y2-$data->y;

        $config['image_library'] = 'gd2';
        $config['source_image'] = $this->url;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $w;
        $config['height'] = $h;
        $config['x_axis'] = $x;
        $config['y_axis'] = $y;

        $dir = "./upload/images/cropped/".$this->id;
        if(!is_dir($dir)) mkdir($dir,0777);

        $upload = $dir."/".basename($this->url);
        if(file_exists($upload)) unlink($upload);

        $config['new_image'] = $upload;

        $this->image_lib->initialize($config);
        if(!$this->image_lib->crop()) echo $this->image_lib->display_errors();
        $this->cropped = $upload;

        parent::disect_image($upload,$this->cropped);
    }
	
	private function GetDiferrentSize($size = "300_250") {
		$url = explode('/',$this->url);
		$url[2] = $size;
		$url = implode('/',$url);

        if(file_exists("./".$url))
            return $url;
        else if(file_exists($this->url))
            return $this->url;
        else if(file_exists($this->large))
            return $this->large;
        else if(file_exists($this->medium))
            return $this->medium;

	}

    private function UploadImage($file) {
        $dir = "upload/images/full_size/".$this->id;
        $target = $dir."/".$file["name"];

        if(!is_dir($dir)) mkdir($dir,0777);

        move_uploaded_file($file["tmp_name"], $target);
        parent::disect_image($target, $file["name"]);

        return $target;
    }
	
	public function CreateOrUpdate() {
		$image = array(
			"url" => $this->url,
			"format" => $this->format
		);
		
		if($this->ref_id > 0) {
			$this->db->where("id",$this->ref_id);
			$this->db->update("vs_multimedias",$image);
		}
		else {
			$this->db->insert("vs_multimedias",$image);
			$this->ref_id = $this->db->insert_id();
		}

		if($this->asoc_id > 0) {
			$type = ($this->header ? "header-image" : "image");
			parent::CreateOrUpdateContentAsoc($this->asoc_id, $this->id, $type);
		}
		
		parent::CreateOrUpdate();
	}
	
}

class gallery extends content_model {
    public $images;
    public $asoc_id;

    function __construct($gallery = array(), $files = array()) {
        parent::__construct($gallery);
        parent::CreateOrUpdate();

        $this->type = "gallery";
        $this->asoc_id = (isset($gallery->asoc_id) ? $gallery->asoc_id : 0 );
        $this->images = (!empty($files) ? $this->UploadImages($files) : $this->GetGalleryImages());
    }

    private function GetGalleryImages() {
        $this->db->select("cc.ref_content_id, cc.correlation");
        $this->db->from("vs_content_content as cc");
        $this->db->where("cc.content_id",$this->id);
        $query = $this->db->get();
        $images = array();

        foreach($query->result() as $image) {
            $image = parent::GetById($image->ref_content_id, $image->correlation);
            array_push($images,$image);
        }

        return (object) $images;
    }

    private function UploadImages($files) {
        $images = array();

        foreach($files as $file) {
            $data = (object) array("name" => "Gallery image", "type" => "multimedia", "asoc_id" => $this->id);
            $image = new image($data,$file);
            $image->CreateOrUpdate();
            array_push($images,$image);
        }

        return (object) $images;
    }

    public function CreateOrUpdate() {
        if($this->asoc_id > 0) parent::CreateOrUpdateContentAsoc($this->asoc_id, $this->id, "gallery");

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
	
	function __construct($event = array(),$file = array()) {
		parent::__construct($event);
		parent::CreateOrUpdate();
		
		$this->start_date = (isset($event->start_date) ? $event->start_date : date('Y-m-d H:i:s', time()) );
		$this->end_date = (isset($event->end_date) ? $event->end_date : date('0000-00-00 00:00:00', time()) );
		$this->fee = (isset($event->fee) ? $event->fee : 0 );
		$this->asoc_id = (isset($event->asoc_id) ? $event->asoc_id : 0 );
		$this->event_type = (isset($event->event_type) ? $event->event_type : "" );
		$this->image = (isset($file["name"]) && $file["name"] != "" ? parent::HandleHeaderImage($file) : parent::GetHeaderImage() );
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