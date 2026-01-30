<?php 

function init_header($data='')
{
	$CI = & get_instance();

	$CI->load->view(ADMIN.INC.'head', $data);
	$CI->load->view(ADMIN.INC.'top_bar', $data);
	$CI->load->view(ADMIN.INC.'side_bar', $data);
}

function init_footer($data='')
{
	$CI = & get_instance();

	$CI->load->view(ADMIN.INC.'footer', $data);
}
 ?>