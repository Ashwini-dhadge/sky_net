<?php




function  loginId()
{
    $CI = &get_instance();
    //print_r($CI->session->userdata());die;
    if ($CI->session->userdata('user_id')) {
        return $CI->session->userdata('user_id');
    } else {
        redirect(base_url() . 'admin');
    }
}

function getPermission($role = '', $module = '', $permission = '')
{
    $CI = &get_instance();

    $CI->db->join('master_module as m', 'm.id=p.module_id');
    if ($role) {
        $CI->db->where('role_id', $role);
    }

    if ($module) {
        $CI->db->where('m.name', $module);
    }

    if ($permission) {
        if ($permission == 'add') {
            $CI->db->where('can_add', 1);
        }
        if ($permission == 'view') {
            $CI->db->where('can_view', 1);
        }
        if ($permission == 'edit') {
            $CI->db->where('can_update', 1);
        }
        if ($permission == 'delete') {
            $CI->db->where('can_delete', 1);
        }
    }
    $CI->db->or_where('all', 1);

    $result = $CI->db->get('master_roles_permission as p')
        ->result();
    if ($result) {
        return true;
    } else {
        return false;
    }
}

function fileUpload($path, $file_name, $multiple = false)
{
    $CI = &get_instance();
    if ($path  && $file_name) {

        $config['file_name'] = "file_" . time();
        $config['upload_path'] = './' . $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = FALSE;
        $config['remove_spaces'] = TRUE;

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        if ($multiple == false) {
            if (! $CI->upload->do_upload($file_name)) {
                $return['status'] = false;
                $return['message'] = $CI->upload->display_errors();
            } else {
                $uploadData = $CI->upload->data();
                $return['status'] = true;
                $return['message'] = 'Image uploaded!';
                $return['image_name'] = $uploadData['file_name'];
            }
        } else {
            $files = $_FILES;

            $cpt = count($files);
            for ($i = 0; $i < $cpt; $i++) {
                $tem_path = $files[$file_name]['name'][$i];
                $new_name = time() . "." . pathinfo($tem_path, PATHINFO_EXTENSION);
                $_FILES[$file_name]['name'] = $new_name;
                $_FILES[$file_name]['type'] = $files[$file_name]['type'][$i];
                $_FILES[$file_name]['tmp_name'] = $files[$file_name]['tmp_name'][$i];
                $_FILES[$file_name]['error'] = $files[$file_name]['error'][$i];
                $_FILES[$file_name]['size'] = $files[$file_name]['size'][$i];
                if (!$CI->upload->do_upload($file_name)) {
                    $return['status'] = false;
                    $return['message'] = $CI->upload->display_errors();
                } else {
                    $uploadData = $CI->upload->data();
                    $return['status'] = true;
                    $return['message'] = 'Image uploaded!';
                    $return['image_name'][] = $uploadData['file_name'];
                }
            }
        }
    } else {
        $return['status'] = false;
        $return['status'] = 'Invaild Parameters!';
    }
    return $return;
}
function fileUploadForRepeter($path, $repeter_name, $image_field_name)
{
    $CI = &get_instance();
    $attach_file = array();
    if ($path  && $repeter_name && $image_field_name) {
        if ($_FILES) {
            foreach ($_FILES[$repeter_name] as $k => $v) {
                foreach ($v as $v2) {
                    $attach_file[$k][] = $v2[$image_field_name];
                    //$cont++;
                }
            }
        }
        if (! $attach_file) {
            $return['status'] = false;
            $return['status'] = 'Invaild Parameters Repeteer Js!';
            return $return;
        }

        $config['file_name'] = "file_" . time();
        $config['upload_path'] = './' . $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
        $config['overwrite'] = FALSE;
        $config['encrypt_name'] = FALSE;
        $config['remove_spaces'] = TRUE;

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);


        $files = $_FILES;

        $cpt = count($attach_file['name']);
        for ($i = 0; $i < $cpt; $i++) {
            $_FILES = array();
            $tem_path = $attach_file['name'][$i];
            $new_name = time() . "." . pathinfo($tem_path, PATHINFO_EXTENSION);
            $_FILES['new_file']['name'] = $new_name;
            $_FILES['new_file']['type'] =  $attach_file['type'][$i];
            $_FILES['new_file']['tmp_name'] = $attach_file['tmp_name'][$i];
            $_FILES['new_file']['error'] = $attach_file['error'][$i];
            $_FILES['new_file']['size'] = $attach_file['size'][$i];

            if (!$CI->upload->do_upload('new_file')) {
                $return['status'] = false;
                $return['message'] = $CI->upload->display_errors();
            } else {
                $uploadData = $CI->upload->data();
                $return['status'] = true;
                $return['message'] = 'Image uploaded!';
                $return['image_name'][] = $uploadData['file_name'];
            }
        }
    } else {
        $return['status'] = false;
        $return['status'] = 'Invaild Parameters!';
    }
    return $return;
}
function calcuateDate($user_id, $courses_id = 0, $lesson_id = 0, $package_id = 0, $courses_duration_id = 0)
{
    $CI = &get_instance();
    $CI->load->model('app/Courses_model');
    $response = array();
    if ($courses_id && $courses_duration_id) {

        $coursesDuratoion = $CI->CommonModel->getData('tbl_order_courses_subscription', array('user_id' => $user_id, 'course_id' => $courses_id, 'courses_duration_id' => $courses_duration_id, 'active' => 1), '', '', 'row_array');
        //   echo $CI->db->last_query();die;

        $var = is_countable($coursesDuratoion) ? $coursesDuratoion : [];
        if (count($var)) {
            $endDate = $coursesDuratoion['end_date'];
            $response['end_date'] = $coursesDuratoion['end_date'];
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
    } elseif ($package_id && $courses_id == 0) {


        //  print_r($where3);
        /*    $courses = $CI->CommonModel->getData('tbl_courses_packages', $where3);
               //   print_r($courses);die;
                         foreach($courses as $key3=>$course1){
                                $coursesDuratoion = $CI->CommonModel->getData('tbl_order_courses_subscription', array('user_id'=>$user_id,'course_id' => $course1['courses_id'],'courses_duration_id'=>$course1['courses_duration_id'],'active'=>1 ,'type'=>3),'','','row_array');
                             //   print_r($coursesDuratoion);die;
                             //  $courses[$key3]['query']=$CI->db->last_query();
                                if($coursesDuratoion){
                                    $endDate = $coursesDuratoion['end_date'];
                                    $courses[$key3]['end_date']=$endDate;
                                     if($endDate < date('Y-m-d')){
                                        $courses[$key3]['is_expired']=1;
                                    }else{
                                        $courses[$key3]['is_expired']=0;
                                    }
                                      $now = time(); // or your date as well
                                     $your_date = strtotime($endDate);
                                 $datediff = $your_date-$now;
                                 $courses[$key3]['reamining_no_days']=round($datediff / (60 * 60 * 24)); 
                                 $response['courses']=$courses;
                                }
                         }
            */

        $coursesDuratoion = $CI->CommonModel->getData('tbl_order_courses_subscription', array('user_id' => $user_id, 'package_id' => $package_id, 'active' => 1, 'type' => 3), 'max(end_date) as end_date', '', 'row_array');

        if ($coursesDuratoion && !is_null($coursesDuratoion['end_date'])) {

            $endDate = $coursesDuratoion['end_date'];
            //  $courses[$key3]['end_date']=$endDate;
            if ($endDate < date('Y-m-d')) {
                $response['is_expired'] = 1;
            } else {
                $response['is_expired'] = 0;
            }
            $now = time(); // or your date as well
            $your_date = strtotime($endDate);
            $datediff = $your_date - $now;
            $response['reamining_no_days'] = round($datediff / (60 * 60 * 24));
            //  $response['courses']=$courses;
        }
    } elseif ($package_id && $courses_id) {
        $where3['package_id'] = $package_id;
        $where3['courses_id'] = $courses_id;
        //  print_r($where3);
        $courses = $CI->CommonModel->getData('tbl_courses_packages', $where3);
        //   print_r($courses);die;
        foreach ($courses as $key3 => $course1) {
            $coursesDuratoion = $CI->CommonModel->getData('tbl_order_courses_subscription', array('user_id' => $user_id, 'course_id' => $course1['courses_id'], 'courses_duration_id' => $course1['courses_duration_id'], 'active' => 1, 'type' => 3), '', '', 'row_array');
            //    print_r($coursesDuratoion);die;
            //  $courses[$key3]['query']=$CI->db->last_query();
            if ($coursesDuratoion) {
                $endDate = $coursesDuratoion['end_date'];
                $courses[$key3]['end_date'] = $endDate;
                if ($endDate < date('Y-m-d')) {
                    $courses[$key3]['is_expired'] = 1;
                } else {
                    $courses[$key3]['is_expired'] = 0;
                }
                $now = time(); // or your date as well
                $your_date = strtotime($endDate);
                $datediff = $your_date - $now;
                $courses[$key3]['reamining_no_days'] = round($datediff / (60 * 60 * 24));
                $response['courses'] = $courses;
            }
        }
    } elseif ($courses_id) {

        $coursesDuratoion = $CI->CommonModel->getData('tbl_order_courses_subscription', array('user_id' => $user_id, 'course_id' => $courses_id, 'active' => 1), '', '', 'row_array');
        //   print_r($coursesDuratoion);die;
        if ($coursesDuratoion) {
            $endDate = $coursesDuratoion['end_date'];
            $response['end_date'] = $coursesDuratoion['end_date'];
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
    }


    if (!$response) {
        return false;
    } else {
        return $response;
    }
}
//not used
function calcuateDateold($user_id, $courses_id = 0, $lesson_id = 0, $package_id = 0, $courses_duration_id = 0)
{
    $CI = &get_instance();
    $CI->load->model('app/Courses_model');
    $response = array();
    $where2 = array();
    $where_in_key = '';
    $check_course_in_package = 0;
    $where1['o.user_id'] = $user_id;
    $where1['o.order_status'] = 1;
    if ($courses_id) {
        $coursesDuratoion = $CI->CommonModel->getData('tbl_courses_packages', array('courses_id' => $courses_id), 'package_id', '', '');

        if (count($coursesDuratoion)) {
            $packages = array_column($coursesDuratoion, 'package_id');
            if ($packages) {
                $check_course_in_package = 1;
                $where_in_key = 'od.courses_id';
                $where2 = $packages;
                $where1['od.type'] = 3;
            }
        } else {
            $where1['od.courses_id'] = $courses_id;
            $where1['od.type'] = 1;
            if ($courses_duration_id) {
                $where1['od.courses_duration_id'] = $courses_duration_id;
            }
        }
    }
    if ($lesson_id) {
        $where1['od.lesson_id'] = $lesson_id;
        $where1['od.type'] = 2;
    }
    if ($package_id) {
        $where1['od.courses_id'] = $package_id;
        $where1['od.type'] = 3;
    }

    $orderDetails = $CI->Courses_model->getOrderData($where1, $where_in_key, $where2);

    foreach ($orderDetails as $key => $order) {
        $order_date = $order['date'];
        $order[$key]['order_date'] = $order_date;

        if ($order['type'] == 1) {
            //1:course 2: lesson 3:package 
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
        } elseif ($order['type'] == 2) {
            $lesson = $CI->CommonModel->getData('tbl_lesson', array('id' => $order['lesson_id']), '', 'duration_id', 'row_array');
            $duratoion_no_of_days = $CI->CommonModel->getData('tbl_duration_master', array('id' => $lesson['duration_id']), '', 'no_of_days', 'row_array');
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
        } elseif ($order['type'] == 3) {

            $where3['package_id'] = $order['courses_id'];
            if ($package_id && $courses_id) {
                $where3['courses_id'] = $courses_id;
            }
            if ($courses_id && $check_course_in_package) {
                $where3['courses_id'] = $courses_id;
            }
            $courses = $CI->CommonModel->getData('tbl_courses_packages', $where3);

            foreach ($courses as $key3 => $course1) {

                $coursesDuratoion = $CI->CommonModel->getData('tbl_courses_duration', array('id' => $course1['courses_duration_id']), 'duration_id', '', 'row_array');
                $duratoion_no_of_days = $CI->CommonModel->getData('tbl_duration_master', array('id' => $coursesDuratoion['duration_id']), 'no_of_days', '', 'row_array');
                $endDate = date('Y-m-d', strtotime($order_date . " +" . $duratoion_no_of_days['no_of_days'] . " days"));
                $courses[$key3]['end_date'] = $endDate;
                if ($endDate < date('Y-m-d')) {
                    $courses[$key3]['is_expired'] = 1;
                } else {
                    $courses[$key3]['is_expired'] = 0;
                }
                $now = time(); // or your date as well
                $your_date = strtotime($endDate);
                $datediff = $your_date - $now;
                $courses[$key3]['reamining_no_days'] = round($datediff / (60 * 60 * 24));
            }

            if ($package_id && $courses_id) {
                $response[$key]['courses'] = $courses[0];
            } else {
                $response[$key]['courses'] = $courses;
            }
        }
    }
    if (!$response) {
        return false;
    } else {
        return $response;
    }
}

function exportCsv1($header_array, $data_array, $file_name)
{
    // file name 
    $filename = $file_name . date('Ymd') . '.csv';
    header("Content-Description: File Transfer");
    header("Content-Disposition: attachment; filename=$filename");
    header("Content-Type: application/csv; ");



    // file creation 
    $file = fopen('php://output', 'w');

    $header = $header_array;
    fputcsv($file, $header);
    foreach ($data_array as $key => $line) {
        fputcsv($file, $line);
    }
    fclose($file);
    exit;
}
function add_commsion_user($user_id, $orderID, $referral_code, $amount)
{
    $CI = &get_instance();
    $user = $CI->CommonModel->getData('tbl_users', array('self_code' => $referral_code), 'id,commsion_percentage', '', 'row_array');
    if ($user) {
        //   $commsion_amt=round(($user['commsion_percentage'] * $amount)/100,2);
        $commsion_amt = ($user['commsion_percentage'] * $amount) / 100;
        $getBalance = getQuickWalletAmount($user_id);
        $Balance = $getBalance['remaining_balance'] + $commsion_amt;
        $wallet_data = array('user_id' => $user['id'], 'action' => 1, 'amount' => $commsion_amt, 'trans_details' => 'add commsion aginst order', 'wallet_type' => 2, 'order_no' => $orderID, 'created_by' => $user_id, 'remaining_balance' => $Balance);
        $CI->CommonModel->iudAction('wallet_transaction', $wallet_data, 'insert');
        // updateQuickWallentAMount($user['id'],1,$commsion_amt);
        return true;
    } else {
        return true;
    }
}
function withdraw_wallet_amount_user($user_id, $orderID, $amount, $wallet_type = 3, $trans_details = 'wallet amount use aginst order')
{
    $CI = &get_instance();
    if ($amount) {
        $getBalance = getQuickWalletAmount($user_id);
        $Balance = $getBalance['remaining_balance'] - $amount;
        $wallet_data = array('user_id' => $user_id, 'action' => 2, 'amount' => $amount, 'trans_details' => $trans_details, 'wallet_type' => $wallet_type, 'order_no' => $orderID, 'created_by' => $user_id, 'remaining_balance' => $Balance);
        $CI->CommonModel->iudAction('wallet_transaction', $wallet_data, 'insert');
    }


    return true;
}
function getQuickWalletAmount($user_id)
{
    $CI = &get_instance();

    $myAllTransaction = $CI->CommonModel->getData('wallet_transaction', array('user_id' => $user_id), 'remaining_balance,id', '', 'row_array', 'id', 'desc');

    if ($myAllTransaction) {
        $walletBalance['remaining_balance'] = $myAllTransaction['remaining_balance'];
        $walletBalance['id'] = $myAllTransaction['id'];
    } else {
        $walletBalance['remaining_balance'] = 0;
        $walletBalance['id'] = 0;
    }
    return $walletBalance;
}
function updateQuickWallentAMount($user_id = '', $action = 1, $amount = '')
{
    $CI = &get_instance();
    $getBalance = getQuickWalletAmount($user_id);

    if ($action == 1) {
        $Balance = $getBalance['remaining_balance'] + $amount;
    } elseif ($action == 2) {
        $Balance = $getBalance['remaining_balance'] - $amount;
    }
    $CI->CommonModel->iudAction('wallet_transaction', array('remaining_balance' => $Balance), 'update', array('id' => $getBalance['id'], 'user_id' => $user_id));
}
function getWithdrawAmount($user_id)
{
    $CI = &get_instance();
    $transaction = $CI->CommonModel->getData('tbl_payments_withdraw', array('user_id' => $user_id), 'sum(payment_amount)as total', '', 'row_array', 'id', 'desc', '1');;
    if ($transaction) {
        $balance = $transaction['total'];
    } else {
        $balance = 0;
    }
    return $balance;
}

function get_instruction()
{
    return   "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";
}
function send_final_exam_certificate($post_id)
{
    //  echo FCPATH;
    $CI = &get_instance();
    $CI->load->library('pdf');
    $CI->load->model('app/Post_model');
    // $data['name']=userId('name');


    $data['wall'] = $CI->Post_model->getPublicWall(array('p.id' => $post_id), 0, 0);
    //   echo $CI->db->last_query();die;
    $data['name'] = ucfirst($data['wall'][0]['post_sender_name']);
    $data['course_name'] = ucfirst($data['wall'][0]['course_name']);
    $data['link'] = base_url() . 'download-certificate/' . $post_id;
    $htmlContent =  $CI->load->view('app/certificate_template_mail', $data, true);

    // echo $htmlContent;die;
    $email_from = 'Course Cerificate';
    //
    $html =  $CI->load->view('app/final_certificate', $data, true);
    $pdfFilePath = $CI->pdf->savePDF($html, 'mypdf', true, 'A4', 'landscape');

    $res1 = sendMail(EMAIL_ID, $email_from, $data['wall'][0]['post_sender_mail'], $email_from, $htmlContent, $pdfFilePath);
    //  $res1 = sendMail(EMAIL_ID,$email_from,'vijendrasalve@gmail.com',$email_from,$htmlContent,$pdfFilePath);

    if ($res1) {
        $CI->session->set_flashdata('success', 'Mail sent to the registered e-mail id');
        return 1;
    } else {
        $CI->session->set_flashdata('error', "Mail Not send");
        return 0;
    }
}
function download_certificate_for_mail($post_id)
{
    $CI = &get_instance();
    $CI->load->library('m_pdf');
    $CI->load->model('app/Post_model');
    //now pass the data//
    $data = array();
    $data['wall'] = $CI->Post_model->getPublicWall(array('p.id' => $post_id), 0, 0);

    $html =  $CI->load->view('app/certificate_mail', $data, true);
    //echo $html;die;
    $pdfFilePath = COURSE_CERTIFICATE_MAIL . "CERTI" . time() . ".pdf";

    $pdf = $CI->m_pdf->load();

    $pdf->WriteHTML($html);

    $pdf->Output($pdfFilePath, "F");
    $download_link = base_url() . $pdfFilePath;

    return $download_link;
}

function save_certificate_for_mail($post_id)
{
    $CI = &get_instance();
    $CI->load->library('m_pdf');
    $CI->load->model('app/Post_model');
    //now pass the data//
    $data = array();
    $data['wall'] = $CI->Post_model->getPublicWall(array('p.id' => $post_id), 0, 0);

    $html =  $CI->load->view('app/certificate_mail', $data, true);
    //echo $html;die;
    $pdfFilePath = COURSE_CERTIFICATE_MAIL . "CERTI" . time() . ".pdf";

    $pdf = $CI->m_pdf->load();

    $pdf->WriteHTML($html);

    $pdf->Output($pdfFilePath, "F");
    $download_link = FCPATH . $pdfFilePath;
    return $download_link;
}
function encode_img_base64($img_path = false, $img_type = 'png')
{
    if ($img_path) {
        //convert image into Binary data
        $img_data = fopen($img_path, 'rb');
        $img_size = filesize($img_path);
        $binary_image = fread($img_data, $img_size);
        fclose($img_data);

        //Build the src string to place inside your img tag
        $img_src = "data:image/" . $img_type . ";base64," . str_replace("\n", "", base64_encode($binary_image));

        return $img_src;
    }

    return false;
}