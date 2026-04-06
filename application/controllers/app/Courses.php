<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Courses extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('app/Courses_model');
        $this->load->model('app/Common_model');
    }

    public function getCategoriesList()
    {
        $response = array();
        // $parent_id = $this->input->post('parent_id') ? $this->input->post('parent_id') : 0;
        $search    = $this->input->post('search') ? $this->input->post('search') : '';
        $categoriesList = $this->Courses_model->getCategoryData('', $search);

        if ($categoriesList) {
            $response['category_list'] = $categoriesList;
            $response['result'] = true;
            $response['message'] = "Category found";
            // $response['category_path'] = base_url() . CATEGORY_IMAGES;
        } else {
            $response['result'] = false;
            $response['message'] = "No Category found";
        }
        echo json_encode($response);
    }

    public function getCourses()
    {
        authenticateUser();
        // echo "<pre>";
        // print_r($_POST);
        // echo json_encode($_POST);
        // die;
        // die;
        $response = array();
        $categoryId = trim($this->input->post('category_id')) ? trim($this->input->post('category_id')) : 0;
        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : "";
        $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : "";
        $page     = $this->input->post('page_no') ? $this->input->post('page_no') : 1;
        // $reg_email = $this->reg_email;
        // echo "<pre>";
        // print_r($this->user_type);
        // die;

        if ($user_id) {
            $user_type = $this->CommonModel->getData('tbl_users', ['id' => $user_id], 'user_type', '', 'row_array');
            if (!isset($this->user_type)) {
                $response['result'] = false;
                $response['message'] = "User Type Not Found";
                echo json_encode($response);
                die;
            }

            if ($page) {
                $limit = 10;
                $offset = ($page - 1) * $limit;
            } else {
                $limit = 0;
                $offset = 0;
            }
            $where = array();
            if ($categoryId && strpos($categoryId, ',') !== false) {
                $categoryId = explode(',', $categoryId);
            }
            if ($categoryId) {
                $where['category_id'] = $categoryId;
            }
            $where['c.status'] = ACTIVE;
            if (isset($this->user_type)) {
                $where['c.course_type'] = $this->user_type;
            }
            // echo "<pre>";
            // print_r($where);
            // die;
            // $where['o.user_id'] = $user_id;
            //FRANCHISE

            $total_records = count($this->Courses_model->getFranchiseCoursesData($where, $search, 0, 0));
            $courseList = $this->Courses_model->getFranchiseCoursesData($where, $search, $limit, $offset);
            $total_pages = ($limit > 0) ? ceil($total_records / $limit) : 1;
            // echo $this->db->last_query();
            // die;
            $response['course_list'] = $courseList;
            // print_r($courseList);
            // die;
            $sub = array();
            if (!empty($courseList)) {

                foreach ($courseList as $key => $course) {
                    $where2['cd.courses_id'] = $course['id'];
                    $ratingData = $this->getCourseRating($course['id']);
                    $courseList[$key]['duration'] = $this->Courses_model->getCoursesDurationData($where2, '', 0, 0);

                    foreach ($courseList[$key]['duration'] as $key2 => $value2) {
                        $packege_subscribe = calcuateDate($user_id, $course['id'], 0, 0, $value2['duration_id']);
                        // print_r($value2['duration_id']);
                        // die;
                        if ($packege_subscribe) {

                            if ($packege_subscribe['is_expired']) {

                                $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
                                // $courseList[$key]['duration'][$key2]['package_plan'] = [];
                            } else {
                                $courseList[$key]['duration'][$key2]['is_subscribe'] = 1;
                                // $sub[0] = $packege_subscribe;
                                // $courseList[$key]['duration'][$key2]['package_plan'] = $sub;
                            }
                        } else {
                            // $getPackage_id = $this->CommonModel->getData('tbl_courses_packages', array('courses_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id']), 'package_id');

                            // if ($getPackage_id) {
                            //     foreach ($getPackage_id as $key1 => $value1) {
                            //         $packege_subscribe1 = calcuateDate($user_id, $value['courses_id'], 0, $value1['package_id'], 0);
                            //         //    print_r($packege_subscribe1);die;
                            //         if ($packege_subscribe1) {
                            //             $courseList[$key]['duration'][$key2]['is_subscribe'] = 1;
                            //             if (isset($packege_subscribe1['courses'][0])) {
                            //                 $courseList[$key]['duration'][$key2]['package_plan'] = $packege_subscribe1['courses'][0];
                            //             } else {
                            //                 $courseList[$key]['duration'][$key2]['package_plan'] = [];
                            //             }
                            //         } else {
                            //             $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
                            //             $courseList[$key]['duration'][$key2]['package_plan'] = [];
                            //         }
                            //     }
                            // } else {
                            $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
                            // $courseDetailsList[$key]['duration'][$key2]['package_plan'] = [];
                            // }
                        }
                    }
                    $no_of_course_lesson_video = $this->CommonModel->getData(
                        'tbl_lesson_video',
                        array('courses_id' => $course['courses_id']),
                        'count(id) as total_videos',
                        '',
                        'row_array'
                    );

                    $no_of_watch_user_video = $this->CommonModel->getData(
                        'tbl_lesson_user_video',
                        array(
                            'courses_id' => $course['courses_id'],
                            'user_id' => $user_id,
                            'view_video' => 1
                        ),
                        'count(id) as watched_videos',
                        '',
                        'row_array'
                    );

                    $totalVideos = (int) $no_of_course_lesson_video['total_videos'];
                    $watchedVideos = (int) $no_of_watch_user_video['watched_videos'];
                    if ($totalVideos > 0) {
                        $watchPercentage = ($watchedVideos / $totalVideos) * 100;
                    } else {
                        $watchPercentage = 0;
                    }
                    $courseList[$key]['course_rating']   = $ratingData['course_rating'];
                    $courseList[$key]['no_of_review'] = $ratingData['no_of_review'];
                    $courseList[$key]['watch_percentage'] = round($watchPercentage, 2);
                    $courseList[$key]['watched_videos'] = $watchedVideos;
                    $courseList[$key]['total_videos'] = $totalVideos;
                }
            }

            // foreach ($courseList as $key => $value) {

            //     $where2['cd.courses_id'] = $value['courses_id'];
            //     $courseList[$key]['duration'] = $this->Courses_model->getCoursesDurationData($where2, '', 0, 0);
            //     $rating = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 1, 'course_id' => $value['courses_id'], 'active' => 1), 'AVG(rate) as avg,count(review) as no_of_review');
            //     if ($rating) {
            //         $avg = ($rating[0]['avg']) ? $rating[0]['avg'] : 0;
            //         $courseList[$key]['avg_rating'] = round($avg, 2);
            //         $courseList[$key]['no_of_review'] = $rating[0]['no_of_review'];
            //     } else {
            //         $courseList[$key]['avg_rating'] = 0;
            //         $courseList[$key]['no_of_review'] = 0;
            //     }
            //     $review = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 1, 'course_id' => $value['courses_id'], 'active' => 1));
            //     if ($review) {
            //         $courseList[$key]['review'] = $review;
            //     } else {
            //         $courseList[$key]['review'] = array();
            //     }
            //     foreach ($courseList[$key]['duration'] as $key2 => $value2) {
            //         $packege_subscribe = calcuateDate($user_id, $value['courses_id'], 0, 0, $value2['duration_id']);

            //         if ($packege_subscribe) {

            //             if ($packege_subscribe['is_expired']) {
            //                 $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
            //                 $courseList[$key]['duration'][$key2]['package_plan'] = [];
            //             } else {
            //                 $courseList[$key]['duration'][$key2]['is_subscribe'] = 1;
            //                 $sub[0] = $packege_subscribe;
            //                 $courseList[$key]['duration'][$key2]['package_plan'] = $sub;
            //             }
            //         } else {
            //             $getPackage_id = $this->CommonModel->getData('tbl_courses_packages', array('courses_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id']), 'package_id');

            //             if ($getPackage_id) {
            //                 foreach ($getPackage_id as $key1 => $value1) {
            //                     $packege_subscribe1 = calcuateDate($user_id, $value['courses_id'], 0, $value1['package_id'], 0);
            //                     //    print_r($packege_subscribe1);die;
            //                     if ($packege_subscribe1) {
            //                         $courseList[$key]['duration'][$key2]['is_subscribe'] = 1;
            //                         if (isset($packege_subscribe1['courses'][0])) {
            //                             $courseList[$key]['duration'][$key2]['package_plan'] = $packege_subscribe1['courses'][0];
            //                         } else {
            //                             $courseList[$key]['duration'][$key2]['package_plan'] = [];
            //                         }
            //                     } else {
            //                         $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
            //                         $courseList[$key]['duration'][$key2]['package_plan'] = [];
            //                     }
            //                 }
            //             } else {
            //                 $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
            //                 $courseList[$key]['duration'][$key2]['package_plan'] = [];
            //             }
            //         }
            //         $rating = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 1, 'course_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id'], 'active' => 1), 'AVG(rate) as avg,count(review) as no_of_review');
            //         if ($rating) {
            //             $avg = ($rating[0]['avg']) ? $rating[0]['avg'] : 0;
            //             $courseList[$key]['duration'][$key2]['avg_rating'] = round($avg, 2);
            //             $courseList[$key]['duration'][$key2]['no_of_review'] = $rating[0]['no_of_review'];
            //         } else {
            //             $courseList[$key]['duration'][$key2]['avg_rating'] = 0;
            //             $courseList[$key]['duration'][$key2]['no_of_review'] = 0;
            //         }
            //         $review = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 1, 'course_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id'], 'active' => 1));
            //         if ($review) {
            //             $courseList[$key]['duration'][$key2]['review'] = $review;
            //         } else {
            //             $courseList[$key]['duration'][$key2]['review'] = array();
            //         }
            //     }

            //     //check final exam
            //     // $getCheckFlag = $this->Common_model->getData('tbl_lesson_user_final_exam', array('courses_id' =>  $value['courses_id'], 'user_id' => $user_id), 'is_show_final_exam_btn,final_exam_done', '', 'row_array');
            //     // if (isset($getCheckFlag['is_show_final_exam_btn']) && $getCheckFlag['is_show_final_exam_btn'] != 1 || empty($getCheckFlag)) {
            //     //     $courseList[$key]['is_lock_lesson'] = 1;
            //     // } else {
            //     //     $courseList[$key]['is_lock_lesson'] = 0;
            //     // }
            //     // if (isset($getCheckFlag['final_exam_done'])) {
            //     //     $courseList[$key]['final_exam_done'] = $getCheckFlag['final_exam_done'];
            //     // } else {
            //     //     $courseList[$key]['final_exam_done'] = 0;
            //     // }
            // }
            if ($courseList) {
                $response['course_list'] = $courseList;
                $response['result'] = true;
                $response['message'] = "Courses found";
                $response['course_path'] = base_url() . COURSE_IMAGES;
                $response['pagination'] = [
                    'total_records' => (int)$total_records,
                    'total_pages'   => (int)$total_pages,
                    'current_page'  => (int)$page,
                    'per_page'      => (int)$limit
                ];
            } else {
                $response['result'] = false;
                $response['message'] = "No Courses found";
            }
        } else {
            $response['result'] = false;
            $response['message'] = 'Invalid Input';
        }
        echo json_encode($response);
    }
    public function getMyCoursesList()
    {
        authenticateUser();
        // echo "<pre>";
        // print_r($_POST);
        // echo json_encode($_POST);
        // die;
        // die;
        $response = array();
        $categoryId = trim($this->input->post('category_id')) ? trim($this->input->post('category_id')) : 0;
        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : "";
        $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : "";
        $page     = $this->input->post('page_no') ? $this->input->post('page_no') : 1;
        $login_user_id = $this->regId;
        // $reg_email = $this->reg_email;
        // echo "<pre>";
        // print_r($this->user_type);
        // die;

        // if ($user_id) {
        $user_type = $this->CommonModel->getData('tbl_users', ['id' => $user_id], 'user_type', '', 'row_array');
        if (empty($this->user_type)) {
            $response['result'] = false;
            $response['message'] = "User Type Not Found";
            echo json_encode($response);
            die;
        }

        if ($page) {
            $limit = 10;
            $offset = ($page - 1) * $limit;
        } else {
            $limit = 0;
            $offset = 0;
        }
        $where = array();
        if ($categoryId && strpos($categoryId, ',') !== false) {
            $categoryId = explode(',', $categoryId);
        }
        if ($categoryId) {
            $where['category_id'] = $categoryId;
        }
        $where['c.status'] = ACTIVE;
        if (isset($this->user_type) && !empty($this->user_type)) {
            $where['c.course_type'] = $this->user_type;
        }
        // echo "<pre>";
        // print_r($where);
        // die;
        $where['o.user_id'] = $login_user_id;
        //FRANCHISE

        $total_records = count($this->Courses_model->getMyCoursesList($where, $search, 0, 0));
        $courseList = $this->Courses_model->getMyCoursesList($where, $search, $limit, $offset);
        $total_pages = ($limit > 0) ? ceil($total_records / $limit) : 1;
        // echo $this->db->last_query();
        // die;
        $response['course_list'] = $courseList;
        // print_r($courseList);
        // die;
        $sub = array();
        if (!empty($courseList)) {

            foreach ($courseList as $key => $course) {
                $where2['cd.courses_id'] = $course['id'];
                $ratingData = $this->getCourseRating($course['id']);
                $courseList[$key]['duration'] = $this->Courses_model->getCoursesDurationData($where2, '', 0, 0);
                foreach ($courseList[$key]['duration'] as $key2 => $value2) {
                    $packege_subscribe = calcuateDate($user_id, $course['id'], 0, 0, $value2['duration_id']);
                    // print_r($packege_subscribe);
                    // die;
                    if ($packege_subscribe) {

                        if ($packege_subscribe['is_expired']) {

                            $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
                            // $courseList[$key]['duration'][$key2]['package_plan'] = [];
                        } else {
                            $courseList[$key]['duration'][$key2]['is_subscribe'] = 1;
                            // $sub[0] = $packege_subscribe;
                            // $courseList[$key]['duration'][$key2]['package_plan'] = $sub;
                        }
                    } else {
                        // $getPackage_id = $this->CommonModel->getData('tbl_courses_packages', array('courses_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id']), 'package_id');

                        // if ($getPackage_id) {
                        //     foreach ($getPackage_id as $key1 => $value1) {
                        //         $packege_subscribe1 = calcuateDate($user_id, $value['courses_id'], 0, $value1['package_id'], 0);
                        //         //    print_r($packege_subscribe1);die;
                        //         if ($packege_subscribe1) {
                        //             $courseList[$key]['duration'][$key2]['is_subscribe'] = 1;
                        //             if (isset($packege_subscribe1['courses'][0])) {
                        //                 $courseList[$key]['duration'][$key2]['package_plan'] = $packege_subscribe1['courses'][0];
                        //             } else {
                        //                 $courseList[$key]['duration'][$key2]['package_plan'] = [];
                        //             }
                        //         } else {
                        //             $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
                        //             $courseList[$key]['duration'][$key2]['package_plan'] = [];
                        //         }
                        //     }
                        // } else {
                        $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
                        // $courseDetailsList[$key]['duration'][$key2]['package_plan'] = [];
                        // }
                    }
                }
                $no_of_course_lesson_video = $this->CommonModel->getData(
                    'tbl_lesson_video',
                    array('courses_id' => $course['courses_id']),
                    'count(id) as total_videos',
                    '',
                    'row_array'
                );

                $no_of_watch_user_video = $this->CommonModel->getData(
                    'tbl_lesson_user_video',
                    array(
                        'courses_id' => $course['courses_id'],
                        'user_id' => $user_id,
                        'view_video' => 1
                    ),
                    'count(id) as watched_videos',
                    '',
                    'row_array'
                );

                $totalVideos = (int) $no_of_course_lesson_video['total_videos'];
                $watchedVideos = (int) $no_of_watch_user_video['watched_videos'];
                if ($totalVideos > 0) {
                    $watchPercentage = ($watchedVideos / $totalVideos) * 100;
                } else {
                    $watchPercentage = 0;
                }
                $courseList[$key]['course_rating']   = $ratingData['course_rating'];
                $courseList[$key]['no_of_review'] = $ratingData['no_of_review'];
                $courseList[$key]['watch_percentage'] = round($watchPercentage, 2);
                $courseList[$key]['watched_videos'] = $watchedVideos;
                $courseList[$key]['total_videos'] = $totalVideos;
            }
        }


        if ($courseList) {
            $response['course_list'] = $courseList;
            $response['result'] = true;
            $response['message'] = "Courses found";
            $response['course_path'] = base_url() . COURSE_IMAGES;
            $response['pagination'] = [
                'total_records' => (int)$total_records,
                'total_pages'   => (int)$total_pages,
                'current_page'  => (int)$page,
                'per_page'      => (int)$limit
            ];
        } else {
            $response['result'] = false;
            $response['message'] = "No Courses found";
        }
        // } else {
        //     $response['result'] = false;
        //     $response['message'] = 'Invalid Input';
        // }
        echo json_encode($response);
    }
    public function getWatchCourses()
    {
        authenticateUser();
        // echo "<pre>";
        // print_r($_POST);
        // echo json_encode($_POST);
        // die;
        // die;
        $response = array();
        $categoryId = trim($this->input->post('category_id')) ? trim($this->input->post('category_id')) : 0;
        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : "";
        $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : "";
        $page     = $this->input->post('page_no') ? $this->input->post('page_no') : 1;
        // $reg_email = $this->reg_email;
        // echo "<pre>";
        // print_r($this->user_type);
        // die;

        if ($user_id) {
            $user_type = $this->CommonModel->getData('tbl_users', ['id' => $user_id], 'user_type', '', 'row_array');
            if (empty($this->user_type)) {
                $response['result'] = false;
                $response['message'] = "User Type Not Found";
                echo json_encode($response);
                die;
            }

            if ($page) {
                $limit = 10;
                $offset = ($page - 1) * $limit;
            } else {
                $limit = 0;
                $offset = 0;
            }
            $where = array();
            if ($categoryId && strpos($categoryId, ',') !== false) {
                $categoryId = explode(',', $categoryId);
            }
            if ($categoryId) {
                $where['category_id'] = $categoryId;
            }
            $where['c.status'] = ACTIVE;
            if (isset($this->user_type) && !empty($this->user_type)) {
                $where['c.course_type'] = $this->user_type;
            }
            if (isset($user_id) && !empty($user_id)) {
                $where['uv.user_id'] = $user_id;
                // $where['o.user_id'] = $user_id;
            }
            // echo "<pre>";
            // print_r($where);
            // die;
            // $where['o.user_id'] = $user_id;
            //FRANCHISE

            $total_records = count($this->Courses_model->getWatchCoursesData($where, $search, 0, 0));
            $courseList = $this->Courses_model->getWatchCoursesData($where, $search, $limit, $offset);
            $total_pages = ($limit > 0) ? ceil($total_records / $limit) : 1;
            // echo $this->db->last_query();
            // die;
            // $response['course_list'] = $courseList;
            // print_r($courseList);
            // die;
            $sub = array();
            if (!empty($courseList)) {

                foreach ($courseList as $key => $course) {

                    $ratingData = $this->getCourseRating($course['courses_id']);
                    $no_of_course_lesson_video = $this->CommonModel->getData(
                        'tbl_lesson_video',
                        array('courses_id' => $course['courses_id']),
                        'count(id) as total_videos',
                        '',
                        'row_array'
                    );

                    $no_of_watch_user_video = $this->CommonModel->getData(
                        'tbl_lesson_user_video_view',
                        array(
                            'courses_id' => $course['courses_id'],
                            'user_id' => $user_id,
                            'view_video' => 1
                        ),
                        'count(id) as watched_videos',
                        '',
                        'row_array'
                    );

                    $totalVideos = (int) $no_of_course_lesson_video['total_videos'];
                    $watchedVideos = (int) $no_of_watch_user_video['watched_videos'];
                    if ($totalVideos == $watchedVideos) {
                        unset($courseList[$key]);
                        continue;
                    }
                    if ($totalVideos > 0) {
                        $watchPercentage = ($watchedVideos / $totalVideos) * 100;
                    } else {
                        $watchPercentage = 0;
                    }
                    $courseList[$key]['course_rating']   = $ratingData['course_rating'];
                    $courseList[$key]['no_of_review'] = $ratingData['no_of_review'];
                    $courseList[$key]['watch_percentage'] = round($watchPercentage, 2);
                    $courseList[$key]['watched_videos'] = $watchedVideos;
                    $courseList[$key]['total_videos'] = $totalVideos;
                }
            }
            $courseList = array_values($courseList);

            if ($courseList) {
                $response['course_list'] = $courseList;
                $response['result'] = true;
                $response['message'] = "Courses found";
                $response['course_path'] = base_url() . COURSE_IMAGES;
                $response['pagination'] = [
                    'total_records' => (int)$total_records,
                    'total_pages'   => (int)$total_pages,
                    'current_page'  => (int)$page,
                    'per_page'      => (int)$limit
                ];
            } else {
                $response['result'] = false;
                $response['message'] = "No Courses found";
            }
        } else {
            $response['result'] = false;
            $response['message'] = 'Invalid Input';
        }
        echo json_encode($response);
    }

    public function getCoursesDetails()
    {
        authenticateUser();
        $response = array();

        $courseId = trim($this->input->post('course_id')) ? trim($this->input->post('course_id')) : 0;
        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : 0;

        if ($courseId && $user_id) {
            $where = array();

            if ($courseId) {
                $where['c.id'] = $courseId;
            }
            if (isset($this->user_type) && !empty($this->user_type)) {
                $where['c.course_type'] = $this->user_type;
            }
            $where['c.status'] = ACTIVE;
            $count = count($this->Courses_model->getCoursesData($where, '', 0, 0));
            $courseDetailsList = $this->Courses_model->getCoursesData($where, '', 0, 0);
            // echo "<pre>";
            // print_r($courseDetailsList[0]['skill_name']);
            // die;
            // echo $this->db->last_query();
            $skill_name = [];

            if (isset($courseDetailsList[0]['skill_name']) && !empty($courseDetailsList[0]['skill_name'])) {
                $skill_name = explode(',', $courseDetailsList[0]['skill_name']);
            }
            // $skill_details
            $courseDetailsList[0]['skill_details'] = $skill_name;
            $ratingData = $this->getCourseRating($courseId);

            $courseDetailsList[0]['course_rating']  = $ratingData['course_rating'] ?? 0;
            $courseDetailsList[0]['no_of_review'] = $ratingData['no_of_review'] ?? 0;
            // echo "<pre>";
            // print_r($skill_ids);
            // print_r($skill_details);
            // // print_r($courseDetailsList);
            // die;

            //print_r($courseDetailsList);die();
            foreach ($courseDetailsList as $key => $value) {
                $where2['cd.courses_id'] = $courseId;
                $courseDetailsList[$key]['duration'] = $this->Courses_model->getCoursesDurationData($where2, '', 0, 0);
                // print_r($courseDetailsList[$key]['duration']);
                // die;
                foreach ($courseDetailsList[$key]['duration'] as $key2 => $value2) {
                    $packege_subscribe = calcuateDate($user_id, $value['courses_id'], 0, 0, $value2['duration_id']);
                    // print_r($packege_subscribe);
                    // die;
                    if ($packege_subscribe) {

                        if ($packege_subscribe['is_expired']) {

                            $courseDetailsList[$key]['duration'][$key2]['is_subscribe'] = 0;
                            // $courseList[$key]['duration'][$key2]['package_plan'] = [];
                        } else {
                            $courseDetailsList[$key]['duration'][$key2]['is_subscribe'] = 1;
                            // $sub[0] = $packege_subscribe;
                            // $courseList[$key]['duration'][$key2]['package_plan'] = $sub;
                        }
                    } else {
                        // $getPackage_id = $this->CommonModel->getData('tbl_courses_packages', array('courses_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id']), 'package_id');

                        // if ($getPackage_id) {
                        //     foreach ($getPackage_id as $key1 => $value1) {
                        //         $packege_subscribe1 = calcuateDate($user_id, $value['courses_id'], 0, $value1['package_id'], 0);
                        //         //    print_r($packege_subscribe1);die;
                        //         if ($packege_subscribe1) {
                        //             $courseList[$key]['duration'][$key2]['is_subscribe'] = 1;
                        //             if (isset($packege_subscribe1['courses'][0])) {
                        //                 $courseList[$key]['duration'][$key2]['package_plan'] = $packege_subscribe1['courses'][0];
                        //             } else {
                        //                 $courseList[$key]['duration'][$key2]['package_plan'] = [];
                        //             }
                        //         } else {
                        //             $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
                        //             $courseList[$key]['duration'][$key2]['package_plan'] = [];
                        //         }
                        //     }
                        // } else {
                        $courseDetailsList[$key]['duration'][$key2]['is_subscribe'] = 0;
                        // $courseDetailsList[$key]['duration'][$key2]['package_plan'] = [];
                        // }
                    }
                }
                $courseSection = $this->Courses_model->getSectionData($courseId);

                $courseDetailsList[$key]['sections'] = $courseSection;
                $courseResourse = $this->Courses_model->getCourseResourse($courseId);
                $courseDetailsList[$key]['resources'] = $courseResourse;
                foreach ($courseSection as $key1 => $value1) {
                    $watch_count = 0;
                    $where1['l.section_id'] = $value1['section_id'];
                    $courseSectionLesson = $this->Courses_model->getLessonsData($courseId, $value1['section_id'], '');
                    foreach ($courseSectionLesson as $key2 => $lessonList) {
                        if ($key2 == 0) {
                            $courseSectionLesson[$key2]['is_lock_lesson'] = 0;
                        } else {
                            $view_previous = array();
                            $view_previous = $this->Common_model->getData('tbl_lesson_user_video', array('user_id' => $user_id, 'view_video' => 1, 'lesson_id' => $courseSectionLesson[$key2 - 1]['lesson_id'], 'status' => 1), '', '', 'row_array', 'id', 'desc');
                            // $view_previous = $this->Common_model->getData('tbl_lesson_user_video', array('user_id' => $user_id, 'view_video' => 1, 'lesson_id' => $lessonList['lesson_id'], 'status' => 1), '', '', 'row_array', 'id', 'desc');
                            // echo $this->db->last_query();
                            // die;
                            // $courseSectionLesson[$key2]['is_lock_lesson_query'] = $this->db->last_query();
                            //if(count(is_countable($view_previous)?$view_previous:[])){
                            if (!empty($view_previous)) {

                                if (is_null($view_previous['solved_mcq']) && is_null($view_previous['result'])) {
                                    //  $lessonList[$key2]['asas1']=1;
                                    $courseSectionLesson[$key2]['is_lock_lesson'] = 1;
                                } else {
                                    //   $lessonList[$key2]['asas1']=2;
                                    $courseSectionLesson[$key2]['is_lock_lesson'] = 0;
                                    $watch_count++;
                                }
                            } else {
                                $courseSectionLesson[$key2]['is_lock_lesson'] = 1;
                            }
                        }
                    }
                    $courseDetailsList[$key]['sections'][$key1]['lessons'] = $courseSectionLesson;
                    $courseDetailsList[$key]['sections'][$key1]['lesson_count'] = count($courseSectionLesson);
                    $courseDetailsList[$key]['sections'][$key1]['lesson_watch_count'] = $watch_count;
                }
            }
            if ($courseDetailsList) {
                $response['result'] = true;
                $response['message'] = "Course details found";
                $response['course_details_list'] = $courseDetailsList;
                $response['course_path'] = base_url() . COURSE_IMAGES;
                $response['resourse_path'] = base_url() . COURSE_RESOURCES;
            } else {
                $response['result'] = false;
                $response['message'] = "No Course details found";
            }
        } else {
            $response['result'] = false;
            $response['message'] = 'Invalid Input';
        }
        echo json_encode($response);
    }

    public function getLessonsDetails()
    {
        authenticateUser();
        $response = array();

        $lessonId = trim($this->input->post('lesson_id')) ? trim($this->input->post('lesson_id')) : 0;
        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : 0;

        $lesson_view = $this->Common_model->getData('tbl_lesson_user_video', array('lesson_id' => $lessonId, 'user_id' => $user_id), 'view_video,solved_mcq,result,id', '', 'row_array');
        if ($lessonId && $user_id) {
            $where = array();

            if ($lessonId) {
                $where['tl.id'] = $lessonId;
            }
            $lessonDetails = $this->Courses_model->getLessonsData('', '', $lessonId);
            // Show Exam Flag
            if (isset($lesson_view['view_video']) && $lesson_view['view_video'] == 1) {
                $lessonDetails[0]['show_exam'] = true;
            } else {
                $lessonDetails[0]['show_exam'] = false;
            }


            // Already Test Submitted Flag
            if (
                empty($lesson_view) ||
                (
                    is_null($lesson_view['solved_mcq'] ?? null) &&
                    is_null($lesson_view['result'] ?? null)
                )
            ) {
                $lessonDetails[0]['already_test_submitted'] = false; // Not submitted
                $lessonDetails[0]['result_id'] = null;
            } else {
                $lessonDetails[0]['already_test_submitted'] = true; // Submitted
                $lessonDetails[0]['result_id'] = $lessonDetails[0]['lesson_id'];
            }
            //print_r($courseDetailsList);die();
            foreach ($lessonDetails as $key => $value) {
                $lessonVideo = $this->Courses_model->getLessonVideoData($lessonId);

                $lessonSubTitle = $this->Courses_model->getLessonSubTitleData($lessonId);
                $lessonDetails[$key]['lesson_video'] = $lessonVideo;
                $lessonDetails[$key]['lesson_sub_title'] = $lessonSubTitle;
            }
            if ($lessonDetails) {
                $response['lesson_details_list'] = $lessonDetails;

                $response['result'] = true;
                $response['message'] = "Lesson Details found";
                $response['video_thumbnail_path'] = base_url() . VIDEO_IMAGES;
            } else {
                $response['result'] = false;
                $response['message'] = "No Lesson Details found";
            }
        } else {
            $response['result'] = false;
            $response['message'] = 'Invalid Input';
        }
        echo json_encode($response);
    }

    public function getLessons()
    {
        authenticateUser();
        $response = array();
        $course_id = trim($this->input->post('course_id')) ? trim($this->input->post('course_id')) : 0;
        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : "";
        $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : "";
        $page     = $this->input->post('page_no') ? $this->input->post('page_no') : 1;

        if ($user_id) {

            if ($page) {
                $limit = 50;
                $offset = ($page - 1) * $limit;
            } else {
                $limit = 0;
                $offset = 0;
            }
            $where = array();
            if ($course_id) {
                $where['l.course_id'] = $course_id;
            }
            $count = count($this->Courses_model->getLessonData($where, $search, 0, 0));
            $lessonList = $this->Courses_model->getLessonData($where, $search, $limit, $offset);
            $courseView = $this->Courses_model->getLessonUserViewData(array('courses_id' => $course_id, 'view_video' => 1, 'user_id' => $user_id));
            // echo  $this->db->last_query();
            $packege_subscribe = calcuateDate($user_id, $course_id, 0, 0, 0);
            $response['packege_subscribe_last_query'] = $this->db->last_query();
            if ($lessonList) {

                foreach ($lessonList as $key2 => $value2) {

                    if ($key2 == 0) {
                        $lessonList[$key2]['is_lock_lesson'] = 0;
                    } else {
                        $view_previous = array();
                        //  $view_previous = $this->CommonModel->getData('tbl_lesson_user_video', array('courses_id' =>$course_id,'user_id'=>$user_id,'view_video' => 1,'lesson_id'=> $lessonList[$key2-1]['lesson_id']),'','','num_rows');
                        //  $view_previous = $this->CommonModel->getData('tbl_lesson_user_video', array('courses_id' =>$course_id,'user_id'=>$user_id,'view_video' => 1,'lesson_id'=> $lessonList[$key2-1]['lesson_id'],'status'=>1),'','','row_array');

                        $view_previous = $this->Common_model->getData('tbl_lesson_user_video', array('user_id' => $user_id, 'view_video' => 1, 'lesson_id' => $lessonList[$key2 - 1]['lesson_id'], 'status' => 1), '', '', 'row_array', 'id', 'desc');
                        $lessonList[$key2]['is_lock_lesson_query'] = $this->db->last_query();
                        //if(count(is_countable($view_previous)?$view_previous:[])){
                        if (!empty($view_previous)) {

                            if (is_null($view_previous['solved_mcq']) && is_null($view_previous['result'])) {
                                //  $lessonList[$key2]['asas1']=1;
                                $lessonList[$key2]['is_lock_lesson'] = 1;
                            } else {
                                //   $lessonList[$key2]['asas1']=2;
                                $lessonList[$key2]['is_lock_lesson'] = 0;
                            }
                        } else {
                            $lessonList[$key2]['is_lock_lesson'] = 1;
                        }
                    }
                    if ($course_id == 18) {
                        $lessonList[$key2]['is_lock_lesson'] = 0;
                    }

                    $getCheck = $this->Common_model->getData('tbl_lesson_video', array('lesson_id' =>  $lessonList[$key2]['lesson_id'], 'courses_id' => $course_id), 'is_this_video_final', '', 'row_array');
                    //check is final video if yes francjies give access to usee only that case last exam submit
                    if (isset($getCheck['is_this_video_final']) && $getCheck['is_this_video_final'] == 1) {
                        //add to 
                        $getCheckFlag = array();
                        $getCheckFlag = $this->Common_model->getData('tbl_lesson_user_final_exam', array('courses_id' =>  $course_id, 'user_id' => $user_id), 'is_show_final_exam_btn', '', 'row_array');
                        if (isset($getCheckFlag['is_show_final_exam_btn']) && $getCheckFlag['is_show_final_exam_btn'] != 1 || empty($getCheckFlag)) {
                            $lessonList[$key2]['is_lock_lesson'] = 1;
                        }
                        $lessonList[$key2]['is_final_exam_btn'] = 1;
                    } else {
                        $lessonList[$key2]['is_final_exam_btn'] = 0;
                    }


                    //only for testing
                    //     $lessonList[$key2]['is_lock_lesson']=0;

                    // print_r($packege_subscribe);
                    if ($packege_subscribe) {
                        // print_r($packege_subscribe);
                        $lessonList[$key2]['is_subscribe'] = 1;
                        //   $packege_subscribe[0]=$packege_subscribe;
                        $lessonList[$key2]['package_plan'][] = $packege_subscribe;
                        //print_r($courseList);die();
                    } else {
                        $lessonList[$key2]['is_subscribe'] = 0;
                        $lessonList[$key2]['package_plan'] = [];
                    }
                }
                $response['lesson_list'] = $lessonList;
                $response['result'] = true;
                $response['reason'] = "lesson found";
                $response['video_path'] = base_url() . VIDEO_IMAGES;
            } else {
                $response['result'] = false;
                $response['reason'] = "No Category found";
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Invalid Input';
        }
    }

    // public function getQuestionAnswerList()
    // {
    //     authenticateUser();
    //     // echo "1";
    //     // die;
    //     $login_user_id = $this->regId;
    //     // echo $login_user_id;
    //     // die;
    //     $page      = (int) $this->input->post('page') ?: 1;
    //     $per_page  = (int) $this->input->post('per_page') ?: 10;
    //     $offset = ($page - 1) * $per_page;
    //     $response = array();
    //     $course_id = trim($this->input->post('course_id')) ? trim($this->input->post('course_id')) : '';
    //     if (empty($course_id)) {
    //         $response['result'] = false;
    //         $response['message'] = 'Invalid Input';
    //         echo json_encode($response);
    //         die;
    //     }
    //     $getQuestionAnswersListing = $this->Courses_model->getQuestionAnswersData($course_id, $login_user_id, $per_page, $offset);
    //     $total_records = $result['total'];
    //     $response['result'] = true;
    //     $response['message'] = "Q&A List Fectched Successfully";
    //     $response['image_path'] = base_url() . USER_IMAGES;
    //     $response['data'] = $getQuestionAnswersListing;
    //     $response['pagination'] = [
    //         'total_records' => $total_records,
    //         'total_pages'   => ceil($total_records / $per_page),
    //         'current_page'  => $page,
    //         'per_page'      => $per_page
    //     ];
    //     echo json_encode($response);
    // }
    public function getQuestionAnswerList()
    {
        authenticateUser();

        $login_user_id = $this->regId;
        $response = array();

        $course_id = trim($this->input->post('course_id')) ?: '';
        $page      = (int) $this->input->post('page') ?: 1;
        $per_page  = (int) $this->input->post('per_page') ?: 10;

        if (empty($course_id)) {
            $response['result'] = false;
            $response['message'] = 'Invalid Input';
            echo json_encode($response);
            return;
        }

        $offset = ($page - 1) * $per_page;

        $result = $this->Courses_model
            ->getQuestionAnswersData($course_id, $login_user_id, $per_page, $offset);

        $total_records = $result['total'];

        $response['result'] = true;
        $response['message'] = "Q&A List Fetched Successfully";
        $response['image_path'] = base_url() . USER_IMAGES;
        $response['data'] = $result['questions'];

        $response['pagination'] = [
            'total_records' => $total_records,
            'total_pages'   => ceil($total_records / $per_page),
            'current_page'  => $page,
            'per_page'      => $per_page
        ];

        echo json_encode($response);
    }
    public function createQnA()
    {
        authenticateUser();
        $login_user_id = $this->regId;


        $course_id = trim($this->input->post('course_id'));
        $question  = trim($this->input->post('question'));

        if (empty($course_id) || empty($question)) {
            $response = [
                'result' => false,
                'message' => 'Invalid Input'
            ];
            echo json_encode($response);
            return;
        }
        $questionData = [
            'course_id' => $course_id,
            'question' => $question,
            'user_id' => $login_user_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $login_user_id,
        ];
        $insert = $this->CommonModel->iudAction('tbl_course_qna', $questionData, 'insert');
        if (!$insert) {
            $response = [
                'result' => false,
                'message' => 'Question Creation Failed'
            ];
            echo json_encode($response);
            return;
        }
        $response = [
            'result' => true,
            'message' => 'Question Added Successfully',

        ];
        echo json_encode($response);
        return;
    }
    public function courseResources()
    {
        authenticateUser();
        $login_user_id = $this->regId;
        $course_id = trim($this->input->post('course_id'));
        if (empty($course_id)) {
            $response = [
                'result' => false,
                'message' => 'Course Id is required'
            ];
            echo json_encode($response);
            return;
        }
        $course_resoureses = $this->CommonModel->getData('tbl_course_resources', ['course_id' => $course_id], 'file_notes AS file_name, file', '', 'result_array');

        $response = [
            'result' => true,
            'message' => 'Course Resources Fetched Successfully',
            'data' => $course_resoureses,
            'resource_path' => base_url() . COURSE_RESOURCES
        ];
        echo json_encode($response);
        return;
    }

    public function addCourseReview()
    {
        authenticateUser();

        $user_id   = $this->regId; // logged in user id
        $course_id = trim($this->input->post('course_id'));
        $rate      = trim($this->input->post('rate'));
        $review    = trim($this->input->post('review'));

        $chekec_course_id = $this->CommonModel->getData('tbl_courses', ['id' => $course_id], 'id', '', 'row_array');
        if (empty($chekec_course_id)) {
            echo json_encode([
                'result'  => false,
                'message' => 'Invalid Course id'
            ]);
            return;
        }
        // Validation
        if (empty($course_id)) {
            echo json_encode([
                'result'  => false,
                'message' => 'Course id is required'
            ]);
            return;
        }

        if (empty($rate)) {
            echo json_encode([
                'result'  => false,
                'message' => 'Rating is required'
            ]);
            return;
        }

        if ($rate < 1 || $rate > 5) {
            echo json_encode([
                'result'  => false,
                'message' => 'Rating must be between 1 to 5'
            ]);
            return;
        }

        if (empty($review)) {
            echo json_encode([
                'result'  => false,
                'message' => 'Review is required'
            ]);
            return;
        }

        $insertData = [
            'user_id'    => $user_id,
            'course_id'  => $course_id,
            'rate'       => $rate,
            'review'     => $review,
            'created_at' => date('Y-m-d H:i:s'),

        ];

        $insert = $this->CommonModel->iudAction(
            'tbl_order_courses_review',
            $insertData,
            'insert'
        );

        if ($insert) {
            $response = [
                'result'  => true,
                'message' => 'Review added successfully'
            ];
        } else {
            $response = [
                'result'  => false,
                'message' => 'Something went wrong'
            ];
        }

        echo json_encode($response);
        return;
    }

    public function updateCourseReview()
    {
        authenticateUser();

        $user_id   = $this->regId;
        $review_id = trim($this->input->post('review_id'));
        $rate      = trim($this->input->post('rate'));
        $review    = trim($this->input->post('review'));

        if (empty($review_id)) {
            echo json_encode([
                'result' => false,
                'message' => 'Review id is required'
            ]);
            return;
        }

        if (empty($rate)) {
            echo json_encode([
                'result' => false,
                'message' => 'Rating is required'
            ]);
            return;
        }

        if ($rate < 1 || $rate > 5) {
            echo json_encode([
                'result' => false,
                'message' => 'Rating must be between 1 to 5'
            ]);
            return;
        }

        if (empty($review)) {
            echo json_encode([
                'result' => false,
                'message' => 'Review is required'
            ]);
            return;
        }

        // Check review exists
        $check = $this->CommonModel->getData(
            'tbl_order_courses_review',
            [
                'id' => $review_id,
                'user_id' => $user_id,
                'deleted_by' => NULL
            ],
            'id',
            '',
            'row_array'
        );

        if (empty($check)) {
            echo json_encode([
                'result' => false,
                'message' => 'Review not found'
            ]);
            return;
        }

        $updateData = [
            'rate'       => $rate,
            'review'     => $review,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => $user_id
        ];

        $update = $this->CommonModel->iudAction(
            'tbl_order_courses_review',
            $updateData,
            'update',
            ['id' => $review_id]
        );

        if ($update) {
            $response = [
                'result' => true,
                'message' => 'Review updated successfully'
            ];
        } else {
            $response = [
                'result' => false,
                'message' => 'Nothing changed or update failed'
            ];
        }

        echo json_encode($response);
    }
    public function deleteCourseReview()
    {
        authenticateUser();

        $user_id   = $this->regId;
        $review_id = trim($this->input->post('review_id'));

        if (empty($review_id)) {
            echo json_encode([
                'result' => false,
                'message' => 'Review id is required'
            ]);
            return;
        }

        // Check review exists
        $check = $this->CommonModel->getData(
            'tbl_order_courses_review',
            [
                'id' => $review_id,
                'user_id' => $user_id,
                'deleted_by' => NULL
            ],
            'id',
            '',
            'row_array'
        );

        if (empty($check)) {
            echo json_encode([
                'result' => false,
                'message' => 'Review not found'
            ]);
            return;
        }

        $deleteData = [
            'deleted_by' => $user_id,
            'deleted_at' => date('Y-m-d H:i:s')
        ];

        $delete = $this->CommonModel->iudAction(
            'tbl_order_courses_review',
            $deleteData,
            'update',
            ['id' => $review_id]
        );

        if ($delete) {
            $response = [
                'result' => true,
                'message' => 'Review deleted successfully'
            ];
        } else {
            $response = [
                'result' => false,
                'message' => 'Delete failed'
            ];
        }

        echo json_encode($response);
    }
    public function courseReviewList()
    {
        authenticateUser();

        $user_id   = $this->regId;
        $course_id = trim($this->input->post('course_id'));
        $page      = trim($this->input->post('page')) ?: 1;
        $limit     = trim($this->input->post('limit')) ?: 10;

        if (empty($course_id)) {
            echo json_encode([
                'result' => false,
                'message' => 'Course id is required'
            ]);
            return;
        }
        $check_course = $this->CommonModel->getData(
            'tbl_courses',
            ['id' => $course_id],
            'id',
            '',
            'row_array'
        );

        if (empty($check_course)) {
            echo json_encode([
                'result' => false,
                'message' => 'Invalid course id'
            ]);
            return;
        }
        $offset = ($page - 1) * $limit;

        $data  = $this->Courses_model->getCourseReviewList($course_id, $limit, $offset, 'list');
        $total = $this->Courses_model->getCourseReviewList($course_id, 0, 0, 'count');

        // Add is_my_review flag
        if (!empty($data)) {
            foreach ($data as &$row) {
                $row['is_my_review'] = ($row['user_id'] == $user_id) ? true : false;
            }
        }

        $total_pages = ($limit > 0) ? ceil($total / $limit) : 1;

        $response = [
            'result'       => true,
            'message'      => 'Course review list fetched successfully',
            'data'         => $data,
            'total'        => $total,
            'total_pages'  => $total_pages,
            'page'         => (int)$page,
            'limit'        => (int)$limit,
            'user_image_path' => base_url(USER_IMAGES)
        ];

        echo json_encode($response);
    }


    public function getMcqQuestionDetails()
    {
        authenticateUser();
        $response = array();

        $lesson_id = trim($this->input->post('lesson_id')) ? trim($this->input->post('lesson_id')) : 0;

        if ($lesson_id) {
            $where = array();

            if ($lesson_id) {
                $where['lesson_id'] = $lesson_id;
            }
            // die();
            $no_of_question = $this->CommonModel->getData('tbl_lesson', array('id' => $lesson_id), 'no_of_question,exam_duration', '', 'row_array');
            $count = count($this->Courses_model->getLessonVideoMCQData($where, '', 0, 0, '', $no_of_question['no_of_question']));
            $questionDetailsList = $this->Courses_model->getLessonVideoMCQData($where, '', 0, 0, '', $no_of_question['no_of_question']);

            if ($questionDetailsList) {
                $response['result'] = true;
                $response['reason'] = "Lesson found";
                $response['lesson_id'] = $lesson_id;
                $response['no_of_question'] = $no_of_question['no_of_question'];
                $response['exam_duration'] = $no_of_question['exam_duration'];
                $response['question_list'] = $questionDetailsList;
                // $response['mcq_instructions '] = MCQ_VIDEO_INSTRUCTIONS;


                // $response['course_path'] = base_url() . COURSE_IMAGES;
            } else {
                $response['result'] = false;
                $response['reason'] = "No Question found";
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Invalid Input';
        }
        echo json_encode($response);
    }

    public function getPackages()
    {
        authenticateUser();
        $response = array();
        //  $categoryId = trim($this->input->post('category_id')) ? trim($this->input->post('category_id')) : 0;
        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : "";
        $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : "";
        $page     = $this->input->post('page_no') ? $this->input->post('page_no') : 1;

        if ($user_id) {
            if ($page) {
                $limit = 50;
                $offset = ($page - 1) * $limit;
            } else {
                $limit = 0;
                $offset = 0;
            }
            $where = array();

            $where['category_id'] = 0;
            $where['c.status'] = ACTIVE;


            $count = count($this->Courses_model->getPackagesData($where, $search, 0, 0));
            $courseList = $this->Courses_model->getPackagesData($where, $search, $limit, $offset);
            //      echo $this->db->last_query();
            if ($courseList) {
                foreach ($courseList as $key => $package) {
                    // $courseList[$key]['package123']=$package['package_id'];
                    $packege_subscribe = calcuateDate($user_id, 0, 0, $package['package_id']);

                    $courseList[$key]['query'] = $this->db->last_query();
                    if ($packege_subscribe) {
                        $courseList[$key]['is_subscribe'] = 1;
                        $courseList[$key]['package_plan'] = $packege_subscribe;
                    } else {
                        $courseList[$key]['is_subscribe'] = 0;
                        $courseList[$key]['package_plan'] = [];
                    }
                    $rating = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 3, 'course_id' => $package['package_id'], 'active' => 1), 'AVG(rate) as avg,count(review) as no_of_review');
                    if ($rating) {
                        $avg = ($rating[0]['avg']) ? $rating[0]['avg'] : 0;
                        $courseList[$key]['avg_rating'] = round($avg, 2);
                        $courseList[$key]['no_of_review'] = $rating[0]['no_of_review'];
                    } else {
                        $courseList[$key]['avg_rating'] = 0;
                        $courseList[$key]['no_of_review'] = 0;
                    }
                    $review = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 3, 'course_id' => $package['package_id'], 'active' => 1));
                    if ($review) {
                        $courseList[$key]['review'] = $review;
                    } else {
                        $courseList[$key]['review'] = array();
                    }
                }
                $response['package_list'] = $courseList;
                $response['result'] = true;
                $response['reason'] = "Courses found";
                $response['course_path'] = base_url() . COURSE_IMAGES;
            } else {
                $response['result'] = false;
                $response['reason'] = "No Category found";
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Invalid Input';
        }
        echo json_encode($response);
    }

    public function getPackagesDetails()
    {
        authenticateUser();
        $response = array();

        $package_id = trim($this->input->post('package_id')) ? trim($this->input->post('package_id')) : 0;
        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : 0;

        if ($package_id && $user_id) {
            $where = array();

            if ($package_id) {
                $where['c.id'] = $package_id;
                $where['c.category_id'] = 0;
            }
            $where['c.status'] = ACTIVE;

            $count = count($this->Courses_model->getPackagesData($where, '', 0, 0));
            $packageDetailsList = $this->Courses_model->getPackagesData($where, '', 0, 0);
            //print_r($courseDetailsList);die();
            foreach ($packageDetailsList as $key => $value) {
                $where1['cp.package_id'] = $value['package_id'];
                $coursesDetails = $this->Courses_model->getPackagesCourseData($where1, '', 0, 0);
                foreach ($coursesDetails as $key2 => $value2) {
                    $packege_subscribe = array();
                    $packege_subscribe = calcuateDate($user_id, $value2['id'], 0, $package_id);
                    if ($packege_subscribe) {
                        //print_r($package[0]['courses']);die();
                        $coursesDetails[$key2]['is_subscribe'] = 1;
                        $coursesDetails[$key2]['end_date'] = $packege_subscribe['courses'][0]['end_date'];
                        $coursesDetails[$key2]['reamining_no_days'] = $packege_subscribe['courses'][0]['reamining_no_days'];
                        $coursesDetails[$key2]['is_expired'] = $packege_subscribe['courses'][0]['is_expired'];
                        $packageDetailsList[$key]['courses'] = $coursesDetails;
                    } else {
                        $coursesDetails[$key2]['is_subscribe'] = 0;
                        $coursesDetails[$key2]['end_date'] = '';
                        $coursesDetails[$key2]['reamining_no_days'] = '';
                        $coursesDetails[$key2]['is_expired'] = 0;
                        $packageDetailsList[$key]['courses'] = $coursesDetails;
                    }
                }
                $rating = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 3, 'course_id' => $value['package_id'], 'active' => 1), 'AVG(rate) as avg,count(review) as no_of_review');
                if ($rating) {
                    $avg = ($rating[0]['avg']) ? $rating[0]['avg'] : 0;
                    $packageDetailsList[$key]['avg_rating'] = round($avg, 2);
                    $packageDetailsList[$key]['no_of_review'] = $rating[0]['no_of_review'];
                } else {
                    $packageDetailsList[$key]['avg_rating'] = 0;
                    $packageDetailsList[$key]['no_of_review'] = 0;
                }
                $review = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 3, 'course_id' => $value['package_id'], 'active' => 1));
                if ($review) {
                    $packageDetailsList[$key]['review'] = $review;
                } else {
                    $packageDetailsList[$key]['review'] = array();
                }
            }

            if ($packageDetailsList) {
                $response['course_package_details_list'] = $packageDetailsList;
                $response['result'] = true;
                $response['reason'] = "Package found";
                $response['course_path'] = base_url() . COURSE_IMAGES;
            } else {
                $response['result'] = false;
                $response['reason'] = "No Package found";
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Invalid Input';
        }
        echo json_encode($response);
    }

    public function getMyPackages()
    {
        authenticateUser();
        $response = array();
        //  $categoryId = trim($this->input->post('category_id')) ? trim($this->input->post('category_id')) : 0;
        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : "";
        $search = trim($this->input->post('search')) ? trim($this->input->post('search')) : "";
        $page     = $this->input->post('page_no') ? $this->input->post('page_no') : 1;

        if ($user_id) {
            if ($page) {
                $limit = 50;
                $offset = ($page - 1) * $limit;
            } else {
                $limit = 0;
                $offset = 0;
            }
            $where = array();

            $where['category_id'] = 0;
            if ($user_id) {
                $where['o.user_id'] = $user_id;
            }

            $count = count($this->Courses_model->getMyPackagesData($where, $search, 0, 0));
            $courseList = $this->Courses_model->getMyPackagesData($where, $search, $limit, $offset);
            if ($courseList) {
                foreach ($courseList as $key => $package) {
                    // print_r(calcuateDate($user_id,0,0,$package['package_id']));die();
                    $packege_subscribe = calcuateDate($user_id, 0, 0, $package['package_id']);
                    if ($packege_subscribe) {
                        $courseList[$key]['is_subscribe'] = 1;
                        $courseList[$key]['package_plan'] = $packege_subscribe;
                    } else {
                        $courseList[$key]['is_subscribe'] = 0;
                        $courseList[$key]['package_plan'] = [];
                    }
                }
                $response['package_list'] = $courseList;
                $response['result'] = true;
                $response['reason'] = "Courses found";
                $response['course_path'] = base_url() . COURSE_IMAGES;
            } else {
                $response['result'] = false;
                $response['reason'] = "No Category found";
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Invalid Input';
        }
        echo json_encode($response);
    }

    private function getCourseRating($course_id)
    {
        $rating = $this->CommonModel->getData(
            'tbl_order_courses_review',
            [
                'course_id'  => $course_id,
                'deleted_by' => NULL
            ],
            'AVG(rate) as avg_rating, COUNT(id) as no_of_review'
        );

        if (!empty($rating)) {

            $avg = ($rating[0]['avg_rating']) ? $rating[0]['avg_rating'] : 0;

            return [
                'course_rating'   => round($avg, 2),
                'no_of_review' => (int)$rating[0]['no_of_review']
            ];
        }

        return [
            'course_rating'   => 0,
            'no_of_review' => 0
        ];
    }
}