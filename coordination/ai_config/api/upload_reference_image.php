<?php
/**
 * Upload Reference Image API
 * Handles file uploads for field option reference images
 *
 * @method POST
 * @endpoint /studio/coordination/ai_config/api/upload_reference_image.php
 * @param int option_id Option ID (required for naming)
 * @param file reference_image The image file to upload
 */

session_start();
require_once __DIR__ . '/../../../functions.php';
require_once __DIR__ . '/../includes/config_functions.php';
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

// Check if file was uploaded
if (!isset($_FILES['reference_image']) || $_FILES['reference_image']['error'] !== UPLOAD_ERR_OK) {
    $error_message = 'No file uploaded';
    if (isset($_FILES['reference_image'])) {
        switch ($_FILES['reference_image']['error']) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                $error_message = 'File exceeds maximum size limit';
                break;
            case UPLOAD_ERR_PARTIAL:
                $error_message = 'File was only partially uploaded';
                break;
            case UPLOAD_ERR_NO_FILE:
                $error_message = 'No file was uploaded';
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
            case UPLOAD_ERR_CANT_WRITE:
                $error_message = 'Server configuration error';
                break;
        }
    }
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $error_message]);
    exit;
}

// Validate the image file
$validation_result = validateReferenceImage($_FILES['reference_image']);
if (!$validation_result['valid']) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => $validation_result['error']]);
    exit;
}

try {
    // Define upload directory
    $upload_dir = __DIR__ . '/../uploads/reference_images/';

    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) {
            throw new Exception('Failed to create upload directory');
        }
    }

    // Get existing option to check for old image
    $mysqli = getDbConnection();
    $stmt = mysqli_prepare($mysqli, "SELECT reference_image FROM ai_field_options WHERE id = ?");
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

    // Delete old image if exists
    if (!empty($option['reference_image'])) {
        $old_file = $upload_dir . $option['reference_image'];
        if (file_exists($old_file)) {
            unlink($old_file);
        }
    }

    // Generate unique filename
    $file_ext = strtolower(pathinfo($_FILES['reference_image']['name'], PATHINFO_EXTENSION));
    $random_string = bin2hex(random_bytes(8));
    $timestamp = time();
    $new_filename = "{$option_id}_{$timestamp}_{$random_string}.{$file_ext}";
    $destination = $upload_dir . $new_filename;

    // Move uploaded file
    if (!move_uploaded_file($_FILES['reference_image']['tmp_name'], $destination)) {
        mysqli_close($mysqli);
        throw new Exception('Failed to move uploaded file');
    }

    // Update database with new filename
    $stmt = mysqli_prepare($mysqli, "UPDATE ai_field_options SET reference_image = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "si", $new_filename, $option_id);

    if (!mysqli_stmt_execute($stmt)) {
        // Delete the uploaded file if database update fails
        unlink($destination);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        throw new Exception('Failed to update database');
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    // Return success with file path
    echo json_encode([
        'success' => true,
        'message' => 'Reference image uploaded successfully',
        'data' => [
            'filename' => $new_filename,
            'url' => '/studio/coordination/ai_config/uploads/reference_images/' . $new_filename
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to upload image: ' . $e->getMessage()
    ]);
}
