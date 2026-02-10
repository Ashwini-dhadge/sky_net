<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LessonsModel extends CI_Model
{
    

    public function getLessonById($id)
    {
        $this->db->select("
            l.id,
            l.title AS lesson_title,
            l.sequence,
            l.description,
            c.title AS course_name,
            s.title AS section_title
        ");
        $this->db->from('tbl_lesson l');
        $this->db->join('tbl_courses c', 'c.id = l.course_id', 'LEFT');
        $this->db->join('tbl_section s', 's.id = l.section_id', 'LEFT');
        $this->db->where('l.id', $id);
        $this->db->where('l.deleted_at IS NULL');
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getLessonMcqs($lesson_id)
    {
        return $this->db
            ->where('lesson_id', $lesson_id)
            ->order_by('id', 'DESC')
            ->get('tbl_lesson_mcq')
            ->result_array();
    }


    public function getLessonList($params)
    {
        $search_value = $params['search'] ?? '';
        $course_id    = $params['course_id'] ?? '';
        $section_id   = $params['section_id'] ?? '';
        $start        = $params['start'] ?? 0;
        $length       = $params['length'] ?? 25;

        $this->db->select("
            l.id,
            l.title AS lesson_title,
            l.sequence,
            l.description,
            c.title AS course_name,
            s.title AS section_title,
            c.id as course_id,
            s.id as section_id
        ");
        $this->db->from('tbl_lesson l');
        $this->db->join('tbl_courses c', 'c.id = l.course_id', 'LEFT');
        $this->db->join('tbl_section s', 's.id = l.section_id', 'LEFT');
        $this->db->where('l.deleted_at IS NULL');

        if (!empty($course_id)) {
            $this->db->where('l.course_id', $course_id);
        }

        if (!empty($section_id)) {
            $this->db->where('l.section_id', $section_id);
        }

        if (!empty($search_value)) {
            $this->db->group_start();
            $this->db->like('l.title', $search_value);
            $this->db->or_like('c.title', $search_value);
            $this->db->or_like('s.title', $search_value);
            $this->db->group_end();
        }

        $this->db->order_by('l.sequence', 'ASC');

        $count_db = clone $this->db;
        $total    = $count_db->count_all_results();

        $this->db->limit($length, $start);
        $data = $this->db->get()->result_array();

        return [
            'total' => $total,
            'data'  => $data
        ];
    }
}
