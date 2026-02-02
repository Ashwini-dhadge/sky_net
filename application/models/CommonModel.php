<?php
/**
 * Created By: Nil Wagh,
 * Date:       15/11/2019,
 * Note:       All Common Method Here 
 */
class CommonModel extends CI_Model
{
	
	/*
		Function : iudAction
		Note:   User For Insert, Update and Delete

	*/

    
	public function getAllData($table = '', $where = array(), $limit = 0, $order_by = '', $sort_by = 'desc')
    {
        $this->db->select('*');
        $this->db->from($table);
        if($where){
            $this->db->where($where);
        }
        if($limit){
            $this->db->limit($limit);
        }
        if($order_by){
            $this->db->order_by($order_by,$sort_by);
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    /*
		Function : getData
		Note:   get Data form database table with where condition

	*/
   
	public function getData($table, $where='',$fields='',$group_by='',$return='', $order_by = '', $sort_by = 'desc')
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
		   if($order_by){
            $this->db->order_by($order_by,$sort_by);
        }
		$query = $this->db->get($table);
		
		if($return == 'row'){
			$result = $query->row();
		}else if($return == 'row_array'){
			$result = $query->row_array();
		}else if($return == 'result'){
			$result = $query->result();
		}else if($return == 'num_rows'){
			$result = $query->num_rows();
		}else{
			$result = $query->result_array();
		}
		return $result;
	}

	public function iudAction($table='',$data = array(), $action='', $where =array())
	{
		switch ($action) {
			case 'insert':
				$this->db->insert($table, $data);
				return $this->db->insert_id();
				break;
			case 'update':
				$this->db->where($where);
				$this->db->set($data);
				$this->db->update($table); 
				return ($this->db->affected_rows() > 0)? true : false ;
				break;
			case 'delete':
				$this->db->where($where);
				$this->db->delete($table); 
				return ($this->db->affected_rows() > 0)? true : false ;
				break;

			default:
				return false;
				break;
		}
	}


      public function getData1($table = '',$where_array=array())
    {       
       $result=$this->db->where($where_array)                       
                        ->get($table)
                        ->result_array();  
        return $result;     
    }
    
	
	/*
		Function: getDataByPagination,
		Note:    Get Date for listing
	*/

	public function getDataByPagination($searchVal = '', $sortColIndex = 0, $sortBy = 'desc', $limit = 0, $offset = 0, $id = 0)
    {
         $this->db->select('*');

        if ($id) {
            $this->db->where('column_name', $id);           
        }
        if (strlen($searchVal)) {
            $searchCondition = "(
                column_name like '%$searchVal%' or               
                column_name like '%$searchVal%' 
            )";
            $this->db->where($searchCondition);
        }

        $this->db->from('table_name');
        if($limit){
            $this->db->limit($limit, $offset);
        }
        $this->db->order_by($this->ColumnName[$sortColIndex], $sortBy);

        $query = $this->db->get();
      
        return $query->result_array();
    }

    /*
        Function : get
        Note:   get Data form database table with where condition
    */
    public function get($table = '',$where_array=array())
    {       
       $result=$this->db->where($where_array)                        
                        ->get($table)
                        ->result_array();  
        return $result;     
    }
    
    //area listing
    function getAreaListing($where = array(), $search= "", $limit = 0 , $offset = 0){
        $this->db->select('b.*');
        $this->db->from('master_beat b');
        // $this->db->join('customer_master c', 'c.role_id = s.vendor_id');
        
        if($search){
            $this->db->like('b.beat_name', $search);
            $this->db->or_like('b.market_name', $search);
        }
        $this->db->where($where);
        
        if($limit || $offset){
            $this->db->limit($limit, $offset);
        }
        
        $this->db->order_by('b.beat_name', 'asc');
        
        $result = $this->db->get();
        //print_r($this->db->last_query());die;
        return $result->result_array();
    }
    
    //vendor listing
    function getVendorListing($where = array(), $search= "", $limit = 0 , $offset = 0){
        $this->db->select('v.*');
        $this->db->from('master_vendors v');
        // $this->db->join('customer_master c', 'c.role_id = s.vendor_id');
        
        if($search){
            $this->db->like('v.shop_name', $search);
            $this->db->or_like('v.vendor_name', $search);
            $this->db->or_like('v.mobile_number', $search);
            $this->db->or_like('v.pan_number', $search);
            $this->db->or_like('v.gst_number', $search);
            $this->db->or_like('v.address', $search);
        }
        $this->db->where($where);
        
        if($limit || $offset){
            $this->db->limit($limit, $offset);
        }
        
        $this->db->order_by('v.shop_name', 'asc');
        
        $result = $this->db->get();
        //print_r($this->db->last_query());die;
        return $result->result_array();
    }
    public function getUserToken(){
        $this->db->select('u.notification_token');
        $this->db->from('tbl_users u');
        $this->db->where('u.role',3);
        $this->db->where('u.notification_token!=','None');
        $this->db->where('u.notification_token!=','');
        $result = $this->db->get();
        // print_r($this->db->last_query());die;
        return $result->result_array();
    }
}
?>