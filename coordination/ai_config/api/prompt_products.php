<?php
/**
 * Prompt Products API
 * Get and save product assignments for prompts
 *
 * GET: Get products for a prompt
 * POST: Save products for a prompt
 *
 * @package Blue7
 * @subpackage AI Config API
 */

header('Content-Type: application/json');

require_once __DIR__ . '/../includes/config_functions.php';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // GET: Get products for a prompt
        if (!isset($_GET['prompt_id'])) {
            throw new Exception('Missing prompt_id parameter');
        }

        $prompt_id = intval($_GET['prompt_id']);
        $prod_ids = getProductsForPrompt($prompt_id);

        echo json_encode([
            'success' => true,
            'data' => $prod_ids
        ]);

    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // POST: Save products for a prompt
        if (!isset($_POST['prompt_id'])) {
            throw new Exception('Missing prompt_id parameter');
        }

        $prompt_id = intval($_POST['prompt_id']);

        // Get prod_ids array (can be empty to clear all assignments)
        $prod_ids = [];
        if (isset($_POST['prod_ids']) && is_array($_POST['prod_ids'])) {
            // Sanitize each prod_id
            foreach ($_POST['prod_ids'] as $prod_id) {
                $sanitized = sanitizeInput($prod_id);
                if (!empty($sanitized)) {
                    $prod_ids[] = $sanitized;
                }
            }
        }

        // Save assignments
        savePromptProducts($prompt_id, $prod_ids);

        echo json_encode([
            'success' => true,
            'message' => 'Product assignments saved successfully',
            'count' => count($prod_ids)
        ]);

    } else {
        throw new Exception('Invalid request method');
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}