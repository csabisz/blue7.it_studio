<?php
/**
 * Base Prompt Editor
 * Edit base prompt templates with live preview and version control
 *
 * @package Blue7
 * @subpackage AI Config
 */

session_start();
include('../../functions.php');

$prod = new Production;
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");

// Get ID from query string
$prompt_type_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$page_title = "Edit Base Prompt";

include('../../header2.php');
include('../../menu.php');

// Require includes
require_once __DIR__ . '/includes/config_functions.php';
?>

<style>
.variable-tag {
    cursor: pointer;
    margin: 3px;
    font-family: monospace;
}
.variable-tag:hover {
    background-color: #0056b3;
}
#promptTemplate {
    font-family: monospace;
    font-size: 14px;
}
.preview-box {
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    padding: 15px;
    border-radius: 4px;
    white-space: pre-wrap;
    font-family: monospace;
    font-size: 13px;
}
.char-count {
    font-size: 12px;
    color: #6c757d;
}
.product-checkbox {
    display: block;
    margin: 5px 0;
    padding: 5px;
    border-radius: 3px;
}
.product-checkbox:hover {
    background-color: #f8f9fa;
}
.product-checkbox input[type="checkbox"] {
    margin-right: 8px;
}
.product-checkbox.hidden {
    display: none;
}
.selected-product-tag {
    display: inline-block;
    margin: 3px;
    padding: 5px 10px;
    background-color: #007bff;
    color: white;
    border-radius: 3px;
    font-size: 13px;
}
.selected-product-tag .remove-btn {
    cursor: pointer;
    margin-left: 8px;
    font-weight: bold;
}
.selected-product-tag .remove-btn:hover {
    color: #ffdddd;
}
</style>

<section class="top_section">
    <article>
        <div class="container-fluid bg-white">

            <?php
            // Authorization check
            if (isset($_COOKIE['client_id']) && ($_COOKIE['start'] < $_COOKIE['expire'])) {

                if ($_COOKIE['coordination'] > 0) {

                    if (empty($prompt_type_id)) {
                        echo '<div class="alert alert-danger mt-4">Missing product type ID parameter.</div>';
                    } else {
            ?>

                        <div class="row">
                            <div class="col-12">
                                <nav aria-label="breadcrumb" class="mt-3">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="index.php">AI Config</a></li>
                                        <li class="breadcrumb-item active" id="productTypeName">Loading...</li>
                                    </ol>
                                </nav>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="card" style="width: 100%; height: auto;">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Base Prompt Template</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Version selector -->
                                        <div class="form-group">
                                            <label>Version</label>
                                            <select id="versionSelect" class="form-control">
                                                <option value="">Loading...</option>
                                            </select>
                                        </div>

                                        <!-- Prompt template textarea -->
                                        <div class="form-group">
                                            <label for="promptTemplate">Prompt Template</label>
                                            <textarea id="promptTemplate" class="form-control" rows="20" placeholder="Enter base prompt template with [VARIABLE] placeholders..."></textarea>
                                            <small class="form-text char-count">
                                                <span id="charCount">0</span> characters
                                            </small>
                                        </div>

                                        <!-- Change summary -->
                                        <div class="form-group">
                                            <label for="changeSummary">Change Summary (Optional)</label>
                                            <input type="text" id="changeSummary" class="form-control" placeholder="Brief description of what you changed..." maxlength="255">
                                        </div>

                                        <!-- Applicable Products -->
                                        <div class="form-group">
                                            <label>Applicable Products</label>
                                            <small class="form-text text-muted mb-2">
                                                Select which products should use this prompt. Search by product ID or name.
                                            </small>

                                            <!-- Search box -->
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                                </div>
                                                <input type="text" id="productSearch" class="form-control" placeholder="Search products...">
                                            </div>

                                            <!-- Bulk actions -->
                                            <div class="mb-2">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllProducts()">
                                                    <i class="fas fa-check-double"></i> Select All
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="clearAllProducts()">
                                                    <i class="fas fa-times"></i> Clear All
                                                </button>
                                                <span class="ml-2 text-muted" id="selectedCount">0 selected</span>
                                            </div>

                                            <!-- Product list -->
                                            <div id="productList" style="max-height: 300px; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 4px; padding: 10px;">
                                                <div class="text-center text-muted">
                                                    <div class="spinner-border spinner-border-sm" role="status"></div>
                                                    <span class="ml-2">Loading products...</span>
                                                </div>
                                            </div>

                                            <!-- Selected products tags -->
                                            <div id="selectedProducts" class="mt-2"></div>
                                        </div>

                                        <!-- Validation messages -->
                                        <div id="validationMessages"></div>

                                        <!-- Save button -->
                                        <button id="saveButton" class="btn btn-success btn-lg" onclick="savePrompt()">
                                            <i class="fas fa-save"></i> Save New Version
                                        </button>
                                        <a href="index.php" class="btn btn-secondary btn-lg">
                                            <i class="fas fa-arrow-left"></i> Back to Dashboard
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <!-- Variable Reference -->
                                <div class="card mb-3" style="width: 100%; height: auto;">
                                    <div class="card-header bg-info text-white">
                                        <h6 class="mb-0">Available Variables</h6>
                                    </div>
                                    <div class="card-body" id="variablesContainer">
                                        <small class="text-muted">Click to insert into template</small>
                                        <div id="variablesList" class="mt-2">
                                            <div class="text-center">
                                                <div class="spinner-border spinner-border-sm" role="status"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Live Preview -->
                                <div class="card" style="width: 100%; height: auto;">
                                    <div class="card-header bg-success text-white">
                                        <h6 class="mb-0">Preview</h6>
                                    </div>
                                    <div class="card-body">
                                        <button class="btn btn-sm btn-primary btn-block mb-3" onclick="generatePreview()">
                                            <i class="fas fa-eye"></i> Generate Preview
                                        </button>
                                        <div id="previewOutput" class="preview-box">
                                            Click "Generate Preview" to see compiled prompt
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

            <?php
                    }
                } else {
                    echo '<div class="alert alert-danger mt-4">You do not have permission to access this page.</div>';
                }
            } else {
                echo '<div class="alert alert-warning mt-4">Please log in to continue.</div>';
            }
            ?>

        </div>
    </article>
</section>

<script>
let currentProductType = null;
let currentPrompt = null;
let allVersions = [];
let loadedVersion = 0;
let availableFields = [];
let allProducts = [];
let selectedProducts = new Set();

const promptTypeId = <?php echo intval($prompt_type_id); ?>;

// Load on page load
document.addEventListener('DOMContentLoaded', function() {
    if (promptTypeId) {
        loadPromptData();
        loadFieldVariables();
        loadProducts();
    }

    // Character count
    document.getElementById('promptTemplate').addEventListener('input', updateCharCount);

    // Product search
    document.getElementById('productSearch').addEventListener('input', filterProducts);
});

function loadPromptData() {
    fetch(`api/get_prompt.php?id=${promptTypeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                currentPrompt = data.data.prompt;
                allVersions = data.data.all_versions || [];

                // Update breadcrumb with type name from API response
                if (currentPrompt && currentPrompt.type_name) {
                    document.getElementById('productTypeName').textContent = currentPrompt.type_name;
                }

                // Populate version dropdown
                populateVersionDropdown();

                // Load active prompt
                if (currentPrompt) {
                    document.getElementById('promptTemplate').value = currentPrompt.prompt_template;
                    loadedVersion = currentPrompt.version;
                    updateCharCount();

                    // Load assigned products if product list has already loaded
                    if (allProducts.length > 0) {
                        loadPromptProducts(currentPrompt.id);
                    }
                }
            } else {
                showError('Failed to load prompt: ' + data.error);
            }
        })
        .catch(error => {
            showError('Error loading prompt: ' + error.message);
        });
}

function loadFieldVariables() {
    fetch(`api/get_fields.php?id=${promptTypeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                availableFields = data.data;
                renderVariables();
            }
        })
        .catch(error => {
            console.error('Error loading fields:', error);
        });
}

function populateVersionDropdown() {
    const select = document.getElementById('versionSelect');
    select.innerHTML = '';

    if (allVersions.length === 0) {
        select.innerHTML = '<option value="">No versions yet</option>';
        select.disabled = true;
        return;
    }

    allVersions.forEach(version => {
        const option = document.createElement('option');
        option.value = version.id;
        option.textContent = `Version ${version.version}${version.is_active ? ' (Current)' : ''}`;
        if (version.is_active) {
            option.selected = true;
        }
        select.appendChild(option);
    });

    // Load selected version when changed
    select.addEventListener('change', function() {
        const versionId = parseInt(this.value);
        const version = allVersions.find(v => v.id === versionId);
        if (version) {
            document.getElementById('promptTemplate').value = version.prompt_template;
            updateCharCount();
        }
    });
}

function renderVariables() {
    const container = document.getElementById('variablesList');

    if (availableFields.length === 0) {
        container.innerHTML = '<small class="text-muted">No fields configured yet</small>';
        return;
    }

    container.innerHTML = '';

    // Add field variables
    availableFields.forEach(field => {
        const varName = field.field_id.toUpperCase();
        const badge = document.createElement('span');
        badge.className = 'badge badge-primary variable-tag';
        badge.textContent = `[${varName}]`;
        badge.title = `Click to insert [${varName}]`;
        badge.onclick = () => insertVariable(varName);
        container.appendChild(badge);
    });

    // Always add ADDITIONAL_INSTRUCTIONS
    const aiVar = document.createElement('span');
    aiVar.className = 'badge badge-warning variable-tag';
    aiVar.textContent = '[ADDITIONAL_INSTRUCTIONS]';
    aiVar.title = 'Click to insert [ADDITIONAL_INSTRUCTIONS]';
    aiVar.onclick = () => insertVariable('ADDITIONAL_INSTRUCTIONS');
    container.appendChild(aiVar);
}

function insertVariable(varName) {
    const textarea = document.getElementById('promptTemplate');
    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;
    const text = textarea.value;

    const varText = `[${varName}]`;
    textarea.value = text.substring(0, start) + varText + text.substring(end);

    // Move cursor after inserted variable
    textarea.selectionStart = textarea.selectionEnd = start + varText.length;
    textarea.focus();

    updateCharCount();
}

function updateCharCount() {
    const textarea = document.getElementById('promptTemplate');
    const count = textarea.value.length;
    document.getElementById('charCount').textContent = count;

    // Show warning if too long or too short
    const charCountEl = document.querySelector('.char-count');
    if (count < 50) {
        charCountEl.style.color = '#dc3545';
    } else if (count > 50000) {
        charCountEl.style.color = '#dc3545';
    } else {
        charCountEl.style.color = '#6c757d';
    }
}

function generatePreview() {
    const template = document.getElementById('promptTemplate').value;

    if (!template.trim()) {
        document.getElementById('previewOutput').textContent = 'Template is empty';
        return;
    }

    // Simple preview with placeholder values
    let preview = template;

    // Replace each field variable with sample value
    availableFields.forEach(field => {
        const varName = field.field_id.toUpperCase();
        const sampleValue = field.field_label || varName;
        const regex = new RegExp(`\\[${varName}\\]`, 'g');
        preview = preview.replace(regex, `**${sampleValue}**`);
    });

    // Replace ADDITIONAL_INSTRUCTIONS
    preview = preview.replace(/\[ADDITIONAL_INSTRUCTIONS\]/g, '**User custom instructions**');

    document.getElementById('previewOutput').textContent = preview;
}

function savePrompt() {
    const promptTemplate = document.getElementById('promptTemplate').value.trim();
    const changeSummary = document.getElementById('changeSummary').value.trim();

    // Validate
    if (!promptTemplate) {
        showValidationError('Prompt template cannot be empty');
        return;
    }

    if (promptTemplate.length < 50) {
        showValidationError('Prompt template must be at least 50 characters');
        return;
    }

    if (promptTemplate.length > 50000) {
        showValidationError('Prompt template must be 50,000 characters or less');
        return;
    }

    // Disable save button
    const saveButton = document.getElementById('saveButton');
    saveButton.disabled = true;
    saveButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

    // Prepare form data
    const formData = new FormData();
    formData.append('prompt_type_id', promptTypeId);
    formData.append('prompt_template', promptTemplate);
    formData.append('change_summary', changeSummary);
    formData.append('loaded_version', loadedVersion);

    // Save prompt
    fetch('api/update_prompt.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const newPromptId = data.data.prompt_id;

                // Save product assignments
                return saveProductAssignments(newPromptId).then(() => {
                    showSuccess('Prompt saved successfully! Version ' + data.data.version + ' created. Product assignments saved.');

                    // Reload prompt data
                    setTimeout(() => {
                        loadPromptData();
                        document.getElementById('changeSummary').value = '';
                    }, 1000);
                });
            } else if (data.conflict) {
                showValidationError('Conflict: ' + data.error);
            } else {
                showValidationError('Failed to save: ' + data.error);
            }
        })
        .catch(error => {
            showValidationError('Error saving prompt: ' + error.message);
        })
        .finally(() => {
            saveButton.disabled = false;
            saveButton.innerHTML = '<i class="fas fa-save"></i> Save New Version';
        });
}

function showValidationError(message) {
    const container = document.getElementById('validationMessages');
    container.innerHTML = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
        ${escapeHtml(message)}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>`;
}

function showSuccess(message) {
    const container = document.getElementById('validationMessages');
    container.innerHTML = `<div class="alert alert-success alert-dismissible fade show" role="alert">
        ${escapeHtml(message)}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>`;
}

function showError(message) {
    const container = document.getElementById('validationMessages');
    container.innerHTML = `<div class="alert alert-danger" role="alert">${escapeHtml(message)}</div>`;
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// ============================================================================
// PRODUCT MANAGEMENT FUNCTIONS
// ============================================================================

function loadProducts() {
    // Load all available products
    fetch('api/get_products.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                allProducts = data.data;
                renderProductList();

                // Load currently assigned products for active prompt
                if (currentPrompt && currentPrompt.id) {
                    loadPromptProducts(currentPrompt.id);
                }
            } else {
                document.getElementById('productList').innerHTML =
                    '<div class="text-danger">Failed to load products</div>';
            }
        })
        .catch(error => {
            console.error('Error loading products:', error);
            document.getElementById('productList').innerHTML =
                '<div class="text-danger">Error loading products</div>';
        });
}

function loadPromptProducts(promptId) {
    fetch(`api/prompt_products.php?prompt_id=${promptId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                selectedProducts = new Set(data.data);
                updateProductCheckboxes();
                renderSelectedTags();
                updateSelectedCount();
            }
        })
        .catch(error => {
            console.error('Error loading prompt products:', error);
        });
}

function renderProductList() {
    const container = document.getElementById('productList');
    container.innerHTML = '';

    if (allProducts.length === 0) {
        container.innerHTML = '<div class="text-muted">No products available</div>';
        return;
    }

    allProducts.forEach(product => {
        const label = document.createElement('label');
        label.className = 'product-checkbox';
        label.dataset.prodId = product.prod_id;
        label.dataset.prodName = product.prod_name;

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.value = product.prod_id;
        checkbox.checked = selectedProducts.has(product.prod_id);
        checkbox.addEventListener('change', function() {
            toggleProduct(product.prod_id, this.checked);
        });

        const text = document.createTextNode(`${product.prod_id} - ${product.prod_name}`);

        label.appendChild(checkbox);
        label.appendChild(text);
        container.appendChild(label);
    });
}

function updateProductCheckboxes() {
    const checkboxes = document.querySelectorAll('#productList input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectedProducts.has(checkbox.value);
    });
}

function filterProducts() {
    const searchTerm = document.getElementById('productSearch').value.toLowerCase();
    const labels = document.querySelectorAll('.product-checkbox');

    labels.forEach(label => {
        const prodId = label.dataset.prodId.toLowerCase();
        const prodName = label.dataset.prodName.toLowerCase();
        const matches = prodId.includes(searchTerm) || prodName.includes(searchTerm);

        label.classList.toggle('hidden', !matches);
    });
}

function toggleProduct(prodId, isSelected) {
    if (isSelected) {
        selectedProducts.add(prodId);
    } else {
        selectedProducts.delete(prodId);
    }

    renderSelectedTags();
    updateSelectedCount();
}

function selectAllProducts() {
    // Select all visible products (respecting search filter)
    const visibleCheckboxes = document.querySelectorAll('.product-checkbox:not(.hidden) input[type="checkbox"]');
    visibleCheckboxes.forEach(checkbox => {
        checkbox.checked = true;
        selectedProducts.add(checkbox.value);
    });

    renderSelectedTags();
    updateSelectedCount();
}

function clearAllProducts() {
    selectedProducts.clear();
    updateProductCheckboxes();
    renderSelectedTags();
    updateSelectedCount();
}

function renderSelectedTags() {
    const container = document.getElementById('selectedProducts');
    container.innerHTML = '';

    if (selectedProducts.size === 0) {
        container.innerHTML = '<small class="text-muted">No products selected</small>';
        return;
    }

    // Sort selected products
    const sorted = Array.from(selectedProducts).sort();

    sorted.forEach(prodId => {
        const product = allProducts.find(p => p.prod_id === prodId);
        if (!product) return;

        const tag = document.createElement('span');
        tag.className = 'selected-product-tag';
        tag.innerHTML = `${product.prod_id} <span class="remove-btn" onclick="removeProduct('${escapeHtml(prodId)}')">&times;</span>`;
        container.appendChild(tag);
    });
}

function removeProduct(prodId) {
    selectedProducts.delete(prodId);
    updateProductCheckboxes();
    renderSelectedTags();
    updateSelectedCount();
}

function updateSelectedCount() {
    document.getElementById('selectedCount').textContent = `${selectedProducts.size} selected`;
}

function saveProductAssignments(promptId) {
    const formData = new FormData();
    formData.append('prompt_id', promptId);

    // Add all selected prod_ids as array
    selectedProducts.forEach(prodId => {
        formData.append('prod_ids[]', prodId);
    });

    return fetch('api/prompt_products.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (!data.success) {
            throw new Error(data.error || 'Failed to save product assignments');
        }
        return data;
    });
}
</script>

<?php
include('../footer.php');
?>
