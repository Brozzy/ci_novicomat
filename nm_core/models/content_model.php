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
	
	public static function CreateSlug($name) {
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
	
	protected function image_resize($src, $dst, $width, $height){
		if(file_exists($src)) {
            list($w, $h) = getimagesize($src);

            $type = strtolower(substr(strrchr($src,"."),1));
            if($type == 'jpeg') $type = 'jpg';
            switch($type){
                case 'bmp': $img = imagecreatefromwbmp($src); break;
                case 'gif': $img = imagecreatefromgif($src); break;
                case 'jpg': $img = imagecreatefromjpeg($src); break;
                case 'png': $img = imagecreatefrompng($src); break;
                default : return "Unsupported picture type!";
            }

            /*if($w < $width and $h < $height) {

                switch($type){
                    case 'bmp': imagewbmp($src, $dst); break;
                    case 'gif': imagegif($src, $dst); break;
                    case 'jpg': imagejpeg($src, $dst); break;
                    case 'png': imagepng($src, $dst); break;
                }

                return true;
            }*/

            $ratio = min($width/$w, $height/$h);
            $width = $w * $ratio;
            $height = $h * $ratio;
            $x = 0;

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
        else return false;
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
		
		foreach($query->result() as $content) {
            $fetch = $this->GetById($content->id);
            array_push($contents,$fetch);
        }

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
		if($row->ref_id != 0) {
            if($row->type == "image" || $row->type == "video" || $row->type == "music") $row->type = "multimedia";
            $this->db->join('vs_'.$row->type.'s as ref','c.ref_id = ref.id');
        }


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
                    if($content->format == "jpg" || $content->format == "png" || $content->format == "gif" || $content->format == "bmp")
					    $content = new image($query->row());
                    else if($content->format == "mp4")
                        $content = new video($query->row());
                    else if($content->format == "mp3")
                        $content = new audio($query->row());
                    else
                        $content = new document($query->row());
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
		$dir3 = "upload/images/300_200/".$this->id;
		$dir4 = "upload/images/500_500/".$this->id;

		$target2 = $dir2."/".basename($file);
		$target3 = $dir3."/".basename($file);
		$target4 = $dir4."/".basename($file);

		if(!is_dir($dir2)) mkdir($dir2,0777);
		if(!is_dir($dir3)) mkdir($dir3,0777);
		if(!is_dir($dir4)) mkdir($dir4,0777);
        if(file_exists($target2)) unlink($target2);
        if(file_exists($target3)) unlink($target3);
        if(file_exists($target4)) unlink($target4);
		
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
		$this->db->select("m.*,c.*,cc.ref_content_id as 'asoc_id'");
		$this->db->from("vs_multimedias as m");
        $this->db->join("vs_content as c","c.ref_id = m.id");
        $this->db->join("vs_content_content as cc","cc.ref_content_id = c.id");
		$this->db->where("cc.content_id",$this->id);
		$this->db->where("cc.correlation","header-image");
		$this->db->limit(1);
		$query = $this->db->get();

        $image = new image($query->row());
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

    public static function DeleteFolder($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public static function IsValidUrl ( $url )
    {
        $url = @parse_url($url);

        if ( ! $url) {
            return false;
        }

        $url = array_map('trim', $url);
        $url['port'] = (!isset($url['port'])) ? 80 : (int)$url['port'];
        $path = (isset($url['path'])) ? $url['path'] : '';

        if ($path == '')
        {
            $path = '/';
        }

        $path .= ( isset ( $url['query'] ) ) ? "?$url[query]" : '';

        if ( isset ( $url['host'] ) AND $url['host'] != gethostbyname ( $url['host'] ) )
        {
            if ( PHP_VERSION >= 5 )
            {
                $headers = get_headers("$url[scheme]://$url[host]:$url[port]$path");
            }
            else
            {
                $fp = fsockopen($url['host'], $url['port'], $errno, $errstr, 30);

                if ( ! $fp )
                {
                    return false;
                }
                fputs($fp, "HEAD $path HTTP/1.1\r\nHost: $url[host]\r\n\r\n");
                $headers = fread ( $fp, 128 );
                fclose ( $fp );
            }
            $headers = ( is_array ( $headers ) ) ? implode ( "\n", $headers ) : $headers;
            return ( bool ) preg_match ( '#^HTTP/.*\s+[(200|301|302)]+\s#i', $headers );
        }
        return false;
    }

    public static function CalculateDate($timestamp) {
        $today = new DateTime('now');
        $date = new DateTime($timestamp);
        $future = ($today > $date ? false : true);

        $interval = $today->diff($date);

        if($interval->y > 4) return $interval->format("");
        else if($interval->y > 2)
            $format = ($future ? "čez %y leta " : "pred %y leti ");
        else if($interval->y == 2)
            $format = ($future ? "čez %y leti " : "pred %y leti ");
        else if($interval->y == 1)
            $format = ($future ? "čez %y leta " : "pred %y letom ");
        else
            $format = "";

        $index = ($interval->y > 0 ? false : true);
        $adjective[0] = ($index ? "čez" : "");
        $adjective[1] = ($index ? "pred" : "");

        if($interval->m > 2)
            $format .= ($future ? $adjective[0]." %m mesece " : $adjective[1]." %m mesecimi ");
        else if($interval->m == 2)
            $format .= ($future ? $adjective[0]." %m meseca " : $adjective[1]." %m mesecoma ");
        else if($interval->m == 1)
            $format .= ($future ? $adjective[0]." %m mesec " : $adjective[1]." %m mesecom ");
        else
            $format .= "";

        $index = ($interval->m > 0 || $interval->y > 0 ? false : true);
        $adjective[0] = ($index ? "čez" : "");
        $adjective[1] = ($index ? "pred" : "");

        if($interval->d > 2)
            $format .= ($future ? $adjective[0]." %d dni " : $adjective[1]." %d dnevi ");
        else if($interval->d == 2)
            $format .= ($future ? $adjective[0]." %d dni " : $adjective[1]." %d dnevoma ");
        else if($interval->d == 1)
            $format .= ($future ? $adjective[0]." %d dan " : $adjective[1]." %d dnevom ");
        else
            $format .= "";

        $index = ($interval->d > 0 || $interval->m > 0 || $interval->y ? false : true);
        $adjective[0] = ($index ? "čez" : "");
        $adjective[1] = ($index ? "pred" : "");

        if($interval->h > 2)
            $format .= ($future ? $adjective[0]." %h ur " : $adjective[1]." %h urami ");
        else if($interval->h == 2)
            $format .= ($future ? $adjective[0]." %h uri " : $adjective[1]." %h urami ");
        else if($interval->h == 1)
            $format .= ($future ? $adjective[0]." %h uro " : $adjective[1]." %h uro ");
        else
            $format .= "";

        $index = ($interval->h > 0 || $interval->d > 0 || $interval->m > 0 || $interval->y ? false : true);
        $adjective[0] = ($index ? "čez" : "in");
        $adjective[1] = ($index ? "pred" : "in");

        if($interval->i > 4)
            $format .= ($future ? $adjective[0]." %i minut" : $adjective[1]." %i minutami");
        else if($interval->i > 2)
            $format .= ($future ? $adjective[0]." %i minute" : $adjective[1]." %i minutami");
        else if($interval->i > 1)
            $format .= ($future ? $adjective[0]." %i minuti" : $adjective[1]." %i minutami");
        else if($interval->i > 0)
            $format .= ($future ? $adjective[0]." %i minuto" : $adjective[1]." %i minuto");
        else
            $format .= "";

        return $interval->format($format);
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
    public $attachments_count;
	public $media;
    public $slug;

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
        $this->media = (isset($article->media) ? $this->HandleMedia($article->media) : $this->GetMedia());
        $this->slug = parent::CreateSlug($this->name);
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

        $this->attachments_count = count($attachments);

		return (object) $attachments;
	}

    private function HandleMedia($media) {
        // TODO
        return array();
    }

    private function GetMedia() {
        $this->db->select("t.id as 'tag_id',t.name,m.id as 'media_id', m.media");
        $this->db->from("vs_tags as t");
        $this->db->join("vs_tags_media as td","t.id = td.tag_id");
        $this->db->join("vs_media as m","m.media = t.name","left");
        $this->db->where("td.parent_id",0);
        $query = $this->db->get();
        $media = array();

        foreach($query->result() as $row) {
            $item = new media($row);
            array_push($media,$item);
        }

        return (object) $media;
    }
}

class media extends CI_Model {
    public $tag_id;
    public $tag;
    public $media;
    public $id;
    public $menu;
    public $favicon;
    public $email;

    public function __construct($media = array()) {
        $this->id = (isset($media->media_id) ? $media->media_id : 0);
        $this->tag_id = (isset($media->tag_id) ? $media->tag_id : 0);
        $this->media = (isset($media->media) ? $media->media : "chucknorris.com");
        $this->tag = (isset($media->name) ? $media->name : "chucknorris.com");
        $this->favicon = (isset($media->media) ? 'http://g.etfv.co/http://www.'.$this->media."?defaulticon=lightpng" : "" );
        $this->menu = $this->GetMenu($this->tag_id);
    }

    private function GetMenu($tag_id) {
        $this->db->select("t.id as 'tag_id',t.name");
        $this->db->from("vs_tags as t");
        $this->db->join("vs_tags_media as td","t.id = td.tag_id");
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
    public $greyscale;
    public $display;
    public $position;
	
	function __construct($image = array(), $file = array()) {
        $this->load->library('image_lib');
        parent::__construct($image);
		parent::CreateOrUpdate();
		
		$this->type = "multimedia";
		$this->url = (isset($image->url) && $image->url != "" ? $image->url : "style/images/icons/png/pictures.png" );
		$this->large = (isset($image->url) ? $this->GetDiferrentSize("500_500") : base_url()."style/images/icons/png/pictures.png" );
		$this->medium = (isset($image->url) ? $this->GetDiferrentSize("300_200") : base_url()."style/images/icons/png/pictures.png" );
		$this->thumbnail = (isset($image->url) ? $this->GetDiferrentSize("thumbnails") : base_url()."style/images/icons/png/pictures.png" );
        $this->cropped = (isset($image->url) ? $this->GetDiferrentSize("cropped") : base_url()."style/images/icons/png/pictures.png");
        $this->width = (isset($image->url) ? $this->GetInfo("width") : 0);
        $this->height = (isset($image->url) ? $this->GetInfo("height") : 0);
		$this->asoc_id = (isset($image->asoc_id) ? $image->asoc_id : 0 );
		$this->header = (isset($image->header) && $image->header == "true" ? true : false );
        $this->url = (isset($file["name"]) && $file["name"] != "" ? $this->UploadImage($file) : $this->url );
        $this->url = ($this->content_model->IsValidUrl($file) ? $this->GetImageFromUrl($file) : $this->url );
		$this->format = (!isset($image->format) ? $this->GetInfo("type") : $image->format );
        $this->position = (isset($image->position) ? $image->position : "bottom");

        $this->display = $this->GetDisplayImage();
	}

    private function GetDisplayImage() {
        if(file_exists($this->cropped))
            return $this->cropped;
        else if(file_exists($this->url))
            return $this->url;
        else if(file_exists($this->large))
            return $this->large;
        else return $this->medium;
    }

    public function GetImageFromUrl($url) {
        $dir = "upload/images/full_size/".$this->id;
        $img = $dir."/".basename($url);
        if(!is_dir($dir)) mkdir($dir,0777);
        if(file_exists($img)) unlink($img);

        file_put_contents($img, file_get_contents($url));
        parent::disect_image($img, $img);

        return $img;
    }

    private function GetInfo($ax = "type") {
        if(file_exists($this->url)) {
            list($width, $height, $type, $attr) = getimagesize(base_url().$this->url);

            switch($ax) {
                case "width": return $width;
                case "height": return $height;
                case "type": {
                    $temp = explode('.',basename($this->url));
                    return (end($temp) == "jpeg" ? "jpg" : end($temp));
                }
            }
        }
        else if(isset($this->url)) {
            $temp = explode('.',$this->url);
            return end($temp);
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

    public function GreyScale() {
        // The file you are grayscaling
        $file = $this->display;

        // Get the dimensions
        list($width, $height) = getimagesize($file);

        // Define our source image
        $type = strtolower(substr(strrchr($file,"."),1));
        if($type == 'jpeg') $type = 'jpg';
        switch($type){
            case 'bmp': $source = imagecreatefromwbmp($file); break;
            case 'gif': $source = imagecreatefromgif($file); break;
            case 'jpg': $source = imagecreatefromjpeg($file); break;
            case 'png': $source = imagecreatefrompng($file); break;
            default : return "Unsupported picture type!";
        }

        // Creating the Canvas
        $bwimage = imagecreate($width, $height);

        //Creates the 256 color palette
        for ($c=0;$c<256;$c++)
        {
            $palette[$c] = imagecolorallocate($bwimage,$c,$c,$c);
        }

        //Creates yiq function
        function yiq($r,$g,$b)
        {
            return (($r*0.299)+($g*0.587)+($b*0.114));
        }

        //Reads the origonal colors pixel by pixel
        for ($y=0;$y<$height;$y++)
        {
            for ($x=0;$x<$width;$x++)
            {
                $rgb = imagecolorat($source,$x,$y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                //This is where we actually use yiq to modify our rbg values, and then convert them to our grayscale palette
                $gs = yiq($r,$g,$b);
                imagesetpixel($bwimage,$x,$y,$palette[$gs]);
            }
        }

        unlink($this->display);

        switch($type){
            case 'bmp': imagewbmp($bwimage, $this->display); break;
            case 'gif': imagegif($bwimage, $this->display); break;
            case 'jpg': imagejpeg($bwimage, $this->display); break;
            case 'png': imagepng($bwimage, $this->display); break;
        }

        return true;
    }

    public function FlipImage($mode = "horizontal") {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $this->display;
        $config['new_image'] = $this->display;
        $config['rotation_angle'] = ($mode == "horizontal" ? "hor" : "ver");
        $this->image_lib->initialize($config);

        $this->image_lib->rotate();
        return true;
    }
	
	private function GetDiferrentSize($size = "300_200") {
		$url = explode('/',$this->url);
		$url[2] = $size;
		$url = implode('/',$url);

        return $url;
	}

    private function UploadImage($file) {
        if(is_dir("./upload/images/cropped/".$this->id)) $this->DeleteFolder("./upload/images/cropped/".$this->id);

        $dir = "upload/images/full_size/".$this->id;
        $target = $dir."/".$file["name"];

        if(!is_dir($dir)) mkdir($dir,0777);
        if(file_exists($target)) unlink($target);

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
        $this->images = (!empty($files) || (isset($gallery->from_internet) && $gallery->from_internet != "") ? $this->UploadImages($files) : $this->GetGalleryImages());
    }

    private function UploadImages($files) {
        $images = array();

        foreach($files as $file) {
            $data = (object) array("name" => $this->Name, "description" => $this->Description, "type" => "multimedia", "asoc_id" => $this->id);
            $image = new image($data,$file);
            $image->CreateOrUpdate();
            array_push($images,$image);
        }

        foreach(explode(',',$this->from_internet) as $url) {
            if($this->content_model->IsValidUrl($url)) {
                $data = (object) array("url" => $url, "name" => $this->Name, "description" => $this->Description, "type" => "multimedia", "asoc_id" => $this->id);
                $image = new image($data);
                array_push($images,$image);
            }
        }

        return (object) $images;
    }

    public function CreateOrUpdate() {
        if($this->asoc_id > 0) parent::CreateOrUpdateContentAsoc($this->asoc_id, $this->id, "gallery");

        parent::CreateOrUpdate();
    }

    public function TransferImages($gallery_id, $update_id, $file) {
        $full_size = "upload/images/full_size/".$update_id."/".$file;
        $large_size = "upload/images/500_500/".$update_id."/".$file;
        $medium_size = "upload/images/300_200/".$update_id."/".$file;
        $thumbnail = "upload/images/thumbnails/".$update_id."/".$file;

        $gallery_full_size = "upload/images/full_size/".$gallery_id."/".$file;
        $gallery_large_size = "upload/images/500_500/".$gallery_id."/".$file;
        $gallery_medium_size = "upload/images/300_200/".$gallery_id."/".$file;
        $gallery_thumbnail = "upload/images/thumbnails/".$gallery_id."/".$file;

        if(file_exists($full_size)) unlink($full_size);
        if(file_exists($large_size)) unlink($large_size);
        if(file_exists($medium_size)) unlink($medium_size);
        if(file_exists($thumbnail)) unlink($thumbnail);
        if(is_dir("upload/images/cropped/".$update_id."/")) rmdir("upload/images/cropped/".$update_id."/");

        if(!is_dir("upload/images/full_size/".$update_id)) mkdir("upload/images/full_size/".$update_id, 0777);
        if(!is_dir("upload/images/500_500/".$update_id)) mkdir("upload/images/500_500/".$update_id, 0777);
        if(!is_dir("upload/images/300_200/".$update_id)) mkdir("upload/images/300_200/".$update_id, 0777);
        if(!is_dir("upload/images/thumbnails/".$update_id)) mkdir("upload/images/thumbnails/".$update_id, 0777);

        copy($gallery_full_size,$full_size);
        copy($gallery_large_size,$large_size);
        copy($gallery_medium_size,$medium_size);
        copy($gallery_thumbnail,$thumbnail);
    }

    public function GetGalleryImages() {
        $this->db->select("c.id,c.name,c.description,c.ref_id,m.url,m.format, m.category");
        $this->db->from("vs_content as c");
        $this->db->join("vs_multimedias as m","c.ref_id = m.id");
        $this->db->join("vs_content_content as cc","cc.ref_content_id = c.id");
        $this->db->where("c.type","multimedia");
        $this->db->where("cc.correlation","image");
        $this->db->or_where("cc.correlation","header-image");
        $this->db->where("m.url != 'style/images/icons/png/pictures.png'");
        $this->db->group_by("m.url");
        $query = $this->db->get();

        $gallery = array(
            "images" => $query->result(),
            "categories" => $this->GetGalleryCategories()
        );

        return (object) $gallery;
    }

    private function GetGalleryCategories() {
        $this->db->select("m.category as 'name'");
        $this->db->from("vs_multimedias as m");
        $this->db->group_by("m.category");
        $this->db->limit(8);
        $query = $this->db->get();

        return $query->result();
    }
}

class video extends content_model {
    public $url;
    public $format;
    public $thumbnail;
    public $asoc_id;
    public $duration;
    public $position;
    public $author_name;
    public $category;
    public $viewCount;
    public $source;

    function __construct($video = array(), $file = array()) {
        parent::__construct($video);
        parent::CreateOrUpdate();

        $this->type = "multimedia";
        $this->url = (isset($video->url) && $video->url != "" ? $video->url : "" );
        $this->thumbnail = (isset($video->thumbnail) ? $video->thumbnail : $this->GetInfo("thumbnail") );
        $this->asoc_id = (isset($video->asoc_id) ? $video->asoc_id : 0 );
        $this->url = (isset($file["name"]) && $file["name"] != "" ? $this->UploadVideo($file) : $this->url );
        $this->url = ($this->content_model->IsValidUrl($file) && $this->IsYoutubeVideo($file) ? $this->SetYoutubeVideo($file) : $this->url );
        $this->position = (isset($video->position) ? $video->position : "bottom");
        $this->format = "mp4";
        $this->source = ($this->content_model->IsValidUrl($this->url) ? "internet" : "local" );
    }

    private function GetInfo($info = "type") {
        if(file_exists($this->url)) {
            list($width, $height, $type, $attr) = getimagesize(base_url().$this->url);

            switch($info) {
                case "length": return $width;
                case "thumbnail": return "style/images/icons/png/video.png";
                case "type": {
                    $temp = explode('.',basename($this->url));
                    return (end($temp) == "jpeg" ? "jpg" : end($temp));
                }
            }
        }
        else if($this->IsYoutubeVideo($this->url)) {
            return "http://i1.ytimg.com/vi/".$this->GetYoutubeVideoId($this->url)."/0.jpg";
        }
    }

    private function SingleVideo($data) {
        $xml= new stdClass;

// author name
        $xml->author = $data->author->name;

        $media = $data->children('http://search.yahoo.com/mrss/');

// title
        $xml->title = $media->group->title;

// description
        $xml->description = $media->group->description;

// URL
        $attrs = $media->group->player->attributes();
        $xml->watchURL = $attrs['url'];

// default thumbnail
        $xml->thumbnail_0 = $media->group->thumbnail[0]->attributes(); // Normal Quality Default Thumbnail

// category
        $xml->category = $media->group->category;

        $yt = $media->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->duration->attributes();

// duration
        $xml->duration = $attrs['seconds'];

// published
        $xml->published = strtotime($data->updated);

        $yt = $data->children('http://gdata.youtube.com/schemas/2007');
        $attrs = $yt->statistics->attributes();

// view count
        $xml->viewCount = $attrs['viewCount'];

// favourite count
        $xml->favCount = $attrs['favoriteCount'];

        $yt = $data->children('http://gdata.youtube.com/schemas/2007');

        if ($yt->rating) {
            $attrs = $yt->rating->attributes();

// likes count
            $xml->likeCount = $attrs['numLikes'];

// dislikes count
            $xml->disLikeCount = $attrs['numDislikes'];
        }

        else {
            $xml->likeCount = 0;
            $xml->disLikeCount = 0;
        }

        $gd = $data->children('http://schemas.google.com/g/2005');
        if ($gd->rating) {
            $attrs = $gd->rating->attributes();

// average rating
            $xml->avgRating = $attrs['average'];

// maximum accept rating
            $xml->maxRating = $attrs['max'];

// number of rates
            $xml->numRaters = $attrs['numRaters'];
        }

        else {
            $xml->avgRating = 0;
            $xml->maxRating = 0;
        }

        $gd = $data->children('http://schemas.google.com/g/2005');
        if ($gd->comments->feedLink) {
            $attrs = $gd->comments->feedLink->attributes();

// comments count
            $xml->commentsCount = $attrs['countHint'];
        }

// related videos
        $data->registerXPathNamespace('feed', 'http://www.w3.org/2005/Atom');
        $relatedV = $data->xpath("feed:link[@rel='http://gdata.youtube.com/schemas/2007#video.related']");
        if (count($relatedV) > 0) {
            $xml->relatedURL = $relatedV[0]['href'];
        }

        return $xml;
    }

    private function SetYoutubeVideo($url) {
        $YoutubeId = $this->GetYoutubeVideoId($url);

        // assign $id to feed link
        $xmlURL = 'http://gdata.youtube.com/feeds/api/videos/' .$YoutubeId. '?v=2';

        // convert XML document to an object
        $data = simplexml_load_file($xmlURL);

        // parse entry data
        $video = $this->SingleVideo($data);

        // lets do some magic! ;)
        $this->thumbnail = "http://i1.ytimg.com/vi/".$YoutubeId."/0.jpg";
        $this->name = (string) $video->title;
        $this->description = (string) $video->description;
        $this->category = (string) $video->category;
        $this->duration = (string) $video->duration;

        return "http://www.youtube.com/embed/".$YoutubeId;
    }

    private function GetYoutubeVideoId($url) {
        preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
        $videoID = (isset($matches[1]) ? $matches[1] : '');

        return preg_replace('/[^\w-_]+/', '', $videoID);
    }

    private function IsYoutubeVideo($url) {
        preg_match("/^(http:\/\/)?([^\/]+)/i", $url, $matches);
        $host = (!empty($matches) ? $matches[2] : "youtube.com");

        return (($host == "www.youtube.com" || $host == "youtube.com") ? true : false);
    }

    private function UploadVideo($file) {
        $dir = "upload/videos/".$this->id;
        $target = $dir."/".$this->content_model->CreateSlug($file["name"]).".mp4";

        if(!is_dir($dir)) mkdir($dir,0777);
        if(file_exists($target)) unlink($target);

        move_uploaded_file($file["tmp_name"], $target);

        return $target;
    }

    public function CreateOrUpdate() {
        $video = array(
            "url" => (string) $this->url,
            "format" => (string) $this->format
        );

        if($this->ref_id > 0) {
            $this->db->where("id",$this->ref_id);
            $this->db->update("vs_multimedias",$video);
        }
        else {
            $this->db->insert("vs_multimedias",$video);
            $this->ref_id = $this->db->insert_id();
        }


        if($this->asoc_id > 0) {
            parent::CreateOrUpdateContentAsoc($this->asoc_id, $this->id, "video");
        }

        parent::CreateOrUpdate();
    }
}

class audio extends content_model {
    public $url;
    public $format;
    public $thumbnail;
    public $asoc_id;
    public $duration;
    public $position;

    function __construct($audio = array(), $file = array()) {
        parent::__construct($audio);
        parent::CreateOrUpdate();

        $this->type = "multimedia";
        $this->url = (isset($audio->url) && $audio->url != "" ? $audio->url : "" );
        $this->thumbnail = base_url()."style/images/icons/png/headphones.png";
        $this->asoc_id = (isset($audio->asoc_id) ? $audio->asoc_id : 0 );
        $this->url = (isset($audio->url) ? $audio->url : "");
        $this->url = (isset($file["name"]) && $file["name"] != "" ? $this->UploadAudio($file) : $this->url );
        $this->position = (isset($audio->position) ? $audio->position : "bottom");
        $this->description = ($this->description == "" ? $this->HandleDescription(basename($this->url)) : $this->description);
        $this->format = "mp3";
    }

    private function HandleDescription($filename) {
        $description = str_replace('mp3','',$filename);
        $description = str_replace('-',' ',$description);
        $description = str_replace('.',' ',$description);
        $description = trim($description);

        return $description.".mp3";
    }

    private function UploadAudio($file) {
        $dir = "upload/audio/".$this->id;
        $target = $dir."/".$this->content_model->CreateSlug($file["name"]).".mp3";

        if(!is_dir($dir)) mkdir($dir,0777);
        if(file_exists($target)) unlink($target);

        move_uploaded_file($file["tmp_name"], $target);

        return $target;
    }

    public function CreateOrUpdate() {
        $video = array(
            "url" => (string) $this->url,
            "format" => (string) $this->format
        );

        if($this->ref_id > 0) {
            $this->db->where("id",$this->ref_id);
            $this->db->update("vs_multimedias",$video);
        }
        else {
            $this->db->insert("vs_multimedias",$video);
            $this->ref_id = $this->db->insert_id();
        }


        if($this->asoc_id > 0) {
            parent::CreateOrUpdateContentAsoc($this->asoc_id, $this->id, "audio");
        }

        parent::CreateOrUpdate();
    }
}

class document extends content_model {
    public $url;
    public $format;
    public $thumbnail;
    public $asoc_id;
    public $duration;
    public $position;

    function __construct($audio = array(), $file = array()) {
        parent::__construct($audio);
        parent::CreateOrUpdate();

        $this->type = "multimedia";
        $this->url = (isset($audio->url) && $audio->url != "" ? $audio->url : "" );
        $this->thumbnail = base_url()."style/images/icons/png/document.png";
        $this->asoc_id = (isset($audio->asoc_id) ? $audio->asoc_id : 0 );
        $this->url = (isset($audio->url) ? $audio->url : "");
        $this->url = (isset($file["name"]) && $file["name"] != "" ? $this->UploadDocument($file) : $this->url );
        $this->format = (isset($file["name"]) && $file["name"] != "" ? $this->GetFormat($file["name"]) : $this->GetFormat($this->url));
        $this->position = (isset($audio->position) ? $audio->position : "bottom");
    }

    private function GetFormat($filename) {
        $format = explode('.',$filename);
        return end($format);
    }

    private function UploadDocument($file) {
        $dir = "upload/documents/".$this->id;
        $target = $dir."/".$file["name"];

        if(!is_dir($dir)) mkdir($dir,0777);
        if(file_exists($target)) unlink($target);

        move_uploaded_file($file["tmp_name"], $target);

        return $target;
    }

    public function CreateOrUpdate() {
        $video = array(
            "url" => (string) $this->url,
            "format" => (string) $this->format
        );

        if($this->ref_id > 0) {
            $this->db->where("id",$this->ref_id);
            $this->db->update("vs_multimedias",$video);
        }
        else {
            $this->db->insert("vs_multimedias",$video);
            $this->ref_id = $this->db->insert_id();
        }


        if($this->asoc_id > 0) {
            parent::CreateOrUpdateContentAsoc($this->asoc_id, $this->id, "audio");
        }

        parent::CreateOrUpdate();
    }
}

class event extends content_model {
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;

    public $display_start_date;
    public $display_end_date;
    public $exact_date_start;
    public $exact_date_end;
    public $fee;
    public $event_type;
    public $image;
    public $asoc_id;

    function __construct($event = array(),$file = array()) {
        parent::__construct($event);
        parent::CreateOrUpdate();

        $this->start_date = (isset($event->start_date) ? $event->start_date : date('Y-m-d H:i:s', time()) );
        $this->display_start_date = parent::CalculateDate($this->start_date);
        $this->end_date = (isset($event->end_date) ? $event->end_date : date('0000-00-00 00:00:00', time()) );
        $this->display_end_date = parent::CalculateDate($this->end_date);

        $this->start_date = (isset($event->start_time) ? $event->start_date." ".$event->start_time.":00" : $this->start_date );
        $this->end_date = (isset($event->end_time) ? $event->end_date." ".$event->end_time.":00" : $this->end_date );

        $this->exact_date_start = date_format(date_create($this->start_date), 'd.m.Y \o\b H:i \u\r\i');
        $this->exact_date_end = ($this->end_date != '0000-00-00 00:00:00' ? date_format(date_create($this->end_date), 'd.m.Y \o\b H:i \u\r\i') : "");

        $this->fee = (isset($event->fee) ? $event->fee : 0 );
        $this->asoc_id = (isset($event->asoc_id) ? $event->asoc_id : 0 );
        $this->event_type = (isset($event->event_type) ? $event->event_type : "social" );

        if(isset($file[0]["name"]) && $file[0]["name"] != "") {
            $this->image = new image((object) array("header" => true, "type" => "multimedia", "asoc_id" => $this->id), $file[0]);
            $this->image->CreateOrUpdate();
        } else if($this->ref_id > 0) {
            $this->image = parent::GetHeaderImage();
        } else {
            $this->image = new image();
        }
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
    public $google_image;
    public $room_name;

    function __construct($location = array()) {
        parent::__construct($location);
        parent::CreateOrUpdate();

        $this->country = (isset($location->country) ? $location->country : "Slovenija" );
        $this->region = (isset($location->region) ? $location->region : "" );
        $this->city = (isset($location->city) ? $location->city : "" );
        $this->street_village = (isset($location->street_village) ? $location->street_village : "" );
        $this->post_number = (isset($location->post_number) ? $location->post_number : "" );
        $this->room_name = (isset($location->room_name) ? $location->room_name : "" );
        $this->house_number = (isset($location->house_number) ? $location->house_number : "" );
        $this->asoc_id = (isset($location->asoc_id) ? $location->asoc_id : 0 );
        $this->google_image = "http://maps.googleapis.com/maps/api/staticmap?center=".parent::CreateSlug($this->country).",".parent::CreateSlug($this->city).",".parent::CreateSlug($this->street_village).",".parent::CreateSlug($this->house_number)."&zoom=15&size=300x250";
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