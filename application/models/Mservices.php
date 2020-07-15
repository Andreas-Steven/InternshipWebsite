<?php

class Mservices extends CI_Model {

    function validateLogin($userid, $password){

        // $statement = $this->db->limit(1)
        //         ->select("*, md5(id::text) idmd5")
        //         ->where("password",$password)
        //         ->or_where("verification_key",$password)
        //         ->and_where("email",$userid)
        //         ->or_where("phone",$userid)
        //      ->get('ai.ai_user');
        $str = "SELECT *, md5(id::text) idmd5
                FROM ai.ai_user
                WHERE (password = '$password' OR verification_key = '$password')
                AND (email = '$userid' OR phone = '$userid')
                LIMIT 1
                ";
        $statement = $this->db->query($str);


        if ($statement->num_rows()>0){
            $result =  $statement->row();
            
            // 20200531 - update last login dan login_status
            $this->db->set("last_login",date('Y-m-d H:i:s'))
                    ->set("login_status",1)
                    ->where("id",$result->id)->update("ai.ai_user");
            
            return $result;
        }else{
            return NULL;
        }
    }

    function refreshToken($id){
    // var_dump($id);die();

        $statement = $this->db->limit(1)
                ->get_where('ai.ai_users', array("md5(id::text)"=>$id));

        if ($statement->num_rows()>0){
            return $statement->row();
        }else{
            return NULL;
        }
    }

    // session logger dan visitor
    function log_session($input) {
        if (!isset($_SESSION['awr_session'])) {
                $awr_session = bin2hex(random_bytes(20));
                $this->session->set_userdata(array("awr_session"=>$awr_session));
            }

        $this->log_visitor($_SESSION['awr_session']);
        $this->log_visitor_activity($_SESSION['awr_session'],$input);

        return $_SESSION['awr_session'];
    }

    function update_session($data) {

        // var_dump($data); die();
        if ($data) {
            $this->db->set("lng",$data['lng'])
                    ->set("lat",$data['lat'])
                    ->where("session_id",$data['session_id'])
                    ->update("log.visitor");

        }

        echo "OK";
    }

    private function log_visitor($session) {

        $ip =  getenv('REMOTE_ADDR')?:
        getenv('HTTP_CLIENT_IP')?:
        getenv('HTTP_X_FORWARDED_FOR')?:
        getenv('HTTP_X_FORWARDED')?:
        getenv('HTTP_FORWARDED_FOR')?:
        getenv('HTTP_FORWARDED');

        if ($this->agent->is_browser())
        {
            $agent = $this->agent->browser().' '.$this->agent->version();
        }
        elseif ($this->agent->is_robot())
        {
            $agent = $this->agent->robot();
        }
        elseif ($this->agent->is_mobile())
        {
            $agent = $this->agent->mobile();
        }
        else
        {
            $agent = 'Unidentified User Agent';
        }

        $data = array (

              "waktu" => date("Y-m-d H:i:s")
            , "platform" => $this->agent->platform()
            , "ip_address" => $ip
            , "browser" => $agent
            , "session_id" => $session
            
            );
        $table = 'log.visitor';

        $found = $this->db->limit(1)->get_where($table,array("session_id"=>$session))->row();

        if (!$found)
            $this->db->insert($table,$data);
    }

    private function log_visitor_activity($session,$input) {

        // var_dump($input);

        $path = isset($input["path"]) ? $input["path"] : getUri();

        $data = array (
              "waktu" => date("Y-m-d H:i:s")
            , "activity" => $path
            , "session_id" => $session          
            );

        $this->db->insert('log.visitor_activity',$data);
    }


    // Function untuk cek berkala user2 yang top last aktif di bot
    function getlist()
    {
        $limit_time = $this->db->limit(1)->get_where("public.lookup",array("lookupkey"=>'session_chat_time'))->row()->lookupvalue;

        $str = "select user_id, last_bot_id bot_id, max(status) live_request
                from ai.livechat
                where COALESCE(live_end_time,request_end_time,request_start_time,live_start_time) > now() - interval '$limit_time'
                group by user_id, bot_id";

        $query = $this->db->query($str);
        
        if ($query->num_rows() > 0)
        {
           return $query->result_array();
        }
        else
            return NULL;
    }




}