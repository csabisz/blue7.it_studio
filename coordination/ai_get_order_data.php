<?php
/**
 * AI Get Order Data API
 *
 * Fetches sub IDs and product IDs for a given order ID.
 * Used for dynamically populating Save to Task form dropdowns.
 *
 * Parameters:
 *   - o_id (required): The order ID to fetch data for
 *   - sub_id (optional): The sub ID to filter products by (products are unique per order+sub_id)
 *
 * Returns JSON:
 *   {
 *     "success": true,
 *     "data": {
 *       "sub_ids": ["n01", "n02", ...],
 *       "products": ["p1523", "p1524", ...]
 *     }
 *   }
 */

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
    if (!isset($_GET['o_id']) || empty($_GET['o_id'])) {
        throw new Exception('Missing required parameter: o_id');
    }

    $o_id = intval($_GET['o_id']);
    $sub_id = isset($_GET['sub_id']) && !empty($_GET['sub_id']) ? trim($_GET['sub_id']) : null;

    if ($o_id <= 0) {
        throw new Exception('Invalid order ID');
    }

    // Connect to database
    $mysqli = getDbConnection();

    // Fetch sub IDs from orders_subnames table
    $query = "SELECT o_sub_id FROM orders_subnames WHERE o_id = ? ORDER BY o_sub_id ASC";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $o_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $subIds = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $subIds[] = $row['o_sub_id'];
    }
    mysqli_stmt_close($stmt);

    // Fetch product IDs from o_prods table
    // If sub_id is provided, filter by both o_id and osub_id
    $products = [];
    if ($sub_id) {
        $query = "SELECT DISTINCT prod_id FROM o_prods WHERE o_id = ? AND osub_id = ? ORDER BY prod_id ASC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "is", $o_id, $sub_id);
    } else {
        $query = "SELECT DISTINCT prod_id FROM o_prods WHERE o_id = ? ORDER BY prod_id ASC";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $o_id);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row['prod_id'];
    }
    mysqli_stmt_close($stmt);

    mysqli_close($mysqli);

    // Return success response
    echo json_encode([
        'success' => true,
        'data' => [
            'sub_ids' => $subIds,
            'products' => $products
        ]
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
