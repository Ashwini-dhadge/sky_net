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

        $data['total_users'] = $this->CommonModel->getData('tbl_users', array('status' => 1, 'is_deleted' => 0), '', '', 'num_rows');
        $data['total_students'] = $this->CommonModel->getData('tbl_users', array('status' => 1, 'is_deleted' => 0, 'role' => 3), '', '', 'num_rows');
        $data['total_instructors'] = $this->CommonModel->getData('tbl_users', array('status' => 1, 'is_deleted' => 0, 'role' => 4), '', '', 'num_rows');
        $data['total_courses'] = $this->CommonModel->getData('tbl_courses', array('status' => 1, 'deleted_by' => null), '', '', 'num_rows');
        $data['courses'] = $this->CommonModel->getData(
            'tbl_courses',
            ['deleted_at' => null],
            'id, title'
        );
        $data['course_student_chart'] = $this->DashboardModel->getCourseStudentChart();
        $data['pending_forum'] = $this->DashboardModel->getPendingForum();
        $data['rejected_forum'] = $this->DashboardModel->getRejectedForum();
        $data['unanswered_qna'] = $this->DashboardModel->getUnansweredQna();

        $data['online_students'] = $this->DashboardModel->getOnlineStudents();
        $data['offline_students'] = $this->DashboardModel->getOfflineStudents();

        $data['online_courses'] = $this->DashboardModel->getOnlineCourses();
        $data['offline_courses'] = $this->DashboardModel->getOfflineCourses();

        $data['enroll_online_student_online_course'] = $this->DashboardModel->enrollOnlineStudentOnlineCourse();
        $data['enroll_offline_student_offline_course'] = $this->DashboardModel->enrollOfflineStudentOfflineCourse();
        $data['enroll_online_student_offline_course'] = $this->DashboardModel->enrollOnlineStudentOfflineCourse();
        $data['enroll_offline_student_online_course'] = $this->DashboardModel->enrollOfflineStudentOnlineCourse();
        // echo"<pre>";print_r($data);die();
        $this->load->view(ADMIN . DASHBOARD . 'dashboard', $data);
    }

    public function approve($id = null)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->CommonModel->iudAction(
            'tbl_forum_questions',
            [
                'is_approved' => 1,
                'approved_at' => date('Y-m-d H:i:s'),
                'approved_by' => loginId(),
                'remark'      => NULL,
                'updated_at'  => date('Y-m-d H:i:s'),
                'updated_by'  => loginId()
            ],
            'update',
            ['id' => $id]
        );

        $this->ForumModel->logAction([
            'forum_id'    => $id,
            'is_approved' => 1,
            'remark'      => NULL,
            'created_by'  => loginId(),
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Question Approved Successfully!');
        redirect($_SERVER['HTTP_REFERER']);
    }


    public function reject()
    {
        $id     = $this->input->post('id');
        $reason = $this->input->post('reason');

        if (!$id || !$reason) {
            $this->session->set_flashdata('error', 'Reject reason is required!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->CommonModel->iudAction(
            'tbl_forum_questions',
            [
                'is_approved' => 2,
                'remark'      => $reason,
                'approved_at' => NULL,
                'approved_by' => NULL,
                'updated_at'  => date('Y-m-d H:i:s'),
                'updated_by'  => loginId()
            ],
            'update',
            ['id' => $id]
        );

        $this->ForumModel->logAction([
            'forum_id'    => $id,
            'is_approved' => 2,
            'remark'      => $reason,
            'created_by'  => loginId(),
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('error', 'Question Rejected Successfully!');
        redirect($_SERVER['HTTP_REFERER']);
    }


    public function returnToPending($id = null)
    {
        if (!$id) {
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->CommonModel->iudAction(
            'tbl_forum_questions',
            [
                'is_approved' => 0,
                'remark'      => NULL,
                'approved_at' => NULL,
                'approved_by' => NULL,
                'updated_at'  => date('Y-m-d H:i:s'),
                'updated_by'  => loginId()
            ],
            'update',
            ['id' => $id]
        );

        $this->ForumModel->logAction([
            'forum_id'    => $id,
            'is_approved' => 0,
            'remark'      => 'Returned to Pending',
            'created_by'  => loginId(),
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Question moved to Pending!');
        redirect($_SERVER['HTTP_REFERER']);
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
