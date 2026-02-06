<?php


class ForumModel extends CI_Model
{
    public $column_order = [null, 'title', 'tags', 'is_approved', 'created_at'];

    private function baseQuery($searchVal = '')
    {
        $this->db->from('tbl_forum_questions');
        $this->db->where('deleted_at IS NULL', null, false);

        if ($searchVal) {
            $this->db->group_start();
            $this->db->like('title', $searchVal);
            $this->db->or_like('description', $searchVal);
            $this->db->group_end();
        }
    }

    public function getAllQuestions($search = '', $col = 0, $dir = 'desc', $limit = 0, $offset = 0)
    {
        $this->baseQuery($search);

        if ($limit) $this->db->limit($limit, $offset);

        if (isset($this->column_order[$col]))
            $this->db->order_by($this->column_order[$col], $dir);
        else
            $this->db->order_by('id', 'DESC');

        return $this->db->get()->result_array();
    }

    public function getApprovedQuestions($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0)
    {
        $this->db->select('q.*, u.first_name as asked_by');
        $this->db->from('tbl_forum_questions q');
        $this->db->join('tbl_users u', 'u.id=q.user_id', 'left');

        $this->db->where('q.is_approved', 1);
        $this->db->where('q.deleted_at IS NULL', null, false);

        if ($searchVal) {
            $this->db->group_start();
            $this->db->like('q.title', $searchVal);
            $this->db->or_like('q.description', $searchVal);
            $this->db->group_end();
        }

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by('q.id', $sortBy);

        return $this->db->get()->result_array();
    }


    public function getNonApprovedQuestions($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0)
    {
        $this->db->select('q.*, u.first_name as asked_by_first, u.last_name as asked_by_last');
        $this->db->from('tbl_forum_questions q');
        $this->db->join('tbl_users u', 'u.id = q.user_id', 'left');
        $this->db->where('q.is_approved', 0);
        $this->db->where('q.deleted_at IS NULL', null, false);

        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }


    public function getAnswersByQuestion($id)
    {
        return $this->db
            ->where('forum_id', $id)
            ->where('deleted_at IS NULL', null, false)
            ->get('tbl_forum_answers')
            ->result_array();
    }
}
