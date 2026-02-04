<?php
/**
 * Restore Previous Version API
 * Restores a base prompt to a previous version
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/restore_version.php
 * @param int history_id History record ID containing the version to restore
 */

session_start();
require_once __DIR__ . '/../../../functions.php';
require_once __DIR__ . '/../includes/config_functions.php';
require_once __DIR__ . '/../includes/history_functions.php';

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
$history_id = isset($_POST['history_id']) ? intval($_POST['history_id']) : 0;

// Validate input
if (empty($history_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameter: history_id']);
    exit;
}

try {
    $restored = restorePromptVersion($history_id);

    echo json_encode([
        'success' => true,
        'message' => 'Version restored successfully',
        'data' => $restored
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to restore version: ' . $e->getMessage()
    ]);
}
