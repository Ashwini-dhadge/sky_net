<?php

class CertificateModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCertificateList($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = 0)
    {
        $this->db->select('tc.*, tu.first_name, tu.last_name, tu.id as user_id, tcou.title as course_name');
        $this->db->from('tbl_certificates tc');
        $this->db->join('tbl_users tu', 'tu.id = tc.user_id', 'left');
        $this->db->join('tbl_courses tcou', 'tcou.id = tc.course_id', 'left');

        if ($id) {
            $this->db->where('tc.id', $id);
        }

        if (!empty($searchVal)) {
            $this->db->group_start();
            $this->db->like('tc.certificate_title', $searchVal);
            $this->db->or_like('tc.certificate_number', $searchVal);
            $this->db->or_like('tu.first_name', $searchVal);
            $this->db->or_like('tu.last_name', $searchVal);
            $this->db->group_end();
        }

        $columns = [
            0 => 'tc.id',
            1 => 'tc.certificate_title',
            2 => 'tc.certificate_number',
            3 => 'tc.score',
            4 => 'tc.grade',
            5 => 'tc.issued_date',
            6 => 'tc.status'
        ];

        if (isset($columns[$sortColIndex])) {
            $this->db->order_by($columns[$sortColIndex], $sortBy);
        } else {
            $this->db->order_by('tc.id', 'desc');
        }

        if ($limit != -1 && $limit != 0) {
            $this->db->limit($limit, $offset);
        }

        return $this->db->get()->result_array();
    }
}
