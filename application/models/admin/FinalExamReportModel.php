<?php

/**
 * 
 */
class FinalExamReportModel extends CI_Model
{
    protected $CourseOrderColumn = [
        'luv.id',
        'tc.title',
        '',
        '',
        '',
    ];



    public function getFinalExamReportDetails(
        $searchVal = '',
        $sortColIndex = '0',
        $sortBy = 'DESC',
        $limit = '0',
        $offset = '0',
        $id = '',
        $where = ''
    ) {

        $this->db->select('
        tu.first_name as student_name,
        tc.title as course_name,
        luv.result,
        ');
        $this->db->from('tbl_lesson_user_video luv');
        $this->db->join('tbl_lesson tl', 'tl.id=luv.lesson_id');
        $this->db->join('tbl_courses tc', 'tc.id=luv.courses_id');
        $this->db->join('tbl_users tu', 'tu.id=luv.user_id');
        $this->db->where([
            'tl.is_final_lesson' => "1",
            'luv.solved_mcq !=' => NULL,
            'luv.view_video' => 1,

        ]);

        if (!empty($where)) {
            $this->db->where($where);
        }

        if ($searchVal) {
            $this->db->where("(
                tu.first_name LIKE '%$searchVal%' OR
                tc.title LIKE '%$searchVal%' 
            )");
        }


        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }


        // $orderColumn = $this->CourseOrderColumn[$sortColIndex];
        // $this->db->order_by($orderColumn, $sortBy);
        $this->db->order_by($this->CourseOrderColumn[$sortColIndex], $sortBy);
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