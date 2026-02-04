<?php
/**
 * Update Base Prompt API
 * Creates new version of base prompt with optimistic locking
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/update_prompt.php
 * @param int prompt_type_id Product type ID
 * @param string prompt_template Prompt template
 * @param string change_summary Summary of changes (optional)
 * @param int loaded_version Version number when user loaded the editor (for conflict detection)
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
$prompt_type_id = isset($_POST['prompt_type_id']) ? intval($_POST['prompt_type_id']) : 0;
$prompt_template = isset($_POST['prompt_template']) ? $_POST['prompt_template'] : '';
$change_summary = isset($_POST['change_summary']) ? sanitizeInput($_POST['change_summary']) : null;
$loaded_version = isset($_POST['loaded_version']) ? intval($_POST['loaded_version']) : 0;

// Validate input
$data = [
    'prompt_type_id' => $prompt_type_id,
    'prompt_template' => $prompt_template,
    'change_summary' => $change_summary
];

$validation_errors = validateBasePromptData($data);

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
    // Get product type
    $type = getPromptTypeById($prompt_type_id);

    if (!$type) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Product type not found']);
        exit;
    }

    // Optimistic locking: Check if version has changed since user loaded the editor
    $current_version = getCurrentPromptVersion($prompt_type_id);

    if ($loaded_version > 0 && $current_version > $loaded_version) {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'error' => 'This prompt was modified by another user. Please refresh and try again.',
            'conflict' => true,
            'current_version' => $current_version
        ]);
        exit;
    }

    // Get old prompt for history
    $old_prompt_template = getBasePromptById($prompt_type_id);

    // Create new version
    $created_by = getCurrentClientId();
    $new_prompt = createNewPromptVersion(
        $prompt_type_id,
        $prompt_template,
        $change_summary,
        $created_by
    );

    // Log to history
    logConfigChange(
        'base_prompt',
        $new_prompt['id'],
        'update',
        ['template' => $old_prompt_template],
        ['template' => $prompt_template],
        $change_summary
    );

    // Clear cache
    clearConfigCacheById($type['id']);

    echo json_encode([
        'success' => true,
        'message' => 'Prompt updated successfully',
        'data' => [
            'prompt_id' => $new_prompt['id'],
            'version' => $new_prompt['version']
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to update prompt: ' . $e->getMessage()
    ]);
}
