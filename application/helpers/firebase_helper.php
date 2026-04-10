<?php
require_once APPPATH . '../vendor/autoload.php';

use Google\Auth\OAuth2;
use GuzzleHttp\Client;

if (!function_exists('get_firebase_access_token')) {
    function get_firebase_access_token()
    {
        $keyFilePath = APPPATH . 'config/firebase-credentials.json'; // Update path

        if (!file_exists($keyFilePath)) {
            throw new Exception("Firebase service account JSON file not found: " . $keyFilePath);
        }

        $credentials = json_decode(file_get_contents($keyFilePath), true);

        if (empty($credentials['private_key']) || empty($credentials['client_email']) || empty($credentials['token_uri'])) {
            throw new Exception("Invalid Firebase credentials file: Missing required keys.");
        }

        $oauth2 = new OAuth2([
            'audience' => $credentials['token_uri'], // Set correct audience
            'issuer' => $credentials['client_email'],
            'signingKey' => $credentials['private_key'],
            'signingAlgorithm' => 'RS256',
            'tokenCredentialUri' => $credentials['token_uri'], // ✅ Important fix
            'scope' => ['https://www.googleapis.com/auth/cloud-platform'],
        ]);

        $token = $oauth2->fetchAuthToken();
        if (!isset($token['access_token'])) {
            throw new Exception("Failed to retrieve access token.");
        }


        return $token['access_token'];
    }
}


// if (!function_exists('sendMobileNotification')) {
//     function sendMobileNotification($deviceTokens, $message, $title)
//     {
//         // echo "<pre>";
//         // print_r($deviceTokens);
//         // print_r($message);
//         // die;
//         $accessToken = get_firebase_access_token();
//         if (!$accessToken) {
//             throw new Exception("Failed to retrieve Firebase access token.");
//         }
//         // print_r($message);

//         // print_r($title);

//         // print_r($accessToken);
//         // die;
//         $client = new Client();

//         $projectId = 'apbc-1b029'; // Replace with your Firebase project ID
//         $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";
//         $batchSize = 500; // Firebase limit is 500 tokens per request
//         $responses = [];

//         // Split the tokens into batches of 500
//         $tokenChunks = array_chunk($deviceTokens, $batchSize);

//         // ✅ Check if tokens are valid
//         foreach ($deviceTokens as $token) {
//             if (preg_match('/^[a-zA-Z0-9:_-]+$/', $token)) { // Basic regex check
//                 $validTokens[] = $token;
//             }
//         }
//         // print_r($deviceTokens);die;
//         if (empty($validTokens)) {
//             echo ('No valid FCM registration tokens found.');
//             die;
//         }

//         foreach ($tokenChunks as $tokens) { // Process each batch
//             foreach ($tokens as $deviceToken) { // Send to each device in batch
//                 $payload = [
//                     "message" => [
//                         "token" => $deviceToken,
//                         "notification" => [
//                             "title" => $title,
//                             "body"  => $message,
//                         ],
//                         "data" => [
//                             "title"          => $title,
//                             "body"           => $message
//                         ],
//                         "apns" => [
//                             "payload" => [
//                                 "aps" => [
//                                     "sound" => "default",
//                                     "content-available" => 1
//                                 ]
//                             ]
//                         ]
//                     ]
//                 ];
//                 // echo "<pre>";
//                 // print_r($payload);die;

//                 try {
//                     $response = $client->post($url, [
//                         'headers' => [
//                             'Authorization' => 'Bearer ' . $accessToken,
//                             'Content-Type'  => 'application/json'
//                         ],
//                         'json' => $payload
//                     ]);

//                     $responses[] = json_decode($response->getBody(), true);
//                 } catch (Exception $e) {
//                     $responses[] = ['error' => $e->getMessage(), 'accessToken' => $accessToken];
//                 }
//             }
//         }

//         return $responses;
//     }
// }


if (!function_exists('sendMobileNotification')) {
    function sendMobileNotification($deviceToken, $message, $title)
    {
        $accessToken = get_firebase_access_token();
        if (!$accessToken) {
            throw new Exception("Failed to retrieve Firebase access token.");
        }


        if (empty($deviceToken)) {
            return ['error' => 'FCM token missing'];
        }

        $client = new Client();

        $projectId = 'skynet-7b810';
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";


        $payload = [
            "message" => [
                "token" => $deviceToken,
                "notification" => [
                    "title" => $title,
                    "body"  => $message,
                ],
                "data" => [
                    "title" => $title,
                    "body"  => $message
                ],
                "apns" => [
                    "payload" => [
                        "aps" => [
                            "sound" => "default",
                            "content-available" => 1
                        ]
                    ]
                ]
            ]
        ];

        try {
            $response = $client->post($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type'  => 'application/json'
                ],
                'json' => $payload
            ]);

            return json_decode($response->getBody(), true);
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}