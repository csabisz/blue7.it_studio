<?php
/**
 * Reorder Options API
 * Updates display_order for field options
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/reorder_options.php
 * @param array option_ids Array of option IDs in new order
 * @param int field_config_id Field config ID for cache clearing
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

// Get option IDs (can be JSON or array)
$option_ids = isset($_POST['option_ids']) ? $_POST['option_ids'] : '';
$field_config_id = isset($_POST['field_config_id']) ? intval($_POST['field_config_id']) : 0;

// Parse JSON if string
if (is_string($option_ids)) {
    $option_ids = json_decode($option_ids, true);
}

if (!is_array($option_ids) || empty($option_ids)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid option_ids parameter']);
    exit;
}

if (empty($field_config_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameter: field_config_id']);
    exit;
}

try {
    // Get field config and product type for cache clearing
    $field = getFieldConfigById($field_config_id);

    if (!$field) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Field config not found']);
        exit;
    }

    $type = getPromptTypeById($field['prompt_type_id']);

    // Update display_order for each option
    $mysqli = getDbConnection();
    mysqli_begin_transaction($mysqli);

    try {
        $stmt = mysqli_prepare($mysqli, "UPDATE ai_field_options SET display_order = ? WHERE id = ?");

        foreach ($option_ids as $index => $option_id) {
            $display_order = $index + 1;
            $option_id_int = intval($option_id);

            mysqli_stmt_bind_param($stmt, "ii", $display_order, $option_id_int);

            if (!mysqli_stmt_execute($stmt)) {
                throw new Exception('Failed to update display order: ' . mysqli_stmt_error($stmt));
            }
        }

        mysqli_stmt_close($stmt);
        mysqli_commit($mysqli);
        mysqli_close($mysqli);

        // Log to history
        logConfigChange(
            'field_option',
            $field_config_id, // Using field_config_id as entity_id for reorder operations
            'update',
            null,
            ['option_ids' => $option_ids],
            'Reordered options'
        );

        // Clear cache
        if ($type) {
            clearConfigCacheById($type['id']);
        }

        echo json_encode([
            'success' => true,
            'message' => 'Options reordered successfully'
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
        'error' => 'Failed to reorder options: ' . $e->getMessage()
    ]);
}
