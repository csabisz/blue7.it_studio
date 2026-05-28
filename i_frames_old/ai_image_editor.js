/**
 * AI Image Editor
 * Fabric.js-based image editor component
 */

var AIImageEditor = (function() {
    'use strict';

    // =========================================================================
    // STATE
    // =========================================================================

    var state = {
        canvas: null,
        originalImage: null,
        originalImageUrl: '',
        editedImageDataUrl: null,
        currentTool: 'select',
        brushSize: 20,
        brushColor: '#ffffff',
        rectColor: '#ffffff',
        historyStack: [],
        historyIndex: -1,
        maxHistory: 50,
        isDrawing: false,
        cropMode: false,
        cropRect: null,
        aspectRatio: null, // null = free, or number like 16/9
        onApplyCallback: null,
        onCancelCallback: null
    };

    // =========================================================================
    // INITIALIZATION
    // =========================================================================

    /**
     * Initialize the editor with an image URL
     */
    function init(imageUrl, options) {
        options = options || {};
        state.originalImageUrl = imageUrl;
        state.onApplyCallback = options.onApply || null;
        state.onCancelCallback = options.onCancel || null;

        // Create and show the editor modal
        createEditorModal();

        // Wait for modal to be fully shown before loading image
        // This ensures the container has correct dimensions
        $('#imageEditorModal').one('shown.bs.modal', function() {
            loadImage(imageUrl);
        });
    }

    /**
     * Create the editor modal HTML
     */
    function createEditorModal() {
        // Remove existing modal if any
        var existingModal = document.getElementById('imageEditorModal');
        if (existingModal) {
            existingModal.remove();
        }

        var modalHtml = '\
<div class="modal fade editor-modal" id="imageEditorModal" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">\
    <div class="modal-dialog modal-xl">\
        <div class="modal-content">\
            <div class="modal-header py-2">\
                <h5 class="modal-title"><i class="fas fa-edit mr-2"></i>Edit Image</h5>\
                <button type="button" class="close" id="editorCloseBtn" aria-label="Close">\
                    <span aria-hidden="true">&times;</span>\
                </button>\
            </div>\
            <div class="modal-body p-0">\
                <!-- Toolbar -->\
                <div class="editor-toolbar">\
                    <div class="toolbar-group">\
                        <button class="toolbar-btn active" data-tool="select" title="Select (V)">\
                            <i class="fas fa-mouse-pointer"></i>\
                        </button>\
                        <button class="toolbar-btn" data-tool="crop" title="Crop (C)">\
                            <i class="fas fa-crop-alt"></i>\
                        </button>\
                        <button class="toolbar-btn" data-tool="eraser" title="Eraser/Brush (E)">\
                            <i class="fas fa-eraser"></i>\
                        </button>\
                        <button class="toolbar-btn" data-tool="rect" title="Rectangle (R)">\
                            <i class="fas fa-square"></i>\
                        </button>\
                    </div>\
                    <div class="toolbar-divider"></div>\
                    <div class="toolbar-group">\
                        <button class="toolbar-btn" id="undoBtn" title="Undo (Ctrl+Z)" disabled>\
                            <i class="fas fa-undo"></i>\
                        </button>\
                        <button class="toolbar-btn" id="redoBtn" title="Redo (Ctrl+Y)" disabled>\
                            <i class="fas fa-redo"></i>\
                        </button>\
                    </div>\
                    <div class="toolbar-divider"></div>\
                    <div class="toolbar-group">\
                        <button class="toolbar-btn reset-btn" id="resetBtn" title="Reset to Original">\
                            <i class="fas fa-sync-alt"></i>\
                        </button>\
                        <button class="toolbar-btn download-btn" id="downloadBtn" title="Download Edited Image">\
                            <i class="fas fa-download"></i>\
                        </button>\
                    </div>\
                </div>\
                \
                <!-- Tool Options -->\
                <div class="tool-options" id="cropOptions">\
                    <div class="tool-option-group">\
                        <span class="tool-option-label">Aspect Ratio:</span>\
                        <div class="aspect-ratio-group">\
                            <button class="aspect-btn active" data-ratio="free">Free</button>\
                            <button class="aspect-btn" data-ratio="16:9">16:9</button>\
                            <button class="aspect-btn" data-ratio="4:3">4:3</button>\
                            <button class="aspect-btn" data-ratio="1:1">1:1</button>\
                            <button class="aspect-btn" data-ratio="9:16">9:16</button>\
                            <button class="aspect-btn" data-ratio="3:4">3:4</button>\
                        </div>\
                    </div>\
                    <div class="toolbar-divider"></div>\
                    <button class="btn btn-sm btn-success" id="applyCropBtn">\
                        <i class="fas fa-check mr-1"></i>Apply Crop\
                    </button>\
                    <button class="btn btn-sm btn-secondary" id="cancelCropBtn">\
                        <i class="fas fa-times mr-1"></i>Cancel\
                    </button>\
                </div>\
                \
                <div class="tool-options" id="eraserOptions">\
                    <div class="tool-option-group">\
                        <span class="tool-option-label">Size:</span>\
                        <input type="range" class="tool-slider" id="brushSizeSlider" min="5" max="100" value="20">\
                        <input type="number" class="tool-option-input" id="brushSizeInput" min="5" max="100" value="20">\
                    </div>\
                    <div class="toolbar-divider"></div>\
                    <div class="tool-option-group">\
                        <span class="tool-option-label">Color:</span>\
                        <div class="color-picker-wrapper">\
                            <input type="color" class="color-picker-input" id="brushColorPicker" value="#ffffff">\
                            <div class="color-picker-preview" id="brushColorPreview" style="background: #ffffff;"></div>\
                        </div>\
                    </div>\
                </div>\
                \
                <div class="tool-options" id="rectOptions">\
                    <div class="tool-option-group">\
                        <span class="tool-option-label">Fill Color:</span>\
                        <div class="color-picker-wrapper">\
                            <input type="color" class="color-picker-input" id="rectColorPicker" value="#ffffff">\
                            <div class="color-picker-preview" id="rectColorPreview" style="background: #ffffff;"></div>\
                        </div>\
                    </div>\
                </div>\
                \
                <!-- Canvas Container -->\
                <div class="editor-canvas-container">\
                    <div class="editor-loading-overlay" id="editorLoading">\
                        <div class="loading-spinner"></div>\
                        <div class="editor-loading-text">Loading image...</div>\
                    </div>\
                    <div class="editor-canvas-wrapper">\
                        <canvas id="editorCanvas"></canvas>\
                    </div>\
                </div>\
                \
                <!-- Status Bar -->\
                <div class="editor-status-bar">\
                    <div class="status-item">\
                        <i class="fas fa-expand-arrows-alt"></i>\
                        <span id="statusDimensions">-</span>\
                    </div>\
                    <div class="status-item">\
                        <span>V: Select | C: Crop | E: Eraser | R: Rectangle | Ctrl+Z: Undo | Ctrl+Y: Redo</span>\
                    </div>\
                </div>\
            </div>\
            <div class="modal-footer py-2">\
                <button type="button" class="btn btn-secondary btn-sm" id="editorCancelBtn">Cancel</button>\
                <button type="button" class="btn btn-primary btn-sm" id="editorApplyBtn">\
                    <i class="fas fa-check mr-1"></i>Apply Edits\
                </button>\
            </div>\
        </div>\
    </div>\
</div>\
<div class="brush-cursor" id="brushCursor"></div>';

        document.body.insertAdjacentHTML('beforeend', modalHtml);

        // Bind events
        bindEvents();

        // Show loading immediately (image will load after modal is shown)
        showLoading(true);

        // Show modal
        $('#imageEditorModal').modal('show');
    }

    /**
     * Load image into the canvas
     */
    function loadImage(imageUrl) {
        showLoading(true);

        // Create a new image to get dimensions
        var img = new Image();
        img.crossOrigin = 'anonymous';

        img.onload = function() {
            // Calculate canvas size to fit in container
            var container = document.querySelector('.editor-canvas-container');
            var maxWidth = container.clientWidth - 40;
            var maxHeight = container.clientHeight - 40;

            var scale = Math.min(maxWidth / img.width, maxHeight / img.height, 1);
            var canvasWidth = img.width * scale;
            var canvasHeight = img.height * scale;

            // Initialize Fabric canvas
            state.canvas = new fabric.Canvas('editorCanvas', {
                width: canvasWidth,
                height: canvasHeight,
                selection: true,
                preserveObjectStacking: true
            });

            // Create background image
            fabric.Image.fromURL(imageUrl, function(fabricImg) {
                fabricImg.set({
                    left: 0,
                    top: 0,
                    scaleX: scale,
                    scaleY: scale,
                    selectable: false,
                    evented: false,
                    originX: 'left',
                    originY: 'top'
                });

                state.originalImage = fabricImg;
                state.canvas.setBackgroundImage(fabricImg, state.canvas.renderAll.bind(state.canvas));

                // Update status
                document.getElementById('statusDimensions').textContent =
                    img.width + ' x ' + img.height + ' px';

                // Save initial state
                saveHistory();

                showLoading(false);
            }, { crossOrigin: 'anonymous' });
        };

        img.onerror = function() {
            showLoading(false);
            alert('Failed to load image. Please try again.');
            closeEditor();
        };

        img.src = imageUrl;
    }

    /**
     * Show/hide loading overlay
     */
    function showLoading(show) {
        var loading = document.getElementById('editorLoading');
        if (loading) {
            loading.style.display = show ? 'flex' : 'none';
        }
    }

    // =========================================================================
    // EVENT BINDING
    // =========================================================================

    function bindEvents() {
        // Tool buttons
        document.querySelectorAll('.toolbar-btn[data-tool]').forEach(function(btn) {
            btn.addEventListener('click', function() {
                selectTool(this.dataset.tool);
            });
        });

        // Undo/Redo
        document.getElementById('undoBtn').addEventListener('click', undo);
        document.getElementById('redoBtn').addEventListener('click', redo);

        // Reset
        document.getElementById('resetBtn').addEventListener('click', resetToOriginal);

        // Download
        document.getElementById('downloadBtn').addEventListener('click', downloadImage);

        // Crop options
        document.querySelectorAll('.aspect-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.aspect-btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');

                var ratio = this.dataset.ratio;
                if (ratio === 'free') {
                    state.aspectRatio = null;
                } else {
                    var parts = ratio.split(':');
                    state.aspectRatio = parseInt(parts[0]) / parseInt(parts[1]);
                }
                if (state.cropRect) {
                    updateCropRect();
                }
            });
        });

        document.getElementById('applyCropBtn').addEventListener('click', applyCrop);
        document.getElementById('cancelCropBtn').addEventListener('click', cancelCrop);

        // Eraser options
        var brushSizeSlider = document.getElementById('brushSizeSlider');
        var brushSizeInput = document.getElementById('brushSizeInput');

        brushSizeSlider.addEventListener('input', function() {
            state.brushSize = parseInt(this.value);
            brushSizeInput.value = this.value;
            updateBrushCursor();
        });

        brushSizeInput.addEventListener('change', function() {
            var val = Math.min(100, Math.max(5, parseInt(this.value) || 20));
            this.value = val;
            state.brushSize = val;
            brushSizeSlider.value = val;
            updateBrushCursor();
        });

        var brushColorPicker = document.getElementById('brushColorPicker');
        var brushColorPreview = document.getElementById('brushColorPreview');

        brushColorPicker.addEventListener('input', function() {
            state.brushColor = this.value;
            brushColorPreview.style.background = this.value;
            if (state.canvas && state.canvas.freeDrawingBrush) {
                state.canvas.freeDrawingBrush.color = this.value;
            }
        });

        brushColorPreview.addEventListener('click', function() {
            brushColorPicker.click();
        });

        // Rectangle options
        var rectColorPicker = document.getElementById('rectColorPicker');
        var rectColorPreview = document.getElementById('rectColorPreview');

        rectColorPicker.addEventListener('input', function() {
            state.rectColor = this.value;
            rectColorPreview.style.background = this.value;
        });

        rectColorPreview.addEventListener('click', function() {
            rectColorPicker.click();
        });

        // Close/Cancel/Apply
        document.getElementById('editorCloseBtn').addEventListener('click', closeEditor);
        document.getElementById('editorCancelBtn').addEventListener('click', closeEditor);
        document.getElementById('editorApplyBtn').addEventListener('click', applyEdits);

        // Keyboard shortcuts
        document.addEventListener('keydown', handleKeydown);

        // Brush cursor
        document.addEventListener('mousemove', updateBrushCursorPosition);

        // Modal hidden event
        $('#imageEditorModal').on('hidden.bs.modal', function() {
            cleanup();
        });
    }

    /**
     * Handle keyboard shortcuts
     */
    function handleKeydown(e) {
        if (!document.getElementById('imageEditorModal')) return;
        if (!$('#imageEditorModal').hasClass('show')) return;

        // Ignore if typing in input
        if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;

        var key = e.key.toLowerCase();

        // Tool shortcuts
        if (key === 'v') {
            e.preventDefault();
            selectTool('select');
        } else if (key === 'c') {
            e.preventDefault();
            selectTool('crop');
        } else if (key === 'e') {
            e.preventDefault();
            selectTool('eraser');
        } else if (key === 'r') {
            e.preventDefault();
            selectTool('rect');
        }

        // Undo/Redo
        if ((e.ctrlKey || e.metaKey) && key === 'z') {
            e.preventDefault();
            if (e.shiftKey) {
                redo();
            } else {
                undo();
            }
        }
        if ((e.ctrlKey || e.metaKey) && key === 'y') {
            e.preventDefault();
            redo();
        }

        // Escape to cancel crop or close
        if (key === 'escape') {
            if (state.cropMode) {
                cancelCrop();
            } else {
                closeEditor();
            }
        }

        // Enter to apply crop
        if (key === 'enter' && state.cropMode) {
            e.preventDefault();
            applyCrop();
        }

        // Delete selected object
        if (key === 'delete' || key === 'backspace') {
            if (state.canvas && state.currentTool === 'select') {
                var activeObject = state.canvas.getActiveObject();
                if (activeObject && activeObject !== state.originalImage) {
                    e.preventDefault();
                    state.canvas.remove(activeObject);
                    saveHistory();
                }
            }
        }
    }

    // =========================================================================
    // TOOL SELECTION
    // =========================================================================

    function selectTool(tool) {
        // Cancel crop mode if switching away
        if (state.cropMode && tool !== 'crop') {
            cancelCrop();
        }

        state.currentTool = tool;

        // Update button states
        document.querySelectorAll('.toolbar-btn[data-tool]').forEach(function(btn) {
            btn.classList.toggle('active', btn.dataset.tool === tool);
        });

        // Hide all tool options
        document.querySelectorAll('.tool-options').forEach(function(opt) {
            opt.classList.remove('active');
        });

        // Show relevant tool options
        if (tool === 'crop') {
            document.getElementById('cropOptions').classList.add('active');
            enterCropMode();
        } else if (tool === 'eraser') {
            document.getElementById('eraserOptions').classList.add('active');
            enterDrawMode();
        } else if (tool === 'rect') {
            document.getElementById('rectOptions').classList.add('active');
            enterRectMode();
        } else {
            enterSelectMode();
        }

        // Update cursor
        updateCursor();
    }

    function updateCursor() {
        if (!state.canvas) return;

        var container = document.querySelector('.editor-canvas-wrapper');
        var brushCursor = document.getElementById('brushCursor');

        if (state.currentTool === 'eraser') {
            container.style.cursor = 'none';
            brushCursor.classList.add('active');
            updateBrushCursor();
        } else if (state.currentTool === 'rect') {
            container.style.cursor = 'crosshair';
            brushCursor.classList.remove('active');
        } else if (state.currentTool === 'crop') {
            container.style.cursor = 'crosshair';
            brushCursor.classList.remove('active');
        } else {
            container.style.cursor = 'default';
            brushCursor.classList.remove('active');
        }
    }

    function updateBrushCursor() {
        var cursor = document.getElementById('brushCursor');
        if (cursor) {
            cursor.style.width = state.brushSize + 'px';
            cursor.style.height = state.brushSize + 'px';
        }
    }

    function updateBrushCursorPosition(e) {
        var cursor = document.getElementById('brushCursor');
        if (cursor && cursor.classList.contains('active')) {
            cursor.style.left = (e.clientX - state.brushSize / 2) + 'px';
            cursor.style.top = (e.clientY - state.brushSize / 2) + 'px';
        }
    }

    // =========================================================================
    // SELECT MODE
    // =========================================================================

    function enterSelectMode() {
        if (!state.canvas) return;

        state.canvas.isDrawingMode = false;
        state.canvas.selection = true;

        // Make all objects selectable except background
        state.canvas.forEachObject(function(obj) {
            obj.selectable = true;
            obj.evented = true;
        });
    }

    // =========================================================================
    // CROP MODE
    // =========================================================================

    function enterCropMode() {
        if (!state.canvas) return;

        state.cropMode = true;
        state.canvas.isDrawingMode = false;
        state.canvas.selection = false;

        // Make all objects unselectable
        state.canvas.forEachObject(function(obj) {
            obj.selectable = false;
            obj.evented = false;
        });

        // Create crop rectangle
        var padding = 50;
        state.cropRect = new fabric.Rect({
            left: padding,
            top: padding,
            width: state.canvas.width - padding * 2,
            height: state.canvas.height - padding * 2,
            fill: 'transparent',
            stroke: '#fff',
            strokeWidth: 2,
            strokeDashArray: [5, 5],
            cornerColor: '#007bff',
            cornerSize: 10,
            transparentCorners: false,
            hasRotatingPoint: false,
            lockRotation: true
        });

        state.canvas.add(state.cropRect);
        state.canvas.setActiveObject(state.cropRect);
        state.cropRect.selectable = true;
        state.cropRect.evented = true;

        // Add dark overlay outside crop area
        updateCropOverlay();

        state.cropRect.on('moving', updateCropOverlay);
        state.cropRect.on('scaling', function() {
            if (state.aspectRatio) {
                enforceAspectRatio();
            }
            updateCropOverlay();
        });
    }

    function updateCropOverlay() {
        // Remove existing overlay
        var overlays = state.canvas.getObjects().filter(function(obj) {
            return obj.isCropOverlay;
        });
        overlays.forEach(function(obj) {
            state.canvas.remove(obj);
        });

        if (!state.cropRect) return;

        var rect = state.cropRect;
        var canvasWidth = state.canvas.width;
        var canvasHeight = state.canvas.height;

        // Create 4 rectangles for the dark overlay
        var overlayColor = 'rgba(0, 0, 0, 0.5)';

        // Top
        var top = new fabric.Rect({
            left: 0,
            top: 0,
            width: canvasWidth,
            height: rect.top,
            fill: overlayColor,
            selectable: false,
            evented: false,
            isCropOverlay: true
        });

        // Bottom
        var bottom = new fabric.Rect({
            left: 0,
            top: rect.top + rect.height * rect.scaleY,
            width: canvasWidth,
            height: canvasHeight - (rect.top + rect.height * rect.scaleY),
            fill: overlayColor,
            selectable: false,
            evented: false,
            isCropOverlay: true
        });

        // Left
        var left = new fabric.Rect({
            left: 0,
            top: rect.top,
            width: rect.left,
            height: rect.height * rect.scaleY,
            fill: overlayColor,
            selectable: false,
            evented: false,
            isCropOverlay: true
        });

        // Right
        var right = new fabric.Rect({
            left: rect.left + rect.width * rect.scaleX,
            top: rect.top,
            width: canvasWidth - (rect.left + rect.width * rect.scaleX),
            height: rect.height * rect.scaleY,
            fill: overlayColor,
            selectable: false,
            evented: false,
            isCropOverlay: true
        });

        state.canvas.add(top, bottom, left, right);
        state.canvas.bringToFront(state.cropRect);
        state.canvas.renderAll();
    }

    function enforceAspectRatio() {
        if (!state.cropRect || !state.aspectRatio) return;

        var rect = state.cropRect;
        var newWidth = rect.width * rect.scaleX;
        var newHeight = newWidth / state.aspectRatio;

        rect.set({
            width: newWidth,
            height: newHeight,
            scaleX: 1,
            scaleY: 1
        });
    }

    function updateCropRect() {
        if (!state.cropRect || !state.aspectRatio) return;

        var rect = state.cropRect;
        var currentWidth = rect.width * rect.scaleX;
        var newHeight = currentWidth / state.aspectRatio;

        rect.set({
            height: newHeight,
            scaleY: 1
        });

        updateCropOverlay();
        state.canvas.renderAll();
    }

    function applyCrop() {
        if (!state.cropRect || !state.canvas) return;

        var rect = state.cropRect;
        var cropX = rect.left;
        var cropY = rect.top;
        var cropWidth = rect.width * rect.scaleX;
        var cropHeight = rect.height * rect.scaleY;

        // Remove crop overlays
        var overlays = state.canvas.getObjects().filter(function(obj) {
            return obj.isCropOverlay;
        });
        overlays.forEach(function(obj) {
            state.canvas.remove(obj);
        });

        state.canvas.remove(state.cropRect);
        state.cropRect = null;

        // Export the cropped area
        var dataUrl = state.canvas.toDataURL({
            format: 'png',
            left: cropX,
            top: cropY,
            width: cropWidth,
            height: cropHeight
        });

        // Reload with cropped image
        fabric.Image.fromURL(dataUrl, function(img) {
            state.canvas.clear();
            state.canvas.setWidth(cropWidth);
            state.canvas.setHeight(cropHeight);

            img.set({
                left: 0,
                top: 0,
                selectable: false,
                evented: false
            });

            state.canvas.setBackgroundImage(img, state.canvas.renderAll.bind(state.canvas));
            state.originalImage = img;

            // Update status
            document.getElementById('statusDimensions').textContent =
                Math.round(cropWidth) + ' x ' + Math.round(cropHeight) + ' px';

            saveHistory();
            state.cropMode = false;
            selectTool('select');
        });
    }

    function cancelCrop() {
        if (!state.canvas) return;

        // Remove crop overlays
        var overlays = state.canvas.getObjects().filter(function(obj) {
            return obj.isCropOverlay;
        });
        overlays.forEach(function(obj) {
            state.canvas.remove(obj);
        });

        if (state.cropRect) {
            state.canvas.remove(state.cropRect);
            state.cropRect = null;
        }

        state.cropMode = false;
        state.aspectRatio = null;

        // Reset aspect ratio buttons
        document.querySelectorAll('.aspect-btn').forEach(function(btn) {
            btn.classList.toggle('active', btn.dataset.ratio === 'free');
        });

        selectTool('select');
    }

    // =========================================================================
    // DRAW MODE (ERASER/BRUSH)
    // =========================================================================

    function enterDrawMode() {
        if (!state.canvas) return;

        state.canvas.isDrawingMode = true;
        state.canvas.selection = false;

        state.canvas.freeDrawingBrush = new fabric.PencilBrush(state.canvas);
        state.canvas.freeDrawingBrush.width = state.brushSize;
        state.canvas.freeDrawingBrush.color = state.brushColor;

        // Save history after path is created
        state.canvas.on('path:created', function() {
            saveHistory();
        });
    }

    // =========================================================================
    // RECTANGLE MODE
    // =========================================================================

    function enterRectMode() {
        if (!state.canvas) return;

        state.canvas.isDrawingMode = false;
        state.canvas.selection = false;

        var startX, startY, rect;

        state.canvas.on('mouse:down', function(opt) {
            if (state.currentTool !== 'rect') return;

            state.isDrawing = true;
            var pointer = state.canvas.getPointer(opt.e);
            startX = pointer.x;
            startY = pointer.y;

            rect = new fabric.Rect({
                left: startX,
                top: startY,
                width: 0,
                height: 0,
                fill: state.rectColor,
                selectable: true
            });

            state.canvas.add(rect);
        });

        state.canvas.on('mouse:move', function(opt) {
            if (!state.isDrawing || state.currentTool !== 'rect' || !rect) return;

            var pointer = state.canvas.getPointer(opt.e);

            if (pointer.x < startX) {
                rect.set({ left: pointer.x });
            }
            if (pointer.y < startY) {
                rect.set({ top: pointer.y });
            }

            rect.set({
                width: Math.abs(pointer.x - startX),
                height: Math.abs(pointer.y - startY)
            });

            state.canvas.renderAll();
        });

        state.canvas.on('mouse:up', function() {
            if (state.currentTool !== 'rect') return;

            state.isDrawing = false;

            if (rect && rect.width > 5 && rect.height > 5) {
                saveHistory();
            } else if (rect) {
                state.canvas.remove(rect);
            }

            rect = null;
        });
    }

    // =========================================================================
    // HISTORY (UNDO/REDO)
    // =========================================================================

    function saveHistory() {
        if (!state.canvas) return;

        // Remove any future history if we're not at the end
        if (state.historyIndex < state.historyStack.length - 1) {
            state.historyStack = state.historyStack.slice(0, state.historyIndex + 1);
        }

        // Save current state
        var json = state.canvas.toJSON(['isCropOverlay']);
        state.historyStack.push(json);

        // Limit history size
        if (state.historyStack.length > state.maxHistory) {
            state.historyStack.shift();
        } else {
            state.historyIndex++;
        }

        updateHistoryButtons();
    }

    function undo() {
        if (state.historyIndex <= 0) return;

        state.historyIndex--;
        loadHistoryState(state.historyStack[state.historyIndex]);
        updateHistoryButtons();
    }

    function redo() {
        if (state.historyIndex >= state.historyStack.length - 1) return;

        state.historyIndex++;
        loadHistoryState(state.historyStack[state.historyIndex]);
        updateHistoryButtons();
    }

    function loadHistoryState(json) {
        if (!state.canvas) return;

        state.canvas.loadFromJSON(json, function() {
            state.canvas.renderAll();
        });
    }

    function updateHistoryButtons() {
        var undoBtn = document.getElementById('undoBtn');
        var redoBtn = document.getElementById('redoBtn');

        if (undoBtn) {
            undoBtn.disabled = state.historyIndex <= 0;
        }
        if (redoBtn) {
            redoBtn.disabled = state.historyIndex >= state.historyStack.length - 1;
        }
    }

    // =========================================================================
    // RESET
    // =========================================================================

    function resetToOriginal() {
        if (!state.originalImageUrl) return;

        if (confirm('Reset all edits and reload the original image?')) {
            // Clear canvas and reload
            if (state.canvas) {
                state.canvas.clear();
                state.canvas.dispose();
                state.canvas = null;
            }

            state.historyStack = [];
            state.historyIndex = -1;
            state.cropMode = false;
            state.cropRect = null;

            loadImage(state.originalImageUrl);
            selectTool('select');
        }
    }

    // =========================================================================
    // EXPORT
    // =========================================================================

    function downloadImage() {
        if (!state.canvas) return;

        // Ensure we're not in crop mode
        if (state.cropMode) {
            cancelCrop();
        }

        var dataUrl = state.canvas.toDataURL({
            format: 'png',
            quality: 1
        });

        var link = document.createElement('a');
        link.download = 'edited-image-' + Date.now() + '.png';
        link.href = dataUrl;
        link.click();
    }

    function applyEdits() {
        if (!state.canvas) return;

        // Ensure we're not in crop mode
        if (state.cropMode) {
            cancelCrop();
        }

        // Deselect all objects to avoid selection borders in export
        state.canvas.discardActiveObject();
        state.canvas.renderAll();

        // Export as data URL with error handling for CORS issues
        try {
            state.editedImageDataUrl = state.canvas.toDataURL({
                format: 'png',
                quality: 1
            });

            // Validate that we got a real data URL (not empty or just the header)
            if (!state.editedImageDataUrl || state.editedImageDataUrl.length < 100) {
                throw new Error('Generated data URL is invalid');
            }

            // Call callback
            if (state.onApplyCallback) {
                state.onApplyCallback(state.editedImageDataUrl);
            }
        } catch (e) {
            console.error('Failed to export canvas:', e);
            alert('Failed to save edits. This may be due to image loading restrictions. Please try downloading the image first and re-uploading it.');
            state.editedImageDataUrl = null;
        }

        closeEditor();
    }

    // =========================================================================
    // CLEANUP
    // =========================================================================

    function closeEditor() {
        if (state.onCancelCallback && !state.editedImageDataUrl) {
            state.onCancelCallback();
        }

        $('#imageEditorModal').modal('hide');
    }

    function cleanup() {
        // Remove event listeners
        document.removeEventListener('keydown', handleKeydown);
        document.removeEventListener('mousemove', updateBrushCursorPosition);

        // Dispose canvas
        if (state.canvas) {
            state.canvas.dispose();
            state.canvas = null;
        }

        // Remove modal
        var modal = document.getElementById('imageEditorModal');
        if (modal) {
            modal.remove();
        }

        // Remove brush cursor
        var cursor = document.getElementById('brushCursor');
        if (cursor) {
            cursor.remove();
        }

        // Reset state
        state.originalImage = null;
        state.editedImageDataUrl = null;
        state.historyStack = [];
        state.historyIndex = -1;
        state.cropMode = false;
        state.cropRect = null;
        state.onApplyCallback = null;
        state.onCancelCallback = null;
    }

    // =========================================================================
    // PUBLIC API
    // =========================================================================

    return {
        init: init,
        getEditedImage: function() {
            return state.editedImageDataUrl;
        }
    };

})();
