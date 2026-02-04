<?php
/**
 * Get All Product Types API
 * Returns list of all product types
 *
 * @method GET
 * @endpoint /studio/coordination/ai_config/api/product_types.php
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

// Get all product types
try {
    $types = getAllPromptTypes(true); // Only active types

    // For each type, get field count
    foreach ($types as &$type) {
        $fields = getFieldConfigsById($type['id'], true);
        $type['field_count'] = count($fields);
    }

    echo json_encode([
        'success' => true,
        'data' => $types
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to fetch product types: ' . $e->getMessage()
    ]);
}
