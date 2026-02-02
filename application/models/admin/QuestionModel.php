<?php

class QuestionModel extends CI_Model
{
    public function getallQuestion($course_id = '', $unanswered = 0)
    {
        $this->db->select([
            'tbl_course_qna.*',
            'tbl_courses.title as course_title',

            // Asked by
            'asker.first_name as asked_first_name',
            'asker.last_name as asked_last_name',
            'tbl_course_qna.created_at as asked_at',

            // Answered by
            'answerer.first_name as answered_first_name',
            'answerer.last_name as answered_last_name',
            'tbl_course_qna.ans_created_at as answered_at'
        ]);


        $this->db->from('tbl_course_qna');

        $this->db->join(
            'tbl_courses',
            'tbl_courses.id = tbl_course_qna.course_id',
            'left'
        );

        // 👤 Who asked the question
        $this->db->join(
            'tbl_users as asker',
            'asker.id = tbl_course_qna.user_id',
            'left'
        );

        // 👤 Who answered the question
        $this->db->join(
            'tbl_users as answerer',
            'answerer.id = tbl_course_qna.ans_created_by',
            'left'
        );

        if ($course_id) {
            $this->db->where('tbl_course_qna.course_id', $course_id);
        }

        if ($unanswered) {
            $this->db->where('(tbl_course_qna.answer IS NULL OR tbl_course_qna.answer = "")');
        }

        // Unanswered first (PHP 8.2 safe)
        $this->db->order_by('(tbl_course_qna.answer IS NULL)', 'DESC', false);
        $this->db->order_by('tbl_course_qna.id', 'DESC');

        return $this->db->get()->result_array();
    }
}
