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

        $this->db->where('tbl_course_qna.deleted_at', null);

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

    public function getUserCourseQna($user_id)
    {
        return $this->db
            ->select("
            qna.*,
            c.title as course_title,
            CONCAT(u.first_name,' ',u.last_name) as asked_by
        ")
            ->from('tbl_course_qna qna')
            ->join('tbl_courses c', 'c.id = qna.course_id', 'left')
            ->join('tbl_users u', 'u.id = qna.user_id', 'left')
            ->where('qna.user_id', $user_id)
            ->where('qna.deleted_at IS NULL', null, false)
            ->order_by('qna.id', 'DESC')
            ->get()
            ->result_array();
    }
}
