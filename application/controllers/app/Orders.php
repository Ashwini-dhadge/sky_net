<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Razorpay\Api\Api;

class Orders extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('app/Courses_model');
        $this->load->model('app/Common_model');
    }

    //not used
    public function cartOperations()
    {
        authenticateUser();
        $response = array();
        $user_id = $this->input->post('user_id') ? $this->input->post('user_id') : '';
        $courses_id = $this->input->post('courses_id') ? $this->input->post('courses_id') : '';
        $lesson_id = $this->input->post('lesson_id') ? $this->input->post('lesson_id') : '';
        $courses_duration_id     = $this->input->post('courses_duration_id') ? $this->input->post('courses_duration_id') : '';
        //	$qty 	= $this->input->post('qty') ? $this->input->post('qty') : '';
        $rate     = $this->input->post('rate') ? $this->input->post('rate') : '';
        $action     = $this->input->post('action') ? $this->input->post('action') : ''; //1:add, 2:update, 3: delete
        $type     = $this->input->post('type') ? $this->input->post('type') : ''; // 	1:course 2: lesson 3:package 	


        $totalAmt = 0;
        if ($user_id != "" && $action != "") {
            $userDetails = $this->Common_model->getData('tbl_users', array('id' => $user_id, 'status' => 1));
            if ($userDetails) {
                $status = false;
                $reason = '';
                if ($action == 1) {       //1:add
                    $cartDetails = $this->Common_model->getData('tbl_cart', array('user_id' => $user_id, 'courses_id' => $courses_id, 'lesson_id' => $lesson_id, 'courses_duration_id' => $courses_duration_id, 'type' => $type));
                    if (! $cartDetails) {
                        $insArr = array('user_id' => $user_id, 'courses_id' => $courses_id, 'lesson_id' => $lesson_id, 'courses_duration_id' => $courses_duration_id, 'type' => $type, 'rate' => $rate, 'value' => ($rate));
                        $res = $this->Common_model->iudAction('tbl_cart', $insArr, 'insert');
                        if ($res) {
                            $response['result'] = true;
                            $response['reason'] = 'Courses added to cart';
                        } else {
                            $response['result'] = false;
                            $response['reason'] = 'Something went wrong, please try later';
                        }
                    } else {
                        $response['result'] = false;
                        $response['reason'] = 'already add to cart';
                    }
                } else if ($action == 2) { //2:update
                    $cartDetails = $this->Common_model->getData('tbl_cart', array('user_id' => $user_id, 'courses_id' => $courses_id, 'lesson_id' => $lesson_id, 'courses_duration_id' => $courses_duration_id, 'type' => $type));
                    if ($cartDetails) {
                        $updArr = array('rate' => $rate, 'value' => ($rate));

                        $res = $this->Common_model->iudAction('tbl_cart', $updArr, 'update', array('id' => $cartDetails[0]['id']));

                        if ($res) {
                            $response['result'] = true;
                            $response['reason'] = 'Cart updated successfully';
                        } else {
                            $response['result'] = false;
                            $response['reason'] = 'Something went wrong, please try later';
                        }
                    } else {
                        $response['result'] = false;
                        $response['reason'] = 'Product not found in cart';
                        //  $reason = 'Product not found in cart';
                    }
                } else if ($action == 3) {     // 3: delete
                    $cartDetails = $this->Common_model->getData('tbl_cart', array('user_id' => $user_id, 'courses_id' => $courses_id, 'lesson_id' => $lesson_id, 'courses_duration_id' => $courses_duration_id, 'type' => $type));
                    if ($cartDetails) {
                        $whrArr = array('id' => $cartDetails[0]['id']);
                        $res = $this->Common_model->iudAction('tbl_cart', '', 'delete', $whrArr);
                        if ($res) {
                            $response['result'] = true;
                            $response['reason'] = 'Cart Deleted successfully';
                        } else {
                            $status = false;
                            $reason = 'Something went wrong, please try later';
                        }
                    } else {
                        $status = false;
                        $reason = 'Courses not found in cart';
                    }
                } else {      //Else Cart List

                    $totalAmount = 0;
                    $cartDetails = $this->Common_model->getData('tbl_cart', array('user_id' => $user_id));
                    /// print_r($cartDetails);
                    if ($cartDetails) {
                        $totalQty = $totalAmount = $totalSavings = 0;
                        foreach ($cartDetails as $key => $cart) {
                            if ($cart['type'] == 1 || $cart['type'] == 3) {
                                //1:course 2: lesson 3:package 
                                $courses = $this->Common_model->getData('tbl_courses', array('id' => $cart['courses_id']));
                                $cartDetails[$key]['title'] = $courses[0]['title'];
                                $cartDetails[$key]['image'] = $courses[0]['image'];
                                $durations = $this->Courses_model->getCoursesDurationData(array('cd.id' => $cart['courses_duration_id']));
                                // echo $this->db->last_query();
                                $totalQty = $totalQty + $cart['qty'];

                                $totalSavings = $totalSavings + (($cart['qty'] * $durations[0]['strike_thr_price']) - ($cart['qty'] * $durations[0]['price']));

                                $cartDetails[$key]['rate'] = $durations[0]['price'];

                                $cartDetails[$key]['value'] = $cart['qty'] * $durations[0]['price'];

                                $totalAmount = $totalAmount + ($cart['qty'] * $durations[0]['price']);
                                // echo $this->db->last_query();
                                //    print_r($durations);
                            } elseif ($cart['type'] == 2) {
                                $lesson = $this->Common_model->getData('tbl_lesson', array('id' => $cart['lesson_id']));
                                $cartDetails[$key]['title'] = $lesson[0]['title'];
                                $cartDetails[$key]['image'] = '';
                                $totalQty = $totalQty + $cart['qty'];
                                $totalSavings = $totalSavings + (($cart['qty'] * $lesson[0]['strike_thr_price']) - ($cart['qty'] * $lesson[0]['price']));
                                $cartDetails[$key]['rate'] = $lesson[0]['price'];
                                $cartDetails[$key]['value'] = $cart['qty'] * $lesson[0]['price'];
                                $totalAmount = $totalAmount + ($cart['qty'] * $lesson[0]['price']);
                            }
                        }

                        $response['course_path'] = base_url() . COURSE_IMAGES;

                        $response['total_qty'] = $totalQty;
                        $response['total_saving'] = $totalSavings;
                        $response['cart_amount'] = $totalAmount;
                        $response['cart_details'] = $cartDetails;
                        $response['result'] = true;
                        $response['reason'] = 'Products found in cart';
                        $cartCount = count($this->Common_model->getData('tbl_cart', array('user_id' => $user_id)));
                        $response['cart_count'] = $cartCount;
                    } else {
                        $response['result'] = true;
                        $response['reason'] = 'No product in cart';
                    }
                }
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

    //
    public function getCartData()
    {
        authenticateUser();
        $response = array();
        $user_id = $this->input->post('user_id') ? $this->input->post('user_id') : '';
        $courses_id = $this->input->post('courses_id') ? $this->input->post('courses_id') : '';
        $courses_duration_id     = $this->input->post('courses_duration_id') ? $this->input->post('courses_duration_id') : '';
        $type     = $this->input->post('type') ? $this->input->post('type') : ''; // 	1:course 2: lesson 3:package 
        $offer_id     = $this->input->post('offer_id') ? $this->input->post('offer_id') : '0';
        $is_wallet_amount_user    = $this->input->post('is_wallet_amount_user') ? $this->input->post('is_wallet_amount_user') : '0';

        $totalAmt = $sub_total = $total_amount2 = 0;
        if ($user_id != "" && $type && $courses_id) {
            $userDetails = $this->Common_model->getData('tbl_users', array('id' => $user_id, 'status' => 1));
            if ($userDetails) {
                $wallet_amount = getQuickWalletAmount($user_id);
                $response['result'] = true;
                $response['main_wallet_balance'] = $wallet_amount['remaining_balance'];
                $wallet_amount = $wallet_amount['remaining_balance'];
                //  print_r($wallet_amount);
                if ($type == 1) {

                    $course_amount = $this->CommonModel->getData('tbl_courses_duration', array('courses_id' => $courses_id, 'id' => $courses_duration_id), '', '', 'row_array');
                    if ($course_amount) {
                        $sub_total = $course_amount['price'];
                        $response['courses_price'] = $course_amount['price'];
                        $response['courses_offer_type'] = $course_amount['offer_type'];
                        $response['courses_saving_amount'] = $course_amount['strike_thr_price'] - $course_amount['price'];

                        $response['courses_strike_thr_price'] = $course_amount['strike_thr_price'];
                    } else {
                        $response['courses_price'] = 0;
                        $response['courses_offer_type'] = 0;
                        $response['courses_saving_amount'] = 0;
                        $response['courses_strike_thr_price'] = 0;
                    }
                } elseif ($type == 3) {
                    $course_amount = $this->CommonModel->getData('tbl_courses_duration', array('courses_id' => $courses_id, 'duration_id' => 0), '', '', 'row_array');
                    if ($course_amount) {
                        $sub_total = $course_amount['price'];
                        $response['courses_price'] = $course_amount['price'];
                        $response['courses_offer_type'] = $course_amount['offer_type'];
                        $response['courses_saving_amount'] = $course_amount['strike_thr_price'] - $course_amount['price'];
                        $response['courses_strike_thr_price'] = $course_amount['strike_thr_price'];
                    } else {

                        $response['courses_price'] = 0;
                        $response['courses_offer_type'] = 0;
                        $response['courses_saving_amount'] = 0;
                        $response['courses_strike_thr_price'] = 0;
                    }
                } else {
                    $response['result'] = false;
                    $response['reason'] = INVALID_INPUT;
                    echo json_encode($response);
                    die;
                }

                $offer_amount = 0;

                $response['sub_total'] = $response['courses_price'];
                if ($offer_id) {
                    $where = array('id' => $offer_id, 'from_date <=' => date('Y-m-d'), 'status' => 1, 'to_date >=' => date('Y-m-d'));

                    $offer_data = $this->CommonModel->getData('tbl_offers', $where, 'offer_type,offer,offer_title,offer_code,min_order_value', '', 'row_array');
                    if ($offer_data) {
                        // offer_type	1.percentage, 2.flat 
                        if ($offer_data['offer_type'] == 1) {
                            $offer_percent = $offer_data['offer'] / 100;
                            $offer_amount = $response['courses_price'] * $offer_percent;
                        } elseif ($offer_data['offer_type'] == 2) {
                            if ($response['courses_price'] >= $offer_data['offer']) {
                                $offer_amount = $offer_data['offer'];
                            } else {
                                $offer_amount = 0;
                            }
                        } else {
                        }
                        $response['offer_title'] = $offer_data['offer_title'];
                        $response['offer_code'] =  $offer_data['offer_code'];
                        $response['offer_min_order_value'] = $offer_data['min_order_value'];
                        $response['courses_saving_amount'] =  $response['courses_saving_amount'] + $offer_amount;
                    } else {
                        $response['result'] = false;
                        $response['reason'] = "Offer Expired";
                        echo json_encode($response);
                        die;
                    }
                }
                $response['offer_amount'] = $offer_amount;

                if ($offer_id) {
                    $total_amount1 = floatval($sub_total) - floatval($offer_amount);
                    $response['offer_amount'] = $offer_amount;
                } else {
                    $total_amount1 = floatval($sub_total);
                    $response['offer_amount'] = $offer_amount;
                    $response['offer_title'] = '';
                    $response['offer_code'] = '';
                    $response['offer_min_order_value'] = '';
                }

                if ($is_wallet_amount_user) {
                    //    print_r($total_amount1);die;
                    //33>20
                    if ($wallet_amount >= $total_amount1) {

                        //    $total_amount2=floatval($wallet_amount)-floatval($total_amount1);
                        $wallet_amount = $total_amount1;
                    } else {
                        $total_amount2 = floatval($total_amount1) - floatval($wallet_amount);
                        $wallet_amount = $wallet_amount;
                    }

                    $response['courses_saving_amount'] =  $response['courses_saving_amount'] + $wallet_amount;
                    $response['wallet_amount'] = $wallet_amount;
                } else {
                    $total_amount2 = floatval($total_amount1);
                    $response['wallet_amount'] = 0;
                }

                $response['total_amount'] = $total_amount2;
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
    //place order
    public function placeOrder()
    {

        $response = array();
        authenticateUser();
        // echo "<pre>";
        // print_r($_POST);
        // die;

        $login_user_id = $this->regId;
        // $api = new Api($this->key_id, $this->key_secret);
        // $user_id         = $this->input->post('user_id') ? $this->input->post('user_id') : '';
        $payment_status    = $this->input->post('payment_status') ? $this->input->post('payment_status') : 0; //0 = Pending, 1 = Paid
        $payment_type    = $this->input->post('payment_type') ? $this->input->post('payment_type') : 1;  //1 = cod, 2 = online
        $amount         = $this->input->post('amount') ? $this->input->post('amount') : 0;
        $delivery_charges    = $this->input->post('delivery_charges') ? $this->input->post('delivery_charges') : 0;
        $discount_amount     = $this->input->post('discount_amount') ? $this->input->post('discount_amount') : 0;
        $gst_amount     = $this->input->post('gst_amount') ? $this->input->post('gst_amount') : 0;
        $total_amount     = $this->input->post('total_amount') ? $this->input->post('total_amount') : '';
        $extra_note     = $this->input->post('extra_note') ? $this->input->post('extra_note') : '';

        $transaction_id    = $this->input->post('transaction_id') ? $this->input->post('transaction_id') : '';
        $payment_id     = $this->input->post('payment_id') ? $this->input->post('payment_id') : '';


        $courses_id = $this->input->post('courses_id') ? $this->input->post('courses_id') : '';
        // $lesson_id = $this->input->post('lesson_id') ? $this->input->post('lesson_id') : '';
        // $courses_duration_id     = $this->input->post('courses_duration_id') ? $this->input->post('courses_duration_id') : '';
        $qty     = $this->input->post('qty') ? $this->input->post('qty') : '1';
        $rate     = $this->input->post('rate') ? $this->input->post('rate') : '';
        // $type     = $this->input->post('type') ? $this->input->post('type') : ''; // 	1:course 2: lesson 3:package 	

        //
        $offer_amount    = $this->input->post('offer_amount') ? $this->input->post('offer_amount') : 0.00;
        $offer_id     = $this->input->post('offer_id') ? $this->input->post('offer_id') : 0;
        $wallet_amount    = $this->input->post('wallet_amount') ? $this->input->post('wallet_amount') : 0.00;
        // $keyId = "rzp_test_xxxxx";
        // $keySecret = "xxxxxxxx";

        // if ($login_user_id != "" && $type != ""  && ($total_amount != "" || ($total_amount == "" && ($wallet_amount != 0.00 || $offer_amount != 0.00)))) {
        if ($login_user_id != ""   && $total_amount != "" && $courses_id != "") {
            $coursesDuratoion = $this->CommonModel->getData('tbl_courses_duration', array('courses_id' => $courses_id), 'id,duration_id', '', 'row_array');
            // print_r($coursesDuratoion);
            // die;
            $userDetails = $this->CommonModel->getData('tbl_users', array('id' => $login_user_id, 'status' => 1));
            if ($userDetails) {
                /*
 		          $wallet_amount_data=getQuickWalletAmount($user_id);
                  $wallet_amount_main=$wallet_amount_data['remaining_balance'];
                   if($wallet_amount_main >= $wallet_amount){
                        	$response['result'] = false;
                            $response['reason'] = "Wallet Amount not grater than Main Balance";
                             echo json_encode($response);die;
                    } */
                //  // $cartDetails = $this->CommonModel->getData('tbl_cart', array('user_id' => $user_id));
                //  if($cartDetails){
                $api = new Api(RAZORPAY_KEY_ID, RAZORPAY_KEY_SECRET);
                // print_r($api);
                // die;
                $amount_paise = $total_amount * 100; // Razorpay works in paise
                $orderNo = ORDER_NUMBER_PREFIX . "" . $login_user_id . "" . strtotime(date('Y-m-d H:i:s'));
                try {

                    $order = $api->order->create([
                        'receipt' => $orderNo,
                        'amount' => $amount_paise,
                        'currency' => 'INR',
                        'payment_capture' => 1
                    ]);
                    // echo "<pre>";
                    // print_r($order);
                    // die;


                    $insOrder = array(
                        'order_no' => $orderNo,
                        // 'razorpay_order_id' => $order['id'],
                        // 'razorpay_order_id' => 1,
                        'user_id' => $login_user_id,
                        'date' => date('Y-m-d'),
                        'order_status' => "CREATED",
                        'payment_status' => 'PENDING',
                        'payment_type' => $payment_type,
                        'amount' => $amount,
                        'delivery_charges' => $delivery_charges,
                        // 'discount_amount' => $discount_amount,
                        'offer_amount' => $offer_amount,
                        'offer_id' => $offer_id,
                        'gst_amount' => $gst_amount,
                        'wallet_amount' => $wallet_amount,
                        'total_amount' => $total_amount,
                        'extra_note' => $extra_note,
                        'created_by' => $login_user_id
                    );
                    // print_r($insOrder);
                    // die;
                    $orderID = $this->CommonModel->iudAction('tbl_orders', $insOrder, 'insert');
                    // print_r($orderID);
                    // die;
                    if ($orderID) {
                        $name = '';

                        $order_payment_detail = [
                            'user_id' => $login_user_id,
                            'order_id' => $orderID,
                            // 'razorpay_order_id' => 1,
                            'razorpay_order_id' => $order['id'],
                            'amount' =>  $amount,
                        ];
                        $this->CommonModel->iudAction('tbl_order_payment_details', $order_payment_detail, 'insert');

                        $name = $userDetails[0]['first_name'];
                        $course_name = $this->CommonModel->getData('tbl_courses', array('id' => $courses_id));
                        $cname = strlen($course_name[0]['title']);
                        if ($cname > 30) {
                            $course_name1 = substr($course_name[0]['title'], 0, 30) . "..";
                        } else {
                            $course_name1 = $course_name[0]['title'];
                        }
                        $verificationMessage = " Dear " . $name . ", Your Course " . $course_name1 . " have been Purchased Successfully. Thanks Team Lalit Dangre";
                        // sendMobileMessage($verificationMessage, $userDetails[0]['mobile_no'], '1507163947849507459');

                        $insCart = array(
                            'user_id' => $login_user_id,
                            'courses_id' => $courses_id,
                            // 'lesson_id' => $lesson_id,
                            'courses_duration_id' => $coursesDuratoion['id'],
                            // 'type' => $type,
                            'rate' => $rate,
                            'order_id' => $orderID

                        );

                        $cartStatus = $this->CommonModel->iudAction('tbl_order_details', $insCart, 'insert');

                        // if ($payment_type == 2) {
                        //     $payArr = array(
                        //         'transaction_id' => $transaction_id,
                        //         'user_id' => $login_user_id,
                        //         'order_id' => $orderID,
                        //         'transaction_date' => date('Y-m-d'),
                        //         'payment_id' => $payment_id,
                        //     );

                        //     $payStatus = $this->CommonModel->iudAction('tbl_payments', $payArr, 'insert');
                        // }

                        //offer reedeem
                        // if ($offer_id) {
                        //     $offerArr = array(
                        //         'offer_id' => $offer_id,
                        //         'user_id' => $login_user_id,
                        //         'order_id' => $orderID
                        //     );
                        //     $offerStatus = $this->CommonModel->iudAction('tbl_offer_redeemed', $offerArr, 'insert');
                        // }

                        //wallet  amount update wallet trancation
                        // if ($wallet_amount) {
                        //     withdraw_wallet_amount_user($login_user_id, $orderID, $wallet_amount);
                        //     // updateQuickWallentAMount($user_id,2,$wallet_amount);
                        //     $response['query'] = $this->db->last_query();
                        // }


                        //add in order subscrbption 
                        // if ($type == 1) {
                        //course subscribtion
                        // $coursesDuratoion = $this->CommonModel->getData('tbl_courses_duration', array('id' => $courses_duration_id), 'duration_id', '', 'row_array');

                        // $duratoion_no_of_days = $this->CommonModel->getData('tbl_duration_master', array('id' => $coursesDuratoion['duration_id']), 'no_of_days', '', 'row_array');
                        // print_r($duratoion_no_of_days);
                        // die;
                        // $order_date = date('Y-m-d');
                        // $endDate = date('Y-m-d', strtotime($order_date . " +" . $duratoion_no_of_days['no_of_days'] . " days"));
                        // $order_subscrb = array(
                        //     'order_id' => $orderID,
                        //     'order_no' => $orderNo,
                        //     'user_id' => $login_user_id,
                        //     // 'type' => $type,
                        //     // 'courses_duration_id' => $courses_duration_id,
                        //     'courses_duration_id' => $coursesDuratoion['duration_id'],
                        //     'course_id' => $courses_id,
                        //     'start_date' => date('Y-m-d'),
                        //     'end_date' => $endDate,
                        //     'active' => 1,
                        //     'no_of_days' => $duratoion_no_of_days['no_of_days'],
                        //     'created_on' => date('Y-m-d H:i:s'),
                        // );
                        // $subcribtionStatus = $this->CommonModel->iudAction('tbl_order_courses_subscription', $order_subscrb, 'insert');

                        // } else {
                        //     //package subscrbption
                        //     if ($type == 3) {
                        //         $where3['package_id'] = $courses_id;
                        //         $courses = $this->CommonModel->getData('tbl_courses_packages', $where3);
                        //         foreach ($courses as $key3 => $course1) {

                        //             $coursesDuratoion = $this->CommonModel->getData('tbl_courses_duration', array('id' => $course1['courses_duration_id']), 'duration_id', '', 'row_array');
                        //             $duratoion_no_of_days = $this->CommonModel->getData('tbl_duration_master', array('id' => $coursesDuratoion['duration_id']), 'no_of_days', '', 'row_array');
                        //             $order_date = date('Y-m-d');
                        //             $endDate = date('Y-m-d', strtotime($order_date . " +" . $duratoion_no_of_days['no_of_days'] . " days"));
                        //             $order_subscrb = array(
                        //                 'order_id' => $orderID,
                        //                 'order_no' => $orderNo,
                        //                 'user_id' => $user_id,
                        //                 'type' => $type,
                        //                 'package_id' => $courses_id,
                        //                 'courses_duration_id' => $course1['courses_duration_id'],
                        //                 'course_id' => $course1['courses_id'],
                        //                 'start_date' => date('Y-m-d'),
                        //                 'end_date' => $endDate,
                        //                 'active' => 1,
                        //                 'no_of_days' => $duratoion_no_of_days['no_of_days'],
                        //                 'created_on' => date('Y-m-d H:i:s'),
                        //             );
                        //             $subcribtionStatus = $this->CommonModel->iudAction('tbl_order_courses_subscription', $order_subscrb, 'insert');
                        //         }
                        //     }
                        // }
                        // $response['query_subscription'] = $this->db->last_query();

                        // if ($userDetails[0]['referral_code'] != NULL) {
                        //     if ($total_amount) {
                        //         add_commsion_user($user_id, $orderID, $userDetails[0]['referral_code'], $total_amount);
                        //         $response['query_commision'] = $this->db->last_query();
                        //     }
                        // }


                        // $response['result'] = true;
                        // $response['reason'] = 'Order placed succefully.';
                        $response = [
                            "status" => true,
                            "message" => "Order created successfully",
                            "data" => [
                                "order_id" => $orderID,
                                "razorpay_order_id" => $order['id'],
                                // "razorpay_order_id" =>  1,
                                "amount" => $amount_paise,
                                "currency" => "INR",
                                // "key_id" => RAZORPAY_KEY_ID
                            ]
                        ];
                    } else {
                        $response['result'] = false;
                        $response['reason'] = SOMETHING_WRONG;
                    }
                } catch (Exception $e) {
                    // print_r("hille");
                    // print_r($e->getMessage());
                    // die;
                    echo json_encode([
                        "status" => false,
                        "message" => $e->getMessage()
                    ]);
                }


                /* }else{
         			$response['result'] = false;
                    $response['reason'] = "No item in cart";
 		        } */
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

    public function updateOrderPaymentStatus()
    {
        $post = json_decode($this->input->raw_input_stream, true);
        authenticateUser();


        $login_user_id = $this->regId;

        $order_id = $post['order_id'] ? $post['order_id'] : '';
        $course_id = $post['course_id'] ? $post['course_id'] : '';
        $razorpay_order_id = $post['razorpay_order_id'] ? $post['razorpay_order_id'] : '';
        $razorpay_payment_id = $post['razorpay_payment_id'] ? $post['razorpay_payment_id'] : '';
        $razorpay_signature = $post['razorpay_signature'] ? $post['razorpay_signature'] : '';
        $payment_status = $post['payment_status'] ? $post['payment_status'] : '';
        if (empty($order_id) || empty($razorpay_order_id) || empty($payment_status)) {
            // if (empty($order_id) || empty($razorpay_order_id) || empty($razorpay_payment_id) || empty($razorpay_signature) || empty($payment_status)) {
            echo json_encode([
                "status" => false,
                "message" => "Invalid input"
            ]);
            die;
        }
        $allowed_status = ['CAPTURED', 'FAILED'];

        if (!in_array($payment_status, $allowed_status)) {
            echo json_encode([
                "status" => false,
                "message" => "Invalid payment status"
            ]);
            die;
        }

        $get_current_order_status = $this->CommonModel->getData('tbl_orders', array('id' => $order_id, 'user_id' => $login_user_id), 'order_status,payment_status', '', 'row_array');
        if (empty($get_current_order_status)) {
            echo json_encode([
                "status" => false,
                "message" => "Invalid order"
            ]);
            die;
        }
        if ($get_current_order_status['payment_status'] == 'CAPTURED' && $get_current_order_status['order_status'] == 'COMPLETED') {
            echo json_encode([
                "status" => true,
                "message" => "Payment already processed"
            ]);
            die;
        }
        if ($get_current_order_status['payment_status'] == 'FAILED' && $get_current_order_status['order_status'] == 'CANCELLED') {
            echo json_encode([
                "status" => false,
                "message" => "Previous payment failed. Please create new order."
            ]);
            die;
        }

        if ($payment_status == 'CAPTURED') {
            $update_order = [
                'order_status' => "COMPLETED",
                'payment_status' => $payment_status,
            ];
            $this->CommonModel->iudAction('tbl_orders', $update_order, 'update', array('id' => $order_id));
            $get_order_details = $this->CommonModel->getData('tbl_orders', array('user_id' => $login_user_id, 'id' => $order_id), 'order_no', '', 'row_array');
            // echo "<pre>";
            // print_r($get_order_details);
            // die;
            $userDetails = $this->CommonModel->getData('tbl_users', array('id' => $login_user_id, 'status' => 1));
            $name = $userDetails[0]['first_name'];
            $course_name = $this->CommonModel->getData('tbl_courses', array('id' => $course_id));
            $coursesDuratoion = $this->CommonModel->getData('tbl_courses_duration', array('courses_id' => $course_id), 'id,duration_id', '', 'row_array');
            $cname = strlen($course_name[0]['title']);
            if ($cname > 30) {
                $course_name1 = substr($course_name[0]['title'], 0, 30) . "..";
            } else {
                $course_name1 = $course_name[0]['title'];
            }
            $verificationMessage = " Dear " . $name . ", Your Course " . $course_name1 . " have been Purchased Successfully. Thanks Team Lalit Dangre";
            // sendMobileMessage($verificationMessage, $userDetails[0]['mobile_no'], '1507163947849507459');
            // update course subscription
            $duratoion_no_of_days = $this->CommonModel->getData('tbl_duration_master', array('id' => $coursesDuratoion['duration_id']), 'no_of_days', '', 'row_array');

            $order_date = date('Y-m-d');
            $endDate = date('Y-m-d', strtotime($order_date . " +" . $duratoion_no_of_days['no_of_days'] . " days"));
            $order_subscrb = array(
                'order_id' => $order_id,
                'order_no' => $get_order_details['order_no'],
                'user_id' => $login_user_id,
                // 'type' => $type,
                // 'courses_duration_id' => $courses_duration_id,
                'courses_duration_id' => $coursesDuratoion['id'],
                'course_id' => $course_id,
                'start_date' => date('Y-m-d'),
                'end_date' => $endDate,
                'active' => 1,
                'no_of_days' => $duratoion_no_of_days['no_of_days'],
                'created_on' => date('Y-m-d H:i:s'),
            );
            $subcribtionStatus = $this->CommonModel->iudAction('tbl_order_courses_subscription', $order_subscrb, 'insert');
            $update_payment_order = [
                'razorpay_payment_id' => $razorpay_payment_id,
                'razorpay_signature' => $razorpay_signature,
                'status' => $payment_status,
                'transaction_date' => date('Y-m-d H:i:s'),
                'payment_response' => json_encode($post)
            ];
            $this->CommonModel->iudAction('tbl_order_payment_details', $update_payment_order, 'update', array('order_id' => $order_id, 'user_id' => $login_user_id, 'razorpay_order_id' => $razorpay_order_id));
        } else if ($payment_status == 'FAILED') {
            $this->CommonModel->iudAction('tbl_orders', array('order_status' => "CANCELLED", 'payment_status' => "FAILED"), 'update', array('id' => $order_id, 'user_id' => $login_user_id));
            $this->CommonModel->iudAction('tbl_order_payment_details', array('status' => 'FAILED'), 'update', array('order_id' => $order_id, 'user_id' => $login_user_id, 'razorpay_order_id' => $razorpay_order_id));
            // echo json_encode([
            //     "status" => false,
            //     "message" => "Payment failed"
            // ]);
            // die;
        }
        echo json_encode([
            "status" => true,
            "message" => "Payment Status update successful",
            "data" => [
                "order_id" => $order_id,
                "course_id" => $course_id,
                "payment_status" => $payment_status,
            ]
        ]);
        die;
    }

    public function cancelOrder()
    {
        $response = array();
        authenticateUser();
        $user_id = $this->input->post('user_id') ? $this->input->post('user_id') : '';
        $order_id = $this->input->post('order_id') ? $this->input->post('order_id') : '';
        $cancel_reason = $this->input->post('cancel_reason') ? $this->input->post('cancel_reason') : '';

        if ($user_id != "" && $order_id != "" && $cancel_reason != "") {
            $userDetails = $this->CommonModel->getData('tbl_users', array('id' => $user_id, 'status' => 1));
            if ($userDetails) {
                $orderDetails = $this->CommonModel->getData('tbl_orders', array('id' => $order_id));
                if ($orderDetails) {

                    $updCart = array('order_status' => ORDER_CANCELLED, 'cancel_reason' => $cancel_reason);
                    $res = $this->CommonModel->iudAction('tbl_orders', $updCart, 'update', array('id' => $order_id));

                    if ($res) {
                        $response['result'] = true;
                        $response['reason'] = "Order cancelled";
                    } else {
                        $response['result'] = false;
                        $response['reason'] = "Something went wrong, please try later";
                    }
                } else {
                    $response['result'] = false;
                    $response['reason'] = "Order not found";
                }
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

    // my order
    public function myOrder()
    {
        authenticateUser();
        $response = array();
        $user_id = $this->input->post('user_id') ? $this->input->post('user_id') : '';
        $type = $this->input->post('type') ? $this->input->post('type') : '';
        if ($user_id != "") {
            $userDetails = $this->Common_model->getData('tbl_users', array('id' => $user_id, 'status' => 1));
            if ($userDetails) {
                if ($type) {
                    $where1 = array('o.user_id' => $user_id, 'od.type' => $type);
                } else {
                    $where1 = array('o.user_id' => $user_id);
                }


                $orderDetails = $this->Courses_model->getOrderData($where1);

                if ($orderDetails) {
                    $totalQty = $totalAmount = $totalSavings = 0;

                    foreach ($orderDetails as $key => $order) {
                        $where_order = array('order_id' => $order['order_id']);
                        $orderCourseSubscriptionDetails = $this->Common_model->getData('tbl_order_courses_subscription', $where_order, 'start_date,max(end_date) as end_date', '', 'row_array');

                        if ($orderCourseSubscriptionDetails) {
                            $orderDetails[$key]['course_subscription_start_date'] = $orderCourseSubscriptionDetails['start_date'];
                            $orderDetails[$key]['course_subscription_end_date'] = $orderCourseSubscriptionDetails['end_date'];
                            $endDate = $orderCourseSubscriptionDetails['end_date'];
                            if ($endDate < date('Y-m-d')) {
                                $orderDetails[$key]['course_subscription_is_expired'] = 1;
                            } else {
                                $orderDetails[$key]['course_subscription_is_expired'] = 0;
                            }
                            $now = time(); // or your date as well
                            $your_date = strtotime($endDate);
                            $datediff = $your_date - $now;
                            $orderDetails[$key]['course_subscription_reamining_no_days'] = round($datediff / (60 * 60 * 24));
                        } else {
                            $orderDetails[$key]['course_subscription_start_date'] = '';
                            $orderDetails[$key]['course_subscription_end_date'] = '';
                            $orderDetails[$key]['course_subscription_reamining_no_days'] = "";
                            $orderDetails[$key]['course_subscription_is_expired'] = 0;
                        }
                        $orderSubcribt = $orderDetails[$key];
                        if ($type) {
                            $where = array('order_id' => $order['order_id'], 'type' => $type);
                        } else {
                            $where = array('order_id' => $order['order_id']);
                        }
                        $coursesDetails = array();
                        $orderCourseDetails = $this->Common_model->getData('tbl_order_details', $where);

                        foreach ($orderCourseDetails as $key1 => $course) {

                            $coursesDetails = array();
                            if ($course['type'] == 1) {
                                $coursesDetails = $course;

                                // $this->Courses_model->getCoursesData($where,$search,0, 0)
                                $courses = $this->Courses_model->getCoursesData(array('c.id' => $course['courses_id']), '', 0, 0);
                                //  echo $this->db->last_query();die;
                                $coursesDetails['title'] = $courses[0]['title'];
                                $coursesDetails['image'] = $courses[0]['image'];
                                $coursesDetails = $courses[0];
                                $where2['cd.courses_id'] = $course['courses_id'];
                                $coursesDetails['duration'] = $this->Courses_model->getCoursesDurationData($where2, '', 0, 0);
                                $package_subscribe_flag = 0;
                                foreach ($coursesDetails['duration'] as $key2 => $value2) {
                                    $packege_subscribe = calcuateDate($user_id, $course['courses_id'], 0, 0, $value2['duration_id']);

                                    if ($packege_subscribe) {
                                        $package_subscribe_flag = 1;
                                        $coursesDetails['duration'][$key2]['is_subscribe'] = 1;
                                        $plan[0] = $packege_subscribe;
                                        $coursesDetails['duration'][$key2]['package_plan'] = $plan;
                                    } else {
                                        $getPackage_id = $this->CommonModel->getData('tbl_courses_packages', array('courses_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id']), 'package_id');
                                        if (!empty($getPackage_id)) {

                                            foreach ($getPackage_id as $key1 => $value1) {
                                                //echo $value['courses_id']." ".$value1['package_id'];
                                                $packege_subscribe1 = calcuateDate($user_id, $course['courses_id'], 0, $value1['package_id'], 0);
                                                //  print_r($packege_subscribe1);die();
                                                if ($packege_subscribe1) {
                                                    $package_subscribe_flag = 1;
                                                    $coursesDetails['duration'][$key2]['is_subscribe'] = 1;
                                                    $coursesDetails['duration'][$key2]['package_plan'] = $packege_subscribe1[0]['courses'];
                                                } else {
                                                    $coursesDetails['duration'][$key2]['is_subscribe'] = 0;
                                                    $coursesDetails['duration'][$key2]['package_plan'] = [];
                                                }
                                            }
                                        } else {
                                            $coursesDetails['duration'][$key2]['is_subscribe'] = 0;
                                            $coursesDetails['duration'][$key2]['package_plan'] = [];
                                        }
                                    }
                                }
                                $courseDetailsList[$key]['is_subscribe'] = $package_subscribe_flag;
                            } elseif ($course['type'] == 2) {
                                $lesson = $this->Common_model->getData('tbl_lesson', array('id' => $course['lesson_id']));
                                $coursesDetails = $course;
                                $coursesDetails['title'] = $lesson[0]['title'];
                                $coursesDetails['image'] = '';
                            } elseif ($course['type'] == 3) {
                                //  courses_id
                                $package_id = $course['courses_id'];
                                $where5['c.id'] = $package_id;
                                $where5['c.category_id'] = 0;
                                $packageDetailsList = $this->Courses_model->getPackagesData($where5, '', 0, 0);
                                //    echo $this->db->last_query();die;
                                $packageDetailsList[0]['course_subscription_start_date'] = $orderSubcribt['course_subscription_start_date'];
                                $packageDetailsList[0]['course_subscription_end_date'] = $orderSubcribt['course_subscription_end_date'];
                                $packageDetailsList[0]['course_subscription_is_expired'] = $orderSubcribt['course_subscription_is_expired'];
                                $packageDetailsList[0]['course_subscription_reamining_no_days'] = $orderSubcribt['course_subscription_reamining_no_days'];
                                $packageDetailsList[0]['is_review_submit'] = $orderSubcribt['is_review_submit'];
                                $packageDetailsList[0]['order_id'] = $orderSubcribt['order_id'];
                                $orderDetails[$key] = $packageDetailsList[0];

                                foreach ($packageDetailsList as $key3 => $value) {
                                    $where4['cp.package_id'] = $value['package_id'];
                                    $coursesDetails = $this->Courses_model->getPackagesCourseData($where4, '', 0, 0);
                                    foreach ($coursesDetails as $key2 => $value2) {
                                        $packege_subscribe = array();
                                        $packege_subscribe = calcuateDate($user_id, $value2['id'], 0, $package_id);
                                        // print_r($packege_subscribe);die;
                                        //  $packege_subscribe=calcuateDate($user_id,$value2['id'],0,$package_id);
                                        if ($packege_subscribe) {
                                            //    print_r($packege_subscribe);die();
                                            $coursesDetails[$key2]['is_subscribe'] = 1;
                                            $coursesDetails[$key2]['end_date'] = $packege_subscribe['courses'][0]['end_date'];
                                            $coursesDetails[$key2]['reamining_no_days'] = $packege_subscribe['courses'][0]['reamining_no_days'];
                                            $coursesDetails[$key2]['is_expired'] = $packege_subscribe['courses'][0]['is_expired'];
                                            $packageDetailsList[$key3]['courses'] = $coursesDetails;
                                        } else {
                                            $coursesDetails[$key2]['is_subscribe'] = 0;
                                            $coursesDetails[$key2]['end_date'] = '';
                                            $coursesDetails[$key2]['reamining_no_days'] = '';
                                            $coursesDetails[$key2]['is_expired'] = 1;
                                            $packageDetailsList[$key3]['courses'] = $coursesDetails;
                                        }
                                    }
                                }
                            }
                            $orderDetails[$key]['courses'] = $coursesDetails;
                        }
                    }
                    $response['course_path'] = base_url() . COURSE_IMAGES;
                    $response['orders_details'] = $orderDetails;
                    $response['result'] = true;
                    $response['reason'] = 'Courses found in cart';
                    $orderCount = count($this->Common_model->getData('tbl_orders', array('user_id' => $user_id)));
                    $response['order_count'] = $orderCount;
                } else {
                    $response['result'] = false;
                    $response['reason'] = "Order Not Found";
                }
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

    public function reviewOrder()
    {
        authenticateUser();
        $response = array();
        $user_id = $this->input->post('user_id') ? $this->input->post('user_id') : '';
        $order_id = $this->input->post('order_id') ? $this->input->post('order_id') : '';
        $rate = $this->input->post('rate') ? $this->input->post('rate') : '';
        $review = $this->input->post('review') ? $this->input->post('review') : '';
        $type = $this->input->post('type') ? $this->input->post('type') : '';
        $courses_duration_id = $this->input->post('courses_duration_id') ? $this->input->post('courses_duration_id') : '';
        $course_id = $this->input->post('course_id') ? $this->input->post('course_id') : '';

        if ($user_id !== "" && $order_id !== "" && $rate != "" && $course_id !== "") {
            $userDetails = $this->CommonModel->getData('tbl_users', array('id' => $user_id, 'status' => 1));
            if ($userDetails) {
                $orderList = $this->CommonModel->getData('tbl_orders', array('user_id' => $user_id, 'id' => $order_id));

                if (isset($orderList) && $orderList[0]['is_review_submit'] == 0) {
                    $insArr = array(
                        'user_id' => $user_id,
                        'order_id' => $order_id,
                        'course_id' => $course_id,
                        'courses_duration_id' => $courses_duration_id,
                        'rate' => $rate,
                        'review' => $review,
                        'type' => $type
                    );

                    $insRes = $this->CommonModel->iudAction('tbl_order_courses_review', $insArr, 'insert');
                    if ($insRes) {
                        $this->CommonModel->iudAction('tbl_orders', array('is_review_submit' => 1), 'update', array('id' => $order_id));
                        $response['result'] = true;
                        $response['reason'] = "Review submitted";
                    } else {
                        $response['result'] = true;
                        $response['reason'] = "Something went wrong, please try later";
                    }
                } else {
                    $response['result'] = false;
                    $response['reason'] = "No orders found or review submited";
                }
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
}