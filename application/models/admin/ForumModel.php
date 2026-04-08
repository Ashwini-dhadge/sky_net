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


    // public function getNonApprovedQuestions(
    //     $status = 0,
    //     $searchVal = '',
    //     $sortColIndex = 0,
    //     $sortBy = 'desc',
    //     $limit = 0,
    //     $offset = 0
    // ) {
    //     $this->db->select('q.*, u.first_name as asked_by');
    //     $this->db->from('tbl_forum_questions q');
    //     $this->db->join('tbl_users u', 'u.id = q.user_id', 'left');

    //     $this->db->where('q.is_approved', $status);
    //     // $this->db->where('q.deleted_at IS NULL', null, false);

    //     if ($limit) {
    //         $this->db->limit($limit, $offset);
    //     }

    //     return $this->db->get()->result_array();
    // }

    protected $PendingQuestionColumn = [
        'q.id',
        '',
        '',

    ];

    public function getNonApprovedQuestions(
        $searchVal = '',
        $sortColIndex = '0',
        $sortBy = 'DESC',
        $limit = '0',
        $offset = '0',
        $id = '',
        $where = ''
    ) {


        $this->db->select('q.*, u.first_name as asked_by');
        $this->db->from('tbl_forum_questions q');
        $this->db->join('tbl_users u', 'u.id = q.user_id', 'left');


        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->where('q.deleted_by', NULL);
        if ($searchVal) {
            $this->db->where("(
                q.title LIKE '%$searchVal%' OR
                u.first_name LIKE '%$searchVal%'
            )");
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }


        $orderColumn = $this->PendingQuestionColumn[$sortColIndex];
        $this->db->order_by($orderColumn, $sortBy);

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

    public function getQuestionById($id)
    {
        return $this->db
            ->select('q.*, u.first_name as asked_by')
            ->from('tbl_forum_questions q')
            ->join('tbl_users u', 'u.id=q.user_id', 'left')
            ->where('q.id', $id)
            ->get()
            ->row_array();
    }

    public function getAnswersWithUser($forum_id)
    {
        $this->db->select('a.*, u.first_name as answered_by');
        $this->db->from('tbl_forum_answers a');
        $this->db->join('tbl_users u', 'u.id = a.user_id');
        $this->db->where('a.forum_id', $forum_id);
        $this->db->where('a.deleted_at IS NULL', null, false);
        $this->db->order_by('a.created_at', 'ASC');

        $answers = $this->db->get()->result_array();
        return $this->buildTree($answers);
    }

    private function buildTree($elements, $parentId = NULL)
    {
        $branch = [];
        foreach ($elements as $element) {
            if ($element['parent_id'] == $parentId) {
                $children = $this->buildTree($elements, $element['id']);
                if ($children) {
                    $element['replies'] = $children;
                } else {
                    $element['replies'] = [];
                }
                $branch[] = $element;
            }
        }
        return $branch;
    }

    public function getRandomQuestions($limit = 5, $excludeId = 0)
    {
        $this->db->select('q.id, q.title');
        $this->db->from('tbl_forum_questions q');
        $this->db->where('q.is_approved', 1);
        $this->db->where('q.deleted_at IS NULL', null, false);
        if ($excludeId) {
            $this->db->where('q.id !=', $excludeId);
        }
        $this->db->order_by('RAND()');
        $this->db->limit($limit);

        return $this->db->get()->result_array();
    }

    public function logAction($data)
    {
        return $this->CommonModel->iudAction(
            'tbl_forum_action_logs',
            [
                'forum_id'    => $data['forum_id'],
                'is_approved' => $data['is_approved'],
                'remark'      => $data['remark'] ?? NULL,
                'created_by'  => $data['created_by'],
                'created_at'  => date('Y-m-d H:i:s')
            ],
            'insert'
        );
    }

    public function getQuestionsByUser($user_id)
    {
        $this->db->select('
        q.*,
        COUNT(a.id) as total_answers,
        CONCAT(asker.first_name, " ", asker.last_name) as asked_by,
        CONCAT(ans_user.first_name, " ", ans_user.last_name) as latest_answered_by
    ');

        $this->db->from('tbl_forum_questions q');
        $this->db->join('tbl_users asker', 'asker.id = q.user_id', 'left');
        $this->db->join(
            'tbl_forum_answers a',
            'a.forum_id = q.id AND a.deleted_at IS NULL',
            'left'
        );

        $latestJoin = 'latest.id = (
        SELECT fa.id
        FROM tbl_forum_answers fa
        WHERE fa.forum_id = q.id
          AND fa.deleted_at IS NULL
        ORDER BY fa.id DESC
        LIMIT 1
    )';

        $this->db->join('tbl_forum_answers latest', $latestJoin, 'left', false);
        $this->db->join('tbl_users ans_user', 'ans_user.id = latest.user_id', 'left');
        $this->db->where('q.user_id', $user_id);
        $this->db->where('q.deleted_at IS NULL', null, false);
        $this->db->group_by('q.id');
        $this->db->order_by('q.id', 'DESC');

        return $this->db->get()->result_array();
    }
}