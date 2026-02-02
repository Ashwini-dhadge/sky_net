<?php
/**
 * 
 */
class DurationMaster extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(ADMIN.'DurationMasterModel');
	}

/*********************************************************************/
//  QMR

	public function index()
	{
		$data['title'] = 'Duration Master';
		$data['active'] = 'Duration Master';
		$this->load->view(ADMIN.'duration'.'/list-duration',$data);
	}

	public function Durtation_list()
	{

		$data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
         $sortBy = $data['order'][0]['dir'];

        $count = count($this->DurationMasterModel->getDurationData($searchVal,0,0,0,0));
        if($count){
            $DurationData = $this->DurationMasterModel->getDurationData($searchVal, $sortColIndex, $sortBy, $limit, $offset);

            foreach ($DurationData as $key => $rank) {
            
                $row = []; 

                array_push($row, $offset+($key + 1));   
               
                array_push($row, $rank['name']);    
                array_push($row, $rank['no_of_days']);              
                      
             
               
            	$confirm = "confirm('Do you want to delete this record?');";
            /*	$action = '
                <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm durationModal" onclick="durationModal('.$rank['id'] .')" data-id="'.$rank['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>
                <a onclick="return '.$confirm.'" href="'.base_url() .ADMIN.'DurationMaster/delete/'.$rank['id'] .'" title="Delete" class="btn btn-danger btn-sm waves-effect waves-light" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>'; */
                	$action = '
                <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm durationModal" onclick="durationModal('.$rank['id'] .')" data-id="'.$rank['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>
              ';
                array_push($row, $action);
            	
                $columns[] = $row;
            }
        }
        $response = [
            'draw' => $page,
            'data' => $columns,
            'recordsTotal' => $count,
            'recordsFiltered' => $count
        ];
        echo json_encode($response);
	}
	public function durationModal()
	{
		$id = $this->input->post('id');
		$data['sub_title'] = 'Add Duration';
		$data['durations'] = $data['duration'] = array();
		if ($id) {
        	$duration = $this->DurationMasterModel->getDurationData('',0,0,0,0,$id);
			$data['sub_title'] = 'Edit Duration Master';
			$data['duration'] = $duration[0];
        	
		}

		$html = $this->load->view(ADMIN.'duration'.'/modal_duration', $data,true);
		if ($html) {
			$response['html'] = $html;
			$response['result'] = true;
			$response['reason'] = 'Data Found';
		}else{
			$response['result'] = fasle;
			$response['reason'] = 'Something went to wrong!';
		}
		echo json_encode($response);
	}

	

	public function add()
	{
		$post = $this->input->post();
		if ($post) {

			
			if (empty($post['id'])) {
				//['created_by']
				$post['created_by'] = loginId();

				if ($this->CommonModel->iudAction('tbl_duration_master',$post,'insert')) {
					$this->session->set_flashdata('success', 'Duration Added Succesfully!');
				}else{
					$this->session->set_flashdata('error','Fail To Add Duration!');
				}
			}else{
				$post['created_by'] = loginId();
				if ($this->CommonModel->iudAction('tbl_duration_master',$post,'update',array('id'=> $post['id']))) {
					$this->session->set_flashdata('success','Duration Updated Succesfully!');
				}else{
					$this->session->set_flashdata('error','Fail To Update Duration!');
				}
			}

		}else{
			$this->session->set_flashdata('error','Something went to wrong!');
		}

        redirect(base_url(ADMIN.'DurationMaster'));
	}


	public function delete($id)
	{
		$where = array('id' => $id);
		// $user=$this->session->userdata('user_id');

 
		if ($this->CommonModel->iudAction('tbl_duration_master',array('deleted_by'=>loginId(),'deleted_at'=>date('Y-m-d H:i:s')),'update',$where)) {
			
			$this->session->set_flashdata('success','Rank deleted successfully');
			redirect(ADMIN.'DurationMaster');
		}else{
			$this->session->set_flashdata('error','Error! fail to delete Rank');
			redirect(ADMIN.'DurationMaster');
		}
	}
    
   

    
}
?>