<?php
header('Content-Type: application/json');

try {
    // Verify request method
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request method');
    }

    // Validate required parameter
    if (!isset($_GET['url']) || empty($_GET['url'])) {
        throw new Exception('Missing required parameter: url');
    }

    $url = $_GET['url'];

    // Initialize cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);

    // Execute request
    curl_exec($ch);

    // Get content length
    $contentLength = curl_getinfo($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    if ($httpCode !== 200) {
        throw new Exception('Failed to fetch file information (HTTP ' . $httpCode . ')');
    }

    if ($contentLength <= 0) {
        throw new Exception('Unable to determine file size');
    }

    // Return success response
    echo json_encode([
        'success' => true,
        'data' => [
            'size' => (int)$contentLength
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to get file size',
        'error' => $e->getMessage()
    ]);
}
