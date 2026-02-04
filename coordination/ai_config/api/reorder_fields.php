<?php
/**
 * Reorder Fields API
 * Updates display_order for field configs
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/reorder_fields.php
 * @param array field_ids Array of field config IDs in new order
 * @param int prompt_type_id Product type ID for cache clearing
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

// Get field IDs (can be JSON or array)
$field_ids = isset($_POST['field_ids']) ? $_POST['field_ids'] : '';
$prompt_type_id = isset($_POST['prompt_type_id']) ? intval($_POST['prompt_type_id']) : 0;

// Parse JSON if string
if (is_string($field_ids)) {
    $field_ids = json_decode($field_ids, true);
}

if (!is_array($field_ids) || empty($field_ids)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid field_ids parameter']);
    exit;
}

if (empty($prompt_type_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameter: prompt_type_id']);
    exit;
}

try {
    // Get product type for cache clearing
    $type = getPromptTypeById($prompt_type_id);

    if (!$type) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Product type not found']);
        exit;
    }

    // Update display_order for each field
    $mysqli = getDbConnection();
    mysqli_begin_transaction($mysqli);

    try {
        $stmt = mysqli_prepare($mysqli, "UPDATE ai_field_configs SET display_order = ? WHERE id = ?");

        foreach ($field_ids as $index => $field_id) {
            $display_order = $index + 1;
            $field_id_int = intval($field_id);

            mysqli_stmt_bind_param($stmt, "ii", $display_order, $field_id_int);

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception('Failed to update display order: ' . mysqli_stmt_error($stmt));
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_commit($mysqli);
        mysqli_close($mysqli);

        // Log to history
        logConfigChange(
            'field_config',
            $prompt_type_id, // Using prompt_type_id as entity_id for reorder operations
            'update',
            null,
            ['field_ids' => $field_ids],
            'Reordered fields'
        );

        // Clear cache
        clearConfigCacheById($type['id']);

        echo json_encode([
            'success' => true,
            'message' => 'Fields reordered successfully'
        ]);

    } catch (Exception $e) {
        mysqli_rollback($mysqli);
        mysqli_close($mysqli);
        throw $e;
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to reorder fields: ' . $e->getMessage()
    ]);
}
