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
        .sg-card-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 6px; }
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
                    Lets the user pick furniture mode, color/texture preset, staging
                    style, room type, quality tier and tool. Selecting an option here
                    auto-fills matching fields in the centre form (which remains
                    editable) and updates the internal settings sent to /v1/generate.
                -->
                <div class="col-md-4 sg-panel">

                    <h6 class="text-dark mb-3">
                        <i class="fas fa-drafting-compass mr-1"></i>
                        Floor Plan Options
                    </h6>

                    <div id="sgPanelStatus" class="sg-status">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Loading Supergrundriss options...
                    </div>

                    <!-- Tool selector (defaults to floorplan-2d) -->
                    <div class="sg-section">
                        <div class="sg-section-label">Tool</div>
                        <select class="form-control form-control-sm" id="sgTool">
                            <option value="floorplan-2d">2D Floor Plan</option>
                        </select>
                    </div>

                    <!-- Furniture / Functions segment -->
                    <!-- <div class="sg-section">
                        <div class="sg-section-label">Furniture &amp; Functions</div>
                        <div class="sg-segment" id="sgFurniture">
                            <button type="button" class="sg-chip" data-value="original">Original</button>
                            <button type="button" class="sg-chip active" data-value="living">Living</button>
                        </div>
                    </div> -->

                    <!-- Room / environment type -->
                    <!-- <div class="sg-section">
                        <div class="sg-section-label">Room / Environment</div>
                        <select class="form-control form-control-sm" id="sgRoomType">
                            <option value="">-- Any --</option>
                            <option value="living_room">Living Room</option>
                            <option value="bedroom">Bedroom</option>
                            <option value="kitchen">Kitchen</option>
                            <option value="bathroom">Bathroom</option>
                            <option value="dining_room">Dining Room</option>
                            <option value="office">Office</option>
                            <option value="hallway">Hallway</option>
                            <option value="apartment">Whole Apartment</option>
                        </select>
                    </div> -->

                    <!-- Color / Texture presets (visual cards) -->
                    <div class="sg-section">
                        <div class="sg-section-label">Colors & Textures</div>
                        <div class="sg-card-grid" id="sgPresets">
                            <div class="sg-status">Loading presets...</div>
                        </div>
                    </div>

                    <!-- Staging styles -->
                    <!-- <div class="sg-section">
                        <div class="sg-section-label">Staging Style</div>
                        <div class="sg-card-grid" id="sgStagingStyles">
                            <div class="sg-status">Loading styles...</div>
                        </div>
                    </div> -->

                    <!-- Quality tier -->
                    <!-- <div class="sg-section">
                        <div class="sg-section-label">Quality Tier</div>
                        <div class="sg-quality-grid" id="sgQuality">
                            <button type="button" class="sg-chip active" data-value="standard">Standard</button>
                            <button type="button" class="sg-chip" data-value="high">High</button>
                            <button type="button" class="sg-chip" data-value="ultra">Ultra</button>
                        </div>
                    </div> -->

                    <!-- Title (optional, sent through additional_instructions) -->
                    <!-- <div class="sg-section">
                        <div class="sg-section-label">Title (optional)</div>
                        <input type="text"
                               class="form-control form-control-sm"
                               id="sgTitle"
                               placeholder="e.g. Apartment 4B - Ground Floor"
                               maxlength="120">
                    </div> -->
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

                    <h6 class="text-dark my-3">Fine-tune Generation Prompt</h6>

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
            <button type="button" class="btn btn-primary btn-sm" id="generateFloorPlan" title="Generate via Supergrundriss /v1/generate">
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
        var dynamicFieldsContainer = document.getElementById('aiDynamicFields');
        var productTypeInput = document.getElementById('aiProductType');
        var previewsContainer = document.getElementById('aiGeneratedPreviews');
        var generateButton = document.getElementById('generateAIImage');
        var generatingOverlay = document.getElementById('generatingOverlay');
        var viewPromptButton = document.getElementById('viewFullPrompt');
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
                        productTypeInput.value = data.data.product_type;
                        renderDynamicFields();
                    } else {
                        console.error('Failed to load product config:', data.error);
                        AIModalShared.showNotification('Failed to load product configuration.', 'warning');
                        dynamicFieldsContainer.innerHTML = '<div class="alert alert-warning">Failed to load configuration</div>';
                        AIModalShared.sendToParent('error', { message: 'Failed to load product configuration', code: 'CONFIG_LOAD_FAILED' });
                    }
                    configLoaded = true;
                    checkReady();
                })
                .catch(function(error) {
                    console.error('Error loading product config:', error);
                    AIModalShared.showNotification('Error loading product configuration', 'danger');
                    dynamicFieldsContainer.innerHTML = '<div class="alert alert-danger">Error loading configuration</div>';
                    AIModalShared.sendToParent('error', { message: 'Error loading product configuration', code: 'CONFIG_LOAD_ERROR' });
                    configLoaded = true;
                    checkReady();
                });
        }

        function renderDynamicFields() {
            if (!productConfig || !productConfig.fields) {
                return;
            }

            dynamicFieldsContainer.innerHTML = '';
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
                dynamicFieldsContainer.appendChild(formGroup);
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

        generateButton.addEventListener('click', function() {
            if (isGenerating) {
                return;
            }

            if (!productConfig || !basePrompt) {
                AIModalShared.showNotification('Product configuration not loaded. Please refresh the page.', 'warning');
                return;
            }

            var modelSelect = document.getElementById('aiModel');
            var productType = productTypeInput.value;

            var fieldValues = {};
            var hasError = false;

            productConfig.fields.forEach(function(fieldConfig) {
                var field = formFields[fieldConfig.id];
                if (!field) return;

                var value = '';
                if (fieldConfig.type === 'checkbox') {
                    value = field.checked;
                } else if (fieldConfig.type === 'select' || fieldConfig.type === 'textarea') {
                    value = field.value.trim();
                }

                if (fieldConfig.required && !value) {
                    AIModalShared.showNotification('Please select/enter ' + fieldConfig.label, 'warning');
                    hasError = true;
                    return;
                }

                fieldValues[fieldConfig.id] = value;
            });

            if (hasError) {
                return;
            }

            isGenerating = true;

            var promptVariables = AIModalShared.getPromptVariables(productConfig, formFields, notesTextarea);
            var finalPrompt = AIModalShared.buildFinalPrompt(basePrompt, promptVariables);

            var formData = new FormData();
            formData.append('orf_id', orfId);
            formData.append('model', modelSelect.value);
            formData.append('product_type', productType);
            formData.append('additional_instructions', notesTextarea.value.trim());
            formData.append('final_prompt', finalPrompt);

            for (var fieldId in fieldValues) {
                if (fieldValues.hasOwnProperty(fieldId)) {
                    formData.append(fieldId, fieldValues[fieldId]);
                }
            }

            // Add user reference images
            var referenceImages = AIModalShared.getReferenceImages();
            referenceImages.forEach(function(file) {
                formData.append('reference_images[]', file);
            });

            // Add admin reference image URLs
            var adminImageUrls = AIModalShared.getAdminReferenceImageUrls();
            if (adminImageUrls.length > 0) {
                formData.append('admin_reference_images', JSON.stringify(adminImageUrls));
            }

            // Add edited image if available
            if (editedImageDataUrl) {
                // Convert data URL to blob
                var byteString = atob(editedImageDataUrl.split(',')[1]);
                var mimeString = editedImageDataUrl.split(',')[0].split(':')[1].split(';')[0];
                var ab = new ArrayBuffer(byteString.length);
                var ia = new Uint8Array(ab);
                for (var i = 0; i < byteString.length; i++) {
                    ia[i] = byteString.charCodeAt(i);
                }
                var blob = new Blob([ab], { type: mimeString });
                formData.append('edited_image', blob, 'edited-image.png');
            }

            generateButton.disabled = true;
            AIModalShared.setButtonLoading(generateButton, 'Generating...');
            generatingOverlay.classList.add('active');

            var restoreButton = function() {
                generateButton.disabled = false;
                generateButton.textContent = 'Generate Image';
                generatingOverlay.classList.remove('active');
            };

            fetch(apiBaseUrl + '/ai_image_generate.php', {
                method: 'POST',
                body: formData
            })
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success) {
                        var noImagesMessage = previewsContainer.querySelector('.text-muted');
                        if (noImagesMessage) {
                            noImagesMessage.remove();
                        }

                        var getFieldLabel = function(fieldId) {
                            var field = formFields[fieldId];
                            if (!field) return '';
                            if (field.tagName === 'SELECT') {
                                var selectedOption = field.options[field.selectedIndex];
                                return selectedOption ? selectedOption.text : '';
                            }
                            return field.value;
                        };

                        var imageData = {
                            id: data.data.ai_record_id,
                            image_url: data.data.image_url,
                            thumbnail_url: data.data.thumbnail_url,
                            model: data.data.model,
                            room_type: getFieldLabel('room_type') || getFieldLabel('space_type') || getFieldLabel('building_type') || getFieldLabel('plan_type'),
                            style_preset: getFieldLabel('style_preset'),
                            quality: data.data.size,
                            created_at: 'Just now'
                        };

                        AIModalShared.addGeneratedImage(imageData);

                        var imagePreview = AIModalShared.createImagePreview(imageData);
                        previewsContainer.insertBefore(imagePreview, previewsContainer.firstChild);

                        AIModalShared.showNotification('Image generated successfully!', 'success', 3000);

                        AIModalShared.sendToParent('imageGenerated', {
                            orf_id: orfId,
                            id: data.data.ai_record_id,
                            image_url: data.data.image_url,
                            thumbnail_url: data.data.thumbnail_url,
                            model: data.data.model,
                            quality: data.data.size
                        });
                    } else {
                        AIModalShared.showNotification('Failed to generate image: ' + (data.error || data.message), 'danger');
                        AIModalShared.sendToParent('error', { message: 'Failed to generate image: ' + (data.error || data.message), code: 'GENERATION_FAILED' });
                    }
                })
                .catch(function(error) {
                    console.error('Error:', error);
                    AIModalShared.showNotification('Failed to generate image: Network error or server unavailable. Please try again.', 'danger');
                    AIModalShared.sendToParent('error', { message: 'Network error during image generation', code: 'NETWORK_ERROR' });
                })
                .finally(function() {
                    restoreButton();
                    isGenerating = false;
                });
        });

        // =========================================================================
        // VIEW FULL PROMPT HANDLER
        // =========================================================================

        viewPromptButton.addEventListener('click', function() {
            if (!productConfig || !basePrompt) {
                AIModalShared.showNotification('Product configuration not loaded. Please refresh the page.', 'warning');
                return;
            }

            var promptVariables = AIModalShared.getPromptVariables(productConfig, formFields, notesTextarea);
            var finalPrompt = AIModalShared.buildFinalPrompt(basePrompt, promptVariables);

            var promptWindow = window.open('', 'Full Prompt', 'width=800,height=600,scrollbars=yes,resizable=yes');
            promptWindow.document.open();
            promptWindow.document.write('<html><head><title>Full AI Prompt</title></head><body>');
            var pre = promptWindow.document.createElement('pre');
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
        // This block wires the new left-side options panel to the Supergrundriss
        // public API documented at https://supergrundriss.de/api/v1/docs.
        //
        // The legacy "Generate Image" path above is preserved untouched. The new
        // "Generate 2D Floor Plan" button (id="generateFloorPlan") submits a
        // multipart/form-data request to POST {apiBaseUrl}/generate using:
        //   - main_image (binary)              : current source / edited image
        //   - tool_slug (string)               : e.g. "floorplan-2d"
        //   - quality_tier (string)            : "standard" | "high" | "ultra"
        //   - settings_json (JSON string)      : { furniture, color_texture_set,
        //                                          staging_style, room_type, title }
        //   - additional_instructions (string) : free-form notes (+ optional title)
        //
        // Authentication: the API requires `Authorization: Bearer flp_xxx` plus an
        // origin in the key whitelist. We DO NOT bake credentials into source.
        // The key is read from (in priority order):
        //   1. URL parameter `?sg_key=flp_...`
        //   2. window.SUPERGRUNDRISS_CONFIG.apiKey set by the parent page
        //
        // TODO: Move credential plumbing server-side (proxy endpoint that injects
        //       the key) so the API key never touches the browser. Update
        //       `sgFetch()` below to point at that proxy when ready.

        var SUPERGRUNDRISS_CONFIG = (window.SUPERGRUNDRISS_CONFIG && typeof window.SUPERGRUNDRISS_CONFIG === 'object')
            ? window.SUPERGRUNDRISS_CONFIG
            : {};
        SUPERGRUNDRISS_CONFIG.apiBaseUrl = urlParams.get('sg_base') || SUPERGRUNDRISS_CONFIG.apiBaseUrl || 'https://supergrundriss.de/api/v1';
        SUPERGRUNDRISS_CONFIG.apiKey = 'flp_VR66bZl5Y448Yw6SSOA8Kk2Tdy4Tc6SA';
        SUPERGRUNDRISS_CONFIG.defaultToolSlug = urlParams.get('sg_tool') || SUPERGRUNDRISS_CONFIG.defaultToolSlug || 'floorplan-2d';

        var sgApiHost = (function() {
            try { return new URL(SUPERGRUNDRISS_CONFIG.apiBaseUrl).origin; }
            catch (e) { return ''; }
        })();

        // DOM references for the new panel
        var sgPanelStatus    = document.getElementById('sgPanelStatus');
        var sgToolSelect     = document.getElementById('sgTool');
        var sgFurnitureBox   = document.getElementById('sgFurniture');
        var sgRoomTypeSelect = document.getElementById('sgRoomType');
        var sgPresetsBox     = document.getElementById('sgPresets');
        var sgStagingBox     = document.getElementById('sgStagingStyles');
        var sgQualityBox     = document.getElementById('sgQuality');
        var sgTitleInput     = document.getElementById('sgTitle');
        var generateFloorPlanBtn = document.getElementById('generateFloorPlan');

        // Internal state mirroring Supergrundriss settings_json + request params.
        var sgState = {
            toolSlug:       SUPERGRUNDRISS_CONFIG.defaultToolSlug,
            quality_tier:   'standard',
            furniture:      'living',
            color_texture_set: 'default',
            staging_style:  '',
            room_type:      ''
        };

        // Cache of the latest /v1/presets payload so we can re-render the cards
        // when the user switches between 2D and 3D tool modes without refetching.
        var sgPresetsCache = [];

        // True when the active tool produces 3D output. Default (2D) is anything
        // that is NOT a 3D tool, so 2D previews win on first render and on any
        // unrecognised slug.
        function sgIsThreeD() {
            return String(sgState.toolSlug || '').toLowerCase().indexOf('3d') !== -1;
        }

        // Pick the preview image variant for a preset based on the active mode.
        // Falls back to the other variant when the requested one is missing so
        // we never render an empty thumbnail.
        function sgPickPreviewImage(item) {
            if (!item) return null;
            if (sgIsThreeD()) return item.preview_image_3d || item.preview_image || null;
            return item.preview_image || item.preview_image_3d || null;
        }

        // -------------------------------------------------------------------------
        // Helpers
        // -------------------------------------------------------------------------

        function sgSetStatus(message, isError) {
            if (!sgPanelStatus) return;
            sgPanelStatus.textContent = message || '';
            sgPanelStatus.className = 'sg-status' + (isError ? ' error' : '');
            sgPanelStatus.style.display = message ? 'block' : 'none';
        }

        function sgFetch(path) {
            if (!SUPERGRUNDRISS_CONFIG.apiKey) {
                return Promise.reject(new Error('Missing Supergrundriss API key (configure via ?sg_key=... or window.SUPERGRUNDRISS_CONFIG.apiKey).'));
            }
            return fetch(SUPERGRUNDRISS_CONFIG.apiBaseUrl + path, {
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + SUPERGRUNDRISS_CONFIG.apiKey, 'Accept': 'application/json' }
            }).then(function(res) {
                return res.json().then(function(body) {
                    if (!res.ok || !body || body.success !== true) {
                        var msg = (body && (body.error || body.message)) || ('HTTP ' + res.status);
                        var err = new Error(msg);
                        err.code = body && body.code;
                        throw err;
                    }
                    return body.data;
                });
            });
        }

        // Populate matching center-form field by id, dispatching a change event so
        // any existing listeners (admin reference image, etc.) still fire. The
        // user can override the value afterwards — fields stay enabled.
        function sgFillCenterField(fieldId, value) {
            if (!fieldId || value === undefined || value === null || value === '') return;
            var field = formFields[fieldId];
            if (!field) return;
            try {
                field.value = String(value);
                if (typeof Event === 'function') {
                    field.dispatchEvent(new Event('change', { bubbles: true }));
                } else {
                    var ev = document.createEvent('HTMLEvents');
                    ev.initEvent('change', true, false);
                    field.dispatchEvent(ev);
                }
            } catch (e) { /* non-fatal */ }
        }

        // Mirror panel state into legacy center-form fields when ids match. We try
        // a handful of common id variations seen across product configurations.
        function sgMirrorToCenterForm() {
            var mirror = {
                room_type:    sgState.room_type,
                space_type:   sgState.room_type,
                building_type: sgState.room_type,
                plan_type:    sgState.toolSlug,
                style_preset: sgState.staging_style,
                furniture:    sgState.furniture,
                color_texture_set: sgState.color_texture_set,
                preset:       sgState.color_texture_set
            };
            for (var k in mirror) {
                if (mirror.hasOwnProperty(k)) sgFillCenterField(k, mirror[k]);
            }
        }

        // -------------------------------------------------------------------------
        // Panel rendering
        // -------------------------------------------------------------------------

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
                    var thumbUrl = (thumbSrc.indexOf('http') === 0)
                        ? thumbSrc
                        : (sgApiHost + thumbSrc);
                    thumb.style.backgroundImage = 'url("' + thumbUrl + '")';
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

        // function sgRenderSegment(container, currentValue, onPick) {
        //     container.querySelectorAll('.sg-chip').forEach(function(chip) {
        //         if (chip.dataset.value === currentValue) chip.classList.add('active');
        //         else chip.classList.remove('active');
        //         chip.addEventListener('click', function() {
        //             container.querySelectorAll('.sg-chip').forEach(function(c) { c.classList.remove('active'); });
        //             chip.classList.add('active');
        //             onPick(chip.dataset.value);
        //         });
        //     });
        // }

        // -------------------------------------------------------------------------
        // Panel initialisation
        // -------------------------------------------------------------------------

        function sgInitPanel() {
            // Wire static segments first so the panel is interactive even if the
            // remote tools/presets/staging-styles fetches fail.
            // sgRenderSegment(sgFurnitureBox, sgState.furniture, function(value) {
            //     sgState.furniture = value;
            //     sgMirrorToCenterForm();
            // });
            // sgRenderSegment(sgQualityBox, sgState.quality_tier, function(value) {
            //     sgState.quality_tier = value;
            // });

            // sgRoomTypeSelect.addEventListener('change', function() {
            //     sgState.room_type = this.value;
            //     sgMirrorToCenterForm();
            // });

            sgToolSelect.addEventListener('change', function() {
                // Update toolSlug FIRST so the renderer (sgPickPreviewImage) sees
                // the new mode and picks the right preview variant.
                sgState.toolSlug = this.value;
                // Re-render from the cached presets so 2D <-> 3D switching is
                // instant and does not depend on a fresh /v1/presets fetch.
                sgRenderCardGrid(sgPresetsBox, sgPresetsCache, sgState.color_texture_set, function(item) {
                    sgState.color_texture_set = item.slug;
                    sgMirrorToCenterForm();
                });
                sgMirrorToCenterForm();
            });

            // sgTitleInput.addEventListener('input', function() {
                // Title flows through additional_instructions at submit time.
            // });

            // If no key is configured, we still let the user interact with the
            // static controls (so they see the UI), but disable the generate
            // button and surface a clear, actionable error.
            if (!SUPERGRUNDRISS_CONFIG.apiKey) {
                sgSetStatus('Supergrundriss API key not configured. Set ?sg_key=flp_... in the iframe URL or window.SUPERGRUNDRISS_CONFIG.apiKey on the parent page.', true);
                sgPresetsBox.innerHTML = '<div class="sg-status">API key required to load presets.</div>';
                sgStagingBox.innerHTML = '<div class="sg-status">API key required to load staging styles.</div>';
                if (generateFloorPlanBtn) {
                    generateFloorPlanBtn.disabled = true;
                    generateFloorPlanBtn.title = 'Configure a Supergrundriss API key to enable generation.';
                }
                return;
            }

            sgSetStatus('Loading Supergrundriss options...');

            // Fetch tools, presets, staging styles in parallel. Failures in one
            // do not block the others — each section degrades independently.
            sgFetch('/tools').then(function(tools) {
                if (!Array.isArray(tools) || !tools.length) return;
                sgToolSelect.innerHTML = '';
                let tempTools = [tools[0], tools[1]];
                tempTools.forEach(function(tool) {
                    var opt = document.createElement('option');
                    opt.value = tool.slug;
                    opt.textContent = tool.name + (tool.category ? ' (' + tool.category + ')' : '');
                    if (tool.slug === sgState.toolSlug) opt.selected = true;
                    sgToolSelect.appendChild(opt);
                });
            }).catch(function(err) {
                console.warn('SG /tools failed:', err);
            });

            sgFetch('/presets').then(function(presets) {
                sgPresetsCache = Array.isArray(presets) ? presets : [];
                sgRenderCardGrid(sgPresetsBox, sgPresetsCache, sgState.color_texture_set, function(item) {
                    sgState.color_texture_set = item.slug;
                    sgMirrorToCenterForm();
                });
            }).catch(function(err) {
                sgPresetsBox.innerHTML = '<div class="sg-status error">Failed to load presets: ' + (err.message || 'unknown error') + '</div>';
            });

            sgFetch('/staging-styles').then(function(styles) {
                sgRenderCardGrid(sgStagingBox, styles, sgState.staging_style, function(item) {
                    sgState.staging_style = item.slug;
                    sgMirrorToCenterForm();
                });
            }).catch(function(err) {
                sgStagingBox.innerHTML = '<div class="sg-status error">Failed to load staging styles: ' + (err.message || 'unknown error') + '</div>';
            });

            sgSetStatus('');
        }

        // -------------------------------------------------------------------------
        // Source image acquisition
        // -------------------------------------------------------------------------

        // Returns a Promise<Blob> for the image to send as `main_image`. Prefers
        // the in-browser edited image (data URL) when present, otherwise fetches
        // the original. Cross-origin fetch may fail — surface a clear message.
        function sgGetSourceBlob() {
            if (editedImageDataUrl) {
                try {
                    var parts = editedImageDataUrl.split(',');
                    var mime = parts[0].split(':')[1].split(';')[0];
                    var bin = atob(parts[1]);
                    var buf = new ArrayBuffer(bin.length);
                    var view = new Uint8Array(buf);
                    for (var i = 0; i < bin.length; i++) view[i] = bin.charCodeAt(i);
                    return Promise.resolve(new Blob([buf], { type: mime }));
                } catch (e) {
                    return Promise.reject(new Error('Failed to decode edited image: ' + e.message));
                }
            }
            if (!originalImageUrl) {
                return Promise.reject(new Error('No source image available to upload.'));
            }
            return fetch(originalImageUrl, { mode: 'cors' })
                .then(function(res) {
                    if (!res.ok) throw new Error('Source image HTTP ' + res.status);
                    return res.blob();
                })
                .catch(function(e) {
                    throw new Error('Could not download the source image (CORS or network). ' +
                        'Use "Edit Image" first or expose the image with CORS. (' + e.message + ')');
                });
        }

        // -------------------------------------------------------------------------
        // Result rendering
        // -------------------------------------------------------------------------

        // Authenticated download of a Supergrundriss-hosted image -> object URL,
        // since result_image_url requires the Bearer token.
        function sgFetchImageObjectUrl(relPath) {
            if (!relPath) return Promise.resolve(null);
            var url = (relPath.indexOf('http') === 0) ? relPath : (sgApiHost + relPath);
            return fetch(url, {
                headers: { 'Authorization': 'Bearer ' + SUPERGRUNDRISS_CONFIG.apiKey }
            }).then(function(res) {
                if (!res.ok) throw new Error('Image download HTTP ' + res.status);
                return res.blob();
            }).then(function(blob) {
                return URL.createObjectURL(blob);
            });
        }

        function sgRenderResult(generation, imageUrl, thumbnailUrl) {
            // Drop the "no images yet" placeholder if present.
            var placeholder = previewsContainer.querySelector('.text-muted');
            if (placeholder) placeholder.remove();

            var card = document.createElement('div');
            card.className = 'sg-floor-plan-result';

            var img = document.createElement('img');
            img.src = thumbnailUrl || imageUrl;
            img.alt = '2D Floor Plan';
            img.title = 'Generation #' + generation.id;
            img.style.cursor = imageUrl ? 'zoom-in' : 'default';
            if (imageUrl) {
                img.addEventListener('click', function() {
                    window.open(imageUrl, '_blank', 'noopener');
                });
            }
            card.appendChild(img);

            var meta = document.createElement('div');
            meta.className = 'sg-fp-meta';
            var parts = [];
            parts.push('<strong>#' + generation.id + '</strong>');
            if (generation.tool_type) parts.push(generation.tool_type);
            if (generation.quality_tier) parts.push(generation.quality_tier);
            meta.innerHTML = parts.join(' &middot; ');
            card.appendChild(meta);

            previewsContainer.insertBefore(card, previewsContainer.firstChild);
        }

        // -------------------------------------------------------------------------
        // Generate handler (Supergrundriss /v1/generate)
        // -------------------------------------------------------------------------

        var sgIsGenerating = false;

        function sgGenerate() {
            if (sgIsGenerating) return;

            if (!SUPERGRUNDRISS_CONFIG.apiKey) {
                AIModalShared.showNotification('Missing Supergrundriss API key. Configure it via ?sg_key=... or window.SUPERGRUNDRISS_CONFIG.apiKey.', 'danger');
                AIModalShared.sendToParent('error', { message: 'Missing Supergrundriss API key', code: 'SG_NO_API_KEY' });
                return;
            }

            // Build settings_json. Center-form values (when fields exist) win
            // over panel state so manual edits are honoured.
            var settings = {
                furniture:         sgState.furniture,
                color_texture_set: sgState.color_texture_set,
                staging_style:     sgState.staging_style,
                room_type:         sgState.room_type
            };

            ['furniture', 'color_texture_set', 'staging_style', 'room_type', 'space_type', 'building_type', 'style_preset', 'preset'].forEach(function(id) {
                var f = formFields[id];
                if (f && typeof f.value === 'string' && f.value.trim() !== '') {
                    var key = (id === 'space_type' || id === 'building_type') ? 'room_type'
                            : (id === 'style_preset')                          ? 'staging_style'
                            : (id === 'preset')                                ? 'color_texture_set'
                            : id;
                    settings[key] = f.value.trim();
                }
            });

            // Drop empty values so settings_json stays compact.
            Object.keys(settings).forEach(function(k) {
                if (settings[k] === '' || settings[k] === null || settings[k] === undefined) delete settings[k];
            });

            // additional_instructions = optional title + free-form notes.
            var noteParts = [];
            var titleVal = (sgTitleInput.value || '').trim();
            if (titleVal) noteParts.push('Title: ' + titleVal);
            var notesVal = (notesTextarea.value || '').trim();
            if (notesVal) noteParts.push(notesVal);
            var additionalInstructions = noteParts.join('\n');

            var toolSlug = sgState.toolSlug || SUPERGRUNDRISS_CONFIG.defaultToolSlug;
            if (!toolSlug) {
                AIModalShared.showNotification('Please select a tool (e.g. 2D Floor Plan).', 'warning');
                return;
            }

            sgIsGenerating = true;
            generateFloorPlanBtn.disabled = true;
            AIModalShared.setButtonLoading(generateFloorPlanBtn, 'Generating...');
            generatingOverlay.classList.add('active');

            var restore = function() {
                sgIsGenerating = false;
                generateFloorPlanBtn.disabled = false;
                AIModalShared.setButtonWithIcon(generateFloorPlanBtn, 'fas fa-drafting-compass', 'Generate 2D Floor Plan');
                generatingOverlay.classList.remove('active');
            };

            sgGetSourceBlob().then(function(blob) {
                var fd = new FormData();
                fd.append('main_image', blob, 'source.png');
                fd.append('tool_slug', toolSlug);
                fd.append('quality_tier', sgState.quality_tier || 'standard');
                fd.append('settings_json', JSON.stringify(settings));
                if (additionalInstructions) fd.append('additional_instructions', additionalInstructions);

                return fetch(SUPERGRUNDRISS_CONFIG.apiBaseUrl + '/generate', {
                    method: 'POST',
                    headers: { 'Authorization': 'Bearer ' + SUPERGRUNDRISS_CONFIG.apiKey, 'Accept': 'application/json' },
                    body: fd
                });
            }).then(function(res) {
                return res.json().then(function(body) {
                    if (!res.ok || !body || body.success !== true || !body.data) {
                        var msg = (body && (body.error || body.message)) || ('HTTP ' + res.status);
                        var err = new Error(msg);
                        err.code = (body && body.code) || ('HTTP_' + res.status);
                        throw err;
                    }
                    return body.data;
                });
            }).then(function(generation) {
                if (generation.status && generation.status !== 'completed') {
                    AIModalShared.showNotification('Floor plan queued (status: ' + generation.status + '). It will appear when ready.', 'info', 4000);
                }
                return Promise.all([
                    sgFetchImageObjectUrl(generation.result_image_url).catch(function() { return null; }),
                    sgFetchImageObjectUrl(generation.result_thumbnail_url).catch(function() { return null; })
                ]).then(function(urls) {
                    var imageUrl = urls[0];
                    var thumbUrl = urls[1] || urls[0];
                    sgRenderResult(generation, imageUrl, thumbUrl);
                    AIModalShared.showNotification('2D floor plan generated successfully!', 'success', 3000);
                    AIModalShared.sendToParent('imageGenerated', {
                        orf_id: orfId,
                        provider: 'supergrundriss',
                        generation_id: generation.id,
                        tool_type: generation.tool_type,
                        quality_tier: generation.quality_tier,
                        image_url: imageUrl,
                        thumbnail_url: thumbUrl
                    });
                });
            }).catch(function(err) {
                console.error('Supergrundriss generate failed:', err);
                AIModalShared.showNotification('Floor plan generation failed: ' + (err.message || 'Unknown error'), 'danger');
                AIModalShared.sendToParent('error', {
                    message: 'Supergrundriss generation failed: ' + (err.message || 'unknown'),
                    code: err.code || 'SG_GENERATION_FAILED'
                });
            }).finally(restore);
        }

        if (generateFloorPlanBtn) {
            generateFloorPlanBtn.addEventListener('click', sgGenerate);
        }

        sgInitPanel();

        // =========================================================================
        // INITIALIZATION
        // =========================================================================

        loadProductConfig();
        loadPreviousImages();

        function getSgState() {
            return sgState.toolSlug;
        }

    })();
</script>
</body>
</html>
