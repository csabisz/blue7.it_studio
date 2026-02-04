<?php
/**
 * Create Prompt Type API
 * Creates a new prompt type with initial base prompt
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/create_prompt_type.php
 * @param string type_key Unique identifier (lowercase, underscores)
 * @param string name Display name
 * @param string description Description (optional)
 * @param string base_prompt_key Base prompt key (optional, defaults to type_key)
 */

session_start();
require_once __DIR__ . '/../../../functions.php';
require_once __DIR__ . '/../includes/config_functions.php';
require_once __DIR__ . '/../includes/history_functions.php';
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
$data = [
    'type_key' => isset($_POST['type_key']) ? sanitizeInput($_POST['type_key']) : '',
    'name' => isset($_POST['name']) ? sanitizeInput($_POST['name']) : '',
    'description' => isset($_POST['description']) ? sanitizeInput($_POST['description']) : null,
    'base_prompt_key' => isset($_POST['base_prompt_key']) ? sanitizeInput($_POST['base_prompt_key']) : ''
];

// Default base_prompt_key to type_key if empty
if (empty($data['base_prompt_key'])) {
    $data['base_prompt_key'] = $data['type_key'];
}

// Validate input
$validation_errors = validateProductTypeData($data);

if (!empty($validation_errors)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Validation failed',
        'validation_errors' => $validation_errors
    ]);
    exit;
}

try {
    // Check if type_key is unique
    if (!isTypeKeyUnique($data['type_key'])) {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'error' => 'Type key already exists. Please choose a different key.',
            'field' => 'type_key'
        ]);
        exit;
    }

    // Create prompt type with initial base prompt
    $result = createPromptType($data);

    // Log to history
    logConfigChange(
        'product_type',
        $result['id'],
        'create',
        null,
        $data,
        'Created new prompt type: ' . $data['name']
    );

    // Clear all caches
    clearAllConfigCaches();

    echo json_encode([
        'success' => true,
        'message' => 'Prompt type created successfully',
        'data' => [
            'id' => $result['id']
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to create prompt type: ' . $e->getMessage()
    ]);
}
