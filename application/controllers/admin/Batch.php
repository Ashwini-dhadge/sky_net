<?php
class Batch extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(ADMIN . 'BatchModel');
		loginId();
	}

	public function index()
	{
		$data['title'] = 'Batch Master';
		$data['active'] = 'Batch Master';
		$this->load->view(ADMIN . BATCH . 'list-batch', $data);
		loginId();
	}

	public function batch_list()
	{
		$data = $_POST;
		$columns = [];
		$page = isset($data['draw']) ? $data['draw'] : 1;
		$limit = isset($data['length']) ? $data['length'] : 10;
		$offset = isset($data['start']) ? $data['start'] : 0;
		$searchVal = isset($data['search']['value']) ? $data['search']['value'] : '';
		$sortColIndex = isset($data['order'][0]['column']) ? $data['order'][0]['column'] : 0;
		$sortBy = isset($data['order'][0]['dir']) ? $data['order'][0]['dir'] : 'desc';

		$count = count($this->BatchModel->getBatchData($searchVal, 0, 0, 0, 0));
		if ($count) {
			$batchData = $this->BatchModel->getBatchData($searchVal, $sortColIndex, $sortBy, $limit, $offset);

			foreach ($batchData as $key => $batch) {
				$row = [];

				array_push($row, $offset + ($key + 1));
				array_push($row, html_escape($batch['batch_name']));
				array_push($row, html_escape($batch['batch_description']));

				$action = '<a href="javascript:void(0);" title="Edit" class="btn btn-primary btn-sm batchModal" data-id="' . $batch['id'] . '"><i class="fas fa-edit"></i></a> ';
				if (empty($batch['total_students']) || $batch['total_students'] == 0) {
					$action .= '<a href="' . base_url(ADMIN . 'Batch/delete/' . $batch['id']) . '" onclick="return confirm(\'Do you want to delete this record?\');" title="Delete" class="btn btn-danger btn-sm waves-effect waves-light"><i class="fas fa-trash-alt"></i></a>';
				}

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

	public function batchModal()
	{
		$id = $this->input->post('id');
		$data['sub_title'] = 'Add Batch';
		$data['batch'] = array();

		if ($id) {
			$batch = $this->BatchModel->getBatchData('', 0, 0, 0, 0, $id);
			$data['sub_title'] = 'Edit Batch';
			if (!empty($batch)) {
				$data['batch'] = $batch[0];
			}
		}

		$html = $this->load->view(ADMIN . BATCH . 'modal_batch', $data, true);
		if ($html) {
			$response['html'] = $html;
			$response['result'] = true;
			$response['reason'] = 'Data Found';
		} else {
			$response['result'] = false;
			$response['reason'] = 'Something went wrong!';
		}
		echo json_encode($response);
	}

	public function add()
	{
		$post = $this->input->post();

		if ($post) {
			$this->db->where('batch_name', $post['batch_name']);
			$this->db->where('deleted_at IS NULL', null, false);

			if (!empty($post['id'])) {
				$this->db->where('id !=', $post['id']);
			}

			$exists = $this->db->get('tbl_batches')->row_array();

			if ($exists) {
				$this->session->set_flashdata('error', 'Batch name already exists!');
				redirect(base_url(ADMIN . 'Batch'));
				return;
			}

			$user_id = $this->session->userdata('id') ? $this->session->userdata('id') : 1;

			if (empty($post['id'])) {
				$post['created_by'] = $user_id;
				$post['created_at'] = date('Y-m-d H:i:s');

				if ($this->CommonModel->iudAction('tbl_batches', $post, 'insert')) {
					$this->session->set_flashdata('success', 'Batch Added Successfully!');
				} else {
					$this->session->set_flashdata('error', 'Fail To Add Batch!');
				}
			} else {
				$post['updated_by'] = $user_id;
				$post['updated_at'] = date('Y-m-d H:i:s');

				if ($this->CommonModel->iudAction('tbl_batches', $post, 'update', ['id' => $post['id']])) {
					$this->session->set_flashdata('success', 'Batch Updated Successfully!');
				} else {
					$this->session->set_flashdata('error', 'Fail To Update Batch!');
				}
			}
		} else {
			$this->session->set_flashdata('error', 'Something went wrong!');
		}

		redirect(base_url(ADMIN . 'Batch'));
	}

	public function delete($id)
	{
		$where = array('id' => $id);
		$user_id = $this->session->userdata('id') ? $this->session->userdata('id') : 1;

		$assignedUser = $this->db->where(['batch_id' => $id, 'is_deleted' => 0])->count_all_results('tbl_users');
		if ($assignedUser > 0) {
			$this->session->set_flashdata('error', 'Cannot delete batch! This batch is assigned to user(s).');
			redirect(ADMIN . 'Batch');
			return;
		}

		$updateData = array(
			'deleted_at' => date('Y-m-d H:i:s'),
			'deleted_by' => $user_id
		);

		if ($this->CommonModel->iudAction('tbl_batches', $updateData, 'update', $where)) {
			$this->session->set_flashdata('success', 'Batch deleted successfully');
		} else {
			$this->session->set_flashdata('error', 'Error! Fail to delete batch');
		}
		redirect(ADMIN . 'Batch');
	}
}
?>
