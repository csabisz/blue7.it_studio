<?php
/**
 * Delete Field Config API
 * Soft deletes a field configuration (sets is_active = 0)
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/delete_field.php
 * @param int field_config_id Field config ID
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

// Get field config ID
$field_config_id = isset($_POST['field_config_id']) ? intval($_POST['field_config_id']) : 0;

if (empty($field_config_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameter: field_config_id']);
    exit;
}

try {
    // Get existing field config
    $field = getFieldConfigById($field_config_id);

    if (!$field) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Field config not found']);
        exit;
    }

    // Get product type for cache clearing
    $type = getPromptTypeById($field['prompt_type_id']);

    // Soft delete (set is_active = 0)
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "
        UPDATE ai_field_configs
        SET is_active = 0
        WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt, "i", $field_config_id);

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        throw new Exception('Failed to delete field config: ' . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    // Log to history
    logConfigChange(
        'field_config',
        $field_config_id,
        'delete',
        $field,
        null,
        'Deleted field: ' . $field['field_label']
    );

    // Clear cache
    if ($type) {
        clearConfigCacheById($type['id']);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Field config deleted successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to delete field config: ' . $e->getMessage()
    ]);
}
