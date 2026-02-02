<?php
/**
 * 
 */
class Category extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(ADMIN.'CategoryModel');
	}

/*********************************************************************/
//  QMR

	public function index()
	{
		$data['title'] = 'Category Master';
		$data['active'] = 'Category Master';
		$this->load->view(ADMIN.CAT.'list-Category',$data);
		 loginId();
	}

	public function Category_list()
	{

		$data = $_POST;
        $columns = [];
        $page = $data['draw'];
        $limit = $data['length'];
        $offset = $data['start'];
        $searchVal = $data['search']['value'];
        $sortColIndex = $data['order'][0]['column'];
        $sortBy = $data['order'][0]['dir'];

        $count = count($this->CategoryModel->getCategoryData($searchVal,0,0,0,0));
        if($count){
            $CategoryData = $this->CategoryModel->getCategoryData($searchVal, $sortColIndex, $sortBy, $limit, $offset);

            foreach ($CategoryData as $key => $Category) {
            
                $row = []; 

                array_push($row, $offset+($key + 1));   
                array_push($row, $Category['category_name']);
                if($Category['status']){
                 $status = '<span class="badge badge-success ">Active</span>';
                }else{
                 $status = '<span class="badge badge-danger ">Not Active</span>';

                }
                array_push($row, $status);
            	$confirm = "confirm('Do you want to delete this record?');";
            	$action = '
                <a href="javascript:void(0);" title="Edit" class="btn btn-primary waves-effect waves-light btn-sm categoryModal" onclick="categoryModal('.$Category['id'] .')" data-id="'.$Category['id'] .'" ><i class="fas fa-edit" aria-hidden="true"></i></a>
                <a onclick="return '.$confirm.'" href="'.base_url() .ADMIN.'Category/delete/'.$Category['id'] .'" title="Delete" class="btn btn-danger btn-sm waves-effect waves-light" ><i class="fas fa-trash-alt" aria-hidden="true"></i></a>';
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
	public function categoryModal()
	{
		$id = $this->input->post('id');
		$data['sub_title'] = 'Add Category';
		$data['categories'] = $data['category'] = array();
		if ($id) {
        	$category = $this->CategoryModel->getCategoryData('',0,0,0,0,$id);
			$data['sub_title'] = 'Edit Category';
			$data['category'] = $category[0];
        	$data['categories'] = $this->CategoryModel->getCategoryData();
		}

		$html = $this->load->view(ADMIN.CAT.'modal_category', $data,true);
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

	public function getCategory()
	{
		$category_level = $this->input->get('category_level');

		if ($category_level) {
        	$categories = $this->CategoryModel->getCategoryData('',0,0,0,0,0,array('c.category_level' => $category_level - 1 ));
        	if ($categories) {
				$response['categories'] = $categories;
				$response['result'] = true;
				$response['reason'] = 'Data Found';
			}else{
				$response['result'] = fasle;
				$response['reason'] = 'Something went to wrong!';
			}
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

			if ($_FILES) {
                $result = fileUpload(CATEGORY_IMAGES, 'category_icon', false);
                if ($result['status'] == true) {
                    $post['category_icon'] = $result['image_name']; 
                }else{
                    unset($post['category_icon']);
                }
            }
			if (empty($post['id'])) {
				if ($this->CommonModel->iudAction('tbl_categories',$post,'insert')) {
					$this->session->set_flashdata('success', 'Category Added Succesfully!');
				}else{
					$this->session->set_flashdata('error','Fail To Add Category!');
				}
			}else{
				if ($this->CommonModel->iudAction('tbl_categories',$post,'update',array('id'=> $post['id']))) {
					$this->session->set_flashdata('success','Category Updated Succesfully!');
				}else{
					$this->session->set_flashdata('error','Fail To Update Category!');
				}
			}

		}else{
			$this->session->set_flashdata('error','Something went to wrong!');
		}

        redirect(base_url(ADMIN.'Category'));
	}


	public function delete($id)
	{
		$where = array('id' => $id);

		if ($this->CommonModel->iudAction('tbl_categories',array('is_deleted'=>1),'update',$where)) {
			
			$this->session->set_flashdata('success','Category deleted successfully');
			redirect(ADMIN.'Category');
		}else{
			$this->session->set_flashdata('error','Error! fail to delete Site');
			redirect(ADMIN.'Category');
		}
	}
    
    public function viewCategory($id)
    {  	
    		if ($id) {
				$data['Category'] = $this->CategoryModel->getCategoryDetail($id);
				$data['title'] = 'Category';
				$data['active'] = 'Category';
				$this->load->view(ADMIN.CAT.'Category-detail-view', $data);
			}else{
				$this->session->set_flashdata('error','Error! Category not found');
				redirect(ADMIN.'Category');
			}
    }

    
}
?>