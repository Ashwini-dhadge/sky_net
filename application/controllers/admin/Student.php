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
        loginId();
    }

    public function index()
    {
        $data['title'] = 'Student';
        $data['active'] = 'Student';
        $data['role'] = 3;
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
                $name_tag = '<a href="' . base_url() . ADMIN . 'Student/view/' . $user['id'] . '/' . $user['role'] . '" title="View" class="text-primary waves-effect waves-ligh mr-2 " ><img src="' . base_url() . USER_IMAGES . $img . '" width="60" class="rounded-circle"></a>';
                $name_tag1 = '<a href="' . base_url() . ADMIN . 'Student/view/' . $user['id'] . '/' . $user['role'] . '" title="View" class="text-primary waves-effect waves-ligh mr-2 " >' . $user['first_name'] . ' ' . $user['last_name'] . '</a>';
                array_push($row, $name_tag);
                array_push($row, $name_tag1);
                array_push($row, $user['email']);
                array_push($row, $user['mobile_no']);
                array_push($row, $user['password']);
                if($user['user_type']== 0){
                    $user_type = '<span class="badge badge-info ">Offline</span>';
                }else{
                    $user_type = '<span class="badge badge-warning ">Online</span>';
                }
                array_push($row, $user_type);
                if ($user['status']) {
                    $status = '<span class="badge badge-success ">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger ">Not Active</span>';
                }
                array_push($row, $status);
                $confirm = "confirm('Are you sure you want to delete this Officer?')";

                $action = '
                <a href="' . base_url() . ADMIN . 'Student/add/' . $user['id'] . '" title="Edit" class="btn btn-success waves-effect waves-light btn-sm " ><i class="fas fa-edit" aria-hidden="true"></i></a>
                <a href="' . base_url() . ADMIN . 'Student/view/' . $user['id'] . '/' . $user['role'] . '" title="view" class="btn btn-primary btn-sm waves-effect waves-light" ><i class="fas fa-eye" aria-hidden="true"></i></a>
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

    public function add_student()
    {
        $data['title'] = 'Add Student';
        $data['role'] = 3;
        $this->load->view(ADMIN . STUDENT . 'add-student', $data);
    }

    public function add($id = '')
    {
        $data['title'] = 'Add Student';
        $data['role'] = 3;

        $post = $this->input->post();
        if ($post) {
            $student = $post;
            if ($_FILES) {
                $result = fileUpload(USER_IMAGES, 'image');
                if ($result['status'] == true) {
                    $student['image'] = $result['image_name'];
                } else {
                    unset($student['image']);
                }
            } else {
                unset($student['image']);
            }
            $role = $this->input->post('role');
            //   $student['role']=4;
            // print_r($student);die;
            $otpNumber = create6NumRandom();
            $selfReferral = "LMS" . $student['mobile_no'];
            $student['self_code'] = $selfReferral;
            $student['otp'] = $otpNumber;

            $student['user_from'] = 1;
            $student['user_type'] = 0;
            if ($post['id'] == '') {
                $student['is_otp_verified'] = 0;
                if ($id = $this->CommonModel->iudAction('tbl_users', $student, 'insert')) {
                    if ($role == 4) {
                        $this->session->set_flashdata('success', 'Instructor Added Successfully');
                    } else {

                        $verificationMessage = $otpNumber . " is the one time password (OTP) for Login. Thanks, Team Lalit Dangre";
                        // sendMobileMessage($verificationMessage, $student['mobile_no'],'1507163947670092160');

                        $this->session->set_flashdata('success', 'User Added Successfully');
                    }
                } else {
                    $this->session->set_flashdata('error', 'Fail To Add Student');
                }
            } else {
                $student['is_otp_verified'] = 1;
                $this->CommonModel->iudAction('tbl_users', $student, 'update', array('id' => $post['id']));
                if ($role == 4) {
                    $this->session->set_flashdata('success', 'Student Updated Successfully');
                } else {
                    $this->session->set_flashdata('success', 'User Updated Successfully');
                }
            }
            if ($role == 3) {
                redirect(base_url(ADMIN . 'Student'));
            } else {
                redirect(base_url(ADMIN . 'Student/index'));
            }
        }
        if ($id) {
            $student = $this->UserModel->getUserData('', 0, 0, 0, 0, $id);
            $data = $student[0];
            $data['title'] = 'Edit Student';
        }
        //  print_r($data);die;
        $this->load->view(ADMIN . STUDENT . 'add-student', $data);
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
            $data['title'] = 'Student';
            $user = $this->UserModel->getUserData('', 0, 0, 0, 0, $_id);
            // print_r($user);die;
            if ($user) {
                //$data['title'] = 'Users';
                $data['user'] = $user[0];

                $this->load->view(ADMIN . STUDENT . 'student_view', $data);
            }
        }
    }
}
