<?php

/**
 * 
 */
class SaleReportModel extends CI_Model
{
    protected $Order_Column = array(
        '',
        'type',
        'title',
        'sales'
    );


    // public function getSaleReportOrders($searchVal = '', $sortColIndex = '0', $sortBy = 'DESC', $limit = '0', $offset = '0', $id = '', $where = '')
    // {

    //     // $this->db->select(' c.title,od.type,v.name as durations,od.courses_duration_id,sum(od.rate)as sales,count(od.courses_id)as total');
    //     $this->db->select(' c.title,od.type,od.courses_duration_id,sum(od.rate)as sales,count(od.courses_id)as total');
    //     $this->db->from('tbl_orders o');
    //     $this->db->join('tbl_users u', 'u.id = o.user_id');
    //     $this->db->join('tbl_order_details od', 'od.order_id = o.id', 'left');
    //     $this->db->join('tbl_courses c', 'c.id = od.courses_id', 'left');
    //     // $this->db->join('tbl_courses_duration cd', 'cd.id = od.courses_duration_id', 'left');
    //     // $this->db->join('tbl_duration_master v', 'v.id = cd.duration_id', 'left');

    //     if ($where) {
    //         $this->db->where($where);
    //     }
    //     if ($id) {
    //         $this->db->where('o.id', $id);
    //     }
    //     // $this->db->where('o.payment_status', 1);


    //     // $this->db->group_by('od.courses_id');
    //     $this->db->group_by([
    //         'od.courses_id',
    //         'c.title',
    //         'od.type',

    //         'od.courses_duration_id'
    //     ]);
    //     $this->db->where([
    //         'o.order_status' => 'COMPLETED',
    //         'o.payment_status' => 'CAPTURED',
    //     ]);
    //     // $this->db->having('type=1');



    //     // $query1 = $this->db->get_compiled_select();
    //     $query1 = "(" . $this->db->get_compiled_select() . ")";

    //     // $this->db->select(' c.title,od.type,v.name as durations,od.courses_duration_id,sum(od.rate)as sales,count(od.courses_id)as total');
    //     $this->db->select(' c.title,od.type,od.courses_duration_id,sum(od.rate)as sales,count(od.courses_id)as total');
    //     $this->db->from('tbl_orders o');
    //     $this->db->join('tbl_users u', 'u.id = o.user_id');
    //     $this->db->join('tbl_order_details od', 'od.order_id = o.id', 'left');
    //     $this->db->join('tbl_courses c', 'c.id = od.courses_id', 'left');
    //     // $this->db->join('tbl_courses_duration cd', 'cd.id = od.courses_duration_id', 'left');
    //     // $this->db->join('tbl_duration_master v', 'v.id = cd.duration_id', 'left');


    //     if ($where) {
    //         $this->db->where($where);
    //     }
    //     if ($id) {
    //         $this->db->where('o.id', $id);
    //     }
    //     $this->db->where([
    //         'o.order_status' => 'COMPLETED',
    //         'o.payment_status' => 'CAPTURED',
    //     ]);

    //     // $this->db->group_by('od.courses_id');
    //     $this->db->group_by([
    //         'od.courses_id',
    //         'c.title',
    //         'od.type',

    //         'od.courses_duration_id'
    //     ]);
    //     // $this->db->having('type=3');

    //     // $query2 = $this->db->get_compiled_select();
    //     $query2 = "(" . $this->db->get_compiled_select() . ")";

    //     $query = $this->db->query($query1 . " UNION " . $query2);
    //     $query3 = $this->db->get_compiled_select();
    //     $union_query = $this->db->last_query();

    //     $this->db->select("*");
    //     $this->db->from("(" . $union_query . ") a");
    //     if ($searchVal) {
    //         $searchCondition = "(
    //            title like '%$searchVal%' or 
    //             type like '%$searchVal%' 
    //         )";


    //         $this->db->where($searchCondition);
    //     }

    //     if ($limit || $offset) {
    //         $this->db->limit($limit, $offset);
    //     }
    //     $this->db->order_by($this->Order_Column[$sortColIndex], $sortBy);

    //     //    echo $this->db->last_query();die();
    //     $result = $this->db->get()
    //         ->result_array();


    //     //    print_r( $result);
    //     return  $result;
    // }

    public function getSaleReportOrders($searchVal = '', $sortColIndex = '0', $sortBy = 'DESC', $limit = '0', $offset = '0', $id = '', $where = '')
    {
        // MAIN AGGREGATION QUERY
        $this->db->select('
        c.title,
        od.type,
        od.courses_duration_id,
        SUM(od.rate) AS sales,
        COUNT(od.courses_id) AS total
    ');
        $this->db->from('tbl_orders o');
        $this->db->join('tbl_users u', 'u.id = o.user_id');
        $this->db->join('tbl_order_details od', 'od.order_id = o.id', 'left');
        $this->db->join('tbl_courses c', 'c.id = od.courses_id', 'left');

        // dynamic filters
        if ($where) {
            $this->db->where($where);
        }

        if ($id) {
            $this->db->where('o.id', $id);
        }

        // only successful paid orders
        $this->db->where([
            'o.order_status' => 'COMPLETED',
            'o.payment_status' => 'CAPTURED',
        ]);

        // GROUPING (very important)
        $this->db->group_by([
            'od.courses_id',


        ]);

        // compile main query
        $mainQuery = $this->db->get_compiled_select();

        // --------------------------------------------------
        // DATATABLE SEARCH + SORT + PAGINATION WRAPPER QUERY
        // --------------------------------------------------
        $this->db->select('*');
        $this->db->from("(" . $mainQuery . ") a");

        // search
        if ($searchVal) {
            $this->db->group_start();
            $this->db->like('title', $searchVal);
            $this->db->or_like('type', $searchVal);
            $this->db->group_end();
        }

        // pagination
        if ($limit != 0) {
            $this->db->limit($limit, $offset);
        }

        // sorting
        $this->db->order_by($this->Order_Column[$sortColIndex], $sortBy);

        return $this->db->get()->result_array();
    }
}