<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('app/Authentication_model');
        // $this->load->model('app/Common_model');
    }



    public function testapi()
    {
        authenticateUser();
        $response['result'] = true;
        $response['reason'] = "Test Api Sucess";
        echo json_encode($response);
    }
}
