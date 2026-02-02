<?php

class QuestionAnswer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(ADMIN . 'QuestionModel');
    }

    public function index()
    {
        loginId();

        $data['title'] = 'Question & Answers';
        $data['active'] = 'Question & Answers';

        $data['courses'] = $this->db
            ->select('id, title')
            ->from('tbl_courses')
            ->where('deleted_at IS NULL')
            ->get()
            ->result_array();

        $this->load->view(ADMIN . QUESTION . 'list-Question', $data);
    }

    private function formatDate($date)
    {
        return $date ? date('d M Y h:i A', strtotime($date)) : '-';
    }


    /* ===== EXISTING LIST (UNCHANGED) ===== */
    public function Question_list()
    {
        $course_id  = $this->input->post('course_id');
        $unanswered = $this->input->post('unanswered');

        $questions = $this->QuestionModel->getallQuestion($course_id, $unanswered);

        $output = [];
        $sr_no = 1; // ✅ START SERIAL NUMBER

        foreach ($questions as $value) {

            $askedByName = trim(
                ($value['asked_first_name'] ?? '') . ' ' .
                    ($value['asked_last_name'] ?? '')
            ) ?: '-';
            $askedDate = $this->formatDate($value['asked_at']);
            $askedBy = $askedByName . '<br><small class="text-muted">[' . $askedDate . ']</small>';


            $answeredByName = trim(
                ($value['answered_first_name'] ?? '') . ' ' .
                    ($value['answered_last_name'] ?? '')
            ) ?: '-';
            $answeredDate = $value['answered_at']
                ? $this->formatDate($value['answered_at'])
                : '-';
            $answeredBy = $answeredByName . '<br><small class="text-muted">[' . $answeredDate . ']</small>';


            $output[] = [
                $sr_no++,
                // $value['course_title'],
                '<a href="' . base_url() . 'admin/Course/View/' . $value['course_id'] . '">' . $value['course_title'] . '</a>',
                $askedBy,
                $value['question'],
                $value['answer']
                    ? mb_substr($value['answer'], 0, 500) . '...'
                    : '<span class="badge badge-warning">Pending</span>',
                $answeredBy,
                '<button class="btn btn-sm btn-primary mr-1"
                    onclick="openAnswerModal(
                        ' . $value['id'] . ',
                        `' . htmlspecialchars($value['question'], ENT_QUOTES) . '`,
                        `' . htmlspecialchars($askedBy, ENT_QUOTES) . '`,
                        `' . htmlspecialchars($answeredBy, ENT_QUOTES) . '`,
                        `' . htmlspecialchars($value['answer'] ?? '', ENT_QUOTES) . '`
                    )">
                    <i class="fas fa-edit"></i>
                </button>'

            ];
        }

        echo json_encode(['data' => $output]);
    }

    public function askQuestion()
    {
        $data = [
            'course_id'   => $this->input->post('course_id'),
            'user_id'     => loginId(), // student/user
            'question'    => $this->input->post('question'),

            // 👇 ASK TIMESTAMP
            'created_at'  => date('Y-m-d H:i:s'),
            'created_by'  => loginId(),

            // 👇 ANSWER FIELDS EMPTY
            'answer'          => NULL,
            'ans_created_at'  => NULL,
            'ans_created_by'  => NULL,
            'ans_updated_at'  => NULL,
            'ans_updated_by'  => NULL
        ];

        $this->db->insert('tbl_course_qna', $data);

        echo json_encode(['status' => true]);
    }



    /* ===== SAVE ANSWER ===== */
    public function saveAnswer()
    {
        $id     = $this->input->post('id');
        $answer = trim($this->input->post('answer'));

        // if (!$id || $answer === '') {
        //     echo json_encode(['status' => false, 'msg' => 'Invalid data']);
        //     return;
        // }

        // Check if answer already exists
        $qna = $this->db
            ->select('answer')
            ->from('tbl_course_qna')
            ->where('id', $id)
            ->get()
            ->row_array();

        $updateData = [
            'answer'         => $answer,
            'ans_updated_at' => date('Y-m-d H:i:s'),
            'ans_updated_by' => loginId()
        ];

        // 👇 FIRST TIME ANSWER
        if (empty($qna['answer'])) {
            $updateData['ans_created_at'] = date('Y-m-d H:i:s');
            $updateData['ans_created_by'] = loginId();
        }

        $this->db->where('id', $id)->update('tbl_course_qna', $updateData);

        echo json_encode(['status' => true]);
    }


    public function deleteAnswer()
    {
        $id = $this->input->post('id');

        if (!$id) {
            echo json_encode(['status' => false]);
            return;
        }

        $this->db->where('id', $id)->update('tbl_course_qna', [
            'answer'          => NULL,
            'ans_created_at'  => NULL,
            'ans_created_by'  => NULL,
            'ans_updated_at'  => NULL,
            'ans_updated_by'  => NULL
        ]);

        echo json_encode(['status' => true]);
    }
}
