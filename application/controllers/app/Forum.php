<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forum extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('app/Authentication_model');
        // $this->load->model('app/Common_model');
    }



    public function createForumPost()
    {
        authenticateUser();
        $user_id = $this->regId;
        print_r($user_id);
        die;
    }
}