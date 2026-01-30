<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Authentication extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('app/Authentication_model');
        $this->load->model('app/Common_model');
    }

    /******************************************** User App Login, Register, Social ********************************************/
    /**
     * User App : Register
     */
    public function registerUser()
    {
        $registrationType = 3;
        $userFirstName = trim($this->input->post('full_name')) ? trim($this->input->post('full_name')) : '';
        // $userLastName = trim($this->input->post('last_name')) ? trim($this->input->post('last_name')) : '';
        $userMobile = trim($this->input->post('mobile')) ? trim($this->input->post('mobile')) : '';
        $userEmail = trim($this->input->post('email')) ? trim($this->input->post('email')) : 0;
        $password = trim($this->input->post('password')) ? trim($this->input->post('password')) : 0;
        $confirm_password = trim($this->input->post('confirm_password')) ? trim($this->input->post('confirm_password')) : 0;
        $userNotificationToken = trim($this->input->post('notification_token')) ? trim($this->input->post('notification_token')) : '';
        $device_details = $this->input->post('device_details') ? $this->input->post('device_details') : "";
        $referral_code = $this->input->post('referral_code') ? $this->input->post('referral_code') : "";
        $gender = $this->input->post('gender') ? $this->input->post('gender') : "";
        $imei_no = $this->input->post('imei_no') ? $this->input->post('imei_no') : "";

        $response = $checkExist = array();

        // if (strlen($userLastName) && strlen($userEmail)  && $userMobile && is_numeric($userMobile) && strlen($userNotificationToken) && strlen($password) && ($password == $confirm_password)) {
        if (
            strlen($userFirstName) &&
            strlen($imei_no) &&
            // strlen($userLastName) &&
            strlen($userEmail) &&
            is_numeric($userMobile) &&
            strlen($userNotificationToken) &&
            strlen($password) &&
            ($password == $confirm_password)
        ) {



            // $is_referral_code = $this->Common_model->getData('tbl_users', array('status' => 1,'self_code'=>$referral_code),'','','num_rows');
            // if(! $is_referral_code){
            //     $response['result'] = false;
            //     $response['reason'] = "Referral code Invalid";
            //     echo json_encode($response);
            //     die;
            // }
            // if ($referral_code) {
            //     $is_referral_code = $this->Common_model->getData('tbl_users', array('status' => 1, 'self_code' => $referral_code), '', '', 'num_rows');
            //     if (! $is_referral_code) {
            //         $response['result'] = false;
            //         $response['reason'] = "Referral code Invalid";
            //         echo json_encode($response);
            //         die;
            //     }
            // }
            // $check_imei_no = $this->Common_model->getData('tbl_users', array('imei_no' => $imei_no), '', '', 'num_rows');
            // if ($check_imei_no) {
            //     $response['result'] = false;
            //     $response['reason'] = "Your Already Register with this IMEI Number";
            //     echo json_encode($response);
            //     die;
            // }

            $checkExist = array();
            $checkExist = $this->Authentication_model->checkUserExist($userEmail, $userMobile, '', '', '', '', $imei_no);
            // echo "<pre>";
            // print_r($checkExist);
            // die;
            if (empty($checkExist)) {


                // $otpNumber = create6NumRandom();
                $otpNumber = 1234;

                $selfReferral = "LMS" . $userMobile;
                $registerDetailArray = array(
                    'role' => $registrationType,
                    'first_name' => $userFirstName,
                    // 'last_name' => $userLastName,
                    'email' => $userEmail,
                    'mobile_no' => $userMobile,
                    'otp' => $otpNumber,
                    'device_details' => $device_details,
                    // 'self_code' => $selfReferral,
                    'referral_code' => $referral_code,
                    'password' => $password,
                    'notification_token' => $userNotificationToken,
                    // 'commsion_percentage' => COMMISION_PERCENTAGE,
                    'imei_no' => $imei_no,
                    'user_type' =>  1  // 1 for Online from mobile side

                );

                $registerId = $this->Common_model->iudAction('tbl_users', $registerDetailArray, 'insert');
                if ($registerId) {
                    $postArray = array(
                        'gender' => $gender,
                        'user_id' => $registerId
                    );
                    $registerId = $this->Common_model->iudAction('user_profile', $postArray, 'insert');
                    $response['result'] = true;
                    $response['message'] = 'Thank you for registering, Please verify your number';

                    $verificationMessage = $otpNumber . " is the one time password (OTP) for Login. Thanks, Team Lalit Dangre";
                    // sendMobileMessage($verificationMessage, $userMobile, '1507163947670092160');
                    // $name=$userFirstName." ".$userLastName;
                    //    $verificationMessage = "Dear ".$name.", Welcome to Lalit Dangre app. Your Username:".$userMobile." and Password:".$password." Thanks. Team Lalit Dangre";
                    //    sendMobileMessage($verificationMessage, $userMobile,'1507163947710162091');

                } else {
                    $response['result'] = false;
                    $response['reason'] = SOMETHING_WRONG;
                }
            } else {
                $response['result'] = false;
                $response['reason'] = 'User with same email, phone or imei_no already exist. Please try again';
            }
        } else {
            $response['result'] = false;
            $response['reason'] = INVALID_INPUT;
        }
        echo json_encode($response);
    }

    /**
     * User App : Send OTP
     */
    public function sendLoginOTP()
    {
        $userMobile = trim($this->input->post('mobile')) ? trim($this->input->post('mobile')) : 0;
        $response = array();
        $registrationType = 3;
        if ($userMobile && is_numeric($userMobile)) {
            $checkExist = $this->Authentication_model->checkUserExist('', $userMobile, $registrationType);

            if (!empty($checkExist) && count($checkExist) && $checkExist > 0) {
                if ($checkExist['status'] != 1) {
                    $response['result'] = false;
                    $response['is_register'] = false;
                    $response['message'] = 'User Not Active';
                    echo json_encode($response);
                    die();
                }
                $otpNumber = '1234'; //create6NumRandom();
                $otpNumber = create6NumRandom();
                $verificationMessage = $otpNumber . " is the one time password (OTP) for Login. Thanks, Team Lalit Dangre";
                // sendMobileMessage($verificationMessage, $userMobile, '1507163947670092160');


                $updateArray = array('otp' => $otpNumber, 'is_otp_verified' => 0);
                $this->Common_model->iudAction('tbl_users', $updateArray, 'update', array('id' => $checkExist['id']));

                $response['result'] = true;
                $response['is_register'] = true;
                $response['message'] = "We have sent you an OTP verification code. Please check";
            } else {
                $response['result'] = false;
                $response['is_register'] = false;
                $response['message'] = 'User not found the the entered mobile number';
            }
        } else {
            $response['result'] = false;
            $response['message'] = INVALID_INPUT;
        }
        echo json_encode($response);
    }

    /**
     * User App : Verify OTP
     */
    public function userOTPVerification()
    {
        $userMobile = trim($this->input->post('mobile')) ? trim($this->input->post('mobile')) : 0;
        $otpNumber = trim($this->input->post('otp_number')) ? trim($this->input->post('otp_number')) : 0;
        $notification_token = trim($this->input->post('notification_token')) ? trim($this->input->post('notification_token')) : 0;
        $imei_no = $this->input->post('imei_no') ? $this->input->post('imei_no') : "";
        $response = $userDetail = array();

        // if ($userMobile && is_numeric($userMobile) && $otpNumber && $notification_token) {
        if ($userMobile && is_numeric($userMobile) && $otpNumber && is_numeric($otpNumber)) {
            $userDetail = $this->Authentication_model->matchOTP($otpNumber, $userMobile);
            // echo json_encode($userDetail);
            // die;
            // echo $this->db->last_query();die;
            if (!empty($userDetail)) {
                $data = array(
                    'reg_type' => $userDetail['role'],
                    'reg_id' => $userDetail['id'],
                    'reg_email' => $userDetail['email'],
                    'reg_mobile' => $userDetail['mobile_no'],
                    'reg_name' => $userDetail['first_name'] . " " . ucwords($userDetail['last_name']),
                    'key' => create6NumRandom()
                );
                $userDetail['api_token'] = JWTEncode($data);

                updateApiToken($userDetail['api_token'], $userDetail['id']);

                $updArr = array('is_otp_verified' => 1, 'status' => 1, 'api_token' => $userDetail['api_token']);

                if ($imei_no) {
                    $updArr['imei_no'] = $imei_no;
                }
                if ($notification_token) {
                    $updArr['notification_token'] = $notification_token;
                }

                $this->Common_model->iudAction('tbl_users', $updArr, 'update', array('id' => $userDetail['id']));

                $userData = $this->Common_model->getUserData(array('u.id' => $userDetail['id']));

                //send sms
                $name = $userData[0]['first_name'] . " " . $userData[0]['last_name'];
                $verificationMessage = "Dear " . $name . ", Welcome to Lalit Dangre app. Your Username:" . $userData[0]['mobile_no'] . " and Password:" . $userData[0]['password'] . " Thanks. Team Lalit Dangre";
                // sendMobileMessage($verificationMessage, $userMobile, '1507163947710162091');

                // if ($userData[0]['referral_code']) {
                //     $trans = $this->Common_model->getData('tbl_users', array('self_code' => $userData[0]['referral_code']), '', '', 'row_array');
                //     $walletData = array(
                //         'user_id' => $trans['id'],
                //         'action' => 1,
                //         'amount' => ON_REGISTER_AMOUNT,
                //         'trans_details' => "Reference Registration amount",
                //         'wallet_type' => 1,
                //         'created_by' => $trans['id'],
                //         'updated_at' => date('Y-m-d h:i:s')
                //     );
                //     $this->Common_model->iudAction('wallet_transaction', $walletData, 'insert');
                //     updateQuickWallentAMount($trans['id'], 1, ON_REGISTER_AMOUNT);
                // }


                //add free courese to users
                // $free_courses_code = $this->Common_model->getData('tbl_courses', array('status' => 1, 'is_free' => 1));
                // if (count($free_courses_code)) {

                //     foreach ($free_courses_code as $key => $course) {
                //         $durations = $this->Common_model->getData('tbl_courses_duration', array('courses_id' => $course['id'], 'status' => 1));
                //         foreach ($durations as $key1 => $dur) {

                //             $subscribe_free = $this->CommonModel->getData('tbl_order_courses_subscription', array('user_id' => $userData[0]['id'], 'course_id' => $course['id'], 'courses_duration_id' => $dur['id']), '', '', 'num_rows');
                //             if (!$subscribe_free) {
                //                 $orderNo = ORDER_NUMBER_PREFIX . "" . $userData[0]['id'] . "" . strtotime(date('Y-m-d H:i:s'));
                //                 $insOrder = array(
                //                     'order_no' => $orderNo,
                //                     'user_id' => $userData[0]['id'],
                //                     'date' => date('Y-m-d'),
                //                     'order_status' => ORDER_NEW,
                //                     'payment_status' => 1,
                //                     'payment_type' => 3,
                //                     'amount' => 0,
                //                     'delivery_charges' => 0,
                //                     'discount_amount' => 0,
                //                     'gst_amount' => 0,
                //                     'total_amount' => 0,
                //                     'extra_note' => 0,
                //                     'created_by' => $userData[0]['id']
                //                 );

                //                 $orderID = $this->CommonModel->iudAction('tbl_orders', $insOrder, 'insert');
                //                 $insCart = array(
                //                     'user_id' => $userData[0]['id'],
                //                     'courses_id' => $course['id'],
                //                     'lesson_id' => 0,
                //                     'courses_duration_id' => $dur['id'],
                //                     'type' => 1,
                //                     'rate' => 0,
                //                     'order_id' => $orderID,
                //                     'is_free' => 1
                //                 );

                //                 $cartStatus = $this->CommonModel->iudAction('tbl_order_details', $insCart, 'insert');

                //                 if ($userData[0]['first_name'] != NULL && $orderID) {
                //                     $name = $userData[0]['first_name'] . " " . $userData[0]['last_name'];
                //                     $course_name = $this->CommonModel->getData('tbl_courses', array('id' => $course['id']));
                //                     $cname = strlen($course_name[0]['title']);
                //                     if ($cname > 22) {
                //                         $course_name1 = substr($course_name[0]['title'], 0, 15) . "..(Free)";
                //                     } else {
                //                         $course_name1 = $course_name[0]['title'] . "..(Free)";
                //                     }
                //                     $verificationMessage = " Dear " . $name . ", Your Course " . $course_name1 . " have been Purchased Successfully. Thanks Team Lalit Dangre";
                //                     sendMobileMessage($verificationMessage, $userData[0]['mobile_no'], '1507163947849507459');

                //                     //course subscribtion

                //                     $duratoion_no_of_days = $this->CommonModel->getData('tbl_duration_master', array('id' =>  $dur['duration_id']), 'no_of_days', '', 'row_array');
                //                     $order_date = date('Y-m-d');
                //                     $endDate = date('Y-m-d', strtotime($order_date . " +" . $duratoion_no_of_days['no_of_days'] . " days"));
                //                     $order_subscrb = array(
                //                         'order_id' => $orderID,
                //                         'order_no' => $orderNo,
                //                         'user_id' =>  $userData[0]['id'],
                //                         'type' => 1,
                //                         'courses_duration_id' => $dur['id'],
                //                         'course_id' =>  $course['id'],
                //                         'start_date' => date('Y-m-d'),
                //                         'end_date' => $endDate,
                //                         'active' => 1,
                //                         'no_of_days' => $duratoion_no_of_days['no_of_days'],
                //                         'created_on' => date('Y-m-d H:i:s'),
                //                     );
                //                     $subcribtionStatus = $this->CommonModel->iudAction('tbl_order_courses_subscription', $order_subscrb, 'insert');
                //                 }
                //             }
                //         }
                //     }
                // }

                unset($userData[0]['last_name']);
                $response['result'] = true;
                $response['user_profile_path'] = base_url() . USER_IMAGES;
                $response['user_detail'] = $userData;
                $response['message'] = "OTP verification successful, Welcome to " . APP_NAME;
            } else {
                $response['result'] = false;
                $response['message'] = 'OTP does not matched. Please try again';
            }
        } else {
            $response['result'] = false;
            $response['message'] = INVALID_INPUT;
        }
        echo json_encode($response);
    }

    /**
     * User Login : Login
     */

    //Hemant 14-Apr for launching of app and separate access to test app for Google Play store
    public function userLogin()
    {
        $response = array();
        $userEmail = $this->input->post('email') ? $this->input->post('email') : "";
        $userMobile = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
        $password = $this->input->post('password') ? $this->input->post('password') : "";
        $notification_token = $this->input->post('notification_token') ? $this->input->post('notification_token') : "";
        $device_details = $this->input->post('device_details') ? $this->input->post('device_details') : "";
        $imei_no = $this->input->post('imei_no') ? $this->input->post('imei_no') : "";

        if ($userEmail) {
            $isUserExist = $this->Authentication_model->checkUserExist($userEmail, '');
            // echo json_encode($isUserExist);
            // die;
            if ($isUserExist) {

                if ($isUserExist['password'] == $password) {
                    if ($isUserExist['is_otp_verified'] == 1) {

                        if ($isUserExist['status'] != 1) {
                            $response['message'] = "User Not active";
                            $response['result'] = false;
                            echo json_encode($response);
                            die;
                        }
                        if ($isUserExist['imei_no'] != $imei_no) {
                            //print_r($isUserExist['imei_no']);
                            //  print_r($imei_no);
                            $response['reason'] = "imei number did not match with Login";
                            $response['result'] = false;
                            echo json_encode($response);
                            die;
                        }
                        $data = array(
                            'reg_type' => $isUserExist['role'],
                            'user_type' => $isUserExist['user_type'],
                            'reg_id' => $isUserExist['id'],
                            'reg_email' => $isUserExist['email'],
                            'reg_mobile' => $isUserExist['mobile_no'],
                            'reg_name' => $isUserExist['first_name'] . " " . ucwords($isUserExist['last_name']),
                            'key' => create6NumRandom()
                        );
                        $api_token = JWTEncode($data);

                        updateApiToken($api_token, $isUserExist['id']);

                        $update_user = array('api_token' => $api_token, 'last_login' => date('Y-m-d H:i:s'));
                        if (!empty($notification_token) && !empty($device_details)) {
                            $update_user['notification_token'] =  $notification_token;
                            $update_user['device_details'] = $device_details;
                        }

                        $this->Common_model->iudAction('tbl_users', $update_user, 'update', array('id' => $isUserExist['id']));
                        $userData = $this->Common_model->getUserData(array('u.id' => $isUserExist['id']));

                        unset($userData[0]['last_name']);
                        $response['user_profile_path'] = base_url() . USER_IMAGES;
                        $response['user_data'] = $userData;
                        $response['result'] = true;
                        $response['mobile_verified'] = true;
                        $response['message'] = "Login Success";
                    } else {
                        $response['result'] = true;
                        $response['mobile_verified'] = false;
                        $response['message'] = "Verify Mobile No With OTP";
                        // $response['reason'] = "OTP sent to registerd mobile number, please verify";
                    }
                } else {
                    $response['result'] = false;
                    if ($isUserExist['is_otp_verified'] == 1) {
                        $response['mobile_verified'] = true;
                    } else {
                        $response['mobile_verified'] = false;
                    }

                    $response['message'] = "Password does not match";
                }
            } else {
                $response['result'] = false;
                $response['message'] = 'USER_NOT_FOUND';
            }
        } else if ($userEmail != "" && $password != "") {

            $isUserExist = $this->Authentication_model->checkUserExist($userEmail, '');

            //echo $this->db->last_query();die;
            if ($isUserExist) {

                if ($isUserExist['password'] == $password) {
                    // if($isUserExist['is_otp_verified'] == 1){

                    if ($isUserExist['status'] != 1) {
                        $response['message'] = "User Not active";
                        $response['result'] = false;
                        echo json_encode($response);
                        die;
                    }
                    if ($isUserExist['imei_no'] != $imei_no) {
                        //print_r($isUserExist['imei_no']);
                        //  print_r($imei_no);
                        $response['reason'] = "imei number did not match with Login";
                        $response['result'] = false;
                        echo json_encode($response);
                        die;
                    }
                    $data = array(
                        'reg_type' => $isUserExist['role'],
                        'user_type' => $isUserExist['user_type'],
                        'reg_id' => $isUserExist['id'],
                        'reg_email' => $isUserExist['email'],
                        'reg_mobile' => $isUserExist['mobile_no'],
                        'reg_name' => $isUserExist['first_name'] . " " . ucwords($isUserExist['last_name']),
                        'key' => create6NumRandom()
                    );
                    $api_token = JWTEncode($data);

                    updateApiToken($api_token, $isUserExist['id']);

                    $update_user = array('api_token' => $api_token, 'last_login' => date('Y-m-d H:i:s'));
                    if (!empty($notification_token) && !empty($device_details)) {
                        $update_user['notification_token'] =  $notification_token;
                        $update_user['device_details'] = $device_details;
                    }
                    $this->Common_model->iudAction('tbl_users', $update_user, 'update', array('id' => $isUserExist['id']));
                    //print_r($this->db->last_query());die();
                    $userData = $this->Common_model->getUserData(array('u.id' => $isUserExist['id']));


                    $response['user_profile_path'] = base_url() . USER_IMAGES;
                    $response['user_data'] = $userData;
                    $response['result'] = true;
                    $response['mobile_verified'] = true;
                    $response['message'] = "Login Success";


                    // }else{

                    // 	$response['result'] = true;
                    // 	$response['mobile_verified'] = false;
                    // 	$response['reason'] = "OTP sent to registerd mobile number, please verify";
                    // }
                } else {
                    $response['result'] = false;
                    if ($isUserExist['is_otp_verified'] == 1) {
                        $response['mobile_verified'] = true;
                    } else {
                        $response['mobile_verified'] = false;
                    }

                    $response['message'] = "Password does not match";
                }
            } else {
                $response['result'] = false;
                $response['message'] = 'USER_NOT_FOUND';
            }
        } else {
            $response['result'] = false;
            $response['message'] = INVALID_INPUT;
        }

        echo json_encode($response);
    }

    // user login
    public function userLogin2()
    {
        $response = array();
        $userMobile = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
        $password = $this->input->post('password') ? $this->input->post('password') : "";
        $notification_token = $this->input->post('notification_token') ? $this->input->post('notification_token') : "";
        $device_details = $this->input->post('device_details') ? $this->input->post('device_details') : "";
        $imei_no = $this->input->post('imei_no') ? $this->input->post('imei_no') : "";

        if ($userMobile != "" && $password != "" && $imei_no != "") {
            $isUserExist = $this->Authentication_model->checkUserExist('', $userMobile);

            if ($isUserExist) {

                if ($isUserExist['password'] == $password) {
                    if ($isUserExist['is_otp_verified'] == 1) {

                        if ($isUserExist['status'] != 1) {
                            $response['reason'] = "User Not active";
                            $response['result'] = false;
                            echo json_encode($response);
                            die;
                        }
                        if ($isUserExist['imei_no'] != $imei_no) {
                            $response['reason'] = "imei number did not match with Login";
                            $response['result'] = false;
                            echo json_encode($response);
                            die;
                        }
                        $data = array(
                            'reg_type' => $isUserExist['role'],
                            'reg_id' => $isUserExist['id'],
                            'reg_email' => $isUserExist['email'],
                            'reg_mobile' => $isUserExist['mobile_no'],
                            'reg_name' => $isUserExist['first_name'] . " " . ucwords($isUserExist['last_name']),
                            'key' => create6NumRandom()
                        );
                        $api_token = JWTEncode($data);

                        updateApiToken($api_token, $isUserExist['id']);

                        $update_user = array('notification_token' => $notification_token, 'api_token' => $api_token, 'device_details' => $device_details, 'last_login' => date('Y-m-d H:i:s'));

                        $this->Common_model->iudAction('tbl_users', $update_user, 'update', array('id' => $isUserExist['id']));
                        //print_r($this->db->last_query());die();
                        $userData = $this->Common_model->getUserData(array('u.id' => $isUserExist['id']));

                        $response['user_profile_path'] = base_url() . USER_IMAGES;
                        $response['user_data'] = $userData;
                        $response['result'] = true;
                        $response['mobile_verified'] = true;
                        $response['reason'] = "Login Success";
                    } else {

                        $response['result'] = true;
                        $response['mobile_verified'] = false;
                        $response['reason'] = "OTP sent to registerd mobile number, please verify";
                    }
                } else {
                    $response['result'] = false;
                    if ($isUserExist['is_otp_verified'] == 1) {
                        $response['mobile_verified'] = true;
                    } else {
                        $response['mobile_verified'] = false;
                    }

                    $response['reason'] = "Password does not match";
                }
            } else {
                $response['result'] = false;
                $response['reason'] = 'USER_NOT_FOUND';
            }
        } else {
            $response['result'] = false;
            $response['reason'] = INVALID_INPUT;
        }

        echo json_encode($response);
    }
    /**
     * 
     */
    public function forgotPassword()
    {
        $response = array();
        $userMobile = $this->input->post('mobile_no') ? $this->input->post('mobile_no') : "";
        $newPassword = $this->input->post('password') ? $this->input->post('password') : "";
        $confirmPassword = $this->input->post('confirm_password') ? $this->input->post('confirm_password') : "";

        if (
            !empty($userMobile) &&
            is_numeric($userMobile) &&
            !empty($newPassword) &&
            !empty($confirmPassword) &&
            $newPassword === $confirmPassword
        ) {
            $isUserExist = $this->Authentication_model->checkUserExist('', $userMobile);

            if ($isUserExist) {
                if ($isUserExist['status'] != 1) {
                    $response['reason'] = "User Not active";
                    $response['result'] = false;
                    echo json_encode($response);
                    die;
                }
                //  $password=rand(1000,9999);
                // $newPassword = '123456';
                // $newPassword = create6NumRandom();

                $name = $isUserExist['first_name'] . " " . $isUserExist['last_name'];
                $verificationMessage = "Hi " . $name . ", Your Password is RESET to " . $newPassword . ". Best Regards, Team Lalit Dangre";
                // sendMobileMessage($verificationMessage, $isUserExist['mobile_no'], '1507163947739707290');
                $this->Common_model->iudAction('tbl_users', array('password' => $newPassword), 'update', array('id' => $isUserExist['id']));

                $response['result'] = true;
                $response['reason'] = "Your Password Succesfully Update";
            } else {
                $response['result'] = false;
                $response['reason'] = USER_NOT_FOUND;
            }
        } else {
            $response['result'] = false;
            $response['reason'] = INVALID_INPUT;
        }

        echo json_encode($response);
    }
    /**
     * Update Profile : User App
     */
    public function updateProfile()
    {

        authenticateUser();

        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : 0;
        $first_name = trim($this->input->post('full_name')) ? trim($this->input->post('full_name')) : '';
        // $last_name = trim($this->input->post('last_name')) ? trim($this->input->post('last_name')) : '';
        $email = trim($this->input->post('email')) ? trim($this->input->post('email')) : '';
        // $gender = trim($this->input->post('gender')) ? trim($this->input->post('gender')) : '';
        // $birthdate = trim($this->input->post('birthdate')) ? trim($this->input->post('birthdate')) : '';

        $response = array();
        if ($user_id && strlen($first_name)) {

            $userDetail = $this->Common_model->getAllData('tbl_users', array('id' => $user_id, 'is_otp_verified' => 1, 'status' => 1));
            // print_r($this->db->last_query());die;
            if ($userDetail) {

                $userUpdatedArray = array(
                    'first_name' => $first_name,
                    // 'last_name' => $last_name,
                    'email' => $email
                );

                $res = $this->Common_model->iudAction('tbl_users', $userUpdatedArray, 'update', array('id' => $user_id));
                $userUpdatedArray1 = array(
                    // 'gender' => $gender,
                    // 'birthdate' => $birthdate,
                    'updated_by' => $user_id,
                    'updated_on' => date('Y-m-d H:i:s')
                );
                $res1 = $this->Common_model->iudAction('user_profile', $userUpdatedArray1, 'update', array('user_id' => $user_id));
                //  print_r($this->db->last_query());die;
                if ($res || $res1) {
                    $userData = $this->Common_model->getUserData(array('u.id' => $user_id));
                    unset($userData[0]['last_name']);
                    $response['user_profile_path'] = base_url() . USER_PROFILE;
                    $response['user_data'] = $userData;
                    $response['result'] = true;
                    $response['message'] = 'Profile updated successfully';
                } else {
                    $response['result'] = false;
                    $response['message'] = 'Something went wrong, please try later';
                }
            } else {
                $response['result'] = false;
                $response['message'] = 'User not found/active';
            }
        } else {
            $response['result'] = false;
            $response['message'] = "INVALID_INPUT";
        }
        echo json_encode($response);
    }

    public function updateProfilePic()
    {
        authenticateUser();

        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : 0;
        $response = array();

        if ($user_id) {
            if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {

                if (!empty($_FILES['image']['name'])) {
                    $uploadStatus = fileUpload(USER_IMAGES, "image", FALSE);
                    if ($uploadStatus['status'] == true) {
                        $postdata['image'] = $uploadStatus['image_name'];
                    } else {
                        unset($postdata['image']);
                    }
                }


                $res = $this->Common_model->iudAction('tbl_users', $postdata, 'update', array('id' => $user_id));
                if ($res) {
                    $response['user_profile_path'] = base_url() . USER_IMAGES;
                    $response['image'] = $postdata['image'];
                    $response['result'] = true;
                    $response['message'] = 'Profile image uploaded successfully';
                } else {
                    $response['result'] = false;
                    $response['message'] = 'Something went wrong, please try later';
                }
            } else {
                $response['result'] = false;
                $response['message'] = "INVALID_INPUT";
            }
        } else {
            $response['result'] = false;
            $response['message'] = "INVALID_INPUT";
        }
        echo json_encode($response);
    }
    public function getDashboard()
    {
        $response = array();

        $user_id   = $this->input->post('user_id') ? $this->input->post('user_id') : 0;
        $api_token = $this->input->post('api_token') ? $this->input->post('api_token') : 0;
        // print_r($this->input->post());die;
        if ($user_id != ""  &&  $api_token != "") {
            $isUserExist = $this->Common_model->getData('tbl_users', array('status' => ACTIVE, 'id' => $user_id));
            // echo $this->db->last_query();
            if ($isUserExist) {
                /*
                        $isCoursesExist = $this->Common_model->getAllData('tbl_courses', array('status' => 1),5);
                        
                        if($isCoursesExist){
                             $response['courses_lists'] =$isCoursesExist;
                        }else{
                             $response['courses_lists'] =array();
                        }
                        
                        $isInstructor = $this->Common_model->getAllData('tbl_users', array('role' => 4),5);
                        
                        if($isInstructor){
                             $response['instructor_lists'] =$isInstructor;
                        }else{
                             $response['instructor_lists'] =array();
                        }
                  */

                // $ = $this->Common_model->getData('tbl_users', array('id' => $isUserExist[0]['franchise_id']),'','','row_array');
                if (isset($isUserExist[0]['franchise_id'])) {
                    $franchise_details = $this->Common_model->getData('tbl_users', array('id' => $isUserExist[0]['franchise_id']), '', '', 'row_array');
                    if ($franchise_details['first_name']) {
                        $response['franchise_name'] = $franchise_details['first_name'] . " " . $franchise_details['last_name'];
                    } else {
                        $response['franchise_name'] = '';
                    }
                } else {
                    $response['franchise_name'] = $isUserExist;
                }


                $payement_array = $this->Common_model->getData('tbl_payments_setting', array('is_active' => 1), '', '', 'row_array');

                if ($payement_array) {
                    $response['payment_gate_way_id'] = $payement_array['id'];
                    $response['payment_gate_way_name'] = $payement_array['payment_gate_name'];
                } else {
                    $response['payment_gate_way_id'] = '';
                    $response['payment_gate_way_name'] = '';
                }

                $about_us = $this->Common_model->getData('tbl_about_us', array('type' => 1), '', '', 'row_array');

                if ($about_us) {
                    $response['about_us_title'] = $about_us['titile'];
                    $response['about_us_description'] = $about_us['description'];
                } else {
                    $response['about_us_title'] = '';
                    $response['about_us_description'] = '';
                }

                $referal_description = $this->Common_model->getData('tbl_about_us', array('type' => 2), '', '', 'row_array');

                if ($referal_description) {
                    $response['referal_title'] = $referal_description['titile'];
                    $response['referal_description'] = $referal_description['description'];
                } else {
                    $response['referal_title'] = '';
                    $response['referal_description'] = '';
                }

                $refund_policy = $this->Common_model->getData('tbl_about_us', array('type' => 3), '', '', 'row_array');

                if ($refund_policy) {
                    $response['refund_title'] = $refund_policy['titile'];
                    $response['refund_description'] = $refund_policy['description'];
                } else {
                    $response['refund_title'] = '';
                    $response['refund_description'] = '';
                }

                $terms = $this->Common_model->getData('tbl_about_us', array('type' => 4), '', '', 'row_array');

                if ($terms) {
                    $response['terms_title'] = $terms['titile'];
                    $response['terms_description'] = $terms['description'];
                } else {
                    $response['terms_title'] = '';
                    $response['terms_description'] = '';
                }



                $response['result'] = true;
                // $response['referal_instructions'] = REFEREAL_MESSAGE . $isUserExist[0]['commsion_percentage'] . " % " . REFEREAL_MESSAGE1;
                $response['user_profile_path'] = base_url() . USER_IMAGES;
                $response['reason'] = "data found";
            } else {
                $response['result'] = false;
                $response['reason'] = "User not found Or Not active";
            }
        } else {
            $response['result'] = false;
            $response['reason'] = "INVALID_INPUT";
        }
        echo json_encode($response);
    }

    public function changedPassword()
    {
        authenticateUser();

        $response = array();
        $old_password = $this->input->post('old_password') ? $this->input->post('old_password') : "";
        $user_id = $this->input->post('user_id') ? $this->input->post('user_id') : "";
        $new_password = $this->input->post('new_password') ? $this->input->post('new_password') : "";

        if ($user_id != "" && $old_password && $new_password) {

            $is_password = $this->Common_model->getData('tbl_users', array('id' => $user_id), '', '', 'row_array');
            if ($is_password['password'] != $old_password) {
                $response['result'] = false;
                $response['reason'] = "Old Password Not Match.";
                echo json_encode($response);
                die;
            } else {
                $this->Common_model->iudAction('tbl_users', array('password' => $new_password), 'update', array('id' => $user_id));
                $response['result'] = true;
                $response['reason'] = "Your password has Changed";
            }
        } else {
            $response['result'] = false;
            $response['reason'] = INVALID_INPUT;
        }

        echo json_encode($response);
    }
}
