<?php

/**
 * 
 */
class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        if ($this->input->post()) {

            $email    = $this->input->post('email');
            $password = $this->input->post('password');
            $user = $this->CommonModel->getData('tbl_users',['email' => $email],'*','','row_array');

            if (empty($user)) {
                $this->session->set_flashdata(
                    'error',
                    'Invalid Username Or Password'
                );
                redirect(base_url('admin'));
            }

            // if ($user['password'] != md5($password))

            if ($password !== $user['password']) {

                $this->session->set_flashdata(
                    'error',
                    'Invalid Username Or Password'
                );

                redirect(base_url('admin'));
            }

            if ($user['status'] == 0) {
                $this->session->set_flashdata(
                    'error',
                    'Your account is inactive'
                );
                redirect(base_url('admin'));
            }

            if ($user['is_deleted'] == 1) {
                $this->session->set_flashdata(
                    'error',
                    'Your account is deleted'
                );
                redirect(base_url('admin'));
            }

            // STUDENT BLOCK
            if ($user['role'] == 3) {
                $this->session->set_flashdata(
                    'error',
                    'Student Not Allowed To Login'
                );
                redirect(base_url('admin'));
            }
            $session = [
                'user_id' => $user['id'],
                'name'    => $user['first_name'],
                'role'    => $user['role'],
                'image'   => $user['image'],
            ];
            $this->session->set_userdata($session);
            redirect(base_url('dashboard'));
        } else {
            if ($this->session->userdata('user_id')) {
                redirect(base_url('dashboard'));
            } else {
                $this->load->view(ADMIN . AUTH . 'login');
            }
        }
    }
    public function logout()
    {
        $this->session->sess_destroy();
        return redirect(base_url('admin'));
    }
}
