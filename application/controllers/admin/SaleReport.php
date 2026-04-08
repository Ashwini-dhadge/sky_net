<?php

/**
 * 
 */
class SaleReport extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'SaleReportModel');
        //$this->load->model(ADMIN.'OrderReportModel');

        loginId();
    }
    public function index()
    {
        $data['title'] = 'Sales Report';
        //    $data['products'] = $this->CommonModel->getData('tbl_products','','',array('id','product_name','sku') );

        $this->load->view(ADMIN . 'report/report_sale', $data);
    }

    public function listSaleOrders()
    {
        $data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];

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





        $count = count($this->SaleReportModel->getSaleReportOrders($searchVal, 0, 0, 0, 0, $id, $where));
        // echo $this->db->last_query();die();
        //  echo $this->db->last_query();die();

        $total = 0;
        $row1 = [];
        if ($count) {


            $result = $this->SaleReportModel->getSaleReportOrders($searchVal, $sortColIndex, $sortBy, $limit, $offset, $id, $where);

            foreach ($result as $key => $value) {
                $total = $total + $value['sales'];

                $row = [];
                array_push($row, $offset + ($key + 1));
                // if ($value['type'] == 1) {
                //     $type = '<span class="badge badge-primary" >Courses</span>';
                // } else {
                //     $type = '<span class="badge badge-success" >Packages</span>';
                // }
                // array_push($row, $type);
                array_push($row, $value['title']);
                array_push($row, $value['total']);
                array_push($row, $value['sales']);


                $columns[] = $row;
            }
            array_push($row1, '');
            array_push($row1, '');
            // array_push($row1, '');
            array_push($row1, '<strong>Total</strong>');
            array_push($row1, '<strong>' . number_format((float)$total, 2, '.', '') . '<strong>');
            $columns[] = $row1;
        }


        $response = [
            'draw' => $page,
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
}