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
        $response = array();
        $categoryId = trim($this->input->post('category_id')) ? trim($this->input->post('category_id')) : 0;
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
            if ($categoryId) {
                $where['category_id'] = $categoryId;
            }
            $where['c.status'] = ACTIVE;
            // $where['o.user_id'] = $user_id;
            //FRANCHISE
            $count = count($this->Courses_model->getFranchiseCoursesData($where, $search, 0, 0));
            $courseList = $this->Courses_model->getFranchiseCoursesData($where, $search, $limit, $offset);
            // echo "<pre>";
            // print_r($courseList);
            // die;
            $sub = array();
            foreach ($courseList as $key => $value) {

                $where2['cd.courses_id'] = $value['courses_id'];
                $courseList[$key]['duration'] = $this->Courses_model->getCoursesDurationData($where2, '', 0, 0);
                $rating = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 1, 'course_id' => $value['courses_id'], 'active' => 1), 'AVG(rate) as avg,count(review) as no_of_review');
                if ($rating) {
                    $avg = ($rating[0]['avg']) ? $rating[0]['avg'] : 0;
                    $courseList[$key]['avg_rating'] = round($avg, 2);
                    $courseList[$key]['no_of_review'] = $rating[0]['no_of_review'];
                } else {
                    $courseList[$key]['avg_rating'] = 0;
                    $courseList[$key]['no_of_review'] = 0;
                }
                $review = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 1, 'course_id' => $value['courses_id'], 'active' => 1));
                if ($review) {
                    $courseList[$key]['review'] = $review;
                } else {
                    $courseList[$key]['review'] = array();
                }
                foreach ($courseList[$key]['duration'] as $key2 => $value2) {
                    $packege_subscribe = calcuateDate($user_id, $value['courses_id'], 0, 0, $value2['duration_id']);

                    if ($packege_subscribe) {

                        if ($packege_subscribe['is_expired']) {
                            $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
                            $courseList[$key]['duration'][$key2]['package_plan'] = [];
                        } else {
                            $courseList[$key]['duration'][$key2]['is_subscribe'] = 1;
                            $sub[0] = $packege_subscribe;
                            $courseList[$key]['duration'][$key2]['package_plan'] = $sub;
                        }
                    } else {
                        $getPackage_id = $this->CommonModel->getData('tbl_courses_packages', array('courses_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id']), 'package_id');

                        if ($getPackage_id) {
                            foreach ($getPackage_id as $key1 => $value1) {
                                $packege_subscribe1 = calcuateDate($user_id, $value['courses_id'], 0, $value1['package_id'], 0);
                                //    print_r($packege_subscribe1);die;
                                if ($packege_subscribe1) {
                                    $courseList[$key]['duration'][$key2]['is_subscribe'] = 1;
                                    if (isset($packege_subscribe1['courses'][0])) {
                                        $courseList[$key]['duration'][$key2]['package_plan'] = $packege_subscribe1['courses'][0];
                                    } else {
                                        $courseList[$key]['duration'][$key2]['package_plan'] = [];
                                    }
                                } else {
                                    $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
                                    $courseList[$key]['duration'][$key2]['package_plan'] = [];
                                }
                            }
                        } else {
                            $courseList[$key]['duration'][$key2]['is_subscribe'] = 0;
                            $courseList[$key]['duration'][$key2]['package_plan'] = [];
                        }
                    }
                    $rating = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 1, 'course_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id'], 'active' => 1), 'AVG(rate) as avg,count(review) as no_of_review');
                    if ($rating) {
                        $avg = ($rating[0]['avg']) ? $rating[0]['avg'] : 0;
                        $courseList[$key]['duration'][$key2]['avg_rating'] = round($avg, 2);
                        $courseList[$key]['duration'][$key2]['no_of_review'] = $rating[0]['no_of_review'];
                    } else {
                        $courseList[$key]['duration'][$key2]['avg_rating'] = 0;
                        $courseList[$key]['duration'][$key2]['no_of_review'] = 0;
                    }
                    $review = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 1, 'course_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id'], 'active' => 1));
                    if ($review) {
                        $courseList[$key]['duration'][$key2]['review'] = $review;
                    } else {
                        $courseList[$key]['duration'][$key2]['review'] = array();
                    }
                }

                //check final exam
                // $getCheckFlag = $this->Common_model->getData('tbl_lesson_user_final_exam', array('courses_id' =>  $value['courses_id'], 'user_id' => $user_id), 'is_show_final_exam_btn,final_exam_done', '', 'row_array');
                // if (isset($getCheckFlag['is_show_final_exam_btn']) && $getCheckFlag['is_show_final_exam_btn'] != 1 || empty($getCheckFlag)) {
                //     $courseList[$key]['is_lock_lesson'] = 1;
                // } else {
                //     $courseList[$key]['is_lock_lesson'] = 0;
                // }
                // if (isset($getCheckFlag['final_exam_done'])) {
                //     $courseList[$key]['final_exam_done'] = $getCheckFlag['final_exam_done'];
                // } else {
                //     $courseList[$key]['final_exam_done'] = 0;
                // }
            }
            if ($courseList) {
                $response['course_list'] = $courseList;
                $response['result'] = true;
                $response['message'] = "Courses found";
                $response['course_path'] = base_url() . COURSE_IMAGES;
            } else {
                $response['result'] = false;
                $response['message'] = "No Category found";
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
            $where['c.status'] = ACTIVE;
            $count = count($this->Courses_model->getCoursesData($where, '', 0, 0));
            $courseDetailsList = $this->Courses_model->getCoursesData($where, '', 0, 0);
            //print_r($courseDetailsList);die();
            foreach ($courseDetailsList as $key => $value) {
                $where1['l.course_id'] = $value['courses_id'];
                $courseDetailsList[$key]['lesson'] = $this->Courses_model->getLessonData($where1, '', 0, 0);
                $where2['cd.courses_id'] = $value['courses_id'];
                $courseDetailsList[$key]['duration'] = $this->Courses_model->getCoursesDurationData($where2, '', 0, 0);
                $package_subscribe_flag = 0;
                foreach ($courseDetailsList[$key]['duration'] as $key2 => $value2) {

                    $packege_subscribe = calcuateDate($user_id, $value['courses_id'], 0, 0, $value2['duration_id']);

                    if ($packege_subscribe) {
                        $package_subscribe_flag = 1;
                        $courseDetailsList[$key]['duration'][$key2]['is_subscribe'] = 1;
                        $courseDetailsList[$key]['duration'][$key2]['package_plan'] = $packege_subscribe;
                    } else {
                        // $getPackage_id = $this->CommonModel->getData('tbl_courses_packages', array('courses_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id']), 'package_id');
                        // if (!empty($getPackage_id)) {

                        //     foreach ($getPackage_id as $key1 => $value1) {
                        //         //echo $value['courses_id']." ".$value1['package_id'];
                        //         $packege_subscribe1 = calcuateDate($user_id, $value['courses_id'], 0, $value1['package_id'], 0);
                        //         //  print_r($packege_subscribe1);die();
                        //         if ($packege_subscribe1) {
                        //             $package_subscribe_flag = 1;
                        //             $courseDetailsList[$key]['duration'][$key2]['is_subscribe'] = 1;
                        //             $courseDetailsList[$key]['duration'][$key2]['package_plan'] = $packege_subscribe1[0]['courses'];
                        //         } else {
                        //             $courseDetailsList[$key]['duration'][$key2]['is_subscribe'] = 0;
                        //             $courseDetailsList[$key]['duration'][$key2]['package_plan'] = [];
                        //         }
                        //     }
                        // } else {
                        $courseDetailsList[$key]['duration'][$key2]['is_subscribe'] = 0;
                        $courseDetailsList[$key]['duration'][$key2]['package_plan'] = [];
                        // }
                    }

                    $rating = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 1, 'course_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id'], 'active' => 1), 'AVG(rate) as avg,count(review) as no_of_review');
                    if ($rating) {
                        $avg = ($rating[0]['avg']) ? $rating[0]['avg'] : 0;
                        $courseDetailsList[$key]['duration'][$key2]['avg_rating'] = round($avg, 2);
                        $courseDetailsList[$key]['duration'][$key2]['no_of_review'] = $rating[0]['no_of_review'];
                    } else {
                        $courseDetailsList[$key]['duration'][$key2]['avg_rating'] = 0;
                        $courseDetailsList[$key]['duration'][$key2]['no_of_review'] = 0;
                    }
                    $review = $this->CommonModel->getData('tbl_order_courses_review', array('type' => 1, 'course_id' => $value2['courses_id'], 'courses_duration_id' => $value2['duration_id'], 'active' => 1));
                    if ($review) {
                        $courseDetailsList[$key]['duration'][$key2]['review'] = $review;
                    } else {
                        $courseDetailsList[$key]['duration'][$key2]['review'] = array();
                    }
                }
                $courseDetailsList[$key]['is_subscribe'] = $package_subscribe_flag;
            }
            if ($courseDetailsList) {
                $response['course_details_list'] = $courseDetailsList;
                $response['result'] = true;
                $response['reason'] = "Courses found";
                $response['course_path'] = base_url() . COURSE_IMAGES;
            } else {
                $response['result'] = false;
                $response['reason'] = "No Courses found";
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Invalid Input';
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
        echo json_encode($response);
    }

    public function getLessonsDetails()
    {
        authenticateUser();
        $response = array();
        $user_id = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : "";
        $lesson_id = trim($this->input->post('lesson_id')) ? trim($this->input->post('lesson_id')) : 0;

        if ($lesson_id && $user_id) {
            $where = array();

            if ($lesson_id) {
                $where['l.id'] = $lesson_id;
            }
            $count = count($this->Courses_model->getLessonData($where, '', 0, 0));
            $lessonDetailsList = $this->Courses_model->getLessonData($where, '', 0, 0);

            foreach ($lessonDetailsList as $key => $value) {

                $packege_subscribe = calcuateDate($user_id, $value['course_id'], 0, 0, 0);
                //print_r($packege_subscribe);   die();
                if ($packege_subscribe) {
                    $lessonDetailsList[$key]['is_subscribe'] = 1;
                    $packege_subscribe[0] = $packege_subscribe;
                    $lessonDetailsList[$key]['package_plan'] = $packege_subscribe[0];
                } else {
                    $lessonDetailsList[$key]['is_subscribe'] = 0;
                    $lessonDetailsList[$key]['package_plan'] = [];
                }

                $where1['lv.lesson_id'] = $value['lesson_id'];

                $lessonDetailsList[$key]['video'] = $this->Courses_model->getLessonVideoData($where1, '', 0, 0, '', $user_id);
                // $lessonDetailsList[$key]['video_query'] = $this->db->last_query();

            }
            if ($lessonDetailsList) {
                $response['lesson_details_list'] = $lessonDetailsList;
                $response['result'] = true;
                $response['reason'] = "Lesson found";
                $response['course_path'] = base_url() . COURSE_IMAGES;
                $response['video_path'] = base_url() . VIDEO_IMAGES;
            } else {
                $response['result'] = false;
                $response['reason'] = "No Lesson found";
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Invalid Input';
        }
        echo json_encode($response);
    }


    public function getMcqQuestionDetails()
    {
        authenticateUser();
        $response = array();

        $lesson_video_id = trim($this->input->post('lesson_video_id')) ? trim($this->input->post('lesson_video_id')) : 0;

        if ($lesson_video_id) {
            $where = array();

            if ($lesson_video_id) {
                $where['lesson_video_id'] = $lesson_video_id;
            }
            // die();
            $no_of_question = $this->CommonModel->getData('tbl_lesson_video', array('id' => $lesson_video_id), 'no_of_question', '', 'row_array');
            $count = count($this->Courses_model->getLessonVideoMCQData($where, '', 0, 0, '', $no_of_question['no_of_question']));
            $questionDetailsList = $this->Courses_model->getLessonVideoMCQData($where, '', 0, 0, '', $no_of_question['no_of_question']);

            if ($questionDetailsList) {
                $response['lesson_question_details_list'] = $questionDetailsList;
                $response['no_of_question'] = $no_of_question['no_of_question'];
                $response['mcq_instructions '] = MCQ_VIDEO_INSTRUCTIONS;

                $response['result'] = true;
                $response['reason'] = "Lesson found";
                $response['course_path'] = base_url() . COURSE_IMAGES;
            } else {
                $response['result'] = false;
                $response['reason'] = "No Lesson found";
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
}
