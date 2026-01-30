<?php

/**
 * 
 */
class Video extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'CourseModel');
        $this->load->model(ADMIN . 'VideoModel');
        loginId();
    }

    /*********************************************************************/
    //  QMR

    public function index()
    {
        $data['title'] = 'Lesson Master';
        $data['active'] = 'Lesson Master';
        $this->load->view(ADMIN . VIDEO . 'list-video', $data);
    }



    public function lesson_list()
    {

        $data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];

        $course_id = isset($data['course_id']) ? $data['course_id'] : 0;
        $course_view_type = isset($data['course_view_type']) ? $data['course_view_type'] : 0;


        $count = count($this->CourseModel->getLessonData($searchVal, 0, 0, 0, 0, $course_id));
        // print_r($count);die;
        if ($count) {
            $lessonData = $this->CourseModel->getLessonData($searchVal, $sortColIndex, $sortBy, $limit, $offset, $course_id);

            foreach ($lessonData as $key => $lesson) {

                $row = [];

                array_push($row, $offset + ($key + 1));
                $title = '<a href="' . base_url() . 'admin/Lesson/view/' . $lesson['id'] . '">' . $lesson['title'] . '</a>';
                array_push($row, $title);
                if ($course_view_type) {
                    $edit_updateTradeQty = '<div contenteditable class="updateDataTable" data-id="' . $lesson["id"] . '" data-column="sort_by">' . $lesson["sort_by"] . '</div>';
                    array_push($row, $edit_updateTradeQty);
                } else {
                    array_push($row, $lesson['course_name']);
                }


                array_push($row, $lesson['duration']);
                array_push($row, $lesson['price']);
                //array_push($row, $lesson['lesson_type']);
                if ($lesson['status']) {
                    $status = '<span class="badge badge-success ">Active</span>';
                } else {
                    $status = '<span class="badge badge-danger ">Not Active</span>';
                }
                array_push($row, $status);
                $alert = "confirm('Do you want to delete this record?');";
                /*	$action = '
            	<a class="btn btn-success btn-sm waves-effect waves-light" href="'.base_url().'admin/Lesson/Lesson/'.$lesson['id'].'" role="button"><i class="fas fa-edit"></i></a>
            	<a class="btn btn-danger btn-sm waves-effect waves-light" href="'.base_url().'admin/Course/CourseLessonDelete/'.$lesson['course_id'].'/'.$lesson['id'].'" role="button" onclick="return '.$alert.'" ><i class="fas fa-trash-alt"></i></a>';
                array_push($row, $action);*/
                $action = '
            	<a class="btn btn-success btn-sm waves-effect waves-light" href="' . base_url() . 'admin/Lesson/Lesson/' . $lesson['id'] . '" role="button"><i class="fas fa-edit"></i></a>';
                array_push($row, $action);
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
    public function courseLessonEdit()
    {
        $id = $this->input->post('id');

        if ($id) {
            if ($data = $this->CourseModel->getLessonData('', 0, '', 0, 0, 0, $id)) {
                //	echo $this->db->last_query();die();
                $response['lesson'] = $data;
                $response['status'] = true;
            } else {
                $response['status'] = false;
                $response['reason'] = "Error, lesson Data not found";
            }
        }
        echo json_encode($response);
    }


    public function Lesson($id = '')
    {
        if (!$this->input->post()) {
            if ($id) {
                //print_r($id);die;
                $data['title'] = 'Edit Lesson';
                $data['lesson'] = $this->CourseModel->getLessonData('', 0, 0, 0, 0, 0, $id);
                $data['video_master'] = $this->CourseModel->getLessonVideoListData('', 0, 0, 0, 0, $id);
            } else {
                $data['title'] = 'Add Lesson';
            }
            $data['active'] = 'Lesson';
            $data['course'] = $this->CommonModel->getData('tbl_courses', array('status' => 1, 'category_id !=' => 0, 'deleted_by' => NULL));
            $data['duration'] = $this->CommonModel->getData('tbl_duration_master', array('deleted_by' => NULL));
            //  print_r($data['duration']);die;

            $this->load->view(ADMIN . LESSON . 'Lesson', $data);
        } else {
            $video_thumbnail = '';
            $post = $this->input->post();
            //	echo"<pre>";
            //	 print_r($_FILES);die;
            if (isset($_FILES['lesson']['name'])) {
                //   print_r($_FILES['name']);
                $result = fileUploadForRepeter(VIDEO_IMAGES, 'lesson', 'video_thumbnail');
                // print_r($result);
                if ($result['status'] == true) {
                    $video_thumbnail = $result['image_name'];
                }
            }
            //	    print_r($video_thumbnail);die;
            //   die;
            if ($post) {

                $sort_number = $this->CommonModel->getData('tbl_lesson', array('course_id' => $post['course_id']), 'max(sort_by) as sort_by', '', 'row_array');
                if (!empty($sort_number['sort_by']) && isset($sort_number['sort_by'])) {
                    $number = $sort_number['sort_by'] + 1;
                } else {
                    $number = 1;
                }

                $lesson = array(
                    'title'  => $post['title'],
                    'course_id'   => $post['course_id'],
                    'benefits'   => $post['benefits'],
                    'language'      => $post['language'],
                    'importance' => $post['importance'],
                    // 'duration_id'  => $post['duration_id'],
                    // 'price'   => $post['price'],
                    //  'offer_type'   => $post['offer_type'],
                    //  'offer_amount'   => $post['offer_amount'],
                    //   'strike_thr_price'   => $post['strike_thr_price'],
                    'status'            => $post['status'],
                    'sort_by' => $number
                );


                if (empty($post['id'])) {


                    $d_id = $this->CommonModel->iudAction('tbl_lesson', $lesson, 'insert');

                    if ($d_id) {

                        foreach ($post['lesson'] as $key => $value) {

                            $video = $post['lesson'][$key];

                            $video_master = array(
                                'title'   => $video['title'],
                                'duration'   => $video['duration'],
                                'video_type'   => $video['video_type'],
                                //'video_url'   => $video['video_url'],
                                // 'video_url_for_mobile_application'   => $video['video_url_for_mobile_application'],
                                'video_vimeo_code' => $video['video_vimeo_code'],
                                //   'video_thumbnail'=>$video_thumbnail[$key]
                            );

                            if (isset($video_thumbnail[$key])) {
                                $video_master['video_thumbnail'] = $video_thumbnail[$key];
                            }

                            $vt_id = $this->CommonModel->iudAction('tbl_video_master', $video_master, 'insert');
                            $lesson_video = array(
                                'lesson_id'   => $d_id,
                                'courses_id'   => $lesson['course_id'],
                                'video_id'   => $vt_id,
                                'language'   => $lesson['language'],
                                'status'   => $lesson['status'],
                                'no_of_question' => $video['no_of_question'],
                                'exam_duration' => $video['exam_duration'],
                                'is_this_video_final' => $video['is_this_video_final']
                            );

                            $vm_id = $this->CommonModel->iudAction('tbl_lesson_video', $lesson_video, 'insert');
                        }
                        redirect(base_url(ADMIN . 'Lesson/view/' . $d_id));
                        $this->session->set_flashdata('success', 'Courses added successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Error! fail to add vendor');
                    }
                } else {
                    $where = array('id' => $post['id']);
                    unset($lesson['sort_by']);

                    $this->CommonModel->iudAction('tbl_lesson', $lesson, 'update', $where);
                    if (isset($post['lesson'])) {
                        foreach ($post['lesson'] as $key => $value) {

                            $video = $post['lesson'][$key];

                            $video_master = array(
                                'title'   => $video['title'],
                                'duration'   => $video['duration'],
                                'video_type'   => $video['video_type'],
                                //'video_url'   => $video['video_url'],
                                //'video_url_for_mobile_application'   => $video['video_url_for_mobile_application'],
                                'video_vimeo_code' => $video['video_vimeo_code'],
                                //    'video_thumbnail'=>$video_thumbnail[$key]
                            );

                            if (isset($video_thumbnail[$key])) {
                                $video_master['video_thumbnail'] = $video_thumbnail[$key];
                            }
                            //  print_r($video_master);die;
                            if (isset($video['id']) && $video['id'] != '') {
                                $this->CommonModel->iudAction('tbl_video_master', $video_master, 'update', array('id' => $video['id']));
                                $v_id = $video['id'];
                                $lesson_video = array(
                                    'language'   => $lesson['language'],
                                    'status'   => $lesson['status'],
                                    'no_of_question' => $video['no_of_question'],
                                    'exam_duration' => $video['exam_duration'],
                                    'is_this_video_final' => $video['is_this_video_final']
                                );
                                //print_r($lesson_video);die;
                                $vm_id = $this->CommonModel->iudAction('tbl_lesson_video', $lesson_video, 'update', array('lesson_id' => $post['id'], 'video_id' => $v_id));
                                //    echo $this->db->last_query();die;
                            } else {
                                $v_id = $this->CommonModel->iudAction('tbl_video_master', $video_master, 'insert');
                                $lesson_video = array(
                                    'lesson_id'   => $post['id'],
                                    'courses_id'   => $lesson['course_id'],
                                    'video_id'   => $v_id,
                                    'language'   => $lesson['language'],
                                    'status'   => $lesson['status'],
                                    'no_of_question' => $video['no_of_question'],
                                    'exam_duration' => $video['exam_duration'],
                                    'is_this_video_final' => $video['is_this_video_final']
                                );

                                $vm_id = $this->CommonModel->iudAction('tbl_lesson_video', $lesson_video, 'insert');
                            }
                        }
                    } else {
                        // $this->CommonModel->iudAction('tbl_video_master', '','delete', array('courses_id' => $post['id']));
                    }
                    $this->session->set_flashdata('success', 'Lesson update successfully');
                    redirect(base_url(ADMIN . 'Lesson/view/' . $post['id']));
                }
            }

            redirect(base_url(ADMIN . 'Lesson'));
        }
    }
    public function addVideo($id = '')
    {
        if (!$this->input->post()) {
            if ($id) {
                //print_r($id);die;
                $data['title'] = 'Edit Lesson';
                $data['lesson'] = $this->CourseModel->getLessonData('', 0, 0, 0, 0, 0, $id);
                $data['video_master'] = $this->CourseModel->getLessonVideoListData('', 0, 0, 0, 0, $id);
            } else {
                $data['title'] = 'Add Lesson';
            }
            $data['active'] = 'Lesson';
            $data['course'] = $this->CommonModel->getData('tbl_courses', array('status' => 1, 'category_id !=' => 0, 'deleted_by' => NULL));
            $data['duration'] = $this->CommonModel->getData('tbl_duration_master', array('deleted_by' => NULL));
            //  print_r($data['duration']);die;

            $this->load->view(ADMIN . VIDEO . 'video-form', $data);
        } else {
            $video_thumbnail = '';
            $post = $this->input->post();
            //	echo"<pre>";
            //	 print_r($_FILES);die;
            if (isset($_FILES['lesson']['name'])) {
                //   print_r($_FILES['name']);
                $result = fileUploadForRepeter(VIDEO_IMAGES, 'lesson', 'video_thumbnail');
                // print_r($result);
                if ($result['status'] == true) {
                    $video_thumbnail = $result['image_name'];
                }
            }
            //	    print_r($video_thumbnail);die;
            //   die;
            if ($post) {

                $sort_number = $this->CommonModel->getData('tbl_lesson', array('course_id' => $post['course_id']), 'max(sort_by) as sort_by', '', 'row_array');
                if (!empty($sort_number['sort_by']) && isset($sort_number['sort_by'])) {
                    $number = $sort_number['sort_by'] + 1;
                } else {
                    $number = 1;
                }

                $lesson = array(
                    'title'  => $post['title'],
                    'course_id'   => $post['course_id'],
                    'benefits'   => $post['benefits'],
                    'language'      => $post['language'],
                    'importance' => $post['importance'],
                    // 'duration_id'  => $post['duration_id'],
                    // 'price'   => $post['price'],
                    //  'offer_type'   => $post['offer_type'],
                    //  'offer_amount'   => $post['offer_amount'],
                    //   'strike_thr_price'   => $post['strike_thr_price'],
                    'status'            => $post['status'],
                    'sort_by' => $number
                );


                if (empty($post['id'])) {


                    $d_id = $this->CommonModel->iudAction('tbl_lesson', $lesson, 'insert');

                    if ($d_id) {

                        foreach ($post['lesson'] as $key => $value) {

                            $video = $post['lesson'][$key];

                            $video_master = array(
                                'title'   => $video['title'],
                                'duration'   => $video['duration'],
                                'video_type'   => $video['video_type'],
                                //'video_url'   => $video['video_url'],
                                // 'video_url_for_mobile_application'   => $video['video_url_for_mobile_application'],
                                'video_vimeo_code' => $video['video_vimeo_code'],
                                //   'video_thumbnail'=>$video_thumbnail[$key]
                            );

                            if (isset($video_thumbnail[$key])) {
                                $video_master['video_thumbnail'] = $video_thumbnail[$key];
                            }

                            $vt_id = $this->CommonModel->iudAction('tbl_video_master', $video_master, 'insert');
                            $lesson_video = array(
                                'lesson_id'   => $d_id,
                                'courses_id'   => $lesson['course_id'],
                                'video_id'   => $vt_id,
                                'language'   => $lesson['language'],
                                'status'   => $lesson['status'],
                                'no_of_question' => $video['no_of_question'],
                                'exam_duration' => $video['exam_duration'],
                                'is_this_video_final' => $video['is_this_video_final']
                            );

                            $vm_id = $this->CommonModel->iudAction('tbl_lesson_video', $lesson_video, 'insert');
                        }
                        redirect(base_url(ADMIN . 'Lesson/view/' . $d_id));
                        $this->session->set_flashdata('success', 'Courses added successfully');
                    } else {
                        $this->session->set_flashdata('error', 'Error! fail to add vendor');
                    }
                } else {
                    $where = array('id' => $post['id']);
                    unset($lesson['sort_by']);

                    $this->CommonModel->iudAction('tbl_lesson', $lesson, 'update', $where);
                    if (isset($post['lesson'])) {
                        foreach ($post['lesson'] as $key => $value) {

                            $video = $post['lesson'][$key];

                            $video_master = array(
                                'title'   => $video['title'],
                                'duration'   => $video['duration'],
                                'video_type'   => $video['video_type'],
                                //'video_url'   => $video['video_url'],
                                //'video_url_for_mobile_application'   => $video['video_url_for_mobile_application'],
                                'video_vimeo_code' => $video['video_vimeo_code'],
                                //    'video_thumbnail'=>$video_thumbnail[$key]
                            );

                            if (isset($video_thumbnail[$key])) {
                                $video_master['video_thumbnail'] = $video_thumbnail[$key];
                            }
                            //  print_r($video_master);die;
                            if (isset($video['id']) && $video['id'] != '') {
                                $this->CommonModel->iudAction('tbl_video_master', $video_master, 'update', array('id' => $video['id']));
                                $v_id = $video['id'];
                                $lesson_video = array(
                                    'language'   => $lesson['language'],
                                    'status'   => $lesson['status'],
                                    'no_of_question' => $video['no_of_question'],
                                    'exam_duration' => $video['exam_duration'],
                                    'is_this_video_final' => $video['is_this_video_final']
                                );
                                //print_r($lesson_video);die;
                                $vm_id = $this->CommonModel->iudAction('tbl_lesson_video', $lesson_video, 'update', array('lesson_id' => $post['id'], 'video_id' => $v_id));
                                //    echo $this->db->last_query();die;
                            } else {
                                $v_id = $this->CommonModel->iudAction('tbl_video_master', $video_master, 'insert');
                                $lesson_video = array(
                                    'lesson_id'   => $post['id'],
                                    'courses_id'   => $lesson['course_id'],
                                    'video_id'   => $v_id,
                                    'language'   => $lesson['language'],
                                    'status'   => $lesson['status'],
                                    'no_of_question' => $video['no_of_question'],
                                    'exam_duration' => $video['exam_duration'],
                                    'is_this_video_final' => $video['is_this_video_final']
                                );

                                $vm_id = $this->CommonModel->iudAction('tbl_lesson_video', $lesson_video, 'insert');
                            }
                        }
                    } else {
                        // $this->CommonModel->iudAction('tbl_video_master', '','delete', array('courses_id' => $post['id']));
                    }
                    $this->session->set_flashdata('success', 'Lesson update successfully');
                    redirect(base_url(ADMIN . 'Lesson/view/' . $post['id']));
                }
            }

            redirect(base_url(ADMIN . 'Lesson'));
        }
    }
    public function Video($id = '', $vm_id = '')
    {

        if (!$this->input->post()) {
            if ($id) {
                $data['video'] = $this->VideoModel->getvideoData('', 0, 0, 0, 0, $id);
            }
            $data['title'] = 'Add video';
            $data['active'] = 'video';
            $data['vm_id'] = $vm_id;
            //$data['video_categories'] = $this->CommonModel->get('video_categories');			 


            $this->load->view(ADMIN . VIDEO . 'video', $data);
        } else {

            $post_data = $this->input->post();
            //print_r($vm_id);die;
            if (!$post_data['id']) {
                //$post_data['created_by']=loginId();


                if ($id = $this->CommonModel->iudAction('tbl_video_master', $post_data, 'insert')) {
                    //print_r($vm_id);die;
                    $where = array('id' => $vm_id);
                    $video_id = $id;
                    $this->CommonModel->iudAction('tbl_lesson_video', array('video_id' => $video_id), 'update', $where);
                    //print_r($this->db->last_query());die;			
                    $this->session->set_flashdata('success', 'videos added successfully');
                } else {
                    $this->session->set_flashdata('error', 'Error! fail to add vendor');
                }
            } else {
                $where = array('id' => $post_data['id']);

                $rid = $this->CommonModel->iudAction('video_details', $post_data, 'update', $where);
                if ($rid) {

                    $this->session->set_flashdata('success', 'videos updated successfully');
                } else {
                    $this->session->set_flashdata('error', 'Error! fail to update videos');
                }
            }
            redirect(base_url(ADMIN . 'Lesson'));
        }
    }

    public function LessonDelete($id)
    {
        $where = array('id' => $id);

        if ($this->CommonModel->iudAction('course', '', 'delete', $where)) {

            $this->session->set_flashdata('success', 'Course deleted successfully');
            redirect(ADMIN . 'Course');
        } else {
            $this->session->set_flashdata('error', 'Error! fail to delete Site');
            redirect(ADMIN . 'Course');
        }
    }


    public function CourseSectionDelete($course_id, $id)
    {
        $where = array('id' => $id);

        if ($this->CommonModel->iudAction('section', '', 'delete', $where)) {

            $this->session->set_flashdata('success', 'Section deleted successfully');
            redirect(base_url(ADMIN . 'Course/viewCourse/' . $course_id));
        } else {
            $this->session->set_flashdata('error', 'Error! fail to delete Site');
            redirect(base_url(ADMIN . 'Course/viewCourse/' . $course_id));
        }
    }

    public function CourseLessonDelete($course_id, $id)
    {
        $where = array('id' => $id);

        if ($this->CommonModel->iudAction('lesson', '', 'delete', $where)) {

            $this->session->set_flashdata('success', 'lesson deleted successfully');
            redirect(base_url(ADMIN . 'Course/viewCourse/' . $course_id));
        } else {
            $this->session->set_flashdata('error', 'Error! fail to delete Site');
            redirect(base_url(ADMIN . 'Course/viewCourse/' . $course_id));
        }
    }


    public function viewLesson($id)
    {
        if ($id) {
            $data['course'] = $this->CourseModel->getCourseDetail($id);
            $data['section'] = $this->CommonModel->get('section', array('course_id' => $id));

            $data['title'] = 'Course';
            $data['active'] = 'Course';
            $sort_number = $this->CourseModel->getMaxOrderNumber($id);

            if (!empty($sort_number) && isset($sort_number)) {
                $number = $sort_number[0]['sort_number'] + 1;
            } else {
                $number = 1;
            }
            $sort_number1 = $this->CourseModel->getMaxLessonOrderNumber($id);

            if (!empty($sort_number1) && isset($sort_number1)) {
                $number1 = $sort_number1[0]['sort_number1'] + 1;
            } else {
                $number1 = 1;
            }
            $data['number_section'] = $number;
            $data['number_lesson'] = $number1;

            //	echo "<pre>";
            //print_r($data);die();
            $this->load->view(ADMIN . COURSE . 'course-detail-view', $data);
        } else {
            $this->session->set_flashdata('error', 'Error! Course not found');
            redirect(ADMIN . 'Course');
        }
    }

    public function courseSection($value = '')
    {


        $post_data = $this->input->post();
        if (!$post_data['id']) {

            if ($id = $this->CommonModel->iudAction('section', $post_data, 'insert')) {

                $this->session->set_flashdata('success', 'section added successfully');
            } else {
                $this->session->set_flashdata('error', 'Error! fail to add vendor');
            }
        } else {
            $where = array('id' => $post_data['id']);

            $rid = $this->CommonModel->iudAction('section', $post_data, 'update', $where);
            if ($rid) {

                $this->session->set_flashdata('success', 'section updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Error! fail to update Courses');
            }
        }
        redirect(base_url(ADMIN . 'Course/viewCourse/' . $post_data['course_id']));
    }
    public function courseLesson($value = '')
    {

        $post_data = $this->input->post();
        if (!$post_data['id']) {

            $post_data1 = array(
                'title' => $post_data['title'],
                'duration' => $post_data['duration'],
                'course_id' => $post_data['course_id'],
                'section_id' => $post_data['section_id'],
                'video_type' => $post_data['video_type'],
                'video_url' => $post_data['video_url'],
                'date_added' => time(),
                'lesson_type' => $post_data['lesson_type'],
                'summary' => $post_data['summary'],
                'order' => $post_data['order'],
                'video_type_for_mobile_application' => $post_data['video_url'],
                'video_url_for_mobile_application' => $post_data['video_url'],
                'duration_for_mobile_application' => $post_data['video_url'],
            );


            if (!empty($_FILES['image']['name'])) {

                if (!empty($_FILES['image']['name'])) {
                    $banner_image = $_FILES['image']['name'];
                }

                $uploadStatus = myUpload(UPLOAD_PATH_LESSON, 'image');

                $imagePath = $uploadStatus['data']['file_name'];
                $post_data1['attachment'] = $imagePath;
            }
            if ($id = $this->CommonModel->iudAction('lesson', $post_data1, 'insert')) {

                $this->session->set_flashdata('success', 'lesson added successfully');
            } else {
                $this->session->set_flashdata('error', 'Error! fail to add vendor');
            }
        } else {
            $where = array('id' => $post_data['id']);
            $post_data1 = array(
                'title' => $post_data['title'],
                'duration' => $post_data['duration'],
                'section_id' => $post_data['section_id'],
                'video_type' => $post_data['video_type'],
                'video_url' => $post_data['video_url'],
                'last_modified' => time(),
                'lesson_type' => $post_data['lesson_type'],
                'summary' => $post_data['summary'],
                'order' => $post_data['order'],
                'video_type_for_mobile_application' => $post_data['video_url'],
                'video_url_for_mobile_application' => $post_data['video_url'],
                'duration_for_mobile_application' => $post_data['video_url'],
            );
            if (!empty($_FILES['image']['name'])) {

                if (!empty($_FILES['image']['name'])) {
                    $banner_image = $_FILES['image']['name'];
                }

                $uploadStatus = myUpload(UPLOAD_PATH_LESSON, 'image');

                $imagePath = $uploadStatus['data']['file_name'];
                $post_data1['attachment'] = $imagePath;
            }

            $rid = $this->CommonModel->iudAction('lesson', $post_data1, 'update', $where);
            if ($rid) {

                $this->session->set_flashdata('success', 'lesson updated successfully');
            } else {
                $this->session->set_flashdata('error', 'Error! fail to update Courses');
            }
        }
        redirect(base_url(ADMIN . 'Course/viewCourse/' . $post_data['course_id']));
    }
    public function listVideolist()
    {
        $data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];

        $v_id = $this->input->post('v_id');

        $where = array();

        // if($c_id){
        //     $where['ic.incidence_id'] = $c_id;
        // }
        //print_r($o_id);die;
        $count = count($this->CourseModel->getLessonVideoData($searchVal, 0, 0, 0, 0, $v_id, $where));
        //print_r($count);die;
        if ($count) {
            $result = $this->CourseModel->getLessonVideoData($searchVal, $sortColIndex, $sortBy, $limit, $offset, $v_id, $where);

            foreach ($result as $key => $value) {

                $row = [];
                array_push($row, $offset + ($key + 1));
                array_push($row, $value['title']);

                if ($value['language'] == 1) {
                    $status = '<span class="badge badge-danger ">English</span>';
                } else if ($value['language'] == 3) {
                    $status = '<span class="badge badge-danger ">Hindi</span>';
                } else {
                    $status = '<span class="badge badge-danger ">Marathi</span>';
                }

                array_push($row, $status);
                array_push($row, $value['duration']);
                $action1 = '<a class="btn btn-success waves-effect waves-light" href="' . base_url('admin/LessonVideoMcq/viewVideoMCQ/') . $value['lesson_id'] . "/" . $value['lesson_video_id'] . '"  role="button" >Question View</a>';
                array_push($row,  $action1);
                $action = '<a class=" waves-effect waves-light MCQCSVModal"  onclick="mcqModal(' . $value['id'] . ',' . $value['lesson_id'] . ')" data-lesson_video_id="' . $value['lesson_video_id'] . '" data-lesson_id="' . $value['lesson_id'] . '"   role="button" >Click Here Upload CSV..</a>';
                array_push($row, $action);
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
    public function view($_id)
    {
        //print_r($_id);die;
        $data['title'] = 'Lesson Details';
        $lesson = $this->CourseModel->getLessonData('', 0, 0, 0, 0, 0, $_id);

        // print_r($this->db->last_query());die;
        // print_r($video);die;
        if ($lesson) {
            $data['lesson'] = $lesson[0];
            $this->load->view(ADMIN . LESSON . 'table_video', $data);
        }
    }
    public function csvMCQModal()
    {
        $id = $this->input->post('id');
        $data['sub_title'] = 'Add MCQ';
        $data['lesson_video_id'] = $this->input->post('lesson_video_id');
        $data['lesson_id'] = $this->input->post('lesson_id');

        $html = $this->load->view(ADMIN . LESSON . 'modal_csv', $data, true);
        if ($html) {
            $response['html'] = $html;
            $response['result'] = true;
            $response['reason'] = 'Data Found';
        } else {
            $response['result'] = fasle;
            $response['reason'] = 'Something went to wrong!';
        }
        echo json_encode($response);
    }

    public function listMCQVideolist()
    {
        $data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];

        $lesson_id = $this->input->post('lesson_id');
        $lesson_video_id = $this->input->post('lesson_video_id');


        $where = array();

        if ($lesson_id) {
            $where['lv.lesson_id'] = $lesson_id;
        }
        if ($lesson_video_id) {
            $where['lv.lesson_video_id'] = $lesson_video_id;
        }
        //print_r($o_id);die;
        $count = count($this->CourseModel->getLessonVideoMCQData($searchVal, 0, 0, 0, 0, $where));
        //print_r($count);die;
        if ($count) {
            $result = $this->CourseModel->getLessonVideoMCQData($searchVal, $sortColIndex, $sortBy, $limit, $offset, $where);

            foreach ($result as $key => $value) {

                $row = [];
                array_push($row, $offset + ($key + 1));
                array_push($row, $value['skill_name']);
                array_push($row, $value['question']);
                array_push($row, "Option " . $value['answer']);
                array_push($row, $value['explantion']);
                array_push($row, $value['option_1']);
                array_push($row, $value['option_2']);
                array_push($row, $value['option_3']);
                array_push($row, $value['option_4']);
                array_push($row, $value['option_5']);
                if ($value['is_challenge'] == 1) {
                    $status = '<span class="badge badge-success ">Yes</span>';
                } else {
                    $status = '<span class="badge badge-primary ">No</span>';
                }
                array_push($row, $status);

                //   $action = '<a class=" waves-effect waves-light MCQCSVModal"  onclick="mcqModal('.$value['id'] .','.$value['lesson_id'] .')" data-lesson_video_id="'.$value['lesson_video_id'] .'" data-lesson_id="'.$value['lesson_id'] .'"   role="button" >Click Here..</a>';
                //    array_push($row, $action);
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

    public function viewVideoMCQ($lesson_id, $lesson_video_id)
    {
        //print_r($_id);die;
        $data['question'] = array();
        $data['lesson_id'] = $lesson_id;
        $data['lesson_video_id'] = $lesson_video_id;
        $this->load->view('admin/Lesson/not_import', $data);
    }

    public function lessonTypeUpdate()
    {
        if ($this->input->post()) {
            $id = $this->input->post('id');
            $value = $this->input->post('value');
            $column = $this->input->post('column');


            if ($id) {
                if ($this->CommonModel->iudAction('tbl_lesson', array($column => $value), 'update', array('id' => $id))) {

                    $reaponse['result'] = true;
                    $reaponse['reason'] = 'Lesson Sorting Updated Successfully';
                } else {
                    $reaponse['result'] = false;
                    $reaponse['reason'] = 'Error! fail to Lesson Sorting  Product Variant';
                }
            }
        }
        echo json_encode($reaponse);
    }
}
