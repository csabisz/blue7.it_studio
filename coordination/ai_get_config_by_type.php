<?php
/**
 * Get Configuration by Prompt Type ID API Endpoint
 *
 * Returns the prompt configuration for a given prompt_type_id.
 * Used by the URL-based AI image modal to load config dynamically
 * when user selects a prompt type from dropdown.
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

    // Check if prompt_type_id is provided
    if (!isset($_GET['prompt_type_id']) || empty($_GET['prompt_type_id'])) {
        throw new Exception('prompt_type_id parameter is required');
    }

    $prompt_type_id = intval($_GET['prompt_type_id']);

    // Get the configuration with session caching (5-minute TTL)
    $cache_key = "ai_config_type_{$prompt_type_id}";

    if (isset($_SESSION[$cache_key]) && isset($_SESSION[$cache_key]['cached_at']) && $_SESSION[$cache_key]['cached_at'] > (time() - 300)) {
        // Use cached config (5-minute cache)
        $result = $_SESSION[$cache_key];
        $product_type = $result['product_type'];
        $config = $result['config'];
        $base_prompt = $result['base_prompt'];
    } else {
        // Load from database
        $prompt_type = getPromptTypeById($prompt_type_id);

        if (!$prompt_type) {
            throw new Exception('Prompt type not found for ID: ' . $prompt_type_id);
        }

        $config = getProductTypeConfigById($prompt_type_id);
        $base_prompt = getBasePromptById($prompt_type_id);
        $product_type = $prompt_type['name'];

        // Cache in session
        $_SESSION[$cache_key] = [
            'product_type' => $product_type,
            'config' => $config,
            'base_prompt' => $base_prompt,
            'cached_at' => time()
        ];
    }

    if (!$config) {
        throw new Exception('Configuration not found for prompt type ID: ' . $prompt_type_id);
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
