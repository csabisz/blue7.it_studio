<?php
/**
 * Add Field Option API
 * Adds a dropdown option to a select-type field
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/add_option.php
 * @param int field_config_id Field config ID
 * @param string option_value Option value
 * @param string option_label Display label
 * @param string prompt_text Optional prompt text for style presets
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

// Get POST data
$data = [
    'field_config_id' => isset($_POST['field_config_id']) ? intval($_POST['field_config_id']) : 0,
    'option_value' => isset($_POST['option_value']) ? sanitizeInput($_POST['option_value']) : '',
    'option_label' => isset($_POST['option_label']) ? sanitizeInput($_POST['option_label']) : '',
    'prompt_text' => isset($_POST['prompt_text']) ? $_POST['prompt_text'] : null,
    'room_restrictions' => isset($_POST['room_restrictions']) ? sanitizeInput($_POST['room_restrictions']) : null
];

// Handle reference image upload if present
$reference_image = null;
if (isset($_FILES['reference_image']) && $_FILES['reference_image']['error'] === UPLOAD_ERR_OK) {
    // Validate the image file
    $validation_result = validateReferenceImage($_FILES['reference_image']);
    if (!$validation_result['valid']) {
        http_response_code(400);
        echo json_encode(['success' => false, 'error' => $validation_result['error']]);
        exit;
    }
}

// Validate input
$validation_errors = validateFieldOptionData($data);

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
    // Get field config to verify it exists and get product type for cache clearing
    $field = getFieldConfigById($data['field_config_id']);

    if (!$field) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Field config not found']);
        exit;
    }

    // Get product type for cache clearing
    $type = getPromptTypeById($field['prompt_type_id']);

    // Get next display order
    $mysqli = getDbConnection();
    $stmt = mysqli_prepare($mysqli, "
        SELECT MAX(display_order) as max_order
        FROM ai_field_options
        WHERE field_config_id = ?
    ");
    mysqli_stmt_bind_param($stmt, "i", $data['field_config_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    $display_order = ($row['max_order'] ?? 0) + 1;

    // Insert option
    $stmt = mysqli_prepare($mysqli, "
        INSERT INTO ai_field_options
        (field_config_id, option_value, option_label, prompt_text, room_restrictions, display_order)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param($stmt, "issssi",
        $data['field_config_id'],
        $data['option_value'],
        $data['option_label'],
        $data['prompt_text'],
        $data['room_restrictions'],
        $display_order
    );

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        throw new Exception('Failed to insert option: ' . mysqli_stmt_error($stmt));
    }

    $option_id = mysqli_insert_id($mysqli);
    mysqli_stmt_close($stmt);

    // Handle reference image upload if present
    $reference_image_url = null;
    if (isset($_FILES['reference_image']) && $_FILES['reference_image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../uploads/reference_images/';

        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        // Generate unique filename
        $file_ext = strtolower(pathinfo($_FILES['reference_image']['name'], PATHINFO_EXTENSION));
        $random_string = bin2hex(random_bytes(8));
        $timestamp = time();
        $new_filename = "{$option_id}_{$timestamp}_{$random_string}.{$file_ext}";
        $destination = $upload_dir . $new_filename;

        // Move uploaded file
        if (move_uploaded_file($_FILES['reference_image']['tmp_name'], $destination)) {
            // Update database with filename
            $stmt = mysqli_prepare($mysqli, "UPDATE ai_field_options SET reference_image = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmt, "si", $new_filename, $option_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $reference_image_url = '/studio/coordination/ai_config/uploads/reference_images/' . $new_filename;
        }
    }

    mysqli_close($mysqli);

    // Log to history
    logConfigChange(
        'field_option',
        $option_id,
        'create',
        null,
        $data,
        'Added option: ' . $data['option_label']
    );

    // Clear cache
    if ($type) {
        clearConfigCacheById($type['id']);
    }

    $response_data = [
        'option_id' => $option_id,
        'display_order' => $display_order
    ];

    if ($reference_image_url) {
        $response_data['reference_image_url'] = $reference_image_url;
    }

    echo json_encode([
        'success' => true,
        'message' => 'Option created successfully',
        'data' => $response_data
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to create option: ' . $e->getMessage()
    ]);
}
