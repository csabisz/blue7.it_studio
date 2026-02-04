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
 *   - ready: Iframe loaded, modal visible
 *   - imageGenerated: New image created
 *   - imageSaved: Image saved to task
 *   - error: Any error occurred
 *   - close: User clicked close button
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
$image_url = $compress_path ? "https://blue7.it/studio/result_compress_files/{$compress_path}" : '';
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

    <style>
        /* Reset and base styles for iframe */
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: transparent;
        }

        /* Loading overlay */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            transition: opacity 0.3s ease;
        }

        .loading-overlay.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .loading-text {
            margin-top: 15px;
            color: #666;
            font-size: 14px;
        }

        /* Modal container - fills entire iframe */
        .iframe-modal-container {
            width: 100%;
            height: 100vh;
        }

        .iframe-modal-content {
            background: #fff;
            width: 100%;
            height: 100%;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .iframe-modal-body {
            overflow-y: auto;
            flex: 1;
            padding: 1rem;
        }

        /* Comparison Modal Styles */
        .comparison-modal .modal-dialog {
            max-width: 95vw;
            margin: 1rem auto;
        }

        .comparison-modal .modal-content {
            height: calc(100vh - 2rem);
            display: flex;
            flex-direction: column;
        }

        .comparison-modal .modal-body {
            flex: 1;
            padding: 0;
            overflow: hidden;
        }

        .comparison-container {
            position: relative;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .comparison-image {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .comparison-before {
            z-index: 1;
        }

        .comparison-after {
            z-index: 2;
        }

        /* Opacity Slider Control */
        .opacity-control {
            position: absolute;
            bottom: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.8);
            padding: 12px 16px;
            border-radius: 8px;
            z-index: 30;
            min-width: 200px;
        }

        .opacity-control label {
            color: #fff;
            font-size: 12px;
            margin-bottom: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .opacity-control label span {
            opacity: 0.7;
        }

        .opacity-slider {
            width: 100%;
            height: 6px;
            -webkit-appearance: none;
            appearance: none;
            background: linear-gradient(to right, rgba(255,255,255,0.3), rgba(255,255,255,0.8));
            border-radius: 3px;
            outline: none;
            cursor: pointer;
        }

        .opacity-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 18px;
            height: 18px;
            background: #fff;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }

        .opacity-slider::-moz-range-thumb {
            width: 18px;
            height: 18px;
            background: #fff;
            border-radius: 50%;
            cursor: pointer;
            border: none;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }

        .comparison-metadata {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0,0,0,0.8);
            color: #fff;
            padding: 15px;
            border-radius: 8px;
            z-index: 20;
            max-width: 280px;
            font-size: 12px;
        }

        .comparison-metadata h6 {
            color: #fff;
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: 600;
        }

        .comparison-metadata p {
            margin: 4px 0;
        }

        .comparison-nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.6);
            color: #fff;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
            z-index: 25;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s, transform 0.2s;
        }

        .comparison-nav-arrow:hover {
            background: rgba(0,0,0,0.8);
            transform: translateY(-50%) scale(1.1);
        }

        .comparison-nav-arrow:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .comparison-nav-arrow:disabled:hover {
            transform: translateY(-50%);
        }

        .comparison-nav-arrow.left {
            left: 20px;
        }

        .comparison-nav-arrow.right {
            right: 20px;
        }

        .modal-generating-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: none;
            cursor: not-allowed;
            align-items: center;
            justify-content: center;
        }

        .modal-generating-overlay.active {
            display: flex;
        }

        /* Toast notification animation */
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Reference Images Dropzone */
        .reference-dropzone {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .reference-dropzone:hover {
            border-color: #007bff;
            background: #f0f7ff;
        }

        .reference-dropzone.dragover {
            border-color: #28a745;
            background: #e8f5e9;
            border-style: solid;
        }

        .reference-previews {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .reference-preview-item {
            position: relative;
            width: 60px;
            height: 60px;
            border-radius: 4px;
            overflow: hidden;
            border: 1px solid #dee2e6;
        }

        .reference-preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .reference-preview-remove {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 18px;
            height: 18px;
            background: rgba(220, 53, 69, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            font-size: 12px;
            line-height: 1;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: background 0.2s;
        }

        .reference-preview-remove:hover {
            background: #dc3545;
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
                <!-- Image Preview Column -->
                <div class="col-md-4">
                    <h6 class="text-dark mb-3">Current Image</h6>
                    <?php if ($image_url): ?>
                        <img src="<?php echo htmlspecialchars($image_url); ?>"
                             alt="Current Image"
                             class="img-fluid rounded border shadow-sm"
                             style="max-height: 400px; width: 100%; object-fit: contain;">
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <small>No compressed image available</small>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Prompt Fine-tuning Column -->
                <div class="col-md-4">
                    <h6 class="text-dark mb-3">Fine-tune Generation Prompt</h6>

                    <!-- Model Selection -->
                    <div class="form-group">
                        <label for="aiModel" class="text-dark">Model</label>
                        <select class="form-control form-control-sm" id="aiModel">
                            <option value="gemini-3-pro-image-preview">[Google] Nano Banana Pro</option>
                            <option value="gemini-2.5-flash-image">[Google] Nano Banana</option>
                            <option value="imagen-4.0-generate-001">[Google] Imagen 4</option>
                            <option value="imagen-4.0-ultra-generate-001">[Google] Imagen 4 Ultra</option>
                            <option value="imagen-4.0-fast-generate-001">[Google] Imagen 4 Fast</option>
                        </select>
                    </div>

                    <!-- Dynamic form fields container -->
                    <div id="aiDynamicFields">
                        <div class="text-center text-muted py-3">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="ml-2">Loading product configuration...</span>
                        </div>
                    </div>

                    <!-- Hidden field to store product type -->
                    <input type="hidden" id="aiProductType" value="">
                </div>

                <!-- Additional Notes -->
                <div class="col-md-4">
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
                </div>
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
            <button type="button" class="btn btn-success btn-sm" id="viewFullPrompt">
                <i class="fas fa-eye"></i> View Full Prompt
            </button>
            <button type="button" class="btn btn-info btn-sm" id="generateAIImage">
                Generate Image
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

<!-- jQuery and Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    (function() {
        'use strict';

        // Get orf_id from URL parameters
        const urlParams = new URLSearchParams(window.location.search);
        const orfId = urlParams.get('orf_id');

        // Base URL for API calls (same origin)
        const apiBaseUrl = '/studio/coordination';

        // Loading overlay
        const loadingOverlay = document.getElementById('loadingOverlay');
        let configLoaded = false;
        let imagesLoaded = false;

        function checkReady() {
            if (configLoaded && imagesLoaded) {
                loadingOverlay.classList.add('hidden');
                sendToParent('ready');
            }
        }

        // =========================================================================
        // POSTMESSAGE COMMUNICATION
        // =========================================================================

        function sendToParent(event, data = {}) {
            window.parent.postMessage({
                type: 'ai-modal-event',
                event: event,
                data: { orf_id: orfId, ...data }
            }, '*');
        }

        // =========================================================================
        // DOM REFERENCES
        // =========================================================================

        const notesTextarea = document.getElementById('aiNotes');
        const dynamicFieldsContainer = document.getElementById('aiDynamicFields');
        const productTypeInput = document.getElementById('aiProductType');
        const previewsContainer = document.getElementById('aiGeneratedPreviews');
        const generateButton = document.getElementById('generateAIImage');
        const generatingOverlay = document.getElementById('generatingOverlay');
        const viewPromptButton = document.getElementById('viewFullPrompt');
        const closeModalBtn = document.getElementById('closeModalBtn');
        const closeModalBtnFooter = document.getElementById('closeModalBtnFooter');

        // Store product configuration
        let productConfig = null;
        let basePrompt = null;
        let formFields = {};
        let referenceImages = [];

        // =========================================================================
        // UTILITY FUNCTIONS
        // =========================================================================

        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            const div = document.createElement('div');
            div.textContent = String(text);
            return div.innerHTML;
        }

        function setButtonLoading(button, text) {
            button.innerHTML = '';
            const spinner = document.createElement('span');
            spinner.className = 'spinner-border spinner-border-sm mr-2';
            spinner.setAttribute('role', 'status');
            spinner.setAttribute('aria-hidden', 'true');
            button.appendChild(spinner);
            button.appendChild(document.createTextNode(text));
        }

        function setButtonWithIcon(button, iconClass, text) {
            button.innerHTML = '';
            const icon = document.createElement('i');
            icon.className = iconClass + ' mr-1';
            button.appendChild(icon);
            button.appendChild(document.createTextNode(text));
        }

        // =========================================================================
        // STATE MANAGEMENT
        // =========================================================================

        let isGenerating = false;
        let currentAiRecordId = null;
        let allGeneratedImages = [];
        let currentImageIndex = 0;

        // =========================================================================
        // NOTIFICATION SYSTEM
        // =========================================================================

        function showNotification(message, type = 'info', duration = 5000) {
            let container = document.getElementById('notificationContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'notificationContainer';
                container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 10000; max-width: 400px;';
                document.body.appendChild(container);
            }

            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show shadow`;
            notification.style.cssText = 'margin-bottom: 10px; animation: slideInRight 0.3s ease;';
            notification.setAttribute('role', 'alert');
            notification.appendChild(document.createTextNode(message));

            const closeButton = document.createElement('button');
            closeButton.type = 'button';
            closeButton.className = 'close';
            closeButton.setAttribute('data-dismiss', 'alert');
            closeButton.setAttribute('aria-label', 'Close');
            closeButton.innerHTML = '<span aria-hidden="true">&times;</span>';
            notification.appendChild(closeButton);

            container.appendChild(notification);

            setTimeout(() => {
                $(notification).alert('close');
            }, duration);
        }

        // =========================================================================
        // DYNAMIC FIELD RENDERING
        // =========================================================================

        function loadProductConfig() {
            fetch(`${apiBaseUrl}/ai_get_product_config.php?orf_id=${orfId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        productConfig = data.data.config;
                        basePrompt = data.data.base_prompt;
                        productTypeInput.value = data.data.product_type;
                        renderDynamicFields();
                    } else {
                        console.error('Failed to load product config:', data.error);
                        showNotification('Failed to load product configuration.', 'warning');
                        dynamicFieldsContainer.innerHTML = '<div class="alert alert-warning">Failed to load configuration</div>';
                        sendToParent('error', { message: 'Failed to load product configuration', code: 'CONFIG_LOAD_FAILED' });
                    }
                    configLoaded = true;
                    checkReady();
                })
                .catch(error => {
                    console.error('Error loading product config:', error);
                    showNotification('Error loading product configuration', 'danger');
                    dynamicFieldsContainer.innerHTML = '<div class="alert alert-danger">Error loading configuration</div>';
                    sendToParent('error', { message: 'Error loading product configuration', code: 'CONFIG_LOAD_ERROR' });
                    configLoaded = true;
                    checkReady();
                });
        }

        function renderDynamicFields() {
            if (!productConfig || !productConfig.fields) {
                return;
            }

            dynamicFieldsContainer.innerHTML = '';

            productConfig.fields.forEach(fieldConfig => {
                const fieldId = fieldConfig.id;
                const formGroup = document.createElement('div');
                formGroup.className = 'form-group';

                const label = document.createElement('label');
                label.setAttribute('for', fieldId);
                label.className = 'text-dark';
                label.textContent = fieldConfig.label;
                if (fieldConfig.required) {
                    const required = document.createElement('span');
                    required.className = 'text-danger';
                    required.textContent = ' *';
                    label.appendChild(required);
                }
                formGroup.appendChild(label);

                let field = null;
                if (fieldConfig.type === 'select') {
                    field = document.createElement('select');
                    field.className = 'form-control form-control-sm';
                    field.id = fieldId;
                    field.setAttribute('data-field-id', fieldConfig.id);

                    const placeholderOption = document.createElement('option');
                    placeholderOption.value = '';
                    placeholderOption.textContent = '-- Select ' + fieldConfig.label + ' --';
                    field.appendChild(placeholderOption);

                    fieldConfig.options.forEach(opt => {
                        const option = document.createElement('option');
                        option.value = opt.value;
                        option.textContent = opt.label;
                        if (opt.prompt) {
                            option.setAttribute('data-prompt', opt.prompt);
                        }
                        if (opt.rooms) {
                            option.setAttribute('data-rooms', opt.rooms);
                        }
                        field.appendChild(option);
                    });

                    if (fieldConfig.id === 'style_preset') {
                        field.addEventListener('change', function() {
                            const selectedOption = this.options[this.selectedIndex];
                            if (selectedOption.dataset.prompt) {
                                notesTextarea.value = selectedOption.dataset.prompt;
                            }
                        });
                    }

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
                    const checkboxWrapper = document.createElement('div');
                    checkboxWrapper.className = 'form-check';

                    field = document.createElement('input');
                    field.type = 'checkbox';
                    field.className = 'form-check-input';
                    field.id = fieldId;
                    field.setAttribute('data-field-id', fieldConfig.id);
                    if (fieldConfig.defaultValue) {
                        field.checked = true;
                    }

                    const checkLabel = document.createElement('label');
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
                dynamicFieldsContainer.appendChild(formGroup);
            });
        }

        // Original image URL
        const originalImageUrl = '<?php echo htmlspecialchars($image_url); ?>';

        // =========================================================================
        // IMAGE PREVIEW FUNCTIONS
        // =========================================================================

        function formatFileSize(bytes) {
            if (!bytes || bytes === 0) return 'Unknown';
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            return Math.round(bytes / Math.pow(1024, i) * 100) / 100 + ' ' + sizes[i];
        }

        function getFileSize(url, callback) {
            fetch(`${apiBaseUrl}/ai_image_get_file_size.php?url=` + encodeURIComponent(url))
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.size) {
                        callback(data.data.size);
                    } else {
                        callback(0);
                    }
                })
                .catch(error => {
                    console.error('Error fetching file size:', error);
                    callback(0);
                });
        }

        // =========================================================================
        // OPACITY SLIDER
        // =========================================================================

        const opacitySlider = document.getElementById('opacitySlider');
        const opacityValue = document.getElementById('opacityValue');
        const comparisonAfter = document.getElementById('comparisonAfter');

        opacitySlider.addEventListener('input', function() {
            const value = this.value;
            opacityValue.textContent = value + '%';
            comparisonAfter.style.opacity = value / 100;
        });

        // Reset opacity when opening comparison modal
        function resetOpacitySlider() {
            opacitySlider.value = 100;
            opacityValue.textContent = '100%';
            comparisonAfter.style.opacity = 1;
        }

        function openComparisonModal(imageData, imageIndex = null) {
            // Reset opacity slider
            resetOpacitySlider();

            document.getElementById('comparisonBefore').src = originalImageUrl;
            document.getElementById('comparisonAfter').src = imageData.image_url;

            document.getElementById('metaRoomType').textContent = imageData.room_type || '-';
            document.getElementById('metaStyle').textContent = imageData.style_preset || '-';
            document.getElementById('metaModel').textContent = imageData.model || '-';
            document.getElementById('metaQuality').textContent = imageData.quality || '-';
            document.getElementById('metaCreated').textContent = imageData.created_at || '-';

            const fileSizeElement = document.getElementById('metaFileSize');
            fileSizeElement.textContent = 'Calculating...';
            getFileSize(imageData.image_url, function(size) {
                fileSizeElement.textContent = formatFileSize(size);
            });

            currentAiRecordId = imageData.id;

            if (imageIndex !== null) {
                currentImageIndex = imageIndex;
            }

            updateNavigationButtons();

            const saveButton = document.getElementById('saveToTask');
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

            $('#comparisonModal').modal('show');
        }

        function updateNavigationButtons() {
            const prevButton = document.getElementById('prevImage');
            const nextButton = document.getElementById('nextImage');

            prevButton.disabled = currentImageIndex <= 0;
            nextButton.disabled = currentImageIndex >= allGeneratedImages.length - 1;
        }

        function showPreviousImage() {
            if (currentImageIndex > 0) {
                currentImageIndex--;
                openComparisonModal(allGeneratedImages[currentImageIndex], currentImageIndex);
            }
        }

        function showNextImage() {
            if (currentImageIndex < allGeneratedImages.length - 1) {
                currentImageIndex++;
                openComparisonModal(allGeneratedImages[currentImageIndex], currentImageIndex);
            }
        }

        function createImagePreview(imageData) {
            const imageWrapper = document.createElement('div');
            imageWrapper.className = 'position-relative';
            imageWrapper.style.cssText = 'width: 150px; height: 150px; margin: 5px;';
            imageWrapper.dataset.imageId = imageData.id;
            imageWrapper.title = `Style: ${escapeHtml(imageData.style_preset)}\n` +
                `Room: ${escapeHtml(imageData.room_type)}\n` +
                `Model: ${escapeHtml(imageData.model)}\n` +
                `Created: ${escapeHtml(imageData.created_at || 'Just now')}`;

            const img = document.createElement('img');
            img.src = imageData.thumbnail_url || imageData.image_url;
            img.className = 'img-fluid rounded border shadow-sm';
            img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; cursor: pointer;';
            img.alt = 'Generated Image';

            imageWrapper.appendChild(img);

            if (imageData.saved_orf_id) {
                const badge = document.createElement('span');
                badge.className = 'badge badge-success';
                badge.style.cssText = 'position: absolute; top: 5px; right: 5px; z-index: 10; padding: 5px 8px;';
                badge.title = 'This image has been saved to the task';
                setButtonWithIcon(badge, 'fas fa-check', 'Saved');
                imageWrapper.appendChild(badge);
            }

            return imageWrapper;
        }

        // Event delegation for preview images
        function initializePreviewsContainer() {
            previewsContainer.addEventListener('click', function(e) {
                const img = e.target.closest('img');
                if (!img) return;

                const wrapper = img.closest('.position-relative');
                if (!wrapper) return;

                const children = Array.from(previewsContainer.querySelectorAll('.position-relative'));
                const index = children.indexOf(wrapper);

                if (index !== -1 && allGeneratedImages[index]) {
                    openComparisonModal(allGeneratedImages[index], index);
                }
            });
        }

        initializePreviewsContainer();

        function loadPreviousImages() {
            previewsContainer.innerHTML = `
                <div class="text-center py-3">
                    <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
                    <span class="text-muted ml-2">Loading previous images...</span>
                </div>
            `;

            fetch(`${apiBaseUrl}/ai_image_fetch_previous.php?orf_id=${orfId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.images.length > 0) {
                        allGeneratedImages = data.data.images;

                        previewsContainer.innerHTML = '';
                        data.data.images.forEach((imageData) => {
                            const imagePreview = createImagePreview(imageData);
                            previewsContainer.appendChild(imagePreview);
                        });
                    } else {
                        allGeneratedImages = [];
                        previewsContainer.innerHTML = '<div class="text-muted small"><em>No previously generated images yet.</em></div>';
                    }
                    imagesLoaded = true;
                    checkReady();
                })
                .catch(error => {
                    console.error('Error loading previous images:', error);
                    allGeneratedImages = [];
                    previewsContainer.innerHTML = '<div class="text-muted small"><em>Error loading previous images.</em></div>';
                    imagesLoaded = true;
                    checkReady();
                });
        }

        // =========================================================================
        // REFERENCE IMAGES DROPZONE
        // =========================================================================

        const referenceDropzone = document.getElementById('referenceDropzone');
        const referenceFileInput = document.getElementById('referenceFileInput');
        const referencePreviews = document.getElementById('referencePreviews');
        const referenceCount = document.getElementById('referenceCount');

        referenceDropzone.addEventListener('click', function() {
            referenceFileInput.click();
        });

        referenceFileInput.addEventListener('change', function(e) {
            addReferenceImages(e.target.files);
            this.value = '';
        });

        referenceDropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.add('dragover');
        });

        referenceDropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('dragover');
        });

        referenceDropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('dragover');

            if (e.dataTransfer.files.length > 0) {
                addReferenceImages(e.dataTransfer.files);
            }
        });

        function addReferenceImages(files) {
            const maxImages = 14;
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            const maxFileSize = 10 * 1024 * 1024;

            for (const file of files) {
                if (referenceImages.length >= maxImages) {
                    showNotification(`Maximum ${maxImages} reference images allowed`, 'warning');
                    break;
                }

                if (!allowedTypes.includes(file.type)) {
                    showNotification(`Invalid file type: ${file.name}. Only JPEG, PNG, and WebP allowed.`, 'warning');
                    continue;
                }

                if (file.size > maxFileSize) {
                    showNotification(`File too large: ${file.name}. Maximum size is 10MB.`, 'warning');
                    continue;
                }

                const isDuplicate = referenceImages.some(
                    existing => existing.name === file.name && existing.size === file.size
                );
                if (isDuplicate) {
                    showNotification(`Duplicate file: ${file.name}`, 'info');
                    continue;
                }

                referenceImages.push(file);
            }

            renderReferencePreviews();
        }

        function renderReferencePreviews() {
            referencePreviews.innerHTML = '';
            referenceCount.textContent = referenceImages.length;

            referenceImages.forEach((file, index) => {
                const item = document.createElement('div');
                item.className = 'reference-preview-item';

                const img = document.createElement('img');
                img.src = URL.createObjectURL(file);
                img.alt = file.name;
                img.onload = function() {
                    URL.revokeObjectURL(this.src);
                };

                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'reference-preview-remove';
                removeBtn.innerHTML = '&times;';
                removeBtn.title = 'Remove';
                removeBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    removeReferenceImage(index);
                });

                item.appendChild(img);
                item.appendChild(removeBtn);
                referencePreviews.appendChild(item);
            });
        }

        function removeReferenceImage(index) {
            referenceImages.splice(index, 1);
            renderReferencePreviews();
        }

        function clearReferenceImages() {
            referenceImages = [];
            renderReferencePreviews();
        }

        // =========================================================================
        // GENERATE IMAGE HANDLER
        // =========================================================================

        generateButton.addEventListener('click', function() {
            if (isGenerating) {
                return;
            }

            if (!productConfig || !basePrompt) {
                showNotification('Product configuration not loaded. Please refresh the page.', 'warning');
                return;
            }

            const modelSelect = document.getElementById('aiModel');
            const productType = productTypeInput.value;

            const fieldValues = {};
            let hasError = false;

            productConfig.fields.forEach(fieldConfig => {
                const field = formFields[fieldConfig.id];
                if (!field) return;

                let value = '';
                if (fieldConfig.type === 'checkbox') {
                    value = field.checked;
                } else if (fieldConfig.type === 'select' || fieldConfig.type === 'textarea') {
                    value = field.value.trim();
                }

                if (fieldConfig.required && !value) {
                    showNotification(`Please select/enter ${fieldConfig.label}`, 'warning');
                    hasError = true;
                    return;
                }

                fieldValues[fieldConfig.id] = value;
            });

            if (hasError) {
                return;
            }

            if (!notesTextarea.value.trim()) {
                showNotification('Please add additional instructions', 'warning');
                return;
            }

            isGenerating = true;

            const promptVariables = {};

            productConfig.fields.forEach(fieldConfig => {
                const field = formFields[fieldConfig.id];
                if (!field) return;

                let value = '';

                if (fieldConfig.type === 'select') {
                    const selectedOption = field.options[field.selectedIndex];
                    if (selectedOption) {
                        if (selectedOption.dataset.prompt) {
                            value = selectedOption.dataset.prompt;
                        } else {
                            value = selectedOption.text || selectedOption.value;
                        }
                    }
                } else if (fieldConfig.type === 'checkbox') {
                    value = field.checked ? 'Yes' : 'No';
                } else {
                    value = field.value.trim();
                }

                const varName = fieldConfig.id.toUpperCase();
                promptVariables[varName] = value;
            });

            promptVariables['ADDITIONAL_INSTRUCTIONS'] = notesTextarea.value.trim();

            let finalPrompt = basePrompt;
            for (const [key, value] of Object.entries(promptVariables)) {
                const regex = new RegExp(`\\[${key}\\]`, 'g');
                finalPrompt = finalPrompt.replace(regex, value);
            }

            finalPrompt = finalPrompt.replace(/\[[A-Z_]+\]/g, '');

            const formData = new FormData();
            formData.append('orf_id', orfId);
            formData.append('model', modelSelect.value);
            formData.append('product_type', productType);
            formData.append('additional_instructions', notesTextarea.value.trim());
            formData.append('final_prompt', finalPrompt);

            for (const [fieldId, value] of Object.entries(fieldValues)) {
                formData.append(fieldId, value);
            }

            referenceImages.forEach(file => {
                formData.append('reference_images[]', file);
            });

            generateButton.disabled = true;
            setButtonLoading(generateButton, 'Generating...');
            generatingOverlay.classList.add('active');

            const restoreButton = function() {
                generateButton.disabled = false;
                generateButton.textContent = 'Generate Image';
                generatingOverlay.classList.remove('active');
            };

            fetch(`${apiBaseUrl}/ai_image_generate.php`, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const noImagesMessage = previewsContainer.querySelector('.text-muted');
                        if (noImagesMessage) {
                            noImagesMessage.remove();
                        }

                        const getFieldLabel = (fieldId) => {
                            const field = formFields[fieldId];
                            if (!field) return '';
                            if (field.tagName === 'SELECT') {
                                const selectedOption = field.options[field.selectedIndex];
                                return selectedOption ? selectedOption.text : '';
                            }
                            return field.value;
                        };

                        const imageData = {
                            id: data.data.ai_record_id,
                            image_url: data.data.image_url,
                            thumbnail_url: data.data.thumbnail_url,
                            model: data.data.model,
                            room_type: getFieldLabel('room_type') || getFieldLabel('space_type') || getFieldLabel('building_type') || getFieldLabel('plan_type'),
                            style_preset: getFieldLabel('style_preset'),
                            quality: data.data.size,
                            created_at: 'Just now'
                        };

                        allGeneratedImages.unshift(imageData);

                        const imagePreview = createImagePreview(imageData);
                        previewsContainer.insertBefore(imagePreview, previewsContainer.firstChild);

                        showNotification('Image generated successfully!', 'success', 3000);

                        sendToParent('imageGenerated', {
                            id: data.data.ai_record_id,
                            image_url: data.data.image_url,
                            thumbnail_url: data.data.thumbnail_url,
                            model: data.data.model,
                            quality: data.data.size
                        });
                    } else {
                        showNotification('Failed to generate image: ' + (data.error || data.message), 'danger');
                        sendToParent('error', { message: 'Failed to generate image: ' + (data.error || data.message), code: 'GENERATION_FAILED' });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to generate image: Network error or server unavailable. Please try again.', 'danger');
                    sendToParent('error', { message: 'Network error during image generation', code: 'NETWORK_ERROR' });
                })
                .finally(() => {
                    restoreButton();
                    isGenerating = false;
                });
        });

        // =========================================================================
        // VIEW FULL PROMPT HANDLER
        // =========================================================================

        viewPromptButton.addEventListener('click', function() {
            if (!productConfig || !basePrompt) {
                showNotification('Product configuration not loaded. Please refresh the page.', 'warning');
                return;
            }

            const promptVariables = {};

            productConfig.fields.forEach(fieldConfig => {
                const field = formFields[fieldConfig.id];
                if (!field) return;

                let value = '';

                if (fieldConfig.type === 'select') {
                    const selectedOption = field.options[field.selectedIndex];
                    if (selectedOption) {
                        if (selectedOption.dataset.prompt) {
                            value = selectedOption.dataset.prompt;
                        } else {
                            value = selectedOption.text || selectedOption.value;
                        }
                    }
                } else if (fieldConfig.type === 'checkbox') {
                    value = field.checked ? 'Yes' : 'No';
                } else {
                    value = field.value.trim();
                }

                const varName = fieldConfig.id.toUpperCase();
                promptVariables[varName] = value;
            });

            promptVariables['ADDITIONAL_INSTRUCTIONS'] = notesTextarea.value.trim();

            let finalPrompt = basePrompt;
            for (const [key, value] of Object.entries(promptVariables)) {
                const regex = new RegExp(`\\[${key}\\]`, 'g');
                finalPrompt = finalPrompt.replace(regex, value);
            }

            finalPrompt = finalPrompt.replace(/\[[A-Z_]+\]/g, '');

            const promptWindow = window.open('', 'Full Prompt', 'width=800,height=600,scrollbars=yes,resizable=yes');
            promptWindow.document.open();
            promptWindow.document.write('<html><head><title>Full AI Prompt</title></head><body>');
            const pre = promptWindow.document.createElement('pre');
            pre.style.whiteSpace = 'pre-wrap';
            pre.style.wordWrap = 'break-word';
            pre.style.fontFamily = 'monospace';
            pre.style.padding = '20px';
            pre.textContent = finalPrompt;
            promptWindow.document.body.appendChild(pre);
            promptWindow.document.write('</body></html>');
            promptWindow.document.close();
        });

        // =========================================================================
        // SAVE TO TASK HANDLER
        // =========================================================================

        const saveToTaskButton = document.getElementById('saveToTask');
        const saveToTaskForm = document.getElementById('saveToTaskForm');
        const saveToTaskSubmit = document.getElementById('saveToTaskSubmit');
        const saveExtensionId = document.getElementById('saveExtensionId');
        const savePresentationName = document.getElementById('savePresentationName');

        // Open the save modal when clicking "Save to Task"
        saveToTaskButton.addEventListener('click', function() {
            if (!currentAiRecordId) {
                showNotification('No AI record selected', 'warning');
                return;
            }

            // Clear the form
            saveExtensionId.value = '';
            savePresentationName.value = '';

            // Show the save modal
            $('#saveToTaskModal').modal('show');

            // Focus the first field after modal is shown
            $('#saveToTaskModal').one('shown.bs.modal', function() {
                saveExtensionId.focus();
            });
        });

        // Handle form submission
        saveToTaskForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const idExtension = saveExtensionId.value.trim();
            const presentationName = savePresentationName.value.trim();

            // Disable submit button and show loading
            saveToTaskSubmit.disabled = true;
            setButtonLoading(saveToTaskSubmit, 'Saving...');

            const formData = new FormData();
            formData.append('orf_ai_id', currentAiRecordId);
            formData.append('id_extension', idExtension);
            formData.append('presentation_name', presentationName);

            fetch(`${apiBaseUrl}/ai_image_save_to_task.php`, {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Close all modals
                        $('#saveToTaskModal').modal('hide');
                        $('#comparisonModal').modal('hide');

                        showNotification('Image saved to task successfully!', 'success', 2000);

                        // Send event to parent - parent will close iframe and reload page
                        sendToParent('imageSaved', {
                            orf_ai_id: currentAiRecordId,
                            saved_orf_id: data.data.saved_orf_id
                        });
                    } else {
                        showNotification('Failed to save image: ' + (data.error || data.message), 'danger');
                        sendToParent('error', { message: 'Failed to save image: ' + (data.error || data.message), code: 'SAVE_FAILED' });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('Failed to save image: ' + error.message, 'danger');
                    sendToParent('error', { message: 'Network error during save', code: 'NETWORK_ERROR' });
                })
                .finally(() => {
                    // Reset submit button
                    saveToTaskSubmit.disabled = false;
                    setButtonWithIcon(saveToTaskSubmit, 'fas fa-save', 'Save');
                });
        });

        // Wire up navigation arrows
        const prevImageButton = document.getElementById('prevImage');
        const nextImageButton = document.getElementById('nextImage');

        prevImageButton.addEventListener('click', showPreviousImage);
        nextImageButton.addEventListener('click', showNextImage);

        // Keyboard navigation
        $(document).on('keydown.comparisonModal', function(e) {
            if ($('#comparisonModal').hasClass('show')) {
                if (e.key === 'ArrowLeft' || e.keyCode === 37) {
                    showPreviousImage();
                } else if (e.key === 'ArrowRight' || e.keyCode === 39) {
                    showNextImage();
                }
            }
        });

        // Reset when modal is closed
        $('#comparisonModal').on('hidden.bs.modal', function() {
            $(document).off('keydown.comparisonModal');
        });

        // =========================================================================
        // CLOSE BUTTON HANDLERS
        // =========================================================================

        function handleClose() {
            sendToParent('close');
        }

        closeModalBtn.addEventListener('click', handleClose);
        closeModalBtnFooter.addEventListener('click', handleClose);

        // =========================================================================
        // INITIALIZATION
        // =========================================================================

        loadProductConfig();
        loadPreviousImages();

    })();
</script>
</body>
</html>
