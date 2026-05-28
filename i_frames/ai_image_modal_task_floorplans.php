<?php
/**
 * AI Image Modal - Standalone Iframe Version
 *
 * This is a standalone iframe entry point for the AI image generation modal.
 * Can be embedded in any external website via iframe.
 *
 * URL Parameters:
 *   - orf_id (required): The o_results file ID
 *   - token (required): Authentication token (placeholder validation for now)
 *
 * PostMessage Events (sent to parent):
 *   - ready:           Iframe loaded, modal visible
 *   - imageGenerated:  New image created (raw generation, before DB save)
 *   - imageRegistered: Generated image was auto-persisted to o_results_ai
 *                      and now lives in "Previously Generated Images".
 *                      Carries: { orf_id, provider, generation_id,
 *                                 orf_ai_id, image_url, thumbnail_url,
 *                                 model }
 *                      Distinct from `imageSaved` on purpose — the parent
 *                      page commonly uses `imageSaved` as a close/redirect
 *                      trigger, and we MUST NOT fire it automatically.
 *   - imageSaved:      User explicitly clicked "Save to Task" and the
 *                      backend attached the AI record to a task file.
 *                      Carries: { orf_id, orf_ai_id, saved_orf_id }
 *   - error:           Any error occurred
 *   - close:           User clicked close button
 */

session_start();

// Get parameters
$orf_id = isset($_GET['orf_id']) ? intval($_GET['orf_id']) : 0;
$token = isset($_GET['token']) ? $_GET['token'] : '';

/**
 * Validate token (placeholder implementation)
 * TODO: Implement real token validation (JWT, session check, etc.)
 *
 * @param string $token The token to validate
 * @return bool True if valid
 */
function validateToken($token) {
    // TODO: Implement real validation
    // For now, accept any non-empty token
    return !empty($token);
}

// Validate request
if (!$orf_id || !validateToken($token)) {
    http_response_code(403);
    die('Invalid request: Missing or invalid orf_id or token');
}

// Database connection
function getDbConnection() {
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

// Load image data
try {
    $mysqli = getDbConnection();

    $stmt = mysqli_prepare($mysqli, "SELECT orf_id, orf_compress_path, prod_id FROM o_results WHERE orf_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $orf_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $image_data = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);

    if (!$image_data) {
        http_response_code(404);
        die('Image not found for orf_id: ' . $orf_id);
    }
} catch (Exception $e) {
    http_response_code(500);
    die('Database error: ' . $e->getMessage());
}

// Build image URL
$compress_path = $image_data['orf_compress_path'];
$image_url = $compress_path ? "https://cseven.eu/studio/result_compress_files/{$compress_path}" : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Image Generation</title>

    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Shared Modal Styles -->
    <link rel="stylesheet" href="ai_modal_shared.css">
    <!-- Image Editor Styles -->
    <link rel="stylesheet" href="ai_image_editor.css">

    <!--
        Scoped styles for the Supergrundriss (florplans.blue7.it) 2D Floor Plan
        options panel. Kept inline so this iframe entry point stays self-contained
        and we do not have to touch the shared CSS used by sibling modals.
    -->
    <style>
        .sg-panel { font-size: 13px; }
        .sg-panel h6 { font-size: 13px; font-weight: 600; }
        .sg-section { margin-bottom: 1rem; }
        .sg-section-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #6c757d;
            margin: 0 0 .35rem 0;
            letter-spacing: .04em;
            font-weight: 600;
        }
        .sg-segment { display: flex; gap: 4px; flex-wrap: wrap; }
        .sg-segment .sg-chip {
            padding: 4px 10px;
            border: 1px solid #ced4da;
            border-radius: 14px;
            background: #fff;
            cursor: pointer;
            font-size: 12px;
            color: #333;
            transition: all .15s;
        }
        .sg-segment .sg-chip:hover { border-color: #007bff; }
        .sg-segment .sg-chip.active { background: #007bff; border-color: #007bff; color: #fff; }
        .sg-card-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 6px; }
        .sg-card {
            border: 1px solid #ced4da;
            border-radius: 6px;
            overflow: hidden;
            cursor: pointer;
            background: #fff;
            transition: all .15s;
            text-align: center;
        }
        .sg-card:hover { border-color: #007bff; box-shadow: 0 2px 6px rgba(0,123,255,0.15); }
        .sg-card.active { border-color: #007bff; box-shadow: 0 0 0 2px #007bff inset; }
        .sg-card .sg-card-thumb {
            width: 100%;
            max-height: 100px;
            height: 100px;
            background-size: contain;
            background-position: center;
            background-color: #fff;
            background-repeat: no-repeat;
        }
        /* Subtle shimmer while we Bearer-fetch the preset thumbnail blob.
           The .is-loading class is toggled by sgLoadPresetThumb() and
           removed once the background-image is applied (or the fetch
           fails — at which point we just show the plain placeholder). */
        .sg-card .sg-card-thumb.is-loading {
            background-image: linear-gradient(90deg, #f1f3f5 25%, #e9ecef 50%, #f1f3f5 75%);
            background-size: 200% 100%;
            animation: sg-thumb-shimmer 1.2s linear infinite;
        }
        @keyframes sg-thumb-shimmer {
            0%   { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        .sg-card .sg-card-label {
            padding: 4px 6px;
            font-size: 11px;
            color: #333;
            line-height: 1.2;
            min-height: 26px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sg-status { font-size: 12px; color: #6c757d; padding: 4px 0; }
        .sg-status.error { color: #dc3545; }
        .sg-quality-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 4px; }

        /* -----------------------------------------------------------------
         * Furniture tab strip
         *
         * 4 equal-width pills that reuse the .sg-chip token (background,
         * border-radius, transitions) so the active/hover treatment is
         * visually consistent with the 2D/3D and Quality segments.
         * Min-height locks the row to a single line and prevents layout
         * shift between hover/focus/active states. CSS Grid distributes
         * the 4 tabs evenly, then collapses to 2 columns on narrow widths.
         * "*" marker mirrors the sg-form-section legend's required-field
         * cue used elsewhere in the panel.
         * ----------------------------------------------------------------- */
        .sg-furniture-tabs {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 4px;
        }
        .sg-furniture-tabs .sg-furniture-chip {
            padding: 6px 6px;
            min-height: 30px;
            text-align: center;
            line-height: 1.1;
            font-size: 12px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sg-furniture-tabs .sg-furniture-chip:focus-visible {
            outline: 2px solid #0056b3;
            outline-offset: 1px;
        }
        .sg-furniture-tabs .sg-furniture-chip[aria-checked="true"] {
            background: #007bff;
            border-color: #007bff;
            color: #fff;
        }
        .sg-section-label .sg-req-mark { color: #dc3545; margin-left: 2px; }
        /* Collapse to 2 columns on narrow modal widths to keep labels readable. */
        @media (max-width: 575.98px) {
            .sg-furniture-tabs { grid-template-columns: repeat(2, 1fr); }
        }
        .sg-floor-plan-result {
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 6px;
            margin: 6px 4px;
            width: 180px;
            background: #fff;
            display: inline-block;
            vertical-align: top;
        }
        .sg-floor-plan-result img {
            width: 100%;
            height: 140px;
            object-fit: contain;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .sg-floor-plan-result .sg-fp-meta {
            font-size: 11px;
            color: #6c757d;
            margin-top: 4px;
            text-align: center;
        }
        .sg-floor-plan-result .sg-fp-meta strong { color: #333; }

        /* -----------------------------------------------------------------
         * SuperGrundriss form (left panel) — comprehensive sections for
         * 2D/3D-Plan, bathroom, kitchen, rest, environment, level,
         * terrace+balcony, and technic. Field state mirrors the JS sgForm
         * model and is validated before /v1/generate is called.
         * ----------------------------------------------------------------- */
        .sg-panel .sg-form-section {
            border: 1px solid #e9ecef;
            border-radius: 6px;
            padding: 8px 10px;
            margin-bottom: 8px;
            background: #fff;
        }
        .sg-panel .sg-form-section.has-error { border-color: #dc3545; background: #fff5f5; }
        .sg-panel .sg-form-section legend {
            font-size: 11px;
            text-transform: uppercase;
            color: #6c757d;
            margin: 0 0 .35rem 0;
            letter-spacing: .04em;
            font-weight: 600;
            float: none;
            width: auto;
            padding: 0;
        }
        .sg-panel .sg-form-section legend .req { color: #dc3545; margin-left: 2px; }
        .sg-panel .sg-checks {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 4px 10px;
        }
        .sg-panel .sg-check-item {
            display: flex;
            align-items: center;
            font-size: 12px;
            line-height: 1.2;
            padding: 1px 0;
        }
        .sg-panel .sg-check-item input[type="checkbox"] {
            margin-right: 6px;
            transform: scale(0.95);
        }
        .sg-panel .form-control-sm { font-size: 12px; }
        .sg-panel .sg-inline-error {
            color: #dc3545;
            font-size: 11px;
            display: none;
            margin-top: 4px;
        }
        .sg-panel .has-error .sg-inline-error { display: block; }
        .sg-panel .has-error .form-control,
        .sg-panel .has-error .sg-segment .sg-chip { border-color: #dc3545; }
        .sg-panel .sg-form-section .sg-segment .sg-chip { font-size: 11px; padding: 3px 8px; }

        /* Disabled / busy state for the generate button */
        #generateFloorPlan:disabled { opacity: .65; cursor: not-allowed; }

        /* -----------------------------------------------------------------
         * Progress modal — shown after the user clicks Generate while the
         * /v1/generate request (and any polling) is in flight. Layered on
         * top of the main modal via z-index. Backdrop blocks interaction.
         * ----------------------------------------------------------------- */
        .sg-progress-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(20, 24, 33, 0.72);
            z-index: 20000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(2px);
            -webkit-backdrop-filter: blur(2px);
        }
        .sg-progress-backdrop.is-open { display: flex; }
        .sg-progress-card {
            background: #fff;
            border-radius: 10px;
            padding: 28px 30px;
            box-shadow: 0 12px 40px rgba(0,0,0,0.3);
            max-width: 460px;
            width: 100%;
            text-align: center;
        }
        .sg-progress-spinner {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            border: 5px solid #e9ecef;
            border-top-color: #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        .sg-progress-title {
            font-size: 16px;
            font-weight: 600;
            color: #212529;
            margin-bottom: 6px;
        }
        .sg-progress-message {
            font-size: 13px;
            color: #495057;
            margin-bottom: 14px;
            line-height: 1.45;
        }
        .sg-progress-elapsed {
            font-size: 12px;
            color: #6c757d;
            margin-bottom: 14px;
        }
        .sg-progress-bar {
            height: 6px;
            background: #f1f3f5;
            border-radius: 3px;
            overflow: hidden;
            margin-top: 6px;
        }
        .sg-progress-bar-fill {
            height: 100%;
            background: linear-gradient(90deg, #007bff, #6610f2);
            width: 0%;
            transition: width 0.4s ease;
        }
        .sg-progress-status {
            font-size: 11px;
            color: #6c757d;
            margin-top: 10px;
            min-height: 14px;
        }

        /* -----------------------------------------------------------------
         * Results modal — opens automatically after a successful generation.
         * Stacks above the main modal (z-index 21000) and contains:
         *   - Image carousel (when API returns multiple)
         *   - Drag-style before/after compare slider
         *   - Toggle to switch between Compare and Generated-only views
         * ----------------------------------------------------------------- */
        .sg-results-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(15, 18, 25, 0.85);
            z-index: 21000;
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }
        .sg-results-backdrop.is-open { display: flex; }
        .sg-results-dialog {
            background: #1a1d23;
            color: #e9ecef;
            border-radius: 10px;
            width: 100%;
            max-width: 1100px;
            max-height: calc(100vh - 32px);
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 16px 60px rgba(0,0,0,0.6);
        }
        .sg-results-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid #2a2f38;
        }
        .sg-results-header h5 {
            margin: 0;
            font-size: 15px;
            font-weight: 600;
        }
        .sg-results-header .sg-close {
            background: none;
            border: none;
            color: #adb5bd;
            font-size: 22px;
            line-height: 1;
            cursor: pointer;
            padding: 4px 8px;
        }
        .sg-results-header .sg-close:hover { color: #fff; }
        .sg-results-toolbar {
            display: flex;
            gap: 8px;
            align-items: center;
            padding: 8px 16px;
            border-bottom: 1px solid #2a2f38;
            background: #1f232b;
            flex-wrap: wrap;
        }
        .sg-results-toolbar .sg-toggle-group {
            display: inline-flex;
            border: 1px solid #3a4150;
            border-radius: 6px;
            overflow: hidden;
        }
        .sg-results-toolbar .sg-toggle-btn {
            background: transparent;
            color: #cfd4dc;
            border: none;
            padding: 5px 12px;
            font-size: 12px;
            cursor: pointer;
        }
        .sg-results-toolbar .sg-toggle-btn.active {
            background: #007bff;
            color: #fff;
        }
        .sg-results-toolbar .sg-result-count {
            font-size: 12px;
            color: #adb5bd;
        }
        .sg-results-toolbar .sg-thumbs {
            display: flex;
            gap: 6px;
            overflow-x: auto;
            max-width: 100%;
        }
        .sg-results-toolbar .sg-thumb {
            width: 44px;
            height: 44px;
            border-radius: 4px;
            background: #2a2f38 center/contain no-repeat;
            cursor: pointer;
            border: 2px solid transparent;
            flex: 0 0 auto;
        }
        .sg-results-toolbar .sg-thumb.active { border-color: #007bff; }
        .sg-results-body {
            flex: 1;
            position: relative;
            overflow: hidden;
            background: #0f1115;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sg-results-footer {
            padding: 10px 16px;
            border-top: 1px solid #2a2f38;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #1f232b;
            font-size: 12px;
            color: #adb5bd;
            flex-wrap: wrap;
            gap: 8px;
        }
        .sg-results-footer .sg-actions { display: flex; gap: 8px; }
        .sg-results-footer .btn { font-size: 12px; }

        /* -----------------------------------------------------------------
         * Drag-style before/after compare slider. The "after" image is
         * clipped to a width controlled by the divider handle. Supports
         * mouse and touch interactions. Maintains aspect ratio via
         * intrinsic image sizing.
         * ----------------------------------------------------------------- */
        .sg-compare {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            user-select: none;
            -webkit-user-select: none;
            overflow: hidden;
        }
        .sg-compare .sg-compare-stage {
            position: relative;
            max-width: 100%;
            max-height: 100%;
            display: inline-block;
            line-height: 0;
        }
        .sg-compare img {
            display: block;
            max-width: 100%;
            max-height: calc(100vh - 220px);
            width: auto;
            height: auto;
            user-drag: none;
            -webkit-user-drag: none;
            pointer-events: none;
        }
        .sg-compare .sg-compare-before {
            position: relative;
            z-index: 1;
        }
        .sg-compare .sg-compare-after-wrap {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 50%;
            overflow: hidden;
            z-index: 2;
            border-right: 2px solid #fff;
            box-shadow: 0 0 0 1px rgba(0,0,0,0.4);
        }
        .sg-compare .sg-compare-after-wrap img {
            max-width: none;
            width: auto;
            height: 100%;
        }
        /* In "generated-only" mode the after image fills the stage and the
           handle / before image are hidden. */
        .sg-compare.is-generated-only .sg-compare-after-wrap {
            width: 100% !important;
            border-right: none;
            box-shadow: none;
        }
        .sg-compare.is-generated-only .sg-compare-handle { display: none; }
        .sg-compare.is-original-only .sg-compare-after-wrap { width: 0 !important; }
        .sg-compare.is-original-only .sg-compare-handle { display: none; }

        .sg-compare-handle {
            position: absolute;
            top: 0;
            left: 50%;
            width: 36px;
            height: 100%;
            margin-left: -18px;
            cursor: ew-resize;
            z-index: 3;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .sg-compare-handle::before {
            content: '';
            position: absolute;
            top: 0; bottom: 0; left: 50%;
            width: 2px;
            background: #fff;
            margin-left: -1px;
            box-shadow: 0 0 4px rgba(0,0,0,0.5);
        }
        .sg-compare-handle .sg-compare-knob {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #fff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #495057;
            font-size: 12px;
            position: relative;
            z-index: 1;
        }
        .sg-compare-handle .sg-compare-knob::before,
        .sg-compare-handle .sg-compare-knob::after {
            content: '';
            border: solid #495057;
            border-width: 0 2px 2px 0;
            display: inline-block;
            padding: 3px;
        }
        .sg-compare-handle .sg-compare-knob::before {
            transform: rotate(135deg);
            margin-right: 2px;
        }
        .sg-compare-handle .sg-compare-knob::after {
            transform: rotate(-45deg);
            margin-left: 2px;
        }
        .sg-compare-label {
            position: absolute;
            top: 8px;
            background: rgba(0,0,0,0.65);
            color: #fff;
            font-size: 11px;
            padding: 3px 8px;
            border-radius: 3px;
            z-index: 4;
            pointer-events: none;
            letter-spacing: .05em;
        }
        .sg-compare-label.left  { left: 8px; }
        .sg-compare-label.right { right: 8px; }

        /* Mobile-friendly adjustments */
        @media (max-width: 575.98px) {
            .sg-results-dialog { max-height: 100vh; border-radius: 0; }
            .sg-compare img { max-height: calc(100vh - 280px); }
            .sg-compare-handle { width: 44px; margin-left: -22px; }
        }
    </style>
</head>
<body>
<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
    <div class="loading-text">Loading AI Image Generator...</div>
</div>

<div class="iframe-modal-container">
    <div class="iframe-modal-content">
        <!-- Generating Overlay -->
        <div class="modal-generating-overlay" id="generatingOverlay">
            <div class="text-center">
                <div class="loading-spinner"></div>
                <div class="loading-text mt-3">Generating image...</div>
            </div>
        </div>

        <!-- Header -->
        <div class="modal-header">
            <h5 class="modal-title">AI Image Generation Settings</h5>
            <button type="button" class="close" id="closeModalBtn" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <!-- Body -->
        <div class="iframe-modal-body">
            <div class="row">
                <!--
                    Supergrundriss (florplans.blue7.it) 2D Floor Plan options panel.
                    Holds the per-tenant generation options that flow into the
                    POST /v1/generate request:
                      - 2D / 3D plan toggle  -> tool_slug
                      - Colors & Textures    -> preset (system preset slug)
                      - Quality tier         -> quality_tier
                    All *required* per-task settings (bathroom, kitchen, level,
                    environment, terrace+balcony, technic, etc.) live in the
                    center "Fine-tune Generation Prompt" column and are
                    validated by sgRequiredFieldsValid() before submission.
                -->
                <div class="col-md-8 sg-panel" id="sgPanel">

                    <h6 class="text-dark mb-3">
                        <i class="fas fa-drafting-compass mr-1"></i>
                        Floor Plan Options
                    </h6>

                    <div id="sgPanelStatus" class="sg-status">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading Supergrundriss options...
                    </div>

                    <!-- 2D / 3D-Plan ---------------------------------------------------- -->
                    <fieldset class="sg-form-section" data-sg-field="plan_type">
                        <legend>2D / 3D-Plan</legend>
                        <div class="sg-segment" id="sgPlanType" role="radiogroup" aria-label="Plan type">
                            <button type="button" class="sg-chip active" data-value="floorplan-2d">2D Floor Plan</button>
                            <button type="button" class="sg-chip" data-value="floorplan-3d">3D Floor Plan</button>
                        </div>
                        <select class="form-control form-control-sm mt-2" id="sgTool" aria-label="Tool slug (auto)">
                            <option value="floorplan-2d">2D Floor Plan</option>
                            <option value="floorplan-3d">3D Floor Plan</option>
                        </select>
                    </fieldset>

                    <!--
                        Furniture selector (settings_json.furniture).

                        Rendered as exactly four mutually-exclusive tabs that
                        mirror the `furniture` control returned by GET /v1/tools
                        for the `floorplan-2d` tool. Both 2D and 3D tools share
                        the same option set, so the UI is identical for either
                        plan type. Tabs are wired by JS (sgInitFurnitureSection)
                        which:
                          - tries to populate options live from /tools controls
                          - falls back to the four static defaults below if the
                            API call fails (so the form is never empty)
                          - stores the picked raw `value` in sgState.furniture
                          - triggers sgUpdateGenerateButtonState() so the
                            Generate button enables only when one is picked
                    -->
                    <div class="sg-section mt-2" id="sgFurnitureSection">
                        <div class="sg-section-label">
                            Furniture <span class="sg-req-mark" aria-hidden="true">*</span>
                        </div>
                        <div class="sg-segment sg-furniture-tabs"
                             id="sgFurniture"
                             role="radiogroup"
                             aria-label="Furniture & Functions">
                            <!-- Fallback options match /v1/tools controls.furniture
                                 for floorplan-2d. Re-rendered from the live API
                                 response when /tools resolves. -->
                            <button type="button" class="sg-chip sg-furniture-chip"
                                    data-value="original" role="radio" aria-checked="false">Original</button>
                            <button type="button" class="sg-chip sg-furniture-chip"
                                    data-value="living" role="radio" aria-checked="false">Wohnen</button>
                            <button type="button" class="sg-chip sg-furniture-chip"
                                    data-value="business" role="radio" aria-checked="false">Büro</button>
                            <button type="button" class="sg-chip sg-furniture-chip"
                                    data-value="empty" role="radio" aria-checked="false">Leer</button>
                        </div>
                    </div>

                    <!-- Color / Texture presets (visual cards) ------------------------- -->
                    <div class="sg-section mt-2">
                        <div class="sg-section-label">Colors & Textures</div>
                        <div class="sg-card-grid" id="sgPresets">
                            <div class="sg-status">Loading presets...</div>
                        </div>
                    </div>

                    <!-- Quality tier --------------------------------------------------- -->
                    <div class="sg-section mt-2">
                        <div class="sg-section-label">Quality</div>
                        <div class="sg-segment" id="sgQuality">
                            <button type="button" class="sg-chip active" data-value="standard">Standard</button>
                            <button type="button" class="sg-chip" data-value="premium">Premium</button>
                        </div>
                    </div>
                </div>

                <!-- Prompt Fine-tuning Column -->
                <div class="col-md-4">
                    <!-- Image Preview Column -->
                    <div class="w-100 row mx-0 px-0">
                        <h6 class="text-dark mb-3">Current Image</h6>
                        <?php if ($image_url): ?>
                            <div class="source-image-container" id="sourceImageContainer">
                                <img src="<?php echo htmlspecialchars($image_url); ?>"
                                    alt="Current Image"
                                    id="sourceImagePreview"
                                    class="img-fluid rounded border shadow-sm"
                                    style="max-height: 400px; width: 100%; object-fit: contain;">
                                <div class="source-image-overlay">
                                    <button type="button" class="btn btn-light btn-sm" id="editImageBtn">
                                        <i class="fas fa-edit mr-1"></i> Edit Image
                                    </button>
                                </div>
                                <div class="edited-indicator" id="editedIndicator" style="display: none;">
                                    <i class="fas fa-pencil-alt"></i>
                                    Edited
                                    <span class="revert-link" id="revertLink">Revert</span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <small>No compressed image available</small>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-12">
                        <div class="form-group">
                            <label for="aiNotes" class="text-dark">Additional Instructions</label>
                            <textarea class="form-control form-control-sm"
                                      id="aiNotes"
                                      rows="3"
                                      placeholder="Add any specific requirements or details..."></textarea>
                        </div>
                        <!-- <div class="form-group mt-3">
                            <label class="text-dark">Reference Images <small class="text-muted">(Optional, max 14)</small></label>
                            <div class="reference-dropzone" id="referenceDropzone">
                                <input type="file" id="referenceFileInput" multiple accept="image/jpeg,image/png,image/jpg,image/webp" hidden>
                                <div class="text-center text-muted py-3">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                    <p class="mb-0 small">Drag & drop or click to upload</p>
                                </div>
                            </div>
                            <div class="reference-previews mt-2" id="referencePreviews"></div>
                            <small class="text-muted"><span id="referenceCount">0</span>/14 images</small>
                        </div> -->
                    </div>

                    <!-- <h6 class="text-dark my-3">Fine-tune Generation Prompt</h6> -->

                    <!-- Model Selection -->
                    <!-- <div class="form-group">
                        <label for="aiModel" class="text-dark">Model</label>
                        <select class="form-control form-control-sm" id="aiModel">
                            <option value="gemini-3-pro-image-preview">[Google] Nano Banana Pro</option>
                            <option value="gemini-2.5-flash-image">[Google] Nano Banana</option>
                            <option value="imagen-4.0-generate-001">[Google] Imagen 4</option>
                            <option value="imagen-4.0-ultra-generate-001">[Google] Imagen 4 Ultra</option>
                            <option value="imagen-4.0-fast-generate-001">[Google] Imagen 4 Fast</option>
                        </select>
                    </div> -->

                    <!-- Dynamic form fields container -->
                    <!-- <div id="aiDynamicFields">
                        <div class="text-center text-muted py-3">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="ml-2">Loading product configuration...</span>
                        </div>
                    </div> -->

                    <!-- Hidden field to store product type -->
                    <!-- <input type="hidden" id="aiProductType" value=""> -->
                </div>

                <!-- Additional Notes -->
                <!-- <div class="col-md-4">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="aiNotes" class="text-dark">Additional Instructions</label>
                            <textarea class="form-control form-control-sm"
                                      id="aiNotes"
                                      rows="3"
                                      placeholder="Add any specific requirements or details..."></textarea>
                        </div>
                        <div class="form-group mt-3">
                            <label class="text-dark">Reference Images <small class="text-muted">(Optional, max 14)</small></label>
                            <div class="reference-dropzone" id="referenceDropzone">
                                <input type="file" id="referenceFileInput" multiple accept="image/jpeg,image/png,image/jpg,image/webp" hidden>
                                <div class="text-center text-muted py-3">
                                    <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                    <p class="mb-0 small">Drag & drop or click to upload</p>
                                </div>
                            </div>
                            <div class="reference-previews mt-2" id="referencePreviews"></div>
                            <small class="text-muted"><span id="referenceCount">0</span>/14 images</small>
                        </div>
                    </div>
                </div> -->
            </div>

            <!-- Previously Generated Images -->
            <div class="row mt-4">
                <div class="col-12">
                    <h6 class="text-dark mb-3">Previously Generated Images</h6>
                    <div id="aiGeneratedPreviews" class="d-flex flex-wrap gap-2" style="gap: 0.5rem; max-height: 300px; overflow-y: auto;">
                        <div class="text-muted small">
                            <em>No previously generated images yet.</em>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" id="closeModalBtnFooter">Close</button>
            <!-- <button type="button" class="btn btn-success btn-sm" id="viewFullPrompt">
                <i class="fas fa-eye"></i> View Full Prompt
            </button> -->
            <!-- <button type="button" class="btn btn-info btn-sm" id="generateAIImage">
                Generate Image
            </button> -->
            <!--
                Generate 2D Floor Plan button.
                Starts in `disabled` state. JS (sgUpdateGenerateButtonState)
                enables it only when ALL required centre-form fields are
                filled, the API key is configured, and no generation is in
                flight. The `disabled` attribute also prevents click events
                from firing if a script tries to programmatically click it.
            -->
            <button type="button" class="btn btn-primary btn-sm" id="generateFloorPlan" disabled
                    title="Fill all required fields in the Fine-tune Generation Prompt section first.">
                <i class="fas fa-drafting-compass mr-1"></i> Generate 2D Floor Plan
            </button>
        </div>
    </div>
</div>

<!-- Image Comparison Modal -->
<div class="modal fade comparison-modal" id="comparisonModal" tabindex="-1" aria-labelledby="comparisonModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title" id="comparisonModalLabel">Before & After Comparison</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="comparison-container" id="comparisonContainer">
                    <!-- Original Image (Before) - Behind -->
                    <img src="" alt="Before (Original)" class="comparison-image comparison-before" id="comparisonBefore">

                    <!-- Generated Image (After) - On Top -->
                    <img src="" alt="After (AI Generated)" class="comparison-image comparison-after" id="comparisonAfter">

                    <!-- Navigation Arrows -->
                    <button class="comparison-nav-arrow left" id="prevImage">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="comparison-nav-arrow right" id="nextImage">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Opacity Slider Control -->
                    <div class="opacity-control">
                        <label>
                            AI Image Opacity
                            <span id="opacityValue">100%</span>
                        </label>
                        <input type="range" class="opacity-slider" id="opacitySlider" min="0" max="100" value="100">
                    </div>

                    <!-- Metadata Overlay -->
                    <div class="text-left comparison-metadata" id="comparisonMetadata">
                        <h6>Generation Details</h6>
                        <p><strong>Room Type:</strong> <span id="metaRoomType"></span></p>
                        <p><strong>Style:</strong> <span id="metaStyle"></span></p>
                        <p><strong>Model:</strong> <span id="metaModel"></span></p>
                        <p><strong>Quality:</strong> <span id="metaQuality"></span></p>
                        <p><strong>File Size:</strong> <span id="metaFileSize"></span></p>
                        <p><strong>Created:</strong> <span id="metaCreated"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer py-2">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="saveToTask">
                    <i class="fas fa-save mr-1"></i> Save to Task
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Save to Task Modal -->
<div class="modal fade" id="saveToTaskModal" tabindex="-1" aria-labelledby="saveToTaskModalLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header py-2">
                <h5 class="modal-title" id="saveToTaskModalLabel">
                    <i class="fas fa-save mr-2"></i>Save to Task
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="saveToTaskForm">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="saveExtensionId">Extension ID</label>
                        <input type="text" class="form-control" id="saveExtensionId" name="id_extension" placeholder="Enter extension ID">
                    </div>
                    <div class="form-group mb-0">
                        <label for="savePresentationName">Presentation Name</label>
                        <input type="text" class="form-control" id="savePresentationName" name="presentation_name" placeholder="Enter presentation name">
                    </div>
                </div>
                <div class="modal-footer py-2">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm" id="saveToTaskSubmit">
                        <i class="fas fa-save mr-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =====================================================================
     SuperGrundriss Progress Modal (layered above the main modal)
     Shown while POST /v1/generate is in flight and during status polling.
     The message and 45s minimum reminder is the same regardless of how
     fast the API responds; the elapsed time + progress bar give the
     user a sense of progress for the typical 1–2 minute generation.
     ===================================================================== -->
<div class="sg-progress-backdrop" id="sgProgressBackdrop" role="dialog" aria-modal="true"
     aria-labelledby="sgProgressTitle" aria-describedby="sgProgressMessage">
    <div class="sg-progress-card">
        <div class="sg-progress-spinner" aria-hidden="true"></div>
        <div class="sg-progress-title" id="sgProgressTitle">Generating 2D Floor Plan…</div>
        <div class="sg-progress-message" id="sgProgressMessage">
            Generation in progress. This can take 1–2 minutes, but at least 45 seconds!
        </div>
        <div class="sg-progress-elapsed" id="sgProgressElapsed">Elapsed: 0s</div>
        <div class="sg-progress-bar" aria-hidden="true">
            <div class="sg-progress-bar-fill" id="sgProgressBarFill"></div>
        </div>
        <div class="sg-progress-status" id="sgProgressStatus">Submitting request…</div>
    </div>
</div>

<!-- =====================================================================
     SuperGrundriss Results Modal (layered above the main modal)
     Opens automatically after a successful generation. Contains:
       - Optional thumbnail strip (when API returns multiple images)
       - Drag-style before/after compare slider
       - Toggle for Compare / Generated-only / Original-only views
     ===================================================================== -->
<div class="sg-results-backdrop" id="sgResultsBackdrop" role="dialog" aria-modal="true"
     aria-labelledby="sgResultsTitle">
    <div class="sg-results-dialog">
        <div class="sg-results-header">
            <h5 id="sgResultsTitle"><i class="fas fa-image mr-1"></i> Generated Floor Plan</h5>
            <button type="button" class="sg-close" id="sgResultsClose" aria-label="Close">&times;</button>
        </div>
        <div class="sg-results-toolbar">
            <div class="sg-toggle-group" role="group" aria-label="View mode">
                <button type="button" class="sg-toggle-btn active" data-mode="compare">Compare</button>
                <button type="button" class="sg-toggle-btn" data-mode="generated">Generated</button>
                <button type="button" class="sg-toggle-btn" data-mode="original">Original</button>
            </div>
            <span class="sg-result-count" id="sgResultCount"></span>
            <div class="sg-thumbs ml-auto" id="sgResultThumbs"></div>
        </div>
        <div class="sg-results-body" id="sgResultsBody">
            <div class="sg-compare" id="sgCompare">
                <div class="sg-compare-stage" id="sgCompareStage">
                    <img class="sg-compare-before" id="sgCompareBefore" src="" alt="Original">
                    <div class="sg-compare-after-wrap" id="sgCompareAfterWrap">
                        <img class="sg-compare-after" id="sgCompareAfter" src="" alt="Generated">
                    </div>
                    <div class="sg-compare-handle" id="sgCompareHandle">
                        <div class="sg-compare-knob"></div>
                    </div>
                    <div class="sg-compare-label left">ORIGINAL</div>
                    <div class="sg-compare-label right">GENERATED</div>
                </div>
            </div>
        </div>
        <div class="sg-results-footer">
            <div class="sg-meta" id="sgResultMeta">Generation #—</div>
            <div class="sg-actions">
                <button type="button" class="btn btn-outline-light btn-sm" id="sgDownloadBtn">
                    <i class="fas fa-download mr-1"></i> Download
                </button>
                <button type="button" class="btn btn-secondary btn-sm" id="sgResultsCloseBtn">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Fabric.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>
<!-- Shared Modal JavaScript -->
<script src="ai_modal_shared.js"></script>
<!-- Image Editor -->
<script src="ai_image_editor.js"></script>

<script>
    (function() {
        'use strict';

        // Get orf_id from URL parameters
        var urlParams = new URLSearchParams(window.location.search);
        var orfId = urlParams.get('orf_id');

        // Base URL for API calls (same origin)
        var apiBaseUrl = '/studio/coordination';

        // Loading overlay
        var loadingOverlay = document.getElementById('loadingOverlay');
        var configLoaded = false;
        var imagesLoaded = false;

        function checkReady() {
            if (configLoaded && imagesLoaded) {
                loadingOverlay.classList.add('hidden');
                AIModalShared.sendToParent('ready', { orf_id: orfId });
            }
        }

        // =========================================================================
        // DOM REFERENCES
        // =========================================================================

        var notesTextarea = document.getElementById('aiNotes');
        // var dynamicFieldsContainer = document.getElementById('aiDynamicFields');
        // var productTypeInput = document.getElementById('aiProductType');
        var previewsContainer = document.getElementById('aiGeneratedPreviews');
        // var generateButton = document.getElementById('generateAIImage');
        var generatingOverlay = document.getElementById('generatingOverlay');
        // var viewPromptButton = document.getElementById('viewFullPrompt');
        var closeModalBtn = document.getElementById('closeModalBtn');
        var closeModalBtnFooter = document.getElementById('closeModalBtnFooter');

        // Store product configuration
        var productConfig = null;
        var basePrompt = null;
        var formFields = {};

        // Edited image state
        var editedImageDataUrl = null;
        var originalImageUrl = '<?php echo htmlspecialchars($image_url); ?>';

        // =========================================================================
        // IMAGE EDITOR INTEGRATION
        // =========================================================================

        var editImageBtn = document.getElementById('editImageBtn');
        var editedIndicator = document.getElementById('editedIndicator');
        var revertLink = document.getElementById('revertLink');
        var sourceImagePreview = document.getElementById('sourceImagePreview');

        if (editImageBtn) {
            editImageBtn.addEventListener('click', function() {
                // Use edited image if available, otherwise original
                var imageToEdit = editedImageDataUrl || originalImageUrl;

                AIImageEditor.init(imageToEdit, {
                    onApply: function(dataUrl) {
                        if (dataUrl && dataUrl.length > 100) {
                            editedImageDataUrl = dataUrl;

                            // Create a new image element to properly load the data URL
                            var newImg = new Image();
                            newImg.onload = function() {
                                sourceImagePreview.src = dataUrl;
                                editedIndicator.style.display = 'flex';
                            };
                            newImg.onerror = function() {
                                console.error('Failed to load edited image data URL');
                                AIModalShared.showNotification('Failed to display edited image.', 'error');
                            };
                            newImg.src = dataUrl;
                        } else {
                            console.error('Invalid edited image data URL');
                            AIModalShared.showNotification('Failed to apply edits. Please try again.', 'error');
                        }
                    },
                    onCancel: function() {
                        // Nothing to do
                    }
                });
            });
        }

        if (revertLink) {
            revertLink.addEventListener('click', function(e) {
                e.stopPropagation();
                editedImageDataUrl = null;
                sourceImagePreview.src = originalImageUrl;
                editedIndicator.style.display = 'none';
            });
        }

        // =========================================================================
        // STATE MANAGEMENT
        // =========================================================================

        var isGenerating = false;

        // Initialize comparison modal with original image URL
        AIModalShared.setOriginalImageUrl(originalImageUrl);

        // =========================================================================
        // DYNAMIC FIELD RENDERING
        // =========================================================================

        function loadProductConfig() {
            fetch(apiBaseUrl + '/ai_get_product_config.php?orf_id=' + orfId)
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success) {
                        productConfig = data.data.config;
                        basePrompt = data.data.base_prompt;
                        // productTypeInput.value = data.data.product_type;
                        renderDynamicFields();
                    } else {
                        console.error('Failed to load product config:', data.error);
                        AIModalShared.showNotification('Failed to load product configuration.', 'warning');
                        // dynamicFieldsContainer.innerHTML = '<div class="alert alert-warning">Failed to load configuration</div>';
                        AIModalShared.sendToParent('error', { message: 'Failed to load product configuration', code: 'CONFIG_LOAD_FAILED' });
                    }
                    configLoaded = true;
                    checkReady();
                })
                .catch(function(error) {
                    console.error('Error loading product config:', error);
                    AIModalShared.showNotification('Error loading product configuration', 'danger');
                    // dynamicFieldsContainer.innerHTML = '<div class="alert alert-danger">Error loading configuration</div>';
                    AIModalShared.sendToParent('error', { message: 'Error loading product configuration', code: 'CONFIG_LOAD_ERROR' });
                    configLoaded = true;
                    checkReady();
                });
        }

        function renderDynamicFields() {
            if (!productConfig || !productConfig.fields) {
                return;
            }

            // dynamicFieldsContainer.innerHTML = '';
            AIModalShared.clearAdminReferenceImages();

            productConfig.fields.forEach(function(fieldConfig) {
                var fieldId = fieldConfig.id;
                var formGroup = document.createElement('div');
                formGroup.className = 'form-group';

                var label = document.createElement('label');
                label.setAttribute('for', fieldId);
                label.className = 'text-dark';
                label.textContent = fieldConfig.label;
                if (fieldConfig.required) {
                    var required = document.createElement('span');
                    required.className = 'text-danger';
                    required.textContent = ' *';
                    label.appendChild(required);
                }
                formGroup.appendChild(label);

                var field = null;
                if (fieldConfig.type === 'select') {
                    field = document.createElement('select');
                    field.className = 'form-control form-control-sm';
                    field.id = fieldId;
                    field.setAttribute('data-field-id', fieldConfig.id);

                    var placeholderOption = document.createElement('option');
                    placeholderOption.value = '';
                    placeholderOption.textContent = '-- Select ' + fieldConfig.label + ' --';
                    field.appendChild(placeholderOption);

                    fieldConfig.options.forEach(function(opt) {
                        var option = document.createElement('option');
                        option.value = opt.value;
                        option.textContent = opt.label;
                        if (opt.prompt) {
                            option.setAttribute('data-prompt', opt.prompt);
                        }
                        if (opt.rooms) {
                            option.setAttribute('data-rooms', opt.rooms);
                        }
                        if (opt.reference_image) {
                            option.setAttribute('data-reference-image', opt.reference_image);
                        }
                        field.appendChild(option);
                    });

                    // Handle reference images from options
                    field.addEventListener('change', function() {
                        var selectedOption = this.options[this.selectedIndex];
                        var refImageUrl = selectedOption.dataset.referenceImage;

                        AIModalShared.removeAdminReferenceImage(fieldConfig.id);

                        if (refImageUrl) {
                            AIModalShared.addAdminReferenceImage(fieldConfig.id, refImageUrl, selectedOption.text);
                        }
                    });

                } else if (fieldConfig.type === 'textarea') {
                    field = document.createElement('textarea');
                    field.className = 'form-control form-control-sm';
                    field.id = fieldId;
                    field.setAttribute('data-field-id', fieldConfig.id);
                    field.rows = 3;
                    if (fieldConfig.placeholder) {
                        field.placeholder = fieldConfig.placeholder;
                    }
                } else if (fieldConfig.type === 'checkbox') {
                    var checkboxWrapper = document.createElement('div');
                    checkboxWrapper.className = 'form-check';

                    field = document.createElement('input');
                    field.type = 'checkbox';
                    field.className = 'form-check-input';
                    field.id = fieldId;
                    field.setAttribute('data-field-id', fieldConfig.id);
                    if (fieldConfig.defaultValue) {
                        field.checked = true;
                    }

                    var checkLabel = document.createElement('label');
                    checkLabel.className = 'form-check-label';
                    checkLabel.setAttribute('for', fieldId);
                    checkLabel.textContent = fieldConfig.label;

                    checkboxWrapper.appendChild(field);
                    checkboxWrapper.appendChild(checkLabel);
                    formGroup.innerHTML = '';
                    formGroup.appendChild(checkboxWrapper);
                }

                if (field && fieldConfig.type !== 'checkbox') {
                    formGroup.appendChild(field);
                }

                formFields[fieldConfig.id] = field;
                // dynamicFieldsContainer.appendChild(formGroup);
            });
        }

        // =========================================================================
        // REFERENCE DROPZONE
        // =========================================================================

        AIModalShared.initReferenceDropzone('referenceDropzone', 'referenceFileInput', 'referencePreviews', 'referenceCount');

        // =========================================================================
        // COMPARISON MODAL
        // =========================================================================

        function onSaveButtonUpdate(imageData) {
            var saveButton = document.getElementById('saveToTask');
            if (imageData.saved_orf_id) {
                saveButton.innerHTML = '<i class="fas fa-check mr-1"></i> Already Saved';
                saveButton.disabled = true;
                saveButton.classList.remove('btn-success');
                saveButton.classList.add('btn-secondary');
            } else {
                saveButton.innerHTML = '<i class="fas fa-save mr-1"></i> Save to Task';
                saveButton.disabled = false;
                saveButton.classList.remove('btn-secondary');
                saveButton.classList.add('btn-success');
            }
        }

        AIModalShared.initComparisonModal(originalImageUrl, apiBaseUrl);

        AIModalShared.initPreviewsContainer('aiGeneratedPreviews', function(imageData, index) {
            AIModalShared.openComparisonModal(imageData, index, apiBaseUrl, onSaveButtonUpdate);
        });

        // =========================================================================
        // LOAD PREVIOUS IMAGES
        // =========================================================================

        function loadPreviousImages() {
            previewsContainer.innerHTML = '\
                <div class="text-center py-3">\
                    <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>\
                    <span class="text-muted ml-2">Loading previous images...</span>\
                </div>';

            fetch(apiBaseUrl + '/ai_image_fetch_previous.php?orf_id=' + orfId)
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success && data.data.images.length > 0) {
                        AIModalShared.setGeneratedImages(data.data.images);

                        previewsContainer.innerHTML = '';
                        data.data.images.forEach(function(imageData) {
                            var imagePreview = AIModalShared.createImagePreview(imageData);
                            previewsContainer.appendChild(imagePreview);
                        });
                    } else {
                        AIModalShared.setGeneratedImages([]);
                        previewsContainer.innerHTML = '<div class="text-muted small"><em>No previously generated images yet.</em></div>';
                    }
                    imagesLoaded = true;
                    checkReady();
                })
                .catch(function(error) {
                    console.error('Error loading previous images:', error);
                    AIModalShared.setGeneratedImages([]);
                    previewsContainer.innerHTML = '<div class="text-muted small"><em>Error loading previous images.</em></div>';
                    imagesLoaded = true;
                    checkReady();
                });
        }

        // =========================================================================
        // GENERATE IMAGE HANDLER
        // =========================================================================

        // generateButton.addEventListener('click', function() {
        //     if (isGenerating) {
        //         return;
        //     }

        //     if (!productConfig || !basePrompt) {
        //         AIModalShared.showNotification('Product configuration not loaded. Please refresh the page.', 'warning');
        //         return;
        //     }

        //     var modelSelect = document.getElementById('aiModel');
        //     var productType = productTypeInput.value;

        //     var fieldValues = {};
        //     var hasError = false;

        //     productConfig.fields.forEach(function(fieldConfig) {
        //         var field = formFields[fieldConfig.id];
        //         if (!field) return;

        //         var value = '';
        //         if (fieldConfig.type === 'checkbox') {
        //             value = field.checked;
        //         } else if (fieldConfig.type === 'select' || fieldConfig.type === 'textarea') {
        //             value = field.value.trim();
        //         }

        //         if (fieldConfig.required && !value) {
        //             AIModalShared.showNotification('Please select/enter ' + fieldConfig.label, 'warning');
        //             hasError = true;
        //             return;
        //         }

        //         fieldValues[fieldConfig.id] = value;
        //     });

        //     if (hasError) {
        //         return;
        //     }

        //     isGenerating = true;

        //     var promptVariables = AIModalShared.getPromptVariables(productConfig, formFields, notesTextarea);
        //     var finalPrompt = AIModalShared.buildFinalPrompt(basePrompt, promptVariables);

        //     var formData = new FormData();
        //     formData.append('orf_id', orfId);
        //     formData.append('model', modelSelect.value);
        //     formData.append('product_type', productType);
        //     formData.append('additional_instructions', notesTextarea.value.trim());
        //     formData.append('final_prompt', finalPrompt);

        //     for (var fieldId in fieldValues) {
        //         if (fieldValues.hasOwnProperty(fieldId)) {
        //             formData.append(fieldId, fieldValues[fieldId]);
        //         }
        //     }

        //     // Add user reference images
        //     var referenceImages = AIModalShared.getReferenceImages();
        //     referenceImages.forEach(function(file) {
        //         formData.append('reference_images[]', file);
        //     });

        //     // Add admin reference image URLs
        //     var adminImageUrls = AIModalShared.getAdminReferenceImageUrls();
        //     if (adminImageUrls.length > 0) {
        //         formData.append('admin_reference_images', JSON.stringify(adminImageUrls));
        //     }

        //     // Add edited image if available
        //     if (editedImageDataUrl) {
        //         // Convert data URL to blob
        //         var byteString = atob(editedImageDataUrl.split(',')[1]);
        //         var mimeString = editedImageDataUrl.split(',')[0].split(':')[1].split(';')[0];
        //         var ab = new ArrayBuffer(byteString.length);
        //         var ia = new Uint8Array(ab);
        //         for (var i = 0; i < byteString.length; i++) {
        //             ia[i] = byteString.charCodeAt(i);
        //         }
        //         var blob = new Blob([ab], { type: mimeString });
        //         formData.append('edited_image', blob, 'edited-image.png');
        //     }

        //     generateButton.disabled = true;
        //     AIModalShared.setButtonLoading(generateButton, 'Generating...');
        //     generatingOverlay.classList.add('active');

        //     var restoreButton = function() {
        //         generateButton.disabled = false;
        //         generateButton.textContent = 'Generate Image';
        //         generatingOverlay.classList.remove('active');
        //     };

        //     fetch(apiBaseUrl + '/ai_image_generate.php', {
        //         method: 'POST',
        //         body: formData
        //     })
        //         .then(function(response) { return response.json(); })
        //         .then(function(data) {
        //             if (data.success) {
        //                 var noImagesMessage = previewsContainer.querySelector('.text-muted');
        //                 if (noImagesMessage) {
        //                     noImagesMessage.remove();
        //                 }

        //                 var getFieldLabel = function(fieldId) {
        //                     var field = formFields[fieldId];
        //                     if (!field) return '';
        //                     if (field.tagName === 'SELECT') {
        //                         var selectedOption = field.options[field.selectedIndex];
        //                         return selectedOption ? selectedOption.text : '';
        //                     }
        //                     return field.value;
        //                 };

        //                 var imageData = {
        //                     id: data.data.ai_record_id,
        //                     image_url: data.data.image_url,
        //                     thumbnail_url: data.data.thumbnail_url,
        //                     model: data.data.model,
        //                     room_type: getFieldLabel('room_type') || getFieldLabel('space_type') || getFieldLabel('building_type') || getFieldLabel('plan_type'),
        //                     style_preset: getFieldLabel('style_preset'),
        //                     quality: data.data.size,
        //                     created_at: 'Just now'
        //                 };

        //                 AIModalShared.addGeneratedImage(imageData);

        //                 var imagePreview = AIModalShared.createImagePreview(imageData);
        //                 previewsContainer.insertBefore(imagePreview, previewsContainer.firstChild);

        //                 AIModalShared.showNotification('Image generated successfully!', 'success', 3000);

        //                 AIModalShared.sendToParent('imageGenerated', {
        //                     orf_id: orfId,
        //                     id: data.data.ai_record_id,
        //                     image_url: data.data.image_url,
        //                     thumbnail_url: data.data.thumbnail_url,
        //                     model: data.data.model,
        //                     quality: data.data.size
        //                 });
        //             } else {
        //                 AIModalShared.showNotification('Failed to generate image: ' + (data.error || data.message), 'danger');
        //                 AIModalShared.sendToParent('error', { message: 'Failed to generate image: ' + (data.error || data.message), code: 'GENERATION_FAILED' });
        //             }
        //         })
        //         .catch(function(error) {
        //             console.error('Error:', error);
        //             AIModalShared.showNotification('Failed to generate image: Network error or server unavailable. Please try again.', 'danger');
        //             AIModalShared.sendToParent('error', { message: 'Network error during image generation', code: 'NETWORK_ERROR' });
        //         })
        //         .finally(function() {
        //             restoreButton();
        //             isGenerating = false;
        //         });
        // });

        // =========================================================================
        // VIEW FULL PROMPT HANDLER
        // =========================================================================

        // viewPromptButton.addEventListener('click', function() {
        //     if (!productConfig || !basePrompt) {
        //         AIModalShared.showNotification('Product configuration not loaded. Please refresh the page.', 'warning');
        //         return;
        //     }

        //     var promptVariables = AIModalShared.getPromptVariables(productConfig, formFields, notesTextarea);
        //     var finalPrompt = AIModalShared.buildFinalPrompt(basePrompt, promptVariables);

        //     var promptWindow = window.open('', 'Full Prompt', 'width=800,height=600,scrollbars=yes,resizable=yes');
        //     promptWindow.document.open();
        //     promptWindow.document.write('<html><head><title>Full AI Prompt</title></head><body>');
        //     var pre = promptWindow.document.createElement('pre');
        //     pre.style.whiteSpace = 'pre-wrap';
        //     pre.style.wordWrap = 'break-word';
        //     pre.style.fontFamily = 'monospace';
        //     pre.style.padding = '20px';
        //     pre.textContent = finalPrompt;
        //     promptWindow.document.body.appendChild(pre);
        //     promptWindow.document.write('</body></html>');
        //     promptWindow.document.close();
        // });

        // =========================================================================
        // SAVE TO TASK HANDLER
        // =========================================================================

        var saveToTaskButton = document.getElementById('saveToTask');
        var saveToTaskForm = document.getElementById('saveToTaskForm');
        var saveToTaskSubmit = document.getElementById('saveToTaskSubmit');
        var saveExtensionId = document.getElementById('saveExtensionId');
        var savePresentationName = document.getElementById('savePresentationName');

        saveToTaskButton.addEventListener('click', function() {
            var currentAiRecordId = AIModalShared.getCurrentAiRecordId();
            if (!currentAiRecordId) {
                AIModalShared.showNotification('No AI record selected', 'warning');
                return;
            }

            saveExtensionId.value = '';
            savePresentationName.value = '';

            $('#saveToTaskModal').modal('show');

            $('#saveToTaskModal').one('shown.bs.modal', function() {
                saveExtensionId.focus();
            });
        });

        saveToTaskForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var currentAiRecordId = AIModalShared.getCurrentAiRecordId();
            var idExtension = saveExtensionId.value.trim();
            var presentationName = savePresentationName.value.trim();

            saveToTaskSubmit.disabled = true;
            AIModalShared.setButtonLoading(saveToTaskSubmit, 'Saving...');

            var formData = new FormData();
            formData.append('orf_ai_id', currentAiRecordId);
            formData.append('id_extension', idExtension);
            formData.append('presentation_name', presentationName);

            fetch(apiBaseUrl + '/ai_image_save_to_task.php', {
                method: 'POST',
                body: formData
            })
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success) {
                        $('#saveToTaskModal').modal('hide');
                        $('#comparisonModal').modal('hide');

                        AIModalShared.showNotification('Image saved to task successfully!', 'success', 2000);

                        AIModalShared.sendToParent('imageSaved', {
                            orf_id: orfId,
                            orf_ai_id: currentAiRecordId,
                            saved_orf_id: data.data.saved_orf_id
                        });
                    } else {
                        AIModalShared.showNotification('Failed to save image: ' + (data.error || data.message), 'danger');
                        AIModalShared.sendToParent('error', { message: 'Failed to save image: ' + (data.error || data.message), code: 'SAVE_FAILED' });
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    AIModalShared.showNotification('Failed to save image: ' + error.message, 'danger');
                    AIModalShared.sendToParent('error', { message: 'Network error during save', code: 'NETWORK_ERROR' });
                })
                .finally(function() {
                    saveToTaskSubmit.disabled = false;
                    AIModalShared.setButtonWithIcon(saveToTaskSubmit, 'fas fa-save', 'Save');
                });
        });

        // =========================================================================
        // CLOSE BUTTON HANDLERS
        // =========================================================================

        function handleClose() {
            AIModalShared.sendToParent('close', { orf_id: orfId });
        }

        closeModalBtn.addEventListener('click', handleClose);
        closeModalBtnFooter.addEventListener('click', handleClose);

        // =========================================================================
        // SUPERGRUNDRISS (florplans.blue7.it) 2D FLOOR PLAN INTEGRATION
        // =========================================================================
        //
        // Implements the full flow against the public Supergrundriss API
        // documented at https://supergrundriss.de/api/v1/docs:
        //
        //   1. Collect form data from the 8 required sections
        //      (2D/3D-Plan, level, environment, bathroom, kitchen, rest,
        //       terrace+balcony, technic) + colors/textures + quality.
        //   2. Validate; surface inline errors and block submit if any
        //      required field is missing.
        //   3. POST multipart/form-data to /v1/generate:
        //        - main_image            (binary)
        //        - tool_slug             (string)            REQUIRED
        //        - quality_tier          (string)
        //        - settings_json         (JSON-encoded)      sections object
        //        - preset                (string, optional)  selected color preset
        //        - additional_instructions (string)          human-readable
        //   4. If status !== 'completed', poll GET /v1/generations/{id}
        //      every 2 seconds for up to 4 minutes.
        //   5. Bearer-fetch the result image as a Blob and display in the
        //      results modal (above the main modal) with a drag-style
        //      before/after compare slider.
        //
        // Authentication: requires `Authorization: Bearer flp_xxx` plus an
        // origin in the key whitelist. The key is sourced (in priority order):
        //   1. URL parameter `?sg_key=flp_...`
        //   2. window.SUPERGRUNDRISS_CONFIG.apiKey on the parent page
        //   3. Hard-coded fallback below (legacy — should be moved server-side)
        //
        // TODO: Move credential plumbing server-side (proxy endpoint that injects
        //       the key) so the API key never touches the browser. Update
        //       `sgFetch()` and `sgGenerate()` below to point at that proxy.

        var SUPERGRUNDRISS_CONFIG = (window.SUPERGRUNDRISS_CONFIG && typeof window.SUPERGRUNDRISS_CONFIG === 'object')
            ? window.SUPERGRUNDRISS_CONFIG
            : {};
        SUPERGRUNDRISS_CONFIG.apiBaseUrl = urlParams.get('sg_base') || SUPERGRUNDRISS_CONFIG.apiBaseUrl || 'https://supergrundriss.de/api/v1';
        SUPERGRUNDRISS_CONFIG.apiKey = urlParams.get('sg_key') || SUPERGRUNDRISS_CONFIG.apiKey || 'flp_VR66bZl5Y448Yw6SSOA8Kk2Tdy4Tc6SA';
        SUPERGRUNDRISS_CONFIG.defaultToolSlug = urlParams.get('sg_tool') || SUPERGRUNDRISS_CONFIG.defaultToolSlug || 'floorplan-2d';

        // Timing knobs (override via window.SUPERGRUNDRISS_CONFIG if needed)
        SUPERGRUNDRISS_CONFIG.requestTimeoutMs = SUPERGRUNDRISS_CONFIG.requestTimeoutMs || 240000; // 4 min hard cap
        SUPERGRUNDRISS_CONFIG.pollIntervalMs   = SUPERGRUNDRISS_CONFIG.pollIntervalMs   || 2000;
        SUPERGRUNDRISS_CONFIG.pollMaxMs        = SUPERGRUNDRISS_CONFIG.pollMaxMs        || 240000; // 4 min poll cap

        var sgApiHost = (function() {
            try { return new URL(SUPERGRUNDRISS_CONFIG.apiBaseUrl).origin; }
            catch (e) { return ''; }
        })();

        // -----------------------------------------------------------------
        // DOM references — left panel
        // -----------------------------------------------------------------
        // The left panel now only carries the tool / preset / quality
        // selectors. All per-task option sections (level, environment,
        // bathroom, kitchen, rest, terrace+balcony, technic) live in the
        // center "Fine-tune Generation Prompt" column (#aiDynamicFields)
        // and are validated by sgRequiredFieldsValid().
        var sgPanelEl            = document.getElementById('sgPanel');
        var sgPanelStatus        = document.getElementById('sgPanelStatus');
        var sgPlanTypeBox        = document.getElementById('sgPlanType');
        var sgToolSelect         = document.getElementById('sgTool');
        var sgFurnitureBox       = document.getElementById('sgFurniture');
        var sgPresetsBox         = document.getElementById('sgPresets');
        var sgQualityBox         = document.getElementById('sgQuality');
        var generateFloorPlanBtn = document.getElementById('generateFloorPlan');

        // -----------------------------------------------------------------
        // DOM references — progress & results modals
        // -----------------------------------------------------------------
        var sgProgressBackdrop = document.getElementById('sgProgressBackdrop');
        var sgProgressElapsed  = document.getElementById('sgProgressElapsed');
        var sgProgressBarFill  = document.getElementById('sgProgressBarFill');
        var sgProgressStatus   = document.getElementById('sgProgressStatus');

        var sgResultsBackdrop  = document.getElementById('sgResultsBackdrop');
        var sgResultsClose     = document.getElementById('sgResultsClose');
        var sgResultsCloseBtn  = document.getElementById('sgResultsCloseBtn');
        var sgResultThumbs     = document.getElementById('sgResultThumbs');
        var sgResultCount      = document.getElementById('sgResultCount');
        var sgResultMeta       = document.getElementById('sgResultMeta');
        var sgDownloadBtn      = document.getElementById('sgDownloadBtn');

        var sgCompareEl        = document.getElementById('sgCompare');
        var sgCompareStage     = document.getElementById('sgCompareStage');
        var sgCompareBefore    = document.getElementById('sgCompareBefore');
        var sgCompareAfter     = document.getElementById('sgCompareAfter');
        var sgCompareAfterWrap = document.getElementById('sgCompareAfterWrap');
        var sgCompareHandle    = document.getElementById('sgCompareHandle');

        // -----------------------------------------------------------------
        // Internal state
        // -----------------------------------------------------------------
        // sgState mirrors the *current* left-panel selection (tool, preset,
        // quality, furniture). Center-form fields are validation-only gates
        // and are no longer persisted into settings_json — see
        // sgBuildSettingsJson() for the new minimal {furniture, preset}
        // payload shape.
        //
        // Furniture mapping
        // -----------------
        // `furniture` holds the *raw* value of the active furniture tab (the
        // value the API expects in settings_json.furniture). The matching
        // human-readable label only lives on the DOM (chip text). Values are
        // sourced live from GET /v1/tools controls.furniture for floorplan-2d
        // (the same option set is reused for floorplan-3d). We seed it with
        // '' so validation forces the user to make an explicit pick — the
        // API's own default ("living") is then highlighted by the live render
        // step if /tools resolves, which feels equivalent without bypassing
        // validation when the API call fails.
        var sgState = {
            toolSlug:          SUPERGRUNDRISS_CONFIG.defaultToolSlug,
            quality_tier:      'standard',
            color_texture_set: '',
            furniture:         ''
        };

        // Live snapshot of the furniture options exposed by the floorplan
        // tools' controls[]. Populated by sgInitPanel() after /tools resolves;
        // falls back to the static HTML markup if the call fails. Each entry
        // matches the shape returned by the API: { value, label, default? }.
        var sgFurnitureOptions = [];

        // The exact ids of the required center-form fields, sourced from
        // the product configuration loaded by ai_get_product_config.php
        // and rendered into #aiDynamicFields by renderDynamicFields().
        // These ids are case-sensitive and match the values returned by
        // the backend, so do NOT lowercase them. The Generate 2D Floor
        // Plan button stays disabled until each one has a non-empty value.
        var sgRequiredCenterFieldIds = [
            '2Dplan',
            'Bathroom1',
            'Kitchen1',
            'Floor1',
            'Environment',
            'Terracebalcony',
            'Technic'
        ];

        // Cache of /v1/presets so 2D <-> 3D switching is instant.
        var sgPresetsCache = [];

        // Cache of the current results modal images (for thumbnail strip).
        var sgResults = { items: [], currentIndex: 0, originalUrl: '' };

        // Single source of truth for "are we generating right now?" — used to
        // block duplicate submissions and disable form interaction.
        var sgIsGenerating = false;

        // Active abort controller (cleared when the request settles); lets us
        // tear down a long-running poll if the user closes the modal.
        var sgActiveAbort = null;

        function sgIsThreeD() {
            return String(sgState.toolSlug || '').toLowerCase().indexOf('3d') !== -1;
        }

        function sgPickPreviewImage(item) {
            if (!item) return null;
            if (sgIsThreeD()) return item.preview_image_3d || item.preview_image || null;
            return item.preview_image || item.preview_image_3d || null;
        }

        function sgSetStatus(message, isError) {
            if (!sgPanelStatus) return;
            sgPanelStatus.textContent = message || '';
            sgPanelStatus.className = 'sg-status' + (isError ? ' error' : '');
            sgPanelStatus.style.display = message ? 'block' : 'none';
        }

        // -------------------------------------------------------------------------
        // Helpers — HTTP
        // -------------------------------------------------------------------------

        function sgAuthHeaders(extra) {
            var h = { 'Authorization': 'Bearer ' + SUPERGRUNDRISS_CONFIG.apiKey, 'Accept': 'application/json' };
            if (extra) for (var k in extra) h[k] = extra[k];
            return h;
        }

        function sgFetch(path) {
            if (!SUPERGRUNDRISS_CONFIG.apiKey) {
                return Promise.reject(new Error('Missing Supergrundriss API key. Configure via ?sg_key=... or window.SUPERGRUNDRISS_CONFIG.apiKey.'));
            }
            return fetch(SUPERGRUNDRISS_CONFIG.apiBaseUrl + path, { method: 'GET', headers: sgAuthHeaders() })
                .then(function(res) {
                    return res.json().then(function(body) {
                        if (!res.ok || !body || body.success !== true) {
                            var msg = (body && (body.error || body.message)) || ('HTTP ' + res.status);
                            var err = new Error(msg);
                            err.code = (body && body.code) || ('HTTP_' + res.status);
                            err.status = res.status;
                            throw err;
                        }
                        return body.data;
                    });
                });
        }

        // Authenticated download of a Supergrundriss-hosted image -> object URL
        // (result images require the Bearer token, so <img src> won't work
        // directly). Object URLs are revoked when the results modal closes.
        function sgFetchImageObjectUrl(relPath) {
            if (!relPath) return Promise.resolve(null);
            var url = (relPath.indexOf('http') === 0) ? relPath : (sgApiHost + relPath);
            return fetch(url, { headers: sgAuthHeaders() })
                .then(function(res) {
                    if (!res.ok) throw new Error('Image download HTTP ' + res.status);
                    return res.blob();
                })
                .then(function(blob) { return URL.createObjectURL(blob); });
        }

        // -----------------------------------------------------------------
        // Persist the rendered floor plan to "Previously Generated Images"
        // -----------------------------------------------------------------
        //
        // After we have the Blob from sgGetResultImage(), POST it to
        // ai_image_generate.php in REGISTER-ONLY MODE (skip_generation=1)
        // so it shows up in the same #aiGeneratedPreviews strip as images
        // produced by the regular Generate Image flow.
        //
        // This mirrors the OLD save flow from
        // backup-05-02-2026/ai_image_modal_task_default.php EXACTLY:
        //
        //   1. ai_image_generate.php  → creates o_results_ai row and
        //                               returns ai_record_id (= orf_ai_id).
        //                               Same row, same columns, same
        //                               thumbnail pipeline as a native
        //                               generation — only the blue7.it
        //                               call is skipped because we already
        //                               have the rendered image bytes from
        //                               Supergrundriss.
        //   2. ai_image_save_to_task.php → uses orf_ai_id to attach the
        //                               image to the task (wired to the
        //                               unchanged "Save to Task" form
        //                               handler further down). Frontend
        //                               and backend contract for this step
        //                               are 100% reused from the OLD flow.
        //
        // Reuse, not duplication: register-only mode is a new branch
        // INSIDE ai_image_generate.php (see $skip_generation), so the DB
        // insert and thumbnail logic live in exactly one place.
        //
        // This is a best-effort step: if the register call fails the SG
        // results modal + Download button still work, so we surface a
        // warning rather than fail the whole generation.
        //
        // Request body (multipart/form-data) — matches the contract of
        // ai_image_generate.php's register-only mode:
        //
        //   skip_generation=1        — selects the register-only branch
        //   orf_id                   — parent o_results record (required)
        //   model                    — "supergrundriss" (populates the
        //                              `model` column; preserves rich
        //                              metadata in the previews strip)
        //   product_type             — "floorplan" (required by the
        //                              endpoint's existing validation)
        //   final_prompt             — human-readable summary for the
        //                              audit log (required)
        //   room_type                — tool_type ("floorplan-2d" / -3d)
        //                              — mapped to the legacy room_type
        //                              column by ai_image_generate.php
        //   style_preset             — selected Colors & Textures preset
        //                              slug — mapped to the legacy
        //                              style_preset column
        //   quality                  — quality_tier ("standard"/"premium")
        //                              — mapped to the legacy quality
        //                              column
        //   additional_instructions  — free-form notes from #aiNotes
        //   generated_image_file     — the rendered floor plan Blob
        //                              (PNG/JPG/WebP) — required for the
        //                              register branch
        //   generation_id            — SG generation id (audit metadata,
        //                              stored in field_values JSON)
        //   tool_slug, quality_tier, preset, furniture, provider — same:
        //                              persisted into field_values JSON
        //                              for future inspection/debugging
        //
        // Response (success — same shape as a native generation):
        //   { success: true, data: { ai_record_id, orf_ai_id, image_url,
        //                            thumbnail_url, model, size,
        //                            registered: true } }
        function sgSaveToPreviousImages(generation, resultImage) {
            if (!resultImage || !resultImage.blob) {
                return Promise.reject(new Error('Cannot save: no rendered image blob available.'));
            }
            if (!orfId) {
                return Promise.reject(new Error('Cannot save: missing orf_id for the source image.'));
            }

            var filename = resultImage.filename || ('supergrundriss-' +
                ((generation && generation.id) || Date.now()) + '.png');

            // Build a short human-readable prompt summary mirroring what
            // ai_image_generate.php normally stores in the AI record so
            // the previews strip shows useful labels later on.
            var promptSummaryParts = [];
            if (generation && generation.tool_type)    promptSummaryParts.push('Tool: ' + generation.tool_type);
            if (generation && generation.quality_tier) promptSummaryParts.push('Quality: ' + generation.quality_tier);
            if (sgState.color_texture_set)             promptSummaryParts.push('Preset: ' + sgState.color_texture_set);
            if (sgState.furniture)                     promptSummaryParts.push('Furniture: ' + sgState.furniture);
            var notesVal = (notesTextarea && notesTextarea.value || '').trim();
            if (notesVal) promptSummaryParts.push('Notes: ' + notesVal);
            var promptSummary = promptSummaryParts.join(' | ') ||
                                'Supergrundriss floor plan generation';

            var fd = new FormData();
            // ── Required by ai_image_generate.php (both native + register modes)
            fd.append('skip_generation', '1');
            fd.append('orf_id',          orfId);
            fd.append('model',           'supergrundriss');
            fd.append('product_type',    'floorplan');
            fd.append('final_prompt',    promptSummary);
            fd.append('additional_instructions', notesVal);

            // ── Legacy descriptor columns (mapped server-side by name)
            if (generation && generation.tool_type)    fd.append('room_type',    generation.tool_type);
            if (sgState.color_texture_set)             fd.append('style_preset', sgState.color_texture_set);
            if (generation && generation.quality_tier) {
                fd.append('quality', generation.quality_tier);
            } else if (sgState.quality_tier) {
                fd.append('quality', sgState.quality_tier);
            }

            // ── Register-only payload: the rendered image itself.
            fd.append('generated_image_file', resultImage.blob, filename);

            // ── Audit metadata, stashed in field_values JSON server-side.
            fd.append('provider', 'supergrundriss');
            if (generation && generation.id != null)   fd.append('generation_id', generation.id);
            if (generation && generation.tool_type)    fd.append('tool_slug',     generation.tool_type);
            if (generation && generation.quality_tier) fd.append('quality_tier',  generation.quality_tier);
            if (sgState.color_texture_set)             fd.append('preset',        sgState.color_texture_set);
            if (sgState.furniture)                     fd.append('furniture',     sgState.furniture);

            console.log('[SG] POST ai_image_generate.php (register-only) ->',
                apiBaseUrl + '/ai_image_generate.php',
                'bytes=' + resultImage.blob.size,
                'mime=' + (resultImage.blob.type || '?'));

            return fetch(apiBaseUrl + '/ai_image_generate.php', {
                method: 'POST',
                body: fd
            })
                .then(function(res) {
                    return res.text().then(function(text) {
                        var body;
                        try { body = text ? JSON.parse(text) : {}; }
                        catch (e) {
                            throw new Error('Malformed register response (HTTP ' + res.status + ').');
                        }
                        console.log('[SG] ai_image_generate.php (register) <-', res.status, body);
                        if (!res.ok || !body || body.success !== true) {
                            var msg = (body && (body.error || body.message)) || ('HTTP ' + res.status);
                            var err = new Error(msg);
                            err.code = (body && body.code) || ('HTTP_' + res.status);
                            err.status = res.status;
                            throw err;
                        }
                        var data = body.data || {};
                        // Normalise the response so callers always see a
                        // single `orf_ai_id` key regardless of which
                        // alias the server returned (matches the OLD
                        // flow's `ai_record_id` convention too).
                        data.orf_ai_id = data.orf_ai_id ||
                                         data.ai_record_id ||
                                         data.id ||
                                         null;
                        return data;
                    });
                });
        }

        // -----------------------------------------------------------------
        // Build the shared imageData shape from a successful save response.
        // -----------------------------------------------------------------
        //
        // Returns the EXACT shape the OLD ai_image_modal_task_default.php
        // built (see backup lines 774-783). Centralising this means the
        // single-image and multi-image code paths produce identical objects,
        // which is critical because:
        //
        //   - AIModalShared.createImagePreview reads .id / .thumbnail_url /
        //     .image_url / .room_type / .style_preset / .model
        //   - AIModalShared.openComparisonModal reads .image_url / .model /
        //     .room_type / .style_preset / .quality / .created_at
        //   - AIModalShared.getCurrentAiRecordId returns whatever .id we
        //     stored, and the unchanged Save-to-Task form handler at
        //     line ~1608 reads that value to POST orf_ai_id to
        //     ai_image_save_to_task.php (the OLD endpoint contract).
        function sgBuildImageData(item, saved) {
            return {
                id:             saved.orf_ai_id,
                image_url:      saved.image_url     || item.imageObjectUrl,
                thumbnail_url:  saved.thumbnail_url || item.thumbObjectUrl || item.imageObjectUrl,
                model:          saved.model         || 'supergrundriss',
                room_type:      (item.generation && item.generation.tool_type) || '',
                style_preset:   sgState.color_texture_set || '',
                quality:        (item.generation && item.generation.quality_tier) || sgState.quality_tier || '',
                created_at:     'Just now',
                // Carry the SG-side metadata along for any downstream
                // consumers (e.g. parent window) that may want to surface it.
                provider:       'supergrundriss',
                generation_id:  item.generation && item.generation.id
            };
        }

        // -----------------------------------------------------------------
        // Persist a batch of generated items (1 or N) sequentially.
        // -----------------------------------------------------------------
        //
        // Why sequentially?
        //   - ai_image_generate.php (register-only) writes to disk + DB.
        //     Running N parallel POSTs would race on filename generation
        //     ('full_' . $ai_record_id . '_' . time() . '.<ext>'); the
        //     time() bucket has 1-second resolution so two saves landing
        //     in the same second would collide.
        //   - Sequential POSTs also keep the UI in a predictable order:
        //     thumbnails appear in generation order in the strip.
        //
        // Per-image error isolation: a failed save warns once and moves on.
        // The successful saves still appear in the strip and emit
        // `imageRegistered` events (NOT `imageSaved` — see explanation at
        // the emit site below). The whole generation flow only errors out
        // if ALL items fail (which is already covered by the outer .catch
        // via the upstream Promise.allSettled in the download step).
        //
        // Why this matters for the SG results modal staying visible:
        //   The SG results modal (sgResultsBackdrop) is opened by
        //   sgOpenResults() BEFORE this function runs and is NEVER closed
        //   by the save pipeline. Closure only happens on explicit user
        //   action — sgCloseResults() is wired to the close button, the
        //   secondary Close button, and backdrop click. The parent page
        //   also cannot close us via `imageSaved` because we don't emit
        //   that event from here.
        function sgPersistGeneratedItems(items) {
            if (!items || !items.length) return Promise.resolve([]);

            var failures = 0;
            var savedItems = [];

            // Hide the "No previously generated images yet." placeholder
            // up front so the user sees thumbnails appearing in real time.
            if (previewsContainer) {
                var placeholder = previewsContainer.querySelector('.text-muted');
                if (placeholder) placeholder.remove();
            }

            return items.reduce(function(chain, item, idx) {
                return chain.then(function() {
                    sgSetProgressStatus(items.length > 1
                        ? 'Saving image ' + (idx + 1) + ' of ' + items.length + '…'
                        : 'Saving to previously generated images…');

                    return sgSaveToPreviousImages(item.generation, item.resultImage)
                        .then(function(saved) {
                            console.log('[SG] saved to ai records ->', saved);

                            // Defensive: even on HTTP 200 the backend may
                            // not return an id (legacy deployment). In
                            // that case skip the local strip insert and
                            // warn — the canonical previous-images fetch
                            // on next modal open will pick it up if the
                            // server did store it.
                            if (!saved || saved.orf_ai_id == null) {
                                console.warn('[SG] save succeeded but no orf_ai_id in response; skipping local preview insert.');
                                AIModalShared.showNotification(
                                    'Floor plan saved, but the server did not return a record id. Reopen the modal to refresh the list.',
                                    'warning', 5000);
                                return;
                            }

                            var newImageData = sgBuildImageData(item, saved);
                            savedItems.push(newImageData);

                            try {
                                AIModalShared.addGeneratedImage(newImageData);
                                if (previewsContainer && AIModalShared.createImagePreview) {
                                    var thumb = AIModalShared.createImagePreview(newImageData);
                                    previewsContainer.insertBefore(thumb, previewsContainer.firstChild);
                                }
                            } catch (uiErr) {
                                // UI integration failures should never
                                // break the save flow — just log them.
                                console.warn('[SG] preview strip integration failed:', uiErr);
                            }

                            // IMPORTANT: do NOT emit `imageSaved` here.
                            //
                            // `imageSaved` in the OLD ai_image_modal_task_default.php
                            // flow ONLY fires after the user explicitly clicks
                            // "Save to Task" — and embedding parents (incl.
                            // the production page) commonly use that event as
                            // their signal to close the iframe, refresh the
                            // task list, or even navigate away. Firing it
                            // here for the automatic DB register would steal
                            // that close/redirect trigger and rip the SG
                            // results modal out from under the user before
                            // they ever see their generated image.
                            //
                            // Use a distinct event name (`imageRegistered`)
                            // so the parent can choose to react to the DB
                            // register separately if it wants, without
                            // overloading the Save-to-Task contract.
                            AIModalShared.sendToParent('imageRegistered', {
                                orf_id:        orfId,
                                provider:      'supergrundriss',
                                generation_id: item.generation && item.generation.id,
                                orf_ai_id:     saved.orf_ai_id,
                                image_url:     saved.image_url     || null,
                                thumbnail_url: saved.thumbnail_url || null,
                                model:         saved.model         || 'supergrundriss'
                            });
                        })
                        .catch(function(saveErr) {
                            failures++;
                            console.warn('[SG] save to previous images failed (item ' + idx + '):', saveErr);
                            AIModalShared.showNotification(
                                'Image ' + (idx + 1) + ' generated, but saving to Previously Generated Images failed: ' +
                                ((saveErr && saveErr.message) || 'unknown error') +
                                '. You can still download it from the results modal.',
                                'warning', 6000);
                            AIModalShared.sendToParent('error', {
                                message: 'Failed to save generated floor plan to DB (item ' + (idx + 1) + '): ' +
                                         ((saveErr && saveErr.message) || 'unknown'),
                                code: (saveErr && saveErr.code) || 'SG_DB_SAVE_FAILED'
                            });
                        });
                });
            }, Promise.resolve()).then(function() {
                if (failures === 0 && savedItems.length > 1) {
                    AIModalShared.showNotification(
                        'All ' + savedItems.length + ' images saved to Previously Generated Images.',
                        'success', 3000);
                }
                return savedItems;
            });
        }

        // -----------------------------------------------------------------
        // Explicit post-generation GET — result_image_url
        // -----------------------------------------------------------------
        //
        // After /v1/generate (and any polling) settles, the generation
        // record carries a `result_image_url` like "/api/generations/482/image"
        // pointing at the bearer-protected binary endpoint that returns the
        // rendered floor plan as raw bytes (PNG by default — see API docs
        // Walkthrough A, step 4).
        //
        // This helper performs an explicit GET to that URL after generation
        // is complete. It is intentionally separate from sgFetchImageObjectUrl
        // (which is reused for any bearer-protected image — presets,
        // thumbnails, etc.) so the post-generation "fetch the final image"
        // step is clearly auditable in code + DevTools + console logs.
        //
        // Returns Promise<{ response, blob, objectUrl, url }> on success.
        // Rejects on missing URL, HTTP error, abort, or empty body.
        function sgGetResultImage(generation, abortSignal) {
            if (!generation || !generation.result_image_url) {
                return Promise.reject(new Error('Generation has no result_image_url to fetch.'));
            }
            var rel = generation.result_image_url;
            var url = (rel.indexOf('http') === 0) ? rel : (sgApiHost + rel);

            console.log('[SG] GET result_image_url ->', url);
            sgSetProgressStatus('Fetching result image…');

            return fetch(url, {
                method:  'GET',
                headers: sgAuthHeaders(),
                signal:  abortSignal
            }).then(function(res) {
                console.log('[SG] GET result_image_url <-', res.status, res.headers.get('content-type') || '');
                if (!res.ok) {
                    var err = new Error('result_image_url GET failed (HTTP ' + res.status + ').');
                    err.status = res.status;
                    throw err;
                }
                return res.blob().then(function(blob) {
                    if (!blob || blob.size === 0) {
                        throw new Error('result_image_url returned an empty body.');
                    }
                    var objectUrl = URL.createObjectURL(blob);
                    console.log('[SG] result_image bytes=' + blob.size + ' type=' + (blob.type || '?'));
                    return { response: res, blob: blob, objectUrl: objectUrl, url: url };
                });
            });
        }

        // -------------------------------------------------------------------------
        // Helpers — center-form access
        // -------------------------------------------------------------------------

        // Resolve a center-form field by id. Falls back to a direct DOM
        // lookup so we still work if formFields[] has not been populated
        // yet (e.g. before renderDynamicFields() finishes).
        function sgGetCenterField(id) {
            return (formFields && formFields[id]) || document.getElementById(id) || null;
        }

        // Read the user-facing value of a center-form field. SELECT/INPUT/
        // TEXTAREA → trimmed string value, CHECKBOX → boolean .checked.
        // Returns '' (or false for checkboxes) when the field is missing
        // so callers can use a single empty-check.
        function sgGetCenterFieldValue(id) {
            var f = sgGetCenterField(id);
            if (!f) return '';
            if (f.type === 'checkbox') return !!f.checked;
            if (f.type === 'radio') {
                var name = f.name;
                if (name) {
                    var picked = document.querySelector('input[type="radio"][name="' + name + '"]:checked');
                    return picked ? (picked.value || '') : '';
                }
                return f.checked ? (f.value || '') : '';
            }
            return (f.value || '').toString().trim();
        }

        // Treat a center-form value as "filled" when it is a non-empty
        // string or a truthy boolean. We deliberately do NOT treat "0" as
        // empty because some product configurations use numeric option
        // values that include zero.
        function sgIsFilled(value) {
            if (value === true)  return true;
            if (value === false) return false;
            return value !== null && value !== undefined && String(value).trim() !== '';
        }

        // -------------------------------------------------------------------------
        // Helpers — validation
        // -------------------------------------------------------------------------

        // Real-time validity check used by the button-state evaluator.
        // Returns true iff every required center-form field has a value.
        // No DOM mutation, no toasts — this runs on every input event.
        function sgRequiredFieldsValid() {
            for (var i = 0; i < sgRequiredCenterFieldIds.length; i++) {
                var id = sgRequiredCenterFieldIds[i];
                var f = sgGetCenterField(id);
                if (!f) return false; // field not rendered yet → stay disabled
                if (!sgIsFilled(sgGetCenterFieldValue(id))) return false;
            }
            return true;
        }

        // Furniture must be one of the API-returned values. We accept either
        // a value from the live /tools fetch (sgFurnitureOptions) or, if the
        // /tools call failed and we are still on the static markup, any of
        // the four fallback values rendered in the HTML. Either way, the
        // raw value is what ends up in settings_json.furniture.
        function sgFurnitureSelected() {
            return !!(sgState.furniture && String(sgState.furniture).trim());
        }

        // Preset must be a non-empty slug. There is only one writer for
        // sgState.color_texture_set (the sgRenderCardGrid onPick callback),
        // so this also guarantees the matching settings_json.preset entry
        // and the top-level multipart `preset` field are both populated.
        function sgPresetSelected() {
            return !!(sgState.color_texture_set && String(sgState.color_texture_set).trim());
        }

        // Single source of truth for the Generate button's disabled state.
        // The button is disabled when any of the following are true:
        //   - we are mid-generation (sgIsGenerating)
        //   - the API key is not configured
        //   - any required center-form field is empty
        //   - no furniture tab is currently active (sgState.furniture is '')
        //   - no Colors & Textures preset is selected
        //     (sgState.color_texture_set is '')
        // The title attribute is updated to give the user a hint about why
        // the button is locked.
        //
        // Validation flow (single source of truth)
        // ----------------------------------------
        // Inputs   : generation lock, API key presence, center-form fields,
        //            sgState.furniture, sgState.color_texture_set
        // Triggers : sgAttachCenterFormValidation() delegated input/change,
        //            furniture click handler in sgInitFurnitureSection(),
        //            preset click in sgRenderCardGrid() onPick callback,
        //            sgInitPanel() after /tools and /presets resolve,
        //            generation start/end transitions.
        // Output   : generateFloorPlanBtn.disabled + .title
        function sgUpdateGenerateButtonState() {
            if (!generateFloorPlanBtn) return;
            var reason = null;
            if (sgIsGenerating)                    reason = 'Generation in progress…';
            else if (!SUPERGRUNDRISS_CONFIG.apiKey) reason = 'Supergrundriss API key not configured.';
            else if (!sgFurnitureSelected())       reason = 'Pick a Furniture option in the Floor Plan Options panel.';
            else if (!sgPresetSelected())          reason = 'Pick a Colors & Textures preset in the Floor Plan Options panel.';

            generateFloorPlanBtn.disabled = reason !== null;
            generateFloorPlanBtn.title = reason || 'Generate via Supergrundriss /v1/generate';
        }

        // Wire real-time validation listeners to the center dynamic-fields
        // container and the right-column notes textarea. Uses event
        // delegation so we don't have to re-bind every time
        // renderDynamicFields() rebuilds the field tree.
        function sgAttachCenterFormValidation() {
            // if (dynamicFieldsContainer) {
            //     ['input', 'change'].forEach(function(evt) {
            //         dynamicFieldsContainer.addEventListener(evt, sgUpdateGenerateButtonState);
            //     });
            // }
            if (notesTextarea) {
                notesTextarea.addEventListener('input', sgUpdateGenerateButtonState);
            }
        }

        // -------------------------------------------------------------------------
        // Source image acquisition
        // -------------------------------------------------------------------------
        //
        // /v1/generate requires `main_image` as a binary file inside a
        // multipart/form-data request (the docs show `-F "main_image=@./sketch.png"`
        // and list PNG / JPG / WebP / PDF — max 20 MB as the supported types).
        // The DOM is the single source of truth for which image to send: the
        // <img> inside #sourceImageContainer is what the user actually sees
        // and is the same element the image editor mutates when an edit is
        // applied (src → data: URL) or reverted (src → original URL).
        //
        // Reading directly from `#sourceImageContainer img` therefore gives
        // us the currently-displayed image whether the user edited it or
        // not — no need to juggle separate originalImageUrl vs
        // editedImageDataUrl variables here. We then turn that src into a
        // Blob via two paths:
        //   - data: URL  → atob() the base64 payload to bytes + Blob with
        //                  the declared MIME (zero network round-trip).
        //   - http(s):   → fetch() the URL with CORS, take .blob().
        //
        // Either way the result is a Blob whose `.type` tells the server
        // the real MIME — the FormData filename is just a label, the server
        // sniffs from the Blob's type. We pick a sensible filename so it
        // shows up correctly in any debugging/inspector view.

        // Map a MIME from the API's accepted set to a filename. Falls back
        // to .png for unknown types so multipart still wraps the upload.
        var SG_MIME_TO_EXT = {
            'image/png':  'png',
            'image/jpeg': 'jpg',
            'image/jpg':  'jpg',
            'image/webp': 'webp',
            'application/pdf': 'pdf'
        };
        function sgFilenameForMime(mime) {
            return 'source.' + (SG_MIME_TO_EXT[(mime || '').toLowerCase()] || 'png');
        }

        // Read the src of the <img> currently displayed inside
        // #sourceImageContainer. Single source of truth for what gets sent
        // as main_image — kept in sync with editedImageDataUrl by the
        // image editor and with originalImageUrl by the Revert button.
        function sgGetSourceImageSrc() {
            var sourceImg = document.querySelector('#sourceImageContainer img');
            return sourceImg && sourceImg.src ? sourceImg.src : '';
        }

        // Decode a data: URL into a Blob (with the declared MIME).
        function sgDataUrlToBlob(dataUrl) {
            var parts = dataUrl.split(',');
            var mime  = parts[0].split(':')[1].split(';')[0];
            var bin   = atob(parts[1]);
            var buf   = new ArrayBuffer(bin.length);
            var view  = new Uint8Array(buf);
            for (var i = 0; i < bin.length; i++) view[i] = bin.charCodeAt(i);
            return new Blob([buf], { type: mime });
        }

        // Returns a Promise<{ blob, filename }> for the image to send as
        // `main_image`. Reads its src EXCLUSIVELY from the
        // #sourceImageContainer <img> element so the upload always matches
        // what the user sees on screen. Cross-origin fetch may fail —
        // surface a clear error so the user knows to either re-edit the
        // image (which produces a same-origin data: URL) or fix the CORS
        // headers on the host.
        function sgGetSourceBlob() {
            var src = sgGetSourceImageSrc();
            if (!src) {
                return Promise.reject(new Error('No source image available to upload (#sourceImageContainer img has no src).'));
            }

            if (src.indexOf('data:') === 0) {
                try {
                    var blob = sgDataUrlToBlob(src);
                    return Promise.resolve({ blob: blob, filename: sgFilenameForMime(blob.type) });
                } catch (e) {
                    return Promise.reject(new Error('Failed to decode source image data URL: ' + e.message));
                }
            }

            return fetch(src, { mode: 'cors' })
                .then(function(res) {
                    if (!res.ok) throw new Error('Source image HTTP ' + res.status);
                    return res.blob();
                })
                .then(function(blob) {
                    return { blob: blob, filename: sgFilenameForMime(blob.type) };
                })
                .catch(function(e) {
                    throw new Error('Could not download the source image (CORS or network). ' +
                        'Use "Edit Image" first or expose the image with CORS. (' + e.message + ')');
                });
        }

        // -------------------------------------------------------------------------
        // Furniture tabs rendering
        // -------------------------------------------------------------------------
        //
        // Renders the `furniture` segment from the data we got back from
        // GET /v1/tools (controls[] where key === 'furniture'). One tab per
        // API option, in order; only ONE tab can be active at a time. Click
        // updates sgState.furniture (raw value, matches the API) and forces
        // a button-state recompute so validation lights up immediately.
        //
        // Reuses the .sg-chip token used by 2D/3D and Quality so styling
        // (hover, focus, active, disabled) stays in sync with the rest of
        // the left panel — no duplicate listeners or per-tab event wiring.
        function sgRenderFurnitureTabs(options) {
            if (!sgFurnitureBox) return;
            sgFurnitureBox.innerHTML = '';

            if (!Array.isArray(options) || !options.length) {
                sgFurnitureBox.innerHTML = '<div class="sg-status">No furniture options available.</div>';
                sgUpdateGenerateButtonState();
                return;
            }

            // If the previously selected value is no longer in the option set
            // (e.g. API removed it), drop the selection so validation correctly
            // forces a fresh pick. If nothing is selected yet, prefer the API
            // default flag, else the first option.
            var values = options.map(function(o) { return o.value; });
            if (!sgState.furniture || values.indexOf(sgState.furniture) === -1) {
                var def = options.find(function(o) { return o.default === true; });
                sgState.furniture = def ? def.value : '';
            }

            options.forEach(function(opt) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'sg-chip sg-furniture-chip';
                btn.setAttribute('role', 'radio');
                btn.setAttribute('data-value', opt.value);
                btn.textContent = opt.label || opt.value;

                var isActive = opt.value === sgState.furniture;
                btn.classList.toggle('active', isActive);
                btn.setAttribute('aria-checked', isActive ? 'true' : 'false');

                sgFurnitureBox.appendChild(btn);
            });

            sgUpdateGenerateButtonState();
        }

        // Apply the active visual + ARIA state to whichever chip matches the
        // current sgState.furniture. Called by the delegated click handler so
        // we don't have to rebind listeners after every render.
        function sgSyncFurnitureChips() {
            if (!sgFurnitureBox) return;
            sgFurnitureBox.querySelectorAll('.sg-furniture-chip').forEach(function(c) {
                var isActive = c.dataset.value === sgState.furniture;
                c.classList.toggle('active', isActive);
                c.setAttribute('aria-checked', isActive ? 'true' : 'false');
            });
        }

        // Wires a single delegated click handler on the furniture container.
        // Doing this once (in sgInitPanel) means re-rendering the tabs from
        // /tools never duplicates listeners. The handler is a no-op while
        // generation is in flight, defending against rapid clicks during
        // submission.
        function sgInitFurnitureSection() {
            if (!sgFurnitureBox) return;
            sgFurnitureBox.addEventListener('click', function(ev) {
                if (sgIsGenerating) return;
                var chip = ev.target.closest('.sg-furniture-chip');
                if (!chip || !sgFurnitureBox.contains(chip)) return;
                sgState.furniture = chip.dataset.value || '';
                sgSyncFurnitureChips();
                sgUpdateGenerateButtonState();
            });
        }

        // -------------------------------------------------------------------------
        // Card grid / presets rendering (Colors & Textures)
        // -------------------------------------------------------------------------
        //
        // Preset preview images are bearer-protected on the Supergrundriss
        // API (the OpenAPI doc says: "Each entry includes a `preview_image`
        // URL — bearer-protected — fetch as a blob to display the thumbnail").
        // A plain `background-image: url(...)` won't carry the
        // Authorization header, so the browser receives a 401/403 and
        // renders an empty box.
        //
        // To make the thumbnails actually show up we:
        //   1. Compute the absolute API URL for the preview (`thumbUrl`).
        //   2. Fetch it via sgFetchImageObjectUrl(), which adds the Bearer
        //      header, takes the response as a Blob, and wraps it in a
        //      same-origin URL.createObjectURL() handle.
        //   3. Apply that object URL as the card's CSS `background-image`.
        // The fetch is async; we cache the resolved object URL so that
        // re-rendering (2D ↔ 3D toggle, /presets reload) does not re-hit
        // the network for the same thumbnail. Object URLs are released
        // (URL.revokeObjectURL) when the iframe unloads.
        //
        // Cache shape: { [absolute thumbUrl]: objectUrl }
        var sgThumbObjectUrlCache = {};

        function sgRevokePresetThumbCache() {
            Object.keys(sgThumbObjectUrlCache).forEach(function(k) {
                try { URL.revokeObjectURL(sgThumbObjectUrlCache[k]); } catch (e) {}
            });
            sgThumbObjectUrlCache = {};
        }
        // Best-effort cleanup of preset thumb object URLs when the page goes
        // away. Browsers also free them on document unload anyway, but being
        // explicit avoids leaks if this iframe is hot-reloaded or kept alive
        // by the host frame.
        window.addEventListener('pagehide', sgRevokePresetThumbCache);

        // Apply the object URL (preferred) to the given thumb element as a
        // CSS background-image. If the bearer-fetch fails we just leave the
        // thumb empty — the label below still identifies the preset.
        function sgApplyThumbBackground(thumbEl, objectUrl) {
            if (!thumbEl || !objectUrl) return;
            thumbEl.style.backgroundImage = 'url("' + objectUrl + '")';
            thumbEl.classList.remove('is-loading');
        }

        function sgLoadPresetThumb(thumbEl, absoluteUrl) {
            if (!thumbEl || !absoluteUrl) return;

            // Cache hit — apply synchronously, no fetch.
            if (sgThumbObjectUrlCache[absoluteUrl]) {
                sgApplyThumbBackground(thumbEl, sgThumbObjectUrlCache[absoluteUrl]);
                return;
            }

            thumbEl.classList.add('is-loading');
            sgFetchImageObjectUrl(absoluteUrl)
                .then(function(objectUrl) {
                    if (!objectUrl) return;
                    // Save first so a parallel render of the same preset
                    // (e.g. plan-type toggle mid-flight) reuses the same blob.
                    sgThumbObjectUrlCache[absoluteUrl] = objectUrl;
                    sgApplyThumbBackground(thumbEl, objectUrl);
                })
                .catch(function(err) {
                    // Bearer-protected thumbs commonly fail with 401/403 if
                    // the key/origin is misconfigured; leave the placeholder
                    // visible and log for diagnostics rather than crash the
                    // card grid render.
                    thumbEl.classList.remove('is-loading');
                    console.warn('SG preset thumb failed (' + absoluteUrl + '):', err);
                });
        }

        function sgRenderCardGrid(container, items, currentValue, onPick) {
            container.innerHTML = '';
            if (!items || !items.length) {
                container.innerHTML = '<div class="sg-status">No options available.</div>';
                return;
            }
            items.forEach(function(item) {
                var card = document.createElement('div');
                card.className = 'sg-card' + (item.slug === currentValue ? ' active' : '');
                card.setAttribute('data-value', item.slug);

                var thumb = document.createElement('div');
                thumb.className = 'sg-card-thumb';

                var thumbSrc = sgPickPreviewImage(item);
                if (thumbSrc) {
                    // Build the absolute API URL the same way sgFetchImageObjectUrl
                    // does — the helper would do this internally, but resolving
                    // it here gives us a stable cache key across re-renders.
                    var thumbUrl = (thumbSrc.indexOf('http') === 0) ? thumbSrc : (sgApiHost + thumbSrc);
                    sgLoadPresetThumb(thumb, thumbUrl);
                }
                card.appendChild(thumb);

                var label = document.createElement('div');
                label.className = 'sg-card-label';
                label.textContent = item.name || item.slug;
                card.appendChild(label);

                card.addEventListener('click', function() {
                    container.querySelectorAll('.sg-card').forEach(function(c) { c.classList.remove('active'); });
                    card.classList.add('active');
                    onPick(item);
                });
                container.appendChild(card);
            });
        }

        // -------------------------------------------------------------------------
        // Panel initialisation
        // -------------------------------------------------------------------------

        // Shared callback for sgRenderCardGrid onPick — writes to the
        // single source of truth (sgState.color_texture_set) and forces a
        // button-state re-check so the new "preset must be picked" gate
        // lights up immediately. Centralised so we don't have to remember
        // to call sgUpdateGenerateButtonState() at each of the three
        // sgRenderCardGrid call sites (2D/3D switch, tool <select> change,
        // initial /presets load).
        function sgOnPresetPick(item) {
            sgState.color_texture_set = item && item.slug ? item.slug : '';
            sgUpdateGenerateButtonState();
        }

        function sgInitPanel() {
            // 2D / 3D segmented control -> updates sgState + mirrors to <select>
            if (sgPlanTypeBox) {
                sgPlanTypeBox.querySelectorAll('.sg-chip').forEach(function(chip) {
                    chip.addEventListener('click', function() {
                        sgPlanTypeBox.querySelectorAll('.sg-chip').forEach(function(c) { c.classList.remove('active'); });
                        chip.classList.add('active');
                        sgState.toolSlug = chip.dataset.value;
                        if (sgToolSelect) sgToolSelect.value = sgState.toolSlug;
                        // Re-render presets to swap 2D <-> 3D thumbnail variant.
                        sgRenderCardGrid(sgPresetsBox, sgPresetsCache, sgState.color_texture_set, sgOnPresetPick);
                    });
                });
            }

            // Tool <select> stays in sync with the segment (and remote /tools fetch).
            if (sgToolSelect) {
                sgToolSelect.addEventListener('change', function() {
                    sgState.toolSlug = this.value;
                    if (sgPlanTypeBox) {
                        sgPlanTypeBox.querySelectorAll('.sg-chip').forEach(function(c) {
                            c.classList.toggle('active', c.dataset.value === sgState.toolSlug);
                        });
                    }
                    sgRenderCardGrid(sgPresetsBox, sgPresetsCache, sgState.color_texture_set, sgOnPresetPick);
                });
            }

            // Quality segmented control
            if (sgQualityBox) {
                sgQualityBox.querySelectorAll('.sg-chip').forEach(function(chip) {
                    chip.addEventListener('click', function() {
                        sgQualityBox.querySelectorAll('.sg-chip').forEach(function(c) { c.classList.remove('active'); });
                        chip.classList.add('active');
                        sgState.quality_tier = chip.dataset.value;
                    });
                });
            }

            // Furniture tabs: a single delegated click handler is registered
            // here once so subsequent re-renders (from /tools) never stack
            // duplicate listeners. The static HTML in the markup already
            // provides usable tabs; the live render only refreshes labels
            // and order.
            sgInitFurnitureSection();
            // Make the initial static markup interactive *before* /tools
            // resolves so the user can still pick a furniture option (and
            // unblock the Generate button) even offline.
            sgSyncFurnitureChips();
            sgUpdateGenerateButtonState();

            // If no key is configured, lock the generate button with a clear
            // explanation. Static panel controls remain interactive so the user
            // can still see the UI shape.
            if (!SUPERGRUNDRISS_CONFIG.apiKey) {
                sgSetStatus('Supergrundriss API key not configured. Set ?sg_key=flp_... in the iframe URL or window.SUPERGRUNDRISS_CONFIG.apiKey on the parent page.', true);
                if (sgPresetsBox) sgPresetsBox.innerHTML = '<div class="sg-status">API key required to load presets.</div>';
                sgUpdateGenerateButtonState();
                return;
            }

            sgSetStatus('Loading Supergrundriss options...');

            // Fetch tools + presets in parallel. Failures degrade gracefully.
            //
            // /tools is the source of truth for furniture options. We pluck the
            // `furniture` control from the floorplan-2d tool (3D shares the
            // same option set) and re-render the tab strip. If the call fails,
            // the static HTML chips remain interactive — so the form is never
            // broken by a transient network error.
            sgFetch('/tools').then(function(tools) {
                if (!Array.isArray(tools) || !tools.length) return;

                // Tool <select> reflects the first two (2D, 3D) tools.
                if (sgToolSelect) {
                    var firstTwo = tools.slice(0, 2);
                    sgToolSelect.innerHTML = '';
                    firstTwo.forEach(function(tool) {
                        var opt = document.createElement('option');
                        opt.value = tool.slug;
                        opt.textContent = tool.name + (tool.category ? ' (' + tool.category + ')' : '');
                        if (tool.slug === sgState.toolSlug) opt.selected = true;
                        sgToolSelect.appendChild(opt);
                    });
                }

                // Furniture options live on the tool's controls[] array.
                // Prefer the active plan tool (toolSlug) so 2D/3D-specific
                // tweaks are picked up; both currently expose identical sets.
                var planTool = tools.find(function(t) { return t.slug === sgState.toolSlug; })
                            || tools.find(function(t) { return t.slug === 'floorplan-2d'; });
                if (planTool && Array.isArray(planTool.controls)) {
                    var furnitureCtl = planTool.controls.find(function(c) { return c && c.key === 'furniture'; });
                    if (furnitureCtl && Array.isArray(furnitureCtl.options) && furnitureCtl.options.length) {
                        sgFurnitureOptions = furnitureCtl.options.slice(0, 4); // exactly 4 tabs
                        sgRenderFurnitureTabs(sgFurnitureOptions);
                    }
                }
            }).catch(function(err) {
                console.warn('SG /tools failed:', err);
            });

            sgFetch('/presets').then(function(presets) {
                // -------------------------------------------------------------
                // Filter: only show presets whose tool_category is "floorplan".
                // -------------------------------------------------------------
                // /v1/presets returns presets for every tool category exposed
                // by the API (floorplan, staging, etc.). This modal is the
                // 2D/3D floor plan entry point, so any non-floorplan preset
                // would (a) clutter the visual card grid and (b) be silently
                // rejected by /v1/generate because it's not compatible with
                // the `floorplan-2d`/`floorplan-3d` tool_slug we send.
                //
                // The category field has shipped in two shapes across API
                // versions, so we accept either:
                //   tool_category: "floorplan"
                //   tool_category: ["floorplan", ...]
                // Anything else is dropped. Presets missing the field entirely
                // are kept as a defensive fallback (older deployments).
                var raw = Array.isArray(presets) ? presets : [];
                sgPresetsCache = raw.filter(function(p) {
                    if (!p) return false;
                    var cat = p.tool_category;
                    if (cat == null) return true; // defensive: legacy presets
                    if (Array.isArray(cat)) {
                        return cat.indexOf('floorplan') !== -1;
                    }
                    return String(cat).toLowerCase() === 'floorplan';
                });

                if (!sgPresetsCache.length) {
                    sgPresetsBox.innerHTML = '<div class="sg-status">No floor plan presets available.</div>';
                    return;
                }
                sgRenderCardGrid(sgPresetsBox, sgPresetsCache, sgState.color_texture_set, sgOnPresetPick);
            }).catch(function(err) {
                sgPresetsBox.innerHTML = '<div class="sg-status error">Failed to load presets: ' + (err.message || 'unknown error') + '</div>';
            });

            sgSetStatus('');
            sgUpdateGenerateButtonState();
        }

        // -------------------------------------------------------------------------
        // Progress modal (loading state UX)
        // -------------------------------------------------------------------------

        var sgProgressTimer = null;
        var sgProgressStartTs = 0;

        function sgOpenProgress() {
            sgProgressStartTs = Date.now();
            sgProgressElapsed.textContent = 'Elapsed: 0s';
            sgProgressBarFill.style.width = '0%';
            sgProgressStatus.textContent = 'Submitting request…';
            sgProgressBackdrop.classList.add('is-open');

            // Tick the elapsed counter + bar (target = 90s for visual fill).
            if (sgProgressTimer) clearInterval(sgProgressTimer);
            sgProgressTimer = setInterval(function() {
                var elapsed = (Date.now() - sgProgressStartTs) / 1000;
                sgProgressElapsed.textContent = 'Elapsed: ' + Math.round(elapsed) + 's';
                var pct = Math.min(95, (elapsed / 90) * 100);
                sgProgressBarFill.style.width = pct.toFixed(1) + '%';
            }, 500);
        }

        function sgSetProgressStatus(text) {
            if (sgProgressStatus) sgProgressStatus.textContent = text || '';
        }

        function sgCloseProgress() {
            sgProgressBackdrop.classList.remove('is-open');
            if (sgProgressTimer) { clearInterval(sgProgressTimer); sgProgressTimer = null; }
            sgProgressBarFill.style.width = '100%';
        }

        // -------------------------------------------------------------------------
        // Results modal — open, populate, drag compare slider
        // -------------------------------------------------------------------------

        function sgRevokeAllObjectUrls() {
            sgResults.items.forEach(function(it) {
                if (it.imageObjectUrl) { try { URL.revokeObjectURL(it.imageObjectUrl); } catch (e) {} }
                if (it.thumbObjectUrl) { try { URL.revokeObjectURL(it.thumbObjectUrl); } catch (e) {} }
            });
        }

        function sgOpenResults(items, originalUrl) {
            sgRevokeAllObjectUrls();
            sgResults = {
                items: items || [],
                currentIndex: 0,
                originalUrl: originalUrl || ''
            };

            // Thumbnail strip
            sgResultThumbs.innerHTML = '';
            if (sgResults.items.length > 1) {
                sgResults.items.forEach(function(it, idx) {
                    var thumb = document.createElement('div');
                    thumb.className = 'sg-thumb' + (idx === 0 ? ' active' : '');
                    var bg = it.thumbObjectUrl || it.imageObjectUrl;
                    if (bg) thumb.style.backgroundImage = 'url("' + bg + '")';
                    thumb.addEventListener('click', function() { sgShowResultAt(idx); });
                    sgResultThumbs.appendChild(thumb);
                });
                sgResultCount.textContent = sgResults.items.length + ' images generated';
            } else {
                sgResultCount.textContent = '';
            }

            sgShowResultAt(0);

            // Reset to "Compare" mode on every open.
            sgSetCompareMode('compare');

            sgResultsBackdrop.classList.add('is-open');
            // Reset divider to 50% AFTER images load so the wrap clip is correct.
            requestAnimationFrame(function() { sgSetDivider(0.5); });
        }

        function sgShowResultAt(idx) {
            var it = sgResults.items[idx];
            if (!it) return;
            sgResults.currentIndex = idx;

            sgCompareBefore.src = sgResults.originalUrl || '';
            sgCompareAfter.src  = it.imageObjectUrl || it.imageUrl || '';

            sgResultThumbs.querySelectorAll('.sg-thumb').forEach(function(t, i) {
                t.classList.toggle('active', i === idx);
            });

            var g = it.generation || {};
            var parts = ['Generation #' + (g.id || '?')];
            if (g.tool_type)    parts.push(g.tool_type);
            if (g.quality_tier) parts.push(g.quality_tier);
            if (g.completed_at) parts.push('completed at ' + g.completed_at);
            sgResultMeta.textContent = parts.join(' · ');

            // Re-apply divider once the new "after" image has its intrinsic
            // size (otherwise the clip wraps the wrong width).
            var onceLoaded = function() {
                sgCompareAfter.removeEventListener('load', onceLoaded);
                sgSetDivider(0.5);
            };
            if (sgCompareAfter.complete) onceLoaded();
            else sgCompareAfter.addEventListener('load', onceLoaded);
        }

        function sgCloseResults() {
            sgResultsBackdrop.classList.remove('is-open');
            sgRevokeAllObjectUrls();
            sgResults = { items: [], currentIndex: 0, originalUrl: '' };
        }

        // Drag-to-reveal compare slider. The handle position is expressed as
        // a 0..1 fraction of the stage width; the after-wrap clip width
        // mirrors the same fraction. Works with mouse + touch (pointer events).
        function sgSetDivider(frac) {
            frac = Math.max(0, Math.min(1, frac));
            var pct = (frac * 100).toFixed(2);
            sgCompareAfterWrap.style.width = pct + '%';
            sgCompareHandle.style.left = pct + '%';
        }

        function sgComputeFracFromEvent(ev) {
            var rect = sgCompareStage.getBoundingClientRect();
            var clientX = (ev.touches && ev.touches.length) ? ev.touches[0].clientX
                        : (ev.clientX !== undefined ? ev.clientX : 0);
            return (clientX - rect.left) / rect.width;
        }

        function sgInitCompareInteractions() {
            var dragging = false;

            var onMove = function(ev) {
                if (!dragging) return;
                ev.preventDefault();
                sgSetDivider(sgComputeFracFromEvent(ev));
            };
            var onUp = function() {
                dragging = false;
                document.removeEventListener('mousemove', onMove);
                document.removeEventListener('mouseup', onUp);
                document.removeEventListener('touchmove', onMove);
                document.removeEventListener('touchend', onUp);
            };

            var startDrag = function(ev) {
                if (sgCompareEl.classList.contains('is-generated-only') ||
                    sgCompareEl.classList.contains('is-original-only')) return;
                dragging = true;
                sgSetDivider(sgComputeFracFromEvent(ev));
                document.addEventListener('mousemove', onMove, { passive: false });
                document.addEventListener('mouseup', onUp);
                document.addEventListener('touchmove', onMove, { passive: false });
                document.addEventListener('touchend', onUp);
            };

            // Allow dragging anywhere on the stage (not only the handle) so
            // it feels natural on mobile too.
            sgCompareStage.addEventListener('mousedown', startDrag);
            sgCompareStage.addEventListener('touchstart', startDrag, { passive: true });

            // Keyboard accessibility: left/right arrows nudge by 5%.
            sgCompareHandle.setAttribute('tabindex', '0');
            sgCompareHandle.setAttribute('role', 'slider');
            sgCompareHandle.setAttribute('aria-label', 'Compare slider');
            sgCompareHandle.addEventListener('keydown', function(e) {
                var cur = parseFloat(sgCompareAfterWrap.style.width) || 50;
                if (e.key === 'ArrowLeft')  sgSetDivider((cur - 5) / 100);
                if (e.key === 'ArrowRight') sgSetDivider((cur + 5) / 100);
            });
        }

        function sgSetCompareMode(mode) {
            sgCompareEl.classList.remove('is-generated-only', 'is-original-only');
            if (mode === 'generated') sgCompareEl.classList.add('is-generated-only');
            else if (mode === 'original') sgCompareEl.classList.add('is-original-only');
            else if (mode === 'compare') sgSetDivider(0.5);

            sgResultsBackdrop.querySelectorAll('.sg-toggle-btn').forEach(function(b) {
                b.classList.toggle('active', b.dataset.mode === mode);
            });
        }

        function sgInitResultsModalUI() {
            sgResultsBackdrop.querySelectorAll('.sg-toggle-btn').forEach(function(b) {
                b.addEventListener('click', function() { sgSetCompareMode(b.dataset.mode); });
            });
            sgResultsClose.addEventListener('click', sgCloseResults);
            sgResultsCloseBtn.addEventListener('click', sgCloseResults);
            sgResultsBackdrop.addEventListener('click', function(e) {
                if (e.target === sgResultsBackdrop) sgCloseResults();
            });
            sgDownloadBtn.addEventListener('click', function() {
                var it = sgResults.items[sgResults.currentIndex];
                if (!it || !it.imageObjectUrl) return;
                var a = document.createElement('a');
                a.href = it.imageObjectUrl;
                a.download = 'floor-plan-' + ((it.generation && it.generation.id) || Date.now()) + '.png';
                document.body.appendChild(a); a.click(); document.body.removeChild(a);
            });
            sgInitCompareInteractions();
        }

        // -------------------------------------------------------------------------
        // DEPRECATED: sgRenderInPreviewsList()
        // -------------------------------------------------------------------------
        //
        // Replaced by the standard AIModalShared.createImagePreview pipeline
        // inside sgGenerate()'s post-save handler (kept in sync with the
        // OLD ai_image_modal_task_default.php flow). That pipeline:
        //
        //   - shares the same imageData shape with the comparison modal,
        //   - sets AIModalShared.getCurrentAiRecordId() to the new orf_ai_id,
        //   - makes the standard "Save to Task" button work for SG-generated
        //     images without any additional wiring.
        //
        // Function kept (no-op) so any stray legacy callers in this file
        // remain safe to invoke; remove once we are confident nothing
        // else references it.
        function sgRenderInPreviewsList(/* generation, imageUrl, thumbnailUrl */) {
            // intentionally empty — see header comment above
        }

        // -------------------------------------------------------------------------
        // Polling — when /v1/generate returns status != "completed"
        // -------------------------------------------------------------------------

        // Polls GET /v1/generations/{id} every pollIntervalMs until status is
        // a terminal state ("completed" or "failed") or pollMaxMs elapses.
        // Resolves with the final generation payload, rejects with a clear
        // Error on timeout / failure / abort.
        function sgPollGeneration(id, abortSignal) {
            var startedAt = Date.now();
            return new Promise(function(resolve, reject) {
                function tick() {
                    if (abortSignal && abortSignal.aborted) {
                        return reject(new Error('Aborted'));
                    }
                    if (Date.now() - startedAt > SUPERGRUNDRISS_CONFIG.pollMaxMs) {
                        return reject(new Error('Generation timed out after ' +
                            Math.round(SUPERGRUNDRISS_CONFIG.pollMaxMs / 1000) + 's. ' +
                            'The job may still complete on the server — check your history.'));
                    }
                    sgFetch('/generations/' + id).then(function(gen) {
                        sgSetProgressStatus('Status: ' + (gen.status || 'unknown'));
                        if (gen.status === 'completed') return resolve(gen);
                        if (gen.status === 'failed')   return reject(new Error(gen.error_message || 'Generation failed.'));
                        setTimeout(tick, SUPERGRUNDRISS_CONFIG.pollIntervalMs);
                    }).catch(function(err) {
                        // Transient network errors: retry up to the poll cap.
                        // Surface non-recoverable errors immediately.
                        if (err && (err.status === 404 || err.code === 'invalid_api_key' ||
                                    err.code === 'forbidden')) return reject(err);
                        console.warn('Poll error (will retry):', err);
                        setTimeout(tick, SUPERGRUNDRISS_CONFIG.pollIntervalMs);
                    });
                }
                tick();
            });
        }

        // -------------------------------------------------------------------------
        // Payload builders
        // -------------------------------------------------------------------------
        //
        // SUPERGRUNDRISS API COMPATIBILITY NOTES
        // (https://supergrundriss.de/api/v1/docs#tag/generations/POST/v1/generate)
        //
        // The /v1/generate endpoint accepts multipart/form-data with these
        // properties:
        //
        //   main_image                (binary, required) — source image
        //   tool_slug                 (string, required) — e.g. floorplan-2d
        //   quality_tier              (string)           — standard | premium
        //   settings_json             (string)           — JSON-encoded
        //                                                  tool-specific
        //                                                  settings; keys come
        //                                                  from GET /v1/tools
        //                                                  controls[] catalog
        //   preset                    (string)           — system preset slug
        //                                                  for Colors&Textures
        //                                                  (mutually exclusive
        //                                                  with user_preset_id)
        //   user_preset_id            (integer)          — alternative to preset
        //   additional_instructions   (string, ≤1000)    — free-form prompt tweaks
        //
        // Field mapping for our UI inputs:
        //
        //   UI input                          | API field
        //   ----------------------------------|----------------------------------
        //   Left panel 2D/3D toggle           | tool_slug
        //   Left panel Quality                | quality_tier
        //   Left panel Furniture tabs         | settings_json.furniture
        //   Left panel Colors & Textures      | preset (system preset slug)
        //                                     |   + settings_json.preset (mirror)
        //   Right column Additional Notes     | additional_instructions
        //   Right column Reference Images     | additional_instructions (filename
        //                                     |   summary only — see note below)
        //   Right column admin ref-image URLs | additional_instructions (URL list)
        //
        // settings_json is intentionally minimal — it carries ONLY the
        // furniture + preset pair. Everything else (tool_slug, quality_tier,
        // preset slug, additional_instructions, main_image) ships as its own
        // top-level multipart field on /v1/generate.
        //
        // Reference images are NOT a native field on POST /v1/generate. The
        // Generation schema reports a `reference_image_paths` array on the
        // *response*, but no request property accepts them. To avoid silently
        // dropping user input we:
        //   1. Surface a one-line summary of provided files in additional_
        //      instructions (filenames, count, total size).
        //   2. For "admin reference images" (URLs from selectable options)
        //      include the URLs verbatim so the model can be told where to
        //      find them.
        //   3. Document the limitation in the UI tooltip if reference files
        //      are present at submit time.

        // Build the JSON object that ships in settings_json.
        //
        // Per the latest API contract, settings_json is now a *minimal*
        // object with EXACTLY two keys — nothing else is injected:
        //
        //   {
        //     "furniture": "<raw value of the active Furniture tab>",
        //     "preset":    "<slug of the active Colors & Textures preset>"
        //   }
        //
        // Everything that previously rode along inside settings_json
        // (plan_type, tool_slug, quality_tier, color_texture_set, raw
        // center-form values keyed by field id) has been removed. The other
        // payload properties still travel as their own multipart fields
        // alongside settings_json (see sgGenerate): main_image, tool_slug,
        // quality_tier, preset, additional_instructions.
        //
        // Furniture mapping
        // -----------------
        // sgState.furniture holds the raw API value from
        // /v1/tools.controls.furniture.options[].value (e.g. "living"),
        // written by the chip click handler in sgInitFurnitureSection().
        //
        // Preset synchronisation
        // ----------------------
        // The `preset` key here reads from sgState.color_texture_set — the
        // exact same source the top-level multipart `preset` field uses
        // (see sgGenerate() below). There is only one writer for
        // color_texture_set: the sgRenderCardGrid() onPick callback. Single
        // source = no duplicate preset state, no drift between the JSON
        // copy and the top-level form field.
        //
        // Both gates are already enforced by sgUpdateGenerateButtonState(),
        // so by the time this builder runs both values are guaranteed to
        // be non-empty. The null-coalescing fallback is a defence-in-depth
        // measure for programmatic submissions only.
        function sgBuildSettingsJson() {
            return {
                furniture: sgState.furniture || null,
                preset:    sgState.color_texture_set || null
            };
        }

        // The API's `additional_instructions` field maps 1:1 to the user's
        // free-form notes in the right-column #aiNotes textarea. Other
        // selections (preset, quality, plan type) already ship as their
        // own multipart fields on /v1/generate, and the furniture/preset
        // pair ships inside settings_json — duplicating any of them here
        // would only eat into the documented 1000-char budget without
        // adding signal.
        //
        // Reference images (user-uploaded files and admin URLs) are NOT
        // included here either: see SUPERGRUNDRISS API COMPATIBILITY NOTES
        // at the top of this block. The /v1/generate schema has no slot
        // for them, and we deliberately do not stuff them into this field.
        function sgBuildAdditionalInstructions() {
            var notes = (notesTextarea && notesTextarea.value || '').trim();
            // Hard-cap at the documented API limit (1000 chars).
            return notes.length > 1000 ? notes.slice(0, 997) + '…' : notes;
        }

        // -------------------------------------------------------------------------
        // Generate handler (entry point — wired to the button click)
        // -------------------------------------------------------------------------

        function sgGenerate() {
            // Duplicate-request guard. Re-check the state machine even
            // though the button is disabled, in case a script tries to
            // bypass the UI by triggering click() programmatically.
            if (sgIsGenerating) return;

            if (!SUPERGRUNDRISS_CONFIG.apiKey) {
                AIModalShared.showNotification('Missing Supergrundriss API key.', 'danger');
                AIModalShared.sendToParent('error', { message: 'Missing Supergrundriss API key', code: 'SG_NO_API_KEY' });
                return;
            }

            // Defense in depth: even though the button is `disabled` until
            // every required center-form field is filled, we re-validate
            // here so a manual JS click() can never bypass the rules.
            if (!sgFurnitureSelected()) {
                AIModalShared.showNotification('Please pick a Furniture option before generating.', 'warning', 4000);
                sgUpdateGenerateButtonState();
                return;
            }
            if (!sgPresetSelected()) {
                AIModalShared.showNotification('Please pick a Colors & Textures preset before generating.', 'warning', 4000);
                sgUpdateGenerateButtonState();
                return;
            }

            var settings = sgBuildSettingsJson();
            var additionalInstructions = sgBuildAdditionalInstructions();
            var toolSlug = sgState.toolSlug || SUPERGRUNDRISS_CONFIG.defaultToolSlug;

            sgIsGenerating = true;
            sgUpdateGenerateButtonState();
            AIModalShared.setButtonLoading(generateFloorPlanBtn, 'Generating…');
            generatingOverlay.classList.add('active');
            sgOpenProgress();
            sgSetProgressStatus('Preparing source image…');

            // AbortController lets us cancel the in-flight fetch + polling if
            // the user closes the iframe / progress modal mid-generation.
            sgActiveAbort = new AbortController();
            var abortSignal = sgActiveAbort.signal;

            // Hard timeout for the initial /v1/generate POST. Polling has its
            // own pollMaxMs cap, so we keep this one tight (request only).
            var hardTimeoutId = setTimeout(function() {
                if (sgActiveAbort) sgActiveAbort.abort();
            }, SUPERGRUNDRISS_CONFIG.requestTimeoutMs);

            var restore = function() {
                sgIsGenerating = false;
                clearTimeout(hardTimeoutId);
                sgActiveAbort = null;
                generatingOverlay.classList.remove('active');
                sgCloseProgress();
                AIModalShared.setButtonWithIcon(generateFloorPlanBtn, 'fas fa-drafting-compass', 'Generate 2D Floor Plan');
                sgUpdateGenerateButtonState();
            };

            sgGetSourceBlob()
                .then(function(source) {
                    sgSetProgressStatus('Uploading & queuing generation…');

                    // /v1/generate is multipart/form-data. `main_image` is
                    // the binary file (Blob) — the API sniffs the MIME from
                    // the Blob's .type, so the filename is just a label.
                    // Both come from the <img> inside #sourceImageContainer,
                    // see sgGetSourceBlob() above.
                    var fd = new FormData();
                    fd.append('main_image', source.blob, source.filename);
                    fd.append('tool_slug', toolSlug);
                    fd.append('quality_tier', sgState.quality_tier || 'standard');
                    fd.append('settings_json', JSON.stringify(settings));
                    if (sgState.color_texture_set) {
                        // System preset slug (mutually exclusive w/ user_preset_id).
                        fd.append('preset', sgState.color_texture_set);
                    }
                    if (additionalInstructions) {
                        fd.append('additional_instructions', additionalInstructions);
                    }

                    return fetch(SUPERGRUNDRISS_CONFIG.apiBaseUrl + '/generate', {
                        method: 'POST',
                        headers: sgAuthHeaders(),
                        body: fd,
                        signal: abortSignal
                    });
                })
                .then(function(res) {
                    // Robustly parse — surface a friendly error if the body
                    // isn't JSON (could be a 502/504 HTML page, etc.).
                    return res.text().then(function(text) {
                        var body;
                        try { body = text ? JSON.parse(text) : {}; }
                        catch (e) {
                            throw new Error('Malformed server response (HTTP ' + res.status + ').');
                        }
                        if (!res.ok || !body || body.success !== true || !body.data) {
                            var msg = (body && (body.error || body.message)) || ('HTTP ' + res.status);
                            var err = new Error(msg);
                            err.code = (body && body.code) || ('HTTP_' + res.status);
                            err.status = res.status;
                            throw err;
                        }
                        return body.data;
                    });
                })
                .then(function(generation) {
                    sgSetProgressStatus('Status: ' + (generation.status || 'unknown'));
                    if (generation.status === 'completed') return generation;
                    if (generation.status === 'failed') {
                        throw new Error(generation.error_message || 'Generation failed.');
                    }
                    // Async path — poll until terminal state.
                    return sgPollGeneration(generation.id, abortSignal);
                })
                .then(function(generation) {
                    // -----------------------------------------------------
                    // Multi-image support
                    // -----------------------------------------------------
                    // The current Supergrundriss /v1/generate response
                    // surfaces a single result_image_url, but the schema
                    // also documents optional `additional_results[]` (e.g.
                    // for tools that return variations). To future-proof
                    // the save pipeline we normalise everything into a
                    // single `generations[]` array and process each entry
                    // independently — one failed download/save does not
                    // poison the others. Today this always yields 1 item;
                    // tomorrow it may yield N.
                    var derived = [generation];
                    if (Array.isArray(generation.additional_results) && generation.additional_results.length) {
                        generation.additional_results.forEach(function(extra, idx) {
                            // Synthesise enough of a generation object for
                            // sgGetResultImage / sgSaveToPreviousImages to
                            // work; reuse parent id when missing for audit.
                            derived.push({
                                id:                  extra.id || (generation.id + ':' + (idx + 1)),
                                tool_type:           extra.tool_type    || generation.tool_type,
                                quality_tier:        extra.quality_tier || generation.quality_tier,
                                status:              'completed',
                                result_image_url:    extra.result_image_url || extra.image_url,
                                result_thumbnail_url: extra.result_thumbnail_url || extra.thumbnail_url
                            });
                        });
                    }

                    // For each generation, fetch the full image (required)
                    // and the thumbnail (best-effort). Use Promise.allSettled
                    // so one failed fetch does NOT block the rest — we then
                    // filter to successful ones below.
                    var fetchPromises = derived.map(function(gen) {
                        return Promise.all([
                            sgGetResultImage(gen, abortSignal),
                            sgFetchImageObjectUrl(gen.result_thumbnail_url).catch(function() { return null; })
                        ]).then(function(results) {
                            var resultImage = results[0];
                            var thumbObj    = results[1] || (resultImage && resultImage.objectUrl);
                            if (!resultImage || !resultImage.objectUrl) {
                                throw new Error('Empty image response for generation ' + gen.id);
                            }
                            return {
                                generation:     gen,
                                imageObjectUrl: resultImage.objectUrl,
                                thumbObjectUrl: thumbObj,
                                resultImage:    resultImage
                            };
                        });
                    });

                    return Promise.allSettled(fetchPromises).then(function(settled) {
                        var items = [];
                        settled.forEach(function(s, i) {
                            if (s.status === 'fulfilled') {
                                items.push(s.value);
                            } else {
                                console.warn('[SG] failed to download result image #' + i + ':', s.reason);
                            }
                        });
                        if (items.length === 0) {
                            throw new Error('Generation completed but no image could be downloaded.');
                        }
                        return items;
                    });
                })
                .then(function(items) {
                    // 1) Pop the SG-specific results modal immediately so
                    //    the user sees the floor plan as soon as it is
                    //    downloaded — this preserves the existing
                    //    generation/modal behaviour. Pass the full items
                    //    array so the modal's thumbnail strip can browse
                    //    multiple results when present.
                    sgOpenResults(items, originalImageUrl);
                    AIModalShared.showNotification(
                        items.length > 1
                            ? items.length + ' floor plans generated successfully!'
                            : '2D floor plan generated successfully!',
                        'success', 3000);

                    // 2) Always emit imageGenerated so the parent page is
                    //    notified even if the DB save below fails. We send
                    //    one event per image to preserve the OLD single-
                    //    payload contract for downstream consumers.
                    items.forEach(function(item) {
                        AIModalShared.sendToParent('imageGenerated', {
                            orf_id: orfId,
                            provider: 'supergrundriss',
                            generation_id: item.generation.id,
                            tool_type: item.generation.tool_type,
                            quality_tier: item.generation.quality_tier,
                            // Local blob: URL (browser-renderable; valid until revoke).
                            image_url: item.imageObjectUrl,
                            thumbnail_url: item.thumbObjectUrl,
                            // Bearer-protected upstream URL the explicit GET hit;
                            // useful for the parent to log or re-fetch server-side.
                            result_image_url: item.resultImage && item.resultImage.url,
                            result_image_bytes: item.resultImage && item.resultImage.blob && item.resultImage.blob.size,
                            result_image_mime: item.resultImage && item.resultImage.blob && item.resultImage.blob.type
                        });
                    });

                    // 3) Persist EACH rendered image to the DB and surface
                    //    them in "Previously Generated Images" using the
                    //    SAME pipeline as the OLD ai_image_modal_task_default.php
                    //    flow:
                    //      - sgSaveToPreviousImages() POSTs the binary to
                    //        ai_image_generate.php in register-only mode
                    //        and returns the new orf_ai_id (normalised in
                    //        the save helper).
                    //      - We then build the exact imageData shape the
                    //        OLD flow used (id = orf_ai_id, image_url,
                    //        thumbnail_url, model, room_type, etc.) and
                    //        push it through AIModalShared.addGeneratedImage
                    //        + AIModalShared.createImagePreview, so:
                    //          * the standard comparison modal opens on
                    //            click of the new thumbnail,
                    //          * AIModalShared.getCurrentAiRecordId()
                    //            returns the new orf_ai_id, and
                    //          * the user-initiated Save to Task button
                    //            (wired to ai_image_save_to_task.php with
                    //            orf_ai_id + id_extension +
                    //            presentation_name) works unchanged.
                    //
                    //    This is intentionally a best-effort step per
                    //    image. If one save fails the SG results modal +
                    //    download button still work for ALL items, and
                    //    successful saves still appear in the strip — we
                    //    only warn for the failures.
                    sgSetProgressStatus(
                        items.length > 1
                            ? 'Saving ' + items.length + ' images to previously generated images…'
                            : 'Saving to previously generated images…');
                    sgPersistGeneratedItems(items);
                })
                .catch(function(err) {
                    console.error('Supergrundriss generate failed:', err);
                    var message;
                    if (err && err.name === 'AbortError') {
                        message = 'Generation cancelled (request took longer than ' +
                                  Math.round(SUPERGRUNDRISS_CONFIG.requestTimeoutMs / 1000) + 's).';
                    } else if (err && (err.code === 'invalid_api_key' || err.status === 401)) {
                        message = 'Invalid or revoked Supergrundriss API key.';
                    } else if (err && (err.code === 'forbidden' || err.status === 403)) {
                        message = 'This origin is not whitelisted for the Supergrundriss key.';
                    } else if (err && err.code === 'insufficient_credits') {
                        message = 'Not enough Supergrundriss credits to run this generation.';
                    } else if (err && err.code === 'rate_limited') {
                        message = 'Rate limited — wait a minute and try again.';
                    } else if (err && err.code === 'payload_too_large') {
                        message = 'Source image is too large (max 20 MB).';
                    } else if (err && err.code === 'unsupported_media_type') {
                        message = 'Source image type not supported (use PNG, JPG, WebP, or PDF).';
                    } else if (err && /NetworkError|Failed to fetch/i.test(err.message || '')) {
                        message = 'Network error — please check your connection and try again.';
                    } else {
                        message = (err && err.message) || 'Unknown error during generation.';
                    }
                    AIModalShared.showNotification('Floor plan generation failed: ' + message, 'danger', 6000);
                    AIModalShared.sendToParent('error', {
                        message: 'Supergrundriss generation failed: ' + message,
                        code: (err && err.code) || 'SG_GENERATION_FAILED'
                    });
                })
                .finally(restore);
        }

        if (generateFloorPlanBtn) {
            generateFloorPlanBtn.addEventListener('click', sgGenerate);
        }

        // -------------------------------------------------------------------------
        // Wire panel + results-modal interactions, then kick off remote fetches.
        // -------------------------------------------------------------------------
        sgInitResultsModalUI();
        sgInitPanel();

        // Wire real-time validation for the center-form fields. Uses event
        // delegation on #aiDynamicFields, so it survives re-renders by
        // renderDynamicFields() and does not need re-binding.
        sgAttachCenterFormValidation();

        // The center-form fields render asynchronously after the IIFE
        // executes (see loadProductConfig() below). renderDynamicFields()
        // builds the inputs and writes them into formFields[]; we wrap that
        // function so we can re-run sgUpdateGenerateButtonState() exactly
        // once the required fields exist in the DOM. Using a wrap (instead
        // of patching the function body) keeps the original function
        // self-contained and reusable.
        if (typeof renderDynamicFields === 'function') {
            var _originalRenderDynamicFields = renderDynamicFields;
            renderDynamicFields = function() {
                _originalRenderDynamicFields.apply(this, arguments);
                // Some configurations have default-checked options for
                // required fields. Re-evaluate the button right after the
                // fields appear so it can flip to enabled without waiting
                // for the next input event.
                sgUpdateGenerateButtonState();
            };
        }

        // Ensure the initial state is correct (button starts disabled
        // because no required fields are filled yet).
        sgUpdateGenerateButtonState();

        // =========================================================================
        // INITIALIZATION
        // =========================================================================

        loadProductConfig();
        loadPreviousImages();

    })();
</script>
</body>
</html>
