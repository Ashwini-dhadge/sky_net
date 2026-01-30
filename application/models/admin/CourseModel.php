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

    public function getCourseData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = 0)
    {

        $this->db->select('c.*,cc.category_name,sm.name');
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
        $this->db->join('tbl_skill_master as sm', 'sm.id =c.skill_id');
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

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by('s.order');

        $query = $this->db->get();

        return $query->result_array();
    }
    public function getLessonData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $course_id = 0, $id = 0)
    {

        $this->db->select('l.*,c.title as course_name,dm.name as duration');

        if ($course_id) {
            $this->db->where('l.course_id', $course_id);
        }

        if ($id) {
            $this->db->where('l.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                l.title  like '%$searchVal%' or
                c.title  like '%$searchVal%' 

            )";
            $this->db->where($searchCondition);
        }


        $this->db->from('tbl_lesson l');
        $this->db->join('tbl_courses c', 'c.id =l.course_id');
        $this->db->join('tbl_duration_master as dm', 'dm.id =l.duration_id', 'left');

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
        $this->db->join('tbl_skill_master as sm', 'sm.id =lv.skill_id');

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
    public function getSectionList($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $course_id = 0, $id = 0)
    {

        $this->db->select('ts.*,c.title as course_name');

        if ($course_id) {
            $this->db->where('l.course_id', $course_id);
        }

        if ($id) {
            $this->db->where('ts.id', $id);
        }

        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                ts.title  like '%$searchVal%' or
                c.title  like '%$searchVal%' 

            )";
            $this->db->where($searchCondition);
        }


        $this->db->from('tbl_section ts');
        $this->db->join('tbl_courses c', 'c.id =ts.course_id');
        // $this->db->join('tbl_duration_master as dm', 'dm.id =l.duration_id', 'left');

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->st_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();

        return $query->result_array();
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
}
