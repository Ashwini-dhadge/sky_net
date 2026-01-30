<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="CodeIgniter API Documentation",
 *     description="API endpoints documentation"
 * )
 * @OA\Server(url="http://192.168.1.14/test-swagger")
 */
class Api_docs extends CI_Controller
{

    public function index()
    {
        ini_set('display_errors', 0);
        error_reporting(0);

        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/json');

        // Load API documentation configuration
        $apiDocs = include(APPPATH . 'config/api_documentation.php');

        // Load routes configuration
        include(APPPATH . 'config/routes.php');

        // Build OpenAPI spec
        $spec = [
            'openapi' => '3.0.0',
            'info' => [
                'title' => 'Skynet API Documentation',
                'version' => '1.0.0',
                'description' => 'API endpoints documentation'
            ],
            'servers' => [
                ['url' => 'http://192.168.1.14/test-swagger', 'description' => 'Development Server']
            ],
            'paths' => []
        ];

        // Generate documentation from configuration
        foreach ($apiDocs as $routeName => $apiConfig) {
            // Get the actual route path
            $routePath = $routeName;

            // Build parameters
            $parameters = [];
            $requiredParams = [];
            foreach ($apiConfig['parameters'] as $paramName => $paramConfig) {
                $parameters[$paramName] = [
                    'type' => $paramConfig['type'],
                    'example' => $paramConfig['example'] ?? ''
                ];
                if (isset($paramConfig['description'])) {
                    $parameters[$paramName]['description'] = $paramConfig['description'];
                }
                if (isset($paramConfig['required']) && $paramConfig['required']) {
                    $requiredParams[] = $paramName;
                }
            }

            // Build response
            $responseProperties = [];
            foreach ($apiConfig['response'] as $respName => $respConfig) {
                $responseProperties[$respName] = [
                    'type' => $respConfig['type']
                ];
                if (isset($respConfig['example'])) {
                    $responseProperties[$respName]['example'] = $respConfig['example'];
                }
                if (isset($respConfig['description'])) {
                    $responseProperties[$respName]['description'] = $respConfig['description'];
                }
            }

            // Determine HTTP method
            $httpMethod = strtolower($apiConfig['method'] ?? 'POST');

            // Build path specification
            $spec['paths']['/' . $routePath][$httpMethod] = [
                'tags' => [$apiConfig['tags']],
                'summary' => $apiConfig['summary'],
                'requestBody' => [
                    'required' => true,
                    'content' => [
                        'application/x-www-form-urlencoded' => [
                            'schema' => [
                                'type' => 'object',
                                'required' => $requiredParams,
                                'properties' => $parameters
                            ]
                        ]
                    ]
                ],
                'responses' => [
                    '200' => [
                        'description' => 'Success',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => $responseProperties
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }

        echo json_encode($spec, JSON_PRETTY_PRINT);
        exit;
    }

    public function ui()
    {
        $this->load->view('swagger_ui');
    }
}
