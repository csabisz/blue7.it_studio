<?php
/**
 * Delete Field Option API
 * Hard deletes a dropdown option
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/delete_option.php
 * @param int option_id Option ID
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

// Get option ID
$option_id = isset($_POST['option_id']) ? intval($_POST['option_id']) : 0;

if (empty($option_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameter: option_id']);
    exit;
}

try {
    // Get existing option
    $mysqli = getDbConnection();
    $stmt = mysqli_prepare($mysqli, "SELECT * FROM ai_field_options WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $option_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $option = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$option) {
        mysqli_close($mysqli);
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Option not found']);
        exit;
    }

    // Get field config and product type for cache clearing
    $field = getFieldConfigById($option['field_config_id']);
    $type = $field ? getPromptTypeById($field['prompt_type_id']) : null;

    // Hard delete
    $stmt = mysqli_prepare($mysqli, "DELETE FROM ai_field_options WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $option_id);

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        throw new Exception('Failed to delete option: ' . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    // Log to history
    logConfigChange(
        'field_option',
        $option_id,
        'delete',
        $option,
        null,
        'Deleted option: ' . $option['option_label']
    );

    // Clear cache
    if ($type) {
        clearConfigCacheById($type['id']);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Option deleted successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to delete option: ' . $e->getMessage()
    ]);
}
