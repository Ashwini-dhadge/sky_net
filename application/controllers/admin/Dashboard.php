<?php
class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'DashboardModel');
        loginId();
    }

    public function index()
    {

        $data['total_users'] = $this->CommonModel->getData('tbl_users', array('status' => 1, 'role' => 3), '', '', 'num_rows');
        $data['total_course'] = $this->CommonModel->getData('tbl_courses', array('status' => 1, 'deleted_by' => NULL, 'category_id !=' => 0), '', '', 'num_rows');
        $data['total_package'] = $this->CommonModel->getData('tbl_courses', array('status' => 1, 'deleted_by' => NULL, 'category_id =' => 0), '', '', 'num_rows');
        $data['total_sale'] = $this->CommonModel->getData('tbl_orders', array('payment_status' => 1), 'sum(total_amount) as sales', '', 'row_array');
        $data['data_payment_gateway'] = $this->CommonModel->getData('tbl_payments_setting', '', '', '', '');


        $this->load->view(ADMIN . DASHBOARD . 'dashboard', $data);
    }

    public function ChangePaymentGateWay()
    {
        $payment_gate_way_id = $_POST['payment_gate_way_id'];
        if (isset($payment_gate_way_id)) {

            $this->CommonModel->iudAction('tbl_payments_setting', array('is_active' => 0), 'update', array('is_active' => 1));

            if ($this->CommonModel->iudAction('tbl_payments_setting', array('is_active' => 1), 'update', array('payment_gate_way_id' => $payment_gate_way_id))) {

                $response['result'] = TRUE;
                $response['reason'] = 'Payement Gateway Status Updated Successfully';
            } else {

                $response['result'] = FALSE;
                $response['reason'] = 'Payement Gateway Status Not Update!';
            }
        } else {
            $response['result'] = FALSE;
            $response['reason'] = 'Payement Gateway Status Not Update!';
        }
        echo json_encode($response);
    }


    function getCategoryWiseSale()
    {
        $getdata = $this->DashboardModel->getCourseWiseSale();
        $totalOrder = count($getdata);
        $series1 = array();
        $labels1 = array();
        $color1 = array();


        foreach ($getdata as $key1 => $order) {
            //     $percentage=(((float)$order['total'])/( $totalOrder))*100;
            $percentage = ((int)$order['total']);
            array_push($series1, round($percentage, 2));
            $labels1[$key1] = $order['title'];
            $color1[$key1] = "#" . $this->random_color();
        }

        $data['series1'] = $series1;
        $data['labels1'] = $labels1;
        $data['colors1'] = $color1;
        echo (json_encode($data));
    }
    function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }
    function random_color()
    {
        return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
    }
}