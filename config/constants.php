<?php
    return [
        'api_version' => env('API_VERSION'),
        'key' => [

            'status' => 'status',
            'success' => 'success',
            'failure' => 'failure',
            'message' => 'message',
            'error' => 'error',
            'token' => 'token',
            'login_error' => 'login_error',
            'data' => 'data',
            '200' => '200',
            '401' => '401',
        ],

        'value' => [

            'success' => 'Success',
            'failure' => 'Failure',
            'failure_msg' => 'Some error occurred.Please try again.',
            'login_error' => 'Incorrect email and password !!',
            'student_login_error' => 'Incorrect phone and password !!',
            'logged_in' => 'You are logged in successfully.',
            'logged_out' => 'You are logged out successfully.',
            'unauthenticated' => 'Unauthenticated', 
        ], 

        'admin' => [
             
            'institute' => [
                'not_exists' => 'Institute does not exists.',
                'resolved' => 'Institute status has been changed to resolved.',
            ], 
            'manage_institute' => [
                'added' => 'Institute has been added successfully.',
                'updated'=> 'Institute has been updated successfully.'
            ]
        ],

        'front' => [
            'key' => [
                'otp' => 'otp'
            ],
            'value' => [
                'otp_sent' => 'OTP has been sent to your registered phone number',
                'otp_mismatch' => 'OTP does not match.',
                'otp_match' => 'OTP has been match successfully.',
                'student_registered' => 'You are successfully registered. Please login now.',
            ]
        ],
    ];
    
?>