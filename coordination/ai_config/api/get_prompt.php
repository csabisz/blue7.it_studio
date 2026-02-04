<?php
/**
 * Get Base Prompt API
 * Returns active base prompt for a product type
 *
 * @method GET
 * @endpoint /studio/coordination/ai_config/api/get_prompt.php?id=3
 * @param int id Prompt type ID
 */

session_start();
require_once __DIR__ . '/../../../functions.php';
require_once __DIR__ . '/../includes/config_functions.php';

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

// Validate input
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameter: id']);
    exit;
}

$prompt_type_id = intval($_GET['id']);

// Get product type
try {
    $type = getPromptTypeById($prompt_type_id);

    if (!$type) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Product type not found']);
        exit;
    }

    // Get all prompts (including versions)
    $all_prompts = getAllBasePrompts($prompt_type_id);

    // Get active prompt
    $active_prompt = null;
    foreach ($all_prompts as $prompt) {
        if ($prompt['is_active']) {
            $active_prompt = $prompt;
            break;
        }
    }

    // Add type name to prompt for breadcrumb display
    if ($active_prompt) {
        $active_prompt['type_name'] = $type['name'];
    }

    if (!$active_prompt) {
        // No prompts exist yet
        echo json_encode([
            'success' => true,
            'data' => [
                'prompt' => null,
                'all_versions' => [],
                'type_name' => $type['name']
            ]
        ]);
        exit;
    }

    echo json_encode([
        'success' => true,
        'data' => [
            'prompt' => $active_prompt,
            'all_versions' => $all_prompts,
            'type_name' => $type['name']
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch prompt: ' . $e->getMessage()
    ]);
}
