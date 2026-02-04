<?php
session_start();
header('Content-Type: application/json');

function getDbConnection()
{
    $host = 'localhost';
    $username = 'adminhdd_domenia1';
    $password = 'p@MjdhfBSmbXWv68';
    $database = 'adminhdd_domenia1';

    $mysqli = mysqli_connect($host, $username, $password, $database);

    if (!$mysqli) {
        throw new Exception('Database connection failed: ' . mysqli_connect_error());
    }

    return $mysqli;
}

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

function downloadImage($url, $destinationPath)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $imageData = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError || $httpCode !== 200 || !$imageData) {
        throw new Exception('Failed to download image: ' . ($curlError ?: 'HTTP ' . $httpCode));
    }

    if (!file_put_contents($destinationPath, $imageData)) {
        throw new Exception('Failed to save downloaded image');
    }

    return true;
}

function createThumbnail($sourcePath, $destinationPath)
{
    list($width, $height, $type) = getimagesize($sourcePath);

    // Calculate new dimensions (fixed height 145px)
    $newHeight = 145;
    $newWidth = floor($width * ($newHeight / $height));

    // Create image resource based on type
    switch ($type) {
        case IMAGETYPE_JPEG:
            $source = imagecreatefromjpeg($sourcePath);
            break;
        case IMAGETYPE_PNG:
            $source = imagecreatefrompng($sourcePath);
            break;
        case IMAGETYPE_GIF:
            $source = imagecreatefromgif($sourcePath);
            break;
        default:
            throw new Exception('Unsupported image type for thumbnail');
    }

    // Create new image
    $thumbnail = imagecreatetruecolor($newWidth, $newHeight);

    // Handle transparency for PNG
    if ($type === IMAGETYPE_PNG) {
        imagealphablending($thumbnail, false);
        imagesavealpha($thumbnail, true);
        $transparent = imagecolorallocatealpha($thumbnail, 255, 255, 255, 127);
        imagefilledrectangle($thumbnail, 0, 0, $newWidth, $newHeight, $transparent);
    }

    // Resample
    imagecopyresampled($thumbnail, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    // Save based on type
    switch ($type) {
        case IMAGETYPE_JPEG:
            imageinterlace($thumbnail, 1);
            imageresolution($thumbnail, 72, 72);
            imagejpeg($thumbnail, $destinationPath);
            break;
        case IMAGETYPE_PNG:
            imagepng($thumbnail, $destinationPath);
            break;
        case IMAGETYPE_GIF:
            imagegif($thumbnail, $destinationPath);
            break;
    }

    imagedestroy($source);
    imagedestroy($thumbnail);

    return true;
}

try {
    // Verify request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate required fields
    $required_fields = ['orf_id', 'model', 'product_type', 'final_prompt'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            throw new Exception("Missing required field: $field");
        }
    }

    // Sanitize inputs
    $orf_id = intval($_POST['orf_id']);
    $model = sanitizeInput($_POST['model']);
    $product_type = sanitizeInput($_POST['product_type']);
    $additional_instructions = sanitizeInput($_POST['additional_instructions'] ?? '');
    $final_prompt = sanitizeInput($_POST['final_prompt']);

    // Collect dynamic field values
    $field_values = [];
    $room_type = '';
    $style_preset = '';
    $quality = '4K';

    // Map common field names for backward compatibility
    foreach ($_POST as $key => $value) {
        if (in_array($key, ['orf_id', 'model', 'product_type', 'additional_instructions', 'final_prompt'])) {
            continue; // Skip already processed fields
        }

        $sanitized_value = sanitizeInput($value);
        $field_values[$key] = $sanitized_value;

        // Map to legacy columns for compatibility
        if ($key === 'room_type' || $key === 'building_type' || $key === 'space_type' || $key === 'plan_type') {
            $room_type = $sanitized_value;
        } elseif ($key === 'style_preset') {
            $style_preset = $sanitized_value;
        } elseif ($key === 'quality') {
            $quality = $sanitized_value;
        }
    }

    // Convert field values to JSON for storage
    $field_values_json = json_encode($field_values);

    // Connect to database
    $mysqli = getDbConnection();

    // Insert into database with new schema
    $query = "INSERT INTO `o_results_ai`
              (`orf_id`, `model`, `product_type`, `room_type`, `style_preset`, `quality`, `additional_instructions`, `final_prompt`, `field_values`)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "issssssss", $orf_id, $model, $product_type, $room_type, $style_preset, $quality, $additional_instructions, $final_prompt, $field_values_json);

    if (!mysqli_stmt_execute($stmt)) {
        throw new Exception('Database insert failed: ' . mysqli_stmt_error($stmt));
    }

    $ai_record_id = mysqli_insert_id($mysqli);
    mysqli_stmt_close($stmt);

    // Get the image file path from o_results_files table
    $query = "SELECT `orf_compress_path` FROM `o_results` WHERE `orf_id` = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $orf_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $file_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$file_data) {
        throw new Exception('Image file not found for orf_id: ' . $orf_id);
    }

    $image_filename = $file_data['orf_compress_path'];

    if (!$image_filename) {
        throw new Exception('No valid image path found');
    }

    // Construct full image path
    $image_path = $_SERVER['DOCUMENT_ROOT'] . '/studio/result_compress_files/' . $image_filename;

    if (!file_exists($image_path)) {
        throw new Exception('Image file does not exist: ' . $image_filename);
    }

    // Prepare API call
    $api_url = 'https://api.blue7.it/api/generate/image';

    // Build multipart form data with image array syntax
    $post_data = [];

    // Add main image as image[0]
    $post_data['image[0]'] = new CURLFile($image_path, mime_content_type($image_path), basename($image_path));

    // Process reference images if provided
    $reference_index = 1;
    if (isset($_FILES['reference_images']) && !empty($_FILES['reference_images']['tmp_name'][0])) {
        $max_reference_images = 14;
        $allowed_types = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        $max_file_size = 10 * 1024 * 1024; // 10MB per file

        $reference_count = count($_FILES['reference_images']['tmp_name']);

        // Limit to max reference images
        if ($reference_count > $max_reference_images) {
            $reference_count = $max_reference_images;
        }

        for ($i = 0; $i < $reference_count; $i++) {
            $tmp_name = $_FILES['reference_images']['tmp_name'][$i];
            $file_type = $_FILES['reference_images']['type'][$i];
            $file_name = $_FILES['reference_images']['name'][$i];
            $file_size = $_FILES['reference_images']['size'][$i];
            $file_error = $_FILES['reference_images']['error'][$i];

            // Skip if empty or error
            if (empty($tmp_name) || $file_error !== UPLOAD_ERR_OK) {
                continue;
            }

            // Validate file type
            if (!in_array($file_type, $allowed_types)) {
                continue;
            }

            // Validate file size
            if ($file_size > $max_file_size) {
                continue;
            }

            // Add reference image to post data
            $post_data['image[' . $reference_index . ']'] = new CURLFile(
                $tmp_name,
                $file_type,
                $file_name
            );
            $reference_index++;
        }
    }

    // Add other form fields
    $post_data['prompt'] = $final_prompt;
    $post_data['size'] = $quality;
    $post_data['model'] = $model;

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 300); // 5 minute timeout

    // Execute API call
    $api_response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);

    if ($curl_error) {
        throw new Exception('API request failed: ' . $curl_error);
    }

    // Parse API response
    $api_data = json_decode($api_response, true);

    if ($http_code !== 200) {
        $error_message = $api_data['error'] ?? $api_data['message'] ?? 'Unknown API error';
        throw new Exception('API returned error: ' . $error_message);
    }

    if (!$api_data || !isset($api_data['success']) || !$api_data['success']) {
        throw new Exception('API generation failed: ' . ($api_data['error'] ?? 'Unknown error'));
    }

    // Update the database record with the generated image URL
    $generated_image_url = $api_data['data']['image_url'];

    // Create directory for AI thumbnails if it doesn't exist
    $thumbnailDir = $_SERVER['DOCUMENT_ROOT'] . '/studio/ai_thumbnails/';
    if (!is_dir($thumbnailDir)) {
        mkdir($thumbnailDir, 0755, true);
    }

    // Generate unique filename for thumbnail
    $thumbnailFilename = 'ai_' . $ai_record_id . '_' . time() . '.jpg';
    $thumbnailPath = $thumbnailDir . $thumbnailFilename;
    $thumbnailUrl = 'https://blue7.it/studio/ai_thumbnails/' . $thumbnailFilename;

    try {
        // Download the generated image temporarily
        $tempImagePath = $thumbnailDir . 'temp_' . $ai_record_id . '.jpg';
        downloadImage($generated_image_url, $tempImagePath);

        // Create thumbnail
        createThumbnail($tempImagePath, $thumbnailPath);

        // Remove temporary file
        unlink($tempImagePath);

    } catch (Exception $thumbnailError) {
        // Log error but don't fail the whole request
        error_log('Failed to create thumbnail: ' . $thumbnailError->getMessage());
        $thumbnailUrl = null;
    }

    $query = "UPDATE `o_results_ai` SET `generated_image_url` = ?, `thumbnail_url` = ? WHERE `orf_ai_id` = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "ssi", $generated_image_url, $thumbnailUrl, $ai_record_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_close($mysqli);

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Image generated successfully',
        'data' => [
            'ai_record_id' => $ai_record_id,
            'image_url' => $generated_image_url,
            'thumbnail_url' => $thumbnailUrl,
            'model' => $api_data['data']['model'],
            'size' => $api_data['data']['size'],
        ],
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to generate image',
        'error' => $e->getMessage(),
    ]);
}
