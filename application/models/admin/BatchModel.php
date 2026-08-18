<?php
class BatchModel extends CI_Model
{

    protected $dt_Column = array(
        'b.id',
        'b.batch_name',
        'b.batch_description',
        ''
    );

    public function getBatchData($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = 0, $where = '')
    {
        $this->db->select('b.*, (SELECT COUNT(u.id) FROM tbl_users u WHERE u.batch_id = b.id AND u.is_deleted = 0) as total_students');
        if ($id) {
            $this->db->where('b.id', $id);
        }

        if ($where) {
            $this->db->where($where);
        }

        if (strlen($searchVal)) {
            $searchVal = $this->db->escape_like_str($searchVal);
            $searchCondition = "(               
                b.batch_name LIKE '%$searchVal%' OR
                b.batch_description LIKE '%$searchVal%'
            )";
            $this->db->where($searchCondition);
        }

        $this->db->from('tbl_batches b');
        $this->db->where('b.deleted_at IS NULL', null, false);

        if ($limit) {
            $this->db->limit($limit, $offset);
        }
        if (isset($this->dt_Column[$sortColIndex]) && !empty($this->dt_Column[$sortColIndex])) {
            $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);
        } else {
            $this->db->order_by('b.id', 'desc');
        }

        $query = $this->db->get();

        return $query->result_array();
    }

    public function getBatchDetail($id = 0)
    {
        $this->db->select('b.*');

        if ($id) {
            $this->db->where('b.id', $id);
        }

        $this->db->from('tbl_batches b');
        $this->db->where('b.deleted_at IS NULL', null, false);
        $query = $this->db->get();
        return $query->result_array();
    }
}
?>
