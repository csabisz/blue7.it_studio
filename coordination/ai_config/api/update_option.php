<?php
/**
 * Update Field Option API
 * Updates an existing dropdown option
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/update_option.php
 * @param int option_id Option ID
 * @param string option_value Option value
 * @param string option_label Display label
 * @param string prompt_text Optional prompt text
 * @param string room_restrictions Comma-separated room types (optional)
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
    $old_option = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$old_option) {
        mysqli_close($mysqli);
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Option not found']);
        exit;
    }

    // Get updated data
    $data = [
        'field_config_id' => $old_option['field_config_id'],
        'option_value' => isset($_POST['option_value']) ? sanitizeInput($_POST['option_value']) : $old_option['option_value'],
        'option_label' => isset($_POST['option_label']) ? sanitizeInput($_POST['option_label']) : $old_option['option_label'],
        'prompt_text' => isset($_POST['prompt_text']) ? $_POST['prompt_text'] : $old_option['prompt_text'],
        'room_restrictions' => isset($_POST['room_restrictions']) ? sanitizeInput($_POST['room_restrictions']) : $old_option['room_restrictions']
    ];

    // Validate input
    $validation_errors = validateFieldOptionData($data);

    if (!empty($validation_errors)) {
        mysqli_close($mysqli);
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Validation failed',
            'validation_errors' => $validation_errors
        ]);
        exit;
    }

    // Get field config and product type for cache clearing
    $field = getFieldConfigById($old_option['field_config_id']);
    $type = $field ? getPromptTypeById($field['prompt_type_id']) : null;

    // Update option
    $stmt = mysqli_prepare($mysqli, "
        UPDATE ai_field_options
        SET option_value = ?,
            option_label = ?,
            prompt_text = ?,
            room_restrictions = ?
        WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt, "ssssi",
        $data['option_value'],
        $data['option_label'],
        $data['prompt_text'],
        $data['room_restrictions'],
        $option_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        throw new Exception('Failed to update option: ' . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    // Log to history
    logConfigChange(
        'field_option',
        $option_id,
        'update',
        $old_option,
        $data,
        'Updated option: ' . $data['option_label']
    );

    // Clear cache
    if ($type) {
        clearConfigCacheById($type['id']);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Option updated successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to update option: ' . $e->getMessage()
    ]);
}
