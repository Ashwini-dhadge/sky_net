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
        $data['course_student_chart'] = $this->db
            ->select('c.title, COUNT(s.id) as total_students')
            ->from('tbl_courses c')
            ->join(
                'tbl_order_courses_subscription s',
                's.course_id = c.id AND s.active = 1 AND s.deleted_on IS NULL',
                'left'
            )
            ->where('c.status', 1)
            ->group_by('c.id')
            ->order_by('total_students', 'DESC')
            ->limit(5)
            ->get()
            ->result();

        $data['pending_forum'] = $this->db
            ->where('is_approved', 0)
            ->where('deleted_at IS NULL', null, false)
            ->order_by('id', 'DESC')
            ->get('tbl_forum_questions')
            ->result();

        $data['rejected_forum'] = $this->db
            ->where('is_approved', 2)
            ->where('deleted_at IS NULL', null, false)
            ->order_by('id', 'DESC')
            ->get('tbl_forum_questions')
            ->result();

        $data['unanswered_qna'] = $this->db
            ->select('q.*, c.title as course_title')
            ->from('tbl_course_qna q')
            ->join('tbl_courses c', 'c.id = q.course_id', 'left')
            ->where('q.answer IS NULL', null, false)
            ->where('q.deleted_at IS NULL', null, false)
            ->order_by('q.id', 'DESC')
            ->get()
            ->result();

        $data['online_students'] = $this->db
            ->where(['status' => 1, 'is_deleted' => 0, 'role' => 3, 'user_type' => 1])
            ->count_all_results('tbl_users');

        $data['offline_students'] = $this->db
            ->where(['status' => 1, 'is_deleted' => 0, 'role' => 3, 'user_type' => 0])
            ->count_all_results('tbl_users');

        $data['online_courses'] = $this->db
            ->where('status', 1)
            ->where('course_type', 1)
            ->where('deleted_at IS NULL', null, false)
            ->count_all_results('tbl_courses');

        $data['offline_courses'] = $this->db
            ->where('status', 1)
            ->where('course_type', 0)
            ->where('deleted_at IS NULL', null, false)
            ->count_all_results('tbl_courses');


        $data['enroll_online_student_online_course'] = $this->db
            ->from('tbl_order_courses_subscription s')
            ->join('tbl_users u', 'u.id = s.user_id', 'inner')
            ->join('tbl_courses c', 'c.id = s.course_id', 'inner')
            ->where('s.active', 1)
            ->where('s.deleted_on IS NULL', null, false)
            ->where('u.role', 3)
            ->where('u.status', 1)
            ->where('u.is_deleted', 0)
            ->where('u.user_type', 1)
            ->where('c.status', 1)
            ->where('c.deleted_at IS NULL', null, false)
            ->where('c.course_type', 1)
            ->count_all_results();

        $data['enroll_offline_student_offline_course'] = $this->db
            ->from('tbl_order_courses_subscription s')
            ->join('tbl_users u', 'u.id = s.user_id', 'inner')
            ->join('tbl_courses c', 'c.id = s.course_id', 'inner')
            ->where('s.active', 1)
            ->where('s.deleted_on IS NULL', null, false)
            ->where('u.role', 3)
            ->where('u.status', 1)
            ->where('u.is_deleted', 0)
            ->where('u.user_type', 0)
            ->where('c.status', 1)
            ->where('c.deleted_at IS NULL', null, false)
            ->where('c.course_type', 0)
            ->count_all_results();

        $data['enroll_online_student_offline_course'] = $this->db
            ->from('tbl_order_courses_subscription s')
            ->join('tbl_users u', 'u.id = s.user_id', 'inner')
            ->join('tbl_courses c', 'c.id = s.course_id', 'inner')
            ->where('s.active', 1)
            ->where('s.deleted_on IS NULL', null, false)
            ->where('u.role', 3)
            ->where('u.status', 1)
            ->where('u.is_deleted', 0)
            ->where('u.user_type', 1)
            ->where('c.status', 1)
            ->where('c.deleted_at IS NULL', null, false)
            ->where('c.course_type', 0)
            ->count_all_results();

        $data['enroll_offline_student_online_course'] = $this->db
            ->from('tbl_order_courses_subscription s')
            ->join('tbl_users u', 'u.id = s.user_id', 'inner')
            ->join('tbl_courses c', 'c.id = s.course_id', 'inner')
            ->where('s.active', 1)
            ->where('s.deleted_on IS NULL', null, false)
            ->where('u.role', 3)
            ->where('u.status', 1)
            ->where('u.is_deleted', 0)
            ->where('u.user_type', 0)
            ->where('c.status', 1)
            ->where('c.deleted_at IS NULL', null, false)
            ->where('c.course_type', 1)
            ->count_all_results();
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
