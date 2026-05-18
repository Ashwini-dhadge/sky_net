<?php

/**
 * 
 */
class FinalExamReport extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'FinalExamReportModel');


        loginId();
    }
    public function index()
    {
        $data['title'] = 'Sales Report';
        //    $data['products'] = $this->CommonModel->getData('tbl_products','','',array('id','product_name','sku') );

        $this->load->view(ADMIN . 'finalExamReport/list', $data);
    }

    // public function listFinalExamReport()
    // {
    //     $course_id = $this->input->post('course_id');
    //     $section_id = $this->input->post('section_id');
    //     $user_id = $this->input->post('user_id');

    //     $result = $this->FinalExamReportModel->getFinalExamReportDetails($course_id, $section_id, $user_id);
    //     // echo "<pre>";
    //     // print_r($result);
    //     // die;
    //     echo json_encode($result);
    // }
    public function listFinalExamReport()
    {
        $data = $_POST;

        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];

        $where = [];
        if (isset($data['course_id']) && !empty($data['course_id'])) {
            $where['luv.courses_id'] = $data['course_id'];
        }
        if (isset($data['user_id']) && !empty($data['user_id'])) {
            $where['luv.user_id'] = $data['user_id'];
        }
        if ($data['course_type'] != '') {
            $where['tc.course_type'] = $data['course_type'];
        }
        // echo "<pre>";
        // print_r($where);
        // die;
        // total records
        $count = count($this->FinalExamReportModel
            ->getFinalExamReportDetails($searchVal, 0, 0, 0, 0, '', $where));
        // echo $this->db->last_query();
        // die;
        $columns = [];

        if ($count) {

            $result = $this->FinalExamReportModel
                ->getFinalExamReportDetails($searchVal, $sortColIndex, $sortBy, $limit, $offset, '', $where);
            // echo "<pre>";
            // print_r($result);
            // die;

            foreach ($result as $key => $value) {

                $row = [];
                $row[] = $offset + ($key + 1);
                $row[] = $value['student_name'];
                $row[] = $value['course_name'];

                $exam = json_decode($value['result'], true);

                $total   = $exam['total_question'] ?? 0;
                $correct = $exam['correct_question'] ?? 0;
                $wrong   = $exam['wrong_question'] ?? 0;


                $row[] = $total;
                $row[] = $correct;
                $row[] = $wrong;
                $columns[] = $row;
            }
        }

        $response = [
            'draw' => intval($page),
            'data' => $columns,
            'recordsTotal' => $count,
            'recordsFiltered' => $count
        ];

        echo json_encode($response);
    }

    public function list_course()
    {
        $get = $this->input->get();
        $searchTerm = !empty($get['searchTerm']) ? $get['searchTerm'] : '';
        $course_type = $get['course_type'] ?? '';


        $where = ['deleted_by' => null];


        if (!empty($searchTerm)) {
            $where['title LIKE'] = '%' . $searchTerm . '%';
        }
        if (!empty($course_type)) {
            $where['course_type LIKE'] = '%' . $course_type . '%';
        }

        $list_course = $this->CommonModel->getData(
            'tbl_courses',
            $where,
            'id,title as text',
            '',
            'result_array'
        );


        echo json_encode($list_course);
    }
    public function list_user()
    {
        $get = $this->input->get();
        $searchTerm = !empty($get['searchTerm']) ? $get['searchTerm'] : '';
        $user_type = $get['user_type'] ?? '';

        $where = ['is_deleted' => 0, 'status' => 1, 'role' => 3];
        if (!empty($user_type)) {
            $where['user_type LIKE'] = '%' . $user_type . '%';
        }

        if (!empty($searchTerm)) {
            $where['title LIKE'] = '%' . $searchTerm . '%';
        }

        $list_course = $this->CommonModel->getData(
            'tbl_users',
            $where,
            'id,first_name as text',
            '',
            'result_array'
        );


        echo json_encode($list_course);
    }
}