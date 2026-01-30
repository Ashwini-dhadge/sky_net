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
        if ($post_data = $this->input->post()) {
            if ($data = $this->CommonModel->getData('tbl_users', $post_data)) {
                $session = array(
                    'user_id'     => $data[0]['id'],
                    'name' => $data[0]['first_name'],
                    'role' => $data[0]['role'],
                    'image'     => $data[0]['image'],
                );
                $this->session->set_userdata($session);
                redirect(base_url('dashboard'));
            } else {
                $this->session->set_flashdata('error', 'Invaild Username Or Password');
                redirect(base_url('admin'));
            }
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