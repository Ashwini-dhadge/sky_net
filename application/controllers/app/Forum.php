<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forum extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('app/Forum_model');
        // $this->load->model('app/Common_model');
    }



    public function createForumPost()
    {
        authenticateUser();
        $response = array();

        $input = json_decode(file_get_contents('php://input'), true);

        $user_id     = $this->regId;
        $title       = isset($input['title']) ? trim($input['title']) : '';

        $description = isset($input['description']) ? trim($input['description']) : '';
        $tagsArray   = isset($input['tags']) ? $input['tags'] : [];

        if (!$user_id) {
            echo json_encode(['result' => false, 'message' => 'User authentication failed']);
            return;
        }

        if (!$title) {
            echo json_encode(['result' => false, 'message' => 'Title is required']);
            return;
        }

        if (!$description) {
            echo json_encode(['result' => false, 'message' => 'Description is required']);
            return;
        }

        $tags = '';
        if (is_array($tagsArray) && !empty($tagsArray)) {
            $tags = implode(',', array_unique(array_map('trim', $tagsArray)));
        }

        $insertData = [
            'user_id' => $user_id,
            'title' => $title,
            'description' => $description,
            'tags' => $tags,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->regId
        ];
        $inserted = $this->CommonModel->iudAction('tbl_forum_questions', $insertData, 'insert');
        if ($inserted) {
            echo json_encode(['result' => true, 'message' => 'Forum post created successfully']);
        } else {
            echo json_encode(['result' => false, 'message' => 'Failed to create forum post']);
        }
    }
    public function forumPostUpdate()
    {
        authenticateUser();

        $input = json_decode(file_get_contents('php://input'), true);

        $user_id        = $this->regId;
        $forum_post_id  = isset($input['forum_post_id']) ? $input['forum_post_id'] : '';
        $title          = isset($input['title']) ? trim($input['title']) : '';
        $description    = isset($input['description']) ? trim($input['description']) : '';
        $tagsArray      = isset($input['tags']) ? $input['tags'] : [];

        // Validation
        if (!$user_id) {
            echo json_encode(['result' => false, 'message' => 'User authentication failed']);
            return;
        }

        if (!$forum_post_id) {
            echo json_encode(['result' => false, 'message' => 'Forum post ID is required']);
            return;
        }

        if (!$title) {
            echo json_encode(['result' => false, 'message' => 'Title is required']);
            return;
        }

        if (!$description) {
            echo json_encode(['result' => false, 'message' => 'Description is required']);
            return;
        }

        // Check ownership: only author can update
        $forum = $this->CommonModel->getData(
            'tbl_forum_questions',
            ['id' => $forum_post_id, 'user_id' => $user_id, 'deleted_by' => NULL],
            '*',
            '',
            'row_array'
        );

        if (!$forum) {
            echo json_encode(['result' => false, 'message' => 'Forum post not found or not allowed to update']);
            return;
        }

        // Prepare tags string
        $tags = '';
        if (is_array($tagsArray) && !empty($tagsArray)) {
            $tags = implode(',', array_unique(array_map('trim', $tagsArray)));
        }

        $updateData = [
            'title'       => $title,
            'description' => $description,
            'tags'        => $tags,
            'is_approved'        => 0,
            'updated_at'  => date('Y-m-d H:i:s'),
            'updated_by'  => $user_id
        ];
        $this->CommonModel->iudAction('tbl_forum_action_logs', [
            'forum_id' => $forum_post_id,
            'is_approved'        => 0,
            'created_by' => $this->regId,
            'created_at' => date('Y-m-d H:i:s')
        ], 'insert');
        $updated = $this->CommonModel->iudAction(
            'tbl_forum_questions',
            $updateData,
            'update',
            ['id' => $forum_post_id]
        );

        if ($updated) {
            echo json_encode(['result' => true, 'message' => 'Forum post updated successfully']);
        } else {
            echo json_encode(['result' => false, 'message' => 'Failed to update forum post']);
        }
    }

    public function forumPostDelete()
    {
        authenticateUser();

        $login_user_id  = $this->regId;
        $forum_post_id  = $this->input->post('forum_post_id');

        if (empty($forum_post_id)) {
            echo json_encode([
                'result' => false,
                'message' => 'Forum post ID is required'
            ]);
            return;
        }

        // Check ownership: only author can delete
        $forum = $this->CommonModel->getData(
            'tbl_forum_questions',
            [
                'id' => $forum_post_id,
                'user_id' => $login_user_id,
                'deleted_by' => NULL
            ],
            '*',
            '',
            'row_array'
        );

        if (!$forum) {
            echo json_encode([
                'result' => false,
                'message' => 'Forum post not found or not allowed to delete'
            ]);
            return;
        }

        // Soft delete the forum post
        $this->CommonModel->iudAction(
            'tbl_forum_questions',
            [
                'deleted_by' => $login_user_id,
                'deleted_at' => date('Y-m-d H:i:s')
            ],
            'update',
            ['id' => $forum_post_id]
        );
        // Soft delete all comments related to this forum post
        $this->CommonModel->iudAction(
            'tbl_forum_answers',
            [
                'deleted_by' => $login_user_id,
                'deleted_at' => date('Y-m-d H:i:s')
            ],
            'update',
            ['id' => $forum_post_id]
        );




        echo json_encode([
            'result' => true,
            'message' => 'Forum post and all associated comments deleted successfully'
        ]);
    }

    public function forumPostList()
    {
        authenticateUser();

        $login_user_id = $this->regId;

        if (!$login_user_id) {
            echo json_encode([
                'result' => false,
                'message' => 'User authentication failed'
            ]);
            return;
        }

        $forumPosts = $this->Forum_model->getForumPostList();
        // echo $this->db->last_query();
        // die;
        if (!empty($forumPosts)) {

            foreach ($forumPosts as &$row) {

                // tags string → array
                $row['tags'] = !empty($row['tags'])
                    ? explode(',', $row['tags'])
                    : [];

                // ownership flag
                $row['is_my_question'] = ($row['user_id'] == $login_user_id);

                // image full path (optional but recommended)
                $row['image'] = !empty($row['image'])
                    ? base_url('uploads/users/' . $row['image'])
                    : null;
            }

            echo json_encode([
                'result' => true,
                'message' => 'Forum post list fetched successfully',
                'data' => $forumPosts,
                'image_path' => base_url() . USER_IMAGES
            ]);
        } else {
            echo json_encode([
                'result' => false,
                'message' => 'No forum posts found',
                'data' => []
            ]);
        }
    }
    public function myForumList()
    {
        authenticateUser();

        $login_user_id = $this->regId;

        if (!$login_user_id) {
            echo json_encode([
                'result' => false,
                'message' => 'User authentication failed'
            ]);
            return;
        }

        $forumPosts = $this->Forum_model->getForumPostList($login_user_id);
        // echo $this->db->last_query();
        // die;
        if (!empty($forumPosts)) {

            foreach ($forumPosts as &$row) {

                // tags string → array
                $row['tags'] = !empty($row['tags'])
                    ? explode(',', $row['tags'])
                    : [];

                // ownership flag
                $row['is_my_question'] = ($row['user_id'] == $login_user_id);

                // image full path (optional but recommended)
                $row['image'] = !empty($row['image'])
                    ? base_url('uploads/users/' . $row['image'])
                    : null;
            }

            echo json_encode([
                'result' => true,
                'message' => 'Forum post list fetched successfully',
                'data' => $forumPosts,
                'image_path' => base_url() . USER_IMAGES
            ]);
        } else {
            echo json_encode([
                'result' => false,
                'message' => 'No forum posts found',
                'data' => []
            ]);
        }
    }

    public function createForumAnswer()
    {
        authenticateUser();

        $response = [];

        $login_user_id = $this->regId;

        $forum_post_id = $this->input->post('forum_post_id');
        $comment       = trim($this->input->post('comment'));


        if (empty($forum_post_id) || empty($comment)) {
            echo json_encode([
                'result'  => false,
                'message' => 'Forum post ID and comment are required'
            ]);
            return;
        }
        $forum_id = $this->CommonModel->getData('tbl_forum_questions', ['id' => $forum_post_id, 'deleted_by' => NULL], 'id', '', 'row_array');

        if (!$forum_id) {
            echo json_encode([
                'result' => false,
                'message' => 'Invalid forum post ID'
            ]);
            return;
        }

        $insertData = [
            'forum_id'   => $forum_post_id,
            'user_id'    => $login_user_id,
            'answer'     => $comment,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->regId
        ];


        $insertId = $this->CommonModel->iudAction('tbl_forum_answers', $insertData, 'insert');

        if ($insertId) {
            echo json_encode([
                'result'  => true,
                'message' => 'Comment Added Successfully'
            ]);
        } else {
            echo json_encode([
                'result'  => false,
                'message' => 'Failed to post answer'
            ]);
        }
    }
    public function forumPostDetail()
    {
        authenticateUser();
        $forum_id      = $this->input->post('forum_post_id');
        $login_user_id = $this->regId;

        if (empty($forum_id)) {
            echo json_encode([
                'result' => false,
                'message' => 'Forum post ID is required'
            ]);
            return;
        }

        $this->load->model('Forum_model');

        // Get forum detail
        $forum = $this->Forum_model->getForumDetail($forum_id);

        if (!$forum) {
            echo json_encode([
                'result' => false,
                'message' => 'Forum post not found'
            ]);
            return;
        }

        // Tags → array
        $forum['tags'] = !empty($forum['tags'])
            ? explode(',', $forum['tags'])
            : [];

        // Ownership
        $forum['is_my_question'] = ($forum['user_id'] == $login_user_id);

        // User image full path
        $forum['image'] = !empty($forum['image'])
            ? base_url('uploads/users/' . $forum['image'])
            : null;

        // Get comments (your existing logic)
        $comments = $this->Forum_model->getForumComments($forum_id);

        $tree = [];
        $map  = [];

        foreach ($comments as $row) {

            $row['is_my_comment'] = (empty($row['parent_id']) && $row['user_id'] == $login_user_id);
            $row['is_my_reply']   = (!empty($row['parent_id']) && $row['user_id'] == $login_user_id);

            $row['replies'] = [];
            $map[$row['comment_id']] = $row;
        }

        foreach ($map as $id => $row) {
            if (empty($row['parent_id'])) {
                $tree[] = &$map[$id];
            } else {
                if (isset($map[$row['parent_id']])) {
                    $map[$row['parent_id']]['replies'][] = &$map[$id];
                }
            }
        }

        echo json_encode([
            'result' => true,
            'message' => 'Forum detail fetched successfully',
            'data' => [
                'forum'    => $forum,
                'comments' => $tree,
                'image_path' => base_url() . USER_IMAGES
            ]
        ]);
    }

    public function replyToComment()
    {
        authenticateUser();

        $forum_id   = $this->input->post('forum_post_id');
        $parent_id  = $this->input->post('comment_id');
        $reply_text = trim($this->input->post('reply'));

        if (empty($forum_id) || empty($parent_id) || empty($reply_text)) {
            echo json_encode([
                'result' => false,
                'message' => 'Forum Post ID, comment ID and reply are required'
            ]);
            return;
        }

        $forum_post_id = $this->CommonModel->getData('tbl_forum_questions', ['id' => $forum_id, 'deleted_by' => NULL], 'id', '', 'row_array');

        if (!$forum_post_id) {
            echo json_encode([
                'result' => false,
                'message' => 'Invalid forum post ID'
            ]);
            return;
        }
        $isCommentExists = $this->CommonModel->getData('tbl_forum_answers', ['id' => $parent_id, 'forum_id' => $forum_id], 'id', '', 'row_array');

        if (!$isCommentExists) {
            echo json_encode([
                'result' => false,
                'message' => 'Invalid parent comment'
            ]);
            return;
        }

        $reply_data = [
            'forum_id'   => $forum_id,
            'user_id'    => $this->regId,
            'answer'     => $reply_text,
            'parent_id'  => $parent_id,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => $this->regId
        ];
        $insert_id = $this->CommonModel->iudAction(
            'tbl_forum_answers',
            $reply_data,
            'insert'
        );
        if (!$insert_id) {
            echo json_encode([
                'result' => false,
                'message' => 'Failed to add reply'
            ]);
            return;
        }

        echo json_encode([
            'result' => true,
            'message' => 'Reply added successfully',

        ]);
    }
    public function postCommentUpdate()
    {
        authenticateUser();

        $login_user_id  = $this->regId;
        $comment_id     = $this->input->post('comment_id');
        $forum_post_id  = $this->input->post('forum_post_id');
        $comment_text   = $this->input->post('comment');
        // print_r($login_user_id);
        // die;
        // Validation
        if (empty($comment_id) || empty($forum_post_id) || empty($comment_text)) {
            echo json_encode([
                'result' => false,
                'message' => 'comment_id, forum_post_id, and comment are required'
            ]);
            return;
        }

        // Check if comment exists and belongs to logged-in user
        $existingComment = $this->CommonModel->getData(
            'tbl_forum_answers',
            [
                'id' => $comment_id,
                'forum_id' => $forum_post_id,
                'user_id' => $login_user_id
            ],
            '*',
            '',
            'row_array'
        );

        if (!$existingComment) {
            echo json_encode([
                'result' => false,
                'message' => 'Comment not found or you are not allowed to edit it'
            ]);
            return;
        }

        // Update comment
        $update = $this->CommonModel->iudAction(
            'tbl_forum_answers',
            ['answer' => $comment_text, 'updated_at' => date('Y-m-d H:i:s')],
            'update',
            ['id' => $comment_id]
        );

        if ($update) {
            echo json_encode([
                'result' => true,
                'message' => 'Comment updated successfully'
            ]);
        } else {
            echo json_encode([
                'result' => false,
                'message' => 'Failed to update comment'
            ]);
        }
    }

    public function postCommentDelete()
    {
        authenticateUser();

        $login_user_id = $this->regId;
        $comment_id    = $this->input->post('comment_id');

        // Validation
        if (empty($comment_id)) {
            echo json_encode([
                'result' => false,
                'message' => 'Comment ID is required'
            ]);
            return;
        }


        $comment = $this->CommonModel->getData(
            'tbl_forum_answers',
            [
                'id'      => $comment_id,
                'user_id' => $login_user_id
            ],
            '*',
            '',
            'row_array'
        );

        if (!$comment) {
            echo json_encode([
                'result' => false,
                'message' => 'Comment not found or you are not allowed to delete it'
            ]);
            return;
        }

        // Soft delete (recommended)
        $deleted = $this->CommonModel->iudAction(
            'tbl_forum_answers',
            [
                'deleted_by' => $login_user_id,
                'deleted_at' => date('Y-m-d H:i:s')
            ],
            'update',
            ['id' => $comment_id]
        );
        $child_comment = $this->CommonModel->iudAction(
            'tbl_forum_answers',
            [
                'deleted_by' => $login_user_id,
                'deleted_at' => date('Y-m-d H:i:s')
            ],
            'update',
            ['parent_id' => $comment_id]
        );


        if ($deleted) {
            echo json_encode([
                'result'  => true,
                'message' => 'Comment deleted successfully'
            ]);
        } else {
            echo json_encode([
                'result'  => false,
                'message' => 'Failed to delete comment'
            ]);
        }
    }
}
