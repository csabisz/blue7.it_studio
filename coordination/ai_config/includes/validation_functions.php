<?php
/**
 * AI Config Validation Functions
 * Input validation and prompt template validation
 */

// Require config functions
require_once __DIR__ . '/config_functions.php';

/**
 * Validate prompt template
 * Checks for required variables based on field configurations
 *
 * @param int $prompt_type_id Product type ID
 * @param string $prompt_template Prompt template to validate
 * @return array Validation result with 'valid', 'missing_variables', and 'unused_variables'
 * @throws Exception on database error
 */
function validatePromptTemplate($prompt_type_id, $prompt_template)
{
    // Get product type
    $type = getPromptTypeById($prompt_type_id);
    if (!$type) {
        throw new Exception('Product type not found');
    }

    // Get field configs for this product type
    $fields = getFieldConfigsById($prompt_type_id, true);

    // Build list of required variables
    $required_vars = [];
    foreach ($fields as $field) {
        // Convert field_id to uppercase for variable name
        $var_name = strtoupper($field['field_id']);
        $required_vars[] = $var_name;
    }

    // Add ADDITIONAL_INSTRUCTIONS as it's a shared field
    $required_vars[] = 'ADDITIONAL_INSTRUCTIONS';

    // Extract all [VARIABLE] placeholders from template
    preg_match_all('/\[([A-Z_]+)\]/', $prompt_template, $matches);
    $used_vars = array_unique($matches[1]);

    // Find missing required variables
    $missing = array_diff($required_vars, $used_vars);

    // Find variables used but not in field configs (not necessarily an error)
    $unused = array_diff($used_vars, $required_vars);

    return [
        'valid' => empty($missing),
        'missing_variables' => array_values($missing),
        'unused_variables' => array_values($unused)
    ];
}

/**
 * Validate field ID format
 * Must be alphanumeric with underscores only
 *
 * @param string $field_id Field ID to validate
 * @return bool True if valid, false otherwise
 */
function validateFieldId($field_id)
{
    return preg_match('/^[a-z0-9_]+$/i', $field_id) === 1;
}

/**
 * Validate option value format
 * Must be alphanumeric with hyphens and underscores only
 *
 * @param string $option_value Option value to validate
 * @return bool True if valid, false otherwise
 */
function validateOptionValue($option_value)
{
    return preg_match('/^[a-z0-9_-]+$/i', $option_value) === 1;
}

/**
 * Validate field type
 *
 * @param string $field_type Field type to validate
 * @return bool True if valid, false otherwise
 */
function validateFieldType($field_type)
{
    $valid_types = ['select', 'textarea', 'checkbox', 'text'];
    return in_array($field_type, $valid_types);
}

/**
 * Validate product type key format
 *
 * @param string $type_key Product type key to validate
 * @return bool True if valid, false otherwise
 */
function validateTypeKey($type_key)
{
    return preg_match('/^[a-z0-9_]+$/i', $type_key) === 1;
}

/**
 * Validate email address
 *
 * @param string $email Email address to validate
 * @return bool True if valid, false otherwise
 */
function validateEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate required fields for product type creation
 *
 * @param array $data Product type data
 * @return array Validation errors (empty if valid)
 */
function validateProductTypeData($data)
{
    $errors = [];

    // Required fields
    if (empty($data['type_key'])) {
        $errors['type_key'] = 'Type key is required';
    } elseif (!validateTypeKey($data['type_key'])) {
        $errors['type_key'] = 'Type key must be alphanumeric with underscores only';
    }

    if (empty($data['name'])) {
        $errors['name'] = 'Name is required';
    } elseif (strlen($data['name']) > 100) {
        $errors['name'] = 'Name must be 100 characters or less';
    }

    if (empty($data['base_prompt_key'])) {
        $errors['base_prompt_key'] = 'Base prompt key is required';
    } elseif (!validateTypeKey($data['base_prompt_key'])) {
        $errors['base_prompt_key'] = 'Base prompt key must be alphanumeric with underscores only';
    }

    // Optional fields with length validation
    if (isset($data['description']) && strlen($data['description']) > 5000) {
        $errors['description'] = 'Description must be 5000 characters or less';
    }

    return $errors;
}

/**
 * Validate required fields for base prompt creation/update
 *
 * @param array $data Base prompt data
 * @return array Validation errors (empty if valid)
 */
function validateBasePromptData($data)
{
    $errors = [];

    // Required fields
    if (empty($data['prompt_type_id'])) {
        $errors['prompt_type_id'] = 'Product type ID is required';
    }

    if (empty($data['prompt_template'])) {
        $errors['prompt_template'] = 'Prompt template is required';
    } elseif (strlen($data['prompt_template']) < 50) {
        $errors['prompt_template'] = 'Prompt template must be at least 50 characters';
    } elseif (strlen($data['prompt_template']) > 50000) {
        $errors['prompt_template'] = 'Prompt template must be 50,000 characters or less';
    } else {
        // Check if it contains at least one variable
        if (!preg_match('/\[[A-Z_]+\]/', $data['prompt_template'])) {
            $errors['prompt_template'] = 'Prompt template must contain at least one [VARIABLE] placeholder';
        }
    }

    // Optional fields with length validation
    if (isset($data['change_summary']) && strlen($data['change_summary']) > 255) {
        $errors['change_summary'] = 'Change summary must be 255 characters or less';
    }

    return $errors;
}

/**
 * Validate required fields for field config creation/update
 *
 * @param array $data Field config data
 * @return array Validation errors (empty if valid)
 */
function validateFieldConfigData($data)
{
    $errors = [];

    // Required fields
    if (empty($data['prompt_type_id'])) {
        $errors['prompt_type_id'] = 'Product type ID is required';
    }

    if (empty($data['field_id'])) {
        $errors['field_id'] = 'Field ID is required';
    } elseif (!validateFieldId($data['field_id'])) {
        $errors['field_id'] = 'Field ID must be alphanumeric with underscores only';
    } elseif (strlen($data['field_id']) > 50) {
        $errors['field_id'] = 'Field ID must be 50 characters or less';
    }

    if (empty($data['field_label'])) {
        $errors['field_label'] = 'Field label is required';
    } elseif (strlen($data['field_label']) > 100) {
        $errors['field_label'] = 'Field label must be 100 characters or less';
    }

    if (empty($data['field_type'])) {
        $errors['field_type'] = 'Field type is required';
    } elseif (!validateFieldType($data['field_type'])) {
        $errors['field_type'] = 'Invalid field type. Must be: select, textarea, checkbox, or text';
    }

    // Optional fields with length validation
    if (isset($data['placeholder']) && strlen($data['placeholder']) > 255) {
        $errors['placeholder'] = 'Placeholder must be 255 characters or less';
    }

    if (isset($data['help_text']) && strlen($data['help_text']) > 5000) {
        $errors['help_text'] = 'Help text must be 5000 characters or less';
    }

    if (isset($data['default_value']) && strlen($data['default_value']) > 255) {
        $errors['default_value'] = 'Default value must be 255 characters or less';
    }

    // Validate validation_rules if provided (must be valid JSON)
    if (isset($data['validation_rules']) && !empty($data['validation_rules'])) {
        json_decode($data['validation_rules']);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $errors['validation_rules'] = 'Validation rules must be valid JSON';
        }
    }

    return $errors;
}

/**
 * Validate reference image file upload
 *
 * @param array $file $_FILES array element for the uploaded file
 * @return array Result with 'valid' boolean and 'error' message if invalid
 */
function validateReferenceImage($file)
{
    // Maximum file size: 5MB
    $max_size = 5 * 1024 * 1024;

    // Allowed MIME types
    $allowed_types = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    // Allowed extensions
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp'];

    // Check file size
    if ($file['size'] > $max_size) {
        return [
            'valid' => false,
            'error' => 'File size exceeds maximum limit of 5MB'
        ];
    }

    // Check MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime_type, $allowed_types)) {
        return [
            'valid' => false,
            'error' => 'Invalid file type. Allowed types: JPEG, PNG, WebP'
        ];
    }

    // Check extension
    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowed_extensions)) {
        return [
            'valid' => false,
            'error' => 'Invalid file extension. Allowed: jpg, jpeg, png, webp'
        ];
    }

    return ['valid' => true];
}

/**
 * Validate required fields for field option creation/update
 *
 * @param array $data Field option data
 * @return array Validation errors (empty if valid)
 */
function validateFieldOptionData($data)
{
    $errors = [];

    // Required fields
    if (empty($data['field_config_id'])) {
        $errors['field_config_id'] = 'Field config ID is required';
    }

    if (empty($data['option_value'])) {
        $errors['option_value'] = 'Option value is required';
    } elseif (!validateOptionValue($data['option_value'])) {
        $errors['option_value'] = 'Option value must be alphanumeric with hyphens and underscores only';
    } elseif (strlen($data['option_value']) > 100) {
        $errors['option_value'] = 'Option value must be 100 characters or less';
    }

    if (empty($data['option_label'])) {
        $errors['option_label'] = 'Option label is required';
    } elseif (strlen($data['option_label']) > 100) {
        $errors['option_label'] = 'Option label must be 100 characters or less';
    }

    // Optional fields with length validation
    if (isset($data['prompt_text']) && strlen($data['prompt_text']) > 10000) {
        $errors['prompt_text'] = 'Prompt text must be 10,000 characters or less';
    }

    if (isset($data['room_restrictions']) && strlen($data['room_restrictions']) > 255) {
        $errors['room_restrictions'] = 'Room restrictions must be 255 characters or less';
    }

    return $errors;
}

/**
 * Check if field ID is unique within a product type
 *
 * @param int $prompt_type_id Product type ID
 * @param string $field_id Field ID to check
 * @param int|null $exclude_config_id Config ID to exclude from check (for updates)
 * @return bool True if unique, false if already exists
 * @throws Exception on database error
 */
function isFieldIdUnique($prompt_type_id, $field_id, $exclude_config_id = null)
{
    $mysqli = getDbConnection();

    $query = "SELECT COUNT(*) as count FROM `ai_field_configs` WHERE `prompt_type_id` = ? AND `field_id` = ?";
    if ($exclude_config_id !== null) {
        $query .= " AND `id` != ?";
    }

    $stmt = mysqli_prepare($mysqli, $query);

    if ($exclude_config_id !== null) {
        mysqli_stmt_bind_param($stmt, "isi", $prompt_type_id, $field_id, $exclude_config_id);
    } else {
        mysqli_stmt_bind_param($stmt, "is", $prompt_type_id, $field_id);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return intval($row['count']) === 0;
}

/**
 * Check if type key is unique
 *
 * @param string $type_key Type key to check
 * @param int|null $exclude_id Product type ID to exclude from check (for updates)
 * @return bool True if unique, false if already exists
 * @throws Exception on database error
 */
function isTypeKeyUnique($type_key, $exclude_id = null)
{
    $mysqli = getDbConnection();

    $query = "SELECT COUNT(*) as count FROM `ai_prompt_types` WHERE `type_key` = ?";
    if ($exclude_id !== null) {
        $query .= " AND `id` != ?";
    }

    $stmt = mysqli_prepare($mysqli, $query);

    if ($exclude_id !== null) {
        mysqli_stmt_bind_param($stmt, "si", $type_key, $exclude_id);
    } else {
        mysqli_stmt_bind_param($stmt, "s", $type_key);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return intval($row['count']) === 0;
}

/**
 * Sanitize and validate JSON data
 *
 * @param string $json JSON string
 * @return array|null Decoded array or null if invalid
 */
function sanitizeJsonData($json)
{
    $data = json_decode($json, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return null;
    }

    return $data;
}
