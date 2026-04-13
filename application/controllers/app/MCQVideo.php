<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MCQVideo extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('app/Courses_model');
        $this->load->model('app/MCQ_model');

        $this->load->model('app/Common_model');
    }

    public function getResultMCQ()
    {
        authenticateUser();

        // echo "<pre>";
        // print_r(json_encode($this->input->post()));
        // die;
        $response = array();
        $userId   = $this->regId;
        // $userId = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : '';
        $lesson_id = trim($this->input->post('lesson_id')) ? trim($this->input->post('lesson_id')) : '';
        //get question 
        $solved_mcq = ($this->input->post('solved_mcq')) ? ($this->input->post('solved_mcq')) : '';
        $solved_duration = ($this->input->post('solved_duration')) ? ($this->input->post('solved_duration')) : '';
        // print_r($solved_mcq);
        // die;
        // print_r($_POST);
        // die;
        if ($solved_mcq != "" && $lesson_id) {
            $already_submitted_test = $this->Common_model->getData('tbl_lesson_user_video', array('lesson_id' => $lesson_id, 'user_id' => $userId), 'solved_mcq,result', '', 'row_array', 'id', 'desc');
            if (isset($already_submitted_test['solved_mcq']) && !empty($already_submitted_test['solved_mcq'])) {
                $response['result'] = false;
                $response['reason'] = 'You have already submitted the test for this lesson';
                echo json_encode($response);
                exit;
            }

            // $getlesson = $this->Common_model->getData('tbl_lesson', array('id' => $lesson_id), 'courses_id,section_id,is_this_video_final', '', 'row_array');
            $getlesson = $this->Common_model->getData('tbl_lesson', array('id' => $lesson_id), 'course_id,section_id,is_final_lesson', '', 'row_array');
            // print_r($getlesson);
            // die;
            if ($getlesson) {
                //print_r($solved_mcq);
                $mcq = json_decode($solved_mcq, true);
                // print_r($mcq);
                // die();
                $questions_ids = [];
                $total_question = $correct_question = $wrong_question = 0;
                foreach ($mcq as $key => $value) {
                    // 	json array [{q_id:1,actual_ans:1,user_ans:3}] 
                    if ($value['q_id'] && $value['actual_ans'] && $value['user_ans']) {
                        $total_question++;
                        $questions_ids[] = $value['q_id'];
                        if ($value['actual_ans'] == $value['user_ans']) {
                            $correct_question++;
                        } else {
                            $wrong_question++;
                        }
                    }
                }
                // //result json[{total_question: solved_question: wrong_question}] 
                $result_mcq = array('total_question' => $total_question, 'correct_question' => $correct_question, 'wrong_question' => $wrong_question);
                $result_mcq_json = json_encode($result_mcq);

                //calaute marks
                $total_marks = $correct_question * VIDEO_QUESTION_CORRECT_PER_MARK;

                //  $percentage=($total_marks/$getMcq['total_marks'])*100;
                //  $final_percentage=number_format((float)$percentage, 2, '.', '');  

                $getlessonVideoMCQ = array();
                $getlessonVideoMCQ = $this->Common_model->getData('tbl_lesson_user_video', array('status' => 1, 'lesson_id' => $lesson_id, 'user_id' => $userId), '', '', 'row_array', 'id', 'desc');

                // $getFranchiseId = $this->Common_model->getData('tbl_users', array('id' => $userId), 'franchise_id,web_franchise_user_id ', '', 'row_array');
                // // echo $this->db->last_query();die;
                // if (isset($getFranchiseId['franchise_id']) && isset($getFranchiseId['web_franchise_user_id'])) {
                //     $franchise_id = $getFranchiseId['franchise_id'];
                //     $web_franchise_user_id = $getFranchiseId['web_franchise_user_id'];
                // } else {
                //     $franchise_id = NULL;
                //     $web_franchise_user_id = NULL;
                // }


                $no_of_question = $this->CommonModel->getData('tbl_lesson', array('id' => $lesson_id), 'no_of_question', '', 'row_array');
                $insArr = array(
                    // 'courses_id' => $getlesson['courses_id'],
                    // 'lesson_id' => $getlesson['lesson_id'],
                    // 'lesson_video_id' => $lesson_video_id,
                    // 'view_video' => 1,
                    // 'user_id' => $userId,
                    'solved_mcq' => $solved_mcq,
                    'result' => $result_mcq_json,
                    'total_marks' => $total_marks,
                    'no_of_question' => $no_of_question['no_of_question'],
                    'solved_duration' => $solved_duration,
                );

                // echo $userId;
                // print_r($insArr);die;
                if (isset($getlessonVideoMCQ) && !empty($getlessonVideoMCQ)) {
                    $insArr['updated_by'] = $userId;
                    $insArr['updated_at'] = date('Y-m-d H:i:s');
                    $insRes = $this->Common_model->iudAction('tbl_lesson_user_video', $insArr, 'update', array('id' => $getlessonVideoMCQ['id']));
                    //  if(empty($getlessonVideoMCQ['solved_mcq']) || $getlessonVideoMCQ['solved_mcq']==''){
                    // $insRes = $this->Common_model->iudAction('tbl_lesson_user_video', $insArr, 'update',array('id'=>$getlessonVideoMCQ['id']));
                    //   $insRes=$getlessonVideoMCQ['id'];
                    // }else{
                    // $insRes = $this->Common_model->iudAction('tbl_lesson_user_video', $insArr, 'insert');
                    //}  
                    $insRes = $getlessonVideoMCQ['id'];
                } else {
                    $insRes = $this->Common_model->iudAction('tbl_lesson_user_video', $insArr, 'insert');
                }

                //$insRes = $this->Common_model->iudAction('tbl_lesson_user_video', $insArr, 'insert');
                if ($lesson_id) {
                    $where['lesson_id'] = $lesson_id;
                }
                if ($insRes) {
                    $out_of_marks = $no_of_question['no_of_question'] * VIDEO_QUESTION_CORRECT_PER_MARK;
                    $percentage = ($total_marks / $out_of_marks) * 100;
                    $final_percentage = number_format((float)$percentage, 2, '.', '');
                    $result_mcq['total_marks'] = $total_marks;
                    $result_mcq['out_of_marks'] = $out_of_marks;
                    $result_mcq['percentage'] = $final_percentage;

                    $response['result'] = true;
                    $response['reason'] = 'Test Submitted Sucessfully';
                    $response['mcq_result'] = $result_mcq;
                    //   print_r($questions_ids);
                    $response['mcq_question_set'] = $this->Courses_model->getLessonVideoMCQData($where, '', 0, 0, $questions_ids);

                    // add  result in Post Wall
                    //  $total_marks=$correct_question*VIDEO_QUESTION_CORRECT_PER_MARK;

                    // $insPostArr = array(
                    //     'post_type' => POST_TYPE_LESSON_VIDEO,
                    //     'ref_id' => $insRes,
                    //     'user_id' => $userId,
                    //     'result' => $result_mcq_json,
                    //     'total_marks' => $total_marks,
                    //     'out_of_marks' => $out_of_marks,
                    //     'percentage' => $final_percentage,
                    //     'solved_duration' => $solved_duration,
                    //     'is_active' => 1,
                    //     'privacy' => ONLY_ME_PRIVACY,
                    // );

                    // $post_id1 = $this->Common_model->iudAction('tbl_post', $insPostArr, 'insert');

                    //this video is final send certificate to mail
                    // if ($getlesson['is_this_video_final'] == 1) {
                    //     $this->Common_model->iudAction('tbl_lesson_user_final_exam', array('final_exam_done' => 1, 'updated_by' => $userId, 'updated_at' => date('Y-m-d H:i:s')), 'update', array('user_id' => $userId, 'franchise_id' => $franchise_id, 'courses_id' => $getlesson['courses_id']));
                    //     send_final_exam_certificate($post_id1);
                    // }
                    // print_r($getlesson);
                    // die;

                    // echo($this->db->last_query());die();


                    // Certficate Generation for final exam


                    if (isset($getlesson['is_final_lesson']) && $getlesson['is_final_lesson'] == 1) {
                        save_final_exam_certificate($lesson_id, $userId);
                    }
                } else {
                    $response['result'] = false;
                    $response['reason'] = 'Something went wrong, please try later';
                }
            } else {
                $response['result'] = false;
                $response['reason'] = 'Invalid Lesson Video';
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Invalid Input';
        }
        echo json_encode($response);
    }

    public function update_view_video()
    {
        authenticateUser();
        $login_user_id = $this->regId;
        $response = array();
        $lesson_video_id = trim($this->input->post('lesson_video_id')) ? trim($this->input->post('lesson_video_id')) : '';
        //get question 
        // print_r($this->input->post());
        // die;
        // print_r($login_user_id);
        // echo "<br>";
        if ($lesson_video_id) {
            $getlesson = $this->Common_model->getData('tbl_lesson_video', array('id' => $lesson_video_id), 'courses_id,section_id,lesson_id', '', 'row_array');


            // print_r($getlesson);
            // echo "<br>";
            // print_r($lesson_count);
            // echo "<br>";
            // print_r($lesson_video_view_count);
            // die;
            if ($getlesson) {
                //print_r($solved_mcq);

                $total_question = $correct_question = $wrong_question = 0;
                $user_video_view = $this->Common_model->getData('tbl_lesson_user_video_view', ['courses_id' => $getlesson['courses_id'], 'section_id' => $getlesson['section_id'], 'lesson_id' => $getlesson['lesson_id'], 'lesson_video_id' => $lesson_video_id, 'user_id' => $login_user_id], 'id', '', 'row_array');
                if (empty($user_video_view)) {
                    $insert_video_flag =  $this->Common_model->iudAction(
                        'tbl_lesson_user_video_view',
                        ['courses_id' => $getlesson['courses_id'], 'section_id' => $getlesson['section_id'], 'lesson_id' => $getlesson['lesson_id'], 'lesson_video_id' => $lesson_video_id, 'view_video' => 1, 'user_id' => $login_user_id, 'created_by' => $login_user_id, 'created_at' => date('Y-m-d H:i:s')],
                        'insert'
                    );
                } else {
                    $insert_video_flag =  $this->Common_model->iudAction(
                        'tbl_lesson_user_video_view',
                        ['view_video' => 1, 'updated_by' => $login_user_id, 'updated_at' => date('Y-m-d H:i:s')],
                        'update',
                        ['courses_id' => $getlesson['courses_id'], 'section_id' => $getlesson['section_id'], 'lesson_id' => $getlesson['lesson_id'], 'lesson_video_id' => $lesson_video_id, 'user_id' => $login_user_id]
                    );
                }

                $user_lesson_video_view = $this->Common_model->getData(
                    'tbl_lesson_user_video',
                    [
                        'courses_id' => $getlesson['courses_id'],
                        'section_id' => $getlesson['section_id'],
                        'lesson_id'  => $getlesson['lesson_id'],
                        'user_id'    => $login_user_id
                    ],
                    'id',
                    '',
                    'row_array'
                );
                $lesson_count = $this->Common_model->getData('tbl_lesson_video', ['courses_id' => $getlesson['courses_id'], 'section_id' => $getlesson['section_id'], 'lesson_id' => $getlesson['lesson_id']], 'count(id) as total_video', '', 'row_array');
                //    echo $this->db->last_query();
                $lesson_video_view_count = $this->Common_model->getData('tbl_lesson_user_video_view', ['courses_id' => $getlesson['courses_id'], 'section_id' => $getlesson['section_id'], 'lesson_id' => $getlesson['lesson_id'], 'user_id' => $login_user_id, 'view_video' => 1], 'count(id) as total_video_view', '', 'row_array');
                $view = 0;
                if ($lesson_count['total_video'] == $lesson_video_view_count['total_video_view']) {
                    $view = 1;
                }

                if (empty($user_lesson_video_view)) {


                    $this->Common_model->iudAction(
                        'tbl_lesson_user_video',
                        [
                            'courses_id' => $getlesson['courses_id'],
                            'section_id' => $getlesson['section_id'],
                            'lesson_id'  => $getlesson['lesson_id'],
                            'view_video' => $view,
                            'user_id'    => $login_user_id,
                            'created_by' => $login_user_id,
                            'created_at' => date('Y-m-d H:i:s')
                        ],
                        'insert'
                    );
                } else {


                    $this->Common_model->iudAction(
                        'tbl_lesson_user_video',
                        [
                            'view_video' => $view,
                            'updated_by' => $login_user_id,
                            'updated_at' => date('Y-m-d H:i:s')
                        ],
                        'update',
                        [
                            'courses_id' => $getlesson['courses_id'],
                            'section_id' => $getlesson['section_id'],
                            'lesson_id'  => $getlesson['lesson_id'],
                            'user_id'    => $login_user_id
                        ]
                    );
                }
                $lesson_view = $this->Common_model->getData('tbl_lesson_user_video', array('lesson_id' => $getlesson['lesson_id'], 'user_id' => $login_user_id), 'view_video', '', 'row_array');



                if ($insert_video_flag) {
                    $response['result'] = true;
                    $response['reason'] = 'Video view updated successfully';
                } else {
                    $response['result'] = false;
                    $response['reason'] = 'Something went wrong, please try later';
                }
                if (isset($lesson_view['view_video']) && $lesson_view['view_video'] == 1) {
                    $response['show_exam'] = true;
                } else {
                    $response['show_exam'] = false;
                }
            } else {
                $response['result'] = false;
                $response['reason'] = 'Invalid Lesson Video';
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Invalid Input';
        }
        echo json_encode($response);
    }

    public function getSolvedvideoMCQ()
    {
        authenticateUser();
        $response = array();
        $login_user_id = $this->regId;
        // $userId = trim($this->input->post('user_id')) ? trim($this->input->post('user_id')) : '';
        $lesson_id = trim($this->input->post('lesson_id')) ? trim($this->input->post('lesson_id')) : '';

        if ($login_user_id != "") {
            $where['cr.user_id'] = $login_user_id;
            if ($lesson_id) {
                $where['cr.lesson_id'] = $lesson_id;
            }
            $getDataChallenge = $this->MCQ_model->getUserVideoMCQData($where);

            foreach ($getDataChallenge as $key => $value) {
                // $getRank = $this->MCQ_model->getRankIdVidoMCQData($value['final_percentage']);
                // if ($getRank) {
                //     $getDataChallenge[$key]['message'] = $getRank['message'];
                //     $getDataChallenge[$key]['badges_image'] = $getRank['badges_image'];
                // } else {
                //     $getDataChallenge[$key]['message'] = '';
                //     $getDataChallenge[$key]['badges_image'] = '';
                // }
            }

            if ($getDataChallenge) {
                $response['result'] = true;
                $response['reason'] = 'Solved lesson MCQ fetched successfully';
                $response['video_mcq_list'] = $getDataChallenge;
                // $response['badges_image_path'] = base_url() . UPLOAD_PATH_BADGES;
            } else {
                $response['result'] = false;
                $response['reason'] = 'No solved lesson MCQ found';
            }
        } else {
            $response['result'] = false;
            $response['reason'] = 'Invalid Input';
        }
        echo json_encode($response);
    }
}