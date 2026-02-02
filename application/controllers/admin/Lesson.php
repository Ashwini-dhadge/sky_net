<?php

/**
 * 
 */
class Lesson extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(ADMIN . 'CourseModel');
		$this->load->model(ADMIN . 'VideoModel');
		$this->load->model('CommonModel');
		// application\models\CommonModel.php
		loginId();
	}

	/*********************************************************************/
	//  QMR

	public function index()
	{
		$data['title']  = 'Lesson Master';
		$data['active'] = 'Lesson Master';

		$data['course'] = $this->CommonModel->get('tbl_courses', [
			'deleted_at' => NULL
		]);

		$data['section'] = $this->CommonModel->get('tbl_section', [
			'deleted_at' => NULL
		]);

		$this->load->view(ADMIN . LESSON . 'lesson_list', $data);
	}


	public function lesson_List()
	{
		$post = $this->input->post();

		$draw   = intval($post['draw'] ?? 0);
		$start  = intval($post['start'] ?? 0);
		$length = intval($post['length'] ?? 25);

		$search_value = $post['search']['value'] ?? '';
		$course_id    = $post['course_id'] ?? '';
		$section_id   = $post['section_id'] ?? '';

		/* ================= BASE QUERY ================= */

		$this->db->select("
        tbl_lesson.id,
        tbl_lesson.title AS lesson_title,
        tbl_lesson.sequence,
        tbl_lesson.description,
        tbl_courses.title AS course_name,
        tbl_section.title AS section_title
    ");

		$this->db->from('tbl_lesson');
		$this->db->join('tbl_courses', 'tbl_courses.id = tbl_lesson.course_id', 'LEFT');
		$this->db->join('tbl_section', 'tbl_section.id = tbl_lesson.section_id', 'LEFT');

		// Only non-deleted lessons
		$this->db->where('tbl_lesson.deleted_at IS NULL');

		/* ================= FILTERS ================= */

		if (!empty($course_id)) {
			$this->db->where('tbl_lesson.course_id', $course_id);
		}

		if (!empty($section_id)) {
			$this->db->where('tbl_lesson.section_id', $section_id);
		}

		/* ================= SEARCH ================= */

		if (!empty($search_value)) {
			$this->db->group_start();
			$this->db->like('tbl_lesson.title', $search_value);
			$this->db->or_like('tbl_courses.title', $search_value);
			$this->db->or_like('tbl_section.title', $search_value);
			$this->db->group_end();
		}

		/* ================= ORDER ================= */

		$this->db->order_by('tbl_lesson.sequence', 'ASC');

		/* ================= COUNT ================= */

		$total_records = $this->db->count_all_results('', FALSE);

		/* ================= PAGINATION ================= */

		$this->db->limit($length, $start);
		$query = $this->db->get()->result_array();

		/* ================= FORMAT DATA ================= */

		$data  = [];
		$sr_no = $start + 1;

		foreach ($query as $row) {

			$description = strip_tags((string) ($row['description'] ?? ''));

			if (strlen($description) > 80) {
				$description = substr($description, 0, 80) . '...';
			}

			$action = '
            <a href="javascript:void(0);" title="MCQ list"
               class="btn btn-sm btn-success mr-1">
                <i class="fa fa-list"></i>
            </a>

            <a href="' . base_url(ADMIN . 'Lesson/edit/' . $row['id']) . '"  
               class="btn btn-sm btn-primary mr-1" title="Edit">
                <i class="fa fa-edit"></i>
            </a>

            <a href="javascript:void(0);" 
               class="btn btn-sm btn-danger" title="Delete"
               onclick="deleteLesson(' . $row['id'] . ')">
                <i class="fa fa-trash"></i>
            </a>
        ';

			$data[] = [
				$sr_no++,
				$row['sequence'],
				$row['lesson_title'],
				$row['course_name'],
				$row['section_title'],
				$description,
				$action
			];
		}

		/* ================= JSON RESPONSE ================= */

		echo json_encode([
			'draw'            => $draw,
			'recordsTotal'    => $total_records,
			'recordsFiltered' => $total_records,
			'data'            => $data
		]);
	}

	public function getSectionsByCourse()
	{
		$course_id = $this->input->post('course_id');

		if (empty($course_id)) {
			echo json_encode([
				'status' => false,
				'data'   => []
			]);
			return;
		}

		$this->db->select('id, title');
		$this->db->from('tbl_section');
		$this->db->where('course_id', $course_id);
		$this->db->where('deleted_at IS NULL');
		$this->db->order_by('id', 'ASC');

		$sections = $this->db->get()->result_array();

		echo json_encode([
			'status' => true,
			'data'   => $sections
		]);
	}






	public function addlesson()
	{
		$data['title'] = 'Lesson Add';
		$data['active'] = 'Lesson Add';
		$data['course'] = $this->CommonModel->getData('tbl_courses', array('status' => 1, 'category_id !=' => 0, 'deleted_by' => NULL));
		$data['section'] = $this->CommonModel->getData('tbl_section', ['deleted_by' => NULL]);

		$data['selected_course_id'] = $this->input->get('course_id');
		// echo"<pre>";print_r($data['section']);die;
		$this->load->view(ADMIN . LESSON . 'add_lesson', $data);
	}


	public function storelesson()
	{
		// echo "<pre>";
		// print_r($this->input->post());
		// die;
		$id = $this->input->post('id');
		$course_id = $this->input->post('course_id');
		$section_id = $this->input->post('section_id');
		$title = $this->input->post('tags');
		$desc = $this->input->post('description');
		$sequence = $this->input->post('sequence');

		/**
		 * =============================
		 *  TAG HANDLING
		 * =============================
		 */

		$tags = $this->input->post('tags_input');   // array
		$tags_string = (!empty($tags)) ? implode(" ", $tags) : "";

		/**
		 * =============================
		 *  LESSON DATA
		 * =============================
		 */
		$lessonData = [
			"course_id" => $course_id,
			"section_id" => $section_id,
			"title" => $title,
			"sub_title" => $tags_string,
			"description" => $desc,
			"sequence" => $sequence,
			"updated_at" => date("Y-m-d H:i:s"),
			"updated_by" => 1
		];

		/**
		 * =============================
		 *  INSERT OR UPDATE LESSON
		 * =============================
		 */
		if (!empty($id)) {

			// UPDATE
			$lesson_id = $id;
			$this->db->where("id", $lesson_id)->update("tbl_lesson", $lessonData);

			// DELETE ALL TAGS
			$this->db->where("lesson_id", $lesson_id)->delete("tbl_lesson_sub_title");

			/**
			 * DO NOT DELETE VIDEOS HERE
			 * We will handle update/add per row
			 */
		} else {
			// INSERT
			$lessonData["created_at"] = date("Y-m-d H:i:s");
			$lessonData["created_by"] = 1;

			$this->db->insert("tbl_lesson", $lessonData);
			$lesson_id = $this->db->insert_id();
		}


		/**
		 * =============================
		 *  SAVE TAGS
		 * =============================
		 */
		if (!empty($tags)) {
			foreach ($tags as $tag) {
				$this->db->insert("tbl_lesson_sub_title", [
					"course_id" => $course_id,
					"section_id" => $section_id,
					"lesson_id" => $lesson_id,
					"sub_title_name" => trim($tag),
					"created_at" => date("Y-m-d H:i:s"),
					"created_by" => 1
				]);
			}
		}


		/**
		 * =============================
		 *  VIDEO SECTION: UPDATE + INSERT
		 * =============================
		 */
		$videos = $this->input->post("videos");

		if (!empty($videos)) {

			$files = $_FILES['videos'];

			foreach ($videos as $i => $v) {

				/**
				 * Check if it is existing video or new video
				 */
				$video_id = isset($v['id']) ? $v['id'] : "";

				/**
				 * Handle thumbnail
				 */
				$thumb_name = $v['old_thumbnail'] ?? "";

				if (!empty($files['name'][$i]['video_thumbnail'])) {

					// Upload new file
					$tmp = $files['tmp_name'][$i]['video_thumbnail'];
					$name = time() . "_" . rand(1000, 9999) . ".jpg";

					move_uploaded_file($tmp, FCPATH . "assets/uploads/thumbnails/video_thumbnails/" . $name);
					$thumb_name = $name;
				}

				/**
				 * Prepare data
				 */
				$videoData = [
					"courses_id" => $course_id,
					"section_id" => $section_id,
					"lesson_id" => $lesson_id,
					"video_title" => $v['video_title'],
					"vimo_code" => $v['vimo_code'],
					"video_type" => $v['video_type'],
					"video_thumbnail" => $thumb_name,
					"updated_at" => date("Y-m-d H:i:s"),
					"updated_by" => 1
				];


				/**
				 * UPDATE EXISTING VIDEO
				 */
				if (!empty($video_id)) {

					$this->db->where("id", $video_id)
						->update("tbl_lesson_video", $videoData);
				} else {

					/**
					 * INSERT NEW VIDEO
					 */
					$videoData["created_at"] = date("Y-m-d H:i:s");
					$videoData["created_by"] = 1;

					$this->db->insert("tbl_lesson_video", $videoData);
				}
			}
		}


		/**
		 * =============================
		 *  DELETE REMOVED VIDEOS
		 * =============================
		 */
		if (!empty($id)) {

			$posted_ids = [];

			if (!empty($videos)) {
				foreach ($videos as $v) {
					if (!empty($v['id'])) {
						$posted_ids[] = $v['id'];
					}
				}
			}

			// Remove videos not included in form anymore
			if (!empty($posted_ids)) {
				$this->db->where("lesson_id", $id);
				$this->db->where_not_in("id", $posted_ids);
				$this->db->delete("tbl_lesson_video");
			}
		}


		/**
		 * =============================
		 * SUCCESS RESPONSE
		 * =============================
		 */
		$this->session->set_flashdata("success", "Lesson saved successfully!");
		redirect(ADMIN . "Lesson");
	}


	public function edit($id)
	{
		$data['title'] = 'Edit Lesson';
		$data['active'] = 'Edit Lesson';

		// MASTER LESSON
		$data['lesson'] = $this->CommonModel
			->getData('tbl_lesson', ['id' => $id, 'deleted_by' => NULL]);

		// TAGS (fixed)
		$data['lesson_tags'] = $this->CommonModel
			->getData('tbl_lesson_sub_title', ['lesson_id' => $id], 'sub_title_name');

		// VIDEOS
		$data['lesson_videos'] = $this->CommonModel
			->getData('tbl_lesson_video', ['lesson_id' => $id]);

		// DROPDOWN
		$data['course'] = $this->CommonModel
			->getData('tbl_courses', ['status' => 1, 'deleted_by' => NULL]);

		$data['section'] = $this->CommonModel
			->getData('tbl_section', ['deleted_by' => NULL]);

		$this->load->view(ADMIN . LESSON . 'add_lesson', $data);
	}

	public function deleteLesson()
	{
		$id = $this->input->post('id');

		if (!$id) {
			echo json_encode([
				'status'  => false,
				'message' => 'Invalid lesson ID'
			]);
			return;
		}

		$data = [
			'deleted_at' => date('Y-m-d H:i:s'),
			'deleted_by' => loginId()
		];

		$this->db->where('id', $id);
		$this->db->update('tbl_lesson', $data);

		if ($this->db->affected_rows() > 0) {
			echo json_encode([
				'status'  => true,
				'message' => 'Lesson deleted successfully'
			]);
		} else {
			echo json_encode([
				'status'  => false,
				'message' => 'Lesson not found or already deleted'
			]);
		}
	}
}