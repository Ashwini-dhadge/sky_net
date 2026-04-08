<?php

/**
 * 
 */
class UserResultReport extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'LearnerProgressReportModel');


        loginId();
    }
    public function index()
    {
        $data['title'] = 'Sales Report';
        //    $data['products'] = $this->CommonModel->getData('tbl_products','','',array('id','product_name','sku') );

        $this->load->view(ADMIN . 'userResultReport/list', $data);
    }

    public function getSectionResult()
    {
        $course_id = $this->input->post('course_id');
        $section_id = $this->input->post('section_id');
        $user_id = $this->input->post('user_id');

        $result = $this->LearnerProgressReportModel->getSectionResultDetails($course_id, $section_id, $user_id);
        // echo "<pre>";
        // print_r($result);
        // die;
        echo json_encode($result);
    }
}