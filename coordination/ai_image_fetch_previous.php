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

try {
    // Verify request method
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request method');
    }

    // Validate required parameter
    if (!isset($_GET['orf_id']) || empty($_GET['orf_id'])) {
        throw new Exception('Missing required parameter: orf_id');
    }

    $orf_id = intval($_GET['orf_id']);

    // Connect to database
    $mysqli = getDbConnection();

    // Fetch all generated images for this orf_id
    $query = "SELECT `orf_ai_id`, `model`, `room_type`, `style_preset`, `quality`,
                     `additional_instructions`, `generated_image_url`, `thumbnail_url`, `saved_orf_id`, `created_at`
              FROM `o_results_ai`
              WHERE `orf_id` = ? AND `generated_image_url` IS NOT NULL
              ORDER BY `created_at` DESC";

    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $orf_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $images = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $images[] = [
            'id' => $row['orf_ai_id'],
            'image_url' => $row['generated_image_url'],
            'thumbnail_url' => $row['thumbnail_url'],
            'model' => $row['model'],
            'room_type' => $row['room_type'],
            'style_preset' => $row['style_preset'],
            'quality' => $row['quality'],
            'instructions' => $row['additional_instructions'],
            'saved_orf_id' => $row['saved_orf_id'],
            'created_at' => $row['created_at']
        ];
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    // Return success response
    echo json_encode([
        'success' => true,
        'data' => [
            'images' => $images,
            'count' => count($images)
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to fetch images',
        'error' => $e->getMessage()
    ]);
}
