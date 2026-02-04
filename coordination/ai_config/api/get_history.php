<?php
/**
 * Get Change History API
 * Returns change history for a product type
 *
 * @method GET
 * @endpoint /studio/coordination/ai_config/api/get_history.php?id=3&limit=50&offset=0
 * @param int id Prompt type ID
 * @param int limit Number of records (optional, default: 50)
 * @param int offset Offset for pagination (optional, default: 0)
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

// Validate input
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameter: id']);
    exit;
}

$prompt_type_id = intval($_GET['id']);
$limit = isset($_GET['limit']) ? intval($_GET['limit']) : 50;
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

// Validate limits
if ($limit < 1 || $limit > 200) {
    $limit = 50;
}

if ($offset < 0) {
    $offset = 0;
}

try {
    $history = getConfigHistory($prompt_type_id, $limit, $offset);
    $total_count = getChangeCount($prompt_type_id);

    echo json_encode([
        'success' => true,
        'data' => [
            'history' => $history,
            'total_count' => $total_count,
            'limit' => $limit,
            'offset' => $offset
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch history: ' . $e->getMessage()
    ]);
}
