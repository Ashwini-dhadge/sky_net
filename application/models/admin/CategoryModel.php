<?php
class CategoryModel extends CI_Model
{

	protected $dt_Column = array(
                                    'c.id',
                                    'c.category_name',
                                    '',
                                    ''
							);
    protected $Dt_Column = array(
                    'oc.id',
                    'oc.offer_category',
                                     
                );

	public function getCategoryData($searchVal='',$sortColIndex=0,$sortBy='desc',$limit=0, $offset=0,$id=0)
     {

        $this->db->select('c.*');
        if ($id) {
            $this->db->where('c.id', $id);           
        }
        
        if (strlen($searchVal)) {
            $searchCondition = "(               
               
                c.category_name  like '%$searchVal%'
              
            )";
            $this->db->where($searchCondition);
        }

        $this->db->from('tbl_categories c');
        $this->db->where('c.is_deleted',0);
     
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->dt_Column[$sortColIndex], $sortBy);

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
     
     
    public function getcategorymasterData($searchVal='', $sortColIndex='0', $sortBy='DESC', $limit='0', $offset='0',$id='', $where='')
    {
        $this->db->select('oc.*');
       
        if($searchVal){
            $searchCondition = "(
                oc.offer_category like '%$searchVal%'                
            
            )";
          $this->db->where($searchCondition);
        }
        if ($where) {
            $this->db->where($where);
        }
        if ($id) {
            $this->db->where('oc.id',$id);
        }

           // $this->db->where('oc.deleted_by',NULL);

        if ($limit) {
        $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->Dt_Column[$sortColIndex], $sortBy);

        $result = $this->db->get('tbl_offer_categories oc')
                           ->result_array();
                           // echo $this->db->last_query();
        return $result;

    }
    
}
  ?>