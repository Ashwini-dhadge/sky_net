<?php

/**
 * 
 */
class UserCourseProgressReportModel extends CI_Model
{
    protected $CourseOrderColumn = [
        '',
        'title',
        'category_name',
        '',
        'price'
    ];

    // public function getMyCoursesList($searchVal = '', $sortColIndex = '0', $sortBy = 'DESC', $limit = '0', $offset = '0', $where = [], $where1 = '')
    // {
    //     // ================================
    //     // MAIN QUERY (COMPILE ONLY)
    //     // ================================
    //     $this->db->select("
    //         c.title,
    //         c.id as courses_id,
    //         main.category_name,
    //        u.first_name as student_name,
    //     ");

    //     $this->db->from('tbl_order_courses_subscription tocs');
    //     $this->db->join('tbl_orders to', 'to.id=tocs.order_id');
    //     $this->db->join('tbl_courses c', 'c.id=tocs.course_id');
    //     $this->db->join('tbl_categories main', 'main.id=c.category_id', 'left');
    //     $this->db->join('tbl_users u', 'u.id=to.user_id');


    //     if (isset($where['category_id']) && is_array($where['category_id'])) {
    //         $this->db->where_in('c.category_id', $where['category_id']);
    //         unset($where['category_id']);
    //     }

    //     if ($where)  $this->db->where($where);
    //     if ($where1) $this->db->where($where1);

    //     $this->db->where('c.deleted_by', NULL);
    //     $this->db->where('to.deleted_by', NULL);

    //     // compile query
    //     $query1 = "(" . $this->db->get_compiled_select() . ")";

    //     // ================================
    //     // OUTER QUERY (SEARCH + PAGINATION)
    //     // ================================
    //     $this->db->select("*");
    //     $this->db->from($query1 . " a");

    //     // 🔍 Global search (same style as sales report)
    //     if ($searchVal) {
    //         $searchCondition = "(
    //             title LIKE '%$searchVal%' OR
    //             category_name LIKE '%$searchVal%' 
    //         )";
    //         $this->db->where($searchCondition);
    //     }


    //     if ($limit || $offset) {
    //         $this->db->limit($limit, $offset);
    //     }


    //     $this->db->order_by($this->CourseOrderColumn[$sortColIndex], $sortBy);

    //     $result = $this->db->get()->result_array();
    //     return $result;
    // }

    public function getMyCoursesList(
        $searchVal = '',
        $sortColIndex = '0',
        $sortBy = 'DESC',
        $limit = '0',
        $offset = '0',
        $id = '',
        $where = ''
    ) {

        // ======================================================
        // MAIN QUERY (compile first) → calculates watch %
        // ======================================================
        $this->db->select("
            c.title,
            c.id as courses_id,
            main.category_name,
            u.first_name as student_name,
    
            ROUND(
                (COUNT(DISTINCT luv.id) / NULLIF(COUNT(DISTINCT lv.id),0)) * 100
            ,2) as watch_percentage
        ");

        $this->db->from('tbl_order_courses_subscription tocs');
        $this->db->join('tbl_orders to', 'to.id=tocs.order_id AND to.order_status="COMPLETED" AND to.payment_status="CAPTURED"');
        $this->db->join('tbl_courses c', 'c.id=tocs.course_id');
        $this->db->join('tbl_categories main', 'main.id=c.category_id', 'left');
        $this->db->join('tbl_users u', 'u.id=to.user_id');

        // total videos in course
        $this->db->join('tbl_lesson_video lv', 'lv.courses_id=c.id', 'left');

        // watched videos by user in that course
        $this->db->join(
            'tbl_lesson_user_video luv',
            'luv.courses_id = c.id AND luv.user_id = to.user_id AND luv.view_video = 1 AND luv.solved_mcq IS NOT NULL',
            'left'
        );

        // filters

        if (!empty($where)) {
            $this->db->where($where);
        }

        $this->db->where('c.deleted_by', NULL);
        $this->db->where('to.deleted_by', NULL);

        // VERY IMPORTANT → one row per user per course
        $this->db->group_by(['c.id', 'to.user_id']);

        // compile main query
        $query1 = "(" . $this->db->get_compiled_select() . ")";

        // ======================================================
        // OUTER QUERY → Search + Pagination + Sorting
        // ======================================================
        $this->db->select("*");
        $this->db->from($query1 . " a");

        // 🔍 global search (datatable search)
        if ($searchVal) {
            $this->db->where("(
                title LIKE '%$searchVal%' OR
                student_name LIKE '%$searchVal%' OR
                category_name LIKE '%$searchVal%'
            )");
        }

        // pagination
        if ($limit || $offset) {
            $this->db->limit($limit, $offset);
        }

        // sorting
        $this->db->order_by($this->CourseOrderColumn[$sortColIndex], $sortBy);

        return $this->db->get()->result_array();
    }
}