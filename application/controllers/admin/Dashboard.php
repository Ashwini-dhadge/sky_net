<?php
class Dashboard extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'DashboardModel');
        loginId();
    }
    public function terms_condtions()
    {

        $this->load->view('terms_and_conditions');
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
        $data['course_wise_sale'] = $this->DashboardModel->getCourseWiseSale();
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
                'remark' => NULL,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => loginId()
            ],
            'update',
            ['id' => $id]
        );

        $this->ForumModel->logAction([
            'forum_id' => $id,
            'is_approved' => 1,
            'remark' => NULL,
            'created_by' => loginId(),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $this->session->set_flashdata('success', 'Question Approved Successfully!');
        redirect($_SERVER['HTTP_REFERER']);
    }


    public function reject()
    {
        $id = $this->input->post('id');
        $reason = $this->input->post('reason');

        if (!$id || !$reason) {
            $this->session->set_flashdata('error', 'Reject reason is required!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        $this->CommonModel->iudAction(
            'tbl_forum_questions',
            [
                'is_approved' => 2,
                'remark' => $reason,
                'approved_at' => NULL,
                'approved_by' => NULL,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => loginId()
            ],
            'update',
            ['id' => $id]
        );

        $this->ForumModel->logAction([
            'forum_id' => $id,
            'is_approved' => 2,
            'remark' => $reason,
            'created_by' => loginId(),
            'created_at' => date('Y-m-d H:i:s')
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
                'remark' => NULL,
                'approved_at' => NULL,
                'approved_by' => NULL,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => loginId()
            ],
            'update',
            ['id' => $id]
        );

        $this->ForumModel->logAction([
            'forum_id' => $id,
            'is_approved' => 0,
            'remark' => 'Returned to Pending',
            'created_by' => loginId(),
            'created_at' => date('Y-m-d H:i:s')
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
            $percentage = ((int) $order['total']);
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


    public function edit_profile()
    {
        $data['title'] = 'Edit';
        $data['details'] = $this->CommonModel->getData(
            'tbl_users',
            array('id' => loginId()),
            '*'
        );

        $this->load->view(ADMIN . 'auth/profile_page', $data);
    }

    public function update_profile($id)
    {
        
        if ($this->input->is_ajax_request()) {

            $user = $this->CommonModel->getData(
                'tbl_users',
                array('id' => $id),
                '*',
                '',
                '',
                1
            );

            // echo "<pre>";
            // print_r($user);
            // exit;

            if (empty($user)) {
                echo json_encode([
                    'status' => 0,
                    'message' => 'User not found'
                ]);
                exit;
            }

            $first_name = trim($this->input->post('first_name') ?? '');
            $last_name = trim($this->input->post('last_name') ?? '');
            $email = trim($this->input->post('email') ?? '');
            $mobile_no = trim($this->input->post('mobile_no') ?? '');

            $email_exist = $this->db
                ->where('email', $email)
                ->where('id !=', $id)
                ->where('is_deleted', 0)
                ->get('tbl_users')
                ->row_array();

            if (!empty($email_exist)) {
                echo json_encode([
                    'status' => 0,
                    'message' => 'Email already exists'
                ]);
                exit;
            }

            $mobile_exist = $this->db
                ->where('mobile_no', $mobile_no)
                ->where('id !=', $id)
                ->where('is_deleted', 0)
                ->get('tbl_users')
                ->row_array();

            if (!empty($mobile_exist)) {
                echo json_encode([
                    'status' => 0,
                    'message' => 'Mobile number already exists'
                ]);
                exit;
            }

            $updateData = [
                'first_name' => $first_name,
                'email' => $email,
                'mobile_no' => $mobile_no
            ];

            if (!empty($this->input->post('password'))) {
                $updateData['password'] = $this->input->post('password');
            }

            if (!empty($_FILES['image']['name'])) {

                $_FILES['profile_file'] = [
                    'name' => $_FILES['image']['name'],
                    'type' => $_FILES['image']['type'],
                    'tmp_name' => $_FILES['image']['tmp_name'],
                    'error' => $_FILES['image']['error'],
                    'size' => $_FILES['image']['size'],
                ];

                $upload = fileUpload(USER_PROFILE, 'profile_file', false);

                if ($upload['status']) {

                    // DELETE OLD IMAGE
                    if (
                        !empty($user[0]['image']) &&
                        file_exists('./' . USER_PROFILE . $user[0]['image'])
                    ) {

                        unlink('./' . USER_PROFILE . $user[0]['image']);
                    }

                    $updateData['image'] = $upload['image_name'];

                } else {

                    ob_clean();
                    header('Content-Type: application/json');

                    echo json_encode([
                        'status' => 0,
                        'message' => strip_tags($upload['message'])
                    ]);
                    exit;
                }
            }

            $this->CommonModel->iudAction(
                'tbl_users',
                $updateData,
                'update',
                array('id' => $id)
            );

            echo json_encode([
                'status' => true,
                'message' => 'Profile updated successfully'
            ]);
            exit;
        }
    }
}