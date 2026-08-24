<?php
/**
 * AI Image Modal - URL-Based Standalone Iframe Version
 *
 * This is a standalone iframe entry point for the AI image generation modal
 * that accepts an arbitrary image URL instead of an orf_id.
 * Can be embedded in any external website via iframe.
 *
 * URL Parameters:
 *   - image_url (required): The URL of the image to transform
 *   - prompt_type_id (optional): Preselect a specific prompt type
 *   - o_id (optional): Order ID - when provided, enables dropdown selection for sub_id and prod_id
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

// Include config functions to get prompt types
require_once __DIR__ . '/../coordination/ai_config/includes/config_functions.php';

// Get parameters
$image_url = isset($_GET['image_url']) ? $_GET['image_url'] : '';
$prompt_type_id = isset($_GET['prompt_type_id']) && !empty($_GET['prompt_type_id']) ? intval($_GET['prompt_type_id']) : 6; // Default to prompt type 6
$o_id = isset($_GET['o_id']) && !empty($_GET['o_id']) ? intval($_GET['o_id']) : null;
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

/**
 * Get sub IDs for an order from orders_subnames table
 */
function getSubIdsForOrder($o_id) {
    $mysqli = getDbConnection();
    $query = "SELECT o_sub_id FROM orders_subnames WHERE o_id = ? ORDER BY o_sub_id ASC";
    $stmt = mysqli_prepare($mysqli, $query);
    mysqli_stmt_bind_param($stmt, "i", $o_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $subIds = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $subIds[] = $row['o_sub_id'];
    }

    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
    return $subIds;
}

// Validate request
if (!$image_url || !validateToken($token)) {
    http_response_code(403);
    die('Invalid request: Missing or invalid image_url or token');
}

// Get all active prompt types for the dropdown
try {
    $promptTypes = getAllPromptTypes(true);
} catch (Exception $e) {
    http_response_code(500);
    die('Failed to load prompt types: ' . $e->getMessage());
}

// If o_id is provided, fetch sub IDs (products are fetched dynamically based on sub_id selection)
$orderSubIds = [];
if ($o_id) {
    try {
        $orderSubIds = getSubIdsForOrder($o_id);
    } catch (Exception $e) {
        // Silently fail - will show text inputs instead
    }
}
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
                    <h6 class="text-dark mb-3">Source Image</h6>
                    <?php if ($image_url): ?>
                        <div class="source-image-container" id="sourceImageContainer">
                            <img src="<?php echo htmlspecialchars($image_url); ?>"
                                 alt="Source Image"
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
                            <small>No image URL provided</small>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Prompt Fine-tuning Column -->
                <div class="col-md-4">
                    <h6 class="text-dark mb-3">Fine-tune Generation Prompt</h6>

                    <!-- Prompt Type Selector -->
                    <div class="form-group">
                        <label for="promptTypeSelect" class="text-dark">Prompt Type</label>
                        <select class="form-control form-control-sm" id="promptTypeSelect">
                            <option value="">-- Select type --</option>
                            <?php foreach ($promptTypes as $type): ?>
                                <option value="<?php echo intval($type['id']); ?>"
                                        <?php echo ($prompt_type_id === intval($type['id'])) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($type['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Model Selection -->
                    <div class="form-group">
                        <label for="aiModel" class="text-dark">Model</label>
                        <select class="form-control form-control-sm" id="aiModel">
                            <!-- Prices: Google list price per image at our default 4K output (ai.google.dev/gemini-api/docs/pricing, Aug 2026) -->
                            <option value="gemini-3.1-flash-image">gemini-3.1-flash-image (~$0.15/img)</option>
                            <option value="gemini-3.1-flash-image-preview">gemini-3.1-flash-image-preview (~$0.15/img)</option>
                            <option value="gemini-3-pro-image-preview">gemini-3-pro-image-preview (~$0.24/img)</option>
                            <option value="gemini-2.5-flash-image">gemini-2.5-flash-image (~$0.04/img, 1K only)</option>
                            <option value="gemini-3.1-flash-lite-image">gemini-3.1-flash-lite-image (~$0.03/img, 1K only)</option>
                        </select>
                    </div>

                    <!-- Dynamic form fields container -->
                    <div id="aiDynamicFields">
                        <div class="text-center text-muted py-3">
                            <em>Select a prompt type above to load configuration options.</em>
                        </div>
                    </div>

                    <!-- Hidden fields to store product type and prompt type id -->
                    <input type="hidden" id="aiProductType" value="">
                    <input type="hidden" id="aiPromptTypeId" value="<?php echo intval($prompt_type_id); ?>">
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

            <!-- Generated Images Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <h6 class="text-dark mb-3">Generated Images</h6>
                    <div id="aiGeneratedPreviews" class="d-flex flex-wrap gap-2" style="gap: 0.5rem; max-height: 300px; overflow-y: auto;">
                        <div class="text-muted small">
                            <em>No generated images yet. Select a prompt type and generate an image to see results here.</em>
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
            <button type="button" class="btn btn-info btn-sm" id="generateAIImage" disabled>
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
                    <div class="alert alert-info small">
                        <i class="fas fa-info-circle mr-1"></i>
                        Since this image was generated from a URL (not a task file), please specify where to save the result.
                    </div>
                    <!-- Row 1: Order ID and Sub ID -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="saveOrderId">Order ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="saveOrderId" name="o_id"
                                   placeholder="e.g., 1234"
                                   value="<?php echo $o_id ? intval($o_id) : ''; ?>"
                                   <?php echo $o_id ? 'readonly' : ''; ?>
                                   required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="saveSubId">Sub ID <span class="text-danger">*</span></label>
                            <?php if ($o_id && !empty($orderSubIds)): ?>
                            <select class="form-control" id="saveSubId" name="sub_id" required>
                                <option value="">-- Select Sub ID --</option>
                                <?php foreach ($orderSubIds as $subId): ?>
                                <option value="<?php echo htmlspecialchars($subId); ?>"><?php echo htmlspecialchars($subId); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php else: ?>
                            <input type="text" class="form-control" id="saveSubId" name="sub_id" placeholder="e.g., n01, x01" required>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Row 2: Product ID and Status -->
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="saveProdId">Product ID <span class="text-danger">*</span></label>
                            <?php if ($o_id && !empty($orderSubIds)): ?>
                            <!-- Products depend on sub_id selection, show disabled dropdown initially -->
                            <select class="form-control" id="saveProdId" name="prod_id" required disabled>
                                <option value="">-- Select Sub ID first --</option>
                            </select>
                            <?php else: ?>
                            <input type="text" class="form-control" id="saveProdId" name="prod_id" placeholder="e.g., p1523" required>
                            <?php endif; ?>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="saveStatus">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="saveStatus" name="status" required>
                                <option value="0">order-request</option>
                                <option value="1">accepted</option>
                                <option value="2">assigned</option>
                                <option value="2.1">waiting for client infos</option>
                                <option value="3">work could start</option>
                                <option value="4">work can start</option>
                                <option value="5">correction needed</option>
                                <option value="6">amendment/client change</option>
                                <option value="6.1">at work</option>
                                <option value="7">checkable</option>
                                <option value="8" selected>checked + confirmed</option>
                                <option value="10">dismissed before</option>
                                <option value="11">dismissed after</option>
                                <option value="12">deleted</option>
                                <option value="13">can not do that</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <!-- Row 3: Extension ID and Presentation Name -->
                    <div class="form-row">
                        <div class="form-group col-md-6 mb-0">
                            <label for="saveExtensionId">Extension ID</label>
                            <input type="text" class="form-control" id="saveExtensionId" name="id_extension" placeholder="Optional">
                        </div>
                        <div class="form-group col-md-6 mb-0">
                            <label for="savePresentationName">Presentation Name</label>
                            <input type="text" class="form-control" id="savePresentationName" name="presentation_name" placeholder="Optional">
                        </div>
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

        // Get parameters from URL and PHP
        var urlParams = new URLSearchParams(window.location.search);
        var imageUrl = urlParams.get('image_url');
        var initialPromptTypeId = '<?php echo $prompt_type_id; ?>';

        // Base URL for API calls (same origin)
        var apiBaseUrl = '/studio/coordination';

        // Loading overlay
        var loadingOverlay = document.getElementById('loadingOverlay');

        // Hide loading overlay after short delay
        setTimeout(function() {
            loadingOverlay.classList.add('hidden');
            AIModalShared.sendToParent('ready', { image_url: imageUrl });
        }, 500);

        // =========================================================================
        // DOM REFERENCES
        // =========================================================================

        var promptTypeSelect = document.getElementById('promptTypeSelect');
        var notesTextarea = document.getElementById('aiNotes');
        var dynamicFieldsContainer = document.getElementById('aiDynamicFields');
        var productTypeInput = document.getElementById('aiProductType');
        var promptTypeIdInput = document.getElementById('aiPromptTypeId');
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
        // PROMPT TYPE SELECTION
        // =========================================================================

        promptTypeSelect.addEventListener('change', function() {
            var selectedTypeId = this.value;

            if (!selectedTypeId) {
                dynamicFieldsContainer.innerHTML = '<div class="text-center text-muted py-3"><em>Select a prompt type above to load configuration options.</em></div>';
                productConfig = null;
                basePrompt = null;
                formFields = {};
                productTypeInput.value = '';
                promptTypeIdInput.value = '';
                generateButton.disabled = true;
                AIModalShared.clearAdminReferenceImages();
                return;
            }

            dynamicFieldsContainer.innerHTML = '\
                <div class="text-center text-muted py-3">\
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>\
                    <span class="ml-2">Loading configuration...</span>\
                </div>';

            loadConfigByPromptType(selectedTypeId);
        });

        function loadConfigByPromptType(promptTypeId) {
            fetch(apiBaseUrl + '/ai_get_config_by_type.php?prompt_type_id=' + promptTypeId)
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success) {
                        productConfig = data.data.config;
                        basePrompt = data.data.base_prompt;
                        productTypeInput.value = data.data.product_type;
                        promptTypeIdInput.value = promptTypeId;
                        renderDynamicFields();
                        generateButton.disabled = false;
                    } else {
                        console.error('Failed to load config:', data.error);
                        AIModalShared.showNotification('Failed to load configuration: ' + data.error, 'warning');
                        dynamicFieldsContainer.innerHTML = '<div class="alert alert-warning">Failed to load configuration</div>';
                        generateButton.disabled = true;
                        AIModalShared.sendToParent('error', { message: 'Failed to load prompt configuration', code: 'CONFIG_LOAD_FAILED' });
                    }
                })
                .catch(function(error) {
                    console.error('Error loading config:', error);
                    AIModalShared.showNotification('Error loading configuration', 'danger');
                    dynamicFieldsContainer.innerHTML = '<div class="alert alert-danger">Error loading configuration</div>';
                    generateButton.disabled = true;
                    AIModalShared.sendToParent('error', { message: 'Error loading prompt configuration', code: 'CONFIG_LOAD_ERROR' });
                });
        }

        // =========================================================================
        // DYNAMIC FIELD RENDERING
        // =========================================================================

        function renderDynamicFields() {
            if (!productConfig || !productConfig.fields) {
                return;
            }

            dynamicFieldsContainer.innerHTML = '';
            formFields = {};
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

            fetch(apiBaseUrl + '/ai_image_fetch_previous.php?image_url=' + encodeURIComponent(imageUrl))
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
                        previewsContainer.innerHTML = '<div class="text-muted small"><em>No previously generated images for this source.</em></div>';
                    }
                })
                .catch(function(error) {
                    console.error('Error loading previous images:', error);
                    AIModalShared.setGeneratedImages([]);
                    previewsContainer.innerHTML = '<div class="text-muted small"><em>Error loading previous images.</em></div>';
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
                AIModalShared.showNotification('Please select a prompt type first.', 'warning');
                return;
            }

            var modelSelect = document.getElementById('aiModel');
            var productType = productTypeInput.value;
            var promptTypeId = promptTypeIdInput.value;

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
            formData.append('image_url', imageUrl);
            formData.append('prompt_type_id', promptTypeId);
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
                            image_url: imageUrl,
                            id: data.data.ai_record_id,
                            generated_image_url: data.data.image_url,
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
                AIModalShared.showNotification('Please select a prompt type first.', 'warning');
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
        var saveOrderId = document.getElementById('saveOrderId');
        var saveStatus = document.getElementById('saveStatus');
        var saveExtensionId = document.getElementById('saveExtensionId');
        var savePresentationName = document.getElementById('savePresentationName');

        // Track if o_id was passed via URL
        var initialOrderId = '<?php echo $o_id ? intval($o_id) : ''; ?>';
        var hasOrderIdFromUrl = initialOrderId !== '';

        // Dynamic loading timeout for debouncing
        var orderIdLoadTimeout = null;

        /**
         * Fetch order data (sub IDs and products) for a given order ID
         */
        function fetchOrderData(orderId, callback) {
            fetch(apiBaseUrl + '/ai_get_order_data.php?o_id=' + encodeURIComponent(orderId))
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success) {
                        callback(null, data.data);
                    } else {
                        callback(data.error || 'Failed to fetch order data', null);
                    }
                })
                .catch(function(error) {
                    callback(error.message || 'Network error', null);
                });
        }

        /**
         * Replace a text input with a select dropdown
         */
        function replaceInputWithSelect(inputId, options, placeholder) {
            var input = document.getElementById(inputId);
            if (!input) return;

            var select = document.createElement('select');
            select.className = 'form-control';
            select.id = inputId;
            select.name = input.name;
            select.required = input.required;

            var placeholderOpt = document.createElement('option');
            placeholderOpt.value = '';
            placeholderOpt.textContent = placeholder;
            select.appendChild(placeholderOpt);

            options.forEach(function(opt) {
                var option = document.createElement('option');
                option.value = opt;
                option.textContent = opt;
                select.appendChild(option);
            });

            input.parentNode.replaceChild(select, input);
        }

        /**
         * Replace a select with a text input
         */
        function replaceSelectWithInput(selectId, placeholder) {
            var select = document.getElementById(selectId);
            if (!select || select.tagName !== 'SELECT') return;

            var input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.id = selectId;
            input.name = select.name;
            input.placeholder = placeholder;
            input.required = select.required;

            select.parentNode.replaceChild(input, select);
        }

        /**
         * Enable/disable form fields
         */
        function setFormFieldsLoading(loading) {
            var subIdField = document.getElementById('saveSubId');
            var prodIdField = document.getElementById('saveProdId');

            if (subIdField) subIdField.disabled = loading;
            if (prodIdField) prodIdField.disabled = loading;
        }

        /**
         * Handle order ID change - fetch new data and update dropdowns
         */
        function handleOrderIdChange(orderId) {
            if (orderIdLoadTimeout) {
                clearTimeout(orderIdLoadTimeout);
            }

            if (!orderId || !/^\d+$/.test(orderId)) {
                return;
            }

            orderIdLoadTimeout = setTimeout(function() {
                setFormFieldsLoading(true);

                fetchOrderData(orderId, function(error, data) {
                    setFormFieldsLoading(false);

                    if (error) {
                        AIModalShared.showNotification('Failed to load order data: ' + error, 'warning');
                        replaceSelectWithInput('saveSubId', 'e.g., n01, x01');
                        replaceSelectWithInput('saveProdId', 'e.g., p1523');
                        return;
                    }

                    if (data.sub_ids && data.sub_ids.length > 0) {
                        replaceInputWithSelect('saveSubId', data.sub_ids, '-- Select Sub ID --');
                        attachSubIdChangeListener();
                    } else {
                        replaceSelectWithInput('saveSubId', 'e.g., n01, x01');
                    }

                    replaceInputWithSelect('saveProdId', [], '-- Select Sub ID first --');
                    document.getElementById('saveProdId').disabled = true;
                });
            }, 500);
        }

        /**
         * Fetch products for a specific order ID and sub ID combination
         */
        function fetchProductsForSubId(orderId, subId, callback) {
            fetch(apiBaseUrl + '/ai_get_order_data.php?o_id=' + encodeURIComponent(orderId) + '&sub_id=' + encodeURIComponent(subId))
                .then(function(response) { return response.json(); })
                .then(function(data) {
                    if (data.success) {
                        callback(null, data.data.products || []);
                    } else {
                        callback(data.error || 'Failed to fetch products', null);
                    }
                })
                .catch(function(error) {
                    callback(error.message || 'Network error', null);
                });
        }

        /**
         * Handle sub ID change - fetch products for this order+sub combination
         */
        function handleSubIdChange(subId) {
            var orderId = saveOrderId.value.trim();
            var prodIdField = document.getElementById('saveProdId');

            if (!orderId || !subId) {
                replaceInputWithSelect('saveProdId', [], '-- Select Sub ID first --');
                document.getElementById('saveProdId').disabled = true;
                return;
            }

            prodIdField.disabled = true;
            if (prodIdField.tagName === 'SELECT') {
                prodIdField.innerHTML = '<option value="">Loading products...</option>';
            }

            fetchProductsForSubId(orderId, subId, function(error, products) {
                if (error) {
                    AIModalShared.showNotification('Failed to load products: ' + error, 'warning');
                    replaceSelectWithInput('saveProdId', 'e.g., p1523');
                    return;
                }

                if (products && products.length > 0) {
                    replaceInputWithSelect('saveProdId', products, '-- Select Product ID --');
                } else {
                    replaceSelectWithInput('saveProdId', 'e.g., p1523');
                }
                document.getElementById('saveProdId').disabled = false;
            });
        }

        /**
         * Attach change listener to sub ID field
         */
        function attachSubIdChangeListener() {
            var subIdField = document.getElementById('saveSubId');
            if (subIdField) {
                subIdField.addEventListener('change', function() {
                    handleSubIdChange(this.value.trim());
                });
            }
        }

        // Add event listener for order ID changes
        if (!hasOrderIdFromUrl) {
            saveOrderId.addEventListener('input', function() {
                handleOrderIdChange(this.value.trim());
            });

            saveOrderId.addEventListener('blur', function() {
                handleOrderIdChange(this.value.trim());
            });
        }

        // Attach sub ID change listener for initial dropdown
        attachSubIdChangeListener();

        // Open the save modal
        saveToTaskButton.addEventListener('click', function() {
            var currentAiRecordId = AIModalShared.getCurrentAiRecordId();
            if (!currentAiRecordId) {
                AIModalShared.showNotification('No AI record selected', 'warning');
                return;
            }

            if (hasOrderIdFromUrl) {
                var subIdSelect = document.getElementById('saveSubId');
                if (subIdSelect && subIdSelect.tagName === 'SELECT') subIdSelect.selectedIndex = 0;

                var prodIdSelect = document.getElementById('saveProdId');
                if (prodIdSelect && prodIdSelect.tagName === 'SELECT') {
                    prodIdSelect.innerHTML = '<option value="">-- Select Sub ID first --</option>';
                    prodIdSelect.disabled = true;
                }
            } else {
                saveOrderId.value = '';
                var subIdField = document.getElementById('saveSubId');
                var prodIdField = document.getElementById('saveProdId');
                if (subIdField.tagName === 'SELECT') {
                    replaceSelectWithInput('saveSubId', 'e.g., n01, x01');
                } else {
                    subIdField.value = '';
                }
                if (prodIdField.tagName === 'SELECT') {
                    replaceSelectWithInput('saveProdId', 'e.g., p1523');
                } else {
                    prodIdField.value = '';
                }
            }

            saveStatus.value = '8';
            saveExtensionId.value = '';
            savePresentationName.value = '';

            $('#saveToTaskModal').modal('show');

            $('#saveToTaskModal').one('shown.bs.modal', function() {
                if (hasOrderIdFromUrl) {
                    document.getElementById('saveSubId').focus();
                } else {
                    saveOrderId.focus();
                }
            });
        });

        // Handle form submission
        saveToTaskForm.addEventListener('submit', function(e) {
            e.preventDefault();

            var currentAiRecordId = AIModalShared.getCurrentAiRecordId();
            var currentSubIdField = document.getElementById('saveSubId');
            var currentProdIdField = document.getElementById('saveProdId');

            var orderId = saveOrderId.value.trim();
            var subId = currentSubIdField.value.trim();
            var prodId = currentProdIdField.value.trim();
            var status = saveStatus.value;
            var idExtension = saveExtensionId.value.trim();
            var presentationName = savePresentationName.value.trim();

            if (!orderId) {
                AIModalShared.showNotification('Order ID is required', 'warning');
                saveOrderId.focus();
                return;
            }

            if (!subId) {
                AIModalShared.showNotification('Sub ID is required', 'warning');
                currentSubIdField.focus();
                return;
            }

            if (!prodId) {
                AIModalShared.showNotification('Product ID is required', 'warning');
                currentProdIdField.focus();
                return;
            }

            saveToTaskSubmit.disabled = true;
            AIModalShared.setButtonLoading(saveToTaskSubmit, 'Saving...');

            var formData = new FormData();
            formData.append('orf_ai_id', currentAiRecordId);
            formData.append('o_id', orderId);
            formData.append('sub_id', subId);
            formData.append('prod_id', prodId);
            formData.append('status', status);
            formData.append('id_extension', idExtension);
            formData.append('presentation_name', presentationName);
            formData.append('source_image_url', imageUrl);

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

                        // Update the image data to show it's saved
                        var allImages = AIModalShared.getGeneratedImages();
                        var savedImage = allImages.find(function(img) { return img.id === currentAiRecordId; });
                        if (savedImage) {
                            savedImage.saved_orf_id = data.data.saved_orf_id;
                        }

                        AIModalShared.sendToParent('imageSaved', {
                            image_url: imageUrl,
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
            AIModalShared.sendToParent('close', { image_url: imageUrl });
        }

        closeModalBtn.addEventListener('click', handleClose);
        closeModalBtnFooter.addEventListener('click', handleClose);

        // =========================================================================
        // INITIALIZATION
        // =========================================================================

        // Load previous images for this source URL
        loadPreviousImages();

        // If prompt_type_id was provided, load its config
        if (initialPromptTypeId) {
            loadConfigByPromptType(initialPromptTypeId);
        }

    })();
</script>
</body>
</html>
