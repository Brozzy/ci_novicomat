<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class content extends base {

	function __construct() {
		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("content_model");
		$this->load->model("domain_model");
		$this->load->model("tag_model");
	}

    // CONTENT CRUD (CREATE READ UPDATE DELETE)
	public function Create() {
        $article = new article();
        $article->CreateOrUpdate();

        redirect(base_url()."Prispevek/".$article->id."/Urejanje");
	}

    public function Read($contentId) {
        $content = $this->content_model->GetById($contentId);
        $user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));
        $gallery = new gallery();
        $gallery_images = $gallery->GetGalleryImages();

        $var = array("content" => $content, "user" => $user);

        if($content->created_by == $user->id) {
            $this->template->load_tpl('home','Urejanje','content/view',$var);
        }
        else redirect(base_url()."Domov","refresh");
    }

    public function Update() {
        $content = (object) $this->input->post("content");
        $internetFiles = (isset($content->from_internet) ? $content->from_internet : "");
        $upload = (isset($_FILES["content"]) && $_FILES["content"] != "" ? $this->GetFiles($_FILES["content"], $internetFiles) : array());

        switch($content->type) {
            case "article":
                $data = new article($content,$upload);
                $data->CreateOrUpdate();
                break;
            case "multimedia":
                if(empty($upload)) {
                    $data = new image($content);
                    $data->CreateOrUpdate();
                }
                else {
                    foreach($upload as $file) {
                        $data = new image($content, $file);
                        $data->CreateOrUpdate();
                    }
                }
                break;
            case "event":
                $data = new event($content,$upload);
                $data->CreateOrUpdate();
                break;
            case "location":
                $data = new location($content,$upload);
                $data->CreateOrUpdate();
                break;
            case "gallery":
                $data = new gallery($content,$upload);
                $data->CreateOrUpdate();
                break;
            case "video":
                if(empty($upload)) {
                    $content->type = "multimedia";
                    $data = new video($content);
                    $data->CreateOrUpdate();
                }
                else {
                    foreach($upload as $file) {
                        $content->type = "multimedia";
                        $data = new video($content,$file);
                        $data->CreateOrUpdate();
                    }
                }
                break;
            case "audio":
                if(empty($upload)) {
                    $content->type = "multimedia";
                    $data = new audio($content);
                    $data->CreateOrUpdate();
                }
                else {
                    foreach($upload as $file) {
                        $content->type = "multimedia";
                        $data = new audio($content,$file);
                        $data->CreateOrUpdate();
                    }
                }
                break;
            case "document":
                if(empty($upload)) {
                    $content->type = "multimedia";
                    $data = new document($content);
                    $data->CreateOrUpdate();
                }
                else {
                    foreach($upload as $file) {
                        $content->type = "multimedia";
                        $data = new document($content,$file);
                        $data->CreateOrUpdate();
                    }
                }
                break;
        }

        $ref_id = (isset($content->asoc_id) && $content->asoc_id > 0 ? $content->asoc_id : $content->id);

        redirect(base_url()."Prispevek/".$ref_id."/Urejanje");
    }

    public function Delete($contentId) {
        $content = $this->content_model->GetById($contentId);

        $this->db->delete('vs_'.$content->type.'s',array('id' => $content->ref_id));
        $this->db->delete('vs_content', array('id' => $content->id));

        redirect(base_url()."Domov");
    }

    public function Edit($contentId) {
        $content = $this->content_model->GetById($contentId);
        $user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));
        $gallery = new gallery();
        $gallery_images = $gallery->GetGalleryImages();

        $var = array("article" => $content, "user" => $user, "gallery" => $gallery_images);

        if($content->created_by == $user->id) {
            $this->template->load_tpl('home','Urejanje','content/edit',$var);
        }
        else redirect(base_url()."Domov","refresh");
    }

    // ATTACHMENTS
    private function GetFiles($file_post,$internet_urls)
    {
        $file_array = array();

        if($internet_urls != "" && $internet_urls != " ") {
            foreach(explode(",",$internet_urls) as $url) {
                $url = trim($url);
                $url = str_replace("https","http",$url);
                if($url != "" && $url != " ")
                    array_push($file_array,trim($url));
            }
        }
        if(isset($file_post['name']['file']) && $file_post['name']['file'] != "") {
            foreach($file_post['name']["file"] as $k => $name) {
                $file = array(
                    "name" => $name,
                    "tmp_name" => $file_post['tmp_name']["file"][$k],
                    "size" => $file_post['size']["file"][$k],
                    "type" => $file_post['type']["file"][$k],
                    "error" => $file_post['error']["file"][$k]
                );

                if($name != "" && $name != " ") {
                    array_push($file_array,$file);
                }
            }
        }

        return $file_array;
    }

    public function DeleteAttachment() {
        $attachment = (object) $this->input->post("attachment");

        $this->db->delete("vs_content_content",array("content_id" => $attachment->asoc_id, "ref_content_id" => $attachment->content_id));
    }

    // TAGS
	public function RemoveTagFromarticle() {
		$articleId = $this->input->post("articleId");
		$Tag = $this->tag_model->GetTag($this->input->post("Tag"));
		
		$this->tag_model->RemoveTagLink($articleId,$Tag->id);
	}

    public function GetTags() {
        $term = $_REQUEST["term"];
        $tags = explode(',',$term);
        $tag = trim(end($tags));
        $response = array();

        if($tag != "" && $tag != " ") {
            $this->db->select("t.name");
            $this->db->from("vs_tags as t");
            $this->db->like('t.name',$tag,"after");
            $this->db->limit(10);
            $query = $this->db->get();

            foreach($query->result() as $tag) array_push($response,$tag->name);
        }

        echo json_encode($response);
    }

    // EVENTS
    public function GetEvents() {
        $name = $_REQUEST["event"];
        $response = array();

        if($name != "" && $name != " ") {
            $this->db->select("c.*, e.start_date, e.end_date");
            $this->db->from("vs_events as e");
            $this->db->join("vs_content as c","c.ref_id = e.id","inner");
            $this->db->where("c.type","event");
            $this->db->like('c.name',$name,"after");
            $this->db->limit(10);
            $query = $this->db->get();

            foreach($query->result() as $event)
                array_push($response,$event->name." (".$event->description."), od ".$event->start_date." do ".$event->end_date);
        }

        echo json_encode($response);
    }

    // UPLOAD AND EDIT IMAGE
    public function CropImage() {
        $crop = (object) $this->input->post("crop");

        $image = $this->content_model->GetById($crop->image_id, "multimedia");
        $image->Crop($crop);
        $image->CreateOrUpdate();

        redirect(base_url()."Prispevek/".$crop->asoc_id."/Urejanje");
    }

    public function GreyscaleImage() {
        $image = (object) $this->input->post("image");

        $content = $this->content_model->GetById($image->image_id, "multimedia");
        $content->GreyScale();
    }

    public function FlipImage() {
        $image = (object) $this->input->post("image");

        $content = $this->content_model->GetById($image->image_id, "multimedia");
        $content->FlipImage();

        redirect(base_url()."Prispevek/".$image->asoc_id."/Urejanje");
    }

    public function SetGalleryImage() {
        $gallery = (object) $this->input->post("gallery");
        $temp = new gallery();

        $data = array(
            "header" => true,
            "asoc_id" => $gallery->asoc_id,
            "type" => "multimedia",
            "name" => $gallery->name,
            "description" => $gallery->description
        );

        if($gallery->update == "true") {
            $temp->TransferImages($gallery->id,$gallery->update_id,basename($gallery->url));
            $this->db->where("id",$gallery->update_ref_id);
            $this->db->update("vs_multimedias",array("url" => "upload/images/full_size/".$gallery->update_id."/".basename($gallery->url), "format" => $gallery->format));
        }
        else if($gallery->header == "true") {
            $image = new image((object) $data);
            $image->url = "upload/images/full_size/".$image->id."/".basename($gallery->url);
            $image->CreateOrUpdate();
            $temp->TransferImages($gallery->id,$image->id,basename($gallery->url));
        }
        else {
            $data["header"] = false;
            $image = new image((object) $data);
            $image->url = "upload/images/full_size/".$image->id."/".basename($gallery->url);
            $image->CreateOrUpdate();
            $temp->TransferImages($gallery->id,$image->id,basename($gallery->url));
        }

        redirect(base_url()."Prispevek/".$gallery->asoc_id."/Urejanje");
    }

    public function ImagePosition() {
        $data = (object) $this->input->post("position");
        $this->db->where("id",$data->image_id);
        $this->db->update("vs_multimedias",array("position" => $data->position ));
    }

}

?>