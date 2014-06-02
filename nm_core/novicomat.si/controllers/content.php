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
	
	public function Create() {

	}
	
	public function CreateArticle() {
		$article = new article();
		$article->CreateOrUpdate();
		
		redirect(base_url()."Prispevek/".$article->id."/Urejanje");
	}

    public function DeleteAttachment() {
        $content_id = $this->input->post("asoc_id");
        $ref_content_id = $this->input->post("id");

        $this->db->delete("vs_content_content",array("content_id" => $content_id, "ref_content_id" => $ref_content_id));
    }



    public function Update() {
		$content = (object) $this->input->post("content");
        $upload = $this->reArrange($_FILES["content"]);

        foreach($upload as $file) {
            echo $file["name"]."<br>";
            echo $file["tmp_name"]."<br>";
            echo $file["type"]."<br>";
            echo $file["size"]."<br>";
            echo "<hr>";

            //echo $file["name"]."<br>";
            //echo $file["type"]."<br>";
            //echo $file["size"]."<br>";
        }

		/*switch($content->type) {
			case "article":
                $data = new article($content,$upload);
                $data->CreateOrUpdate();
				break;
			case "multimedia":
                $data = new image($content,$upload);
                $data->CreateOrUpdate();
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
		}

        $ref_id = (isset($content->asoc_id) && $content->asoc_id > 0 ? $content->asoc_id : $content->id);

        redirect(base_url()."Prispevek/".$ref_id."/Urejanje");*/
	}
	
	public function View($articleId) {
		$article = $this->content_model->GetById($articleId);
		$user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));

		$var = array("article" => $article, "user" => $user);

		if($article->state > 2 || $article->created_by == $user->id)
			$this->template->load_tpl('master',$article->title,'content/article/view',$var);
		else redirect(base_url()."Domov","refresh");
	}
	
	public function Edit($contentId) {
		$content = $this->content_model->GetById($contentId);
		$user = $this->user_model->Get(array("criteria" => "id", "value" => $this->session->userdata("userId"), "limit" => 1));
		
		$var = array("article" => $content, "user" => $user);
		
		if($content->created_by == $user->id) {
			$this->template->load_tpl('master','Urejanje','content/edit',$var);
		}
		else redirect(base_url()."Domov","refresh");
	}
	
	public function Delete($contentId) {
		$content = $this->content_model->GetById($contentId);
		
		$this->db->delete('vs_'.$content->type,array('id' => $content->ref_id));
		$this->db->delete('vs_content', array('id' => $content->id));
	}
	
	public function RemoveTagFromarticle() {
		$articleId = $this->input->post("articleId");
		$Tag = $this->tag_model->GetTag($this->input->post("Tag"));
		
		$this->tag_model->RemoveTagLink($articleId,$Tag->id);
	}
	
	public function CropImage() {
		$crop = (object) $this->input->post("crop");

        $image = $this->content_model->GetById($crop->image_id, "multimedia");
        $image->Crop($crop);
        $image->CreateOrUpdate();

        echo base_url().$image->cropped;
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
}

class file {
    public $name;
    public $tmp_name;
    public $size;
    public $type;
    public $error;

    public function __construct($file) {

    }

    private function reArrange ( &$file_post )
    {
        $file_array = array();

        foreach($file_post['name']["file"] as $k => $name) {
            $this->name = $name;
            $this->tmp_name = $file_post['tmp_name']["file"][$k];
            $this->size = $file_post['size']["file"][$k];
            $this->type = $file_post['type']["file"][$k];
            $this->error = $file_post['error']["file"][$k];

            array_push($file_array,$this);
        }

        return (object) $file_array;
    }
}

?>