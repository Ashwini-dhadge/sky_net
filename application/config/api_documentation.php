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
        'parameters' => [
            'user_id' => ['type' => 'number', 'required' => true, 'example' => '12'],
            'api_token' => ['type' => 'string', 'required' => true, 'example' => '1234567895'],
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
            'api_token' => ['type' => 'string', 'required' => true, 'example' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJyZWdfdHlwZSI6IjMiLCJyZWdfaWQiOiIyIiwicmVnX2VtYWlsIjoib21rYXJAZ21haWwuY29tIiwicmVnX21vYmlsZSI6IjEyMzQ1Njc4OTkiLCJyZWdfbmFtZSI6Im9ta2FyICIsImtleSI6ODIxMjk0fQ.yAdTYxX4NSZrqvYGPnmdwzVCi2LqXTyw1lR3osc7f-4'],
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


    // TestApi
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
