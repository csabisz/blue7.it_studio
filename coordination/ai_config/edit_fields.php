<?php
/**
 * Field Configuration Manager
 * Manage form fields and options for each product type
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

$page_title = "Manage Fields";

include('../../header2.php');
include('../../menu.php');

// Require includes
require_once __DIR__ . '/includes/config_functions.php';
?>

<!-- Include SortableJS for drag-and-drop -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

<style>
.field-list-item {
    background: white;
    border: 1px solid #dee2e6;
    padding: 12px;
    margin-bottom: 8px;
    border-radius: 4px;
    cursor: move;
    transition: all 0.2s;
}

.field-list-item:hover {
    border-color: #007bff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.field-list-item.active {
    border-color: #007bff;
    background-color: #e7f3ff;
}

.field-list-item .drag-handle {
    color: #6c757d;
    cursor: move;
    margin-right: 8px;
}

.field-badge {
    font-size: 11px;
    padding: 2px 6px;
}

.option-row {
    padding: 8px;
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    margin-bottom: 5px;
    border-radius: 3px;
    cursor: move;
}

.option-row:hover {
    background: #e9ecef;
}

.form-preview-box {
    background: #f8f9fa;
    border: 2px dashed #dee2e6;
    padding: 20px;
    border-radius: 4px;
    min-height: 200px;
}

.empty-state {
    text-align: center;
    color: #6c757d;
    padding: 40px;
}

.btn-xs {
    padding: 2px 8px;
    font-size: 12px;
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
                            <!-- Left Column: Field List -->
                            <div class="col-md-4">
                                <div class="card" style="width: 100%; height: auto;">
                                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Fields</h5>
                                        <button class="btn btn-sm btn-light" onclick="showAddFieldModal()">
                                            <i class="fas fa-plus"></i> Add Field
                                        </button>
                                    </div>
                                    <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                                        <div id="fieldsList">
                                            <div class="text-center">
                                                <div class="spinner-border text-primary" role="status"></div>
                                                <p class="text-muted mt-2">Loading fields...</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Field Editor & Options Manager -->
                            <div class="col-md-8">
                                <!-- Field Editor -->
                                <div class="card mb-3" id="fieldEditorCard" style="display: none; width: 100%; height: auto">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0">Edit Field</h5>
                                    </div>
                                    <div class="card-body">
                                        <form id="fieldEditorForm">
                                            <input type="hidden" id="editFieldId" name="field_config_id">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Field ID</label>
                                                        <input type="text" class="form-control" id="editFieldIdValue" readonly>
                                                        <small class="text-muted">Cannot be changed after creation</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Field Label *</label>
                                                        <input type="text" class="form-control" id="editFieldLabel" name="field_label" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Field Type *</label>
                                                        <select class="form-control" id="editFieldType" name="field_type" onchange="toggleOptionsManager()">
                                                            <option value="select">Select (Dropdown)</option>
                                                            <option value="textarea">Textarea</option>
                                                            <option value="checkbox">Checkbox</option>
                                                            <option value="text">Text Input</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>&nbsp;</label>
                                                        <div class="custom-control custom-checkbox mt-2">
                                                            <input type="checkbox" class="custom-control-input" id="editFieldRequired" name="is_required" value="1">
                                                            <label class="custom-control-label" for="editFieldRequired">Required Field</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Placeholder</label>
                                                <input type="text" class="form-control" id="editFieldPlaceholder" name="placeholder">
                                            </div>

                                            <div class="form-group">
                                                <label>Help Text</label>
                                                <textarea class="form-control" id="editFieldHelpText" name="help_text" rows="2"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label>Default Value</label>
                                                <input type="text" class="form-control" id="editFieldDefault" name="default_value">
                                            </div>

                                            <div id="validationMessages"></div>

                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save"></i> Save Field
                                            </button>
                                            <button type="button" class="btn btn-danger" onclick="deleteField()">
                                                <i class="fas fa-trash"></i> Delete Field
                                            </button>
                                            <button type="button" class="btn btn-secondary" onclick="clearFieldEditor()">
                                                Cancel
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <!-- Options Manager (for select fields) -->
                                <div class="card mb-3" id="optionsManagerCard" style="display: none; width: 100%; height: auto;">
                                    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">Dropdown Options</h5>
                                        <button class="btn btn-sm btn-light" onclick="showAddOptionModal()">
                                            <i class="fas fa-plus"></i> Add Option
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="optionsList">
                                            <p class="text-muted">No options yet. Click "Add Option" to create one.</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Form Preview -->
                                <div class="card" style="width: 100%; height: auto;"">
                                    <div class="card-header bg-secondary text-white">
                                        <h5 class="mb-0">Form Preview</h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="formPreview" class="form-preview-box">
                                            <div class="empty-state">
                                                <i class="fas fa-eye fa-3x mb-3 text-muted"></i>
                                                <p>Preview of how fields will appear in the AI image modal</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <a href="index.php" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                                    </a>
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

<!-- Add Field Modal -->
<div class="modal fade" id="addFieldModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add New Field</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addFieldForm">
                    <div class="form-group">
                        <label>Field ID *</label>
                        <input type="text" class="form-control" id="newFieldId" name="field_id" required pattern="[a-z0-9_]+" placeholder="e.g., room_type">
                        <small class="text-muted">Lowercase letters, numbers, and underscores only</small>
                    </div>

                    <div class="form-group">
                        <label>Field Label *</label>
                        <input type="text" class="form-control" id="newFieldLabel" name="field_label" required placeholder="e.g., Room Type">
                    </div>

                    <div class="form-group">
                        <label>Field Type *</label>
                        <select class="form-control" id="newFieldType" name="field_type" required>
                            <option value="select">Select (Dropdown)</option>
                            <option value="textarea">Textarea</option>
                            <option value="checkbox">Checkbox</option>
                            <option value="text">Text Input</option>
                        </select>
                    </div>

                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="newFieldRequired" name="is_required" value="1">
                        <label class="custom-control-label" for="newFieldRequired">Required Field</label>
                    </div>

                    <div id="addFieldMessages"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addField()">
                    <i class="fas fa-plus"></i> Add Field
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Add Option Modal -->
<div class="modal fade" id="addOptionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Dropdown Option</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="addOptionForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Option Value *</label>
                                <input type="text" class="form-control" id="newOptionValue" name="option_value" required pattern="[a-z0-9_-]+" placeholder="e.g., living-room">
                                <small class="text-muted">Lowercase, numbers, hyphens, underscores</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Option Label *</label>
                                <input type="text" class="form-control" id="newOptionLabel" name="option_label" required placeholder="e.g., Living Room">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Prompt Text (Optional)</label>
                        <textarea class="form-control" id="newOptionPrompt" name="prompt_text" rows="3" placeholder="Optional style-specific prompt text..."></textarea>
                    </div>

                    <div class="form-group">
                        <label>Room Restrictions (Optional)</label>
                        <input type="text" class="form-control" id="newOptionRooms" name="room_restrictions" placeholder="e.g., living-room,bedroom,kitchen">
                        <small class="text-muted">Comma-separated room types this option applies to</small>
                    </div>

                    <div id="addOptionMessages"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="addOption()">
                    <i class="fas fa-plus"></i> Add Option
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Option Modal -->
<div class="modal fade" id="editOptionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Option</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="editOptionForm">
                    <input type="hidden" id="editOptionId" name="option_id">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Option Value *</label>
                                <input type="text" class="form-control" id="editOptionValue" name="option_value" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Option Label *</label>
                                <input type="text" class="form-control" id="editOptionLabel" name="option_label" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Prompt Text (Optional)</label>
                        <textarea class="form-control" id="editOptionPrompt" name="prompt_text" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Room Restrictions (Optional)</label>
                        <input type="text" class="form-control" id="editOptionRooms" name="room_restrictions">
                    </div>

                    <div id="editOptionMessages"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="updateOption()">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>

<script>
let currentProductType = null;
let currentProductTypeId = null;
let allFields = [];
let selectedFieldId = null;
let fieldsSortable = null;
let optionsSortable = null;

const promptTypeId = <?php echo intval($prompt_type_id); ?>;

// Load on page load
document.addEventListener('DOMContentLoaded', function() {
    if (promptTypeId) {
        currentProductTypeId = promptTypeId;
        loadProductTypeAndFields();
    }

    // Form submit handlers
    document.getElementById('fieldEditorForm').addEventListener('submit', function(e) {
        e.preventDefault();
        updateField();
    });
});

function loadProductTypeAndFields() {
    // Load fields (which includes type name)
    loadFields();
}

function loadFields() {
    fetch(`api/get_fields.php?id=${promptTypeId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                allFields = data.data;

                // Update breadcrumb with type name from API response
                if (data.type_name) {
                    document.getElementById('productTypeName').textContent = data.type_name;
                }

                renderFieldsList();
                updateFormPreview();
            } else {
                showError('Failed to load fields: ' + data.error);
            }
        })
        .catch(error => {
            showError('Error loading fields: ' + error.message);
        });
}

function renderFieldsList() {
    const container = document.getElementById('fieldsList');

    if (allFields.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-list fa-2x mb-2"></i><p>No fields yet. Click "Add Field" to create one.</p></div>';
        return;
    }

    container.innerHTML = '';

    allFields.forEach(field => {
        const item = document.createElement('div');
        item.className = 'field-list-item';
        item.dataset.fieldId = field.id;
        if (selectedFieldId === field.id) {
            item.classList.add('active');
        }

        item.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-grip-vertical drag-handle"></i>
                    <strong>${escapeHtml(field.field_label)}</strong>
                    <span class="badge badge-secondary field-badge ml-2">${field.field_type}</span>
                    ${field.is_required ? '<span class="badge badge-danger field-badge">Required</span>' : ''}
                </div>
                <button class="btn btn-sm btn-primary btn-xs" onclick="selectField(${field.id})">
                    <i class="fas fa-edit"></i>
                </button>
            </div>
            <small class="text-muted d-block mt-1">${field.field_id}</small>
        `;

        container.appendChild(item);
    });

    // Initialize drag-and-drop
    if (fieldsSortable) {
        fieldsSortable.destroy();
    }
    fieldsSortable = Sortable.create(container, {
        animation: 150,
        handle: '.drag-handle',
        onEnd: function(evt) {
            reorderFields();
        }
    });
}

function selectField(fieldId) {
    selectedFieldId = fieldId;
    const field = allFields.find(f => f.id === fieldId);

    if (!field) return;

    // Update field list highlighting
    document.querySelectorAll('.field-list-item').forEach(item => {
        item.classList.remove('active');
        if (parseInt(item.dataset.fieldId) === fieldId) {
            item.classList.add('active');
        }
    });

    // Populate field editor
    document.getElementById('editFieldId').value = field.id;
    document.getElementById('editFieldIdValue').value = field.field_id;
    document.getElementById('editFieldLabel').value = field.field_label;
    document.getElementById('editFieldType').value = field.field_type;
    document.getElementById('editFieldRequired').checked = field.is_required;
    document.getElementById('editFieldPlaceholder').value = field.placeholder || '';
    document.getElementById('editFieldHelpText').value = field.help_text || '';
    document.getElementById('editFieldDefault').value = field.default_value || '';

    // Show editor
    document.getElementById('fieldEditorCard').style.display = 'block';

    // Show options manager if select type
    toggleOptionsManager();

    // Load options if select type
    if (field.field_type === 'select') {
        renderOptions(field.options || []);
    }
}

function toggleOptionsManager() {
    const fieldType = document.getElementById('editFieldType').value;
    const optionsCard = document.getElementById('optionsManagerCard');

    if (fieldType === 'select') {
        optionsCard.style.display = 'block';
        // Reload options if a field is selected
        if (selectedFieldId) {
            const field = allFields.find(f => f.id === selectedFieldId);
            if (field && field.options) {
                renderOptions(field.options);
            }
        }
    } else {
        optionsCard.style.display = 'none';
    }
}

function renderOptions(options) {
    const container = document.getElementById('optionsList');

    if (options.length === 0) {
        container.innerHTML = '<p class="text-muted">No options yet. Click "Add Option" to create one.</p>';
        return;
    }

    container.innerHTML = '';

    options.forEach(option => {
        const row = document.createElement('div');
        row.className = 'option-row';
        row.dataset.optionId = option.id;

        row.innerHTML = `
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-grip-vertical text-muted mr-2"></i>
                    <strong>${escapeHtml(option.option_label)}</strong>
                    <span class="badge badge-light ml-2">${escapeHtml(option.option_value)}</span>
                </div>
                <div>
                    <button class="btn btn-sm btn-info btn-xs" onclick="showEditOptionModal(${option.id})">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-xs" onclick="deleteOption(${option.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;

        container.appendChild(row);
    });

    // Initialize drag-and-drop for options
    if (optionsSortable) {
        optionsSortable.destroy();
    }
    optionsSortable = Sortable.create(container, {
        animation: 150,
        onEnd: function(evt) {
            reorderOptions();
        }
    });
}

function updateFormPreview() {
    const container = document.getElementById('formPreview');

    if (allFields.length === 0) {
        container.innerHTML = '<div class="empty-state"><i class="fas fa-eye fa-3x mb-3 text-muted"></i><p>Preview of how fields will appear in the AI image modal</p></div>';
        return;
    }

    container.innerHTML = '';

    allFields.forEach(field => {
        const formGroup = document.createElement('div');
        formGroup.className = 'form-group';

        let fieldHtml = `<label>${escapeHtml(field.field_label)}${field.is_required ? ' <span class="text-danger">*</span>' : ''}</label>`;

        if (field.field_type === 'select') {
            fieldHtml += `<select class="form-control" disabled>`;
            fieldHtml += `<option value="">Select ${escapeHtml(field.field_label)}</option>`;
            if (field.options) {
                field.options.forEach(opt => {
                    fieldHtml += `<option value="${escapeHtml(opt.option_value)}">${escapeHtml(opt.option_label)}</option>`;
                });
            }
            fieldHtml += `</select>`;
        } else if (field.field_type === 'textarea') {
            fieldHtml += `<textarea class="form-control" rows="3" placeholder="${escapeHtml(field.placeholder || '')}" disabled></textarea>`;
        } else if (field.field_type === 'checkbox') {
            fieldHtml += `<div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" disabled><label class="custom-control-label">${escapeHtml(field.field_label)}</label></div>`;
        } else {
            fieldHtml += `<input type="text" class="form-control" placeholder="${escapeHtml(field.placeholder || '')}" disabled>`;
        }

        if (field.help_text) {
            fieldHtml += `<small class="form-text text-muted">${escapeHtml(field.help_text)}</small>`;
        }

        formGroup.innerHTML = fieldHtml;
        container.appendChild(formGroup);
    });
}

function clearFieldEditor() {
    selectedFieldId = null;
    document.getElementById('fieldEditorCard').style.display = 'none';
    document.getElementById('optionsManagerCard').style.display = 'none';
    document.querySelectorAll('.field-list-item').forEach(item => {
        item.classList.remove('active');
    });
}

// Continue in next part due to length...
</script>

<script>
// Field CRUD Operations

function showAddFieldModal() {
    document.getElementById('addFieldForm').reset();
    document.getElementById('addFieldMessages').innerHTML = '';
    $('#addFieldModal').modal('show');
}

function addField() {
    const formData = new FormData(document.getElementById('addFieldForm'));
    formData.append('prompt_type_id', currentProductTypeId);

    // Disable button
    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';

    fetch('api/add_field.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#addFieldModal').modal('hide');
            loadFields();
            showSuccess('Field added successfully!');
        } else {
            document.getElementById('addFieldMessages').innerHTML = `<div class="alert alert-danger">${escapeHtml(data.error)}</div>`;
        }
    })
    .catch(error => {
        document.getElementById('addFieldMessages').innerHTML = `<div class="alert alert-danger">Error: ${escapeHtml(error.message)}</div>`;
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-plus"></i> Add Field';
    });
}

function updateField() {
    const formData = new FormData(document.getElementById('fieldEditorForm'));

    fetch('api/update_field.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadFields();
            showSuccess('Field updated successfully!');
        } else {
            document.getElementById('validationMessages').innerHTML = `<div class="alert alert-danger">${escapeHtml(data.error)}</div>`;
        }
    })
    .catch(error => {
        document.getElementById('validationMessages').innerHTML = `<div class="alert alert-danger">Error: ${escapeHtml(error.message)}</div>`;
    });
}

function deleteField() {
    if (!confirm('Are you sure you want to delete this field? This action cannot be undone.')) {
        return;
    }

    const formData = new FormData();
    formData.append('field_config_id', selectedFieldId);

    fetch('api/delete_field.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            clearFieldEditor();
            loadFields();
            showSuccess('Field deleted successfully!');
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}

function reorderFields() {
    const fieldIds = [];
    document.querySelectorAll('.field-list-item').forEach(item => {
        fieldIds.push(item.dataset.fieldId);
    });

    const formData = new FormData();
    formData.append('field_ids', JSON.stringify(fieldIds));
    formData.append('prompt_type_id', currentProductTypeId);

    fetch('api/reorder_fields.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadFields(); // Reload to get updated order
        } else {
            alert('Error reordering fields: ' + data.error);
        }
    });
}

// Option CRUD Operations

function showAddOptionModal() {
    if (!selectedFieldId) {
        alert('Please select a field first');
        return;
    }

    document.getElementById('addOptionForm').reset();
    document.getElementById('addOptionMessages').innerHTML = '';
    $('#addOptionModal').modal('show');
}

function addOption() {
    const formData = new FormData(document.getElementById('addOptionForm'));
    formData.append('field_config_id', selectedFieldId);

    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';

    fetch('api/add_option.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#addOptionModal').modal('hide');
            loadFields();
            showSuccess('Option added successfully!');
        } else {
            document.getElementById('addOptionMessages').innerHTML = `<div class="alert alert-danger">${escapeHtml(data.error)}</div>`;
        }
    })
    .catch(error => {
        document.getElementById('addOptionMessages').innerHTML = `<div class="alert alert-danger">Error: ${escapeHtml(error.message)}</div>`;
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-plus"></i> Add Option';
    });
}

function showEditOptionModal(optionId) {
    const field = allFields.find(f => f.id === selectedFieldId);
    const option = field.options.find(o => o.id === optionId);

    if (!option) return;

    document.getElementById('editOptionId').value = option.id;
    document.getElementById('editOptionValue').value = option.option_value;
    document.getElementById('editOptionLabel').value = option.option_label;
    document.getElementById('editOptionPrompt').value = option.prompt_text || '';
    document.getElementById('editOptionRooms').value = option.room_restrictions || '';
    document.getElementById('editOptionMessages').innerHTML = '';

    $('#editOptionModal').modal('show');
}

function updateOption() {
    const formData = new FormData(document.getElementById('editOptionForm'));

    const btn = event.target;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';

    fetch('api/update_option.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#editOptionModal').modal('hide');
            loadFields();
            showSuccess('Option updated successfully!');
        } else {
            document.getElementById('editOptionMessages').innerHTML = `<div class="alert alert-danger">${escapeHtml(data.error)}</div>`;
        }
    })
    .catch(error => {
        document.getElementById('editOptionMessages').innerHTML = `<div class="alert alert-danger">Error: ${escapeHtml(error.message)}</div>`;
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-save"></i> Save Changes';
    });
}

function deleteOption(optionId) {
    if (!confirm('Are you sure you want to delete this option?')) {
        return;
    }

    const formData = new FormData();
    formData.append('option_id', optionId);

    fetch('api/delete_option.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadFields();
            showSuccess('Option deleted successfully!');
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}

function reorderOptions() {
    const optionIds = [];
    document.querySelectorAll('.option-row').forEach(row => {
        optionIds.push(row.dataset.optionId);
    });

    const formData = new FormData();
    formData.append('option_ids', JSON.stringify(optionIds));
    formData.append('field_config_id', selectedFieldId);

    fetch('api/reorder_options.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadFields(); // Reload to get updated order
        } else {
            alert('Error reordering options: ' + data.error);
        }
    });
}

// Utility Functions

function showSuccess(message) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-success alert-dismissible fade show';
    alert.innerHTML = `${escapeHtml(message)}<button type="button" class="close" data-dismiss="alert">&times;</button>`;
    document.querySelector('.container-fluid').insertBefore(alert, document.querySelector('.row'));
    setTimeout(() => alert.remove(), 5000);
}

function showError(message) {
    document.getElementById('fieldsList').innerHTML = `<div class="alert alert-danger">${escapeHtml(message)}</div>`;
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>

<?php
include('../../footer.php');
?>
