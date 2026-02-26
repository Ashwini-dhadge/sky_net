<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardModel extends CI_Model
{

   public function getCourseWiseSale()
   {

      $this->db->select(' count(od.courses_id)as total,c.title');
      $this->db->from('tbl_orders o');
      $this->db->join('tbl_order_details as od', 'od.order_id =o.id');
      $this->db->join('tbl_courses as c', 'c.id =od.courses_id');

      $this->db->where('o.order_status', 1);
      $this->db->group_by('od.courses_id');
      $query = $this->db->get();
      //echo $this->db->last_query(); die();
      return $query->result_array();
   }

   public function getCourseStudentChart()
   {
      return $this->db
         ->select('c.title, COUNT(s.id) as total_students')
         ->from('tbl_courses c')
         ->join(
            'tbl_order_courses_subscription s',
            's.course_id = c.id AND s.active = 1 AND s.deleted_on IS NULL',
            'left'
         )
         ->where('c.status', 1)
         ->group_by('c.id')
         ->order_by('total_students', 'DESC')
         ->limit(5)
         ->get()
         ->result();
   }


   public function getPendingForum()
   {
      return $this->db
         ->where('is_approved', 0)
         ->where('deleted_at IS NULL', null, false)
         ->order_by('id', 'DESC')
         ->get('tbl_forum_questions')
         ->result();
   }


   public function getRejectedForum()
   {
      return $this->db
         ->where('is_approved', 2)
         ->where('deleted_at IS NULL', null, false)
         ->order_by('id', 'DESC')
         ->get('tbl_forum_questions')
         ->result();
   }


   public function getUnansweredQna()
   {
      return $this->db
         ->select('q.*, c.title as course_title')
         ->from('tbl_course_qna q')
         ->join('tbl_courses c', 'c.id = q.course_id', 'left')
         ->where('q.answer IS NULL', null, false)
         ->where('q.deleted_at IS NULL', null, false)
         ->order_by('q.id', 'DESC')
         ->get()
         ->result();
   }


   public function getOnlineStudents()
   {
      return $this->db
         ->where([
            'status' => 1,
            'is_deleted' => 0,
            'role' => 3,
            'user_type' => 1
         ])
         ->count_all_results('tbl_users');
   }

   public function getOfflineStudents()
   {
      return $this->db
         ->where([
            'status' => 1,
            'is_deleted' => 0,
            'role' => 3,
            'user_type' => 0
         ])
         ->count_all_results('tbl_users');
   }


   public function getOnlineCourses()
   {
      return $this->db
         ->where('status', 1)
         ->where('course_type', 1)
         ->where('deleted_at IS NULL', null, false)
         ->count_all_results('tbl_courses');
   }

   public function getOfflineCourses()
   {
      return $this->db
         ->where('status', 1)
         ->where('course_type', 0)
         ->where('deleted_at IS NULL', null, false)
         ->count_all_results('tbl_courses');
   }



   private function baseEnrollmentQuery()
   {
      return $this->db
         ->from('tbl_order_courses_subscription s')
         ->join('tbl_users u', 'u.id = s.user_id', 'inner')
         ->join('tbl_courses c', 'c.id = s.course_id', 'inner')
         ->where('s.active', 1)
         ->where('s.deleted_on IS NULL', null, false)
         ->where('u.role', 3)
         ->where('u.status', 1)
         ->where('u.is_deleted', 0)
         ->where('c.status', 1)
         ->where('c.deleted_at IS NULL', null, false);
   }

   public function enrollOnlineStudentOnlineCourse()
   {
      return $this->baseEnrollmentQuery()
         ->where('u.user_type', 1)
         ->where('c.course_type', 1)
         ->count_all_results();
   }

   public function enrollOfflineStudentOfflineCourse()
   {
      return $this->baseEnrollmentQuery()
         ->where('u.user_type', 0)
         ->where('c.course_type', 0)
         ->count_all_results();
   }

   public function enrollOnlineStudentOfflineCourse()
   {
      return $this->baseEnrollmentQuery()
         ->where('u.user_type', 1)
         ->where('c.course_type', 0)
         ->count_all_results();
   }

   public function enrollOfflineStudentOnlineCourse()
   {
      return $this->baseEnrollmentQuery()
         ->where('u.user_type', 0)
         ->where('c.course_type', 1)
         ->count_all_results();
   }
}
