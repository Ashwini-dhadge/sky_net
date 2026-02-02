<?php
class DurationMasterModel extends CI_Model
{

	protected $dt_Column = array(
                                    'r.id',
                                    'r.name',
                                    'r.no_of_days',
                                    
                                    ''
							);

	public function getDurationData($searchVal='',$sortColIndex=0,$sortBy='desc',$limit=0, $offset=0,$id=0)
     {

        $this->db->select('r.*');
        if ($id) {
            $this->db->where('r.id', $id);           
        }
        
        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                r.name  like '%$searchVal%'
              
            )";
            $this->db->where($searchCondition);
        }


        $this->db->from('tbl_duration_master r');
         $this->db->where('r.deleted_by', NULL); 
     
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();
      
        return $query->result_array();
    }
    // 	public function getRankVideoData($searchVal='',$sortColIndex=0,$sortBy='desc',$limit=0, $offset=0,$id=0)
    //  {

    //     $this->db->select('r.*');
    //     if ($id) {
    //         $this->db->where('r.id', $id);           
    //     }
        
    //     if (strlen($searchVal)) {
    //         $searchCondition = "(               
               
    //             r.rank  like '%$searchVal%'
              
    //         )";
    //         $this->db->where($searchCondition);
    //     }


    //     $this->db->from('tbl_video_mcq_rank_master r');
    //     $this->db->where('r.deleted_by',NULL);
     
    //     if($limit){
    //         $this->db->limit($limit, $offset);
    //     }
    //     $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

    //     $query = $this->db->get();
      
    //     return $query->result_array();
    // }

    // public function geCategoryDetail($id=0)
    //  {

    //     $this->db->select('c.*');
        
    //     if ($id) {
    //         $this->db->where('c.id', $id);           
    //     }

    //     $this->db->from('tbl_events e');      
    //     $query = $this->db->get();      
    //     return $query->result_array();
     
    //  }
    
}
  ?>