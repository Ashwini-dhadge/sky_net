<?php

/**
 * 
 */
class UserCourseProgressReport extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'UserCourseProgressReportModel');
        //$this->load->model(ADMIN.'OrderReportModel');

        loginId();
    }
    public function index()
    {
        $data['title'] = 'Sales Report';
        //    $data['products'] = $this->CommonModel->getData('tbl_products','','',array('id','product_name','sku') );

        $this->load->view(ADMIN . 'userCourseProgressReport/list', $data);
    }

    public function listUserCourseProgressReport()
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
            $where['tocs.course_id'] = $data['course_id'];
        }
        if (isset($data['user_id']) && !empty($data['user_id'])) {
            $where['tocs.user_id'] = $data['user_id'];
        }

        // total records
        $count = count($this->UserCourseProgressReportModel
            ->getMyCoursesList($searchVal, 0, 0, 0, 0, '', $where));

        $columns = [];

        if ($count) {

            $result = $this->UserCourseProgressReportModel
                ->getMyCoursesList($searchVal, $sortColIndex, $sortBy, $limit, $offset, '', $where);

            foreach ($result as $key => $value) {

                $row = [];
                $row[] = $offset + ($key + 1);
                $row[] = $value['student_name'];
                $row[] = $value['title'];
                $row[] = $value['category_name'];
                $progress = (float)$value['watch_percentage'];

                if ($progress >= 90) {
                    $colorClass = 'p-excellent';
                } elseif ($progress >= 50) {
                    $colorClass = 'p-good';
                } elseif ($progress > 0) {
                    $colorClass = 'p-average';
                } else {
                    $colorClass = 'p-zero';
                }

                $label = $progress == 0 ? 'Not Started' : $progress . '%';

                $progressBar = '
                <div class="progress-card">
                    <div class="progress-head">
                        <span>Progress</span>
                        <strong>' . $label . '</strong>
                    </div>
                
                    <div class="progress enterprise-progress">
                        <div class="progress-bar ' . $colorClass . '" style="width:' . $progress . '%"></div>
                    </div>
                </div>';

                $row[] = $progressBar;
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
    public function getArea()
    {
        $outlet_id = $this->input->post('outlet_id');
        if ($outlet_id) {

            $area = $this->OrderReportModel->getOutletWiseAreaData($outlet_id);

            $response['area'] = $area;
            $response['status'] = true;
        } else {
            $response['status'] = false;
            $response['reason'] = "Error, ok Data not found";
        }
        echo json_encode($response);
    }
    public function downloadSaleReport()
    {
        $data = $_POST;
        $columns = [];

        $id = $this->input->post('id');
        $on_date = $this->input->post('on_date');
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        $product_id = $this->input->post('product_id');
        $payment_type = $this->input->post('payment_type');
        $outlet_id = $this->input->post('outlet_id');
        $area = $this->input->post('area');
        $where = array();
        $where_in = array();
        $areas = '';

        if ($on_date == 1) {
            $from_date = date('Y-m-d');
            $where['o.date'] = date('Y-m-d', strtotime($from_date));
        } else if ($on_date == 2) {
            $from_date = date('Y-m-d', strtotime('-1 days'));
            $where['o.date'] = date('Y-m-d', strtotime($from_date));
        } else if ($on_date == 3) {
            $from_date = date('Y-m-d', strtotime('last monday'));
            $to_date = date('Y-m-d', strtotime('next sunday'));
            $where['o.date BETWEEN "' . $from_date . '" AND "' . $to_date . '" '] = '';
        } else if ($on_date == 4) {
            $from_date = date('Y-m-d', strtotime('first day of this month'));
            $to_date = date('Y-m-d', strtotime('last day of this month'));
            $where['o.date BETWEEN "' . $from_date . '" AND "' . $to_date . '" '] = '';
        } else if ($on_date == 5) {
            $from_date = date('Y-m-d', strtotime('01/31'));
            $to_date = date('Y-m-d', strtotime('12/31'));
            $where['o.date BETWEEN "' . $from_date . '" AND "' . $to_date . '" '] = '';
        } else if ($on_date == 6) {

            $from = new DateTime($from_date);
            $to = new DateTime($to_date);

            $from_date = $from->format('Y-m-d 00:00:00');
            $to_date = $to->format('Y-m-d 23:59:59');

            $where['o.date BETWEEN "' . $from_date . '" AND "' . $to_date . '" '] = '';
        } else {
            //$where['o.date'] = date('Y-m-d',strtotime($from_date));
        }




        $count = count($this->SaleReportModel->getSaleReportOrders(0, 0, 0, 0, 0, $id, $where));
        // echo $this->db->last_query();die();
        //  echo $this->db->last_query();die();

        $total = 0;
        $row1 = [];
        if ($count) {


            $result = $this->SaleReportModel->getSaleReportOrders(0, 0, 0, 0, 0, $id, $where);

            foreach ($result as $key => $value) {
                $total = $total + $value['sales'];

                $row = [];
                array_push($row, ($key + 1));
                if ($value['type'] == 1) {
                    $type = 'Courses';
                } else {
                    $type = 'Packages';
                }
                array_push($row, $type);
                array_push($row, $value['title']);
                array_push($row, $value['total']);
                array_push($row, $value['sales']);


                $columns[] = $row;
            }
            array_push($row1, '');
            array_push($row1, '');
            array_push($row1, '');
            array_push($row1, 'Total');
            array_push($row1, '' . number_format((float)$total, 2, '.', ''));
            $columns[] = $row1;
            $table_columns = array('Sr._No.',  'Sales',   'Type', ' Courses/package Name ',  'Total Sale Count',  'Sale');
            exportCsv1($table_columns, $columns, 'member');
        } else {
            $this->session->set_flashdata('success', 'No data For Export ');
            redirect(base_url('admin/SaleReport'));
        }
    }

    public function list_course()
    {
        $get = $this->input->get();
        $searchTerm = !empty($get['searchTerm']) ? $get['searchTerm'] : '';


        $where = ['deleted_by' => null];


        if (!empty($searchTerm)) {
            $where['title LIKE'] = '%' . $searchTerm . '%';
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
    public function list_section()
    {
        $get = $this->input->get();
        $searchTerm = !empty($get['searchTerm']) ? $get['searchTerm'] : '';
        $course_id = !empty($get['course_id']) ? $get['course_id'] : '';

        $where = ['deleted_by' => null, 'course_id' => $course_id];
        if (!empty($searchTerm)) {
            $where['title LIKE'] = '%' . $searchTerm . '%';
        }

        $list_section = $this->CommonModel->getData(
            'tbl_section',
            $where,
            'id,title as text',
            '',
            'result_array'
        );


        echo json_encode($list_section);
    }
    public function list_lesson()
    {
        $get = $this->input->get();
        $searchTerm = !empty($get['searchTerm']) ? $get['searchTerm'] : '';
        $course_id = !empty($get['course_id']) ? $get['course_id'] : '';
        $section_id = !empty($get['section_id']) ? $get['section_id'] : '';

        $where = ['deleted_by' => null, 'course_id' => $course_id, 'section_id' => $section_id];
        if (!empty($searchTerm)) {
            $where['title LIKE'] = '%' . $searchTerm . '%';
        }

        $list_lesson = $this->CommonModel->getData(
            'tbl_lesson',
            $where,
            'id,title as text',
            '',
            'result_array'
        );


        echo json_encode($list_lesson);
    }
    public function list_user()
    {
        $get = $this->input->get();
        $searchTerm = !empty($get['searchTerm']) ? $get['searchTerm'] : '';


        $where = ['is_deleted' => 0, 'status' => 1, 'role' => 3];


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