<?php

use PhpOffice\PhpSpreadsheet\Shared\Date;

class Forum extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'ForumModel');
        $this->load->model('CommonModel');
    }


    public function pending_list()
    {
        $data = $_POST;
        // echo $this->session->userdata('role');die;
        $columns = [];
        $page  = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];
        $status = $data['status'] ?? 0;

        $ForumData = $this->ForumModel->getNonApprovedQuestions(
            $status,
            $searchVal,
            $sortColIndex,
            $sortBy,
            $limit,
            $offset
        );


        $count = count($ForumData);


        if ($count) {

            foreach ($ForumData as $key => $forum) {

                $row = [];

                array_push($row, $offset + ($key + 1));
                array_push($row, $forum['title']);
                array_push($row, $forum['asked_by']);

                switch ($status) {

                    case 1:
                        $is_approved = '
                        <span class="badge badge-success px-3 py-2">
                            <i class="fa fa-check mr-1"></i> Approved
                        </span>';
                        break;

                    case 2:
                        $is_approved = '
                        <span class="badge badge-danger px-3 py-2">
                            <i class="fa fa-times mr-1"></i> Rejected
                        </span>';
                        break;

                    default:
                        $is_approved = '
                        <span class="badge badge-warning px-3 py-2">
                            <i class="fa fa-clock mr-1"></i> Pending
                        </span>';
                }

                array_push($row, $is_approved);
                $action = '';

                if ($this->session->userdata('role') == 1) {

                    if ($status == 0) {
                        $action = '
                        <div class="btn-group shadow-sm">

                            <button class="btn btn-success btn-sm approve"
                                data-id="' . $forum['id'] . '"
                                title="Approve">
                                <i class="fa fa-check"></i>
                            </button>

                            <button class="btn btn-danger btn-sm reject"
                                data-id="' . $forum['id'] . '"
                                title="Reject">
                                <i class="fa fa-times"></i>
                            </button>

                        </div>';
                    } elseif ($status == 2) {
                        $action = '
                        <button class="btn btn-warning btn-sm returnPending"
                            data-id="' . $forum['id'] . '"
                            title="Return to Pending">
                            <i class="fa fa-undo"></i> Return
                        </button>';
                    }
                }


                array_push($row, $action);
                $columns[] = $row;
            }
        }

        echo json_encode([
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $count,
            'recordsFiltered' => $count
        ]);
    }


    public function approved_list()
    {
        $data = $this->input->post();

        $page  = $data['draw'] ?? 1;
        $limit = $data['length'] ?? 1000;
        $offset = $data['start'] ?? 0;
        $searchVal = $data['search']['value'] ?? '';
        $sortColIndex = $data['order'][0]['column'] ?? 0;
        $sortBy = $data['order'][0]['dir'] ?? 'desc';

        $ForumData = $this->ForumModel->getApprovedQuestions(
            $searchVal,
            $sortColIndex,
            $sortBy,
            $limit,
            $offset
        );

        $totalCount = $this->db
            ->where('is_approved', 1)
            ->where('deleted_at IS NULL', null, false)
            ->count_all_results('tbl_forum_questions');


        if ($totalCount) {

            foreach ($ForumData as $key => $forum) {

                $answers = $this->db
                    ->where('forum_id', $forum['id'])
                    ->where('deleted_at', null)
                    ->count_all_results('tbl_forum_answers');

                $row = [];

                array_push($row, $forum['id']);
                array_push($row, $forum['title']);
                array_push($row, $forum['asked_by']);
                array_push($row, $forum['description']);
                array_push($row, $forum['tags']);
                $formattedDate = '-';

                if (!empty($forum['created_at'])) {
                    $dt = DateTime::createFromFormat('Y-m-d H:i:s', $forum['created_at']);
                    if ($dt !== false) {
                        $formattedDate = $dt->format('d-m-Y h:i A');
                    }
                }
                array_push($row, $formattedDate);
                array_push($row, $answers);



                $columns[] = $row;
            }
        }

        echo json_encode([
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $totalCount,
            'recordsFiltered' => $totalCount
        ]);
    }


    public function pending()
    {
        $data['title'] = "Question Approval";
        $this->load->view(ADMIN . FORUM . 'list-pending', $data);
    }

    public function listing()
    {
        $data['title'] = "Forum Listing";
        $this->load->view(ADMIN . FORUM . 'list-listing', $data);
    }


    public function approve()
    {
        $this->CommonModel->iudAction(
            'tbl_forum_questions',
            [
                'is_approved' => 1,
                'approved_at' => date('Y-m-d H:i:s'),
                'approved_by' => loginId(),
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => loginId()
            ],
            'update',
            ['id' => $this->input->post('id')]
        );
        $this->ForumModel->logAction([
            'forum_id'    => $this->input->post('id'),
            'is_approved' => 1,
            'remark'      => NULL,
            'created_by'  => loginId(),
            'created_at'  => date('Y-m-d H:i:s')
        ]);



        $this->session->set_flashdata('success', 'Question Approved!');
    }

    public function reject()
    {
        $id     = $this->input->post('id');
        $reason = $this->input->post('reason');

        $this->CommonModel->iudAction(
            'tbl_forum_questions',
            [
                'is_approved' => 2,
                'remark'      => $reason,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => loginId(),
                'deleted_at' => date('Y-m-d H:i:s'),
                'deleted_by' => loginId()
            ],
            'update',
            ['id' => $id]
        );

        $this->ForumModel->logAction([
            'forum_id'    => $id,
            'is_approved' => 2,
            'remark'      => $reason,
            'created_by'  => loginId(),
            'created_at'  => date('Y-m-d H:i:s')
        ]);


        $this->session->set_flashdata('error', 'Question Rejected!');
    }

    public function returnToPending()
    {
        $id = $this->input->post('id');

        if (!$id) {
            echo json_encode(['status' => false]);
            return;
        }

        $this->CommonModel->iudAction(
            'tbl_forum_questions',
            [
                'is_approved' => 0,
                'remark'      => NULL,
                'deleted_at' => NULL,
                'deleted_by' => NULL,
                'updated_at' => date('Y-m-d H:i:s'),
                'updated_by' => loginId()
            ],
            'update',
            ['id' => $id]
        );

        $this->ForumModel->logAction([
            'forum_id'    => $id,
            'is_approved' => 0,
            'remark'      => 'Returned to pending',
            'created_by'  => loginId(),
            'created_at'  => date('Y-m-d H:i:s')
        ]);


        echo json_encode(['status' => true]);
    }



    public function deleteAnswer()
    {
        $this->CommonModel->iudAction(
            'tbl_forum_answers',
            ['deleted_at' => date('Y-m-d H:i:s')],
            'update',
            ['id' => $this->input->post('id')]
        );
        $this->session->set_flashdata('success', 'Answer deleted successfully');
    }

    public function answers_json($id)
    {
        $list = $this->ForumModel->getAnswersByQuestion($id);
        echo json_encode([
            "data" => $list
        ]);
    }


    public function addQuestion()
    {
        $title       = $this->input->post('title');
        $description = $this->input->post('description');
        $tags        = $this->input->post('tags');
        $tagString = '';

        if (!empty($tags)) {
            $tagString = implode(',', $tags);
        }
        $this->CommonModel->iudAction(
            'tbl_forum_questions',
            [
                'title'       => $title,
                'description' => $description,
                'tags'        => $tagString,
                'is_approved'  => 1,
                'user_id'     => loginId(),
                'created_at'  => date('Y-m-d H:i:s')
            ],
            'insert'
        );
        if (!empty($tags)) {

            foreach ($tags as $tag) {
                $this->CommonModel->iudAction(
                    'tbl_forum_tags',
                    [
                        'tag_name'    => trim($tag),
                        'created_at'  => date('Y-m-d H:i:s')
                    ],
                    'insert'
                );
            }
        }
        echo json_encode(['status' => true]);
    }


    public function addAnswer()
    {
        $this->CommonModel->iudAction(
            'tbl_forum_answers',
            [
                'forum_id' => $this->input->post('forum_id'),
                'answer' => $this->input->post('answer'),
                'user_id' => loginId(),
                'created_at' => date('Y-m-d H:i:s')
            ],
            'insert'
        );
        $this->session->set_flashdata('success', 'Answer added successfully');
    }


    public function deleteQuestion()
    {
        $id = $this->input->post('id');

        if (!$id) {
            echo json_encode(['status' => false]);
            return;
        }

        $now = date('Y-m-d H:i:s');
        $user = loginId();

        $this->CommonModel->iudAction(
            'tbl_forum_questions',
            [
                'deleted_at' => $now,
                'deleted_by' => $user
            ],
            'update',
            ['id' => $id]
        );

        $this->CommonModel->iudAction(
            'tbl_forum_answers',
            [
                'deleted_at' => $now,
                'deleted_by' => $user
            ],
            'update',
            ['forum_id' => $id]
        );

        echo json_encode(['status' => true]);
    }

    public function detail_view($id)
    {
        $question = $this->ForumModel->getQuestionById($id);
        $answers = $this->ForumModel->getAnswersWithUser($id);

        $recentQuestions = $this->ForumModel->getRandomQuestions(5, $id);

        $data['title'] = 'Forum Details';
        $data['question'] = $question;
        $data['answers'] = $answers;
        $data['recentQuestions'] = $recentQuestions;

        $this->load->view(ADMIN . FORUM . 'details_view', $data);
    }
}
