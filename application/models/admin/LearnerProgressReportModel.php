<?php

/**
 * 
 */
class LearnerProgressReportModel extends CI_Model
{
    protected $CourseOrderColumn = [
        '',
        'title',
        'category_name',
        '',
        'price'
    ];


    // COUNT(DISTINCT lv.id) as total_lessons,
    // COUNT(DISTINCT luv.lesson_id) as watched_lessons,

    // ROUND(
    //     (COUNT(DISTINCT luv.lesson_id) / NULLIF(COUNT(DISTINCT lv.id),0)) * 100
    // ,2) as section_progress
    public function getLearnerProgressList(
        $searchVal = '',
        $sortColIndex = '0',
        $sortBy = 'DESC',
        $limit = '0',
        $offset = '0',
        $id = '',
        $where = ''
    ) {


        $this->db->select("
        c.id as course_id,
        s.id as section_id,
        u.id as user_id,
        c.title,
        s.title as section_title,
        l.title as lesson_title,
        u.first_name as student_name,
          luv.result
        ");

        $this->db->from('tbl_order_courses_subscription tocs');

        $this->db->join(
            'tbl_orders to',
            "to.id = tocs.order_id 
             AND to.order_status = 'COMPLETED'
             AND to.payment_status = 'CAPTURED'"
        );

        $this->db->join('tbl_users u', 'u.id = tocs.user_id');
        $this->db->join('tbl_courses c', 'c.id = tocs.course_id');
        $this->db->join('tbl_section s', 's.course_id = c.id');
        $this->db->join('tbl_lesson l', 'l.section_id = s.id');
        // total lessons in section
        $this->db->join('tbl_lesson_video lv', 'lv.section_id = s.id', 'left');

        // watched lessons by user
        $this->db->join(
            'tbl_lesson_user_video luv',
            'luv.lesson_id = l.id 
             AND luv.user_id = to.user_id
             AND luv.view_video = 1
             AND luv.solved_mcq IS NOT NULL',
            'left'
        );

        // -------------------------------------------------------
        // Filters
        // -------------------------------------------------------
        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->where('c.deleted_by', NULL);
        $this->db->where('to.deleted_by', NULL);

        // 🔥 Important → one row per user per course per section
        $this->db->group_by(['c.id', 's.id', 'l.id', 'to.user_id']);

        // -------------------------------------------------------
        // Global search (datatable)
        // -------------------------------------------------------
        if ($searchVal) {
            $this->db->where("(
                c.title LIKE '%$searchVal%' OR
                s.title LIKE '%$searchVal%' OR
                u.first_name LIKE '%$searchVal%'
            )");
        }
        $this->db->having('COUNT(DISTINCT luv.lesson_id) >', 0);
        // -------------------------------------------------------
        // Pagination
        // -------------------------------------------------------
        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        // -------------------------------------------------------
        // Sorting (safe fallback)
        // -------------------------------------------------------
        $orderColumn = $this->CourseOrderColumn[$sortColIndex] ?? 'c.title';
        $this->db->order_by($orderColumn, $sortBy);

        return $this->db->get()->result_array();
    }

    public function getSectionResultDetails($course_id, $section_id, $lesson_id, $user_id)
    {
        $this->db->select('
        c.title as course_name,
        s.title as section_name,
        lv.title as lesson_name,
        luv.result,
        luv.no_of_question,
        u.first_name as student_name,
        ');
        $this->db->from('tbl_lesson_user_video luv');
        $this->db->join('tbl_courses c', 'c.id=luv.courses_id');
        $this->db->join('tbl_section s', 's.id=luv.section_id');
        $this->db->join('tbl_lesson lv', 'lv.id=luv.lesson_id');
        $this->db->join('tbl_users u', 'u.id=luv.user_id');
        $this->db->where('luv.solved_mcq IS NOT NULL');
        $this->db->where('luv.view_video', 1);
        if (!empty($course_id)) {
            $this->db->where('luv.courses_id', $course_id);
        }
        if (!empty($section_id)) {
            $this->db->where('luv.section_id', $section_id);
        }
        if (!empty($lesson_id)) {
            $this->db->where('luv.lesson_id', $lesson_id);
        }
        if (!empty($user_id)) {
            $this->db->where('luv.user_id', $user_id);
        }
        return $this->db->get()->result_array();
    }
}