<?php
class UserModel extends CI_Model
{

	protected $order_Column = array(
                                    'u.id',                                  
									'u.first_name',
                                    'u.last_name',                                    
									'u.mobile_no',
									'u.email',
									'u.status',
									''
                                                                  

							);
    protected $user_Column = array(
                                    'cr.id',                                  
                                    'cr.exam_title',
                                    
                                                                  

                            );

	public function getUserData($searchVal='',$sortColIndex=0,$sortBy='desc',$limit=0, $offset=0,$id=0,$role_id=0)
     {

        $this->db->select('u.*');
        if ($id) {
            $this->db->where('u.id', $id);           
        }

        if (strlen($searchVal)) {
            $searchCondition = "(     
             
                u.first_name like '%$searchVal%' or 
                u.last_name like '%$searchVal%' or 
                u.mobile_no like '%$searchVal%' or   
                u.email like '%$searchVal%'             
               
            )";
            $this->db->where($searchCondition);
        }
       
        if ($role_id) {
            $this->db->where('u.role', $role_id);           
        }
        $this->db->where('u.is_deleted', 0);

        $this->db->from('tbl_users u');
    
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->order_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();
     //echo $this->db->last_query();die();
        return $query->result_array();
    }

    public function getUserCourseData($searchVal='',$sortColIndex=0,$sortBy='desc',$limit=0, $offset=0,$id=0,$where='')
     {

        $this->db->select('od.*,o.order_no,c.title as course_name,dm.name as duration_name,dm.no_of_days,o.date as order_date,o.order_status');
        if ($id) {
            $this->db->where('u.id', $id);           
        }

        if (strlen($searchVal)) {
            $searchCondition = "(     
             
                u.first_name like '%$searchVal%' or 
                u.last_name like '%$searchVal%' or 
                u.mobile_no like '%$searchVal%' or   
                u.email like '%$searchVal%'             
               
            )";
            $this->db->where($searchCondition);
        }
       
        if ($where) {
            $this->db->where($where);           
        }
        $this->db->where('u.is_deleted', 0);
        $this->db->where('o.payment_status', 1);
        //$this->db->where('od.type', 1);
        

        $this->db->from('tbl_orders o');
        $this->db->join('tbl_order_details as od', 'od.order_id =o.id');
        $this->db->join('tbl_users as u', 'u.id =o.user_id');
        $this->db->join('tbl_courses as c', 'c.id =od.courses_id');
        $this->db->join('tbl_courses_duration as cd', 'cd.id =od.courses_duration_id','left');
        $this->db->join('tbl_duration_master as dm', 'dm.id =cd.duration_id','left');
    


        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->order_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();
     //echo $this->db->last_query();die();
        return $query->result_array();
    }

 
      public function getUserName($searchVal='')
    {
        $this->db->select('concat( p.first_name," ",p.last_name) as name,p.id');         
        if($searchVal){
                $searchCondition = "(            
                   p.first_name like '%$searchVal%'   or         
                   p.last_name like '%$searchVal%'
  
                )";
              $this->db->where($searchCondition);
            }  
        $this->db->where('p.role',3);
        $result = $this->db->get('tbl_users as p')->result_array();
    
        return $result; 
    }
     

      function getUserChallengeMCQData($searchVal='',$sortColIndex=0,$sortBy='desc',$limit=0, $offset=0,$id=0,$where=''){
         
        $this->db->select(' challenge_mcq_id,solved_mcq,result,cr.total_marks ,solved_duration ,r.rank,r.badges_image,cm.exam_title,cm.description,cm.exam_duration,cm.is_negative,cm.no_of_question,cm.total_marks as out_of_mark,cr.created_at as exam_date'); 
        $this->db->from('tbl_challenge_result cr');
        $this->db->join('tbl_challenge_mcq cm','cm.id =cr.challenge_mcq_id');
        $this->db->join('tbl_rank_master r','r.id =cr.rank_id');
       
        $this->db->where($where);
      
        $this->db->where('cr.deleted_by',NULL);

        if (strlen($searchVal)) {
            $searchCondition = "(     

                cm.exam_title like '%$searchVal%' or 
                cm.description like '%$searchVal%' or 
                cm.exam_duration like '%$searchVal%' 
              
            )";
            $this->db->where($searchCondition);
        }
       
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->user_Column[$sortColIndex], $sortBy);
        $result = $this->db->get();
        $challenges=$result->result_array();
        foreach($challenges as $key=>$value){
             $mcq=json_decode($value['solved_mcq'],true);
             $mcq_result=json_decode($value['result'],true);
          // print_r($mcq_result);die();
          
                 $challenges[$key]['correct_question']=$mcq_result['correct_question'];
                 $challenges[$key]['wrong_question']=$mcq_result['wrong_question'];
           
             unset($challenges[$key]['result']);
             unset($challenges[$key]['solved_mcq']);
            foreach($mcq as $key1=>$value1){
                    if($value1['q_id'] && $value1['actual_ans'] && $value1['user_ans']){
                        $questions_ids[]=$value1['q_id'];
                        $user_answer_ids[]=$value1['user_ans'];
                        
                    }
                }
                $where3['challenge_mcq_id']= $value['challenge_mcq_id'];
              
        }
        return $challenges;
      
    }

    function getUserVideoMCQData($searchVal='',$sortColIndex=0,$sortBy='desc',$limit=0, $offset=0,$id=0,$where=''){
         
        $this->db->select(' cr.lesson_video_id,solved_mcq,result,cr.total_marks ,cr.created_at as exam_date,v.title as exam_title,cr.no_of_question'); 
        $this->db->from('tbl_lesson_user_video cr');
        $this->db->join('tbl_lesson_video lv','lv.id =cr.lesson_video_id');
         $this->db->join('tbl_video_master v','v.id =lv.video_id');
       
        $this->db->where($where);
          $searchCondition = "(     

                cm.exam_title like '%$searchVal%'  
               
            )";
        $this->db->where('cr.deleted_by',NULL);
        $this->db->where('cr.solved_mcq is not null');
        $this->db->where('cr.result is not null');
        $result = $this->db->get();
        $challenges=$result->result_array();
        foreach($challenges as $key=>$value){           

            $challenges[$key]['no_of_question']=$value['no_of_question'];
            $challenges[$key]['out_of_mark']=$value['no_of_question']*VIDEO_QUESTION_CORRECT_PER_MARK;;
        
        }
        return $challenges;
      
    }
    public function getUserWalletData($searchVal='', $sortColIndex='0', $sortBy='DESC', $limit='0', $offset='0',$id='', $where='' )
    {
        $this->db->select('*');
        $this->db->from('wallet_transaction');

        if ($where) {
            $this->db->where($where);
        }
        if($id) 
        {
            $this->db->where('o.id',$id);
        }
     
        
         if($searchVal){
            $searchCondition = "(
                amount like '%$searchVal%' or                 
                trans_details like '%$searchVal%' or 
                wallet_type like '%$searchVal%'
            )";
          $this->db->where($searchCondition);
        }
        
        if($limit || $offset){
            $this->db->limit($limit, $offset);
        }
       
       $result = $this->db->get()
                           ->result_array();
       
        return  $result;

    }
    
}
  ?>