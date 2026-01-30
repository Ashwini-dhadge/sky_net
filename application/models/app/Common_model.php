<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Common_model
 * For Common Functions
 */
class Common_model extends CI_Model
{
    /*
		Function : iudAction
		Note:   User For Insert, Update and Delete

	*/
    public function iudAction($table = '', $data = array(), $action = '', $where = array())
    {
        switch ($action) {
            case 'insert':
                $this->db->insert($table, $data);
                $insert_id = $this->db->insert_id();
                return $insert_id;
                break;

            case 'update':
                $this->db->where($where);
                //  $this->db->update($table, $data);
                // return ($this->db->affected_rows() > 0)? true : false;
                $res = $this->db->update($table, $data);
                return ($res) ? true : false;
                break;

            case 'delete':
                $this->db->where($where);
                $this->db->delete($table);
                return ($this->db->affected_rows() > 0) ? true : false;
                break;
        }
    }
    public function getAllData($table = '', $where = array(), $limit = 0, $order_by = '', $sort_by = 'desc', $offset = 0)
    {
        $this->db->select('*');
        $this->db->from($table);
        if ($where) {
            $this->db->where($where);
        }
        if ($limit) {
            if ($offset) {
                $this->db->limit($limit, $offset);
            } else {
                $this->db->limit($limit);
            }
        }
        if ($order_by) {
            $this->db->order_by($order_by, $sort_by);
        }
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getData($table, $where = '', $fields = '', $group_by = '', $return = '', $order_by = '', $sort_by = 'desc')
    {
        if ($fields) {
            $this->db->select($fields);
        }
        if ($where) {
            $this->db->where($where);
        }
        if ($group_by) {
            $this->db->group_by($group_by);
        }
        if ($order_by) {
            $this->db->order_by($order_by, $sort_by);
        }
        $query = $this->db->get($table);

        if ($return == 'row') {
            $result = $query->row();
        } else if ($return == 'row_array') {
            $result = $query->row_array();
        } else if ($return == 'result') {
            $result = $query->result();
        } else if ($return == 'num_rows') {
            $result = $query->num_rows();
        } else {
            $result = $query->result_array();
        }
        return $result;
    }
    public function getUserData($where = array(), $search = "")
    {
        $this->db->select('u.*,up.gender,up.birthdate ');
        $this->db->from('tbl_users u');
        $this->db->join('user_profile up', 'up.user_id = u.id', 'left');


        if ($search) {
            $searchVal = "(
                        u.first_name like '%$search%' or
                        u.last_name like '%$search%' or
                        u.email like '%$search%' or
                        u.mobile_no like '%$search%'
                       
                        )";
            $this->db->where($searchVal);
        }

        $this->db->where($where);
        $this->db->order_by('u.id', 'desc');

        $result = $this->db->get();
        // print_r($this->db->last_query());die;
        return $result->result_array();
    }
    public function getAddedTransaction($user_id = 0)
    {
        $this->db->select('SUM(amount) as totalAdded');
        $this->db->from('wallet_transaction p');
        $this->db->where(array('user_id' => $user_id, 'action' => 1));
        $query = $this->db->get();
        return $query->row_array();
    }
    public function getSubtractedTransaction($user_id = 0)
    {
        $this->db->select('SUM(amount) as totalSubtract');
        $this->db->from('wallet_transaction p');
        $this->db->where(array('user_id' => $user_id, 'action' => 2));
        $query = $this->db->get();
        return $query->row_array();
    }
    public function getAllOfferData($where = array(), $search = "")
    {
        $this->db->select('o.*,oc.offer_category as offer_category_name');
        $this->db->from('tbl_offers o');
        $this->db->join('tbl_offer_categories oc', 'oc.id = o.offer_category', 'left');
        if ($search) {
            $searchVal = "(
                        o.offer_title like '%$search%' or
                        o.offer_category like '%$search%' or
                        o.offer_type like '%$search%' or
                        o.offer like '%$search%'
                       
                        )";
            $this->db->where($searchVal);
        }

        $this->db->where($where);
        $this->db->where('o.status', 1);
        $this->db->where('o.is_deleted', NULL);
        $this->db->where('o.from_date <=', date('Y-m-d'));
        $this->db->where('o.to_date >=', date('Y-m-d'));
        $this->db->order_by('o.id', 'desc');
        $result = $this->db->get();
        // print_r($this->db->last_query());die;
        return $result->result_array();
    }
}
