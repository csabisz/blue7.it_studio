<?php
/**
 * List previously generated AI images for a task (orf_id) or URL-based source
 * (image_url). Returns records shaped for the modal preview strip + delete flow.
 */
session_start();
header('Content-Type: application/json; charset=utf-8');

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
    mysqli_set_charset($mysqli, 'utf8mb4');
    return $mysqli;
}

function dbColumnExists($mysqli, $table, $column)
{
    $table = mysqli_real_escape_string($mysqli, $table);
    $column = mysqli_real_escape_string($mysqli, $column);
    $sql = "SHOW COLUMNS FROM `{$table}` LIKE '{$column}'";
    $res = mysqli_query($mysqli, $sql);
    if (!$res) {
        return false;
    }
    $exists = mysqli_num_rows($res) > 0;
    mysqli_free_result($res);
    return $exists;
}

/**
 * Build normalized URL variants for tolerant source_image_url matching.
 *
 * @param string $u
 * @return string[]
 */
function urlMatchVariants($u)
{
    $u = trim((string) $u);
    if ($u === '') {
        return [];
    }

    $variants = [];
    $current = $u;
    for ($i = 0; $i < 3; $i++) {
        $variants[$current] = true;
        $decoded = html_entity_decode($current, ENT_QUOTES, 'UTF-8');
        if ($decoded === $current) {
            break;
        }
        $current = $decoded;
    }
    $variants[rawurldecode($current)] = true;
    $variants[urldecode($current)] = true;
    $variants[htmlspecialchars($u, ENT_QUOTES, 'UTF-8')] = true;
    $variants[htmlspecialchars($current, ENT_QUOTES, 'UTF-8')] = true;

    return array_keys($variants);
}

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
        throw new Exception('Invalid request method');
    }

    $orf_id = isset($_GET['orf_id']) && $_GET['orf_id'] !== '' ? intval($_GET['orf_id']) : 0;
    $image_url = isset($_GET['image_url']) ? trim((string) $_GET['image_url']) : '';

    if ($orf_id <= 0 && $image_url === '') {
        throw new Exception('Missing required parameter: orf_id or image_url');
    }

    $mysqli = getDbConnection();

    $optionalCols = [
        'source_image_url', 'generated_image_url', 'thumbnail_url',
        'model', 'room_type', 'style_preset', 'quality', 'created_at'
    ];
    $selectCols = ['orf_ai_id', 'orf_id'];
    foreach ($optionalCols as $col) {
        if (dbColumnExists($mysqli, 'o_results_ai', $col)) {
            $selectCols[] = $col;
        }
    }

    $rows = [];

    if ($orf_id > 0) {
        $selectSql = 'SELECT ' . implode(', ', $selectCols)
            . ' FROM o_results_ai WHERE orf_id = ? ORDER BY orf_ai_id DESC';
        $stmt = mysqli_prepare($mysqli, $selectSql);
        if (!$stmt) {
            throw new Exception('Failed to prepare query: ' . mysqli_error($mysqli));
        }
        mysqli_stmt_bind_param($stmt, 'i', $orf_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        while ($row = mysqli_fetch_assoc($result)) {
            $rows[] = $row;
        }
        mysqli_stmt_close($stmt);
    } else {
        // URL-scoped records: source_image_url is persisted HTML-encoded via
        // sanitizeInput() in ai_image_generate.php, so compare variant forms.
        $selectSql = 'SELECT ' . implode(', ', $selectCols)
            . ' FROM o_results_ai WHERE source_image_url IS NOT NULL'
            . ' AND source_image_url != \'\' ORDER BY orf_ai_id DESC';
        $result = mysqli_query($mysqli, $selectSql);
        if (!$result) {
            throw new Exception('Failed to query URL-scoped records: ' . mysqli_error($mysqli));
        }

        $providedVariants = urlMatchVariants($image_url);
        while ($row = mysqli_fetch_assoc($result)) {
            $stored = isset($row['source_image_url']) ? (string) $row['source_image_url'] : '';
            if ($stored === '') {
                continue;
            }
            $storedVariants = urlMatchVariants($stored);
            $match = false;
            foreach ($storedVariants as $sv) {
                if (in_array($sv, $providedVariants, true)) {
                    $match = true;
                    break;
                }
            }
            if ($match) {
                $rows[] = $row;
            }
        }
        mysqli_free_result($result);
    }

    $hasSavedLink = dbColumnExists($mysqli, 'o_results', 'orf_ai_id');
    $savedStmt = null;
    if ($hasSavedLink) {
        $savedStmt = mysqli_prepare($mysqli, 'SELECT orf_id FROM o_results WHERE orf_ai_id = ? LIMIT 1');
    }

    $images = [];
    foreach ($rows as $row) {
        $orfAiId = intval($row['orf_ai_id']);
        if ($orfAiId <= 0) {
            continue;
        }

        $imageUrl = '';
        if (!empty($row['generated_image_url'])) {
            $imageUrl = $row['generated_image_url'];
        } elseif (!empty($row['thumbnail_url'])) {
            $imageUrl = $row['thumbnail_url'];
        }

        $savedOrfId = null;
        if ($savedStmt) {
            mysqli_stmt_bind_param($savedStmt, 'i', $orfAiId);
            mysqli_stmt_execute($savedStmt);
            $savedRes = mysqli_stmt_get_result($savedStmt);
            $savedRow = mysqli_fetch_assoc($savedRes);
            if ($savedRow && !empty($savedRow['orf_id'])) {
                $savedOrfId = intval($savedRow['orf_id']);
            }
            if ($savedRes) {
                mysqli_free_result($savedRes);
            }
        }

        $images[] = [
            'id'                  => $orfAiId,
            'orf_ai_id'           => $orfAiId,
            'ai_record_id'        => $orfAiId,
            'image_url'           => $imageUrl,
            'generated_image_url' => $imageUrl,
            'thumbnail_url'       => isset($row['thumbnail_url']) ? $row['thumbnail_url'] : $imageUrl,
            'source_image_url'    => isset($row['source_image_url']) ? $row['source_image_url'] : '',
            'model'               => isset($row['model']) ? $row['model'] : '',
            'room_type'           => isset($row['room_type']) ? $row['room_type'] : '',
            'style_preset'        => isset($row['style_preset']) ? $row['style_preset'] : '',
            'quality'             => isset($row['quality']) ? $row['quality'] : '',
            'created_at'          => isset($row['created_at']) ? $row['created_at'] : '',
            'saved_orf_id'        => $savedOrfId,
        ];
    }

    if ($savedStmt) {
        mysqli_stmt_close($savedStmt);
    }
    mysqli_close($mysqli);

    echo json_encode([
        'success' => true,
        'data' => [
            'images' => $images,
        ],
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error'   => $e->getMessage(),
    ]);
}
