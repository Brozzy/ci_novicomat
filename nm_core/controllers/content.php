<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); require('base.php');

class content extends base {

	function __construct() {
		parent::__construct();

		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model("content_model");
		$this->load->model("media_model");
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

    public function Update($publish = false, $type = "article") {
        $publish = (bool) $publish;
        $content = (object) $this->input->post("content");
        $data = "";

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
            case "image":
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
            case "bug":
                if(empty($upload)) {
                    $data = new bug($content);
                    $data->CreateOrUpdate();
                }
                else {
                    foreach($upload as $file) {
                        $data = new bug($content,$file);
                        $data->CreateOrUpdate();
                    }
                }
                break;
        }

        if(!$publish && $type == "article") {
            $ref_id = (isset($content->asoc_id) && $content->asoc_id > 0 ? $content->asoc_id : $content->id);
            redirect(base_url()."Prispevek/".$ref_id."/Urejanje");
        }
        else if(!$publish) { redirect(base_url()."Domov"); }
        else return $data;
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

        if($content->IsEligible($user->id)) $this->template->load_tpl('home','Urejanje','content/edit',$var);
        else redirect(base_url()."Domov","refresh");
    }

    public function Publish() {
        $article = $this->Update(true);
        $article->Publish();

        redirect(base_url()."Domov","refresh");
    }

    public function GetByTag($tag = "") {
        $media = $this->media_model->GetNavigation();
        $contents = $this->content_model->GetMediaContent($media, $tag);

        echo json_encode($contents);
    }

    public function GetModal($modal) {
        $js = $this->input->post('ajax');
        $asoc_id = 0;
        $hidden = (object) $this->input->post('hidden');
        foreach($hidden as $hid) { if($hid['name'] == 'asoc_id') { $asoc_id = $hid['value']; break; } };

        $content = $this->content_model->GetById($this->input->post("id"), $asoc_id);

        if($js) echo $this->load->view('home/forms/'.$modal, array('content' => $content, 'hidden' => $hidden));
        else {
            $user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));
            $this->template->load_tpl('home','Obrazec','forms/'.$modal, array('content' => $content, 'hidden' => $hidden, 'user' => $user));
        }
    }

    public function AddEditor() {
        $partial_user = (object) $this->input->post("user");
        $content = (object) $this->input->post("content");

        $user = ($partial_user->username != "" ? $this->user_model->GetByUsername($partial_user->username): $this->user_model->GetByEmail($partial_user->email) );
        if(isset($user->id)) $this->db->insert('vs_content_users', array('user_id' => $user->id, 'content_id' => $content->asoc_id, 'access_level' => $partial_user->access_level ));

        redirect(base_url()."Prispevek/".$content->asoc_id."/Urejanje");
    }

    // ERRORS
    public function Errors() {
        $errors = new bug();
        $user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));

        $var = array("errors" => $errors->GetAll(), "user" => $user);
        $this->template->load_tpl('home','Pregled napak','error/view',$var);
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
        $this->db->delete("vs_content_content",array("content_id" => $this->input->post("asoc_id"), "ref_content_id" => $this->input->post("id")));
    }

    // TAGS
	public function RemoveTagFromarticle() {
		$articleId = $this->input->post("articleId");
		$Tag = $this->tag_model->GetTag($this->input->post("Tag"));
		
		$this->tag_model->RemoveTagLink($articleId,$Tag->id);
	}

    // AUTOCOMPLETE
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

            foreach($query->result() as $tag) array_push($response,strtolower($tag->name));
        }

        echo json_encode($response);
    }

    public function GetUsers($method = 'username') {
        $term = $_REQUEST["term"];
        $response = array();

        if($term != "" && $term != " ") {
            $this->db->select("u.".$method);
            $this->db->from("vs_users as u");
            $this->db->like('u.'.$method,$term,"after");
            $this->db->limit(10);
            $query = $this->db->get();

            foreach($query->result() as $user) {
                array_push($response,($method == 'username' ? strtolower($user->username) : strtolower($user->email)));
            }
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

        $sizes = array(
            "extra_large" => $image->extra_large,
            "large" => $image->large,
            "medium" => $image->medium,
            "small" => $image->thumbnail
        );

        echo json_encode($sizes);
    }

    public function GreyscaleImage() {
        $content = (object) $this->input->post("content");

        print_r($content);

        $image = $this->content_model->GetById($content->id);
        $image->GreyScale();
        $image->CreateOrUpdate();

        $sizes = array(
            "extra_large" => $image->extra_large,
            "large" => $image->large,
            "medium" => $image->medium,
            "small" => $image->thumbnail
        );

        echo json_encode($sizes);
    }

    public function FlipImage() {
        $content = (object) $this->input->post("content");

        $image = $this->content_model->GetById($content->id);
        $image->FlipImage($content->mode);
        $image->CreateOrUpdate();

        $sizes = array(
            "extra_large" => $image->extra_large,
            "large" => $image->large,
            "medium" => $image->medium,
            "small" => $image->thumbnail
        );

        echo json_encode($sizes);
    }

    public function SetGalleryImage() {
        $gallery = new gallery();
        $data = (object) $this->input->post("gallery");
        $source = $this->content_model->GetById($data->id);
        $image = ($data->update_id != "" && $data->update_id != "0" ? $image = $this->content_model->GetById($data->update_id) : new image());

        $image->CreateOrUpdate();

        $image->category = 'gallery';
        $image->asoc_id = $data->asoc_id;
        $image->header = ($data->header == "true" ? true : false);
        $image->name = $source->name;
        $image->description = $source->description;

        $gallery->TransferImages($source,$image);
        $image->HandleTags(implode(',',$source->tags));
        $image->CreateOrUpdate();

        redirect(base_url()."Prispevek/".$data->asoc_id."/Urejanje");
    }

    public function GetGalleryImages() {
        $gallery = new gallery();
        echo json_encode($gallery->GetGalleryImages());
    }

    public function ImagePosition() {
        $data = (object) $this->input->post("position");

        $this->db->where("content_id",$data->asoc_id);
        $this->db->where("ref_content_id",$data->image_id);
        $this->db->update("vs_content_content",array("position" => $data->position ));
    }

    // BUG REPORT
    public function RemoveBug() {
        $id = $this->input->post("id");

        $this->db->where("id",$id);
        $this->db->delete("vs_content");
    }

    public function ReportBug() {
        $this->Update(false,"bug");
    }
}

?>