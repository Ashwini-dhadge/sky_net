<?php

/**
 * 
 */
class Course extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(ADMIN . 'CourseModel');
	}

	/*********************************************************************/
	//  QMR

	public function index()
	{
		loginId();
		$data['title'] = 'Course Master';
		$data['active'] = 'Course Master';
		$this->load->view(ADMIN . COURSE . 'list-Course', $data);
	}

	public function Course_list()
	{

		$data = $_POST;
		$columns = [];
		$page = $data['draw'];
		$limit = $data['length'];
		$offset = $data['start'];
		$searchVal = $data['search']['value'];
		$sortColIndex = $data['order'][0]['column'];
		$sortBy = $data['order'][0]['dir'];

		$count = count($this->CourseModel->getCourseData($searchVal, 0, 0, 0, 0));
		if ($count) {
			$CourseData = $this->CourseModel->getCourseData($searchVal, $sortColIndex, $sortBy, $limit, $offset);

			foreach ($CourseData as $key => $Course) {

				$row = [];

				array_push($row, $offset + ($key + 1));
				$title = '<a href="' . base_url() . 'admin/Course/View/' . $Course['id'] . '">' . $Course['title'] . '</a>';
				array_push($row, $title);
				$edit_updateTradeQty = '<div contenteditable class="updateDataTableCourse" data-id="' . $Course["id"] . '" data-column="sort_by">' . $Course["sort_by"] . '</div>';
				array_push($row, $edit_updateTradeQty);
				//array_push($row, $Course['Course_name']);
				array_push($row, $Course['category_name']);
				// array_push($row, $Course['title']);
				// array_push($row, $Course['offer_amount']);
				if ($Course['status']) {
					$status = '<span class="badge badge-success ">Active</span>';
				} else {
					$status = '<span class="badge badge-danger ">Not Active</span>';
				}
				array_push($row, $status);

				$alert = "confirm('Do you want to delete this record?');";
				//	$action = '<a class="btn btn-success btn-sm waves-effect waves-light" href="'.base_url().'admin/Course/Course/'.$Course['id'].'" role="button" ><i class="fas fa-edit"></i></a>            	<a class="btn btn-danger btn-sm waves-effect waves-light" href="'.base_url().'admin/Course/CourseDelete/'.$Course['id'].'" role="button" onclick="return '.$alert.'" ><i class="fas fa-trash-alt"></i></a>';
				$action = '<a class="btn btn-success btn-sm waves-effect waves-light" href="' . base_url() . 'admin/Course/Course/' . $Course['id'] . '" role="button" ><i class="fas fa-edit"></i></a> ';
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


	public function section_list()
	{

		$data = $_POST;
		$columns = [];
		$page = $data['draw'];
		$limit = $data['length'];
		$offset = $data['start'];
		$searchVal = $data['search']['value'];
		$sortColIndex = $data['order'][0]['column'];
		$sortBy = $data['order'][0]['dir'];

		$course_id = $data['course_id'];

		$count = count($this->CourseModel->getSectionData($searchVal, 0, 0, 0, 0, $course_id));
		if ($count) {
			$sectionData = $this->CourseModel->getSectionData($searchVal, $sortColIndex, $sortBy, $limit, $offset, $course_id);

			foreach ($sectionData as $key => $section) {

				$row = [];

				array_push($row, $offset + ($key + 1));

				//array_push($row, $Course['Course_name']);
				array_push($row, $section['title']);



				$alert = "confirm('Do you want to delete this record?');";
				$action = '<a class="btn btn-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#SModal" onclick="courseSectionEdit(' . $section['id'] . ')" role="button"><i class="fas fa-edit"></i></a>';
				$action .= '<a class="btn btn-danger btn-sm waves-effect waves-light" href="' . base_url() . 'admin/Course/CourseSectionDelete/' . $section['course_id'] . '/' . $section['id'] . '" role="button" onclick="return ' . $alert . '" ><i class="fas fa-trash-alt"></i></a>';
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

	public function courseSectionEdit()
	{
		$id = $this->input->post('id');

		if ($id) {
			if ($data = $this->CourseModel->getSectionData('', 0, '', 0, 0, 0, $id)) {
				//	echo $this->db->last_query();die();
				$response['section'] = $data;
				$response['status'] = true;
			} else {
				$response['status'] = false;
				$response['reason'] = "Error, Product Data not found";
			}
		}
		echo json_encode($response);
	}


	public function lesson_list()
	{

		$data = $_POST;
		$columns = [];
		$page = $data['draw'];
		$limit = $data['length'];
		$offset = $data['start'];
		$searchVal = $data['search']['value'];
		$sortColIndex = $data['order'][0]['column'];
		$sortBy = $data['order'][0]['dir'];

		$course_id = $data['course_id'];


		$count = count($this->CourseModel->getLessonData($searchVal, 0, 0, 0, 0, $course_id));
		if ($count) {
			$lessonData = $this->CourseModel->getLessonData($searchVal, $sortColIndex, $sortBy, $limit, $offset, $course_id);

			foreach ($lessonData as $key => $lesson) {

				$row = [];

				array_push($row, $offset + ($key + 1));

				//array_push($row, $Course['Course_name']);
				array_push($row, $lesson['title']);
				array_push($row, $lesson['duration']);
				array_push($row, $lesson['section_name']);
				array_push($row, $lesson['lesson_type']);

				$alert = "confirm('Do you want to delete this record?');";
				$action = '<a class="btn btn-secondary btn-sm waves-effect waves-light" data-toggle="modal" data-target="#LModal" onclick="courseLessonEdit(' . $lesson['id'] . ')" role="button"><i class="fas fa-edit"></i></a>';
				$action .= '<a class="btn btn-danger btn-sm waves-effect waves-light" href="' . base_url() . 'admin/Course/CourseDelete/' . $lesson['course_id'] . '/' . $lesson['id'] . '" role="button" onclick="return ' . $alert . '" ><i class="fas fa-trash-alt"></i></a>';
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
	public function courseLessonEdit()
	{
		$id = $this->input->post('id');

		if ($id) {
			if ($data = $this->CourseModel->getLessonData('', 0, '', 0, 0, 0, $id)) {
				//	echo $this->db->last_query();die();
				$response['lesson'] = $data;
				$response['status'] = true;
			} else {
				$response['status'] = false;
				$response['reason'] = "Error, lesson Data not found";
			}
		}
		echo json_encode($response);
	}


	public function Course($id = '')
	{
		if (!$this->input->post()) {
			if ($id) {
				//print_r($id);die;
				$data['title'] = 'Edit Course';
				$data['course'] = $this->CourseModel->getCourseData('', 0, 0, 0, 0, $id);
				$data['course_duration'] = $this->CourseModel->getDurationData('', 0, 0, 0, 0, $id);
				//print_r($data['course_duration']);die;

			} else {
				$data['title'] = 'Add Course';
			}
			$data['active'] = 'Course';
			$data['category'] = $this->CommonModel->getData('tbl_categories', array('status' => 1));
			$data['skill'] = $this->CommonModel->getData('tbl_skill_master');
			$data['duration'] = $this->CommonModel->getData('tbl_duration_master', array('deleted_by' => NULL));


			$this->load->view(ADMIN . COURSE . 'Course', $data);
		} else {

			$post = $this->input->post();
			// echo "<pre>";
			// print_r($post);
			// die;
			if ($post) {
				$course = array(
					'title'  => $post['title'],
					'skill_id'           => $post['skill_id'][0] ?? '',
					'category_id'   => $post['category_id'],
					'assessment'      => $post['assessment'],
					'benefits' => $post['benefits'],
					'language'  => $post['language'],
					'certificate'         => $post['certificate'],
					'status'            => $post['status'],
					'is_free' => $post['is_free']
				);
				if ($_FILES) {
					$result = fileUpload(COURSE_IMAGES, 'image', false);
					if ($result['status'] == true) {
						$course['image'] = $result['image_name'];
					} else {
						unset($course['image']);
					}
				}

				if (empty($post['id'])) {
					$sort_number = $this->CommonModel->getData('tbl_courses', '', 'max(sort_by) as sort_by', '', 'row_array');
					if (!empty($sort_number['sort_by']) && isset($sort_number['sort_by'])) {
						$number = $sort_number['sort_by'] + 1;
					} else {
						$number = 1;
					}
					$course['instructor_id'] = loginId();

					if (isset($post['sort_by']) && $post['sort_by']) {
						$course['sort_by'] = $post['sort_by'];
					} else {
						$course['sort_by'] = $number;
					}

					$d_id = $this->CommonModel->iudAction('tbl_courses', $course, 'insert');
					//	print_r($d_id);die;
					if ($d_id) {
						foreach ($post['course'] as $key => $value) {
							$duration = $post['course'][$key];
							$duration_time = array(
								'courses_id'    => $d_id,
								'duration_id'   => $duration['duration_id'],
								'price'   => $duration['price'],
								'offer_type'   => $duration['offer_type'],
								'offer_amount'   => $duration['offer_amount'],
								'strike_thr_price'   => $duration['strike_thr_price']
							);
							//print_r($duration_time);die;
							$dt_id = $this->CommonModel->iudAction('tbl_courses_duration', $duration_time, 'insert');
						}

						$this->session->set_flashdata('success', 'Courses added successfully');
					} else {
						$this->session->set_flashdata('error', 'Error! fail to add vendor');
					}
				} else {
					$where = array('id' => $post['id']);
					$this->CommonModel->iudAction('tbl_courses', $course, 'update', $where);
					//print_r($this->db->last_query());die;
					if (isset($post['course'])) {
						foreach ($post['course'] as $key => $value) {
							$duration = $post['course'][$key];
							$duration_time = array(
								'courses_id'    => $post['id'],
								'duration_id'   => $duration['duration_id'],
								'price'   => $duration['price'],
								'offer_type'   => $duration['offer_type'],
								'offer_amount'   => $duration['offer_amount'],
								'strike_thr_price'   => $duration['strike_thr_price']
							);
							//print_r($duration_time);die;
							if (isset($duration['id']) && $duration['id'] != '') {
								$this->CommonModel->iudAction('tbl_courses_duration', $duration_time, 'update', array('id' => $duration['id']));
								$v_id = $duration['id'];
							} else {
								$v_id = $this->CommonModel->iudAction('tbl_courses_duration', $duration_time, 'insert');
							}
						}
					} else {
						$this->CommonModel->iudAction('tbl_courses_duration', '', 'delete', array('courses_id' => $post['id']));
					}

					$this->session->set_flashdata('success', 'Courses update successfully');
				}
			}

			redirect(base_url(ADMIN . 'Course'));
		}
	}




	public function CourseSectionDelete($course_id, $id)
	{
		$where = array('id' => $id);

		if ($this->CommonModel->iudAction('section', '', 'delete', $where)) {

			$this->session->set_flashdata('success', 'Section deleted successfully');
			redirect(base_url(ADMIN . 'Course/viewCourse/' . $course_id));
		} else {
			$this->session->set_flashdata('error', 'Error! fail to delete Site');
			redirect(base_url(ADMIN . 'Course/viewCourse/' . $course_id));
		}
	}

	public function CourseLessonDelete($course_id, $id)
	{
		$where = array('id' => $id);

		if ($this->CommonModel->iudAction('lesson', '', 'delete', $where)) {

			$this->session->set_flashdata('success', 'lesson deleted successfully');
			redirect(base_url(ADMIN . 'Course/viewCourse/' . $course_id));
		} else {
			$this->session->set_flashdata('error', 'Error! fail to delete Site');
			redirect(base_url(ADMIN . 'Course/viewCourse/' . $course_id));
		}
	}
	public function CourseDelete($id)
	{
		$where = array('id' => $id);

		if ($this->CommonModel->iudAction('tbl_courses', array('deleted_by' => $id), 'update', $where)) {

			$this->session->set_flashdata('success', 'lesson deleted successfully');
			redirect(ADMIN . 'Course');
		} else {
			$this->session->set_flashdata('error', 'Error! fail to delete Site');
			redirect(ADMIN . 'Course');
		}
	}



	public function viewCourse($id)
	{
		if ($id) {
			$data['course'] = $this->CourseModel->getCourseDetail($id);
			$data['section'] = $this->CommonModel->get('section', array('course_id' => $id));

			$data['title'] = 'Course';
			$data['active'] = 'Course';
			$sort_number = $this->CourseModel->getMaxOrderNumber($id);

			if (count($sort_number)) {
				$number = $sort_number[0]['sort_number'] + 1;
			} else {
				$number = 1;
			}
			$sort_number1 = $this->CourseModel->getMaxLessonOrderNumber($id);

			if (count($sort_number1)) {
				$number1 = $sort_number1[0]['sort_number1'] + 1;
			} else {
				$number1 = 1;
			}
			$data['number_section'] = $number;
			$data['number_lesson'] = $number1;

			//	echo "<pre>";
			//print_r($data);die();
			$this->load->view(ADMIN . COURSE . 'course-detail-view', $data);
		} else {
			$this->session->set_flashdata('error', 'Error! Course not found');
			redirect(ADMIN . 'Course');
		}
	}

	public function courseSection($value = '')
	{


		$post_data = $this->input->post();
		if (!$post_data['id']) {

			if ($id = $this->CommonModel->iudAction('section', $post_data, 'insert')) {

				$this->session->set_flashdata('success', 'section added successfully');
			} else {
				$this->session->set_flashdata('error', 'Error! fail to add vendor');
			}
		} else {
			$where = array('id' => $post_data['id']);

			$rid = $this->CommonModel->iudAction('section', $post_data, 'update', $where);
			if ($rid) {

				$this->session->set_flashdata('success', 'section updated successfully');
			} else {
				$this->session->set_flashdata('error', 'Error! fail to update Courses');
			}
		}
		redirect(base_url(ADMIN . 'Course/viewCourse/' . $post_data['course_id']));
	}
	public function courseLesson($value = '')
	{

		$post_data = $this->input->post();
		if (!$post_data['id']) {

			$post_data1 = array(
				'title' => $post_data['title'],
				'duration' => $post_data['duration'],
				'course_id' => $post_data['course_id'],
				'section_id' => $post_data['section_id'],
				'video_type' => $post_data['video_type'],
				'video_url' => $post_data['video_url'],
				'date_added' => time(),
				'lesson_type' => $post_data['lesson_type'],
				'summary' => $post_data['summary'],
				'order' => $post_data['order'],
				'video_type_for_mobile_application' => $post_data['video_url'],
				'video_url_for_mobile_application' => $post_data['video_url'],
				'duration_for_mobile_application' => $post_data['video_url'],
			);


			if (!empty($_FILES['image']['name'])) {

				if (!empty($_FILES['image']['name'])) {
					$banner_image = $_FILES['image']['name'];
				}

				$uploadStatus = myUpload(UPLOAD_PATH_LESSON, 'image');

				$imagePath = $uploadStatus['data']['file_name'];
				$post_data1['attachment'] = $imagePath;
			}
			if ($id = $this->CommonModel->iudAction('lesson', $post_data1, 'insert')) {

				$this->session->set_flashdata('success', 'lesson added successfully');
			} else {
				$this->session->set_flashdata('error', 'Error! fail to add vendor');
			}
		} else {
			$where = array('id' => $post_data['id']);
			$post_data1 = array(
				'title' => $post_data['title'],
				'duration' => $post_data['duration'],
				'section_id' => $post_data['section_id'],
				'video_type' => $post_data['video_type'],
				'video_url' => $post_data['video_url'],
				'last_modified' => time(),
				'lesson_type' => $post_data['lesson_type'],
				'summary' => $post_data['summary'],
				'order' => $post_data['order'],
				'video_type_for_mobile_application' => $post_data['video_url'],
				'video_url_for_mobile_application' => $post_data['video_url'],
				'duration_for_mobile_application' => $post_data['video_url'],
			);
			if (!empty($_FILES['image']['name'])) {

				if (!empty($_FILES['image']['name'])) {
					$banner_image = $_FILES['image']['name'];
				}

				$uploadStatus = myUpload(UPLOAD_PATH_LESSON, 'image');

				$imagePath = $uploadStatus['data']['file_name'];
				$post_data1['attachment'] = $imagePath;
			}

			$rid = $this->CommonModel->iudAction('lesson', $post_data1, 'update', $where);
			if ($rid) {

				$this->session->set_flashdata('success', 'lesson updated successfully');
			} else {
				$this->session->set_flashdata('error', 'Error! fail to update Courses');
			}
		}
		redirect(base_url(ADMIN . 'Course/viewCourse/' . $post_data['course_id']));
	}

	public function View($_id)
	{
		//print_r($_id);die;
		$data['title'] = 'Course Details';
		$course = $this->CourseModel->getCourseData('', 0, 0, 0, 0, $_id);
		// print_r($this->db->last_query());die;
		// print_r($course);die;
		if ($course) {
			$data['course'] = $course[0];
			$this->load->view(ADMIN . COURSE . 'course-view', $data);
		}
	}



	public function listDurationlist()
	{
		$data = $_POST;
		$columns = [];
		$page = $data['draw'];
		$limit = $data['length'];
		$offset = $data['start'];
		$searchVal = $data['search']['value'];
		$sortColIndex = $data['order'][0]['column'];
		$sortBy = $data['order'][0]['dir'];

		$d_id = $this->input->post('d_id');

		$where = array();

		// if($c_id){
		//     $where['ic.incidence_id'] = $c_id;
		// }
		//print_r($o_id);die;
		$count = count($this->CourseModel->getCourseDurationData($searchVal, 0, 0, 0, 0, $d_id, $where));
		//print_r($this->db->last_query());die;
		if ($count) {
			$result = $this->CourseModel->getCourseDurationData($searchVal, $sortColIndex, $sortBy, $limit, $offset, $d_id, $where);
			// print_r($result);die;
			foreach ($result as $key => $value) {

				$row = [];
				array_push($row, $offset + ($key + 1));
				array_push($row, $value['name']);

				if ($value['language'] == 1) {
					$language = '<span class="badge badge-secondary ">English</span>';
				} else {
					$language = '<span class="badge badge-secondary ">Marathi</span>';
				}

				array_push($row, $language);
				// array_push($row, $value['duration']);
				if ($value['offer_type'] == 1) {
					$offer_type = '<span class="badge badge-primary ">Flat</span>';
				} else {
					$offer_type = '<span class="badge badge-primary ">Percentage</span>';
				}
				array_push($row, $offer_type);

				array_push($row, $value['offer_amount']);
				array_push($row, $value['strike_thr_price']);
				if ($value['status'] == 1) {
					$status = '<span class="badge badge-success _status" onclick="changeDurationStatus(' . $value['id'] . ',0)" id="status_' . $value['id'] . '" title="Click for In-Active">Active</span>';
				} else {
					$status = '<span class="badge badge-danger _status" onclick="changeDurationStatus(' . $value['id'] . ',1)" id="status_' . $value['id'] . '" title="Click for Active">In-Active</span>';
				}

				array_push($row, $status);
				$alert = "confirm('Do you want to delete this record?');";
				//	$action = '<a class="btn btn-danger btn-sm waves-effect waves-light" href="'.base_url().'admin/Course/CourseDurationDelete/'.$d_id.'/'.$value['id'].'" role="button" onclick="return '.$alert.'" ><i class="fas fa-trash-alt"></i></a>';
				// array_push($row, $action);
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

	public function CourseDurationDelete($d_id = '', $id = '')
	{

		$where = array('id' => $id);
		// print_r($where);die;
		if ($this->CommonModel->iudAction('tbl_courses_duration', array('deleted_by' => loginId(), 'deleted_at' => date('Y-m-d H:i:s')), 'delete', $where)) {

			$this->session->set_flashdata('success', 'Course Duration deleted successfully');
			redirect(ADMIN . 'Course/View/' . $d_id);
		} else {
			$this->session->set_flashdata('error', 'Error! fail to delete Course Duration');
			redirect(ADMIN . 'Course/View/' . $d_id);
		}
	}

	public function changeDurationStatus()
	{
		$get = $this->input->get();
		//  print_r($get);die;
		if ($this->CommonModel->iudAction('tbl_courses_duration', $get, 'update', array('id' => $get['id']))) {
			$response['result'] = TRUE;
			$response['reason'] = 'Duration Status Updated Successfully';
		} else {
			$response['result'] = FALSE;
			$response['reason'] = 'Duration Status Not Update!';
		}
		echo json_encode($response);
	}
	public function getCourseName()
	{

		if (isset($_GET['searchTerm'])) {
			$searchTerm = $_GET['searchTerm'];
		} else {
			$searchTerm = '';
		}
		$pes = $this->CourseModel->getCourseName($searchTerm);
		$data = $chidls = array();
		foreach ($pes as $key => $ps) {
			$data[] = ['id' => $ps['id'], 'text' => $ps['name']];
		}
		echo json_encode($data);
	}
	public function getCourseDurationsName()
	{
		$courses_id = $this->input->post('courses_id');
		if ($courses_id) {

			$duration = $this->CourseModel->getCourseDurationData('', 0, 0, 0, 0, 0, array('courses_id' => $courses_id));
			//   echo $this->db->last_query();die();

			$response['duration'] = $duration;
			$response['status'] = true;
		} else {
			$response['status'] = false;
			$response['reason'] = "Error, ok Data not found";
		}
		echo json_encode($response);
	}

	public function getAmount()
	{
		$courses_id = $this->input->post('courses_id');
		$type = $this->input->post('type');
		$courses_duration_id = $this->input->post('courses_duration_id');
		if ($type == 1) {
			$where = array('id' => $courses_duration_id, 'courses_id' => $courses_id);
		} else {
			$where = array('courses_id' => $courses_id);
		}
		if ($courses_id) {

			$duration =  $this->CommonModel->getData('tbl_courses_duration', $where, 'price', '', 'row_array');
			//   echo $this->db->last_query();die();

			$response['amount'] = $duration['price'];
			$response['status'] = true;
		} else {
			$response['status'] = false;
			$response['reason'] = "Error, ok Data not found";
		}
		echo json_encode($response);
	}

	public function CourseTypeUpdate()
	{
		if ($this->input->post()) {
			$id = $this->input->post('id');
			$value = $this->input->post('value');
			$column = $this->input->post('column');


			if ($id) {
				if ($this->CommonModel->iudAction('tbl_courses', array($column => $value), 'update', array('id' => $id))) {

					$reaponse['result'] = true;
					$reaponse['reason'] = 'Course Sorting Updated Successfully';
				} else {
					$reaponse['result'] = false;
					$reaponse['reason'] = 'Error! fail to Course Sorting  Product Variant';
				}
			}
		}
		echo json_encode($reaponse);
	}
}
