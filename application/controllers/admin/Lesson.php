<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Lesson extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model(ADMIN . 'CourseModel');
		$this->load->model(ADMIN . 'VideoModel');
		$this->load->model('CommonModel');
		$this->load->model(ADMIN . 'LessonsModel');
		loginId();
	}

	public function index()
	{
		$data['title']  = 'Lesson Master';
		$data['active'] = 'Lesson Master';
		$data['course'] = $this->CommonModel->get('tbl_courses', [
			'deleted_at' => NULL
		]);
		$data['section'] = [];

		$data['lessons'] = $this->CommonModel->get('tbl_lesson', [
			'deleted_at' => NULL
		]);
		$this->load->view(ADMIN . LESSON . 'lesson_list', $data);
	}


	public function lesson_List()
	{
		$post = $this->input->post();

		$params = [
			'draw'       => intval($post['draw'] ?? 0),
			'start'      => intval($post['start'] ?? 0),
			'length'     => intval($post['length'] ?? 10),
			'search'     => $post['search']['value'] ?? '',
			'course_id'  => $post['course_id'] ?? '',
			'section_id' => $post['section_id'] ?? ''
		];

		$result = $this->LessonsModel->getLessonList($params);

		$data  = [];
		$sr_no = $params['start'] + 1;

		foreach ($result['data'] as $row) {

			$rowData = [
				$sr_no++,
				$row['sequence'],
				$row['course_name'],
				$row['section_title'],
				$row['lesson_title'],

				[
					'lesson_id'  => $row['id'],
					'course_id'  => $row['course_id'],
					'section_id' => $row['section_id']
				]
			];

			array_push($data, $rowData);
		}

		echo json_encode([
			'draw'            => $params['draw'],
			'recordsTotal'    => $result['total'],
			'recordsFiltered' => $result['total'],
			'data'            => $data
		]);
	}


	public function mcq($lesson_id)
	{
		// echo '<pre>'; print_r($this->session->userdata('user_id'));die();
		$data['lesson'] = $this->LessonsModel->getLessonById($lesson_id);

		if (empty($data['lesson'])) {
			show_404();
		}
		$data['mcqs'] = $this->LessonsModel->getLessonMcqs($lesson_id);
		$data['title'] = 'Lesson MCQs';

		$this->load->view(ADMIN . 'lesson/mcq_list', $data);
	}

	public function saveMcqBulk()
	{
		$user_id = $this->session->userdata('user_id');
		$jsonRows = $this->input->post('rows');

		if ($jsonRows) {

			$rows = json_decode($jsonRows, true);

			if (!empty($rows) && is_array($rows)) {

				$insertData = [];
				$seenQuestions = [];

				foreach ($rows as $row) {

					$lesson_id = (int)($row['lesson_id'] ?? 0);
					$question  = trim($row['question'] ?? '');
					$optionA   = trim($row['option_a'] ?? '');
					$optionB   = trim($row['option_b'] ?? '');
					$optionC   = trim($row['option_c'] ?? '');
					$optionD   = trim($row['option_d'] ?? '');
					$correct   = strtoupper(trim($row['correct_option'] ?? ''));

					if (
						$lesson_id <= 0 ||
						$question === '' ||
						$optionA === '' ||
						$optionB === '' ||
						$optionC === '' ||
						$optionD === '' ||
						!in_array($correct, ['A', 'B', 'C', 'D'])
					) {
						continue;
					}

					$key = strtolower(preg_replace('/\s+/', ' ', $question));

					if (isset($seenQuestions[$key])) {
						continue;
					}

					$seenQuestions[$key] = true;

					$exists = $this->db
						->where('lesson_id', $lesson_id)
						->where('question', $question)
						->count_all_results('tbl_lesson_mcq');

					if ($exists) continue;

					$insertData[] = [
						'lesson_id'      => $lesson_id,
						'question'       => $question,
						'option_a'       => $optionA,
						'option_b'       => $optionB,
						'option_c'       => $optionC,
						'option_d'       => $optionD,
						'correct_option' => $correct,
						'created_at'     => date('Y-m-d H:i:s'),
						'created_by'     => $user_id,
						'updated_at'     => date('Y-m-d H:i:s'),
						'updated_by'     => $user_id
					];
				}

				if ($insertData) {

					$chunks = array_chunk($insertData, 1000);

					foreach ($chunks as $chunk) {
						$this->db->insert_batch('tbl_lesson_mcq', $chunk);
					}
				}

				echo json_encode([
					'status' => true,
					'msg' => 'MCQs uploaded successfully',
					'inserted' => count($insertData)
				]);

				exit;
			}
		}


		$post = $this->input->post();
		$lesson_id = $post['lesson_id'];

		if (!empty($post['question'])) {

			foreach ($post['question'] as $i => $q) {

				if (
					empty($q) ||
					empty($post['option_a'][$i]) ||
					empty($post['option_b'][$i])
				) {
					continue;
				}

				$this->CommonModel->iudAction(
					'tbl_lesson_mcq',
					[
						'lesson_id'      => $lesson_id,
						'question'       => $q,
						'option_a'       => $post['option_a'][$i],
						'option_b'       => $post['option_b'][$i],
						'option_c'       => $post['option_c'][$i] ?? null,
						'option_d'       => $post['option_d'][$i] ?? null,
						'correct_option' => $post['correct_option'][$i],
						'created_at'     => date('Y-m-d H:i:s'),
						'created_by'     => $user_id,
						'updated_at'     => date('Y-m-d H:i:s'),
						'updated_by'     => $user_id
					],
					'insert'
				);
			}

			redirect(ADMIN . 'Lesson/mcq/' . $lesson_id);
		}

		echo json_encode([
			'status' => false,
			'msg' => 'No data found'
		]);
	}
	
	
	public function updateMcq()
	{
		$post = $this->input->post();

		if (empty($post['id'])) {
			redirect(ADMIN . 'Lesson');
		}

		$this->CommonModel->iudAction(
			'tbl_lesson_mcq',
			[
				'question'       => $post['question'],
				'option_a'       => $post['option_a'],
				'option_b'       => $post['option_b'],
				'option_c'       => $post['option_c'],
				'option_d'       => $post['option_d'],
				'correct_option' => $post['correct_option'],
				'updated_at'     => date('Y-m-d H:i:s'),
				'updated_by'     => $this->session->userdata('user_id')
			],
			'update',
			['id' => $post['id']]
		);

		$this->session->set_flashdata('success', 'MCQ updated successfully');
		redirect(ADMIN . 'Lesson/mcq/' . $post['lesson_id']);
	}


	public function deleteMcq()
	{
		$id = $this->input->post('id');

		if (!$id) {
			echo json_encode(['status' => false]);
			return;
		}

		$this->CommonModel->iudAction(
			'tbl_lesson_mcq',
			[
				'deleted_at' => date('Y-m-d H:i:s'),
				'deleted_by' => $this->session->userdata('user_id')
			],
			'update',
			['id' => $id]
		);
		$this->session->set_flashdata('success', 'MCQ deleted successfully');
		echo json_encode(['status' => true]);
	}


	public function downloadMcqXlsxTemplate($lesson_id)
	{
		$lesson = $this->LessonsModel->getLessonById($lesson_id);
		if (empty($lesson)) {
			show_404();
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('MCQ Template');

		$headers = [
			'question',
			'option_a',
			'option_b',
			'option_c',
			'option_d',
			'correct_option'
		];
		$sheet->fromArray($headers, null, 'A1');
		$sheet->getStyle('A1:F1')->getFont()->setBold(true);
		$sheet->getStyle('A1:F1')->getAlignment()
			->setHorizontal(Alignment::HORIZONTAL_CENTER)
			->setVertical(Alignment::VERTICAL_CENTER);

		$sheet->getStyle('A1:F1')->getFill()
			->setFillType(Fill::FILL_SOLID)
			->getStartColor()->setARGB('FFEFEFEF');

		$sheet->getRowDimension(1)->setRowHeight(30);

		$sheet->getColumnDimension('A')->setWidth(60);
		$sheet->getColumnDimension('B')->setWidth(30);
		$sheet->getColumnDimension('C')->setWidth(30);
		$sheet->getColumnDimension('D')->setWidth(30);
		$sheet->getColumnDimension('E')->setWidth(30);
		$sheet->getColumnDimension('F')->setWidth(20);

		$sheet->getStyle('A:A')->getAlignment()->setWrapText(true);
		$sheet->getStyle('B:E')->getAlignment()->setWrapText(true);

		// $sheet->fromArray([
		// 	[
		// 		'What does EC2 stand for?',
		// 		'Elastic Compute Cloud',
		// 		'Elastic Container Cloud',
		// 		'Elastic Cache Cloud',
		// 		'Enterprise Compute Cloud',
		// 		'A'
		// 	],
		// 	[
		// 		'Which AWS service is used for object storage?',
		// 		'EBS',
		// 		'EC2',
		// 		'S3',
		// 		'EFS',
		// 		'C'
		// 	]
		// ], null, 'A2');

		// $sheet->getRowDimension(2)->setRowHeight(45);
		// $sheet->getRowDimension(3)->setRowHeight(45);

		for ($row = 2; $row <= 500; $row++) {
			$validation = $sheet->getCell("F{$row}")->getDataValidation();
			$validation->setType(DataValidation::TYPE_LIST);
			$validation->setErrorStyle(DataValidation::STYLE_STOP);
			$validation->setAllowBlank(false);
			$validation->setShowDropDown(true);
			$validation->setFormula1('"A,B,C,D"');
			$validation->setErrorTitle('Invalid value');
			$validation->setError('Select A, B, C or D only');
			$validation->setPromptTitle('Correct Answer');
			$validation->setPrompt('Choose A / B / C / D');
		}

		$sheet->freezePane('A2');

		$sheet->getStyle('A1:F50')->getBorders()->getAllBorders()
			->setBorderStyle(Border::BORDER_THIN);

		$filename = 'lesson_' . $lesson_id . '_mcq_template.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

	public function previewMcqXlsx()
	{
		$lesson_id = (int)$this->input->post('lesson_id');

		if (empty($lesson_id)) {
			echo json_encode([
				'status' => false,
				'msg'    => 'Lesson ID missing'
			]);
			exit;
		}

		if (!isset($_FILES['mcq_file']) || $_FILES['mcq_file']['error'] !== UPLOAD_ERR_OK) {
			echo json_encode([
				'status' => false,
				'msg'    => 'File upload error'
			]);
			exit;
		}

		try {
			$fileTmp = $_FILES['mcq_file']['tmp_name'];
			$spreadsheet = IOFactory::load($fileTmp);
			$sheet = $spreadsheet->getActiveSheet();
			$highestRow = $sheet->getHighestDataRow();

			$preview = [];
			$fileDuplicates = [];
			$totalRows = 0;
			$validRows = 0;
			$invalidRows = 0;

			for ($rowIndex = 2; $rowIndex <= $highestRow; $rowIndex++) {
				$question = trim((string)$sheet->getCell("A{$rowIndex}")->getValue());
				$optionA  = trim((string)$sheet->getCell("B{$rowIndex}")->getValue());
				$optionB  = trim((string)$sheet->getCell("C{$rowIndex}")->getValue());
				$optionC  = trim((string)$sheet->getCell("D{$rowIndex}")->getValue());
				$optionD  = trim((string)$sheet->getCell("E{$rowIndex}")->getValue());
				$correct  = strtoupper(trim((string)$sheet->getCell("F{$rowIndex}")->getValue()));

				if (
					$question === '' &&
					$optionA === '' &&
					$optionB === '' &&
					$optionC === '' &&
					$optionD === '' &&
					$correct === ''
				) {
					continue;
				}

				$totalRows++;
				$rowErrors = [];

				if ($question === '') {
					$rowErrors[] = 'Question required';
				}

				if ($optionA === '' || $optionB === '' || $optionC === '' || $optionD === '') {
					$rowErrors[] = 'All 4 options required';
				}

				if (!in_array($correct, ['A', 'B', 'C', 'D'])) {
					$rowErrors[] = 'Correct option must be A,B,C or D';
				}

				$questionKey = strtolower(preg_replace('/\s+/', ' ', $question));
				if ($questionKey !== '') {
					if (isset($fileDuplicates[$questionKey])) {
						$rowErrors[] = 'Duplicate question in uploaded file';
					} else {
						$fileDuplicates[$questionKey] = true;
					}
				}

				// Duplicate in database for same lesson
				if ($question !== '') {
					$exists = $this->db
						->where('lesson_id', $lesson_id)
						->where('question', $question)
						->count_all_results('tbl_lesson_mcq');

					if ($exists > 0) {
						$rowErrors[] = 'Question already exists in this lesson';
					}
				}

				if (!empty($rowErrors)) {
					$invalidRows++;
				} else {
					$validRows++;
				}

				$preview[] = [
					'row'            => $rowIndex,
					'lesson_id'      => $lesson_id,
					'question'       => $question,
					'option_a'       => $optionA,
					'option_b'       => $optionB,
					'option_c'       => $optionC,
					'option_d'       => $optionD,
					'correct_option' => $correct,
					'errors'         => $rowErrors
				];
			}

			echo json_encode([
				'status'  => true,
				'data'    => $preview,
				'summary' => [
					'total'   => $totalRows,
					'valid'   => $validRows,
					'invalid' => $invalidRows
				]
			]);
			exit;
		} catch (Exception $e) {
			echo json_encode([
				'status' => false,
				'msg'    => $e->getMessage()
			]);
			exit;
		}
	}

	public function downloadErrorExcel()
	{
		$rows = json_decode($this->input->post('rows'), true);

		if (empty($rows) || !is_array($rows)) {
			echo 'No error rows found';
			exit;
		}

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('MCQ Errors');

		$headers = [
			'row_no',
			'question',
			'option_a',
			'option_b',
			'option_c',
			'option_d',
			'correct_option',
			'errors'
		];

		$sheet->fromArray($headers, null, 'A1');
		$sheet->getStyle('A1:H1')->getFont()->setBold(true);

		$excelRows = [];
		foreach ($rows as $row) {
			$excelRows[] = [
				$row['row'] ?? '',
				$row['question'] ?? '',
				$row['option_a'] ?? '',
				$row['option_b'] ?? '',
				$row['option_c'] ?? '',
				$row['option_d'] ?? '',
				$row['correct_option'] ?? '',
				implode(', ', $row['errors'] ?? [])
			];
		}

		$sheet->fromArray($excelRows, null, 'A2');
		$sheet->getStyle('A:H')->getAlignment()->setWrapText(true);

		foreach (range('A', 'H') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		$filename = 'mcq_error_rows_' . date('Ymd_His') . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer = new Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}


	public function uploadMcqXlsx($lesson_id)
	{
		$lesson = $this->LessonsModel->getLessonById($lesson_id);
		if (empty($lesson)) {
			show_404();
		}
		if (!isset($_FILES['mcq_file']) || $_FILES['mcq_file']['error'] !== UPLOAD_ERR_OK) {
			redirect(ADMIN . 'Lesson/mcq/' . $lesson_id);
		}

		$fileTmp = $_FILES['mcq_file']['tmp_name'];

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileTmp);
		$sheet = $spreadsheet->getActiveSheet();
		$rows = $sheet->toArray(null, true, true, true);

		foreach ($rows as $index => $row) {

			if ($index === 1) continue;

			$question = trim($row['A'] ?? '');
			$optionA  = trim($row['B'] ?? '');
			$optionB  = trim($row['C'] ?? '');
			$optionC  = trim($row['D'] ?? '');
			$optionD  = trim($row['E'] ?? '');
			$correct  = strtoupper(trim($row['F'] ?? ''));
			
			if ($question == '') {
				$errors[] = "Row $index : Question is required.";
				continue;
			}

			if ($optionA == '' || $optionB == '' || $optionC == '' || $optionD == '') {
				$errors[] = "Row $index : All 4 options (A,B,C,D) are required.";
				continue;
			}

			if (!in_array($correct, ['A', 'B', 'C', 'D'])) {
				$errors[] = "Row $index : Correct answer must be A,B,C or D.";
				continue;
			}
			if (
				$question === '' ||
				$optionA === '' ||
				$optionB === '' ||
				!in_array($correct, ['A', 'B', 'C', 'D'])
			) {
				continue;
			}

			$this->CommonModel->iudAction('tbl_lesson_mcq', [
				'lesson_id'      => $lesson_id,
				'question'       => $question,
				'option_a'       => $optionA,
				'option_b'       => $optionB,
				'option_c'       => $optionC,
				'option_d'       => $optionD,
				'correct_option' => $correct,
				'created_at'     => date('Y-m-d H:i:s'),
				'created_by'     => $this->session->userdata('user_id'),
				'updated_at'     => date('Y-m-d H:i:s'),
				'updated_by'     => $this->session->userdata('user_id')
			], 'insert');
		}
		redirect(ADMIN . 'Lesson/mcq/' . $lesson_id);
	}

	public function getSectionsByCourse()
	{
		$course_id = $this->input->post('course_id');

		if (empty($course_id)) {
			echo json_encode(['status' => false, 'data' => []]);
			return;
		}
		$sections = $this->CommonModel->getData(
			'tbl_section',
			['course_id'  => $course_id,	'deleted_at' => null],
			'id, title',
			'',
			'',
			'id',
			'ASC'
		);
		echo json_encode([
			'status' => true,
			'data'   => $sections
		]);
	}


	public function getLessonsBySection()
	{
		$section_id = $this->input->post('section_id');

		if (empty($section_id)) {
			echo json_encode(['status' => false, 'data' => []]);
			return;
		}

		$lessons = $this->CommonModel->getData(
			'tbl_lesson',
			[
				'section_id' => $section_id,
				'deleted_at' => null
			],
			'id, title',
			'',
			'',
			'id',
			'ASC'
		);

		echo json_encode([
			'status' => true,
			'data'   => $lessons
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

	public function check_lesson_title()
	{
		$title      = trim($this->input->post('title'));
		$course_id  = $this->input->post('course_id');
		$section_id = $this->input->post('section_id');
		$id         = $this->input->post('id');

		$this->db->where('title', $title);
		$this->db->where('course_id', $course_id);
		$this->db->where('section_id', $section_id);

		if ($id) {
			$this->db->where('id !=', $id);
		}

		$query = $this->db->get('tbl_lesson');

		if ($query->num_rows() > 0) {
			echo "exists";
		} else {
			echo "available";
		}
	}

	public function check_final_lesson()
	{
		$course_id = $this->input->post('course_id');
		$lesson_id = $this->input->post('lesson_id');

		$this->db->where('course_id', $course_id);
		$this->db->where('is_final_lesson', '1');
		$this->db->where('deleted_by IS NULL', null, false);

		if (!empty($lesson_id)) {
			$this->db->where('id !=', $lesson_id);
		}

		$exists = $this->db->get('tbl_lesson')->num_rows();

		echo ($exists > 0) ? "exists" : "available";
	}

	public function storelesson()
	{
		$id         = $this->input->post('id');
		$course_id  = $this->input->post('course_id');
		$section_id = $this->input->post('section_id');
		$title      = $this->input->post('tags');
		$desc       = $this->input->post('description');
		$sequence   = $this->input->post('sequence');
		$no_of_question   = $this->input->post('no_of_question');
		$exam_duration   = $this->input->post('exam_duration');
		$is_final_lesson   = $this->input->post('is_final_lesson');
		// echo"<pre>";print_r($exam_duration);
		// echo"<pre>";print_r($no_of_question);die;
		$tags = $this->input->post('tags_input');
		$tags_string = (!empty($tags)) ? implode(" ", $tags) : "";
		$videos = $this->input->post('videos');

		$validVideo = false;

		foreach ($videos as $v) {
			if (!empty($v['video_title']) && !empty($v['vimo_code'])) {
				$validVideo = true;
			}
		}

		if (!$validVideo) {
			die('At least one video is required');
		}
		$lessonData = [
			"course_id"   => $course_id,
			"section_id"  => $section_id,
			"title"       => $title,
			"sub_title"   => $tags_string,
			"description" => $desc,
			"exam_duration" => $exam_duration,
			"no_of_question" => $no_of_question,
			"sequence"    => $sequence,
			"is_final_lesson"    => $is_final_lesson,
			"updated_at"  => date("Y-m-d H:i:s"),
			"updated_by"  => 1
		];

		$this->db->trans_start();

		if (!empty($id)) {

			$lesson_id = $id;
			$this->CommonModel->iudAction(
				'tbl_lesson',
				$lessonData,
				'update',
				['id' => $lesson_id]
			);

			$this->CommonModel->iudAction(
				'tbl_lesson_sub_title',
				[],
				'delete',
				['lesson_id' => $lesson_id]
			);
		} else {

			$lessonData["created_at"] = date("Y-m-d H:i:s");
			$lessonData["created_by"] = 1;

			$lesson_id = $this->CommonModel->iudAction(
				'tbl_lesson',
				$lessonData,
				'insert'
			);
		}

		if (!empty($tags)) {
			foreach ($tags as $tag) {
				$this->CommonModel->iudAction(
					'tbl_lesson_sub_title',
					[
						"course_id"      => $course_id,
						"section_id"     => $section_id,
						"lesson_id"      => $lesson_id,
						"sub_title_name" => trim($tag),
						"created_at"     => date("Y-m-d H:i:s"),
						"created_by"     => 1
					],
					'insert'
				);
			}
		}

		$videos = $this->input->post("videos");
		$files  = $_FILES['videos'] ?? [];

		$posted_ids = [];

		if (!empty($videos)) {

			foreach ($videos as $i => $v) {

				$video_title = trim($v['video_title'] ?? '');
				$vimo_code   = trim($v['vimo_code'] ?? '');
				$video_type  = $v['video_type'] ?? '';

				if ($video_title === '' && $vimo_code === '') {
					continue;
				}

				if ($video_title === '' || $vimo_code === '') {
					continue;
				}

				$video_id   = $v['id'] ?? '';
				$thumb_name = $v['old_thumbnail'] ?? '';

				if (
					isset($files['name'][$i]['video_thumbnail']) &&
					$files['name'][$i]['video_thumbnail'] != ''
				) {

					$tmp  = $files['tmp_name'][$i]['video_thumbnail'];
					$ext  = pathinfo($files['name'][$i]['video_thumbnail'], PATHINFO_EXTENSION);
					$name = time() . '_' . rand(1000, 9999) . '.' . $ext;

					move_uploaded_file(
						$tmp,
						FCPATH . "assets/uploads/thumbnails/video_thumbnails/" . $name
					);

					$thumb_name = $name;
				}

				$videoData = [
					"courses_id"      => $course_id,
					"section_id"      => $section_id,
					"lesson_id"       => $lesson_id,
					"video_title"     => $video_title,
					"vimo_code"       => $vimo_code,
					"video_type"      => $video_type,
					"video_thumbnail" => $thumb_name,
					"updated_at"      => date("Y-m-d H:i:s"),
					"updated_by"      => 1
				];

				if ($video_id) {

					$posted_ids[] = $video_id;

					$this->CommonModel->iudAction(
						'tbl_lesson_video',
						$videoData,
						'update',
						['id' => $video_id]
					);
				} else {

					$videoData["created_at"] = date("Y-m-d H:i:s");
					$videoData["created_by"] = 1;

					$newId = $this->CommonModel->iudAction(
						'tbl_lesson_video',
						$videoData,
						'insert'
					);

					$posted_ids[] = $newId;
				}
			}
		}

		if (!empty($id)) {

			if (!empty($posted_ids)) {

				$this->db->where('lesson_id', $lesson_id);
				$this->db->where_not_in('id', $posted_ids);
				$this->db->delete('tbl_lesson_video');
			} else {

				$this->CommonModel->iudAction(
					'tbl_lesson_video',
					[],
					'delete',
					['lesson_id' => $lesson_id]
				);
			}
		}


		$this->db->trans_complete();

		$this->session->set_flashdata("success", "Lesson saved successfully!  ");
		redirect(ADMIN . "Lesson");
	}

	


	public function edit($id)
	{
		$data['title'] = 'Edit Lesson';
		$data['active'] = 'Edit Lesson';

		$data['lesson'] = $this->CommonModel
			->getData('tbl_lesson', ['id' => $id, 'deleted_by' => NULL]);

		$data['lesson_tags'] = $this->CommonModel
			->getData('tbl_lesson_sub_title', ['lesson_id' => $id], 'sub_title_name');

		$data['lesson_videos'] = $this->CommonModel
			->getData('tbl_lesson_video', ['lesson_id' => $id, 'deleted_by' => NULL]);

		$data['course'] = $this->CommonModel
			->getData('tbl_courses', ['status' => 1, 'deleted_by' => NULL]);

		$data['section'] = $this->CommonModel->getData(
			'tbl_section',
			[
				'course_id' => $data['lesson'][0]['course_id'],
				'deleted_by' => NULL
			]
		);


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

		$result = $this->CommonModel->iudAction(
			'tbl_lesson',
			$data,
			'update',
			['id' => $id]
		);

		if ($result) {
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


	public function save_videos()
	{
		$course_id  = $this->input->post('course_id');
		$section_id = $this->input->post('section_id');
		$lesson_id  = $this->input->post('lesson_id');
		// echo '<pre>';
		// print_r($this->input->post());
		// die();
		$videos = $this->input->post('videos');
		$files  = $_FILES['videos'] ?? [];

		if (empty($videos)) {
			echo json_encode(['status' => 0]);
			return;
		}

		$posted_ids = [];

		foreach ($videos as $i => $v) {
			$video_id   = $v['id'] ?? '';
			$thumb_name = $v['old_thumbnail'] ?? '';

			if (!empty($files['name'][$i]['video_thumbnail'])) {
				$tmp  = $files['tmp_name'][$i]['video_thumbnail'];
				$name = time() . '_' . rand(1000, 9999) . '.jpg';

				move_uploaded_file(
					$tmp,
					FCPATH . "assets/uploads/thumbnails/video_thumbnails/" . $name
				);

				$thumb_name = $name;
			}

			$videoData = [
				"courses_id"      => $course_id,
				"section_id"      => $section_id,
				"lesson_id"       => $lesson_id,
				"video_title"     => $v['video_title'],
				"vimo_code"       => $v['vimo_code'],
				"video_type"      => strtoupper($v['video_type']),
				"video_thumbnail" => $thumb_name,
				"updated_at"      => date("Y-m-d H:i:s"),
				"updated_by"      => $this->session->userdata('id')
			];

			if (!empty($video_id)) {
				$posted_ids[] = $video_id;

				$this->CommonModel->iudAction(
					'tbl_lesson_video',
					$videoData,
					'update',
					['id' => $video_id]
				);
			} else {
				$videoData["created_at"] = date("Y-m-d H:i:s");
				$videoData["created_by"] = $this->session->userdata('id');

				$insert_id = $this->CommonModel->iudAction(
					'tbl_lesson_video',
					$videoData,
					'insert'
				);

				if ($insert_id)
					$posted_ids[] = $insert_id;
			}
		}

		if (!empty($posted_ids)) {
			$existing = $this->CommonModel->getData(
				'tbl_lesson_video',
				['lesson_id' => $lesson_id],
				'id'
			);

			foreach ($existing as $row) {
				if (!in_array($row['id'], $posted_ids)) {
					$this->CommonModel->iudAction(
						'tbl_lesson_video',
						['deleted_at' => date('Y-m-d H:i:s'), 'deleted_by' => loginId()],
						'update',
						['id' => $row['id']]
					);
				}
			}
		}

		echo json_encode(['status' => 1]);
	}


	public function get_lesson_videos()
	{
		$lesson_id = $this->input->post('lesson_id');

		$videos = $this->CommonModel->getData(
			'tbl_lesson_video',
			['lesson_id' => $lesson_id, 'deleted_at' => NULL]
		);

		echo json_encode($videos);
	}
}
