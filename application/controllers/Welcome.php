<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index()
	{
		loginId();
		redirect(base_url() . ADMIN . 'dashboard');
	}
	public function terms_condtions()
	{
		$this->load->view('terms_and_conditions');
	}
	public function syncOnlineCourseCertificates()
	{
		// Get all online courses (type = 1)
		$courses = $this->CommonModel->getData(
			'tbl_courses',
			['course_type' => 1],
			'id',
			'',
			'result_array'
		);

		foreach ($courses as $course) {

			// check already exists
			$existing = $this->CommonModel->getData(
				'tbl_course_certificate',
				['course_id' => $course['id']],
				'id',
				'',
				'row_array'
			);

			if (empty($existing)) {

				$insertData = [
					'course_id'        => $course['id'],
					'issued_by'        => 'Red Hat',
					'verify_url'       => 'https://www.credly.com/badges/d898ed2a-8d6a-49de-8600-bce8d3fb41d8',
					'certification_id' => '190-236-588',
					'barcode_logo'     => 'dummy_qr.png'
				];

				// insert using your common function
				$this->CommonModel->iudAction(
					'tbl_course_certificate',
					$insertData,
					'insert'
				);
			}
		}
	}
}