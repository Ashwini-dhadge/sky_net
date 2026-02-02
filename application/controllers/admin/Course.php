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
				$action = '
					<a class="btn btn-success btn-sm waves-effect waves-light" 
					href="' . base_url() . 'admin/Course/Course/' . $Course['id'] . '" 
					title="Edit Course">
					<i class="fas fa-edit"></i>
					</a>
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

	public function course_qna($course_id)
	{
		$data['title']     = 'Course Q&A';
		$data['course_id'] = $course_id;
		$data['active']    = 'Course';
		$this->load->view(ADMIN . COURSE . 'course_qna', $data);
	}
	public function course_qna_list()
	{
		$post = $this->input->post();

		$course_id = $post['course_id'] ?? 0;

		$draw   = intval($post['draw'] ?? 1);
		$start  = intval($post['start'] ?? 0);
		$length = intval($post['length'] ?? 10);
		$search = $post['search']['value'] ?? '';

		/* ===== TOTAL COUNT ===== */
		$this->db->from('tbl_course_qna q');
		$this->db->where('q.course_id', $course_id);
		$total = $this->db->count_all_results();

		/* ===== FILTERED COUNT ===== */
		$this->db->from('tbl_course_qna q');
		$this->db->join('tbl_users ask', 'ask.id = q.user_id', 'left');
		$this->db->where('q.course_id', $course_id);

		if ($search !== '') {
			$this->db->group_start();
			$this->db->like('q.question', $search);
			$this->db->like('ask.first_name', $search);
			$this->db->or_like('ask.last_name', $search);
			$this->db->group_end();
		}

		$filtered = $this->db->count_all_results();

		/* ===== DATA ===== */
		$this->db->select('
        q.*,
        CONCAT(ask.first_name," ",ask.last_name) AS asked_by,
        CONCAT(ans.first_name," ",ans.last_name) AS answered_by,
        c.status AS course_status
    ');
		$this->db->from('tbl_course_qna q');
		$this->db->join('tbl_users ask', 'ask.id = q.user_id', 'left');
		$this->db->join('tbl_users ans', 'ans.id = q.ans_created_by', 'left');
		$this->db->join('tbl_courses c', 'c.id = q.course_id', 'left');
		$this->db->where('q.course_id', $course_id);

		if ($search !== '') {
			$this->db->group_start();
			$this->db->like('q.question', $search);
			$this->db->like('ask.first_name', $search);
			$this->db->or_like('ask.last_name', $search);
			$this->db->group_end();
		}

		$this->db->order_by('CASE WHEN q.answer IS NULL THEN 0 ELSE 1 END', 'ASC', FALSE); // ✅ Pending first
		$this->db->order_by('q.created_at', 'ASC');

		$this->db->limit($length, $start);
		$result = $this->db->get()->result_array();

		$data = [];
		$sr = $start + 1;

		foreach ($result as $row) {

			$isAnswered = !empty($row['answer']);

			/* STATUS */
			$status = $isAnswered
				? '<span class="badge badge-success">Answered</span>'
				: '<span class="badge badge-warning">Pending</span>';

			/* ANSWERED BY + TOOLTIP */
			if ($isAnswered) {
				$answeredTime = date('d M Y h:i A', strtotime($row['ans_created_at']));
				$answeredBy = '<span data-toggle="tooltip" title="Answered on ' . $answeredTime . '">'
					. ($row['answered_by'] ?: 'Instructor') .
					'</span>';
			} else {
				$answeredBy = '-';
			}

			/* SAFE JS VALUES */
			$questionJs = json_encode($row['question']);
			$answerJs   = json_encode($row['answer']);

			/* ACTION */
			if ($row['course_status'] == 1) {

				$btnClass = $isAnswered ? 'btn-warning' : 'btn-primary';
				$btnText  = $isAnswered ? 'Update' : 'Answer';

				$questionJs = json_encode($row['question']);
				$answerJs   = json_encode($row['answer']);

				if ($row['course_status'] == 1) {

					$btnClass = $isAnswered ? 'btn-warning' : 'btn-primary';
					$btnText  = $isAnswered ? 'Update' : 'Answer';

					$action = '<button class="btn btn-sm ' . $btnClass . '"
        onclick=\'openAnswerModal(' . $row['id'] . ',' . $questionJs . ',' . $answerJs . ')\'>
        ' . $btnText . '
    </button>';
				} else {
					$action = '<span class="text-muted">Course Inactive</span>';
				}
			} else {
				$action = '<span class="text-muted">Course Inactive</span>';
			}

			$data[] = [
				$sr++,
				$row['question'],
				$row['asked_by'] ?: 'Guest',
				$answeredBy,
				$status,
				$action
			];
		}

		echo json_encode([
			'draw'            => $draw,
			'recordsTotal'    => $total,
			'recordsFiltered' => $filtered,
			'data'            => $data
		]);
		exit;
	}




	public function save_course_answer()
	{
		$qna_id     = $this->input->post('qna_id');
		$answer     = $this->input->post('answer');
		$answer_by  = $this->input->post('answer_by');
		$main_instructor_id = loginId();

		$this->CommonModel->iudAction(
			'tbl_course_qna',
			[
				'main_instructor_id'            => $main_instructor_id,
				'answer'            			=> $answer,
				'ans_created_at'    			=> date('Y-m-d H:i:s'),
				'ans_created_by'    			=> $answer_by,
				'ans_updated_at'    			=> date('Y-m-d H:i:s'),
				'ans_updated_by'    			=> $answer_by,
				'updated_at'        			=> date('Y-m-d H:i:s'),
				'updated_by'        			=> loginId()
			],
			'update',
			['id' => $qna_id]
		);

		echo json_encode(['status' => true]);
	}

	public function course_qna_analytics($course_id)
	{
		// Total
		$total = $this->db->where('course_id', $course_id)
			->count_all_results('tbl_course_qna');

		// Answered
		$answered = $this->db->where('course_id', $course_id)
			->where('answer IS NOT NULL', null, false)
			->count_all_results('tbl_course_qna');

		// Pending
		$pending = $total - $answered;

		// Avg answer time (ONLY answered)
		$avg = $this->db->select('AVG(TIMESTAMPDIFF(HOUR, created_at, ans_created_at)) AS avg_time')
			->where('course_id', $course_id)
			->where('ans_created_at IS NOT NULL', null, false)
			->get('tbl_course_qna')
			->row()
			->avg_time;

		echo json_encode([
			'total'     => $total,
			'answered'  => $answered,
			'pending'   => $pending,
			'avg_hours' => ($avg && $avg > 0) ? round($avg, 1) : 0
		]);
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

		$draw   = $data['draw'];
		$limit  = $data['length'];
		$offset = $data['start'];
		$search = $data['search']['value'];
		$orderCol = $data['order'][0]['column'];
		$orderDir = $data['order'][0]['dir'];

		$course_id = $data['course_id'] ?? 0;

		$total = count(
			$this->CourseModel->getLessonData($search, 0, 0, 0, 0, $course_id)
		);

		$rows = [];

		if ($total > 0) {

			$lessonData = $this->CourseModel->getLessonData(
				$search,
				$orderCol,
				$orderDir,
				$limit,
				$offset,
				$course_id
			);

			foreach ($lessonData as $key => $lesson) {

				$row = [];
				$row[] = $offset + ($key + 1);
				$row[] = $lesson['title'];
				$row[] = $lesson['duration'];
				$row[] = $lesson['section_name'];
				$row[] = $lesson['lesson_type'];

				$action  = '<a class="btn btn-secondary btn-sm" data-toggle="modal" ';
				$action .= 'data-target="#LModal" onclick="courseLessonEdit(' . $lesson['id'] . ')">';
				$action .= '<i class="fas fa-edit"></i></a> ';

				$action .= '<a class="btn btn-danger btn-sm" ';
				$action .= 'href="' . base_url() . 'admin/Course/CourseDelete/' . $lesson['course_id'] . '/' . $lesson['id'] . '" ';
				$action .= 'onclick="return confirm(\'Delete this lesson?\')">';
				$action .= '<i class="fas fa-trash-alt"></i></a>';

				$row[] = $action;

				$rows[] = $row;
			}
		}

		echo json_encode([
			'draw'            => $draw,
			'recordsTotal'    => $total,
			'recordsFiltered' => $total,
			'data'            => $rows
		]);
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
		/* ================= VIEW ================= */
		if (!$this->input->post()) {

			if ($id) {
				$data['title']  = 'Edit Course';
				$data['course'] = $this->CommonModel->getData(
					'tbl_courses',
					['id' => $id, 'deleted_at' => NULL],
					'*',
					'',
					'row_array'
				);

				$data['resources'] = $this->CommonModel->getData(
					'tbl_course_resources',
					['course_id' => $id]
				);

				$data['course_duration'] = $this->db
					->from('tbl_courses_duration')
					->where('courses_id', $id)
					->where('deleted_at', NULL)
					->order_by('id', 'DESC')          // or created_at DESC
					->limit(1)
					->get()
					->row_array();
			} else {
				$data['title'] = 'Add Course';
			}

			$data['active']   = 'Course';
			$data['category'] = $this->CommonModel->getData('tbl_categories', ['status' => 1]);
			$data['skill']    = $this->CommonModel->getData('tbl_skill_master');
			$data['duration'] = $this->CommonModel->getData('tbl_duration_master');
			$data['instructors'] = $this->CourseModel->getInstructors();

			// echo '<pre>';
			// print_r($data);
			// die();
			$this->load->view(ADMIN . COURSE . 'Course', $data);
			return;
		}

		/* ================= SAVE ================= */

		$post = $this->input->post();

		/* ================= COURSE DATA ================= */

		$courseData = [
			'title'         => $post['title'],
			'instructor_id' => $post['instructor_id'],
			'category_id'   => $post['category_id'],
			'course_type'   => $post['course_type'] ?? 0,
			'skill_id'      => $post['skill_id'][0] ?? null,
			'language'      => $post['language'],
			'certificate'   => $post['certificate'],
			'assessment'    => $post['assessment'],
			'benefits'      => $post['benefits'],
			'notes'         => $post['notes'],
			'status'        => $post['status'],
			'is_free'       => $post['is_free'],
		];

		/* ===== IMAGE UPLOAD ===== */
		if (!empty($_FILES['image']['name'])) {
			$upload = fileUpload(COURSE_IMAGES, 'image', false);
			if ($upload['status']) {
				$courseData['image'] = $upload['image_name'];
			}
		}

		/* ===== INSERT / UPDATE COURSE ===== */
		if (empty($post['id'])) {

			$courseData['created_by'] = loginId();
			$courseData['created_at'] = date('Y-m-d H:i:s');

			$courseId = $this->CommonModel->iudAction(
				'tbl_courses',
				$courseData,
				'insert'
			);

			$this->session->set_flashdata('success', 'Course added successfully');
		} else {

			$courseId = $post['id'];

			$courseData['updated_by'] = loginId();
			$courseData['updated_at'] = date('Y-m-d H:i:s');

			$this->CommonModel->iudAction(
				'tbl_courses',
				$courseData,
				'update',
				['id' => $courseId]
			);

			$this->session->set_flashdata('success', 'Course updated successfully');
		}

		/* ================= COURSE RESOURCES ================= */

		$keepIds = [];

		if (!empty($post['resources'])) {

			foreach ($post['resources'] as $index => $resource) {

				$resourceId = $resource['resource_id'] ?? null;

				$data = [
					'course_id'  => $courseId,
					'file_notes' => $resource['file_notes'],
				];

				if (!empty($_FILES['resources']['tmp_name'][$index]['file'])) {

					$_FILES['resource_file'] = [
						'name'     => $_FILES['resources']['name'][$index]['file'],
						'type'     => $_FILES['resources']['type'][$index]['file'],
						'tmp_name' => $_FILES['resources']['tmp_name'][$index]['file'],
						'error'    => $_FILES['resources']['error'][$index]['file'],
						'size'     => $_FILES['resources']['size'][$index]['file'],
					];

					$upload = fileUpload(COURSE_RESOURCES, 'resource_file', false);

					if ($upload['status']) {
						$data['file'] = $upload['image_name'];
					}
				}

				if ($resourceId) {

					$data['updated_at'] = date('Y-m-d H:i:s');
					$data['updated_by'] = loginId();

					$this->CommonModel->iudAction(
						'tbl_course_resources',
						$data,
						'update',
						['id' => $resourceId]
					);

					$keepIds[] = $resourceId;
				} else {

					if (!empty($data['file'])) {
						$data['created_at'] = date('Y-m-d H:i:s');
						$data['created_by'] = loginId();

						$newId = $this->CommonModel->iudAction(
							'tbl_course_resources',
							$data,
							'insert'
						);

						$keepIds[] = $newId;
					}
				}
			}
		}

		$this->db->where('course_id', $courseId);
		if (!empty($keepIds)) {
			$this->db->where_not_in('id', $keepIds);
		}
		$this->db->delete('tbl_course_resources');

		/* ================= COURSE DURATION (CORRECT TABLE) ================= */

		$durationId = 5; // DEFAULT FROM MASTER

		$strike = (float)$post['strike_thr_price'];
		$offer  = (float)$post['offer_amount'];

		if ($post['offer_type'] == 1) {
			$price = max(0, $strike - $offer);
		} else {
			$price = max(0, $strike - (($strike * $offer) / 100));
		}

		$courseDurationData = [
			'courses_id'       => $courseId,
			'duration_id'      => $durationId,
			'offer_type'       => $post['offer_type'],
			'offer_amount'     => $offer,
			'strike_thr_price' => $strike,
			'price'            => $price,
			'status'           => 1
		];

		$existingDuration = $this->CommonModel->getData(
			'tbl_courses_duration',
			['courses_id' => $courseId, 'duration_id' => $durationId, 'deleted_at' => NULL],
			'*',
			'',
			'row_array'
		);

		if ($existingDuration) {

			$courseDurationData['updated_at'] = date('Y-m-d H:i:s');
			$courseDurationData['updated_by'] = loginId();

			$this->CommonModel->iudAction(
				'tbl_courses_duration',
				$courseDurationData,
				'update',
				['id' => $existingDuration['id']]
			);
		} else {

			$courseDurationData['created_at'] = date('Y-m-d H:i:s');
			$courseDurationData['created_by'] = loginId();

			$this->CommonModel->iudAction(
				'tbl_courses_duration',
				$courseDurationData,
				'insert'
			);
		}

		redirect(base_url(ADMIN . 'Course'));
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
			$data['sections'] = $this->CommonModel->getData(
				'tbl_section',
				['course_id' => $id, 'deleted_by' => NULL]
			);

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

			$data['course_list'] = $this->CommonModel->getData('tbl_courses', array('status' => 1, 'category_id !=' => 0, 'deleted_by' => NULL));
			$data['section_list'] = $this->CommonModel->getData('tbl_section', ['deleted_by' => NULL]);

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
		if ($course) {
			$data['course'] = $course[0];
			$this->load->model('admin/CourseModel');
			$data['instructors'] = $this->CourseModel->getInstructors();
			$this->load->view(ADMIN . COURSE . 'course-view', $data);
		}
	}

	public function CourseResource()
	{
		$draw   = intval($this->input->post('draw'));
		$start  = intval($this->input->post('start'));
		$length = intval($this->input->post('length'));

		$rows = $this->CourseModel->getCourseResources();

		$data = [];
		$sr = $start + 1;

		foreach ($rows as $row) {
			$data[] = [
				$sr++,
				$row['file_notes'],
				'<a href="' . base_url(COURSE_RESOURCES . $row['file']) . '" target="_blank">View</a>',
				$row['created_by'],
				date('d M Y', strtotime($row['created_at'])),
				'<button class="btn btn-sm btn-danger">Delete</button>'
			];
		}

		echo json_encode([
			'draw' => $draw,
			'recordsTotal' => count($rows),
			'recordsFiltered' => count($rows),
			'data' => $data
		]);
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

			$duration = $this->CommonModel->getData('tbl_courses_duration', $where, 'price', '', 'row_array');
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
