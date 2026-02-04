<?php
/**
 * Add Field Config API
 * Creates a new field configuration for a product type
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/add_field.php
 * @param int prompt_type_id Product type ID
 * @param string field_id Field identifier (unique per product type)
 * @param string field_label Display label
 * @param string field_type Field type: select, textarea, checkbox, text
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

// Get POST data
$data = [
    'prompt_type_id' => isset($_POST['prompt_type_id']) ? intval($_POST['prompt_type_id']) : 0,
    'field_id' => isset($_POST['field_id']) ? sanitizeInput($_POST['field_id']) : '',
    'field_label' => isset($_POST['field_label']) ? sanitizeInput($_POST['field_label']) : '',
    'field_type' => isset($_POST['field_type']) ? sanitizeInput($_POST['field_type']) : '',
    'is_required' => isset($_POST['is_required']) ? intval($_POST['is_required']) : 0,
    'placeholder' => isset($_POST['placeholder']) ? sanitizeInput($_POST['placeholder']) : null,
    'help_text' => isset($_POST['help_text']) ? sanitizeInput($_POST['help_text']) : null,
    'validation_rules' => isset($_POST['validation_rules']) ? $_POST['validation_rules'] : null,
    'default_value' => isset($_POST['default_value']) ? sanitizeInput($_POST['default_value']) : null
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

try {
    // Check if field_id is unique within this product type
    if (!isFieldIdUnique($data['prompt_type_id'], $data['field_id'])) {
        http_response_code(409);
        echo json_encode([
            'success' => false,
            'error' => 'Field ID already exists for this product type'
        ]);
        exit;
    }

    // Get product type for cache clearing
    $type = getPromptTypeById($data['prompt_type_id']);
    if (!$type) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Product type not found']);
        exit;
    }

    // Get next display order
    $mysqli = getDbConnection();
    $stmt = mysqli_prepare($mysqli, "
        SELECT MAX(display_order) as max_order
        FROM ai_field_configs
        WHERE prompt_type_id = ?
    ");
    mysqli_stmt_bind_param($stmt, "i", $data['prompt_type_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $display_order = ($row['max_order'] ?? 0) + 1;

    // Insert field config
    $created_by = getCurrentClientId();

    $stmt = mysqli_prepare($mysqli, "
        INSERT INTO ai_field_configs
        (prompt_type_id, field_id, field_label, field_type, is_required,
         placeholder, help_text, validation_rules, default_value, display_order, created_by, updated_by)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param($stmt, "isssissssiii",
        $data['prompt_type_id'],
        $data['field_id'],
        $data['field_label'],
        $data['field_type'],
        $data['is_required'],
        $data['placeholder'],
        $data['help_text'],
        $data['validation_rules'],
        $data['default_value'],
        $display_order,
        $created_by,
        $created_by
    );

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        throw new Exception('Failed to insert field config: ' . mysqli_stmt_error($stmt));
    }

    $field_config_id = mysqli_insert_id($mysqli);
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    // Log to history
    logConfigChange(
        'field_config',
        $field_config_id,
        'create',
        null,
        $data,
        'Added new field: ' . $data['field_label']
    );

    // Clear cache
    clearConfigCacheById($type['id']);

    echo json_encode([
        'success' => true,
        'message' => 'Field config created successfully',
        'data' => [
            'field_config_id' => $field_config_id,
            'display_order' => $display_order
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to create field config: ' . $e->getMessage()
    ]);
}
