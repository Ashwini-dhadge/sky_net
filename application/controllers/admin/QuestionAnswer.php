<?php

class QuestionAnswer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'QuestionModel');
        $this->load->model('CommonModel');
    }

    public function index()
    {
        loginId();

        $data['title']  = 'Question & Answers';
        $data['active'] = 'Question & Answers';

        $data['courses'] = $this->CommonModel->getData(
            'tbl_courses',
            ['deleted_at' => null],
            'id, title'
        );

        $this->load->view(ADMIN . QUESTION . 'list-Question', $data);
    }

    private function formatDate($date)
    {
        return $date ? date('d M Y h:i A', strtotime($date)) : '-';
    }

    public function Question_list()
    {
        $course_id  = $this->input->post('course_id');
        $unanswered = $this->input->post('unanswered');

        $questions = $this->QuestionModel->getallQuestion($course_id, $unanswered);
        // echo '<pre>'; print_r($questions);die();
        $output = [];
        $sr_no  = 1;

        foreach ($questions as $value) {
            $askedByName = trim(
                ($value['asked_first_name'] ?? '') . ' ' .
                    ($value['asked_last_name'] ?? '')
            );

            if ($askedByName === '') {
                $askedByName = '-';
            }

            $askedDate = $this->formatDate($value['asked_at']);
            $askedBy   = $askedByName . '<br><small class="text-muted">[' . $askedDate . ']</small>';

            $answeredByName = trim(
                ($value['answered_first_name'] ?? '') . ' ' . ($value['answered_last_name'] ?? '')
            );

            if ($answeredByName === '') {
                $answeredByName = '-';
            }

            $answeredDate = $value['answered_at']
                ? $this->formatDate($value['answered_at'])
                : '-';

            $answeredBy = $answeredByName . '<br><small class="text-muted">[' . $answeredDate . ']</small>';

            $answerPreview = $value['answer']
                ? mb_substr($value['answer'], 0, 500) . '...'
                : '<span class="badge badge-warning">Pending</span>';

            $actionBtn = '
            <button class="btn btn-sm btn-primary mr-1"
                onclick=\'openAnswerModal('
                . $value['id'] . ','
                . json_encode($value['question']) . ','
                . json_encode($askedBy) . ','
                . json_encode($answeredBy) . ','
                . json_encode($value['answer'] ?? '')
                . ')\'>
                <i class="fas fa-edit"></i>
            </button>
        ';

            array_push($output, [
                $sr_no++,
                '<a href="' . base_url() . 'admin/Course/View/' . $value['course_id'] . '">'
                    . $value['course_title'] .
                    '</a>',
                $askedBy,
                $value['question'],
                $answerPreview,
                $answeredBy,
                $actionBtn
            ]);
        }

        echo json_encode(['data' => $output]);
    }


    public function askQuestion()
    {
        $data = [
            'course_id'   => $this->input->post('course_id'),
            'user_id'     => loginId(),
            'question'    => $this->input->post('question'),

            'created_at'  => date('Y-m-d H:i:s'),
            'created_by'  => loginId(),

            'answer'          => null,
            'ans_created_at'  => null,
            'ans_created_by'  => null,
            'ans_updated_at'  => null,
            'ans_updated_by'  => null
        ];

        $this->CommonModel->iudAction(
            'tbl_course_qna',
            $data,
            'insert'
        );

        echo json_encode(['status' => true]);
    }

    public function saveAnswer()
    {
        $id     = $this->input->post('id');
        $answer = trim($this->input->post('answer'));

        $qna = $this->CommonModel->getData(
            'tbl_course_qna',
            ['id' => $id],
            'answer',
            '',
            'row_array'
        );

        $updateData = [
            'answer'         => $answer,
            'ans_updated_at' => date('Y-m-d H:i:s'),
            'ans_updated_by' => loginId()
        ];

        if (empty($qna['answer'])) {
            $updateData['ans_created_at'] = date('Y-m-d H:i:s');
            $updateData['ans_created_by'] = loginId();
        }

        $this->CommonModel->iudAction(
            'tbl_course_qna',
            $updateData,
            'update',
            ['id' => $id]
        );

        echo json_encode(['status' => true]);
    }

    public function deleteAnswer()
    {
        $id = $this->input->post('id');

        if (!$id) {
            echo json_encode(['status' => false]);
            return;
        }

        $this->CommonModel->iudAction(
            'tbl_course_qna',
            [
                'answer'          => null,
                'ans_created_at'  => null,
                'ans_created_by'  => null,
                'ans_updated_at'  => null,
                'ans_updated_by'  => null
            ],
            'update',
            ['id' => $id]
        );

        echo json_encode(['status' => true]);
    }
}
