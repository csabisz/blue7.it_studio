<?php
/**
 * Get All Products API
 * Returns list of all products for selection
 *
 * @package Blue7
 * @subpackage AI Config API
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../includes/config_functions.php';

try {
    // Get all products
    $products = getAllProducts();

    echo json_encode([
        'success' => true,
        'data' => $products,
        'count' => count($products)
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}