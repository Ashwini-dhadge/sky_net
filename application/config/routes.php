<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['admin'] = ADMIN . "Auth";
$route['auth0-login'] = ADMIN . "Auth/Auth0";

$route['logout'] = ADMIN . "Auth/logout";

$route['admin/profile/(:any)'] = ADMIN . 'Authentication/profile/$1';
$route['admin/serviceList/(:any)'] = ADMIN . 'Service/serviceList/$1';
$route['dashboard'] = ADMIN . "Dashboard";
$route['admin/Category']             = ADMIN . 'Category';


/**************** API Routes ******************/
//Authentication
$route['register_user'] = 'app/Authentication/registerUser'; #done
$route['otp_verification'] = 'app/Authentication/userOTPVerification'; #done
$route['resend_otp'] = 'app/Authentication/sendLoginOTP'; #done
$route['login_user'] = 'app/Authentication/userLogin'; #done
$route['update_profile'] = 'app/Authentication/updateProfile'; #done
$route['update_profile_pic'] = 'app/Authentication/updateProfilePic';
$route['forgot_password'] = 'app/Authentication/forgotPassword'; #done
$route['app_changed_password'] = 'app/Authentication/changedPassword';

//dashboard

$route['app_dashboard'] = 'app/Authentication/getDashboard';
// Course
$route['category_list'] = 'app/Courses/getCategoriesList'; #done
$route['app_courses_list'] = 'app/Courses/getCourses';
$route['app_courses_details'] = 'app/Courses/getCoursesDetails';
$route['lesson_details'] = 'app/Courses/getLessonsDetails';
$route['question_answer_list'] = 'app/Courses/getQuestionAnswerList';
$route['create_qna'] = 'app/Courses/createQnA';
$route['testing'] = 'app/Test/testapi';

// Discussion Forum
$route['create_forum_post'] = 'app/Forum/createForumPost';
$route['forum_post_update'] = 'app/Forum/forumPostUpdate';
$route['forum_post_delete'] = 'app/Forum/forumPostDelete';
$route['forum_post_list'] = 'app/Forum/forumPostList';
$route['forum_post_comment'] = 'app/Forum/createForumAnswer';
$route['forum_post_detail'] = 'app/Forum/forumPostDetail';
$route['forum_post_reply'] = 'app/Forum/replyToComment';
$route['forum_post_comment_update'] = 'app/Forum/postCommentUpdate';
$route['post_comment_delete'] = 'app/Forum/postCommentDelete';
$route['my_forum_list'] = 'app/Forum/myForumList';