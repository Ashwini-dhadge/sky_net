<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * API Documentation Configuration
 * Add your API endpoints here with their parameters and responses
 */

return [
    // Authentication APIs
    'register_user' => [
        'summary' => 'Register New User',
        'tags' => 'Authentication',
        'method' => 'POST',
        'parameters' => [
            'full_name' => ['type' => 'string', 'required' => true, 'example' => 'John'],
            'mobile' => ['type' => 'number', 'required' => true, 'example' => '1234567890'],
            'email' => ['type' => 'string', 'required' => true, 'example' => 'abc@gmail.com'],
            'password' => ['type' => 'string', 'required' => true, 'example' => 'password123'],
            'confirm_password' => ['type' => 'string', 'required' => true, 'example' => 'password123'],
            'notification_token' => ['type' => 'string', 'required' => false, 'example' => '123'],
            'device_details' => ['type' => 'string', 'required' => false, 'example' => '123'],
            'imei_no' => ['type' => 'string', 'required' => true, 'example' => '123'],
        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' =>  'Thank you for registering, Please verify your number'],
            // 'reason' => ['type' => 'string', 'example' => 'User registered successfully'],
            // 'user_id' => ['type' => 'integer', 'example' => 123],
            // 'api_token' => ['type' => 'string', 'example' => 'abc123xyz']
        ]
    ],

    'login_user' => [
        'summary' => 'User Login',
        'tags' => 'Authentication',
        'method' => 'POST',
        'parameters' => [
            'email' => ['type' => 'string', 'required' => true, 'example' => 'john@example.com'],
            'password' => ['type' => 'string', 'required' => true, 'example' => 'password123'],
            'notification_token' => ['type' => 'string', 'required' => false, 'example' => '123'],
            'device_details' => ['type' => 'string', 'required' => false, 'example' => '123'],
            'imei_no' => ['type' => 'string', 'required' => true, 'example' => '123'],
        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'Login Success'],
            'user_data' => ['type' => 'object'],

        ]
    ],

    'otp_verification' => [
        'summary' => 'Verify OTP',
        'tags' => 'Authentication',
        'method' => 'POST',
        'parameters' => [
            'mobile' => ['type' => 'number', 'required' => true, 'example' => '123'],
            'otp_number' => ['type' => 'string', 'required' => true, 'example' => '1234'],
            'notification_token' => ['type' => 'string', 'required' => false, 'example' => '1234'],
        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'OTP verification successful, Welcome to SKYNET']
        ]
    ],
    'resend_otp' => [
        'summary' => 'Resend OTP',
        'tags' => 'Authentication',
        'method' => 'POST',
        'parameters' => [
            'mobile' => ['type' => 'number', 'required' => true, 'example' => '123'],

        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'We have sent you an OTP verification code. Please check']
        ]
    ],

    'forgot_password' => [
        'summary' => 'Forgot Password',
        'tags' => 'Authentication',
        'method' => 'POST',
        'parameters' => [
            'mobile' => ['type' => 'number', 'required' => true, 'example' => '1234567895'],
            'password' => ['type' => 'string', 'required' => true, 'example' => '1234567895'],
            'confirm_password' => ['type' => 'string', 'required' => true, 'example' => '1234567895'],

        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'reason' => ['type' => 'string', 'example' => 'Your Password Succesfully Update']
        ]
    ],

    'update_profile' => [
        'summary' => 'Update Profile',
        'tags' => 'Authentication',
        'method' => 'POST',
        'headers' => [
            'Authorization' => [
                'type' => 'string',
                'required' => true,
                'example' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...'
            ]
        ],
        'parameters' => [
            'user_id' => ['type' => 'number', 'required' => true, 'example' => '12'],
            'full_name' => ['type' => 'string', 'required' => true, 'example' => 'Amit'],
            'email' => ['type' => 'string', 'required' => true, 'example' => 'abc@gmail.com'],

        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'reason' => ['type' => 'string', 'example' => 'Profile updated successfully']
        ]
    ],

    'category_list' => [
        'summary' => 'Course Category Detail',
        'tags' => 'Course',
        'method' => 'POST',
        'parameters' => [
            'search' => ['type' => 'string', 'required' => false, 'example' => '1234'],
        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'Category found']
        ]
    ],
    'app_courses_list' => [
        'summary' => 'Course Detail',
        'tags' => 'Course',
        'method' => 'POST',
        'parameters' => [
            'user_id' => ['type' => 'number', 'required' => true, 'example' => '1'],
            'search' => ['type' => 'string', 'required' => false, 'example' => '1234'],
            'page_no' => ['type' => 'number', 'required' => false, 'example' => '1'],
            'category_id' => ['type' => 'number', 'required' => false, 'example' => '1'],
        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'Course Detail']
        ]
    ],
    'course_detail' => [
        'summary' => 'Course Detail',
        'tags' => 'Course',
        'method' => 'POST',
        'parameters' => [

            'user_id' => ['type' => 'number', 'required' => true, 'example' => '1'],
            'course_id' => ['type' => 'number', 'required' => true, 'example' => '1'],
        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'Course Detail']
        ]
    ],
    'create_qna' => [
        'summary' => 'Course Detail',
        'tags' => 'Course',
        'method' => 'POST',
        'parameters' => [
            'course_id' => ['type' => 'number', 'required' => true, 'example' => '1'],
            'question' => ['type' => 'string', 'required' => true, 'example' => '1'],
        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'Question Added Successfully']
        ]
    ],
    'question_answer_list' => [
        'summary' => 'Course Detail',
        'tags' => 'Course',
        'method' => 'POST',
        'parameters' => [
            'course_id' => ['type' => 'number', 'required' => true, 'example' => '1'],

        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'Question Added Successfully']
        ]
    ],


    // Course Review APIs
    'create_course_review' => [
        'summary' => 'Add Course Review',
        'tags' => 'Course Review',
        'method' => 'POST',
        'headers' => [
            'Authorization' => [
                'type' => 'string',
                'required' => true,
                'example' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...'
            ]
        ],
        'parameters' => [
            'course_id' => ['type' => 'number', 'required' => true, 'example' => '1'],
            'rate'      => ['type' => 'number', 'required' => true, 'example' => '5'],
            'review'    => ['type' => 'string', 'required' => true, 'example' => 'Excellent course with clear explanation'],
        ],
        'response' => [
            'result'  => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'Review added successfully'],
        ]
    ],

    'update_course_review' => [
        'summary' => 'Update Course Review',
        'tags' => 'Course Review',
        'method' => 'POST',
        'headers' => [
            'Authorization' => [
                'type' => 'string',
                'required' => true,
                'example' => 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...'
            ]
        ],
        'parameters' => [
            'review_id' => ['type' => 'number', 'required' => true, 'example' => '10'],
            'rate'      => ['type' => 'number', 'required' => true, 'example' => '4'],
            'review'    => ['type' => 'string', 'required' => true, 'example' => 'Updated review text'],
        ],
        'response' => [
            'result'  => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'Review updated successfully'],
        ]
    ],

    'delete_course_review' => [
        'summary' => 'Delete Course Review',
        'tags' => 'Course Review',
        'method' => 'POST',
        'headers' => [
            'Authorization' => [
                'type' => 'string',
                'required' => true,
                'example' => 'Bearer token_here'
            ]
        ],
        'parameters' => [
            'review_id' => ['type' => 'number', 'required' => true, 'example' => '10'],
        ],
        'response' => [
            'result'  => ['type' => 'boolean', 'example' => true],
            'message' => ['type' => 'string', 'example' => 'Review deleted successfully'],
        ]
    ],

    'course_review_list' => [
        'summary' => 'Course Review List',
        'tags' => 'Course Review',
        'method' => 'POST',
        'headers' => [
            'Authorization' => [
                'type' => 'string',
                'required' => true,
                'example' => 'Bearer token_here'
            ]
        ],
        'parameters' => [
            'course_id' => ['type' => 'number', 'required' => true, 'example' => '1'],
            'page'      => ['type' => 'number', 'required' => false, 'example' => '1'],
            'limit'     => ['type' => 'number', 'required' => false, 'example' => '10'],
        ],
        'response' => [
            'result'          => ['type' => 'boolean', 'example' => true],
            'message'         => ['type' => 'string', 'example' => 'Course review list fetched successfully'],
            'data'            => ['type' => 'array'],
            'total'           => ['type' => 'number', 'example' => 25],
            'total_pages'     => ['type' => 'number', 'example' => 3],
            'page'            => ['type' => 'number', 'example' => 1],
            'limit'           => ['type' => 'number', 'example' => 10],
            'user_image_path' => ['type' => 'string', 'example' => 'https://example.com/uploads/users/'],
        ]
    ],


    'create_forum_post' => [
        'summary' => 'Create a Forum Post',
        'tags' => ['Discussion Forum'],
        'method' => 'POST',
        'parameters' => [
            'title' => ['type' => 'string', 'required' => true, 'example' => 'What is WebSocket'],
            'description' => ['type' => 'string', 'required' => true, 'example' => 'Explain WebSocket in simple terms'],
            'tags' => ['type' => 'array', 'items' => ['type' => 'string'], 'example' => ['websocket', 'realtime']],
        ],
        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'reason' => ['type' => 'string', 'example' => 'Forum post created successfully'],
        ]
    ],



    'testing' => [
        'summary' => 'Test Api',
        'tags' => 'Testing',
        'method' => 'GET',

        'response' => [
            'result' => ['type' => 'boolean', 'example' => true],
            'reason' => ['type' => 'string', 'example' => 'Testing Api Call successfully'],
        ]
    ],
];