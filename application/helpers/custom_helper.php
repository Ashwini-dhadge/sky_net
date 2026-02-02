<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Upload single and multiple image
 */
if (!function_exists('myUpload')) {

    function myUpload($upload_path, $name, $multiple = FALSE)
    {
        $ci = &get_instance();
        $config = array(
            'file_name' => "img_" . time(),
            'allowed_types' => '*',
            'max_size' => 1000024,
            'overwrite' => FALSE,
            'upload_path' => $upload_path
        );

        $ci->upload->initialize($config);

        if (!$multiple) {
            if ($_FILES[$name]['name'] == null) {
                return array('errorf' => TRUE, 'error' => 'Please Select Image');
            }

            if (!$ci->upload->do_upload($name)) {
                return array('errorf' => TRUE, 'error' => $ci->upload->display_errors());
            } else {

                $data = $ci->upload->data();
                return array('errorf' => FALSE, 'data' => $ci->upload->data());
            }
        } else {
            $temp = array();

            if ($_FILES[$name]['name'] == null) {
                return array('errorf' => TRUE, 'error' => 'Please Select Image');
            }

            $files = $_FILES;
            $number_of_files_uploaded = count($_FILES[$name]['name']);

            for ($i = 0; $i < $number_of_files_uploaded; $i++) {

                $_FILES = array();
                $_FILES[$name]['name'] = $files[$name]['name'][$i];
                $_FILES[$name]['type'] = $files[$name]['type'][$i];
                $_FILES[$name]['tmp_name'] = $files[$name]['tmp_name'][$i];
                $_FILES[$name]['error'] = $files[$name]['error'][$i];
                $_FILES[$name]['size'] = $files[$name]['size'][$i];

                if (!$ci->upload->do_upload($name)) {
                    $temp = array('errorf' => TRUE, 'error' => $ci->upload->display_errors());
                    break;
                } else {
                    $temp[] = $data = $ci->upload->data();
                }
            }

            $_FILES = $files;
            if (isset($temp['errorf'])) {
                return $temp;
            } else {
                return array('errorf' => FALSE, 'data' => $temp);
            }
        }
    }
}

/**
 * Send mobile notification
 */
if (!function_exists('sendMobileNotification')) {

    function sendMobileNotification($tokenIds, $message = '', $title = '', $image = '')
    {

        /*$fields = array(
            'registration_ids' => $tokenIds,
            'data' => array('message' => $message)
        );*/
        $fields = array(
            'registration_ids' => $tokenIds,
            'priority' => 10,
            'notification' => array('title' => $title, 'body' =>  $message, 'image' => $image),
            'data' => array('title' => $title, 'body' =>  $message, 'image' => $image),
        );

        // $newF = json_encode($fields);

        // 'apns' => array('headers' => array('apns-expiration' => '10')),
        // 'android' => array("ttl" => "100s"),
        // 'webpush' => array('headers' => array('TTL' => '10'))

        $headers = array(
            'Authorization:key = ' . MOBILE_NOTIFICATION_KEY,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, MOBILE_NOTIFICATION_URL);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($newF));
        $result = curl_exec($ch);
        //  print_r($result);die;
        return $result;
    }
}
/**
 * Send email
 */
if (!function_exists('sendMail1')) {

    function sendMail1($from = '', $from_name = '', $to = '', $subject = '', $body = '', $attchment_path = '')
    {
        echo $attchment_path;
        die;
        $ci = &get_instance();
        $ci->load->library('email');
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.lalitdangre.com',
            'smtp_port' => 587,
            'smtp_user' => EMAIL_ID,
            'smtp_pass' => EMAIL_PASSWORD,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE,

        );
        // echo json_encode($config);die;
        $ci->email->initialize($config);
        $ci->email->from($from, $from_name);
        $ci->email->to($to);
        $ci->email->subject($subject);
        $ci->email->message($body);
        if ($attchment_path) {
            $ci->email->attach($attchment_path);
        }
        //  $ci->email->send();
        echo  $ci->email->print_debugger();
        if ($ci->email->send()) {
            return true;
        } else {
            return false;
        }
    }
}


if (!function_exists('sendMail')) {
    function sendMail($from, $from_name, $to, $subject, $body, $attachments = '')
    {
        require_once FCPATH . 'vendor/autoload.php'; // Ensure correct path to autoload.php


        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.office365.com'; // or 'ssl://smtp.hostinger.com'
            $mail->SMTPAuth   = true;
            $mail->Username   = 'noreply@windhans.com';      // set in config/constants.php
            $mail->Password   = 'Hitler@2025'; // set in config/constants.php
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587; // or 465 for SSL

            // Recipients
            $mail->setFrom('noreply@windhans.com', $from_name);
            $mail->addAddress($to);

            // Add attachments if any
            if (!empty($attachments)) {
                if (is_array($attachments)) {
                    foreach ($attachments as $file) {
                        if (file_exists($file)) {
                            echo $attchment_path;
                            die;
                            $mail->addAttachment($file);
                        }
                    }
                } elseif (file_exists($attachments)) {
                    $mail->addAttachment($attachments);
                }
            }


            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            log_message('error', 'Mailer Error: ' . $mail->ErrorInfo);
            return false;
        }
    }
}
if (!function_exists('sendMailTest')) {

    function sendMailTest($from = '', $from_name = '', $to = '', $subject = '', $body = '', $attchment_path = '')
    {

        $ci = &get_instance();
        //$ci->load->library('email');
        $config = array(
            'protocol'     => 'smtp',
            'smtp_host'    => 'smtp.office365.com',
            'smtp_user'    => 'info@lalitdangre.com',
            'smtp_pass'    => 'Foundation@2023',
            'smtp_port'    => 587,
            'smtp_crypto'  => 'ssl',
            'mailtype'     => 'html',
            'charset'      => 'utf-8',
            'wordwrap'     => TRUE,
            'newline'      => "\r\n",
            'smtp_debug' => 1
        );
        $ci->load->library('email', $config);

        $ci->email->from('info@lalitdangre.com', 'info');
        $ci->email->to('ashwinidhadge2709@gmail.com');
        $ci->email->subject('Your Subjectvv');
        $ci->email->message('Your Message');
        $ci->email->send();
        echo $ci->email->print_debugger();
        die;

        if ($ci->email->send()) {
            echo 'Email sent successfully.';
            echo $ci->email->print_debugger();
        } else {
            show_error($ci->email->print_debugger());
        }
        echo $ci->email->print_debugger();
        die;
    }
}
/**
 * Send mobile message
 */
if (!function_exists('sendMobileMessage')) {

    function
    sendMobileMessage($message = '', $mobileNumber = 0, $templateID = '')
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, MOBILE_SMS_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        // http://admin.bestsms.co.in/api/pushsms.php?user=104143&key=010Py14l308yor9XRV80&sender=LalitD&mobile=9527380090&text=2025 is the one time password (OTP) for Login. Thanks, Team Lalit Dangre&entityid=1501542750000010817&templateid=1507163947670092160
        // curl_setopt($ch, CURLOPT_POSTFIELDS, "user=".MOBILE_SMS_ACCOUNT_USER."&key=".MOBILE_SMS_KEY."&entityid=".ENRITYID."&mobile=".$mobileNumber."&sender=".MOBILE_SMS_SENDER."&entityid=".ENRITYID."&text=".$message."&templateid=".$templateID);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "authkey=" . MOBILE_SMS_AUTH . "&mobiles=" . $mobileNumber . "&sender=" . MOBILE_SMS_SENDER . "&route=4&country=91&DLT_TE_ID=" . $templateID . "&message=" . $message);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return curl_error($ch);
        }

        curl_close($ch);
        return $response;
    }
}

/**
 * Create random string with character and number
 */
if (!function_exists('createCharNumRandom')) {

    function createCharNumRandom()
    {
        $chars = "ABCDEFGHJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
        $i = 0;
        $pass = '';

        while ($i <= 8) {
            $num = mt_rand(0, 61);
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return $pass;
    }
}

/**
 * Create random 6 digit number
 */
if (!function_exists('create6NumRandom')) {

    function create6NumRandom()
    {
        return mt_rand(100000, 999999);
    }
}

/**
 * Create random 6 digit number
 */
if (!function_exists('createUniqueNumber')) {

    function createUniqueNumber()
    {
        $ci = &get_instance();
        $unique = mt_rand(10000, 99999);
        $result = $ci->Welcome_model->getData('users', array('unique_number' => $unique));
        if (count($result)) {
            return createUniqueNumber();
        } else {
            return "NC-" . $unique;
        }
    }
}

/**
 * Check : Mobile number already exists or not
 */
if (!function_exists('checkMobileIsExists')) {

    function checkMobileIsExists($Mobile = 0)
    {
        $ci = &get_instance();
        $result = $ci->Common_model->getData(DB_REGISTER, array('register_mobile' => $Mobile));
        if (count($result)) {
            return $result[0];
        } else {
            return 'false';
        }
    }
}

/**
 * Recent Activity
 */
if (!function_exists('activityLog')) {

    function activityLog($user_id = '', $desc = '', $type = '', $id = '', $activity_details = '')
    {
        $CI = &get_instance();
        $data = array(
            'user_id' => $user_id,
            'message' => $desc,
            'type' => $type,
            'activity_id' => $id,
            'activity_details'      => $activity_details
        );
        $CI->db->insert('tbl_recent_activities', $data);
    }
}


/**
 * Update API Token
 */
if (!function_exists('updateApiToken')) {

    function updateApiToken($apiToken = '', $reg_id = 0)
    {
        $CI = &get_instance();
        $CI->load->model('app/Authentication_model');

        $token = array('api_token' => $apiToken);

        $updateApiToken = $CI->Authentication_model->updateToken($token, $reg_id);

        if ($updateApiToken) {
            $response['reg_id'] = $updateApiToken;
            $response['result'] = true;
            $response['reason'] = 'Token updated successfully..!';
        } else {
            $response['result'] = false;
            $response['reason'] = SOMETHING_WRONG;
        }

        return $response;
    }
}

/**
 * Check API Token
 */
if (!function_exists('authenticateUser')) {
    function authenticateUser()
    {
        $CI = &get_instance();
        $CI->load->model('app/Authentication_model');
        // $CI->load->model('admin/Driver_model');

        $apiToken = $CI->input->post('api_token') ? $CI->input->post('api_token') : 0;
        $user_id = $CI->input->post('user_id') ? $CI->input->post('user_id') : 0;
        // $header = $CI->input->request_headers();
        // $token = explode(" ", $header['Authorization']);
        // echo json_encode($header);
        // echo json_encode($token['1']);
        // die;
        try {
            if ($apiToken) {
                $userDetail = JWTDecode($apiToken);
                // var_dump($apiToken);
                // var_dump($userDetail);
                $checkExist = $CI->Authentication_model->checkUserExist($userDetail->reg_email, $userDetail->reg_mobile, $userDetail->reg_type, '', false, $apiToken);
                // print_r($CI->db->last_query());die;

                // echo json_encode($checkExist);
                // die;
                // if ($checkExist['id'] !== $user_id) {
                //     $response['result'] = false;

                //     $response['message'] = 'Token Not recogrnized';
                //     echo json_encode($response);
                //     die;
                // }
                if (($checkExist)) {
                    $CI->regId = $userDetail->reg_id;
                    $CI->regType = $userDetail->reg_type;
                    $CI->regEmail = $userDetail->reg_email;
                    $CI->regMobile = $userDetail->reg_mobile;
                    return true;
                } else {
                    $response['result'] = false;
                    $response['isSessionExpired'] = true;
                    $response['message'] = 'Authentication failed. Please login again.';
                    echo json_encode($response);
                    die;
                }
            } else {
                $response['result'] = false;
                $response['isSessionExpired'] = true;
                $response['message'] = 'You are not authorised for this request. Please login again.';
                echo json_encode($response);
                die;
            }
        } catch (\Exception $e) {
            $response['result'] = false;
            $response['isSessionExpired'] = true;
            $response['message'] = "Token mismathed";
            echo json_encode($response);
            die;
        }
    }
}
/**
 * Check API Token
 */
if (!function_exists('authenticateUserWeb')) {
    function authenticateUserWeb()
    {
        $CI = &get_instance();
        $CI->load->model('app/Authentication_model');
        // $CI->load->model('admin/Driver_model');

        $apiToken = $CI->input->post('api_token') ? $CI->input->post('api_token') : 0;

        try {
            if ($apiToken) {
                $userDetail = JWTDecode($apiToken);
                // var_dump($apiToken);
                // print_r($userDetail);

                $checkExist = $CI->Authentication_model->checkWebUserExist($userDetail->userId, $userDetail->email, $userDetail->role, $userDetail->isFranchiseUser, $userDetail->franchiseId, '', TRUE, $apiToken);
                // echo $CI->db->last_query();die;
                // print_r($checkExist);die;
                // [userId] => 1
                // [email] => superadmin@gmail.com
                // [role] => PLATFORM_ADMIN
                // [isFranchiseUser] =>
                // [franchiseId] =>
                // [purpose] => php-api-integration
                // [iat] => 1743084294
                // [exp] => 1743689094
                if (($checkExist)) {
                    $CI->regId = $checkExist['id'];
                    $CI->regFranchiseId = $checkExist['franchise_id'];
                    $CI->regWebUserId = $checkExist['web_franchise_user_id'];
                    $CI->regRole = $checkExist['role'];
                    $CI->isFranchiseUser = $userDetail->isFranchiseUser;
                    return true;
                } else {

                    $response['result'] = false;
                    $response['isSessionExpired'] = true;
                    $response['reason'] = 'Authentication failed. Please login again.';
                    echo json_encode($response);
                    die;
                }
            } else {
                $response['result'] = false;
                $response['isSessionExpired'] = true;
                $response['reason'] = 'You are not authorised for this request. Please login again.';
                echo json_encode($response);
                die;
            }
        } catch (\Exception $e) {
            $response['result'] = false;
            $response['isSessionExpired'] = true;
            $response['reason'] = "Token mismathed";
            echo json_encode($response);
            die;
        }
    }
}