<?php
/**
 * 
 */
class DashboardModel extends CI_Model
{
    
   public function getCourseWiseSale()
   {
     
      $this->db->select(' count(od.courses_id)as total,c.title');
      $this->db->from('tbl_orders o');
      $this->db->join('tbl_order_details as od', 'od.order_id =o.id');
      $this->db->join('tbl_courses as c', 'c.id =od.courses_id'); 
   
      $this->db->where('o.order_status',1);
      $this->db->group_by('od.courses_id');
      $query = $this->db->get();
     //echo $this->db->last_query(); die();
        return $query->result_array();
   }
}

?>
