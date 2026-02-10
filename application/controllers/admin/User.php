<?php

/**
 * 
 */
class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'UserModel');
        loginId();
    }

    /*********************************************************************/
    // 

    public function index()
    {
        $data['title'] = 'Users';
        $data['active'] = 'User';
        $data['role'] = 2;
    // echo $data['role']; die();
        $this->load->view(ADMIN . USER . 'list-user', $data);
    }
    public function index1()
    {
        $data['title'] = 'Instructor';
        $data['active'] = 'Instructor';
        $data['role'] = 4;
        $this->load->view(ADMIN . USER . 'list-user', $data);
    }
    public function listUsers()
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

        $count = count($this->UserModel->getUserData($searchVal, 0, 0, 0, 0, 0, $role_id));
        // print_r($count);die;
        if ($count) {
            $userData = $this->UserModel->getUserData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $role_id);

            foreach ($userData as $key => $user) {
                $row = [];
                $no = $offset + ($key + 1);
                array_push($row, $offset + ($key + 1));
                $img = ($user['image']) ? $user['image'] : 'no-image.png';
                //'.base_url().ADMIN.'Users/view/'.$value['id'].'
                $name_tag = '<a href="' . base_url() . ADMIN . 'User/view/' . $user['id'] . '/' . $user['role'] . '" title="View" class="text-primary waves-effect waves-ligh mr-2 " ><img src="' . base_url() . USER_IMAGES . $img . '" width="60" class="rounded-circle"></a>';
                $name_tag1 = '<a href="' . base_url() . ADMIN . 'User/view/' . $user['id'] . '/' . $user['role'] . '" title="View" class="text-primary waves-effect waves-ligh mr-2 " >' . $user['first_name'] . ' ' . $user['last_name'] . '</a>';
                array_push($row, $name_tag);
                array_push($row, $name_tag1);
                array_push($row, $user['email']);
                array_push($row, $user['mobile_no']);
                array_push($row, $user['password']);
                array_push($row, $user['commsion_percentage']);
                if ($user['status']) {
                    $status = '<span class="badge badge-success ">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger ">Not Active</span>';
                }
                array_push($row, $status);
                $confirm = "confirm('Are you sure you want to delete this Officer?')";

                $action = '
                <a href="' . site_url() . ADMIN . 'User/add/' . $user['id'] . '" title="Edit" class="btn btn-success waves-effect waves-light btn-sm " ><i class="fas fa-edit" aria-hidden="true"></i></a>
                <a href="' . base_url() . ADMIN . 'User/view/' . $user['id'] . '/' . $user['role'] . '" title="view" class="btn btn-primary btn-sm waves-effect waves-light" ><i class="fas fa-eye" aria-hidden="true"></i></a>
                <a onclick="return ' . $confirm . '" href="' . base_url() . ADMIN . 'User/delete/' . $user['id'] . '" title="Delete" class="btn btn-danger btn-sm waves-effect waves-light" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                
                ';


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
    public function view($_id, $_role)
    {
        if ($_role == 3) {
            $data['title'] = 'Users';
            $user = $this->UserModel->getUserData('', 0, 0, 0, 0, $_id);
            if ($user) {
                //$data['title'] = 'Users';
                $data['user'] = $user[0];
                $this->load->view(ADMIN . USER . 'user_view', $data);
            }
        } else {
            $data['title'] = 'Instructor';
            $user = $this->UserModel->getUserData('', 0, 0, 0, 0, $_id);
            // print_r($user);die;
            if ($user) {
                //$data['title'] = 'Users';
                $data['user'] = $user[0];

                $this->load->view(ADMIN . USER . 'instructor_view', $data);
            }
        }
    }
    public function add($_id = '')
    {
        $data['title'] = 'Add Instructor';

        $post = $this->input->post();

        $role = $post['role'] ?? null;

        if ($role == 2) {
            $data['role'] = 2;
        } elseif ($role == 4) {
            $data['role'] = 4;
        }


        // echo '<pre>';
        // print_r($post);
        // die();

        if ($post) {

            /* ================= MOBILE UNIQUE CHECK ================= */

            $this->db->where('mobile_no', $post['mobile_no']);
            $this->db->where('is_deleted', 0);

            if (!empty($post['id'])) {
                // EDIT MODE → exclude current user
                $this->db->where('id !=', $post['id']);
            }

            $mobileExists = $this->db->count_all_results('tbl_users');

            if ($mobileExists > 0) {
                $this->session->set_flashdata('error', 'Mobile number already exists');
                redirect($_SERVER['HTTP_REFERER']);
                return; // 🔥 STOP EXECUTION
            }

            /* ================= CONTINUE SAVE ================= */

            $instructor = $post;

            if (!empty($_FILES['image']['name'])) {
                $result = fileUpload(USER_IMAGES, 'image');
                if ($result['status']) {
                    $instructor['image'] = $result['image_name'];
                } else {
                    unset($instructor['image']);
                }
            } else {
                unset($instructor['image']);
            }

            $role = $post['role'];

            $otpNumber   = create6NumRandom();
            $selfReferral = "LMS" . $post['mobile_no'];

            $instructor['self_code'] = $selfReferral;
            $instructor['otp']       = $otpNumber;
            $instructor['user_from'] = 1;
            if($role == 2){
                $instructor['user_type'] = 0;
            }

            if (empty($post['id'])) {
                /* ===== INSERT ===== */
                $instructor['is_otp_verified'] = 0;

                if ($this->CommonModel->iudAction('tbl_users', $instructor, 'insert')) {

                    $this->session->set_flashdata(
                        'success',
                        ($role == 4) ? 'Instructor Added Successfully' : 'User Added Successfully'
                    );
                } else {
                    $this->session->set_flashdata('error', 'Fail To Add Instructor');
                }
            } else {
                /* ===== UPDATE ===== */
                $instructor['is_otp_verified'] = 1;

                $this->CommonModel->iudAction(
                    'tbl_users',
                    $instructor,
                    'update',
                    ['id' => $post['id']]
                );

                $this->session->set_flashdata(
                    'success',
                    ($role == 4) ? 'Instructor Updated Successfully' : 'User Updated Successfully'
                );
            }


            if ($role == 2) {
                redirect(base_url(ADMIN . 'User'));
                exit;
            } elseif ($role == 4) {
                redirect(base_url(ADMIN . 'User/index1'));
                exit;
            } else {
                redirect(base_url(ADMIN . 'User'));
                exit;
            }
        }

        /* ================= EDIT VIEW ================= */
        if ($_id) {

            $instructor = $this->UserModel->getUserData('', 0, 0, 0, 0, $_id);

            if (empty($instructor)) {
                show_404();
            }

            $data = $instructor[0];

            // VERY IMPORTANT
            $data['role'] = $data['role'];

            $data['title'] = ($data['role'] == 4)
                ? 'Edit Instructor'
                : 'Edit User';

            $this->load->view(ADMIN . USER . 'add-instructor', $data);
            return;
        }


        if ($role == 2) {
            redirect(base_url(ADMIN . 'User'));
        } elseif ($role == 4) {
            redirect(base_url(ADMIN . 'User/index1'));
        } else {
            redirect(base_url(ADMIN . 'User'));
        }
    }


    public function add_user($role = 2)
    {
        $data['title'] = ($role == 4) ? 'Add Instructor' : 'Add User';
        $data['role']  = $role;

        $this->load->view(ADMIN . USER . 'add-instructor', $data);
    }

    public function delete($id)
    {
        if ($id) {
            if ($this->CommonModel->iudAction('tbl_users', array('is_deleted' => 1), 'update', array('id' => $id))) {

                $this->session->set_flashdata('success', ' Deleted Successfully');
            } else {
                $this->session->set_flashdata('error', 'Fail to Delete ');
            }
        } else {
            $this->session->set_flashdata('error', INVAILD_INPUT);
        }

        redirect(base_url(ADMIN . 'User/index1'));
    }
    public function checkMobile()
    {
        $mobile = $this->input->post('mobile_no');
        $id     = (int)$this->input->post('id');

        if (!$mobile) {
            echo json_encode(['valid' => false]);
            return;
        }

        $this->db->where('mobile_no', $mobile);
        $this->db->where('is_deleted', 0);

        if ($id > 0) {
            $this->db->where('id !=', $id);
        }

        $exists = $this->db->count_all_results('tbl_users');

        echo json_encode([
            'valid' => ($exists === 0)
        ]);
    }


    public function updateIMEINO()
    {
        $post = $this->input->post();

        if ($post['action'] == 1) {
            $res = $this->CommonModel->iudAction('tbl_users', array('imei_no' => $post['imei_no'], 'commsion_percentage' => $post['commsion_percentage']), 'update', array('id' => $post['id']));
        } else {
            $res = $this->CommonModel->iudAction('tbl_users', array('imei_no' => NULL), 'update', array('id' => $post['id']));
        }
        if ($res) {
            $result['result'] = true;
            $result['reason'] = "Data updated successfully";
        } else {
            $result['reason'] = false;
            $result['reason'] = "Data updated successfully";
        }
        echo json_encode($result);
    }
    public function listUsersMyCourses()
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
        $where = array();
        $user_id = $this->input->post('user_id');
        $type = $this->input->post('type');
        if ($user_id) {
            $where['o.user_id'] = $user_id;
        }
        if ($type) {
            $where['od.type'] = $type;
        }

        // print_r($where);die();

        $count = count($this->UserModel->getUserCourseData($searchVal, 0, 0, 0, 0, 0, $where));
        // echo $this->db->last_query();die();
        // print_r($count);die;
        if ($count) {
            $userData = $this->UserModel->getUserCourseData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);

            foreach ($userData as $key => $user) {
                $row = [];
                $no = $offset + ($key + 1);
                array_push($row, $offset + ($key + 1));
                if ($type == 1) {
                    array_push($row, $user['course_name'] . "(" . $user['duration_name'] . ")");
                } else {
                    array_push($row, $user['course_name']);
                }
                $order_no = '<a href="' . base_url() . ADMIN . 'Order/view/' . $user['order_id'] . '" title="View" class="text-primary waves-effect waves-ligh " >' . $user['order_no'] . '</a>';
                array_push($row, $order_no);
                if ($user['order_status'] == 1) {
                    $class = 'success';
                    $status = '<span class="badge badge-' . $class . '" >New</span>';
                } else if ($user['order_status'] == 2) {
                    $class = 'secondary';
                    $status = '<span class="badge badge-' . $class . '" >Changed Courses</span>';
                } else if ($user['order_status'] == 3) {
                    $class = 'danger';
                    $status = '<span class="badge badge-' . $class . '" >Cancel</span>';
                } else if ($user['order_status'] == 0) {
                    $class = 'danger';
                    $status = '<span class="badge badge-' . $class . '" >In Active</span>';
                }
                array_push($row, $status);
                array_push($row, $user['order_date']);
                if ($type == 1) {
                    $endDate = date('Y-m-d', strtotime($user['order_date'] . " +" . $user['no_of_days'] . " days"));
                    if ($endDate < date('Y-m-d')) {
                        $is_expired = 1;
                    } else {
                        $is_expired = 0;
                    }
                    $now = time(); // or your date as well
                    $your_date = strtotime($endDate);
                    $datediff = $your_date - $now;
                    $reamining_no_days = round($datediff / (60 * 60 * 24));
                    array_push($row, $endDate);
                    if ($is_expired) {
                        $status = '<span class="badge badge-danger">Expired</span>';
                    } else {
                        $status = '<span class="badge badge-sucess">Current</span>';
                    }
                    array_push($row, $status);
                } else {
                    array_push($row, '');
                    array_push($row, '');
                }


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

    public function calcuateNodays($value = '')
    {
        $coursesDuratoion = $CI->CommonModel->getData('tbl_courses_duration', array('id' => $order['courses_duration_id']), 'duration_id', '', 'row_array');

        $duratoion_no_of_days = $CI->CommonModel->getData('tbl_duration_master', array('id' => $coursesDuratoion['duration_id']), 'no_of_days', '', 'row_array');

        $endDate = date('Y-m-d', strtotime($order_date . " +" . $duratoion_no_of_days['no_of_days'] . " days"));
        $response['end_date'] = $endDate;
        if ($endDate < date('Y-m-d')) {
            $response['is_expired'] = 1;
        } else {
            $response['is_expired'] = 0;
        }
        $now = time(); // or your date as well
        $your_date = strtotime($endDate);
        $datediff = $your_date - $now;
        $response['reamining_no_days'] = round($datediff / (60 * 60 * 24));
    }

    public function getUsersName($id = 0)
    {

        if (isset($_GET['searchTerm'])) {
            $searchTerm = $_GET['searchTerm'];
        } else {
            $searchTerm = '';
        }
        $pes = $this->UserModel->getUserName($searchTerm);
        $data = $chidls = array();
        foreach ($pes as $key => $ps) {
            if ($ps['id'] == $id) {
                $data[] = ['id' => $ps['id'], 'text' => $ps['name'], 'selected' => 'true'];
            } else {
                $data[] = ['id' => $ps['id'], 'text' => $ps['name']];
            }
        }
        echo json_encode($data);
    }

    public function listUsersMyChallenge()
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
        $where = array();
        $user_id = $this->input->post('user_id');
        $type = $this->input->post('type');
        if ($user_id) {
            $where['cr.user_id'] = $user_id;
            //  cr.user_id
        }

        // print_r($where);die();

        $count = count($this->UserModel->getUserChallengeMCQData($searchVal, 0, 0, 0, 0, 0, $where));
        // echo $this->db->last_query();die();
        // print_r($count);die;
        if ($count) {
            $userData = $this->UserModel->getUserChallengeMCQData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);

            foreach ($userData as $key => $user) {
                $row = [];
                $no = $offset + ($key + 1);

                array_push($row, $offset + ($key + 1));
                array_push($row, $user['exam_title']);
                array_push($row, $user['exam_duration']);
                array_push($row, $user['solved_duration']);
                array_push($row, $user['total_marks'] . "/" . $user['out_of_mark']);
                array_push($row, $user['exam_date']);
                array_push($row, $user['rank']);
                if ($user['badges_image']) {
                    $img = '<img src="' . base_url() . UPLOAD_PATH_BADGES . $user['badges_image'] . '" width="50px" height="">';
                } else {
                    $img = '';
                }
                array_push($row, $img);
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

    public function listUsersMyVideoMCQ()
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
        $where = array();
        $user_id = $this->input->post('user_id');
        $type = $this->input->post('type');
        if ($user_id) {
            $where['cr.user_id'] = $user_id;
            //  cr.user_id
        }

        // print_r($where);die();

        $count = count($this->UserModel->getUserVideoMCQData($searchVal, 0, 0, 0, 0, 0, $where));
        // echo $this->db->last_query();die();
        // print_r($count);die;
        if ($count) {
            $userData = $this->UserModel->getUserVideoMCQData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);

            foreach ($userData as $key => $user) {
                $row = [];
                $no = $offset + ($key + 1);

                array_push($row, $offset + ($key + 1));
                array_push($row, $user['exam_title']);
                array_push($row, $user['total_marks'] . "/" . $user['out_of_mark']);
                array_push($row, $user['exam_date']);

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
    public function listUsersMyWallet()
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
        $where = array();
        $user_id = $this->input->post('user_id');

        if ($user_id) {
            $where['user_id'] = $user_id;
        }

        // print_r($where);die();

        $count = count($this->UserModel->getUserWalletData($searchVal, 0, 0, 0, 0, 0, $where));
        // echo $this->db->last_query();die();
        // print_r($count);die;
        if ($count) {
            $userData = $this->UserModel->getUserWalletData($searchVal, $sortColIndex, $sortBy, $limit, $offset, 0, $where);

            foreach ($userData as $key => $user) {
                $row = [];
                $no = $offset + ($key + 1);
                array_push($row, $offset + ($key + 1));
                array_push($row, $user['trans_details']);
                array_push($row, $user['amount']);

                if ($user['wallet_type'] == 1) {
                    $class = 'success';
                    $status = '<span class="badge badge-' . $class . '" >Reference Amount</span>';
                } else if ($user['wallet_type'] == 2) {
                    $class = 'primary';
                    $status = '<span class="badge badge-' . $class . '" >commission</span>';
                }
                array_push($row, $status);
                if ($user['order_no']) {
                    $order_no = '<a href="' . base_url() . ADMIN . 'Order/view/' . $user['order_no'] . '" title="View" class="text-primary waves-effect waves-ligh " >' . $user['order_no'] . '</a>';
                    array_push($row, $order_no);
                } else {
                    array_push($row, '-');
                }


                array_push($row, $user['created_at']);

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
}
