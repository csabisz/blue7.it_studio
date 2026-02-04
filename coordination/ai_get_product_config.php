<?php
/**
 * Get Product Configuration API Endpoint
 *
 * Returns the product configuration for a given orf_id or product_type.
 * Uses direct product-to-prompt mapping via the ai_prompt_products junction table.
 * Used by the AI image generation modal to dynamically render form fields.
 */

session_start();
header('Content-Type: application/json');

// Include database configuration functions
require_once __DIR__ . '/ai_config/includes/config_functions.php';

try {
    // Verify request method
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request method');
    }

    $product_type = null;
    $prod_id = null;

    // Check if orf_id is provided
    if (isset($_GET['orf_id']) && !empty($_GET['orf_id'])) {
        $orf_id = intval($_GET['orf_id']);

        // Get prod_id from database
        $mysqli = getDbConnection();
        $query = "SELECT `prod_id` FROM `o_results` WHERE `orf_id` = ?";
        $stmt = mysqli_prepare($mysqli, $query);
        mysqli_stmt_bind_param($stmt, "i", $orf_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);

        if (!$row) {
            throw new Exception('Result not found for orf_id: ' . $orf_id);
        }

        $prod_id = $row['prod_id'];
    }
    // Check if product_type is directly provided (for backward compatibility)
    elseif (isset($_GET['product_type']) && !empty($_GET['product_type'])) {
        $product_type = trim($_GET['product_type']);
    }
    else {
        throw new Exception('Either orf_id or product_type parameter is required');
    }

    // Get the configuration with session caching (5-minute TTL)
    if ($prod_id) {
        // Use prod_id for direct lookup via junction table
        $cache_key = "ai_config_prod_{$prod_id}";

        if (isset($_SESSION[$cache_key]) && isset($_SESSION[$cache_key]['cached_at']) && $_SESSION[$cache_key]['cached_at'] > (time() - 300)) {
            // Use cached config (5-minute cache)
            $result = $_SESSION[$cache_key];
            $product_type = $result['product_type'];
            $config = $result['config'];
            $base_prompt = $result['base_prompt'];
        } else {
            // Load from database using junction table lookup
            $result = getProductConfiguration($prod_id);
            $product_type = $result['product_type'];
            $config = $result['config'];
            $base_prompt = $result['base_prompt'];

            // Cache in session
            $_SESSION[$cache_key] = array_merge($result, ['cached_at' => time()]);
        }
    } else {
        // Use product_type for lookup (backward compatibility for direct type_key access)
        $cache_key = "ai_config_{$product_type}";

        if (isset($_SESSION[$cache_key]) && isset($_SESSION[$cache_key]['cached_at']) && $_SESSION[$cache_key]['cached_at'] > (time() - 300)) {
            // Use cached config (5-minute cache)
            $config = $_SESSION[$cache_key]['config'];
            $base_prompt = $_SESSION[$cache_key]['base_prompt'];
        } else {
            // Load from database
            $config = getProductTypeConfigFromDB($product_type);
            $base_prompt = getBasePromptFromDB($product_type);

            // Cache in session
            $_SESSION[$cache_key] = [
                'config' => $config,
                'base_prompt' => $base_prompt,
                'cached_at' => time()
            ];
        }
    }

    if (!$config) {
        throw new Exception('Configuration not found for product type: ' . $product_type);
    }

    // Return success response
    echo json_encode([
        'success' => true,
        'data' => [
            'product_type' => $product_type,
            'config' => $config,
            'base_prompt' => $base_prompt,
        ],
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
    ]);
}