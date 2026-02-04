<style>
    .modal-xl {
        max-width: 1440px;
    }

    .comparison-modal .modal-dialog {
        max-width: 90vw;
    }

    .comparison-container {
        position: relative;
        width: 100%;
        height: 70vh;
        overflow: hidden;
        background: #000;
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

    .comparison-after {
        clip-path: none;
    }

    .comparison-slider {
        position: absolute;
        top: 0;
        left: 50%;
        width: 4px;
        height: 100%;
        background: #fff;
        cursor: ew-resize;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
        z-index: 10;
    }

    .comparison-slider::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
    }

    .comparison-slider::after {
        content: '⟷';
        line-height: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 20px;
        color: #333;
        font-weight: bold;
    }

    .comparison-metadata {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0,0,0,0.7);
        color: #fff;
        padding: 15px;
        border-radius: 5px;
        z-index: 20;
        max-width: 300px;
    }

    .comparison-metadata h6 {
        color: #fff;
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: bold;
    }

    .comparison-metadata p {
        margin: 5px 0;
        font-size: 12px;
    }

    .comparison-labels {
        position: absolute;
        bottom: 20px;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 20px;
        z-index: 15;
    }

    .comparison-label {
        background: rgba(0,0,0,0.7);
        color: #fff;
        padding: 8px 15px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
    }

    .comparison-nav-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        color: #fff;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        cursor: pointer;
        z-index: 25;
        font-size: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.3s;
    }

    .comparison-nav-arrow:hover {
        background: rgba(0,0,0,0.8);
    }

    .comparison-nav-arrow:disabled {
        opacity: 0.3;
        cursor: not-allowed;
    }

    .comparison-nav-arrow.left {
        left: 20px;
    }

    .comparison-nav-arrow.right {
        right: 20px;
    }

    .slider-toggle {
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 20;
        background: rgba(0,0,0,0.7);
        color: #fff;
        border: 1px solid rgba(255,255,255,0.3);
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .slider-toggle:hover {
        background: rgba(0,0,0,0.9);
    }

    .modal-generating-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.7);
        z-index: 9999;
        display: none;
        cursor: not-allowed;
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

<!-- AI Image Generation Modal -->
<div class="modal fade text-left" id="aiImageModal<?php echo $result_files[$i]['orf_id']; ?>" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="aiImageModalLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" style="position: relative;">
            <!-- Generating Overlay -->
            <div class="modal-generating-overlay" id="generatingOverlay<?php echo $result_files[$i]['orf_id']; ?>"></div>
            <div class="modal-header">
                <h5 class="modal-title" id="aiImageModalLabel<?php echo $result_files[$i]['orf_id']; ?>">AI Image Generation Settings</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Image Preview Column -->
                    <div class="col-md-4">
                        <h6 class="text-dark mb-3">Current Image</h6>
                        <?php if ($result_files[$i]['orf_compress_path']): ?>
                            <img src="https://blue7.it/studio/result_compress_files/<?= $result_files[$i]['orf_compress_path'] ?>"
                                 alt="Compressed Image"
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
                            <label for="aiModel<?php echo $result_files[$i]['orf_id']; ?>" class="text-dark">Model</label>
                            <select class="form-control form-control-sm" id="aiModel<?php echo $result_files[$i]['orf_id']; ?>">
                                <option value="gemini-3-pro-image-preview">[Google] Nano Banana Pro</option>
                                <option value="gemini-2.5-flash-image">[Google] Nano Banana</option>
                                <option value="imagen-4.0-generate-001">[Google] Imagen 4</option>
                                <option value="imagen-4.0-ultra-generate-001">[Google] Imagen 4 Ultra</option>
                                <option value="imagen-4.0-fast-generate-001">[Google] Imagen 4 Fast</option>
                            </select>
                        </div>

                        <!-- Dynamic form fields container -->
                        <div id="aiDynamicFields<?php echo $result_files[$i]['orf_id']; ?>">
                            <!-- Fields will be dynamically loaded here based on product type -->
                            <div class="text-center text-muted py-3">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                <span class="ml-2">Loading product configuration...</span>
                            </div>
                        </div>

                        <!-- Hidden field to store product type -->
                        <input type="hidden" id="aiProductType<?php echo $result_files[$i]['orf_id']; ?>" value="">
                    </div>

                    <!-- Additional Notes -->
                    <div class="col-md-4">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="aiNotes<?php echo $result_files[$i]['orf_id']; ?>" class="text-dark">Additional Instructions</label>
                                <textarea class="form-control form-control-sm"
                                          id="aiNotes<?php echo $result_files[$i]['orf_id']; ?>"
                                          rows="3"
                                          placeholder="Add any specific requirements or details..."></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label class="text-dark">Reference Images <small class="text-muted">(Optional, max 14)</small></label>
                                <div class="reference-dropzone" id="referenceDropzone<?php echo $result_files[$i]['orf_id']; ?>">
                                    <input type="file" id="referenceFileInput<?php echo $result_files[$i]['orf_id']; ?>" multiple accept="image/jpeg,image/png,image/jpg,image/webp" hidden>
                                    <div class="text-center text-muted py-3">
                                        <i class="fas fa-cloud-upload-alt fa-2x mb-2"></i>
                                        <p class="mb-0 small">Drag & drop or click to upload</p>
                                    </div>
                                </div>
                                <div class="reference-previews mt-2" id="referencePreviews<?php echo $result_files[$i]['orf_id']; ?>"></div>
                                <small class="text-muted"><span id="referenceCount<?php echo $result_files[$i]['orf_id']; ?>">0</span>/14 images</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Previously Generated Images -->
                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="text-dark mb-3">Previously Generated Images</h6>
                        <div id="aiGeneratedPreviews<?php echo $result_files[$i]['orf_id']; ?>" class="d-flex flex-wrap gap-2" style="gap: 0.5rem; max-height: 300px; overflow-y: auto;">
                            <!-- Dynamically populated via AJAX or PHP -->
                            <div class="text-muted small">
                                <em>No previously generated images yet.</em>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="viewFullPrompt<?php echo $result_files[$i]['orf_id']; ?>">
                    <i class="fas fa-eye"></i> View Full Prompt
                </button>
                <button type="button" class="btn btn-info btn-sm" id="generateAIImage<?php echo $result_files[$i]['orf_id']; ?>">
                    Generate Image
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Image Comparison Modal -->
<div class="modal fade comparison-modal" id="comparisonModal<?php echo $result_files[$i]['orf_id']; ?>" tabindex="-1" aria-labelledby="comparisonModalLabel<?php echo $result_files[$i]['orf_id']; ?>" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="comparisonModalLabel<?php echo $result_files[$i]['orf_id']; ?>">Before & After Comparison</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div class="comparison-container" id="comparisonContainer<?php echo $result_files[$i]['orf_id']; ?>">
                    <!-- Original Image (Before) -->
                    <img src="" alt="Before" class="comparison-image comparison-before" id="comparisonBefore<?php echo $result_files[$i]['orf_id']; ?>">

                    <!-- Generated Image (After) -->
                    <img src="" alt="After" class="comparison-image comparison-after" id="comparisonAfter<?php echo $result_files[$i]['orf_id']; ?>">

                    <!-- Slider Toggle Button -->
                    <button class="slider-toggle" id="sliderToggle<?php echo $result_files[$i]['orf_id']; ?>">
                        <i class="fas fa-eye"></i> Show Slider
                    </button>

                    <!-- Navigation Arrows -->
                    <button class="comparison-nav-arrow left" id="prevImage<?php echo $result_files[$i]['orf_id']; ?>">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="comparison-nav-arrow right" id="nextImage<?php echo $result_files[$i]['orf_id']; ?>">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Labels -->
                    <div class="comparison-labels" id="comparisonLabels<?php echo $result_files[$i]['orf_id']; ?>" style="display: none;">
                        <span class="comparison-label">Before (Original)</span>
                        <span class="comparison-label">After (AI Generated)</span>
                    </div>

                    <!-- Metadata Overlay -->
                    <div class="text-left comparison-metadata" id="comparisonMetadata<?php echo $result_files[$i]['orf_id']; ?>">
                        <h6>Generation Details</h6>
                        <p><strong>Room Type:</strong> <span id="metaRoomType<?php echo $result_files[$i]['orf_id']; ?>"></span></p>
                        <p><strong>Style:</strong> <span id="metaStyle<?php echo $result_files[$i]['orf_id']; ?>"></span></p>
                        <p><strong>Model:</strong> <span id="metaModel<?php echo $result_files[$i]['orf_id']; ?>"></span></p>
                        <p><strong>Quality:</strong> <span id="metaQuality<?php echo $result_files[$i]['orf_id']; ?>"></span></p>
                        <p><strong>File Size:</strong> <span id="metaFileSize<?php echo $result_files[$i]['orf_id']; ?>"></span></p>
                        <p><strong>Created:</strong> <span id="metaCreated<?php echo $result_files[$i]['orf_id']; ?>"></span></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-sm" id="saveToTask<?php echo $result_files[$i]['orf_id']; ?>">
                    <i class="fas fa-save mr-1"></i> Save to Task
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        'use strict';

        const orfId = '<?php echo $result_files[$i]['orf_id']; ?>';
        const notesTextarea = document.getElementById('aiNotes' + orfId);
        const dynamicFieldsContainer = document.getElementById('aiDynamicFields' + orfId);
        const productTypeInput = document.getElementById('aiProductType' + orfId);

        // Store product configuration
        let productConfig = null;
        let basePrompt = null;
        let formFields = {}; // Store references to dynamically created form fields
        let referenceImages = []; // Array to store File objects for reference images

        // =========================================================================
        // UTILITY FUNCTIONS (XSS Protection & DOM Helpers)
        // =========================================================================

        /**
         * Sanitizes a string for safe HTML insertion
         * @param {string} text - The text to sanitize
         * @returns {string} - Sanitized text
         */
        function escapeHtml(text) {
            if (text === null || text === undefined) return '';
            const div = document.createElement('div');
            div.textContent = String(text);
            return div.innerHTML;
        }

        /**
         * Sets button to loading state safely
         * @param {HTMLElement} button - The button element
         * @param {string} text - Loading text to display
         */
        function setButtonLoading(button, text) {
            button.innerHTML = '';
            const spinner = document.createElement('span');
            spinner.className = 'spinner-border spinner-border-sm mr-2';
            spinner.setAttribute('role', 'status');
            spinner.setAttribute('aria-hidden', 'true');
            button.appendChild(spinner);
            button.appendChild(document.createTextNode(text));
        }

        /**
         * Sets button to icon + text state safely
         * @param {HTMLElement} button - The button element
         * @param {string} iconClass - FontAwesome icon class
         * @param {string} text - Button text
         */
        function setButtonWithIcon(button, iconClass, text) {
            button.innerHTML = '';
            const icon = document.createElement('i');
            icon.className = iconClass + ' mr-1';
            button.appendChild(icon);
            button.appendChild(document.createTextNode(text));
        }

        /**
         * Creates a throttled function
         * @param {Function} func - Function to throttle
         * @param {number} limit - Minimum time between invocations in ms
         * @returns {Function} - Throttled function
         */
        function throttle(func, limit) {
            let inThrottle;
            return function(...args) {
                if (!inThrottle) {
                    func.apply(this, args);
                    inThrottle = true;
                    setTimeout(() => inThrottle = false, limit);
                }
            };
        }

        // =========================================================================
        // STATE MANAGEMENT (Race Condition Protection)
        // =========================================================================

        let isGenerating = false;

        // =========================================================================
        // NOTIFICATION SYSTEM (Better UX than alerts)
        // =========================================================================

        /**
         * Shows a toast notification
         * @param {string} message - The message to display
         * @param {string} type - Bootstrap alert type (success, danger, warning, info)
         * @param {number} duration - How long to show in ms
         */
        function showNotification(message, type = 'info', duration = 5000) {
            // Create or get notification container
            let container = document.getElementById('notificationContainer');
            if (!container) {
                container = document.createElement('div');
                container.id = 'notificationContainer';
                container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 10000; max-width: 400px;';
                document.body.appendChild(container);
            }

            // Create notification
            const notification = document.createElement('div');
            notification.className = `alert alert-${type} alert-dismissible fade show shadow`;
            notification.style.cssText = 'margin-bottom: 10px; animation: slideInRight 0.3s ease;';
            notification.setAttribute('role', 'alert');

            // Add message text safely
            notification.appendChild(document.createTextNode(message));

            // Create close button
            const closeButton = document.createElement('button');
            closeButton.type = 'button';
            closeButton.className = 'close';
            closeButton.setAttribute('data-dismiss', 'alert');
            closeButton.setAttribute('aria-label', 'Close');
            closeButton.innerHTML = '<span aria-hidden="true">&times;</span>';
            notification.appendChild(closeButton);

            container.appendChild(notification);

            // Auto-dismiss after duration
            setTimeout(() => {
                $(notification).alert('close');
            }, duration);
        }

        // =========================================================================
        // DYNAMIC FIELD RENDERING
        // =========================================================================

        /**
         * Load product configuration from server
         */
        function loadProductConfig() {
            fetch(`ai_get_product_config.php?orf_id=${orfId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        productConfig = data.data.config;
                        basePrompt = data.data.base_prompt;
                        productTypeInput.value = data.data.product_type;

                        // Render dynamic fields
                        renderDynamicFields();
                    } else {
                        // Show error and fallback to default
                        console.error('Failed to load product config:', data.error);
                        showNotification('Failed to load product configuration. Using default fields.', 'warning');
                        dynamicFieldsContainer.innerHTML = '<div class="alert alert-warning">Failed to load configuration</div>';
                    }
                })
                .catch(error => {
                    console.error('Error loading product config:', error);
                    showNotification('Error loading product configuration', 'danger');
                    dynamicFieldsContainer.innerHTML = '<div class="alert alert-danger">Error loading configuration</div>';
                });
        }

        /**
         * Render dynamic form fields based on product configuration
         */
        function renderDynamicFields() {
            if (!productConfig || !productConfig.fields) {
                return;
            }

            // Clear container
            dynamicFieldsContainer.innerHTML = '';

            // Render each field
            productConfig.fields.forEach(fieldConfig => {
                const fieldId = fieldConfig.id + orfId;
                const formGroup = document.createElement('div');
                formGroup.className = 'form-group';

                // Create label
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

                // Create field based on type
                let field = null;
                if (fieldConfig.type === 'select') {
                    field = document.createElement('select');
                    field.className = 'form-control form-control-sm';
                    field.id = fieldId;
                    field.setAttribute('data-field-id', fieldConfig.id);

                    // Add placeholder option
                    const placeholderOption = document.createElement('option');
                    placeholderOption.value = '';
                    placeholderOption.textContent = '-- Select ' + fieldConfig.label + ' --';
                    field.appendChild(placeholderOption);

                    // Add options
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

                    // Add change event for style preset to populate additional instructions
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
                    formGroup.innerHTML = ''; // Clear label
                    formGroup.appendChild(checkboxWrapper);
                }

                if (field && fieldConfig.type !== 'checkbox') {
                    formGroup.appendChild(field);
                }

                // Store field reference
                formFields[fieldConfig.id] = field;

                // Append to container
                dynamicFieldsContainer.appendChild(formGroup);
            });
        }

        // Get original image URL
        const originalImageUrl = '<?php echo "https://blue7.it/studio/result_compress_files/" . $result_files[$i]["orf_compress_path"]; ?>';

        // Store current AI record ID for Save to Task
        let currentAiRecordId = null;
        let allGeneratedImages = [];
        let currentImageIndex = 0;

        // Helper function to format file size
        function formatFileSize(bytes) {
            if (!bytes || bytes === 0) return 'Unknown';
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(1024));
            return Math.round(bytes / Math.pow(1024, i) * 100) / 100 + ' ' + sizes[i];
        }

        // Function to fetch file size from URL
        function getFileSize(url, callback) {
            // Use server-side proxy to avoid CORS issues
            fetch('ai_image_get_file_size.php?url=' + encodeURIComponent(url))
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

        // Function to open comparison modal
        function openComparisonModal(imageData, imageIndex = null) {
            // Set images
            document.getElementById('comparisonBefore' + orfId).src = originalImageUrl;
            document.getElementById('comparisonAfter' + orfId).src = imageData.image_url;

            // Set metadata
            document.getElementById('metaRoomType' + orfId).textContent = imageData.room_type;
            document.getElementById('metaStyle' + orfId).textContent = imageData.style_preset;
            document.getElementById('metaModel' + orfId).textContent = imageData.model;
            document.getElementById('metaQuality' + orfId).textContent = imageData.quality;
            document.getElementById('metaCreated' + orfId).textContent = imageData.created_at;

            // Get and display file size
            const fileSizeElement = document.getElementById('metaFileSize' + orfId);
            fileSizeElement.textContent = 'Calculating...';
            getFileSize(imageData.image_url, function(size) {
                fileSizeElement.textContent = formatFileSize(size);
            });

            // Store AI record ID for Save to Task
            currentAiRecordId = imageData.id;

            // Update current image index if provided
            if (imageIndex !== null) {
                currentImageIndex = imageIndex;
            }

            // Update navigation arrows
            updateNavigationButtons();

            // Reset Save to Task button state
            const saveButton = document.getElementById('saveToTask' + orfId);
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

            // Open modal
            $('#comparisonModal' + orfId).modal('show');
        }

        // Function to update navigation button states
        function updateNavigationButtons() {
            const prevButton = document.getElementById('prevImage' + orfId);
            const nextButton = document.getElementById('nextImage' + orfId);

            prevButton.disabled = currentImageIndex <= 0;
            nextButton.disabled = currentImageIndex >= allGeneratedImages.length - 1;
        }

        // Navigate to previous image
        function showPreviousImage() {
            if (currentImageIndex > 0) {
                // Remove slider when changing images
                if (comparisonSlider) {
                    removeSlider();
                    setButtonWithIcon(sliderToggleButton, 'fas fa-eye', 'Show Slider');
                }
                currentImageIndex--;
                openComparisonModal(allGeneratedImages[currentImageIndex], currentImageIndex);
            }
        }

        // Navigate to next image
        function showNextImage() {
            if (currentImageIndex < allGeneratedImages.length - 1) {
                // Remove slider when changing images
                if (comparisonSlider) {
                    removeSlider();
                    setButtonWithIcon(sliderToggleButton, 'fas fa-eye', 'Show Slider');
                }
                currentImageIndex++;
                openComparisonModal(allGeneratedImages[currentImageIndex], currentImageIndex);
            }
        }

        // Function to create image preview element
        function createImagePreview(imageData) {
            const imageWrapper = document.createElement('div');
            imageWrapper.className = 'position-relative';
            imageWrapper.style.cssText = 'width: 150px; height: 150px; margin: 5px;';
            imageWrapper.dataset.imageId = imageData.id; // Store ID for reference
            // Use escapeHtml for user-provided data
            imageWrapper.title = `Style: ${escapeHtml(imageData.style_preset)}\n` +
                                 `Room: ${escapeHtml(imageData.room_type)}\n` +
                                 `Model: ${escapeHtml(imageData.model)}\n` +
                                 `Created: ${escapeHtml(imageData.created_at || 'Just now')}`;

            const img = document.createElement('img');
            // Use thumbnail if available, otherwise use full image
            img.src = imageData.thumbnail_url || imageData.image_url;
            img.className = 'img-fluid rounded border shadow-sm';
            img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; cursor: pointer;';
            img.alt = 'Generated Image';

            // No individual click handler - using event delegation instead

            imageWrapper.appendChild(img);

            // Add saved badge if image has been saved to task
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

        // =========================================================================
        // EVENT DELEGATION - Single listener for all preview images (Performance)
        // =========================================================================

        // Get DOM references needed for event delegation
        const previewsContainer = document.getElementById('aiGeneratedPreviews' + orfId);

        /**
         * Initialize event delegation for preview images
         * More efficient than individual handlers on each image
         */
        function initializePreviewsContainer() {
            previewsContainer.addEventListener('click', function(e) {
                // Find the clicked image
                const img = e.target.closest('img');
                if (!img) return;

                // Find the wrapper element
                const wrapper = img.closest('.position-relative');
                if (!wrapper) return;

                // Get index from DOM position
                const children = Array.from(previewsContainer.querySelectorAll('.position-relative'));
                const index = children.indexOf(wrapper);

                if (index !== -1 && allGeneratedImages[index]) {
                    openComparisonModal(allGeneratedImages[index], index);
                }
            });
        }

        // Initialize event delegation
        initializePreviewsContainer();

        // Function to load previously generated images
        function loadPreviousImages() {
            // Show loading indicator
            previewsContainer.innerHTML = `
                <div class="text-center py-3">
                    <span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>
                    <span class="text-muted ml-2">Loading previous images...</span>
                </div>
            `;

            fetch(`ai_image_fetch_previous.php?orf_id=${orfId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.images.length > 0) {
                        // Store all images in array for navigation
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
                })
                .catch(error => {
                    console.error('Error loading previous images:', error);
                    allGeneratedImages = [];
                    previewsContainer.innerHTML = '<div class="text-muted small"><em>Error loading previous images.</em></div>';
                });
        }

        // =========================================================================
        // REFERENCE IMAGES DROPZONE
        // =========================================================================

        const referenceDropzone = document.getElementById('referenceDropzone' + orfId);
        const referenceFileInput = document.getElementById('referenceFileInput' + orfId);
        const referencePreviews = document.getElementById('referencePreviews' + orfId);
        const referenceCount = document.getElementById('referenceCount' + orfId);

        // Click to open file picker
        referenceDropzone.addEventListener('click', function() {
            referenceFileInput.click();
        });

        // Handle file input change
        referenceFileInput.addEventListener('change', function(e) {
            addReferenceImages(e.target.files);
            // Reset input so same file can be selected again
            this.value = '';
        });

        // Drag and drop handlers
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

        /**
         * Add reference images with validation
         * @param {FileList} files - Files to add
         */
        function addReferenceImages(files) {
            const maxImages = 14;
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            const maxFileSize = 10 * 1024 * 1024; // 10MB per file

            for (const file of files) {
                // Check max count
                if (referenceImages.length >= maxImages) {
                    showNotification(`Maximum ${maxImages} reference images allowed`, 'warning');
                    break;
                }

                // Validate file type
                if (!allowedTypes.includes(file.type)) {
                    showNotification(`Invalid file type: ${file.name}. Only JPEG, PNG, and WebP allowed.`, 'warning');
                    continue;
                }

                // Validate file size
                if (file.size > maxFileSize) {
                    showNotification(`File too large: ${file.name}. Maximum size is 10MB.`, 'warning');
                    continue;
                }

                // Check for duplicates by name and size
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

        /**
         * Render reference image thumbnails
         */
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
                    URL.revokeObjectURL(this.src); // Free memory
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

        /**
         * Remove a reference image by index
         * @param {number} index - Index to remove
         */
        function removeReferenceImage(index) {
            referenceImages.splice(index, 1);
            renderReferencePreviews();
        }

        /**
         * Clear all reference images (called when modal opens)
         */
        function clearReferenceImages() {
            referenceImages = [];
            renderReferencePreviews();
        }

        // Load product config and previous images when modal is shown (using jQuery for Bootstrap 4 compatibility)
        $('#aiImageModal' + orfId).on('shown.bs.modal', function() {
            loadProductConfig();
            loadPreviousImages();
            clearReferenceImages(); // Reset reference images when modal opens
        });

        // Handle Generate Image button click
        const generateButton = document.getElementById('generateAIImage' + orfId);
        const generatingOverlay = document.getElementById('generatingOverlay' + orfId);

        generateButton.addEventListener('click', function() {
            // Race condition protection: prevent multiple simultaneous requests
            if (isGenerating) {
                return;
            }

            // Check if product config is loaded
            if (!productConfig || !basePrompt) {
                showNotification('Product configuration not loaded. Please close and reopen the modal.', 'warning');
                return;
            }

            // Validate form fields
            const modelSelect = document.getElementById('aiModel' + orfId);
            const productType = productTypeInput.value;

            // Collect field values and validate required fields
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

                // Validate required fields
                if (fieldConfig.required && !value) {
                    showNotification(`Please select/enter ${fieldConfig.label}`, 'warning');
                    hasError = true;
                    return;
                }

                fieldValues[fieldConfig.id] = value;
            });

            // Check for validation errors
            if (hasError) {
                return;
            }

            // Validate additional instructions if using base prompt
            if (!notesTextarea.value.trim()) {
                showNotification('Please add additional instructions', 'warning');
                return;
            }

            // Set generating state
            isGenerating = true;

            // Build variable map for prompt substitution dynamically from all fields
            const promptVariables = {};

            productConfig.fields.forEach(fieldConfig => {
                const field = formFields[fieldConfig.id];
                if (!field) return;

                let value = '';

                if (fieldConfig.type === 'select') {
                    const selectedOption = field.options[field.selectedIndex];
                    if (selectedOption) {
                        // Use prompt_text if available, otherwise use the option label
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

                // Create variable name from field_id (uppercase)
                const varName = fieldConfig.id.toUpperCase();
                promptVariables[varName] = value;
            });

            // Always add ADDITIONAL_INSTRUCTIONS
            promptVariables['ADDITIONAL_INSTRUCTIONS'] = notesTextarea.value.trim();

            // Build final prompt using base prompt template
            let finalPrompt = basePrompt;
            for (const [key, value] of Object.entries(promptVariables)) {
                const regex = new RegExp(`\\[${key}\\]`, 'g');
                finalPrompt = finalPrompt.replace(regex, value);
            }

            // Clean up any remaining placeholders
            finalPrompt = finalPrompt.replace(/\[[A-Z_]+\]/g, '');

            // Prepare form data with all field values
            const formData = new FormData();
            formData.append('orf_id', orfId);
            formData.append('model', modelSelect.value);
            formData.append('product_type', productType);
            formData.append('additional_instructions', notesTextarea.value.trim());
            formData.append('final_prompt', finalPrompt);

            // Add all dynamic field values to form data
            for (const [fieldId, value] of Object.entries(fieldValues)) {
                formData.append(fieldId, value);
            }

            // Add reference images to form data
            referenceImages.forEach(file => {
                formData.append('reference_images[]', file);
            });

            // Disable button and show loading state using safe function
            generateButton.disabled = true;
            setButtonLoading(generateButton, 'Generating...');

            // Show overlay to disable modal interaction
            generatingOverlay.style.display = 'block';

            // Store original button content for restoration
            const restoreButton = function() {
                generateButton.disabled = false;
                generateButton.textContent = 'Generate Image';
                generatingOverlay.style.display = 'none';
            };

            // Submit AJAX request
            fetch('ai_image_generate.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {

                    if (data.success) {
                        // Remove "no images" message if exists
                        const noImagesMessage = previewsContainer.querySelector('.text-muted');
                        if (noImagesMessage) {
                            noImagesMessage.remove();
                        }

                        // Get display labels for the fields
                        const getFieldLabel = (fieldId) => {
                            const field = formFields[fieldId];
                            if (!field) return '';
                            if (field.tagName === 'SELECT') {
                                const selectedOption = field.options[field.selectedIndex];
                                return selectedOption ? selectedOption.text : '';
                            }
                            return field.value;
                        };

                        // Create image preview element using the helper function
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

                        // Add to the beginning of the images array
                        allGeneratedImages.unshift(imageData);

                        // Create new preview (event delegation handles clicks automatically)
                        const imagePreview = createImagePreview(imageData);

                        // Prepend to previews container (newest first)
                        previewsContainer.insertBefore(imagePreview, previewsContainer.firstChild);

                        // Show success notification
                        showNotification('Image generated successfully!', 'success', 3000);
                    } else {
                        // Show error notification
                        showNotification('Failed to generate image: ' + (data.error || data.message), 'danger');
                    }
                })
                .catch(error => {
                    // Show error notification
                    console.error('Error:', error);
                    showNotification('Failed to generate image: Network error or server unavailable. Please try again.', 'danger');
                })
                .finally(() => {
                    // Always restore button state and reset generation flag
                    restoreButton();
                    isGenerating = false;
                });
        });

        // Handle View Full Prompt button click
        const viewPromptButton = document.getElementById('viewFullPrompt' + orfId);

        viewPromptButton.addEventListener('click', function() {
            // Check if product config is loaded
            if (!productConfig || !basePrompt) {
                showNotification('Product configuration not loaded. Please close and reopen the modal.', 'warning');
                return;
            }

            // Collect field values
            const fieldValues = {};

            productConfig.fields.forEach(fieldConfig => {
                const field = formFields[fieldConfig.id];
                if (!field) return;

                let value = '';
                if (fieldConfig.type === 'checkbox') {
                    value = field.checked;
                } else if (fieldConfig.type === 'select' || fieldConfig.type === 'textarea') {
                    value = field.value.trim();
                }

                fieldValues[fieldConfig.id] = value;
            });

            // Build variable map for prompt substitution dynamically from all fields
            const promptVariables = {};

            productConfig.fields.forEach(fieldConfig => {
                const field = formFields[fieldConfig.id];
                if (!field) return;

                let value = '';

                if (fieldConfig.type === 'select') {
                    const selectedOption = field.options[field.selectedIndex];
                    if (selectedOption) {
                        // Use prompt_text if available, otherwise use the option label
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

                // Create variable name from field_id (uppercase)
                const varName = fieldConfig.id.toUpperCase();
                promptVariables[varName] = value;
            });

            // Always add ADDITIONAL_INSTRUCTIONS
            promptVariables['ADDITIONAL_INSTRUCTIONS'] = notesTextarea.value.trim();

            // Build final prompt using base prompt template
            let finalPrompt = basePrompt;
            for (const [key, value] of Object.entries(promptVariables)) {
                const regex = new RegExp(`\\[${key}\\]`, 'g');
                finalPrompt = finalPrompt.replace(regex, value);
            }

            // Clean up any remaining placeholders
            finalPrompt = finalPrompt.replace(/\[[A-Z_]+\]/g, '');

            // Open new window with plain text prompt
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

        // Initialize comparison slider functionality
        const comparisonContainer = document.getElementById('comparisonContainer' + orfId);
        const comparisonAfter = document.getElementById('comparisonAfter' + orfId);
        const comparisonBefore = document.getElementById('comparisonBefore' + orfId);
        const comparisonLabels = document.getElementById('comparisonLabels' + orfId);

        let comparisonSlider = null;
        let isDragging = false;
        let imageBounds = null;

        // Store document-level event handler references for proper cleanup (memory leak prevention)
        let documentMouseUpHandler = null;
        let documentTouchEndHandler = null;

        // Store requestAnimationFrame ID for throttling slider updates (performance optimization)
        let rafId = null;

        function updateImageBounds() {
            if (!comparisonSlider) return;

            // Get the actual rendered size and position of the image
            const imageRect = comparisonBefore.getBoundingClientRect();
            const containerRect = comparisonContainer.getBoundingClientRect();

            imageBounds = {
                left: imageRect.left - containerRect.left,
                right: imageRect.right - containerRect.left,
                width: imageRect.width,
                top: imageRect.top - containerRect.top,
                height: imageRect.height
            };

            // Update slider to match image height and position
            comparisonSlider.style.top = imageBounds.top + 'px';
            comparisonSlider.style.height = imageBounds.height + 'px';
        }

        function updateSliderPosition(clientX) {
            if (!imageBounds || !comparisonSlider) return;

            const containerRect = comparisonContainer.getBoundingClientRect();
            const relativeX = clientX - containerRect.left;

            // Calculate position relative to the actual image bounds
            let position = ((relativeX - imageBounds.left) / imageBounds.width) * 100;

            // Constrain between 0 and 100
            position = Math.max(0, Math.min(100, position));

            // Update slider position within image bounds
            const sliderLeft = imageBounds.left + (imageBounds.width * position / 100);
            comparisonSlider.style.left = sliderLeft + 'px';

            // Update clip path for after image
            comparisonAfter.style.clipPath = `inset(0 0 0 ${position}%)`;
        }

        // Mouse event handlers
        function handleMouseDown(e) {
            isDragging = true;
            e.preventDefault();
        }

        function handleMouseMove(e) {
            if (!isDragging) return;

            // Cancel any pending animation frame for throttling
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            // Schedule update on next frame for smooth performance
            rafId = requestAnimationFrame(() => {
                updateSliderPosition(e.clientX);
                rafId = null;
            });
        }

        function handleMouseUp() {
            isDragging = false;

            // Clean up any pending animation frame
            if (rafId) {
                cancelAnimationFrame(rafId);
                rafId = null;
            }
        }

        // Touch event handlers
        function handleTouchStart(e) {
            isDragging = true;
            e.preventDefault();
        }

        function handleTouchMove(e) {
            if (!isDragging) return;

            // Cancel any pending animation frame for throttling
            if (rafId) {
                cancelAnimationFrame(rafId);
            }

            // Schedule update on next frame for smooth performance
            rafId = requestAnimationFrame(() => {
                updateSliderPosition(e.touches[0].clientX);
                rafId = null;
            });
        }

        function handleTouchEnd() {
            isDragging = false;

            // Clean up any pending animation frame
            if (rafId) {
                cancelAnimationFrame(rafId);
                rafId = null;
            }
        }

        // Click to move slider
        function handleContainerClick(e) {
            // Check if click is on slider itself or any control button
            if (e.target === comparisonSlider ||
                e.target.closest('.slider-toggle') ||
                e.target.closest('.comparison-nav-arrow') ||
                e.target.closest('.comparison-metadata')) {
                return;
            }
            updateSliderPosition(e.clientX);
        }

        function createSlider() {
            // Create slider element
            comparisonSlider = document.createElement('div');
            comparisonSlider.className = 'comparison-slider';
            comparisonSlider.id = 'comparisonSlider' + orfId;

            // Add to container
            comparisonContainer.appendChild(comparisonSlider);

            // Update bounds and position slider
            updateImageBounds();
            if (imageBounds) {
                const centerX = imageBounds.left + (imageBounds.width / 2);
                comparisonSlider.style.left = centerX + 'px';
            }

            // Set initial clip path
            comparisonAfter.style.clipPath = 'inset(0 0 0 50%)';

            // Show comparison labels
            comparisonLabels.style.display = 'flex';

            // Store handler references for proper cleanup
            documentMouseUpHandler = handleMouseUp;
            documentTouchEndHandler = handleTouchEnd;

            // Add event listeners
            comparisonSlider.addEventListener('mousedown', handleMouseDown);
            comparisonContainer.addEventListener('mousemove', handleMouseMove);
            document.addEventListener('mouseup', documentMouseUpHandler);

            comparisonSlider.addEventListener('touchstart', handleTouchStart);
            comparisonContainer.addEventListener('touchmove', handleTouchMove);
            document.addEventListener('touchend', documentTouchEndHandler);

            comparisonContainer.addEventListener('click', handleContainerClick);
        }

        function removeSlider() {
            if (comparisonSlider) {
                // Remove slider-specific event listeners
                comparisonSlider.removeEventListener('mousedown', handleMouseDown);
                comparisonContainer.removeEventListener('mousemove', handleMouseMove);
                comparisonSlider.removeEventListener('touchstart', handleTouchStart);
                comparisonContainer.removeEventListener('touchmove', handleTouchMove);
                comparisonContainer.removeEventListener('click', handleContainerClick);

                // Remove element
                comparisonSlider.remove();
                comparisonSlider = null;
            }

            // Remove document-level listeners using stored references (prevents memory leaks)
            if (documentMouseUpHandler) {
                document.removeEventListener('mouseup', documentMouseUpHandler);
                documentMouseUpHandler = null;
            }
            if (documentTouchEndHandler) {
                document.removeEventListener('touchend', documentTouchEndHandler);
                documentTouchEndHandler = null;
            }

            // Reset clip path
            comparisonAfter.style.clipPath = 'none';

            // Hide comparison labels
            comparisonLabels.style.display = 'none';
        }

        // Handle Save to Task button click
        const saveToTaskButton = document.getElementById('saveToTask' + orfId);
        saveToTaskButton.addEventListener('click', function() {
            if (!currentAiRecordId) {
                showNotification('No AI record selected', 'warning');
                return;
            }

            // Prompt for id_extension
            const idExtension = prompt('Enter Extension ID:');
            if (idExtension === null) {
                return; // User cancelled
            }

            // Prompt for presentation_name
            const presentationName = prompt('Enter Presentation Name:');
            if (presentationName === null) {
                return; // User cancelled
            }


            // Disable button and show loading state using safe function
            saveToTaskButton.disabled = true;
            setButtonLoading(saveToTaskButton, 'Saving...');

            // Prepare form data
            const formData = new FormData();
            formData.append('orf_ai_id', currentAiRecordId);
            formData.append('id_extension', idExtension.trim());
            formData.append('presentation_name', presentationName.trim());

            // Submit AJAX request
            fetch('ai_image_save_to_task.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update button to show success state using safe function
                        setButtonWithIcon(saveToTaskButton, 'fas fa-check', 'Saved Successfully!');
                        saveToTaskButton.classList.remove('btn-success');
                        saveToTaskButton.classList.add('btn-secondary');

                        // Show success notification
                        showNotification('Image saved to task successfully!', 'success', 3000);

                        // Keep button disabled
                        // After 2 seconds, change text to "Already Saved"
                        setTimeout(function() {
                            setButtonWithIcon(saveToTaskButton, 'fas fa-check', 'Already Saved');
                        }, 2000);
                    } else {
                        // Re-enable button on error
                        saveToTaskButton.disabled = false;
                        setButtonWithIcon(saveToTaskButton, 'fas fa-save', 'Save to Task');

                        // Show error notification
                        showNotification('Failed to save image: ' + (data.error || data.message), 'danger');
                    }
                })
                .catch(error => {
                    // Re-enable button on error
                    saveToTaskButton.disabled = false;
                    setButtonWithIcon(saveToTaskButton, 'fas fa-save', 'Save to Task');

                    console.error('Error:', error);
                    showNotification('Failed to save image: ' + error.message, 'danger');
                });
        });

        // Wire up navigation arrows
        const prevImageButton = document.getElementById('prevImage' + orfId);
        const nextImageButton = document.getElementById('nextImage' + orfId);

        prevImageButton.addEventListener('click', showPreviousImage);
        nextImageButton.addEventListener('click', showNextImage);

        // Slider toggle functionality
        const sliderToggleButton = document.getElementById('sliderToggle' + orfId);

        sliderToggleButton.addEventListener('click', function() {
            if (comparisonSlider) {
                // Slider exists, remove it
                removeSlider();
                setButtonWithIcon(sliderToggleButton, 'fas fa-eye', 'Show Slider');
            } else {
                // Slider doesn't exist, create it
                createSlider();
                setButtonWithIcon(sliderToggleButton, 'fas fa-eye-slash', 'Hide Slider');
            }
        });

        // Keyboard navigation (left/right arrows) - using namespaced events for proper cleanup
        $(document).on('keydown.comparisonModal' + orfId, function(e) {
            if ($('#comparisonModal' + orfId).hasClass('show')) {
                if (e.key === 'ArrowLeft' || e.keyCode === 37) {
                    showPreviousImage();
                } else if (e.key === 'ArrowRight' || e.keyCode === 39) {
                    showNextImage();
                }
            }
        });

        // Reset slider and cleanup when modal is closed
        $('#comparisonModal' + orfId).on('hidden.bs.modal', function() {
            // Remove slider if it exists
            if (comparisonSlider) {
                removeSlider();
                setButtonWithIcon(sliderToggleButton, 'fas fa-eye', 'Show Slider');
            }

            // Remove namespaced keydown listener to prevent memory leaks
            $(document).off('keydown.comparisonModal' + orfId);
        });
    })();
</script>