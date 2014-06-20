<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class token_model extends CI_Model {

    /**
     * @param $user_id id from user
     * @param $hour_diff positive integer for hour different
     * @usage
     * returns new token is the new token is older than $hour_diff
     * returns existing token if the token is younger than $hour_diff
     */
    public function CheckToken($user_id, $hour_diff)
    {
        $this->db->select("t.token_id as id, t.token, TIMESTAMPDIFF(HOUR, t.token_created, NOW()) as diff, t.user_id, t.used");
        $this->db->from("vs_token as t");
        $this->db->where("t.user_id", $user_id);
        $this->db->where("t.used", '0');
        $this->db->limit(1);
        $query = $this->db->get();
        $token = $query->row();
        //Instance of the current class
        $model = new token_model();

        if(isset($token->id))
        {
            if($token->diff > $hour_diff || $model->TokenUsed($token->token))
            {
                $model->useToken($token->token);
                $new_token = $model->EncryptToken($user_id);
                $model->InsertToken($new_token, $user_id);
                return $new_token;
            }
            else //returns current token if its younger than the spcified value
                return $token->token;
        }
        else
        {
            $new_token = $model->EncryptToken($user_id);
            $model->InsertToken($new_token, $user_id);
            return $new_token;
        }
    }

//--------------------------------------------------------------------------------------------------------------------------

    /**
     * @param $token
     * @usage sets vs_token.used table value to 1
     */
    public function useToken($token)
    {
        $data = array(
            "used" => 1
        );
        $this->db->where("t.token",$token);
        $this->db->update("vs_token as t",$data);
    }
//--------------------------------------------------------------------------------------------------------------------------

    public function TokenUsed($token)
    {
        //escaping the token
        $tokenCheck = $this->db->escape($token);
        //outputs escaped string without quotes
        $token = substr($tokenCheck,1,(strlen($tokenCheck) - 2));

        $this->db->select("t.used");
        $this->db->from("vs_token as t");
        $this->db->where("t.token", $token);
        $this->db->where("t.used", 0);
        $this->db->limit(1);
        $query = $this->db->get();

        $query = $query->row();

        if(isset($query->used))
            return false;
        else
            return true;
    }
//--------------------------------------------------------------------------------------------------------------------------
    public function TokenExpired($token,$hours)
    {
        //escaping the token
        $tokenCheck = $this->db->escape($token);
        //outputs escaped string without quotes
        $token = substr($tokenCheck,1,(strlen($tokenCheck) - 2));

        $this->db->select("TIMESTAMPDIFF(HOUR, t.token_created, NOW()) as diff");
        $this->db->from("vs_token as t");
        $this->db->where("t.token", $token);
        $this->db->limit(1);

        $query = $this->db->get();
        $query = $query->row();

        if(isset($query->diff))
        {
            if($query->diff > $hours)
                return true;
            else
                return false;
        }
        else
            return false;

    }
//--------------------------------------------------------------------------------------------------------------------------
    public function InsertToken($token,$user_id)
    {
        $data = array(
            "user_id" => $user_id,
            "token" => $token,
            "used" => 0
        );
        $this->db->insert("vs_token", $data);
    }
//--------------------------------------------------------------------------------------------------------------------------
    private function EncryptToken($username)
    {
        return md5(rand(5,20).$username.rand(5,15));
    }
}