<?php
class CourseModel extends CI_Model
{

    protected $dt_Column = array(
        'c.id',
        'c.title',
        'c.sort_by',
        'c.status',
        ''
    );
    protected $lt_Column = array(
        'l.id',
        'c.title',
        'l.price',
        'l.duration',
        'l.status',
        ''
    );
    protected $st_Column = array(
        '',
        '',

    );

    protected $cd_Column = array(
        'cd.id',
        ''
    );

    public function getInstructors()
    {
        return $this->db
            ->select('id, first_name, last_name')
            ->from('tbl_users')
            ->where('role', 4)
            ->where('is_deleted', 0)
            ->where('status', 1) // usually 1 = active (adjust if needed)
            ->get()
            ->result_array();
    }

    public function getCourseResources()
    {
        return $this->db
            ->from('tbl_course_resources tcr')
            ->select('tcr.*, c.title as course_title')
            ->join('tbl_courses c', 'c.id = tcr.course_id', 'left')
            ->where('tcr.course_id', $this->input->post('course_id'))
            ->where('tcr.deleted_at', NULL)
            ->get()
            ->result_array();
    }

    // public function getCourseResources($limit, $start)
    // {
    //     return $this->db
    //         ->where('deleted_at', NULL)
    //         ->limit($limit, $start)
    //         ->order_by('id', 'DESC')
    //         ->get('tbl_course_resources')
    //         ->result_array();
    // }

    public function countCourseResources()
    {
        return $this->db
            ->where('deleted_at', NULL)
            ->count_all_results('tbl_course_resources');
    }



    public function getCourseData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = 0)
    {

        $this->db->select('c.*,cc.category_name');
        if ($id) {
            $this->db->where('c.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(               
                c.title  like '%$searchVal%' or 
                cc.category_name like '%$searchVal%' or 
                c.status like '%$searchVal%' 
            )";
            $this->db->where($searchCondition);
        }


        $this->db->from('tbl_courses c');
        $this->db->join('tbl_categories as cc', 'cc.id =c.category_id');
        $this->db->where('c.deleted_by', NULL);

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getCourseDetail($id = 0)
    {

        $this->db->select('c.*,cc.name');

        if ($id) {
            $this->db->where('c.id', $id);
        }

        $this->db->from('course c');
        $this->db->join('category as cc', 'cc.id =c.category_id');
        $query = $this->db->get();
        $result = $query->result_array();

        foreach ($result as $key => $course) {
            $this->db->select(' *');
            $this->db->from('section');
            $this->db->where('course_id', $course['id']);
            $query2 = $this->db->get();
            $result3 = $query2->result_array();
            $result[$key]['section'] = $result3;



            foreach ($result3 as $key2 => $section) {
                $this->db->select(' *');
                $this->db->from('lesson');
                $this->db->where('section_id', $section['id']);
                $this->db->where('course_id', $course['id']);
                $query3 = $this->db->get();
                $result[$key]['lesson'] = $query3->result_array();
            }
        }

        return $result;
    }
    public function getSectionData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $course_id = 0, $id = 0)
    {

        $this->db->select('s.*');
        if ($course_id) {
            $this->db->where('s.course_id', $course_id);
        }
        if ($id) {
            $this->db->where('s.id', $id);
        }


        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                s.title  like '%$searchVal%' 
               
              
            )";
            $this->db->where($searchCondition);
        }


        $this->db->from('section s');
        $this->db->where('s.deleted_by', NULL);

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('s.order');

        $query = $this->db->get();

        return $query->result_array();
    }
    public function getLessonData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $course_id = 0, $id = 0)
    {
        $this->db->select('l.*, 
        c.id as course_id,
        s.id as section_id,
        c.title as course_name,
        s.title as section_name');
        

        if ($course_id) {
            $this->db->where('l.course_id', $course_id);
        }

        if ($id) {
            $this->db->where('l.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(               
            l.title LIKE '%$searchVal%' OR
            c.title LIKE '%$searchVal%'
        )";
            $this->db->where($searchCondition);
        }

        $this->db->from('tbl_lesson l');
        $this->db->join('tbl_courses c', 'c.id = l.course_id');
        $this->db->join('tbl_section s', 's.id = l.section_id');
        $this->db->where('l.deleted_at IS NULL');


        if ($limit) {
            $this->db->limit($limit, $offset);
        }

        $this->db->order_by($this->lt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();
        return $query->result_array();
    }


    public function getMaxOrderNumber($course_id)
    {
        $result = $this->db->select('max(a.order) as sort_number')
            ->where('a.course_id', $course_id)
            ->get('section a')
            ->result_array();
        return $result;
    }
    public function getMaxLessonOrderNumber($course_id)
    {
        $result = $this->db->select('max(a.order) as sort_number1')
            ->where('a.course_id', $course_id)
            ->get('lesson a')
            ->result_array();
        return $result;
    }
    public function getDurationData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = 0)
    {

        $this->db->select('cd.*');
        if ($id) {
            $this->db->where('cd.courses_id', $id);
        }


        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                cd.price  like '%$searchVal%'
              
            )";
            $this->db->where($searchCondition);
        }


        $this->db->from('tbl_courses_duration cd');
        $this->db->join('tbl_duration_master as dm', 'dm.id =cd.duration_id');
        $this->db->join('tbl_courses as c', 'c.id =cd.courses_id');

        $this->db->where('c.deleted_by', NULL);

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->cd_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();

        return $query->result_array();
    }
    public function getLessonVideoData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = 0)
    {

        $this->db->select('vm.*,lv.*,lv.id as lesson_video_id,vm.title,vm.duration');
        if ($id) {
            $this->db->where('lv.lesson_id', $id);
        }


        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                lv.id  like '%$searchVal%'  
               
            )";
            $this->db->where($searchCondition);
        }


        $this->db->from('tbl_lesson_video lv');
        $this->db->join('tbl_lesson as l', 'l.id =lv.lesson_id');
        $this->db->join('tbl_video_master as vm', 'vm.id =lv.video_id');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        //  $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getLessonVideoListData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = 0, $where = '')
    {

        $this->db->select('vm.*,lv.no_of_question ,lv.exam_duration,lv.is_this_video_final');
        if ($id) {
            $this->db->where('lv.lesson_id', $id);
        }


        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                lv.id  like '%$searchVal%'  
               
            )";
            $this->db->where($searchCondition);
        }

        if ($where) {
            $this->db->where($where);
        }
        $this->db->from('tbl_lesson_video lv');
        $this->db->join('tbl_lesson as l', 'l.id =lv.lesson_id');
        $this->db->join('tbl_video_master as vm', 'vm.id =lv.video_id');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        //  $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getCourseDurationData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = 0, $_where = 0)
    {

        $this->db->select('cd.*,c.language,dm.name');
        if ($id) {
            $this->db->where('cd.courses_id', $id);
        }


        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                dm.name  like '%$searchVal%'  
               
            )";
            $this->db->where($searchCondition);
        }


        $this->db->from('tbl_courses_duration cd');
        $this->db->join('tbl_courses as c', 'c.id =cd.courses_id');
        $this->db->join('tbl_duration_master as dm', 'dm.id =cd.duration_id');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->where('dm.deleted_by', NULL);
        if ($_where) {
            $this->db->where($_where);
        }
        //  $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();

        return $query->result_array();
    }
    public function getLessonVideoMCQData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $where = '')
    {

        $this->db->select('lv.*,sm.name as skill_name');

        if ($where) {
            $this->db->where($where);
        }


        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                lv.question  like '%$searchVal%'  
               
            )";
            $this->db->where($searchCondition);
        }

        $this->db->where('lv.deleted_by', NULL);
        $this->db->from('tbl_lesson_question_master lv');
        $this->db->join('tbl_skill_master as sm', 'sm.id =lv.skill');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        //  $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();

        return $query->result_array();
    }
    public function getCourseName($searchVal = '')
    {
        $this->db->select('p.title as name,p.id');
        if ($searchVal) {
            $searchCondition = "(            
                   p.title like '%$searchVal%'            
                   
  
                )";
            $this->db->where($searchCondition);
        }
        $this->db->where('p.status', 1);
        $this->db->where('p.category_id !=', 0);
        $this->db->where('p.is_free ', 0);

        $this->db->where('p.deleted_by', NULL);
        $result = $this->db->get('tbl_courses as p')->result_array();

        return $result;
    }
    public function getSectionList($searchVal = "", $sortColIndex = 0, $sortBy = "asc", $limit = 10, $offset = 0, $course_id = 0)
    {
        $columns = [
            "ts.id",
            "c.id as course_id",
            "c.title",
            "ts.title",
            "ts.description"
        ];

        $this->db->select("ts.*, c.title AS course_name");
        $this->db->from("tbl_section ts");
        $this->db->join("tbl_courses c", "c.id = ts.course_id", "LEFT");
        $this->db->where("ts.deleted_at IS NULL");

        if (!empty($course_id)) {
            $this->db->where("ts.course_id", $course_id);   
        }

        if (!empty($searchVal)) {
            $this->db->group_start();
            $this->db->like("ts.title", $searchVal);
            $this->db->or_like("c.title", $searchVal);
            $this->db->or_like("ts.description", $searchVal);
            $this->db->group_end();
        }

        if (!empty($sortColIndex) && isset($columns[$sortColIndex])) {
            $this->db->order_by($columns[$sortColIndex], $sortBy);
        }

        if ($limit > 0) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }



    public function getSubSectionData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = 0)
    {

        $this->db->select('tss.*');
        if ($id) {
            $this->db->where('tss.id', $id);
        }
        if (strlen($searchVal)) {
            $searchCondition = "(               
                tss.section_id  like '%$searchVal%'  
               
            )";
            $this->db->where($searchCondition);
        }
        $this->db->from('tbl_sub_section tss');
        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        //  $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        $query = $this->db->get();

        return $query->result_array();
    }

    public function getCourseQnaList($course_id, $search = '', $limit = 0, $start = 0)
    {
        $this->db->select('
            q.*,
            CONCAT(ask.first_name," ",ask.last_name) AS asked_by,
            CONCAT(ans.first_name," ",ans.last_name) AS answered_by,
            c.status AS course_status
        ');
        $this->db->from('tbl_course_qna q');
        $this->db->join('tbl_users ask', 'ask.id = q.user_id', 'left');
        $this->db->join('tbl_users ans', 'ans.id = q.ans_created_by', 'left');
        $this->db->join('tbl_courses c', 'c.id = q.course_id', 'left');
        $this->db->where('q.course_id', $course_id);

        if ($search !== '') {
            $this->db->group_start();
            $this->db->like('q.question', $search);
            $this->db->like('ask.first_name', $search);
            $this->db->or_like('ask.last_name', $search);
            $this->db->group_end();
        }

        $this->db->order_by('CASE WHEN q.answer IS NULL THEN 0 ELSE 1 END', 'ASC', false);
        $this->db->order_by('q.created_at', 'ASC');

        if ($limit) {
            $this->db->limit($limit, $start);
        }

        return $this->db->get()->result_array();
    }
}
