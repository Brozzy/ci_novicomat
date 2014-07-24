<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class content_model extends CI_Model {

    public $id;
    public $name;
    public $slug;
    public $description;
    public $ref_id;

    public $type;
    public $created;
    public $display_created;
    public $created_by;
    public $updated;
    public $updated_by;
    public $author;
    public $owner;
    public $tags;

    function __construct($content = array()) {
        parent::__construct();

        $this->id = (isset($content->id) ? $content->id : 0);
        $this->name = (isset($content->name) ? $content->name : "");
        $this->slug = (isset($content->name) && trim($content->name) != "" ? $this->GetAlias($this->name) : "nova-vsebina");
        $this->description = (isset($content->description) ? $content->description : "");

        $this->type = (isset($content->type) ? $content->type : 'content');
        $this->created_by = (isset($content->created_by) ? $content->created_by : $this->session->userdata("userId"));
        $this->created = (isset($content->created) ? $content->created : date('Y-m-d H:i:s', time() ));
        $this->display_created = $this->CalculateDate($this->created);
        $this->updated = (isset($content->updated) ? $content->updated : "0000-00-00");
        $this->author = (isset($content->created_by) ? $this->user_model->Get(array("criteria" => "id", "value" => $this->created_by, "limit" => 1)) : "");

        $this->owner = (isset($content->created_by) ? $this->CheckOwner() : FALSE);
        $this->ref_id = (isset($content->ref_id) ? $content->ref_id : 0);
        $this->tags = (isset($content->tags) ? $this->HandleTags($content->tags) : $this->GetTags());
    }

    // PRIVATE
    private function GetTags() {
        $this->db->select("t.name");
        $this->db->from("vs_tags as t");
        $this->db->join("vs_tags_content as tc","tc.tag_id = t.id");
        $this->db->where("tc.content_id",$this->id);
        $query = $this->db->get();
        $tags = array();

        foreach($query->result() as $tag) array_push($tags,$tag->name);

        return $tags;
    }

    private function CheckOwner() {
        return ($this->created_by == $this->session->userdata("userId") ? TRUE : FALSE);
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

    // PROTECTED
    protected function CheckIfTagsExists($tag) {
        $this->db->select("t.id");
        $this->db->from("vs_tags as t");
        $this->db->where("t.name",$tag);
        $this->db->or_where("t.alias",$tag);
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

    protected function GetPosition($asoc_id, $id) {
        $this->db->select("cc.position");
        $this->db->from("vs_content_content as cc");
        $this->db->where("cc.content_id",$asoc_id);
        $this->db->where("cc.ref_content_id",$id);
        $this->db->limit(1);
        $query = $this->db->get();
        $row = $query->row();

        return (isset($row->position) ? $row->position : "bottom");
    }

    // PUBLIC
    public function HandleTags($tags) {
        $this->db->delete("vs_tags_content",array("content_id" => $this->id));

        $tags = explode(',',$tags);
        foreach($tags as $tag) {
            $tag = trim($tag);
            if($tag != "" && $tag != " " && strlen($tag) > 2) $this->CreateNewTagConnection($this->id,$tag);
        }

        return $tags;
    }

    public function CreateNewTagConnection($content_id,$tag) {
        $tag_id = $this->CheckIfTagsExists($tag);
        $this->db->insert("vs_tags_content",array("tag_id" => $tag_id, "content_id" => $content_id));
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

    public function GetMediaContent($media, $tagAlias = "") {
        $tagId = $this->CheckIfTagsExists($tagAlias);

        $this->db->select("c.id");
        $this->db->from("vs_content c");
        $this->db->join("vs_media_content as mc","c.id = mc.content_id");
        $this->db->join("vs_media as m","mc.media_id=m.id");
        if($tagAlias != "") $this->db->join("vs_tags_content as tc","tc.content_id = c.id");
        $this->db->where("mc.status", 2);
        $this->db->where("c.type", "article");
        $this->db->where("m.id",$media->id);
        if($tagAlias != "") $this->db->where("tc.tag_id",$tagId);
        $this->db->order_by("c.created","desc");
        $query = $this->db->get();
        $contents = array();

        foreach($query->result() as $content) {
            $article = $this->GetById($content->id);
            array_push($contents, $article);
        }

        return (object) $contents;
    }

    public function IsEligible($userId) {
        $this->db->select('uc.user_id');
        $this->db->from("vs_content_users as uc");
        $this->db->where('uc.content_id',$this->id);
        $this->db->where('uc.user_id',$userId);
        $this->db->limit(1);
        $query = $this->db->get();
        $row = $query->row();

        return ($this->created_by == $userId || (isset($row->user_id) && $row->user_id == $userId) ? true : false);
    }

    public function GetUserContent($userId) {
        $this->db->select("c.*");
        $this->db->from("vs_content as c");
        $this->db->join("vs_content_users as uc",'uc.content_id = c.id','left');
        $this->db->where("c.type","article");
        $this->db->where("c.created_by",$userId);
        $this->db->or_where("uc.user_id",$userId);
        $this->db->order_by("c.id","DESC");
        $this->db->group_by("c.id");
        $query = $this->db->get();
        $contents = array();

        foreach($query->result() as $content) {
            $fetch = $this->GetById($content->id);
            array_push($contents,$fetch);
        }

        return (object) $contents;
    }

    public function GetById($content_id, $asoc_id = 0) {
        $this->db->select("c.type,c.ref_id");
        $this->db->from("vs_content as c");
        $this->db->where("c.id",$content_id);
        $this->db->limit(1);
        $query = $this->db->get();
        $row = $query->row();

        if(isset($row->ref_id)) {
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
                            $content = new image($query->row(),NULL,$asoc_id);
                        else if($content->format == "mp4")
                            $content = new video($query->row(),NULL,$asoc_id);
                        else if($content->format == "mp3")
                            $content = new audio($query->row(),NULL,$asoc_id);
                        else
                            $content = new document($query->row(),NULL, $asoc_id);
                        break;
                    case "gallery":
                        $content = new gallery($query->row());
                        break;
                    case "event":
                        $content = new event($query->row());
                        break;
                    case "bug":
                        $content = new bug($query->row());
                        break;
                    default:
                        break;
                }
            }
            return $content;
        }
        else return new content_model();
    }

    public function CreateSlug($name) {
        //$string = $this->GetAlias($name);
        $string = preg_replace("/[\/\.]/", " ", $name);
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

    // STATIC
    public static function DeleteFolder($dir, $recursive = true) {
        if($recursive) {
            $files = array_diff(scandir($dir), array('.','..'));
            foreach ($files as $file) unlink("$dir/$file");
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

        if($interval->d > 2 && $interval->y == 0)
            $format .= ($future ? $adjective[0]." %d dni " : $adjective[1]." %d dnevi ");
        else if($interval->d == 2 && $interval->y == 0)
            $format .= ($future ? $adjective[0]." %d dni " : $adjective[1]." %d dnevoma ");
        else if($interval->d == 1 && $interval->y == 0)
            $format .= ($future ? $adjective[0]." %d dan " : $adjective[1]." %d dnevom ");
        else
            $format .= "";

        $index = ($interval->d > 0 || $interval->m > 0 || $interval->y ? false : true);
        $adjective[0] = ($index ? "čez" : "");
        $adjective[1] = ($index ? "pred" : "");

        if($interval->h > 2 && $interval->m == 0 && $interval->y == 0)
            $format .= ($future ? $adjective[0]." %h ur " : $adjective[1]." %h urami ");
        else if($interval->h == 2 && $interval->m == 0 && $interval->y == 0)
            $format .= ($future ? $adjective[0]." %h uri " : $adjective[1]." %h urami ");
        else if($interval->h == 1 && $interval->m == 0 && $interval->y == 0)
            $format .= ($future ? $adjective[0]." %h uro " : $adjective[1]." %h uro ");
        else
            $format .= "";

        $index = ($interval->h > 0 || $interval->d > 0 || $interval->m > 0 || $interval->y ? false : true);
        $adjective[0] = ($index ? "čez" : "in");
        $adjective[1] = ($index ? "pred" : "in");

        if($interval->i > 4 && $interval->d == 0 && $interval->m == 0 && $interval->y == 0)
            $format .= ($future ? $adjective[0]." %i minut" : $adjective[1]." %i minutami");
        else if($interval->i > 2 && $interval->d == 0 && $interval->m == 0 && $interval->y == 0)
            $format .= ($future ? $adjective[0]." %i minute" : $adjective[1]." %i minutami");
        else if($interval->i > 1 && $interval->d == 0 && $interval->m == 0 && $interval->y == 0)
            $format .= ($future ? $adjective[0]." %i minuti" : $adjective[1]." %i minutami");
        else if($interval->i > 0 && $interval->d == 0 && $interval->m == 0 && $interval->y == 0)
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
        $this->media = (isset($article->media) ? $this->HandleMedia($article) : $this->GetMedia());
        $this->slug = parent::CreateSlug($this->name);
    }

    // PRIVATE
    private function GetAttachments() {
        $this->db->select("cc.ref_content_id, cc.correlation");
        $this->db->from("vs_content_content as cc");
        $this->db->where("cc.content_id",$this->id);
        $this->db->where("cc.correlation !=","header-image");
        $query = $this->db->get();
        $attachments = array();

        foreach($query->result() as $attachment) {
            $content = parent::GetById($attachment->ref_content_id, $this->id);
            array_push($attachments,$content);
        }

        $this->attachments_count = count($attachments);

        return (object) $attachments;
    }

    private function HandleMedia($article) {
        $this->db->where("content_id",$this->id);
        $this->db->delete("vs_media_content");

        foreach($article->media as $media)  {
            $this->db->select("m.id");
            $this->db->from("vs_media as m");
            $this->db->where("m.media",$media);
            $this->db->limit(1);
            $query = $this->db->get();
            $row = $query->row();

            $this->db->insert("vs_media_content",array("media_id" => $row->id, "content_id" => $this->id, "status" => $this->state ));
        }

        return array();
    }

    private function GetMedia() {
        $this->db->select("t.name as 'name', tm.tag_id, tm.parent_id");
        $this->db->from("vs_tags as t");
        $this->db->join("vs_tags_media as tm","tm.tag_id = t.id");
        $this->db->where("tm.parent_id",0);
        $query = $this->db->get();
        $medias = array();

        foreach($query->result() as $row) {
            $media = new media($row,$this->id);
            array_push($medias, $media);
        }

        return (object) $medias;
    }

    // PUBLIC
    public function Publish() {
        $this->db->select("mc.id, mc.media_id");
        $this->db->from("vs_media_content as mc");
        $this->db->where("mc.content_id",$this->id);
        $query = $this->db->get();

        foreach($query->result() as $row) {
            $media = new media($row);
            if($media->CheckIfAligable() || $row->media_id == 1 || $row->media_id == 2) {
                $this->db->where("id",$row->id);
                $this->db->update("vs_media_content",array("status" => 2));
            }
            else {
                $this->db->where("id",$row->id);
                $this->db->update("vs_media_content",array("status" => 1));
            }
        }
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
}

class media extends CI_Model {

    public $alias;
    public $tag_id;
    private $parent_id;
    private $content_id;

    public $menu;
    public $favicon;
    public $email;
    public $checked;

    public $attr;
    public $class;
    public $display;

    public function __construct($media = array(), $content_id = 0) {
        $this->id = (isset($media->id) ? $media->id : 0);
        $this->tag_id = (isset($media->tag_id) ? $media->tag_id : 0);
        $this->name = (isset($media->name) ? $media->name : "");
        $this->alias = (isset($media->alias) ? $media->alias : "");
        $this->content_id = $content_id;

        $this->favicon = (isset($media->parent_id) && $media->parent_id == 0 && $this->IsDomainName() ? 'http://g.etfv.co/http://www.'.$this->name."?defaulticon=lightpng" : NULL );
        $this->menu = $this->GetMenu();

        $this->checked = $this->CheckIfSelected();
        $this->class = ($this->checked ? 'checked' : "");
        $this->attr = ($this->checked ? "checked='checked'" : "");
        $this->display = ($this->checked ? "auto" : "none");
    }

    // PRIVATE
    private function CheckIfSelected() {
        $this->db->select("tc.id");
        $this->db->from("vs_tags_content as tc");
        $this->db->where("tc.content_id",$this->content_id);
        $this->db->where("tc.tag_id",$this->tag_id);
        $this->db->limit(1);
        $query = $this->db->get();
        $row = $query->row();

        return (isset($row->id) ? true : false);
    }

    private function GetMenu() {
        $this->db->select("t.id as 'tag_id',t.name, t.alias");
        $this->db->from("vs_tags as t");
        $this->db->join("vs_tags_media as tm","t.id = tm.tag_id");
        $this->db->where("tm.parent_id",$this->tag_id);
        $query = $this->db->get();
        $menu = array();

        foreach($query->result() as $row) {
            $media = new media($row, $this->content_id);
            array_push($menu,$media);
        }

        return (object) $menu;
    }

    // PUBLIC
    public function CheckIfAligable() {
        if($this->id == 1) return true;

        $this->db->select("ul.level");
        $this->db->from("vs_users_level as ul");
        $this->db->where("ul.user_id",$this->session->userdata("UserId"));
        $this->db->where("ul.media_id",$this->id);
        $this->db->limit(1);
        $query = $this->db->get();
        $row = $query->row();

        return (isset($row->level) && $row->level > 2 ? true : false);
    }

    public function IsDomainName() {
        return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $this->name) //valid chars check
            && preg_match("/^.{1,253}$/", $this->name) //overall length check
            && preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $this->name)   ); //length of each label
    }

    public function GetDomainId($name) {
        $this->db->select("id");
        $this->db->from("vs_media as m");
        $this->db->where("m.media",$name);
        $this->db->limit(1);
        $query = $this->db->get();

        return $query->row();
    }
}

class image extends content_model {
    public $url;
    public $format;
    public $category;

    public $thumbnail;
    public $medium;
    public $large;
    public $extra_large;

    public $header;
    public $asoc_id;
    public $cropped;
    public $position;

    function __construct($image = array(), $file = array(), $asoc_id = 0) {
        $this->load->library('image_lib');
        parent::__construct($image);
        parent::CreateOrUpdate();

        $this->type = "multimedia";
        $this->url = (isset($image->url) && $image->url != "" ? $image->url : "style/images/icons/png/pictures.png" );
        $this->url = (isset($file["name"]) && $file["name"] != "" ? $this->UploadImage($file) : $this->url );
        $this->url = (parent::IsValidUrl($file) ? $this->GetImageFromUrl($file) : $this->url );
        $this->format = (!isset($image->format) ? $this->GetFormat() : $image->format );
        $this->category = (isset($image->category) ? $image->category : 'new');

        $this->extra_large = (isset($image->url) ? $this->GetDiferrentSize("xl") : "style/images/icons/png/pictures.png" );
        $this->large = (isset($image->url) ? $this->GetDiferrentSize("l") : "style/images/icons/png/pictures.png" );
        $this->medium = (isset($image->url) ? $this->GetDiferrentSize("m") : "style/images/icons/png/pictures.png" );
        $this->thumbnail = (isset($image->url) ? $this->GetDiferrentSize("s") : "style/images/icons/png/pictures.png" );
        $this->cropped = ($this->CheckIfCropped() ? $this->ReIntUrls() : false );

        $this->header = (isset($image->header) && $image->header == "true" ? true : false );
        $this->asoc_id = (isset($image->asoc_id) ? $image->asoc_id : 0 );
        $this->asoc_id = ($asoc_id != 0 ? $asoc_id : $this->asoc_id );

        $this->position = parent::GetPosition($this->asoc_id, $this->id);
    }

    // PRIVATE
    private function GetFormat($filename = "") {
        $temp = ($filename != "" ? explode(".",$filename) : explode(".",$this->url));
        $format = end($temp);
        $format = ($format == "jpeg" ? "jpg" : $format);

        return strtolower($format);
    }

    private function GetDiferrentSize($size) {
        return "upload/images/".$this->id."/".$size.".".$this->format;
    }

    private function CheckIfCropped() {
        return is_dir("./upload/images/".$this->id."/cropped");
    }

    private function ReIntUrls($folder = "cropped") {
        $this->extra_large = "upload/images/".$this->id."/".$folder."/xl.".$this->format;
        $this->large = "upload/images/".$this->id."/".$folder."/l.".$this->format;
        $this->medium = "upload/images/".$this->id."/".$folder."/m.".$this->format;
        $this->thumbnail = "upload/images/".$this->id."/".$folder."/s.".$this->format;

        return true;
    }

    private function UploadImage($file) {
        if($this->CheckIfCropped()) parent::DeleteFolder('upload/images/'.$this->id.'/cropped',true);

        $format = $this->GetFormat($file["name"]);
        $dir = "upload/images/".$this->id;
        $filename = $this->id.".".$format;
        $target = $dir."/".$filename;

        if(!is_dir($dir)) mkdir($dir,0777);
        if(file_exists($target)) unlink($target);

        move_uploaded_file($file["tmp_name"], $target);

        $this->DisectImage($dir, $target,$format);

        $this->name = ($this->name == "" ? $file["name"] : $this->name);
        return $target;
    }

    private function DisectImage($dir, $tmpName,$format) {
        $thumbnail = $dir."/s.".$format;
        $medium = $dir."/m.".$format;
        $large = $dir."/l.".$format;
        $extra_large = $dir."/xl.".$format;

        if(file_exists($thumbnail)) unlink($thumbnail);
        if(file_exists($medium)) unlink($medium);
        if(file_exists($large)) unlink($large);
        if(file_exists($extra_large)) unlink($extra_large);

        $this->ResizeImage($tmpName, $thumbnail, 100, 83, $format);
        $this->ResizeImage($tmpName, $medium, 300, 250, $format);
        $this->ResizeImage($tmpName, $large, 500, 417, $format);
        $this->ResizeImage($tmpName, $extra_large, 1024, 683, $format);
    }

    private function ResizeImage($src, $dst, $width, $height, $format){
        list($w, $h) = getimagesize($src);

        switch($format){
            case 'bmp': $img = imagecreatefromwbmp($src); break;
            case 'gif': $img = imagecreatefromgif($src); break;
            case 'jpg': $img = imagecreatefromjpeg($src); break;
            case 'png': $img = imagecreatefrompng($src); break;
            default : return "Unsupported picture type!";
        }

        $ratio = min($width/$w, $height/$h);
        $width = $w * $ratio;
        $height = $h * $ratio;
        $x = 0;

        $new = imagecreatetruecolor($width, $height);

        // preserve transparency
        if($format == "gif" or $format == "png"){
            imagecolortransparent($new, imagecolorallocatealpha($new, 0, 0, 0, 127));
            imagealphablending($new, false);
            imagesavealpha($new, true);
        }

        imagecopyresampled($new, $img, 0, 0, $x, 0, $width, $height, $w, $h);

        switch($format){
            case 'bmp': imagewbmp($new, $dst); break;
            case 'gif': imagegif($new, $dst); break;
            case 'jpg': imagejpeg($new, $dst); break;
            case 'png': imagepng($new, $dst); break;
        }
    }

    // PUBLIC
    public function GetImageFromUrl($url) {
        $dir = "upload/images/".$this->id;
        $format = $this->GetFormat($url);
        $target = $dir."/".$this->id.".".$format;

        if(is_dir($dir)) parent::DeleteFolder($dir);
        mkdir($dir,0777);

        file_put_contents($target, file_get_contents($url));
        $this->DisectImage($dir, $target, $format);

        $this->name = ($this->name == "" ? basename($url) : $this->name);
        return $target;
    }

    public function Crop($data) {
        $dir = "./upload/images/".$this->id."/cropped";
        $format = $this->GetFormat();

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

        if(is_dir($dir)) parent::DeleteFolder($dir);

        mkdir($dir,0777);
        $target = $dir."/".$this->id.".".$format;
        $config['new_image'] = $target;

        $this->image_lib->initialize($config);
        $this->image_lib->crop();

        $this->DisectImage($dir,$target,$format);
        $this->ReIntUrls();
    }

    public function GreyScale() {
        $dir = "upload/images/".$this->id."/cropped";
        $filename = $this->id.".".$this->GetFormat();
        $target = $dir."/".$filename;

        // The file you are grayscaling
        $file = ($this->CheckIfCropped() ? $target : $this->url);

        if(!is_dir($dir)) mkdir($dir,0777);

        // Get the dimensions
        list($width, $height) = getimagesize($file);

        // Define our source image
        switch($this->GetFormat()){
            case 'bmp': $source = imagecreatefromwbmp($file); break;
            case 'gif': $source = imagecreatefromgif($file); break;
            case 'jpg': $source = imagecreatefromjpeg($file); break;
            case 'png': $source = imagecreatefrompng($file); break;
            default : return "Unsupported picture type!";
        }

        // Creating the Canvas
        $bwimage = imagecreate($width, $height);

        //Creates the 256 color palette
        for ($c=0;$c<256;$c++) $palette[$c] = imagecolorallocate($bwimage,$c,$c,$c);

        //Creates yiq function
        function yiq($r,$g,$b) {
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

        switch($this->GetFormat()){
            case 'bmp': imagewbmp($bwimage, $target); break;
            case 'gif': imagegif($bwimage, $target); break;
            case 'jpg': imagejpeg($bwimage, $target); break;
            case 'png': imagepng($bwimage, $target); break;
        }

        $this->DisectImage($dir,$target,$this->GetFormat());
        $this->ReIntUrls();
    }

    public function FlipImage($mode = "horizontal") {
        $dir = "upload/images/".$this->id."/cropped";
        $filename = $this->id.".".$this->GetFormat();
        $target = $dir."/".$filename;

        // The file you are grayscaling
        $file = ($this->CheckIfCropped() ? $target : $this->url);

        if(!is_dir($dir)) mkdir($dir,0777);

        $config['image_library'] = 'gd2';
        $config['source_image'] = $file;
        $config['new_image'] = $target;
        $config['rotation_angle'] = ($mode == "horizontal" ? "hor" : "vrt");
        $this->image_lib->initialize($config);

        $this->image_lib->rotate();
        $this->DisectImage($dir,$target,$this->GetFormat());
    }

    public function CreateOrUpdate() {
        $image = array(
            "url" => $this->url,
            "format" => $this->format,
            "category" => $this->category
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

    // PRIVATE
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

    // PUBLIC
    public function CreateOrUpdate() {
        if($this->asoc_id > 0) parent::CreateOrUpdateContentAsoc($this->asoc_id, $this->id, "gallery");

        parent::CreateOrUpdate();
    }

    public function TransferImages($source, $image) {
        $dir = "./upload/images/".$image->id;

        if(is_dir($dir)) parent::DeleteFolder($dir);
        mkdir($dir);

        $image->url = $dir."/".$image->id.".".$source->format;
        $image->extra_large = $dir."/xl.".$source->format;
        $image->large = $dir."/l.".$source->format;
        $image->medium = $dir."/m.".$source->format;
        $image->thumbnail = $dir."/s.".$source->format;
        $image->format = $source->format;

        copy($source->url,$image->url);
        copy($source->extra_large,$image->extra_large);
        copy($source->large,$image->large);
        copy($source->medium,$image->medium);
        copy($source->thumbnail,$image->thumbnail);
    }

    public function GetGalleryImages() {
        $this->db->select("c.id,c.name,c.description,c.ref_id,m.url,m.format");
        $this->db->from("vs_content as c");
        $this->db->join("vs_multimedias as m","c.ref_id = m.id");
        $this->db->where("c.type","multimedia");
        $this->db->where("m.url != 'style/images/icons/png/pictures.png'");
        $this->db->where("c.name != 'Error'");
        $this->db->where("m.category != 'gallery'");
        $this->db->where("m.format","jpg");
        $this->db->or_where("m.format","gif");
        $this->db->or_where("m.format","png");
        $this->db->or_where("m.format","bmp");
        $this->db->limit(20);
        $query = $this->db->get();
        $gallery = array();

        foreach($query->result() as $row) {
            $image = new image($row);
            array_push($gallery,$image);
        }

        return (object) $gallery;
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
        $this->format = "mp4";
        $this->source = ($this->content_model->IsValidUrl($this->url) ? "internet" : "local" );

        $this->position = (isset($video->position) ? parent::HandlePosition($this->asoc_id, $this->id, $video->position) : "bottom");
    }

    // PRIVATE
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
        $this->name = (trim($this->name) == "" ? basename($file["name"]) : $this->name);

        return $target;
    }

    // PUBLIC
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

class bug extends content_model {
    public $status;
    public $priority;
    public $fixed;
    public $fixed_by;
    public $images;

    function __construct($bug = array(), $file = array()) {
        parent::__construct($bug);
        parent::CreateOrUpdate();

        $this->type = "bug";
        $this->status = (isset($bug->status) ? $bug->status : "not resolved" );
        $this->priority = (isset($bug->priority) ? $bug->priority : 0 );
        $this->fixed = (isset($bug->fixed) ? $bug->fixed : NULL );
        $this->fixed_by = (isset($bug->fixed_by) ? $bug->fixed_by : NULL );
        $this->images = $this->GetImages();

        if(isset($file["name"]) && $file["name"] != "") $this->UploadImage($file);
    }

    // PRIVATE
    private function GetImages() {
        $this->db->select("cc.ref_content_id");
        $this->db->from("vs_content_content as cc");
        $this->db->where("cc.content_id",$this->id);
        $this->db->where("cc.correlation","image");
        $query = $this->db->get();
        $images = array();

        foreach($query->result() as $row) {
            $image = parent::GetById($row->ref_content_id);
            array_push($images,$image);
        }

        return (object) $images;
    }

    private function UploadImage($file) {
        $data = array(
            "name" => $this->name,
            "description" => $this->description,
            "asoc_id" => $this->id,
            "type" => "multimedia",
            "tags" => implode(',',$this->tags)
        );

        $image = new image((object) $data,$file);
        $image->CreateOrUpdate();
    }

    // PUBLIC
    public function CreateOrUpdate() {
        $bug = array(
            "status" => $this->status,
            "priority" => $this->priority,
            "fixed" => $this->fixed,
            "fixed_by" => $this->fixed_by
        );

        if($this->ref_id > 0) {
            $this->db->where("id",$this->ref_id);
            $this->db->update("vs_bugs",$bug);
        }
        else {
            $this->db->insert("vs_bugs",$bug);
            $this->ref_id = $this->db->insert_id();
        }

        parent::CreateOrUpdate();
    }

    public function GetAll() {
        $this->db->select("c.id");
        $this->db->from("vs_content as c");
        $this->db->where("c.type","bug");
        $this->db->order_by("c.id","desc");
        $query = $this->db->get();
        $errors = array();

        foreach($query->result() as $row) {
            $bug = parent::GetById($row->id);
            array_push($errors,$bug);
        }

        return (object) $errors;
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
        $this->format = "mp3";
    }

    // PRIVATE
    private function UploadAudio($file) {
        $dir = "upload/audio/".$this->id;
        $target = $dir."/".$this->content_model->CreateSlug($file["name"]).".mp3";

        if(!is_dir($dir)) mkdir($dir,0777);
        if(file_exists($target)) unlink($target);

        move_uploaded_file($file["tmp_name"], $target);
        $this->name = (trim($this->name) == "" ? basename($file["name"]) : $this->name);

        return $target;
    }

    // PUBLIC
    public function CreateOrUpdate() {
        $video = array(
            "url" => (string) $this->url,
            "format" => (string) $this->format
        );


        $this->db->insert("vs_multimedias",$video);
        $this->ref_id = $this->db->insert_id();



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

    // PRIVATE
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

    // PUBLIC
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

    // PRIVATE

    // PUBLIC
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
        $this->google_image = "http://maps.googleapis.com/maps/api/staticmap?center=".parent::CreateSlug($this->country).",".parent::CreateSlug($this->city).",".parent::CreateSlug($this->street_village).",".parent::CreateSlug($this->house_number)."&zoom=16&size=300x200";
    }

    // PRIVATE

    // PUBLIC
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
