<?php
/**
 * Validate Prompt Template API
 * Checks prompt template for required variables
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/validate_prompt.php
 * @param int prompt_type_id Product type ID
 * @param string prompt_template Prompt template to validate
 */

session_start();
require_once __DIR__ . '/../../../functions.php';
require_once __DIR__ . '/../includes/config_functions.php';
require_once __DIR__ . '/../includes/validation_functions.php';

// Update session timestamp
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");

// Set JSON header
header('Content-Type: application/json');

// Authorization check
if (!isset($_COOKIE['client_id']) || $_COOKIE['start'] >= $_COOKIE['expire']) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Session expired']);
    exit;
}

if ($_COOKIE['coordination'] <= 0) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Access denied - coordination permission required']);
    exit;
}

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Get POST data
$prompt_type_id = isset($_POST['prompt_type_id']) ? intval($_POST['prompt_type_id']) : 0;
$prompt_template = isset($_POST['prompt_template']) ? $_POST['prompt_template'] : '';

// Validate input
if (empty($prompt_type_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameter: prompt_type_id']);
    exit;
}

if (empty($prompt_template)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameter: prompt_template']);
    exit;
}

try {
    // Validate prompt template
    $validation_result = validatePromptTemplate($prompt_type_id, $prompt_template);

    echo json_encode([
        'success' => true,
        'data' => $validation_result
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to validate prompt: ' . $e->getMessage()
    ]);
}
