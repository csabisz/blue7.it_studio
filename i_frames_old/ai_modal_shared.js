/**
 * AI Modal Shared JavaScript
 * Shared functionality for ai_image_modal.php and ai_image_modal_url.php
 */

var AIModalShared = (function() {
    'use strict';

    // =========================================================================
    // UTILITY FUNCTIONS
    // =========================================================================

    /**
     * Escape HTML to prevent XSS
     */
    function escapeHtml(text) {
        if (text === null || text === undefined) return '';
        var div = document.createElement('div');
        div.textContent = String(text);
        return div.innerHTML;
    }

    /**
     * Set button to loading state with spinner
     */
    function setButtonLoading(button, text) {
        button.innerHTML = '';
        var spinner = document.createElement('span');
        spinner.className = 'spinner-border spinner-border-sm mr-2';
        spinner.setAttribute('role', 'status');
        spinner.setAttribute('aria-hidden', 'true');
        button.appendChild(spinner);
        button.appendChild(document.createTextNode(text));
    }

    /**
     * Set button with icon
     */
    function setButtonWithIcon(button, iconClass, text) {
        button.innerHTML = '';
        var icon = document.createElement('i');
        icon.className = iconClass + ' mr-1';
        button.appendChild(icon);
        button.appendChild(document.createTextNode(text));
    }

    /**
     * Format file size in human-readable format
     */
    function formatFileSize(bytes) {
        if (!bytes || bytes === 0) return 'Unknown';
        var sizes = ['Bytes', 'KB', 'MB', 'GB'];
        var i = Math.floor(Math.log(bytes) / Math.log(1024));
        return Math.round(bytes / Math.pow(1024, i) * 100) / 100 + ' ' + sizes[i];
    }

    // =========================================================================
    // NOTIFICATION SYSTEM
    // =========================================================================

    /**
     * Show toast notification
     */
    function showNotification(message, type, duration) {
        type = type || 'info';
        duration = duration || 5000;

        var container = document.getElementById('notificationContainer');
        if (!container) {
            container = document.createElement('div');
            container.id = 'notificationContainer';
            container.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 10000; max-width: 400px;';
            document.body.appendChild(container);
        }

        var notification = document.createElement('div');
        notification.className = 'alert alert-' + type + ' alert-dismissible fade show shadow';
        notification.style.cssText = 'margin-bottom: 10px; animation: slideInRight 0.3s ease;';
        notification.setAttribute('role', 'alert');
        notification.appendChild(document.createTextNode(message));

        var closeButton = document.createElement('button');
        closeButton.type = 'button';
        closeButton.className = 'close';
        closeButton.setAttribute('data-dismiss', 'alert');
        closeButton.setAttribute('aria-label', 'Close');
        closeButton.innerHTML = '<span aria-hidden="true">&times;</span>';
        notification.appendChild(closeButton);

        container.appendChild(notification);

        setTimeout(function() {
            $(notification).alert('close');
        }, duration);
    }

    // =========================================================================
    // POSTMESSAGE COMMUNICATION
    // =========================================================================

    /**
     * Send message to parent window
     */
    function sendToParent(event, data, identifier) {
        data = data || {};
        var payload = {
            type: 'ai-modal-event',
            event: event,
            data: data
        };
        if (identifier) {
            payload.data[identifier.key] = identifier.value;
        }
        window.parent.postMessage(payload, '*');
    }

    // =========================================================================
    // ADMIN REFERENCE IMAGE FUNCTIONS
    // =========================================================================

    var adminReferenceImages = {};

    /**
     * Add an admin reference image from a selected option
     */
    function addAdminReferenceImage(fieldId, imageUrl, optionLabel) {
        adminReferenceImages[fieldId] = {
            url: imageUrl,
            label: optionLabel
        };
        renderAdminReferencePreviews();
    }

    /**
     * Remove an admin reference image for a specific field
     */
    function removeAdminReferenceImage(fieldId) {
        if (adminReferenceImages[fieldId]) {
            delete adminReferenceImages[fieldId];
            renderAdminReferencePreviews();
        }
    }

    /**
     * Render admin reference image previews
     */
    function renderAdminReferencePreviews() {
        var adminContainer = document.getElementById('adminReferencePreviews');
        var referencePreviews = document.getElementById('referencePreviews');

        if (!referencePreviews) return;

        if (!adminContainer) {
            adminContainer = document.createElement('div');
            adminContainer.id = 'adminReferencePreviews';
            adminContainer.className = 'admin-reference-previews mb-2';
            referencePreviews.parentNode.insertBefore(adminContainer, referencePreviews);
        }

        adminContainer.innerHTML = '';

        var adminImageKeys = Object.keys(adminReferenceImages);
        if (adminImageKeys.length === 0) {
            adminContainer.style.display = 'none';
            return;
        }

        adminContainer.style.display = 'block';

        var label = document.createElement('small');
        label.className = 'text-muted d-block mb-1';
        label.innerHTML = '<i class="fas fa-magic mr-1"></i>Style References:';
        adminContainer.appendChild(label);

        var previewRow = document.createElement('div');
        previewRow.className = 'd-flex flex-wrap';
        previewRow.style.gap = '8px';

        adminImageKeys.forEach(function(fieldId) {
            var imageData = adminReferenceImages[fieldId];
            var item = document.createElement('div');
            item.className = 'admin-reference-item position-relative';
            item.style.cssText = 'width: 60px; height: 60px;';

            var img = document.createElement('img');
            img.src = imageData.url;
            img.alt = imageData.label;
            img.title = imageData.label + ' (Style Reference)';
            img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; border-radius: 4px; border: 2px solid #17a2b8;';

            item.appendChild(img);
            previewRow.appendChild(item);
        });

        adminContainer.appendChild(previewRow);
    }

    /**
     * Clear all admin reference images
     */
    function clearAdminReferenceImages() {
        adminReferenceImages = {};
        var adminContainer = document.getElementById('adminReferencePreviews');
        if (adminContainer) {
            adminContainer.innerHTML = '';
            adminContainer.style.display = 'none';
        }
    }

    /**
     * Get admin reference image URLs for form submission
     */
    function getAdminReferenceImageUrls() {
        return Object.values(adminReferenceImages).map(function(img) {
            return img.url;
        });
    }

    // =========================================================================
    // REFERENCE IMAGES DROPZONE
    // =========================================================================

    var referenceImages = [];

    /**
     * Initialize the reference dropzone
     */
    function initReferenceDropzone(dropzoneId, fileInputId, previewsId, countId, onUpdate) {
        var dropzone = document.getElementById(dropzoneId);
        var fileInput = document.getElementById(fileInputId);
        var previews = document.getElementById(previewsId);
        var countDisplay = document.getElementById(countId);

        if (!dropzone || !fileInput) return;

        dropzone.addEventListener('click', function() {
            fileInput.click();
        });

        fileInput.addEventListener('change', function(e) {
            addReferenceImages(e.target.files, previews, countDisplay, onUpdate);
            this.value = '';
        });

        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.add('dragover');
        });

        dropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('dragover');
        });

        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            this.classList.remove('dragover');

            if (e.dataTransfer.files.length > 0) {
                addReferenceImages(e.dataTransfer.files, previews, countDisplay, onUpdate);
            }
        });
    }

    /**
     * Add reference images with validation
     */
    function addReferenceImages(files, previewsContainer, countDisplay, onUpdate) {
        var maxImages = 14;
        var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        var maxFileSize = 10 * 1024 * 1024;

        for (var i = 0; i < files.length; i++) {
            var file = files[i];

            if (referenceImages.length >= maxImages) {
                showNotification('Maximum ' + maxImages + ' reference images allowed', 'warning');
                break;
            }

            if (allowedTypes.indexOf(file.type) === -1) {
                showNotification('Invalid file type: ' + file.name + '. Only JPEG, PNG, and WebP allowed.', 'warning');
                continue;
            }

            if (file.size > maxFileSize) {
                showNotification('File too large: ' + file.name + '. Maximum size is 10MB.', 'warning');
                continue;
            }

            var isDuplicate = referenceImages.some(function(existing) {
                return existing.name === file.name && existing.size === file.size;
            });
            if (isDuplicate) {
                showNotification('Duplicate file: ' + file.name, 'info');
                continue;
            }

            referenceImages.push(file);
        }

        renderReferencePreviews(previewsContainer, countDisplay);
        if (onUpdate) onUpdate(referenceImages);
    }

    /**
     * Render reference image previews
     */
    function renderReferencePreviews(previewsContainer, countDisplay) {
        if (!previewsContainer) return;

        previewsContainer.innerHTML = '';
        if (countDisplay) countDisplay.textContent = referenceImages.length;

        referenceImages.forEach(function(file, index) {
            var item = document.createElement('div');
            item.className = 'reference-preview-item';

            var img = document.createElement('img');
            img.src = URL.createObjectURL(file);
            img.alt = file.name;
            img.onload = function() {
                URL.revokeObjectURL(this.src);
            };

            var removeBtn = document.createElement('button');
            removeBtn.type = 'button';
            removeBtn.className = 'reference-preview-remove';
            removeBtn.innerHTML = '&times;';
            removeBtn.title = 'Remove';
            removeBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                removeReferenceImage(index, previewsContainer, countDisplay);
            });

            item.appendChild(img);
            item.appendChild(removeBtn);
            previewsContainer.appendChild(item);
        });
    }

    /**
     * Remove a reference image
     */
    function removeReferenceImage(index, previewsContainer, countDisplay) {
        referenceImages.splice(index, 1);
        renderReferencePreviews(previewsContainer, countDisplay);
    }

    /**
     * Clear all reference images
     */
    function clearReferenceImages(previewsContainer, countDisplay) {
        referenceImages = [];
        renderReferencePreviews(previewsContainer, countDisplay);
    }

    /**
     * Get reference images array
     */
    function getReferenceImages() {
        return referenceImages;
    }

    // =========================================================================
    // COMPARISON MODAL
    // =========================================================================

    var comparisonState = {
        allGeneratedImages: [],
        currentImageIndex: 0,
        currentAiRecordId: null,
        originalImageUrl: ''
    };

    /**
     * Initialize comparison modal
     */
    function initComparisonModal(originalUrl, apiBaseUrl) {
        comparisonState.originalImageUrl = originalUrl;

        var opacitySlider = document.getElementById('opacitySlider');
        var opacityValue = document.getElementById('opacityValue');
        var comparisonAfter = document.getElementById('comparisonAfter');

        if (opacitySlider) {
            opacitySlider.addEventListener('input', function() {
                var value = this.value;
                opacityValue.textContent = value + '%';
                comparisonAfter.style.opacity = value / 100;
            });
        }

        var prevButton = document.getElementById('prevImage');
        var nextButton = document.getElementById('nextImage');

        if (prevButton) {
            prevButton.addEventListener('click', showPreviousImage);
        }
        if (nextButton) {
            nextButton.addEventListener('click', showNextImage);
        }

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

        $('#comparisonModal').on('hidden.bs.modal', function() {
            $(document).off('keydown.comparisonModal');
        });
    }

    /**
     * Reset opacity slider
     */
    function resetOpacitySlider() {
        var opacitySlider = document.getElementById('opacitySlider');
        var opacityValue = document.getElementById('opacityValue');
        var comparisonAfter = document.getElementById('comparisonAfter');

        if (opacitySlider) {
            opacitySlider.value = 100;
            opacityValue.textContent = '100%';
            comparisonAfter.style.opacity = 1;
        }
    }

    /**
     * Open comparison modal with image data
     */
    function openComparisonModal(imageData, imageIndex, apiBaseUrl, onSaveButtonUpdate) {
        resetOpacitySlider();

        document.getElementById('comparisonBefore').src = comparisonState.originalImageUrl;
        document.getElementById('comparisonAfter').src = imageData.image_url;

        document.getElementById('metaRoomType').textContent = imageData.room_type || '-';
        document.getElementById('metaStyle').textContent = imageData.style_preset || '-';
        document.getElementById('metaModel').textContent = imageData.model || '-';
        document.getElementById('metaQuality').textContent = imageData.quality || '-';
        document.getElementById('metaCreated').textContent = imageData.created_at || '-';

        var fileSizeElement = document.getElementById('metaFileSize');
        fileSizeElement.textContent = 'Calculating...';
        getFileSize(imageData.image_url, apiBaseUrl, function(size) {
            fileSizeElement.textContent = formatFileSize(size);
        });

        comparisonState.currentAiRecordId = imageData.id;

        if (imageIndex !== null && imageIndex !== undefined) {
            comparisonState.currentImageIndex = imageIndex;
        }

        updateNavigationButtons();

        if (onSaveButtonUpdate) {
            onSaveButtonUpdate(imageData);
        }

        $('#comparisonModal').modal('show');
    }

    /**
     * Update navigation button states
     */
    function updateNavigationButtons() {
        var prevButton = document.getElementById('prevImage');
        var nextButton = document.getElementById('nextImage');

        if (prevButton) {
            prevButton.disabled = comparisonState.currentImageIndex <= 0;
        }
        if (nextButton) {
            nextButton.disabled = comparisonState.currentImageIndex >= comparisonState.allGeneratedImages.length - 1;
        }
    }

    /**
     * Show previous image
     */
    function showPreviousImage() {
        if (comparisonState.currentImageIndex > 0) {
            comparisonState.currentImageIndex--;
            var imageData = comparisonState.allGeneratedImages[comparisonState.currentImageIndex];
            openComparisonModal(imageData, comparisonState.currentImageIndex);
        }
    }

    /**
     * Show next image
     */
    function showNextImage() {
        if (comparisonState.currentImageIndex < comparisonState.allGeneratedImages.length - 1) {
            comparisonState.currentImageIndex++;
            var imageData = comparisonState.allGeneratedImages[comparisonState.currentImageIndex];
            openComparisonModal(imageData, comparisonState.currentImageIndex);
        }
    }

    /**
     * Get file size from server
     */
    function getFileSize(url, apiBaseUrl, callback) {
        fetch(apiBaseUrl + '/ai_image_get_file_size.php?url=' + encodeURIComponent(url))
            .then(function(response) { return response.json(); })
            .then(function(data) {
                if (data.success && data.data.size) {
                    callback(data.data.size);
                } else {
                    callback(0);
                }
            })
            .catch(function(error) {
                console.error('Error fetching file size:', error);
                callback(0);
            });
    }

    /**
     * Set generated images array
     */
    function setGeneratedImages(images) {
        comparisonState.allGeneratedImages = images;
    }

    /**
     * Add a generated image to the beginning
     */
    function addGeneratedImage(imageData) {
        comparisonState.allGeneratedImages.unshift(imageData);
    }

    /**
     * Get current AI record ID
     */
    function getCurrentAiRecordId() {
        return comparisonState.currentAiRecordId;
    }

    /**
     * Get all generated images
     */
    function getGeneratedImages() {
        return comparisonState.allGeneratedImages;
    }

    /**
     * Set original image URL
     */
    function setOriginalImageUrl(url) {
        comparisonState.originalImageUrl = url;
    }

    // =========================================================================
    // IMAGE PREVIEW CREATION
    // =========================================================================

    /**
     * Create image preview element
     */
    function createImagePreview(imageData) {
        var imageWrapper = document.createElement('div');
        imageWrapper.className = 'position-relative';
        imageWrapper.style.cssText = 'width: 150px; height: 150px; margin: 5px;';
        imageWrapper.dataset.imageId = imageData.id;
        imageWrapper.title = 'Style: ' + escapeHtml(imageData.style_preset) + '\n' +
            'Room: ' + escapeHtml(imageData.room_type) + '\n' +
            'Model: ' + escapeHtml(imageData.model) + '\n' +
            'Created: ' + escapeHtml(imageData.created_at || 'Just now');

        var img = document.createElement('img');
        img.src = imageData.thumbnail_url || imageData.image_url;
        img.className = 'img-fluid rounded border shadow-sm';
        img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; cursor: pointer;';
        img.alt = 'Generated Image';

        imageWrapper.appendChild(img);

        if (imageData.saved_orf_id) {
            var badge = document.createElement('span');
            badge.className = 'badge badge-success';
            badge.style.cssText = 'position: absolute; top: 5px; right: 5px; z-index: 10; padding: 5px 8px;';
            badge.title = 'This image has been saved to the task';
            setButtonWithIcon(badge, 'fas fa-check', 'Saved');
            imageWrapper.appendChild(badge);
        }

        return imageWrapper;
    }

    /**
     * Initialize previews container with click delegation
     */
    function initPreviewsContainer(containerId, onImageClick) {
        var container = document.getElementById(containerId);
        if (!container) return;

        container.addEventListener('click', function(e) {
            var img = e.target.closest('img');
            if (!img) return;

            var wrapper = img.closest('.position-relative');
            if (!wrapper) return;

            var children = Array.from(container.querySelectorAll('.position-relative'));
            var index = children.indexOf(wrapper);

            if (index !== -1 && comparisonState.allGeneratedImages[index]) {
                onImageClick(comparisonState.allGeneratedImages[index], index);
            }
        });
    }

    // =========================================================================
    // PROMPT BUILDER
    // =========================================================================

    /**
     * Build final prompt from base prompt and field values
     */
    function buildFinalPrompt(basePrompt, promptVariables) {
        var finalPrompt = basePrompt;

        for (var key in promptVariables) {
            if (promptVariables.hasOwnProperty(key)) {
                var regex = new RegExp('\\[' + key + '\\]', 'g');
                finalPrompt = finalPrompt.replace(regex, promptVariables[key]);
            }
        }

        // Remove any remaining placeholders
        finalPrompt = finalPrompt.replace(/\[[A-Z_]+\]/g, '');

        return finalPrompt;
    }

    /**
     * Get prompt variables from form fields
     */
    function getPromptVariables(productConfig, formFields, notesTextarea) {
        var promptVariables = {};

        if (!productConfig || !productConfig.fields) return promptVariables;

        productConfig.fields.forEach(function(fieldConfig) {
            var field = formFields[fieldConfig.id];
            if (!field) return;

            var value = '';

            if (fieldConfig.type === 'select') {
                var selectedOption = field.options[field.selectedIndex];
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

            var varName = fieldConfig.id.toUpperCase();
            promptVariables[varName] = value;
        });

        if (notesTextarea) {
            promptVariables['ADDITIONAL_INSTRUCTIONS'] = notesTextarea.value.trim();
        }

        return promptVariables;
    }

    // =========================================================================
    // PUBLIC API
    // =========================================================================

    return {
        // Utilities
        escapeHtml: escapeHtml,
        setButtonLoading: setButtonLoading,
        setButtonWithIcon: setButtonWithIcon,
        formatFileSize: formatFileSize,

        // Notifications
        showNotification: showNotification,

        // PostMessage
        sendToParent: sendToParent,

        // Admin Reference Images
        addAdminReferenceImage: addAdminReferenceImage,
        removeAdminReferenceImage: removeAdminReferenceImage,
        clearAdminReferenceImages: clearAdminReferenceImages,
        getAdminReferenceImageUrls: getAdminReferenceImageUrls,

        // Reference Dropzone
        initReferenceDropzone: initReferenceDropzone,
        getReferenceImages: getReferenceImages,
        clearReferenceImages: clearReferenceImages,

        // Comparison Modal
        initComparisonModal: initComparisonModal,
        openComparisonModal: openComparisonModal,
        setGeneratedImages: setGeneratedImages,
        addGeneratedImage: addGeneratedImage,
        getGeneratedImages: getGeneratedImages,
        getCurrentAiRecordId: getCurrentAiRecordId,
        setOriginalImageUrl: setOriginalImageUrl,

        // Image Previews
        createImagePreview: createImagePreview,
        initPreviewsContainer: initPreviewsContainer,

        // Prompt Builder
        buildFinalPrompt: buildFinalPrompt,
        getPromptVariables: getPromptVariables
    };

})();
