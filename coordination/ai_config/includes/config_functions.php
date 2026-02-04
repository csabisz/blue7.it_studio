<?php
/**
 * AI Config Functions
 * Database CRUD operations for AI configuration management
 */

// Prevent direct access
if (!defined('AI_CONFIG_INCLUDED')) {
    define('AI_CONFIG_INCLUDED', true);
}

/**
 * Get database connection
 * Uses same credentials as other AI coordination files
 *
 * @return mysqli Database connection
 * @throws Exception if connection fails
 */
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

    // Set charset to UTF-8
    mysqli_set_charset($mysqli, 'utf8mb4');

    return $mysqli;
}

/**
 * Sanitize input string
 *
 * @param string $input Input string
 * @return string Sanitized string
 */
function sanitizeInput($input)
{
    return trim(stripslashes(htmlspecialchars($input)));
}

/**
 * Sanitize output string for HTML display
 *
 * @param string $text Text to sanitize
 * @return string Sanitized text
 */
function sanitizeOutput($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// ============================================================================
// PROMPT TYPE FUNCTIONS
// ============================================================================

/**
 * Get all prompt types
 *
 * @param bool $activeOnly If true, returns only active prompt types
 * @return array Array of prompt types
 * @throws Exception on database error
 */
function getAllPromptTypes(bool $activeOnly = true): array
{
    $mysqli = getDbConnection();

    $query = "SELECT * FROM `ai_prompt_types`";
    if ($activeOnly) {
        $query .= " WHERE `is_active` = 1";
    }
    $query .= " ORDER BY `display_order` ASC, `name` ASC";

    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        mysqli_close($mysqli);
        throw new Exception('Failed to fetch prompt types: ' . mysqli_error($mysqli));
    }

    $types = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $types[] = $row;
    }

    mysqli_close($mysqli);
    return $types;
}

/**
 * Get prompt type by ID
 *
 * @param int $id Prompt type ID
 * @return array|null Prompt type data or null if not found
 * @throws Exception on database error
 */
function getPromptTypeById($id)
{
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "SELECT * FROM `ai_prompt_types` WHERE `id` = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $type = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $type ?: null;
}

/**
 * Get prompt type by type_key
 *
 * @param string $type_key Prompt type key (e.g., 'interior_render')
 * @return array|null Prompt type data or null if not found
 * @throws Exception on database error
 */
/**
 * Create a new prompt type with initial base prompt
 *
 * @param array $data Prompt type data with keys:
 *   - type_key (required) - Unique identifier
 *   - name (required) - Display name
 *   - description (optional) - Description text
 *   - base_prompt_key (required) - Base prompt identifier
 *   - display_order (optional, auto-assigned if not provided)
 * @return array Created prompt type data with 'id', 'type_key', and 'prompt_id'
 * @throws Exception on database error
 */
function createPromptType($data)
{
    $mysqli = getDbConnection();

    // Start transaction - both type and initial prompt must succeed
    mysqli_begin_transaction($mysqli);

    try {
        // Get next display_order if not provided
        if (!isset($data['display_order'])) {
            $stmt = mysqli_prepare($mysqli, "
                SELECT MAX(display_order) as max_order
                FROM ai_prompt_types
            ");
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            $data['display_order'] = ($row['max_order'] ?? 0) + 1;
        }

        // Get created_by from session
        $created_by = getCurrentClientId();

        // Insert prompt type
        $stmt = mysqli_prepare($mysqli, "
            INSERT INTO ai_prompt_types
            (type_key, name, description, base_prompt_key, is_active, display_order, created_by, updated_by)
            VALUES (?, ?, ?, ?, 1, ?, ?, ?)
        ");

        mysqli_stmt_bind_param($stmt, "ssssiii",
            $data['type_key'],
            $data['name'],
            $data['description'],
            $data['base_prompt_key'],
            $data['display_order'],
            $created_by,
            $created_by
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Failed to insert prompt type: ' . mysqli_stmt_error($stmt));
        }

        $new_id = mysqli_insert_id($mysqli);
        mysqli_stmt_close($stmt);

        // Create initial base prompt (version 1)
        $initial_template = "[ADDITIONAL_INSTRUCTIONS]\n\nThis is a new prompt template. Please configure the fields and update this prompt.";

        $stmt = mysqli_prepare($mysqli, "
            INSERT INTO ai_base_prompts
            (prompt_type_id, prompt_template, version, is_active, change_summary, created_by)
            VALUES (?, ?, 1, 1, 'Initial prompt template', ?)
        ");

        mysqli_stmt_bind_param($stmt, "isi", $new_id, $initial_template, $created_by);

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception('Failed to create initial prompt: ' . mysqli_stmt_error($stmt));
        }

        $prompt_id = mysqli_insert_id($mysqli);
        mysqli_stmt_close($stmt);

        // Commit transaction
        mysqli_commit($mysqli);
        mysqli_close($mysqli);

        return [
            'id' => $new_id,
            'type_key' => $data['type_key'],
            'prompt_id' => $prompt_id
        ];

    } catch (Exception $e) {
        mysqli_rollback($mysqli);
        mysqli_close($mysqli);
        throw $e;
    }
}

// ============================================================================
// BASE PROMPT FUNCTIONS
// ============================================================================

/**
 * Get active base prompt for a prompt type by ID
 *
 * @param int $prompt_type_id Prompt type ID
 * @return string|null Prompt template or null if not found
 * @throws Exception on database error
 */
function getBasePromptById($prompt_type_id)
{
    $mysqli = getDbConnection();

    // Get active base prompt
    $stmt = mysqli_prepare($mysqli, "
        SELECT `prompt_template`
        FROM `ai_base_prompts`
        WHERE `prompt_type_id` = ? AND `is_active` = 1
        ORDER BY `version` DESC
        LIMIT 1
    ");
    mysqli_stmt_bind_param($stmt, "i", $prompt_type_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $prompt = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $prompt ? $prompt['prompt_template'] : null;
}

/**
 * Get all base prompts for a prompt type (including inactive versions)
 *
 * @param int $prompt_type_id Prompt type ID
 * @return array Array of base prompts ordered by version DESC
 * @throws Exception on database error
 */
function getAllBasePrompts($prompt_type_id)
{
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "
        SELECT * FROM `ai_base_prompts`
        WHERE `prompt_type_id` = ?
        ORDER BY `version` DESC
    ");
    mysqli_stmt_bind_param($stmt, "i", $prompt_type_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $prompts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $prompts[] = $row;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $prompts;
}

/**
 * Get current prompt version number
 *
 * @param int $prompt_type_id Prompt type ID
 * @return int Current version number
 * @throws Exception on database error
 */
function getCurrentPromptVersion($prompt_type_id)
{
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "
        SELECT `version` FROM `ai_base_prompts`
        WHERE `prompt_type_id` = ?
        ORDER BY `version` DESC
        LIMIT 1
    ");
    mysqli_stmt_bind_param($stmt, "i", $prompt_type_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $prompt = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $prompt ? intval($prompt['version']) : 0;
}

/**
 * Create new base prompt version
 *
 * @param int $prompt_type_id Prompt type ID
 * @param string $prompt_template Prompt template
 * @param string|null $change_summary Summary of changes
 * @param int|null $created_by Client ID of creator
 * @return array New prompt data with id and version
 * @throws Exception on database error
 */
function createNewPromptVersion($prompt_type_id, $prompt_template, $change_summary = null, $created_by = null)
{
    $mysqli = getDbConnection();

    // Start transaction
    mysqli_begin_transaction($mysqli);

    try {
        // Deactivate all previous versions
        $stmt = mysqli_prepare($mysqli, "
            UPDATE `ai_base_prompts`
            SET `is_active` = 0
            WHERE `prompt_type_id` = ?
        ");
        mysqli_stmt_bind_param($stmt, "i", $prompt_type_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Get next version number
        $next_version = getCurrentPromptVersion($prompt_type_id) + 1;

        // Insert new version
        $stmt = mysqli_prepare($mysqli, "
            INSERT INTO `ai_base_prompts`
            (`prompt_type_id`, `prompt_template`, `version`, `is_active`, `change_summary`, `created_by`)
            VALUES (?, ?, ?, 1, ?, ?)
        ");
        mysqli_stmt_bind_param($stmt, "isisi", $prompt_type_id, $prompt_template, $next_version, $change_summary, $created_by);
        mysqli_stmt_execute($stmt);

        $new_id = mysqli_insert_id($mysqli);

        mysqli_stmt_close($stmt);
        mysqli_commit($mysqli);
        mysqli_close($mysqli);

        return [
            'id' => $new_id,
            'version' => $next_version
        ];

    } catch (Exception $e) {
        mysqli_rollback($mysqli);
        mysqli_close($mysqli);
        throw $e;
    }
}

// ============================================================================
// FIELD CONFIG FUNCTIONS
// ============================================================================

/**
 * Get all field configs for a prompt type by ID
 *
 * @param int $prompt_type_id Prompt type ID
 * @param bool $activeOnly If true, returns only active fields
 * @return array Array of field configs with nested options
 * @throws Exception on database error
 */
function getFieldConfigsById($prompt_type_id, $activeOnly = true)
{
    $mysqli = getDbConnection();

    // Get fields
    $query = "
        SELECT * FROM `ai_field_configs`
        WHERE `prompt_type_id` = ?";
    if ($activeOnly) {
        $query .= " AND `is_active` = 1";
    }
    $query .= " ORDER BY `display_order` ASC";

    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $prompt_type_id);
    mysqli_stmt_execute($stmt);
    $fields_result = mysqli_stmt_get_result($stmt);

    $fields = [];
    while ($field = mysqli_fetch_assoc($fields_result)) {
        // Get options for this field if it's a select type
        if ($field['field_type'] === 'select') {
            $options_query = "
                SELECT * FROM `ai_field_options`
                WHERE `field_config_id` = ?";
            if ($activeOnly) {
                $options_query .= " AND `is_active` = 1";
            }
            $options_query .= " ORDER BY `display_order` ASC";

            $options_stmt = mysqli_prepare($mysqli, $options_query);
            mysqli_stmt_bind_param($options_stmt, "i", $field['id']);
            mysqli_stmt_execute($options_stmt);
            $options_result = mysqli_stmt_get_result($options_stmt);

            $options = [];
            while ($option = mysqli_fetch_assoc($options_result)) {
                $options[] = $option;
            }
            mysqli_stmt_close($options_stmt);

            $field['options'] = $options;
        } else {
            $field['options'] = [];
        }

        $fields[] = $field;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $fields;
}

/**
 * Get complete product type configuration from database by ID
 * Returns format compatible with existing ai_image_modal.php
 *
 * @param int $prompt_type_id Prompt type ID
 * @return array|null Configuration array or null if not found
 * @throws Exception on database error
 */
function getProductTypeConfigById($prompt_type_id)
{
    $type = getPromptTypeById($prompt_type_id);

    if (!$type) {
        return null;
    }

    $fields = getFieldConfigsById($prompt_type_id, true);

    // Transform to match existing config format
    $config_fields = [];
    foreach ($fields as $field) {
        $config_field = [
            'id' => $field['field_id'],
            'label' => $field['field_label'],
            'type' => $field['field_type'],
            'required' => (bool)$field['is_required']
        ];

        if ($field['placeholder']) {
            $config_field['placeholder'] = $field['placeholder'];
        }

        if ($field['help_text']) {
            $config_field['help_text'] = $field['help_text'];
        }

        if ($field['default_value']) {
            $config_field['defaultValue'] = $field['default_value'];
        }

        // Add options if present
        if (!empty($field['options'])) {
            $config_field['options'] = [];
            foreach ($field['options'] as $option) {
                $opt = [
                    'value' => $option['option_value'],
                    'label' => $option['option_label']
                ];

                if ($option['prompt_text']) {
                    $opt['prompt'] = $option['prompt_text'];
                }

                if ($option['room_restrictions']) {
                    $opt['rooms'] = $option['room_restrictions'];
                }

                $config_field['options'][] = $opt;
            }
        }

        $config_fields[] = $config_field;
    }

    return [
        'name' => $type['name'],
        'description' => $type['description'],
        'fields' => $config_fields
    ];
}

// ============================================================================
// CACHE FUNCTIONS
// ============================================================================

/**
 * Clear configuration cache for a product type by ID
 *
 * @param int $prompt_type_id Prompt type ID
 * @return void
 */
function clearConfigCacheById($prompt_type_id)
{
    if (!isset($_SESSION)) {
        session_start();
    }

    $cache_key = "ai_config_id_{$prompt_type_id}";
    if (isset($_SESSION[$cache_key])) {
        unset($_SESSION[$cache_key]);
    }
}

/**
 * Clear all AI config caches
 *
 * @return void
 */
function clearAllConfigCaches()
{
    if (!isset($_SESSION)) {
        session_start();
    }

    // Remove all session keys starting with ai_config_
    foreach (array_keys($_SESSION) as $key) {
        if (strpos($key, 'ai_config_') === 0) {
            unset($_SESSION[$key]);
        }
    }
}

// ============================================================================
// FIELD CONFIG CRUD OPERATIONS
// ============================================================================

/**
 * Get field config by ID
 *
 * @param int $config_id Field config ID
 * @return array|null Field config or null if not found
 * @throws Exception on database error
 */
function getFieldConfigById($config_id)
{
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "SELECT * FROM `ai_field_configs` WHERE `id` = ?");
    mysqli_stmt_bind_param($stmt, "i", $config_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $field = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $field ?: null;
}

/**
 * Get field options for a field config
 *
 * @param int $field_config_id Field config ID
 * @param bool $activeOnly If true, returns only active options
 * @return array Array of options
 * @throws Exception on database error
 */
function getFieldOptions($field_config_id, $activeOnly = true)
{
    $mysqli = getDbConnection();

    $query = "SELECT * FROM `ai_field_options` WHERE `field_config_id` = ?";
    if ($activeOnly) {
        $query .= " AND `is_active` = 1";
    }
    $query .= " ORDER BY `display_order` ASC";

    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $field_config_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $options = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $options[] = $row;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $options;
}

// ============================================================================
// HELPER FUNCTIONS
// ============================================================================

/**
 * Get client ID from session
 *
 * @return int|null Client ID or null if not logged in
 */
function getCurrentClientId()
{
    return isset($_COOKIE['client_id']) ? intval($_COOKIE['client_id']) : null;
}

/**
 * Get client IP address
 *
 * @return string IP address
 */
function getClientIpAddress()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

/**
 * Get user agent string
 *
 * @return string User agent (truncated to 255 chars)
 */
function getUserAgent()
{
    return substr($_SERVER['HTTP_USER_AGENT'], 0, 255);
}

// ============================================================================
// PROMPT-PRODUCT MAPPING FUNCTIONS
// ============================================================================

/**
 * Get all products from products table
 *
 * @return array Array of products with prod_id and prod_name
 * @throws Exception on database error
 */
function getAllProducts()
{
    $mysqli = getDbConnection();

    $query = "SELECT prod_id, prod_name FROM products ORDER BY prod_id ASC";
    $result = mysqli_query($mysqli, $query);

    if (!$result) {
        mysqli_close($mysqli);
        throw new Exception('Failed to fetch products: ' . mysqli_error($mysqli));
    }

    $products = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    mysqli_close($mysqli);
    return $products;
}

/**
 * Get products assigned to a specific prompt
 *
 * @param int $prompt_id Prompt ID
 * @return array Array of prod_ids
 * @throws Exception on database error
 */
function getProductsForPrompt($prompt_id)
{
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "SELECT prod_id FROM ai_prompt_products WHERE prompt_id = ? ORDER BY prod_id ASC");
    mysqli_stmt_bind_param($stmt, "i", $prompt_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $prod_ids = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $prod_ids[] = $row['prod_id'];
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $prod_ids;
}

/**
 * Save product assignments for a prompt
 * Replaces all existing assignments
 *
 * @param int $prompt_id Prompt ID
 * @param array $prod_ids Array of prod_ids to assign
 * @return bool Success
 * @throws Exception on database error
 */
function savePromptProducts($prompt_id, $prod_ids)
{
    $mysqli = getDbConnection();

    // Start transaction
    mysqli_begin_transaction($mysqli);

    try {
        // Delete existing assignments
        $stmt = mysqli_prepare($mysqli, "DELETE FROM ai_prompt_products WHERE prompt_id = ?");
        mysqli_stmt_bind_param($stmt, "i", $prompt_id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Insert new assignments
        if (!empty($prod_ids)) {
            $stmt = mysqli_prepare($mysqli, "INSERT INTO ai_prompt_products (prompt_id, prod_id) VALUES (?, ?)");

            foreach ($prod_ids as $prod_id) {
                mysqli_stmt_bind_param($stmt, "is", $prompt_id, $prod_id);
                mysqli_stmt_execute($stmt);
            }

            mysqli_stmt_close($stmt);
        }

        mysqli_commit($mysqli);
        mysqli_close($mysqli);

        return true;

    } catch (Exception $e) {
        mysqli_rollback($mysqli);
        mysqli_close($mysqli);
        throw $e;
    }
}

/**
 * Get all active prompts for a specific product
 *
 * @param string $prod_id Product ID
 * @return array Array of prompt data
 * @throws Exception on database error
 */
function getPromptsForProduct($prod_id)
{
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "
        SELECT bp.*, pt.name as prompt_type_name
        FROM ai_prompt_products pp
        JOIN ai_base_prompts bp ON pp.prompt_id = bp.id
        JOIN ai_prompt_types pt ON bp.prompt_type_id = pt.id
        WHERE pp.prod_id = ? AND bp.is_active = 1
        ORDER BY bp.version DESC
    ");
    mysqli_stmt_bind_param($stmt, "s", $prod_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $prompts = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $prompts[] = $row;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $prompts;
}

/**
 * Check if a product has any prompt assigned
 *
 * @param string $prod_id Product ID
 * @return bool True if product has at least one active prompt assigned
 */
function hasPromptForProduct(string $prod_id): bool
{
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "
        SELECT COUNT(*) as count
        FROM ai_prompt_products pp
        JOIN ai_base_prompts bp ON pp.prompt_id = bp.id
        WHERE pp.prod_id = ? AND bp.is_active = 1
    ");

    mysqli_stmt_bind_param($stmt, "s", $prod_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $row['count'] > 0;
}

/**
 * Get active base prompt for a product ID
 * Replaces the old range-based lookup
 *
 * @param string $prod_id Product ID (e.g., 'p_1523')
 * @return string|null Prompt template or null if not found
 * @throws Exception on database error
 */
function getBasePromptForProduct($prod_id)
{
    $prompts = getPromptsForProduct($prod_id);

    if (empty($prompts)) {
        return null;
    }

    // Return the first (highest version) prompt
    return $prompts[0]['prompt_template'];
}

/**
 * Get configuration for a product by prod_id
 * Uses direct product-to-prompt assignment via junction table
 *
 * @param string $prod_id Product ID (e.g., 'p1523')
 * @return array|null Configuration with product_type, config, and base_prompt
 * @throws Exception on database error or if product has no assigned prompt
 */
function getProductConfiguration($prod_id)
{
    $prompts = getPromptsForProduct($prod_id);

    if (empty($prompts)) {
        throw new Exception("No prompt assigned to product: {$prod_id}. Please assign a prompt in the AI Config panel.");
    }

    // Product has direct prompt assignment
    $prompt = $prompts[0]; // Get highest version
    $prompt_type_id = $prompt['prompt_type_id'];

    // Get field configuration for this product type
    $config = getProductTypeConfigById($prompt_type_id);

    return [
        'product_type' => $prompt['prompt_type_name'],
        'prompt_type_id' => $prompt_type_id,
        'config' => $config,
        'base_prompt' => $prompt['prompt_template']
    ];
}
