<?php
/**
 * AI Config Admin Dashboard
 * Main page listing all product types with quick actions
 *
 * @package Blue7
 * @subpackage AI Config
 */

session_start();
include('../../functions.php');

$prod = new Production;
$_COOKIE['start'] = gmdate("Y-m-d H:i:s");

$page_title = "AI Configuration Management";

include('../../header2.php');
include('../../menu.php');

// Require includes
require_once __DIR__ . '/includes/config_functions.php';
?>

<section class="top_section">
    <article>
        <div class="container-fluid bg-white">

            <?php
            // Authorization check
            if (isset($_COOKIE['client_id']) && ($_COOKIE['start'] < $_COOKIE['expire'])) {

                if ($_COOKIE['coordination'] > 0) {
            ?>

                    <div class="row">
                        <div class="col-12">
                            <h2 class="mt-4 mb-4">AI Configuration Management</h2>
                            <p class="text-muted">Manage base prompts and field configurations for AI image generation.</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card" style="width: 100%; height: auto;">
                                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Product Types</h5>
                                    <button class="btn btn-light btn-sm" onclick="showCreatePromptTypeModal()">
                                        <i class="fas fa-plus"></i> Create New Prompt Type
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="productTypesTable">
                                            <thead>
                                                <tr>
                                                    <th>Product Type</th>
                                                    <th>Description</th>
                                                    <th>Fields</th>
                                                    <th>Last Updated</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Loaded via JavaScript -->
                                                <tr>
                                                    <td colspan="5" class="text-center">
                                                        <div class="spinner-border text-primary" role="status">
                                                            <span class="sr-only">Loading...</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

            <?php
                } else {
                    echo '<div class="alert alert-danger mt-4">You do not have permission to access this page. Coordination permission required.</div>';
                }
            } else {
                echo '<div class="alert alert-warning mt-4">Please log in to continue.</div>';
            }
            ?>

        </div>
    </article>
</section>

<script>
// Load product types on page load
document.addEventListener('DOMContentLoaded', function() {
    loadProductTypes();
});

function loadProductTypes() {
    fetch('api/product_types.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderProductTypes(data.data);
            } else {
                showError('Failed to load product types: ' + data.error);
            }
        })
        .catch(error => {
            showError('Error loading product types: ' + error.message);
        });
}

function renderProductTypes(types) {
    const tbody = document.querySelector('#productTypesTable tbody');

    if (types.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="text-center">No product types found</td></tr>';
        return;
    }

    tbody.innerHTML = '';

    types.forEach(type => {
        const row = document.createElement('tr');

        // Name
        const nameCell = document.createElement('td');
        nameCell.innerHTML = '<strong>' + escapeHtml(type.name) + '</strong><br><small class="text-muted">' + escapeHtml(type.type_key) + '</small>';
        row.appendChild(nameCell);

        // Description
        const descCell = document.createElement('td');
        descCell.textContent = type.description || '-';
        row.appendChild(descCell);

        // Field count
        const fieldsCell = document.createElement('td');
        fieldsCell.innerHTML = '<span class="badge badge-info">' + (type.field_count || 0) + ' fields</span>';
        row.appendChild(fieldsCell);

        // Last updated
        const updatedCell = document.createElement('td');
        const updatedDate = new Date(type.updated_at);
        updatedCell.innerHTML = '<small>' + updatedDate.toLocaleDateString() + '<br>' + updatedDate.toLocaleTimeString() + '</small>';
        row.appendChild(updatedCell);

        // Actions
        const actionsCell = document.createElement('td');
        actionsCell.innerHTML = `
            <div class="btn-group btn-group-sm" role="group">
                <a href="edit_base_prompt.php?id=${type.id}" class="btn btn-primary" title="Edit Base Prompt">
                    <i class="fas fa-edit"></i> Prompt
                </a>
                <a href="edit_fields.php?id=${type.id}" class="btn btn-success" title="Manage Fields">
                    <i class="fas fa-list"></i> Fields
                </a>
                <a href="view_history.php?id=${type.id}" class="btn btn-info" title="View History">
                    <i class="fas fa-history"></i> History
                </a>
            </div>
        `;
        row.appendChild(actionsCell);

        tbody.appendChild(row);
    });
}

function showError(message) {
    const tbody = document.querySelector('#productTypesTable tbody');
    tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">' + escapeHtml(message) + '</td></tr>';
}

// ============================================================================
// PROMPT TYPE CREATION FUNCTIONS
// ============================================================================

let typeKeyCheckTimeout = null;

function showCreatePromptTypeModal() {
    document.getElementById('createPromptTypeForm').reset();
    document.getElementById('createPromptTypeMessages').innerHTML = '';
    document.getElementById('typeKeyValidation').innerHTML = '';
    document.getElementById('createPromptTypeBtn').disabled = false;
    $('#createPromptTypeModal').modal('show');

    // Focus on name field
    setTimeout(() => {
        document.getElementById('promptTypeName').focus();
    }, 500);
}

function generateTypeKey(name) {
    return name
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '_')  // Replace non-alphanumeric with underscore
        .replace(/^_+|_+$/g, '')       // Remove leading/trailing underscores
        .replace(/_+/g, '_')           // Collapse multiple underscores
        .substring(0, 50);             // Limit length
}

function checkTypeKeyUniqueness(typeKey) {
    const validationDiv = document.getElementById('typeKeyValidation');
    const createBtn = document.getElementById('createPromptTypeBtn');

    fetch('api/product_types.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const exists = data.data.some(type => type.type_key === typeKey);

                if (exists) {
                    validationDiv.innerHTML = '<small class="text-danger"><i class="fas fa-times-circle"></i> This type key already exists</small>';
                    createBtn.disabled = true;
                } else {
                    validationDiv.innerHTML = '<small class="text-success"><i class="fas fa-check-circle"></i> Type key is available</small>';
                    createBtn.disabled = false;
                }
            }
        })
        .catch(error => {
            console.error('Error checking uniqueness:', error);
            validationDiv.innerHTML = '';
            createBtn.disabled = false;
        });
}

function createPromptType() {
    const form = document.getElementById('createPromptTypeForm');
    const formData = new FormData(form);
    const messagesDiv = document.getElementById('createPromptTypeMessages');
    const createBtn = document.getElementById('createPromptTypeBtn');

    // Client-side validation
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    // Disable button
    createBtn.disabled = true;
    createBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creating...';

    fetch('api/create_prompt_type.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            $('#createPromptTypeModal').modal('hide');

            // Show success message
            const tableBody = document.querySelector('#productTypesTable tbody');
            tableBody.insertAdjacentHTML('afterbegin', `
                <tr>
                    <td colspan="5" class="text-center">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Prompt type "${escapeHtml(formData.get('name'))}" created.
                            Redirecting to prompt editor...
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    </td>
                </tr>
            `);

            // Redirect to edit prompt page
            setTimeout(() => {
                window.location.href = `edit_base_prompt.php?id=${data.data.id}`;
            }, 1500);
        } else {
            // Show error
            let errorMsg = data.error;
            if (data.validation_errors) {
                errorMsg = Object.values(data.validation_errors).join('<br>');
            }
            messagesDiv.innerHTML = `<div class="alert alert-danger">${escapeHtml(errorMsg)}</div>`;
        }
    })
    .catch(error => {
        messagesDiv.innerHTML = `<div class="alert alert-danger">Error: ${escapeHtml(error.message)}</div>`;
    })
    .finally(() => {
        createBtn.disabled = false;
        createBtn.innerHTML = '<i class="fas fa-plus"></i> Create Prompt Type';
    });
}

// Auto-generate type key from name
document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('promptTypeName');
    const keyInput = document.getElementById('promptTypeKey');
    const baseKeyInput = document.getElementById('basePromptKey');

    if (nameInput && keyInput) {
        nameInput.addEventListener('input', function() {
            // Only auto-generate if key field is empty or was auto-generated
            const currentKey = keyInput.value;
            if (!currentKey || keyInput.dataset.autoGenerated === 'true') {
                const generatedKey = generateTypeKey(this.value);
                keyInput.value = generatedKey;
                keyInput.dataset.autoGenerated = 'true';

                // Also update base_prompt_key
                baseKeyInput.value = generatedKey;

                // Check uniqueness
                if (generatedKey) {
                    checkTypeKeyUniqueness(generatedKey);
                }
            }
        });

        // Mark as manually edited if user changes it
        keyInput.addEventListener('input', function() {
            if (this.value !== generateTypeKey(nameInput.value)) {
                this.dataset.autoGenerated = 'false';
            }

            // Also update base_prompt_key to match
            baseKeyInput.value = this.value;

            // Check uniqueness with debounce
            clearTimeout(typeKeyCheckTimeout);
            if (this.value) {
                typeKeyCheckTimeout = setTimeout(() => {
                    checkTypeKeyUniqueness(this.value);
                }, 500);
            } else {
                document.getElementById('typeKeyValidation').innerHTML = '';
            }
        });
    }
});

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>

<!-- Create Prompt Type Modal -->
<div class="modal fade" id="createPromptTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Prompt Type</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="createPromptTypeForm">
                    <div class="form-group">
                        <label for="promptTypeName">Name *</label>
                        <input type="text" class="form-control" id="promptTypeName" name="name"
                               required maxlength="100" placeholder="e.g., Product Render">
                        <small class="text-muted">Display name for this prompt type</small>
                    </div>

                    <div class="form-group">
                        <label for="promptTypeKey">Type Key *</label>
                        <input type="text" class="form-control" id="promptTypeKey" name="type_key"
                               required pattern="[a-z0-9_]+" maxlength="50"
                               placeholder="e.g., product_render">
                        <small class="text-muted">Unique identifier (auto-generated from name, lowercase and underscores only)</small>
                        <div id="typeKeyValidation" class="mt-1"></div>
                    </div>

                    <div class="form-group">
                        <label for="promptTypeDescription">Description</label>
                        <textarea class="form-control" id="promptTypeDescription" name="description"
                                  rows="3" maxlength="500"
                                  placeholder="Brief description of this prompt type..."></textarea>
                    </div>

                    <div class="form-group">
                        <label for="basePromptKey">Base Prompt Key</label>
                        <input type="text" class="form-control" id="basePromptKey" name="base_prompt_key"
                               pattern="[a-z0-9_]+" maxlength="50"
                               placeholder="Auto-filled from type key">
                        <small class="text-muted">Usually same as type key (auto-filled)</small>
                    </div>

                    <div id="createPromptTypeMessages"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="createPromptTypeBtn" onclick="createPromptType()">
                    <i class="fas fa-plus"></i> Create Prompt Type
                </button>
            </div>
        </div>
    </div>
</div>

<?php
include('../footer.php');
?>
