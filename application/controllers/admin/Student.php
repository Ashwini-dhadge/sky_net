<?php

/**
 * 
 */
class Student extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'StudentModel');
        $this->load->model(ADMIN . 'UserModel');
        $this->load->model(ADMIN . 'ForumModel');
        $this->load->model(ADMIN . 'QuestionModel');
        loginId();
        if ($this->session->userdata('role') != 1) {
            show_error('You do not have permission to access this page.', 403, 'Access Denied');
        }
    }

    public function index()
    {
        $data['title'] = 'Student';
        $data['active'] = 'Student';
        $data['role'] = 3;
        $this->load->model(ADMIN . 'BatchModel');
        $data['batches'] = $this->BatchModel->getBatchData('', 0, 'asc', 0, 0, 0, ['b.status' => 1]);
        $this->load->view(ADMIN . STUDENT . 'list-student', $data);
    }

    public function listStudent()
    {
        $data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];
        $role_id = $this->input->post('role');
        //print_r($role_id);die;
        $student_type = $this->input->post('student_type');
        $batch_id = $this->input->post('batch_id');
        $count = count($this->UserModel->getUserData($searchVal, 0, 0, 0, 0, 0, $role_id, $student_type, $batch_id));
        // print_r($count);die;
        if ($count) {
            $userData = $this->UserModel->getUserData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $role_id, $student_type, $batch_id);

            foreach ($userData as $key => $user) {
                $row = [];
                $no = $offset + ($key + 1);
                array_push($row, $offset + ($key + 1));
                $img = (!empty($user['image']) && file_exists(FCPATH . USER_IMAGES . $user['image']))
                    ? $user['image']
                    : 'user.png'; // default image inside assets/images/

                $imagePath = (!empty($user['image']) && file_exists(FCPATH . USER_IMAGES . $user['image']))
                    ? base_url() . USER_IMAGES . $user['image']
                    : base_url() . 'assets/images/user.png';

                $name_tag = '<a href="' . base_url() . ADMIN . 'Student/view/' . $user['id'] . '/' . $user['role'] . '" 
                    title="View" 
                    class="text-primary waves-effect waves-ligh mr-2">
                    
                    <img src="' . $imagePath . '" 
                        width="40" 
                        height="40" 
                        class="rounded-circle">
                </a>';
                $name_tag1 = '
                <a href="' . base_url() . ADMIN . 'Student/view/' . $user['id'] . '/' . $user['role'] . '" 
                title="View" 
                class="student-name-wrap text-primary waves-effect waves-ligh mr-2">
                ' . $user['first_name'] . ' ' . $user['last_name'] . '
                </a>';
                array_push($row, $name_tag);
                array_push($row, $name_tag1);
                array_push($row, $user['email']);
                array_push($row, $user['mobile_no']);
                array_push($row, $user['password']);
                if ($user['user_type'] == 0) {
                    $user_type = '<span class="badge badge-info ">Offline</span>';
                } else {
                    $user_type = '<span class="badge badge-warning ">Online</span>';
                }
                array_push($row, $user_type);
                $batch_name = !empty($user['batch_name']) ? html_escape($user['batch_name']) : '-';
                array_push($row, $batch_name);
                if ($user['status']) {
                    $status = '<span class="badge badge-success ">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger ">Not Active</span>';
                }
                array_push($row, $status);
                $confirm = "confirm('Are you sure you want to delete this Officer?')";
                $assign_btn = '';

                $action = '';

                if ($user['user_type'] == 0) {
                    $action .= '
                    <a href="javascript:void(0);" 
                    title="Assign Course" 
                    class="btn btn-info btn-sm waves-effect waves-light openAssignModal"
                    data-id="' . $user['id'] . '">
                    <i class="fas fa-book"></i>
                    </a>
                    ';
                }

                $action = '
                <div class="dropdown">
                    <button class="btn btn-secondary btn-sm dropdown-toggle" 
                        type="button" 
                        id="dropdownMenuButton' . $user['id'] . '" 
                        data-toggle="dropdown" 
                        aria-haspopup="true" 
                        aria-expanded="false"
                        style="padding: 4px 8px;">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton' . $user['id'] . '">
                ';

                if ($user['user_type'] == 0) {
                    $action .= '
                        <a href="javascript:void(0);" 
                            class="dropdown-item openAssignModal"
                            data-id="' . $user['id'] . '">
                            <i class="fas fa-book text-info mr-2"></i> Assign Course
                        </a>
                    ';
                }

                $action .= '
                        <a href="javascript:void(0);" 
                            class="dropdown-item certificateModal"
                            data-id="' . $user['id'] . '">
                            <i class="fas fa-award text-warning mr-2"></i> Certificate
                        </a>

                        <a href="' . base_url() . ADMIN . 'Student/add/' . $user['id'] . '" 
                            class="dropdown-item">
                            <i class="fas fa-edit text-success mr-2"></i> Edit
                        </a>

                        <a href="' . base_url() . ADMIN . 'Student/view/' . $user['id'] . '/' . $user['role'] . '" 
                            class="dropdown-item">
                            <i class="fas fa-eye text-primary mr-2"></i> View
                        </a>


                    </div>
                </div>
                ';

                // <a onclick="return ' . $confirm . '" 
                //     href="' . base_url() . ADMIN . 'User/delete/' . $user['id'] . '" 
                //     class="dropdown-item text-danger">
                //     <i class="fas fa-trash-alt mr-2"></i> Delete
                // </a>

                array_push($row, $action);


                $columns[] = $row;
            }
        }
        $response = [
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $count,
            'recordsFiltered' => $count
        ];
        echo json_encode($response);
    }

    public function get_assign_course_modal()
    {
        $user_id = $this->input->post('user_id');
        $this->load->model('UserModel');

        $courses = $this->CommonModel->getData(
            'tbl_courses',
            array(
                'deleted_by' => null,
                'course_type' => 0,
                'status' => 1
            )
        );


        $sub_map = $this->UserModel->getUserCourseSubscriptionMap($user_id);

        $data['user_id'] = $user_id;
        $data['courses'] = $courses;
        $data['sub_map'] = $sub_map;

        $this->load->view('admin/student/assign_course_modal', $data);
    }

    public function make_certificate_modal()
    {
        $user_id = $this->input->post('user_id');

        $data['user_details'] = $this->CommonModel->getData(
            'tbl_users',
            ['id' => $user_id],
            '',
            '',
            'row_array'
        );
        $data['courses'] = $this->CommonModel->getAllData(
            'tbl_courses',
            ['status' => 1]
        );

        $this->load->view('admin/student/certificate_modal', $data);
    }

    public function save_certificate()
    {
        $post = $this->input->post();

        $data = [
            'user_id' => $post['user_id'],
            'course_id' => !empty($post['course_id']) ? $post['course_id'] : NULL,
            'external_course' => $post['external_course'] ?? NULL,
            'certificate_title' => $post['certificate_title'],
            'score' => $post['score'] ?? NULL,
            'grade' => $post['grade'] ?? NULL,
            'issued_date' => $post['issued_date'],
            'certificate_number' => 'CERT' . time(),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if (!empty($_FILES['certificate_file']['name'])) {

            $_FILES['cert_file'] = [
                'name' => $_FILES['certificate_file']['name'],
                'type' => $_FILES['certificate_file']['type'],
                'tmp_name' => $_FILES['certificate_file']['tmp_name'],
                'error' => $_FILES['certificate_file']['error'],
                'size' => $_FILES['certificate_file']['size'],
            ];

            $upload = fileUpload(CERTIFICATE_FILES, 'cert_file', false);

            if ($upload['status']) {
                $data['certificate_file'] = $upload['image_name'];
            }
        }

        $this->CommonModel->iudAction(
            'tbl_certificates',
            $data,
            'insert'
        );

        echo json_encode([
            'status' => true,
            'message' => 'Certificate Generated Successfully'
        ]);
    }

    public function save_assigned_courses()
    {
        $user_id = $this->input->post('user_id');
        $selected_courses = $this->input->post('course_ids');
        // ===== GET USER DETAILS FOR NOTIFICATION =====
        $userDetails = $this->CommonModel->getData('tbl_users', ['id' => $user_id], '*', '', 'row_array');
        $name = $userDetails['first_name'] . ' ' . $userDetails['last_name'];
        $deviceToken = $userDetails['notification_token'];
        $assignedCourses = [];
        if (!$user_id) {
            echo json_encode(['status' => false]);
            exit;
        }

        if (!is_array($selected_courses)) {
            $selected_courses = [];
        }

        $this->db->where('user_id', $user_id);
        $this->db->where('deleted_on IS NULL', null, false);
        $allSubs = $this->db->get('tbl_order_courses_subscription')->result_array();

        $all_map = [];
        foreach ($allSubs as $sub) {
            $all_map[$sub['course_id']] = $sub;
        }

        foreach ($all_map as $course_id => $sub) {
            if (!in_array($course_id, $selected_courses) && $sub['active'] == 1) {
                $this->CommonModel->iudAction(
                    'tbl_order_courses_subscription',
                    [
                        'active' => 0,
                        'deleted_on' => date('Y-m-d H:i:s')
                    ],
                    'update',
                    [
                        'id' => $sub['id']
                    ]
                );
            }
        }

        foreach ($selected_courses as $course_id) {

            $duration_row = $this->db
                ->select('id')
                ->where('courses_id', $course_id)
                ->get('tbl_courses_duration')
                ->row();

            $course_duration_id = $duration_row ? $duration_row->id : 0;

            if (isset($all_map[$course_id])) {
                if ($all_map[$course_id]['active'] == 0) {

                    $this->CommonModel->iudAction(
                        'tbl_order_courses_subscription',
                        [
                            'active' => 1,
                            'deleted_on' => null,
                            'courses_duration_id' => $course_duration_id,
                            'start_date' => date('Y-m-d'),
                            'end_date' => date('Y-m-d', strtotime('+30 days'))
                        ],
                        'update',
                        [
                            'id' => $all_map[$course_id]['id']
                        ]
                    );
                }
                continue;
            }

            $order_no = 'ORD' . time() . rand(100, 999);
            $orderData = [
                'order_no' => $order_no,
                'user_id' => $user_id,
                'date' => date('Y-m-d'),
                'order_status' => 'COMPLETED',
                'payment_status' => 'CAPTURED',
                'payment_type' => 3,
                'amount' => 0,
                'gst_amount' => 0,
                'total_amount' => 0,
                'created_on' => date('Y-m-d H:i:s')
            ];

            $order_id = $this->CommonModel->iudAction('tbl_orders', $orderData, 'insert');

            $course_value = $this->CommonModel->getData(
                'tbl_courses_duration',
                ['courses_id' => $course_id],
                'price',
                '',
                'row_array',
                'id',
                'DESC'
            );
            // echo '<pre>';
            // print_r($course_value);
            // die;
            $orderDetailsData = [
                'order_id' => $order_id,
                'courses_id' => $course_id,
                'courses_duration_id' => $course_duration_id,
                'lesson_id' => 0,
                'qty' => 1,
                'rate' => $course_value['price'] ?? 0,
                'value' => $course_value['price'] ?? 0,
                'user_id' => $user_id,
                'type' => 1,
                'is_free' => 1,
                'franchise_id' => 0
            ];

            $this->CommonModel->iudAction('tbl_order_details', $orderDetailsData, 'insert');

            $duration_id = 5;

            $duration = $this->db
                ->where('id', $duration_id)
                ->get('tbl_duration_master')
                ->row();

            $no_of_days = $duration ? $duration->no_of_days : 30;

            $subData = [
                'order_id' => $order_id,
                'order_no' => $order_no,
                'user_id' => $user_id,
                'type' => 1,
                'courses_duration_id' => $course_duration_id,
                'course_id' => $course_id,
                'start_date' => date('Y-m-d'),
                'end_date' => date('Y-m-d', strtotime('+' . $no_of_days . ' days')),
                'active' => 1,
                'no_of_days' => $no_of_days,
                'is_free' => 1,
                'created_on' => date('Y-m-d H:i:s')
            ];

            $this->CommonModel->iudAction('tbl_order_courses_subscription', $subData, 'insert');
            $course = $this->CommonModel->getData(
                'tbl_courses',
                ['id' => $course_id],
                'title',
                '',
                'row_array'
            );
            $assignedCourses[] = $course['title'];
        }
        // echo "<pre>";
        // print_r($assignedCourses);
        // die;
        $this->session->set_flashdata('success', 'Courses assigned successfully');
        // ===== SEND ONE PUSH NOTIFICATION =====
        if (!empty($assignedCourses) && !empty($deviceToken)) {

            $courseList = implode(', ', $assignedCourses);

            if (strlen($courseList) > 60) {
                $courseList = substr($courseList, 0, 60) . '...';
            }

            $title = "New Courses Assigned";
            $message = "Dear $name, New course(s) $courseList have been assigned to your account. Start learning now! Thanks, Team Skynet.";

            sendMobileNotification($deviceToken, $message, $title);
        }
        echo json_encode(['status' => true]);
        exit;
    }


    public function add_student()
    {
        $this->add();
    }

    public function check_email()
    {
        $email = $this->input->post('email');
        $user_id = $this->input->post('user_id');

        $this->db->where('email', $email);
        $this->db->where('is_deleted', 0);

        if ($user_id) {
            $this->db->where('id !=', $user_id);
        }

        $query = $this->db->get('tbl_users');

        echo ($query->num_rows() > 0) ? "exists" : "available";
    }

    public function check_mobile()
    {
        $mobile = $this->input->post('mobile');
        $user_id = $this->input->post('user_id');

        $this->db->where('mobile_no', $mobile);
        $this->db->where('is_deleted', 0);

        if ($user_id) {
            $this->db->where('id !=', $user_id);
        }

        $query = $this->db->get('tbl_users');

        echo ($query->num_rows() > 0) ? "exists" : "available";
    }

    public function add($id = '')
    {
        $data['title'] = 'Add Student';
        $data['role'] = 3;
        $post = $this->input->post();

        if ($post) {
            $student = $post;
            unset($student['user_id']);
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
                    $student['image'] = $upload['image_name'];
                }
            }
            $student['self_code'] = "LMS" . $student['mobile_no'];
            $student['otp'] = create6NumRandom();
            $student['user_from'] = 1;
            if (isset($post['user_type'])) {
                // $student['user_type'] = $post['user_type'];
            }
            if (isset($post['batch_id'])) {
                $student['batch_id'] = !empty($post['batch_id']) ? $post['batch_id'] : null;
            }
            $student['is_otp_verified'] = 0;

            if (!empty($post['id'])) {

                $this->CommonModel->iudAction(
                    'tbl_users',
                    $student,
                    'update',
                    ['id' => $post['id']]
                );
            } else {
                $student['user_type'] = 0;
                $this->CommonModel->iudAction(
                    'tbl_users',
                    $student,
                    'insert'
                );
            }

            redirect(base_url(ADMIN . 'Student'));
        }

        if ($id) {

            $student = $this->CommonModel->getData(
                'tbl_users',
                ['id' => $id],
                '',
                '',
                'row_array'
            );

            $data = $student;
            $data['title'] = 'Edit Student';
        }

        $this->load->model(ADMIN . 'BatchModel');
        $data['batches'] = $this->BatchModel->getBatchData('', 0, 'asc', 0, 0, 0, ['b.status' => 1]);

        $this->load->view(ADMIN . STUDENT . 'add-student', $data);
    }
    public function view($_id, $_role)
    {
        if ($_role == 3) {

            $data['title'] = 'Users';

            $user = $this->UserModel->getUserData('', 0, 0, 0, 0, $_id);

            if ($user) {

                $data['user'] = $user[0];

                $data['forum_questions'] = $this->ForumModel->getQuestionsByUser($_id);
                $data['qna_list'] = $this->QuestionModel->getUserCourseQna($_id);
                $data['lesson_progress'] = $this->UserModel->getUserLessonProgress($_id);

                $data['lesson_progress'] = $this->UserModel->getUserLessonProgress($_id);

                foreach ($data['lesson_progress'] as $key => $row) {
                    $data['lesson_progress'][$key]['questions'] =
                        $this->UserModel->getLessonQuestions($row['lesson_id']);
                }

                $data['certificates'] = $this->CommonModel->getData(
                    'tbl_certificates',
                    ['user_id' => $_id],
                    '',
                    '',
                    ''
                );

                $this->load->view(ADMIN . USER . 'user_view', $data);
            }
        } else {
            $data['title'] = 'Student';
            $user = $this->UserModel->getUserData('', 0, 0, 0, 0, $_id);
            if ($user) {
                $data['user'] = $user[0];
                $this->load->view(ADMIN . STUDENT . 'student_view', $data);
            }
        }
    }

    function getCourseName($id)
    {
        $CI = &get_instance();
        $course = $CI->CommonModel->getData(
            'tbl_courses',
            ['id' => $id],
            'title',
            '',
            'row_array'
        );
        return $course['title'] ?? '-';
    }
}
