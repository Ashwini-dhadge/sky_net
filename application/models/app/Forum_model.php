<?php
defined('BASEPATH') or exit('No direct script access allowed');



class Forum_model extends CI_Model
{
    public function getForumPostList($user_id = null)
    {
        // Subquery for comment count
        $subQuery = $this->db
            ->select('COUNT(*)')
            ->from('tbl_forum_answers')
            ->where('tbl_forum_answers.forum_id = fq.id')
            ->get_compiled_select();

        $this->db->select("
            fq.id AS forum_post_id,
            fq.user_id,
            fq.title,
            fq.description,
            fq.tags,
            fq.remark,
            fq.created_at,
            u.first_name AS full_name,
            u.image,
            fq.is_approved,
             CASE
        WHEN fq.is_approved = 0 THEN 'Un-public'
        WHEN fq.is_approved = 1 THEN 'Public'
        WHEN fq.is_approved = 2 THEN 'Rejected'
        ELSE 'Unknown'
    END AS status,
            ({$subQuery}) AS comment_count
        ")
            ->from('tbl_forum_questions fq')
            ->join('tbl_users u', 'u.id = fq.user_id', 'left')
            // ->where('fq.is_approved', 1)
            ->where('fq.deleted_by', NULL);

        // Filter by user_id if passed (my forum list)
        if (!empty($user_id)) {
            $this->db->where('fq.user_id', $user_id);
        } else {
            // For all forum list, show only approved posts
            $this->db->where('fq.is_approved', 1);
        }

        $this->db->order_by('fq.id', 'DESC');

        return $this->db->get()->result_array();
    }



    public function isForumExists($forum_id)
    {
        return $this->db
            ->where(['id' => $forum_id, 'deleted_by' => NULL])
            ->get('tbl_forum_questions')
            ->row_array();
    }


    public function getForumComments($forum_id)
    {
        return $this->db
            ->select('
                fa.id AS comment_id,
                fa.forum_id as forum_post_id,
                fa.user_id,
                fa.answer AS comment,
                fa.parent_id,
                  u.first_name,
                    u.image,
                fa.created_at
            ')
            ->from('tbl_forum_answers fa')
            ->join('tbl_users u', 'u.id = fa.user_id', 'left')
            ->where('fa.forum_id', $forum_id)
            ->order_by('fa.id', 'ASC')
            ->get()
            ->result_array();
    }
    public function getForumDetail($forum_id)
    {
        return $this->db
            ->select('
            fq.id AS forum_post_id,
            fq.user_id,
            fq.title,
            fq.description,
            fq.tags,
            fq.created_at,

            u.first_name,
            u.image,

            COUNT(fa.id) AS comment_count
        ')
            ->from('tbl_forum_questions fq')
            ->join('tbl_users u', 'u.id = fq.user_id', 'left')
            ->join('tbl_forum_answers fa', 'fa.forum_id = fq.id', 'left')
            ->where('fq.id', $forum_id)
            ->where('fq.deleted_by', NULL)
            ->group_by('fq.id')
            ->get()
            ->row_array();
    }
}