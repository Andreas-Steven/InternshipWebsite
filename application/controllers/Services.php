<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model(array('mservices'));
         // $this->tokenInfo= $this->mauth->resolveToken($this->input->request_headers());
         // $this->tokenData=$this->tokenInfo['data'];
    }   

    function login() {
        $data = (Object)$this->input->post();
        // var_dump($data);die();

        $user = $this->mwidget->validateLogin($data->userid, $data->password);

        // var_dump($user);die();

        if (!empty($user)) {
            $return["message"]="OK";
            $return["statuscode"]=200;    
            $return["token"]=jwt::encode($user, "f1111d64c8e1aac3ad72b475398718af");
            // $return["user"]=$user;
            // header("Location: https://demo.cakra.ai/08192830787dah0823hasjkjas818763jjamkpsvn9/demov3.html?a=aa7be6262c1926ef6ae0e913c3aef790&q=hai");
            // exit();
        } else {
            $return["message"]="Invalid Login";
            $return["statuscode"]=201;
            // header("Location: https://demo.cakra.ai/widget/");
            // exit();  
        }
        
        echo json_encode($return);
        // return;

    }

    function refreshToken() {
        $data = (Object)$this->input->post();
        // var_dump($data);die();

        $user = $this->mwidget->refreshToken($data->id);

        // var_dump($user);die();

        if (!empty($user)) {
            $return["message"]="OK";
            $return["statuscode"]=200;    
            $return["token"]=jwt::encode($user, "f1111d64c8e1aac3ad72b475398718af");
        } else {
            $return["message"]="Invalid ID";
            $return["statuscode"]=201;
            header("Location: login");
        }
        
        echo json_encode($return);
        // return;

    }


    function log_session() {

        $input  = $this->input->post();
        
        $data   = $this->mservices->log_session($input);

        echo json_encode(array("session_id"=>$data));
    }


    function update_session() {

        $input  = $this->input->post();
        
        $data   = $this->mservices->update_session($input);

        echo $data;
    }

    function login() {
        $input  = $this->input->post();
        $data   = $this->mservices->login($input);

        echo json_encode(array("session_id"=>$data));

    }




}
