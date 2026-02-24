<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Courses_model
 * Check Duplication
 */

class MCQ_model extends CI_Model
{
    function getChallengeData()
    {
        /*
            SELECT cq.*, COUNT(vc.id) as_count_of_no_question FROM `tbl_challenge_mcq` cq
            left join `view_challenge_mcq_questions` vc on vc.challenge_mcq_id=cq.id GROUP by cq.id HAVING COUNT(vc.id)>= cq.no_oF_question
*/
        $this->db->select('cq.*, COUNT(vc.id) as_count_of_no_question ');
        $this->db->from('tbl_challenge_mcq cq');
        $this->db->join('view_challenge_mcq_questions vc', 'vc.challenge_mcq_id=cq.id');
        $this->db->group_by('cq.id');
        $this->db->having('COUNT(vc.id)>= cq.no_oF_question');
        $this->db->where('cq.status', 1);
        $query = $this->db->get();


        return $query->result_array();
    }

    function getChallengeMCQData($where = array(), $search = "", $limit = 0, $offset = 0, $where_in = "", $is_shuffle = 1, $no_of_question = DISPLAY_NO_OF_QUESTION)
    {

        $this->db->select('id as q_id, skill_id,is_challenge,question,answer,explantion,option_1,option_2,option_3,option_4,option_5 ,""as user_answer');
        $this->db->from('view_challenge_mcq_questions');

        if ($search) {

            $searchVal = "(
                        question like '%$search%' or
                        answer like '%$search%' 
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);
        if ($where_in) {
            $this->db->where_in('id', $where_in);
        }
        $this->db->where('deleted_by', NULL);
        if ($is_shuffle) {
            $this->db->order_by('rand()');
            $this->db->limit($no_of_question);
        } else {
            if ($where_in) {
                $order = sprintf('FIELD(id, %s)', implode(', ', $where_in));
                $this->db->order_by($order);
            }
        }

        $result = $this->db->get();

        return $result->result_array();
    }

    function getRankIdData($percentage)
    {
        $this->db->select('* ');
        $this->db->from('tbl_rank_master');
        $this->db->where('percentage_to >=', $percentage);
        $this->db->where('percentage_from <=', $percentage);
        $this->db->where('deleted_by', NULL);
        $query = $this->db->get();
        return $query->row_array();
    }

    function getRankIdVidoMCQData($percentage)
    {
        $this->db->select('* ');
        $this->db->from('tbl_video_mcq_rank_master');
        $this->db->where('percentage_to >=', $percentage);
        $this->db->where('percentage_from <=', $percentage);
        $this->db->where('deleted_by', NULL);
        $query = $this->db->get();
        return $query->row_array();
    }


    function getUserChallengeMCQData($where = array())
    {

        $this->db->select(' challenge_mcq_id,solved_mcq,result,cr.total_marks,cr.percentage ,solved_duration ,r.rank,r.badges_image,cm.exam_title,cm.description,cm.exam_duration,cm.is_negative,cm.no_of_question,cm.total_marks as out_of_mark,cr.created_at as exam date');
        $this->db->from('tbl_challenge_result cr');
        $this->db->join('tbl_challenge_mcq cm', 'cm.id =cr.challenge_mcq_id');
        $this->db->join('tbl_rank_master r', 'r.id =cr.rank_id');

        $this->db->where($where);

        $this->db->where('cr.deleted_by', NULL);
        $result = $this->db->get();
        $challenges = $result->result_array();
        foreach ($challenges as $key => $value) {
            $mcq = json_decode($value['solved_mcq'], true);
            $mcq_result = json_decode($value['result'], true);
            //   print_r($mcq);die();

            $challenges[$key]['correct_question'] = $mcq_result['correct_question'];
            $challenges[$key]['wrong_question'] = $mcq_result['wrong_question'];

            unset($challenges[$key]['result']);
            unset($challenges[$key]['solved_mcq']);

            // foreach($mcq as $key1=>$value1){
            //         if($value1['q_id'] && $value1['actual_ans']){
            //             $questions_ids[]=$value1['q_id'];
            //             $user_answer_ids[]=$value1['user_ans'];
            //         }
            //     }
            $questions_ids = array_column($mcq, 'q_id');
            $user_answer_ids = array_column($mcq, 'user_ans');
            $where3['challenge_mcq_id'] = $value['challenge_mcq_id'];

            $question_set = $this->getChallengeMCQData($where3, '', 0, 0, $questions_ids, 0);

            foreach ($question_set as $key3 => $value3) {
                // var_dump($value3);
                $key34 = array_search($value3['q_id'], $questions_ids);
                $question_set[$key3]['user_answer'] = $user_answer_ids[$key34];
            } //die;

            $challenges[$key]['question'] = $question_set;
        }
        return $challenges;
    }

    function getUserVideoMCQData($where = array())
    {

        $this->db->select(' cr.lesson_id,solved_mcq,result,cr.total_marks ,cr.created_at as exam date,cr.no_of_question,cr.solved_duration,l.exam_duration');
        $this->db->from('tbl_lesson_user_video cr');
        $this->db->join('tbl_lesson l', 'l.id =cr.lesson_id');
        // $this->db->join('tbl_lesson_video lv', 'lv.id =cr.lesson_video_id');
        // $this->db->join('tbl_video_master v', 'v.id =lv.video_id');

        $this->db->where($where);

        $this->db->where('cr.deleted_by', NULL);
        $this->db->where('cr.solved_mcq is not null');
        $this->db->where('cr.result is not null');
        $this->db->where('cr.solved_mcq !=""');
        $result = $this->db->get();
        $challenges = $result->result_array();
        //echo  $this->db->last_query();die;
        foreach ($challenges as $key => $value) {

            $challenges[$key]['no_of_question'] = $value['no_of_question'];
            $challenges[$key]['out_of_mark'] = $value['no_of_question'] * VIDEO_QUESTION_CORRECT_PER_MARK;;

            $mcq = json_decode($value['solved_mcq'], true);
            $mcq_result = json_decode($value['result'], true);

            $challenges[$key]['correct_question'] = $mcq_result['correct_question'];
            $challenges[$key]['wrong_question'] = $mcq_result['wrong_question'];

            $percentage = ($challenges[$key]['correct_question'] * VIDEO_QUESTION_CORRECT_PER_MARK / $challenges[$key]['out_of_mark']) * 100;
            $challenges[$key]['final_percentage'] = number_format((float)$percentage, 2, '.', '');
            // print_r($challenges);
            unset($challenges[$key]['result']);
            unset($challenges[$key]['solved_mcq']);
            foreach ($mcq as $key1 => $value1) {
                if ($value1['q_id'] && $value1['actual_ans']) {
                    // $where3['lesson_video_id'] = $value['lesson_video_id'];
                    $where3['id'] = $value1['q_id'];
                    $question = $this->getLessonVideoMCQData($where3, '', 0, 0, '', 0);
                    $question[0]['user_answer'] = $value1['user_ans'];
                    $question_set[] = $question[0];
                    // $question_set[] = '';
                }
            }
            $challenges[$key]['question'] = $question_set;
        }
        return $challenges;
    }
    function getLessonVideoMCQData($where = array(), $search = "", $limit = 0, $offset = 0, $where_in = "", $is_shuffle = 1)
    {
        $this->db->select('id as q_id,question,correct_option as answer,option_a as option_1,option_b as option_2,option_c as option_3,option_d as option_4');
        $this->db->from('tbl_lesson_mcq');
        if ($search) {

            $searchVal = "(
                        question like '%$search%' or
                        answer like '%$search%' 
                        )";
            $this->db->where($searchVal);
        }

        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        $this->db->where($where);

        if ($where_in) {
            $this->db->where_in('id', $where_in);
        }

        $this->db->where('deleted_by', NULL);

        // $this->db->order_by('id', 'desc');
        if ($is_shuffle) {
            $this->db->order_by('rand()');
            $this->db->limit(DISPLAY_NO_OF_QUESTION);
        } else {
            if ($where_in) {
                $where_in_str = implode(",", $where_in);
                $where_empty = str_replace(', ', ',', $where_in_str);
                $this->db->order_by("FIND_IN_SET(id,'" . $where_empty . "')", '', 'false');
            }
        }

        $result = $this->db->get();

        return $result->result_array();
    }
}