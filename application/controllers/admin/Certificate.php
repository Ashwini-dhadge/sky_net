<?php

class Certificate extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'CertificateModel');
        loginId();
    }
    public function index()
    {
        $data['title'] = 'Certificate';
        // echo "Certificate";
        $data['users'] = $this->CommonModel->getData('tbl_users', ['is_deleted' => 0, 'role' => 3, 'status' => 1], '', '', '');
        $this->load->view('admin/certificate/list-certificate', $data);
    }

    public function Certificate_list()
    {
        $data = $_POST;
        $columns = [];

        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];

        $totalData = $this->CertificateModel->getCertificateList($searchVal, $sortColIndex, $sortBy, 0, 0);
        $count = count($totalData);

        if ($count) {

            $CertificateData = $this->CertificateModel->getCertificateList($searchVal, $sortColIndex, $sortBy, $limit, $offset);

            foreach ($CertificateData as $key => $rowData) {

                $row = [];

                $row[] = $offset + ($key + 1);
                $row[] = $rowData['certificate_title'];
                $row[] = $rowData['certificate_number'];
                $row[] = $rowData['first_name'] . ' ' . $rowData['last_name'];
                $row[] = $rowData['course_name'] ?? 'N/A';
                $row[] = $rowData['score'] ? $rowData['score'] : 'N/A';
                $row[] = $rowData['grade'] ? $rowData['grade'] : 'N/A';
                $row[] = $rowData['issued_date'];

                $status = $rowData['status']
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-danger">Inactive</span>';

                $row[] = $status;

                // 👉 ACTION BUTTONS (CLEAN)
                $action = '
                            <a href="javascript:void(0);" 
                                class="btn btn-primary btn-sm editCertificate" 
                                data-id="' . $rowData['id'] . '" 
                                data-user="' . $rowData['user_id'] . '" 
                                title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        ';

                        //  <a href="' . base_url() . ADMIN . 'Certificate/delete/' . $rowData['id'] . '" 
                        //         class="btn btn-danger btn-sm" 
                        //         onclick="return confirm(\'Are you sure to delete?\')" 
                        //         title="Delete">
                        //         <i class="fas fa-trash"></i>
                        //     </a>

                $row[] = $action;

                // 👉 PUSH
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

    public function make_certificate_modal()
    {
        $user_id = $this->input->post('user_id');
        $id      = $this->input->post('id');
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

        if (!empty($id)) {
            $data['certificate'] = $this->CommonModel->getData(
                'tbl_certificates',
                ['id' => $id],
                '',
                '',
                'row_array'
            );
        } else {
            $data['certificate'] = [];
        }

        $this->load->view('admin/student/certificate_modal', $data);
    }

    // public function save_certificate()
    // {
    //     $post = $this->input->post();

    //     $data = [
    //         'user_id' => $post['user_id'],
    //         'course_id' => !empty($post['course_id']) ? $post['course_id'] : NULL,
    //         'external_course' => $post['external_course'] ?? NULL,
    //         'certificate_title' => $post['certificate_title'],
    //         'score' => $post['score'] ?? NULL,
    //         'grade' => $post['grade'] ?? NULL,
    //         'issued_date' => $post['issued_date'],
    //     ];

    //     if (!empty($_FILES['certificate_file']['name'])) {

    //         $_FILES['cert_file'] = [
    //             'name'     => $_FILES['certificate_file']['name'],
    //             'type'     => $_FILES['certificate_file']['type'],
    //             'tmp_name' => $_FILES['certificate_file']['tmp_name'],
    //             'error'    => $_FILES['certificate_file']['error'],
    //             'size'     => $_FILES['certificate_file']['size'],
    //         ];

    //         $upload = fileUpload(CERTIFICATE_FILES, 'cert_file', false);

    //         if ($upload['status']) {
    //             $data['certificate_file'] = $upload['image_name'];
    //         }
    //     }

    //     if (!empty($post['id'])) {

    //         $data['updated_at'] = date('Y-m-d H:i:s');

    //         $this->CommonModel->iudAction(
    //             'tbl_certificates',
    //             $data,
    //             'update',
    //             ['id' => $post['id']]
    //         );

    //         echo json_encode([
    //             'status' => true,
    //             'message' => 'Certificate Updated Successfully'
    //         ]);
    //     } else {

    //         $data['certificate_number'] = 'CERT' . time();
    //         $data['created_at'] = date('Y-m-d H:i:s');

    //         $this->CommonModel->iudAction(
    //             'tbl_certificates',
    //             $data,
    //             'insert'
    //         );

    //         echo json_encode([
    //             'status' => true,
    //             'message' => 'Certificate Generated Successfully'
    //         ]);
    //     }
    // }


    public function save_certificate()
    {
        $post = $this->input->post();

        $course_id = $post['course_id'] ?? '';
        $external_course = $post['external_course'] ?? '';

        $course_id = trim($course_id);
        $external_course = trim($external_course);

        if ($course_id !== '') {
            $external_course = null;
        } elseif ($external_course !== '') {
            $course_id = null;
        } else {
            $course_id = null;
            $external_course = null;
        }

        $data = [
            'user_id' => $post['user_id'],
            'course_id' => $course_id,
            'external_course' => $external_course,
            'certificate_title' => $post['certificate_title'],
            'score' => $post['score'] ?? null,
            'grade' => $post['grade'] ?? null,
            'issued_date' => $post['issued_date'],
        ];

        if (!empty($_FILES['certificate_file']['name'])) {
            $_FILES['cert_file'] = [
                'name'     => $_FILES['certificate_file']['name'],
                'type'     => $_FILES['certificate_file']['type'],
                'tmp_name' => $_FILES['certificate_file']['tmp_name'],
                'error'    => $_FILES['certificate_file']['error'],
                'size'     => $_FILES['certificate_file']['size'],
            ];

            $upload = fileUpload(CERTIFICATE_FILES, 'cert_file', false);

            if ($upload['status']) {
                $data['certificate_file'] = $upload['image_name'];
            }
        }

        if (!empty($post['id'])) {
            $data['updated_at'] = date('Y-m-d H:i:s');

            $this->CommonModel->iudAction(
                'tbl_certificates',
                $data,
                'update',
                ['id' => $post['id']]
            );

            echo json_encode([
                'status' => true,
                'message' => 'Certificate Updated Successfully'
            ]);
        } else {
            $data['certificate_number'] = 'CERT' . time();
            $data['created_at'] = date('Y-m-d H:i:s');

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
    }
    
    public function delete($id = '')
    {
        $this->CommonModel->iudAction(
            'tbl_certificates',
            ['is_deleted' => 1],
            'update',
            ['id' => $id]
        );
    }
}
