<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Courses_model
 * Check Duplication
 */

class Courses_model extends CI_Model
{
    function getCategoryData($parent_id = 0, $search = '')
    {
        $this->db->select('c.id,c.category_name');
        $this->db->from('tbl_categories c');
        $this->db->where('parent_id', $parent_id);
        $this->db->where('status', 1);
        $this->db->where('is_deleted', 0);
        $this->db->like('category_name', $search);
        $this->db->order_by('category_name', 'asc');
        $result = $this->db->get();
        return $result->result_array();
    }

    function getCoursesData($where = array(), $search = "", $limit = 0, $offset = 0, $where1 = "")
    {
        $this->db->select('c.*,c.id as courses_id,main.category_name as category_name,concat(u.first_name,u.last_name)as instructor_name,u.image as instructor_image ,u.email,u.mobile_no,(SELECT COUNT(DISTINCT `l`.`id`) FROM tbl_lesson as l WHERE `l`.`course_id` = `c`.`id` and `l`.`status`=1 )as no_of_lessons,(SELECT COUNT(DISTINCT `cd`.`id`) FROM tbl_courses_duration as cd WHERE `cd`.`courses_id` = `c`.`id` and `cd`.`status`=1 )as no_of_duration,sm.name as skill_name');
        $this->db->from('tbl_courses c');
        $this->db->join('tbl_categories main', 'main.id = c.category_id', 'left');
        $this->db->join('tbl_users u', 'u.id =c.instructor_id');
        $this->db->join('tbl_skill_master sm', 'sm.id =c.skill_id');


        if ($search) {
            $searchVal = "(
                        u.first_name like '%$search%' or
                        u.last_name like '%$search%' or
                        sm.name like '%$search%' or
                        u.mobile_no like '%$search%' or
                        c.title like '%$search%' or
                        main.category_name like '%$search%' or
                         c.benefits like '%$search%'
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where1) {
            $this->db->where($where1);
        }
        //$this->db->where('c.status',ACTIVE);
        $this->db->where('c.deleted_by', NULL);

        $this->db->order_by('c.sort_by', 'asc');

        $result = $this->db->get();
        // print_r($this->db->last_query());die;
        return $result->result_array();
    }

    function getFranchiseCoursesData($where = array(), $search = "", $limit = 0, $offset = 0, $where1 = "")
    {
        $this->db->select('c.*,c.id as courses_id,main.category_name as category_name,concat(u.first_name,u.last_name)as instructor_name,u.image as instructor_image ,u.email,u.mobile_no,(SELECT COUNT(DISTINCT `cd`.`id`) FROM tbl_courses_duration as cd WHERE `cd`.`courses_id` = `c`.`id` and `cd`.`status`=1 )as no_of_duration,sm.name as skill_name');
        // $this->db->select('c.*,c.id as courses_id,main.category_name as category_name,concat(u.first_name,u.last_name)as instructor_name,u.image as instructor_image ,u.email,u.mobile_no,(SELECT COUNT(DISTINCT `l`.`id`) FROM tbl_lesson as l WHERE `l`.`course_id` = `c`.`id` and `l`.`status`=1 )as no_of_lessons,(SELECT COUNT(DISTINCT `cd`.`id`) FROM tbl_courses_duration as cd WHERE `cd`.`courses_id` = `c`.`id` and `cd`.`status`=1 )as no_of_duration,sm.name as skill_name');
        $this->db->from('tbl_courses c');
        $this->db->join('tbl_categories main', 'main.id = c.category_id', 'left');
        $this->db->join('tbl_users u', 'u.id =c.instructor_id');
        $this->db->join('tbl_skill_master sm', 'sm.id =c.skill_id');
        // $this->db->join('tbl_order_courses_subscription o', 'o.course_id =c.id');
        // $this->db->join('tbl_users u1','u1.id =c.id');

        if ($search) {
            $searchVal = "(
                        u.first_name like '%$search%' or
                        u.last_name like '%$search%' or
                        sm.name like '%$search%' or
                        u.mobile_no like '%$search%' or
                        c.title like '%$search%' or
                        main.category_name like '%$search%' or
                         c.benefits like '%$search%'
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where1) {
            $this->db->where($where1);
        }
        //$this->db->where('c.status',ACTIVE);
        $this->db->where('c.deleted_by', NULL);

        $this->db->order_by('c.sort_by', 'asc');

        $result = $this->db->get();
        // print_r($this->db->last_query());die;
        return $result->result_array();
    }

    function getLessonData($where = array(), $search = "", $limit = 0, $offset = 0, $where1 = "")
    {
        $this->db->select('l.*,l.id as lesson_id,(SELECT COUNT(DISTINCT `lv`.`id`) FROM tbl_lesson_video as lv WHERE `lv`.`lesson_id` = `l`.`id` and `lv`.`status`=1 )as no_of_videos,c.is_free');
        $this->db->from('tbl_lesson l');
        $this->db->join('tbl_courses c', 'c.id=l.course_id');
        if ($search) {
            $searchVal = "(
                        l.benefits like '%$search%' or
                        l.language like '%$search%' or
                        l.importance like '%$search%' or
                        l.title like '%$search%' 
                       
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where1) {
            $this->db->where($where1);
        }
        $this->db->where('l.status', ACTIVE);
        $this->db->where('l.deleted_by', NULL);

        $this->db->order_by('l.sort_by', 'asc');

        $result = $this->db->get();
        // print_r($this->db->last_query());die;
        return $result->result_array();
    }
    function getCoursesDurationData($where = array(), $search = "", $limit = 0, $offset = 0, $where1 = "")
    {
        $this->db->select('m.name as duration,cd.*,cd.id as duration_id');
        $this->db->from('tbl_courses_duration cd');
        $this->db->join('tbl_duration_master m', 'm.id =cd.duration_id', 'left');
        if ($search) {
            $searchVal = "(
                        m.name like '%$search%' or
                        m.no_of_days like '%$search%' 
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where1) {
            $this->db->where($where1);
        }
        $this->db->where('cd.status', ACTIVE);
        $this->db->where('cd.deleted_by', NULL);

        $this->db->order_by('cd.id', 'asc');

        $result = $this->db->get();
        // print_r($this->db->last_query());die;
        return $result->result_array();
    }
    function getLessonVideoData($where = array(), $search = "", $limit = 0, $offset = 0, $where1 = "", $user_id = 0)
    {
        $this->db->select('lv.*,vm.*,lv.id as lesson_video_id');
        $this->db->from('tbl_lesson_video lv');
        $this->db->join('tbl_video_master vm', 'vm.id = lv.video_id', 'left');
        //    $this->db->join('tbl_lesson_question_master lqm','lqm.lesson_video_id = lv.id');

        if ($search) {
            $searchVal = "( 
                        vm.duration like '%$search%' or
                        vm.title like '%$search%' 
                       
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where1) {
            $this->db->where($where1);
        }
        $this->db->where('lv.status', ACTIVE);
        $this->db->where('lv.deleted_by', NULL);
        $this->db->group_by('lv.video_id', ACTIVE);
        $this->db->order_by('lv.id', 'asc');

        $query_lesson = $this->db->get();
        $result = $query_lesson->result_array();
        // print_r($this->db->last_query());die;
        foreach ($result as $key => $value) {
            $result[$key]['no_of_question'] = $value['no_of_question'];
            if ($user_id) {
                $stored_pocedure = "CALL procedure_solved_mcq_view_video(" . $value['lesson_video_id'] . "," . $user_id . ") ";
                $query = $this->db->query($stored_pocedure);
                $lesson_array = $query->row_array();
                //  echo $this->db->last_query();die;
                $query->next_result();
                $query->free_result();
                if (!empty($lesson_array) && isset($lesson_array)) {
                    $result[$key]['view_video'] = $lesson_array['view_video'];
                    $result[$key]['user_solved_exam'] = $lesson_array['user_solved_exam'];
                } else {
                    $result[$key]['view_video'] = 0;
                    $result[$key]['user_solved_exam'] = 0;
                }
            } else {
                $result[$key]['view_video'] = 0;
                $result[$key]['user_solved_exam'] = 0;
            }
        }
        return $result;
    }
    function getLessonVideoMCQData($where = array(), $search = "", $limit = 0, $offset = 0, $where_in = "", $no_of_question = 0)
    {

        $this->db->select('id as q_id, skill_id,is_challenge,question,answer,explantion,option_1,option_2,option_3,option_4,option_5,""as user_answer ');
        $this->db->from('view_lesson_video_question');

        if ($search) {

            $searchVal = "(
                        question like '%$search%' or
                        answer like '%$search%' 
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where_in) {
            $this->db->where_in($where_in);
        }

        $this->db->where('deleted_by', NULL);

        // $this->db->order_by('id', 'desc');
        $this->db->order_by('rand()');
        if ($no_of_question) {
            $this->db->limit($no_of_question);
        } else {
            $this->db->limit(DISPLAY_NO_OF_QUESTION);
        }
        //$this->db->limit(DISPLAY_NO_OF_QUESTION);
        $result = $this->db->get();
        // print_r($this->db->last_query());die;
        return $result->result_array();


        // print_r($this->db->last_query());die;
        // return $query->result_array();
    }
    function getPackagesData($where = array(), $search = "", $limit = 0, $offset = 0, $where1 = "")
    {
        $this->db->select('c.*,c.id as package_id,concat(u.first_name,u.last_name)as instructor_name,u.image as instructor_image ,u.email,u.mobile_no,(SELECT COUNT(DISTINCT `cp`.`id`) FROM tbl_courses_packages as cp WHERE `cp`.`package_id` = `c`.`id` and `cp`.`status`=1 )as no_of_courses,sm.name as skill_name, cd.price,cd.offer_type,cd.offer_amount,cd.strike_thr_price');
        $this->db->from('tbl_courses c');
        $this->db->join('tbl_users u', 'u.id =c.instructor_id');
        $this->db->join('tbl_courses_duration cd', 'cd.courses_id =c.id');
        $this->db->join('tbl_skill_master sm', 'sm.id =c.skill_id', 'left');


        if ($search) {
            $searchVal = "(
                        u.first_name like '%$search%' or
                        u.last_name like '%$search%' or
                        sm.name like '%$search%' or
                        u.mobile_no like '%$search%' or
                        c.title like '%$search%' or
                        c.benefits like '%$search%'
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where1) {
            $this->db->where($where1);
        }
        //  $this->db->where('c.status',ACTIVE);
        $this->db->where('c.deleted_by', NULL);

        $this->db->order_by('c.sort_by', 'asc');

        $result = $this->db->get();
        //  print_r($this->db->last_query());die;
        return $result->result_array();
    }
    function getPackagesCourseData($where = array(), $search = "", $limit = 0, $offset = 0, $where1 = "")
    {
        $this->db->select('c.id as courses_id,c.*,c.id as package_id,concat(u.first_name,u.last_name)as instructor_name,u.image as instructor_image ,u.email,u.mobile_no,(SELECT COUNT(DISTINCT `cp`.`id`) FROM tbl_courses_packages as cp WHERE `cp`.`package_id` = `c`.`id` and `cp`.`status`=1 )as no_of_courses,sm.name as skill_name, m.name as duration,cat.category_name,(SELECT COUNT(DISTINCT `l`.`id`) FROM tbl_lesson as l WHERE `l`.`course_id` = `c`.`id` and `l`.`status`=1 )as no_of_lessons');
        $this->db->from('tbl_courses_packages cp');
        $this->db->join('tbl_courses c', 'cp.courses_id =c.id');
        $this->db->join('tbl_categories cat', 'cat.id =c.category_id');
        $this->db->join('tbl_courses_duration cd', 'cp.courses_duration_id =cd.id');
        $this->db->join('tbl_duration_master m', 'm.id =cd.duration_id');
        $this->db->join('tbl_users u', 'u.id =c.instructor_id');

        $this->db->join('tbl_skill_master sm', 'sm.id =c.skill_id');



        if ($search) {
            $searchVal = "(
                        u.first_name like '%$search%' or
                        u.last_name like '%$search%' or
                        sm.name like '%$search%' or
                        u.mobile_no like '%$search%' or
                        c.title like '%$search%' or
                        c.benefits like '%$search%'
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where1) {
            $this->db->where($where1);
        }
        $this->db->where('c.status', ACTIVE);
        $this->db->where('c.deleted_by', NULL);

        $this->db->order_by('c.sort_by', 'asc');

        $result = $this->db->get();
        //    print_r($this->db->last_query());die;
        return $result->result_array();
    }

    function getOrderData($where = array(), $where_in_key = '', $where_in_value = '')
    {
        //   print_r($where);die();
        $this->db->select('o.id as order_id,concat(u.first_name,u.last_name)as user_name,u.image as instructor_image ,u.email,u.mobile_no,od.*,o.*');
        $this->db->from('tbl_orders o');
        $this->db->join('tbl_order_details od', 'od.order_id =o.id');
        $this->db->join('tbl_users u', 'u.id =o.user_id');

        $this->db->where($where);
        if ($where_in_key && $where_in_value) {
            $this->db->where_in($where_in_key, $where_in_value);
        }

        $this->db->where('o.order_status', 1);
        $this->db->where('o.payment_status', 1);
        $this->db->where('o.deleted_by', NULL);

        $this->db->order_by('o.id', 'desc');

        $result = $this->db->get();
        //    print_r($this->db->last_query());die;
        return $result->result_array();
    }

    function getMyPackagesData($where = array(), $search = "", $limit = 0, $offset = 0, $where1 = "")
    {
        $this->db->select('c.*,c.id as package_id,concat(u.first_name,u.last_name)as instructor_name,u.image as instructor_image ,u.email,u.mobile_no,(SELECT COUNT(DISTINCT `cp`.`id`) FROM tbl_courses_packages as cp WHERE `cp`.`package_id` = `c`.`id` and `cp`.`status`=1 )as no_of_courses,sm.name as skill_name, cd.price,cd.offer_type,cd.offer_amount,cd.strike_thr_price,o.is_review_submit');
        $this->db->from('tbl_courses c');
        $this->db->join('tbl_users u', 'u.id =c.instructor_id');
        $this->db->join('tbl_courses_duration cd', 'cd.courses_id =c.id');
        $this->db->join('tbl_skill_master sm', 'sm.id =c.skill_id');

        $this->db->join('tbl_order_details od', 'od.courses_id =c.id');
        $this->db->join('tbl_orders o', 'o.id =od.order_id');

        if ($search) {
            $searchVal = "(
                        u.first_name like '%$search%' or
                        u.last_name like '%$search%' or
                        sm.name like '%$search%' or
                        u.mobile_no like '%$search%' or
                        c.title like '%$search%' or
                        c.benefits like '%$search%'
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where1) {
            $this->db->where($where1);
        }
        $this->db->where('c.status', ACTIVE);
        $this->db->where('c.deleted_by', NULL);
        $this->db->where('od.type', '3');

        $this->db->group_by('c.id', 'desc');
        $this->db->order_by('c.id', 'desc');

        $result = $this->db->get();
        //  print_r($this->db->last_query());die;
        return $result->result_array();
    }

    function getLessonUserViewData($where = array())
    {
        //   print_r($where);die();
        $this->db->select('max(sort_by)as last_lesson_sort');
        $this->db->from('tbl_lesson_user_video lv');
        $this->db->join('tbl_lesson l', 'l.id =lv.lesson_id');

        $this->db->where($where);

        $this->db->order_by('sort_by', 'desc');

        $result = $this->db->get();
        //print_r($this->db->last_query());die;
        return $result->row_array();
    }

    function getPrviousLessonUserViewData($where = array())
    {
        //   print_r($where);die();
        $this->db->select('lv.*');
        $this->db->from('tbl_lesson_user_video lv');
        $this->db->join('tbl_lesson l', 'l.id =lv.lesson_id');

        $this->db->where($where);

        $this->db->order_by('sort_by', 'desc');

        $result = $this->db->get();
        //print_r($this->db->last_query());die;
        return $result->row_array();
    }
    function getMyCoursesData($where = array(), $search = "", $limit = 0, $offset = 0, $where1 = "")
    {
        $this->db->select('c.*,c.id as courses_id,main.category_name as category_name,concat(u.first_name,u.last_name)as instructor_name,u.image as instructor_image ,u.email,u.mobile_no,(SELECT COUNT(DISTINCT `l`.`id`) FROM tbl_lesson as l WHERE `l`.`course_id` = `c`.`id` and `l`.`status`=1 )as no_of_lessons,(SELECT COUNT(DISTINCT `cd`.`id`) FROM tbl_courses_duration as cd WHERE `cd`.`courses_id` = `c`.`id` and `cd`.`status`=1 )as no_of_duration,sm.name as skill_name');
        $this->db->from('tbl_courses c');
        $this->db->join('tbl_categories main', 'main.id = c.category_id', 'left');
        $this->db->join('tbl_users u', 'u.id =c.instructor_id');
        $this->db->join('tbl_skill_master sm', 'sm.id =c.skill_id');
        $this->db->join('tbl_order_details od', 'od.courses_id =c.id');
        $this->db->join('tbl_orders o', 'o.id =od.order_id');

        if ($search) {
            $searchVal = "(
                        u.first_name like '%$search%' or
                        u.last_name like '%$search%' or
                        sm.name like '%$search%' or
                        u.mobile_no like '%$search%' or
                        c.title like '%$search%' or
                        main.category_name like '%$search%' or
                         c.benefits like '%$search%'
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where1) {
            $this->db->where($where1);
        }
        //$this->db->where('c.status',ACTIVE);
        $this->db->where('c.deleted_by', NULL);

        $this->db->order_by('c.sort_by', 'asc');

        $result = $this->db->get();
        // print_r($this->db->last_query());die;
        return $result->result_array();
    }
}