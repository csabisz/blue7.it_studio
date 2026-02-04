<?php
/**
 * AI Config History Functions
 * Audit trail and version control operations
 */

// Require config functions
require_once __DIR__ . '/config_functions.php';

/**
 * Log a configuration change to history
 *
 * @param string $entity_type Entity type: product_type, base_prompt, field_config, field_option
 * @param int $entity_id ID of the modified record
 * @param string $action Action: create, update, delete, restore
 * @param array|null $old_values Associative array of old values
 * @param array|null $new_values Associative array of new values
 * @param string|null $description Brief description of the change
 * @return int History record ID
 * @throws Exception on database error
 */
function logConfigChange($entity_type, $entity_id, $action, $old_values = null, $new_values = null, $description = null)
{
    $mysqli = getDbConnection();

    // Get change metadata
    $changed_by = getCurrentClientId();
    $ip_address = getClientIpAddress();
    $user_agent = getUserAgent();

    // Encode values as JSON
    $old_json = $old_values ? json_encode($old_values) : null;
    $new_json = $new_values ? json_encode($new_values) : null;

    // Insert history record
    $stmt = mysqli_prepare($mysqli, "
        INSERT INTO `ai_config_history`
        (`entity_type`, `entity_id`, `action`, `old_values`, `new_values`, `change_description`, `changed_by`, `ip_address`, `user_agent`)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    mysqli_stmt_bind_param($stmt, "sissssiss",
        $entity_type,
        $entity_id,
        $action,
        $old_json,
        $new_json,
        $description,
        $changed_by,
        $ip_address,
        $user_agent
    );

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_close($mysqli);
        throw new Exception('Failed to log config change: ' . mysqli_stmt_error($stmt));
    }

    $history_id = mysqli_insert_id($mysqli);

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $history_id;
}

/**
 * Get change history for a product type
 * Returns all changes related to the product type and its fields/prompts
 *
 * @param int $prompt_type_id Prompt type ID
 * @param int $limit Number of records to return (default: 50)
 * @param int $offset Offset for pagination (default: 0)
 * @return array Array of history records with user info
 * @throws Exception on database error
 */
function getConfigHistory($prompt_type_id, $limit = 50, $offset = 0)
{
    $mysqli = getDbConnection();

    // Build query to get history for:
    // 1. The product type itself
    // 2. Base prompts for this product type
    // 3. Field configs for this product type
    // 4. Field options for field configs of this product type

    $query = "
        SELECT
            h.*,
            c.u_name as user_name,
            c.u_surname as user_surname,
            c.email as user_email
        FROM `ai_config_history` h
        LEFT JOIN `u_clients` c ON h.changed_by = c.client_ID
        WHERE (
            (h.entity_type = 'product_type' AND h.entity_id = ?)
            OR (h.entity_type = 'base_prompt' AND h.entity_id IN (
                SELECT id FROM ai_base_prompts WHERE prompt_type_id = ?
            ))
            OR (h.entity_type = 'field_config' AND h.entity_id IN (
                SELECT id FROM ai_field_configs WHERE prompt_type_id = ?
            ))
            OR (h.entity_type = 'field_option' AND h.entity_id IN (
                SELECT o.id
                FROM ai_field_options o
                INNER JOIN ai_field_configs f ON o.field_config_id = f.id
                WHERE f.prompt_type_id = ?
            ))
        )
        ORDER BY h.changed_at DESC
        LIMIT ? OFFSET ?
    ";

    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "iiiiii", $prompt_type_id, $prompt_type_id, $prompt_type_id, $prompt_type_id, $limit, $offset);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $history = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Decode JSON values
        if ($row['old_values']) {
            $row['old_values'] = json_decode($row['old_values'], true);
        }
        if ($row['new_values']) {
            $row['new_values'] = json_decode($row['new_values'], true);
        }

        $history[] = $row;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $history;
}

/**
 * Get single history record by ID
 *
 * @param int $history_id History record ID
 * @return array|null History record or null if not found
 * @throws Exception on database error
 */
function getHistoryRecord($history_id)
{
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "
        SELECT
            h.*,
            c.u_name as user_name,
            c.u_surname as user_surname,
            c.email as user_email
        FROM `ai_config_history` h
        LEFT JOIN `u_clients` c ON h.changed_by = c.client_ID
        WHERE h.id = ?
    ");
    mysqli_stmt_bind_param($stmt, "i", $history_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $record = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    if (!$record) {
        return null;
    }

    // Decode JSON values
    if ($record['old_values']) {
        $record['old_values'] = json_decode($record['old_values'], true);
    }
    if ($record['new_values']) {
        $record['new_values'] = json_decode($record['new_values'], true);
    }

    return $record;
}

/**
 * Restore a base prompt to a previous version
 *
 * @param int $history_id History record ID containing the version to restore
 * @return array New prompt data with id and version
 * @throws Exception on database error or if restore fails
 */
function restorePromptVersion($history_id)
{
    $history = getHistoryRecord($history_id);

    if (!$history) {
        throw new Exception('History record not found');
    }

    if ($history['entity_type'] !== 'base_prompt') {
        throw new Exception('History record is not a base prompt change');
    }

    if (!isset($history['old_values']['template'])) {
        throw new Exception('No template found in history record');
    }

    $mysqli = getDbConnection();

    // Get prompt_type_id from the entity_id (which is the prompt ID)
    $stmt = mysqli_prepare($mysqli, "SELECT `prompt_type_id` FROM `ai_base_prompts` WHERE `id` = ?");
    mysqli_stmt_bind_param($stmt, "i", $history['entity_id']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $prompt = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    if (!$prompt) {
        throw new Exception('Original prompt not found');
    }

    // Create new version with old content
    $restored_template = $history['old_values']['template'];
    $change_summary = "Restored from version at " . $history['changed_at'];
    $created_by = getCurrentClientId();

    $new_prompt = createNewPromptVersion(
        $prompt['prompt_type_id'],
        $restored_template,
        $change_summary,
        $created_by
    );

    // Log the restoration
    logConfigChange(
        'base_prompt',
        $new_prompt['id'],
        'restore',
        null,
        ['template' => $restored_template],
        'Restored from history ID ' . $history_id
    );

    // Clear cache
    $type = getPromptTypeById($prompt['prompt_type_id']);
    if ($type) {
        clearConfigCache($type['type_key']);
    }

    return $new_prompt;
}

/**
 * Get change count for a product type
 * Useful for dashboard statistics
 *
 * @param int $prompt_type_id Prompt type ID
 * @return int Number of changes
 * @throws Exception on database error
 */
function getChangeCount($prompt_type_id)
{
    $mysqli = getDbConnection();

    $query = "
        SELECT COUNT(*) as count
        FROM `ai_config_history`
        WHERE (
            (entity_type = 'product_type' AND entity_id = ?)
            OR (entity_type = 'base_prompt' AND entity_id IN (
                SELECT id FROM ai_base_prompts WHERE prompt_type_id = ?
            ))
            OR (entity_type = 'field_config' AND entity_id IN (
                SELECT id FROM ai_field_configs WHERE prompt_type_id = ?
            ))
            OR (entity_type = 'field_option' AND entity_id IN (
                SELECT o.id
                FROM ai_field_options o
                INNER JOIN ai_field_configs f ON o.field_config_id = f.id
                WHERE f.prompt_type_id = ?
            ))
        )
    ";

    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "iiii", $prompt_type_id, $prompt_type_id, $prompt_type_id, $prompt_type_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return intval($row['count']);
}

/**
 * Get recent changes across all product types
 * Useful for dashboard overview
 *
 * @param int $limit Number of records to return (default: 20)
 * @return array Array of recent history records
 * @throws Exception on database error
 */
function getRecentChanges($limit = 20)
{
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "
        SELECT
            h.*,
            c.u_name as user_name,
            c.u_surname as user_surname,
            c.email as user_email,
            pt.name as product_type_name
        FROM `ai_config_history` h
        LEFT JOIN `u_clients` c ON h.changed_by = c.client_ID
        LEFT JOIN `ai_base_prompts` bp ON h.entity_type = 'base_prompt' AND h.entity_id = bp.id
        LEFT JOIN `ai_field_configs` fc ON h.entity_type = 'field_config' AND h.entity_id = fc.id
        LEFT JOIN `ai_prompt_types` pt ON (
            (h.entity_type = 'product_type' AND h.entity_id = pt.id)
            OR (h.entity_type = 'base_prompt' AND bp.prompt_type_id = pt.id)
            OR (h.entity_type = 'field_config' AND fc.prompt_type_id = pt.id)
        )
        ORDER BY h.changed_at DESC
        LIMIT ?
    ");
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $history = [];
    while ($row = mysqli_fetch_assoc($result)) {
        // Decode JSON values
        if ($row['old_values']) {
            $row['old_values'] = json_decode($row['old_values'], true);
        }
        if ($row['new_values']) {
            $row['new_values'] = json_decode($row['new_values'], true);
        }

        $history[] = $row;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    return $history;
}

/**
 * Compare two history records (for diff viewing)
 *
 * @param array $old_record Old history record
 * @param array $new_record New history record
 * @return array Comparison data with added, removed, and modified keys
 */
function compareHistoryRecords($old_record, $new_record)
{
    $old_values = $old_record['old_values'] ?? [];
    $new_values = $new_record['new_values'] ?? [];

    $comparison = [
        'added' => [],
        'removed' => [],
        'modified' => []
    ];

    // Find added keys
    foreach ($new_values as $key => $value) {
        if (!array_key_exists($key, $old_values)) {
            $comparison['added'][$key] = $value;
        } elseif ($old_values[$key] !== $value) {
            $comparison['modified'][$key] = [
                'old' => $old_values[$key],
                'new' => $value
            ];
        }
    }

    // Find removed keys
    foreach ($old_values as $key => $value) {
        if (!array_key_exists($key, $new_values)) {
            $comparison['removed'][$key] = $value;
        }
    }

    return $comparison;
}
