<?php
/**
 * Update Field Config API
 * Updates an existing field configuration
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/update_field.php
 * @param int field_config_id Field config ID
 * @param string field_label Display label
 * @param string field_type Field type
 * @param bool is_required Whether field is required
 * @param string placeholder Placeholder text (optional)
 * @param string help_text Help text (optional)
 * @param string validation_rules JSON validation rules (optional)
 * @param string default_value Default value (optional)
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

// Get field config ID
$field_config_id = isset($_POST['field_config_id']) ? intval($_POST['field_config_id']) : 0;

if (empty($field_config_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing required parameter: field_config_id']);
    exit;
}

try {
    // Get existing field config
    $old_field = getFieldConfigById($field_config_id);

    if (!$old_field) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Field config not found']);
        exit;
    }

    // Get updated data
    $data = [
        'prompt_type_id' => $old_field['prompt_type_id'],
        'field_id' => $old_field['field_id'], // Cannot change field_id
        'field_label' => isset($_POST['field_label']) ? sanitizeInput($_POST['field_label']) : $old_field['field_label'],
        'field_type' => isset($_POST['field_type']) ? sanitizeInput($_POST['field_type']) : $old_field['field_type'],
        'is_required' => isset($_POST['is_required']) ? intval($_POST['is_required']) : $old_field['is_required'],
        'placeholder' => isset($_POST['placeholder']) ? sanitizeInput($_POST['placeholder']) : $old_field['placeholder'],
        'help_text' => isset($_POST['help_text']) ? sanitizeInput($_POST['help_text']) : $old_field['help_text'],
        'validation_rules' => isset($_POST['validation_rules']) ? $_POST['validation_rules'] : $old_field['validation_rules'],
        'default_value' => isset($_POST['default_value']) ? sanitizeInput($_POST['default_value']) : $old_field['default_value']
    ];

    // Validate input
    $validation_errors = validateFieldConfigData($data);

    if (!empty($validation_errors)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'error' => 'Validation failed',
            'validation_errors' => $validation_errors
        ]);
        exit;
    }

    // Get product type for cache clearing
    $type = getPromptTypeById($data['prompt_type_id']);

    // Update field config
    $mysqli = getDbConnection();
    $updated_by = getCurrentClientId();

    $stmt = mysqli_prepare($mysqli, "
        UPDATE ai_field_configs
        SET field_label = ?,
            field_type = ?,
            is_required = ?,
            placeholder = ?,
            help_text = ?,
            validation_rules = ?,
            default_value = ?,
            updated_by = ?
        WHERE id = ?
    ");

    mysqli_stmt_bind_param($stmt, "ssissssii",
        $data['field_label'],
        $data['field_type'],
        $data['is_required'],
        $data['placeholder'],
        $data['help_text'],
        $data['validation_rules'],
        $data['default_value'],
        $updated_by,
        $field_config_id
    );

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        throw new Exception('Failed to update field config: ' . mysqli_stmt_error($stmt));
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    // Log to history
    logConfigChange(
        'field_config',
        $field_config_id,
        'update',
        $old_field,
        $data,
        'Updated field: ' . $data['field_label']
    );

    // Clear cache
    if ($type) {
        clearConfigCacheById($type['id']);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Field config updated successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to update field config: ' . $e->getMessage()
    ]);
}
