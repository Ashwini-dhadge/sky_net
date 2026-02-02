<?php
class VideoModel extends CI_Model
{

	protected $dt_Column = array(
                                    'v.id',
                                    'vc.name',
                                    'v.description',
                                    'v.video_url', 
                                    'v.sku',
                                    'v.image',
                                    ''                      
							);
						
    protected $dt_Column1 = array(
                                    'v.id',
                                    'v.name',
                                    'v.description',   
                                    'v.sku',
                                    ''                      
                            );
    


	public function getvideoData($searchVal='',$sortColIndex=0,$sortBy='desc',$limit=0, $offset=0,$id=0)
     {

        $this->db->select('v.*');
        if ($id) {
            $this->db->where('v.id', $id);           
        }

    	
        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                v.name  like '%$searchVal%' or 
                v.description like '%$searchVal%' 
               
            )";
            $this->db->where($searchCondition);
        }


        $this->db->from('tbl_video_master v');
       // $this->db->join('video_categories as vc', 'vc.id =v.video_category_id');
      
     
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

        $query = $this->db->get();
      
        return $query->result_array();
    }
    public function getvideoCategoryData($searchVal='',$sortColIndex=0,$sortBy='desc',$limit=0, $offset=0,$id=0)
     {

        $this->db->select('v.*');
        if ($id) {
            $this->db->where('v.id', $id);           
        }

        
        if (strlen($searchVal)) {
            $searchCondition = "(              
               
                vc.name  like '%$searchVal%' 
               
               
              
            )";
            $this->db->where($searchCondition);
        }


        $this->db->from('video_categories v');
 
     
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column1[$sortColIndex], $sortBy);

        $query = $this->db->get();
      
        return $query->result_array();
    }
    

    public function geCategoryDetail($id=0)
     {

        $this->db->select('c.*');
        
        if ($id) {
            $this->db->where('c.id', $id);           
        }

        $this->db->from('tbl_events e');      
        $query = $this->db->get();      
        return $query->result_array();
     
     }
    
}
  ?>