<?php
session_start();
header('Content-Type: application/json');

// Include required files
include('../functions.php');

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

function createCompressed($sourcePath, $destinationPath, $prodId)
{
    list($width, $height, $type) = getimagesize($sourcePath);

    // Default scaling logic (fit to 1920x1080)
    $firstDivider = $width / 3840;
    $secondDivider = $height / 1920;
    $newDivider = max($firstDivider, $secondDivider);

    // $desiredWidth = floor($width / $newDivider);
    // $desiredHeight = floor($height / $newDivider);

    $desiredWidth = $width;
    $desiredHeight = $height;

    // Create image resource
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
            throw new Exception('Unsupported image type for compression');
    }

    // Create new image
    $compressed = imagecreatetruecolor($desiredWidth, $desiredHeight);

    // Handle transparency for PNG
    if ($type === IMAGETYPE_PNG) {
        imagealphablending($compressed, false);
        imagesavealpha($compressed, true);
        $transparent = imagecolorallocatealpha($compressed, 255, 255, 255, 127);
        imagefilledrectangle($compressed, 0, 0, $desiredWidth, $desiredHeight, $transparent);
    }

    // Resample
    imagecopyresampled($compressed, $source, 0, 0, 0, 0, $desiredWidth, $desiredHeight, $width, $height);

    // Save based on type
    switch ($type) {
        case IMAGETYPE_JPEG:
            imageinterlace($compressed, 1);
            imageresolution($compressed, 72, 72);
            imagejpeg($compressed, $destinationPath, 90);
            break;
        case IMAGETYPE_PNG:
            imagepng($compressed, $destinationPath, 8);
            break;
        case IMAGETYPE_GIF:
            imagegif($compressed, $destinationPath);
            break;
    }

    imagedestroy($source);
    imagedestroy($compressed);

    return true;
}

try {
    // Verify request method
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Validate required parameter
    if (!isset($_POST['orf_ai_id']) || empty($_POST['orf_ai_id'])) {
        throw new Exception('Missing required parameter: orf_ai_id');
    }

    $orf_ai_id = intval($_POST['orf_ai_id']);

    // Get additional fields
    $id_extension = isset($_POST['id_extension']) ? trim($_POST['id_extension']) : 'ai_generated';
    $presentation_name = isset($_POST['presentation_name']) ? trim($_POST['presentation_name']) : 'AI Generated';

    // Connect to database
    $mysqli = getDbConnection();

    // Get AI generation record
    $query = "SELECT * FROM `o_results_ai` WHERE `orf_ai_id` = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $orf_ai_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $aiRecord = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$aiRecord) {
        throw new Exception('AI generation record not found');
    }

    // Check if already saved
    if ($aiRecord['saved_orf_id']) {
        throw new Exception('This image has already been saved to the task');
    }

    // Get original file record to retrieve order details
    $query = "SELECT * FROM `o_results` WHERE `orf_id` = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $aiRecord['orf_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $originalFile = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$originalFile) {
        throw new Exception('Original file record not found');
    }

    // Extract order details
    $o_id = $originalFile['o_id'];
    $om_id = $originalFile['om_id'];
    $osub_id = $originalFile['osub_id'];
    $prod_id = $originalFile['prod_id'];
    $uca_id = isset($_COOKIE['uca_id']) ? intval($_COOKIE['uca_id']) : $originalFile['uca_id'];

    // Generate unique internal filename
    $internalName = sha1(uniqid(mt_rand(), true));
    $extension = 'jpg'; // AI generated images are typically JPG

    // Create directory structure
    $year = date('Y');
    $baseDir = $o_id . '.' . $osub_id . '.' . $prod_id;

    $resultDir = $_SERVER['DOCUMENT_ROOT'] . '/studio/result_files/' . $year . '/' . $o_id . '/' . $baseDir . '/';
    $thumbnailDir = $_SERVER['DOCUMENT_ROOT'] . '/studio/result_thumbnail_files/' . $year . '/' . $o_id . '/' . $baseDir . '/';
    $compressDir = $_SERVER['DOCUMENT_ROOT'] . '/studio/result_compress_files/' . $year . '/' . $o_id . '/' . $baseDir . '/';

    // Create directories if they don't exist
    if (!is_dir($resultDir)) {
        mkdir($resultDir, 0755, true);
    }
    if (!is_dir($thumbnailDir)) {
        mkdir($thumbnailDir, 0755, true);
    }
    if (!is_dir($compressDir)) {
        mkdir($compressDir, 0755, true);
    }

    // File paths
    $originalPath = $resultDir . $internalName . '.' . $extension;
    $thumbnailPath = $thumbnailDir . $internalName . '_thumb.' . $extension;
    $compressPath = $compressDir . $internalName . '_compress.' . $extension;

    // Download the AI-generated image
    downloadImage($aiRecord['generated_image_url'], $originalPath);

    // Generate thumbnail
    createThumbnail($originalPath, $thumbnailPath);

    // Generate compressed version
    createCompressed($originalPath, $compressPath, $prod_id);

    // Construct display filename with presentation_name replacing "AI Generated"
    if ($om_id == 0) {
        $orfName = $o_id . '.' . $osub_id . '.' . $prod_id . ' - ' . $id_extension . '.' . $extension;
    } else {
        $orfName = $om_id . '.' . $osub_id . '.' . $prod_id . '.' . $o_id . ' - ' . $id_extension . '.' . $extension;
    }

    // Prepare relative paths for database
    $relativePath = $year . '/' . $o_id . '/' . $baseDir . '/';
    $thumbnailRelativePath = $relativePath . $internalName . '_thumb.' . $extension;
    $compressRelativePath = $relativePath . $internalName . '_compress.' . $extension;

    // Prepare data for database insertion
    $data = array(
        'o_id' => $o_id,
        'om_id' => $om_id,
        'osub_id' => $osub_id,
        'prod_id' => $prod_id,
        'uca_id' => $uca_id,
        'pict_categ_name' => $presentation_name,
        'orf_name' => $orfName,
        'orf_internal_name_dom' => $internalName . '.' . $extension,
        'orf_type_dom' => $extension,
        'orf_path_dom' => $relativePath,
        'orf_thumbnail_path' => $thumbnailRelativePath,
        'orf_compress_path' => $compressRelativePath,
        'orf_upload_date' => gmdate("Y-m-d H:i:s"),
        'orf_status' => 8
    );

    // Insert into o_results table using existing function
    $prod = new Production;
    $jsonData = json_encode($data);
    $prod->upload_creator_result_file3($jsonData);

    // Query for the newly inserted record since upload_creator_result_file3 uses its own connection
    $query = "SELECT `orf_id` FROM `o_results`
              WHERE `orf_internal_name_dom` = ?
              ORDER BY `orf_id` DESC LIMIT 1";
    $stmt = mysqli_prepare($mysqli, $query);
    $internalFilename = $internalName . '.' . $extension;
    mysqli_stmt_bind_param($stmt, "s", $internalFilename);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $newRecord = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$newRecord) {
        throw new Exception('Failed to retrieve newly created file record');
    }

    $newOrfId = $newRecord['orf_id'];

    // Update o_results_ai with the saved_orf_id
    $query = "UPDATE `o_results_ai` SET `saved_orf_id` = ? WHERE `orf_ai_id` = ?";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "ii", $newOrfId, $orf_ai_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    mysqli_close($mysqli);

    // Return success response
    echo json_encode([
        'success' => true,
        'message' => 'Image saved to task successfully',
        'data' => [
            'orf_id' => $newOrfId,
            'filename' => $orfName,
            'thumbnail_url' => 'https://blue7.it/studio/result_thumbnail_files/' . $thumbnailRelativePath
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to save image to task',
        'error' => $e->getMessage()
    ]);
}