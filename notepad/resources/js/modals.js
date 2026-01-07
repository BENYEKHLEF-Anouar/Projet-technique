/**
 * Admin Notes Modal Management
 * Vanilla JavaScript for handling create, edit, and view modals with AJAX submissions
 */

// ============================================================================
// MODAL UTILITIES
// ============================================================================

/**
 * Show a success message toast
 */
function showSuccessMessage(message) {
    // Find existing success alerts or create container
    const existingAlert = document.querySelector('.success-toast');
    if (existingAlert) {
        existingAlert.remove();
    }

    const alert = document.createElement('div');
    alert.className = 'success-toast fixed top-4 right-4 z-50 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg shadow-lg flex items-center gap-3 animate-slide-in';
    alert.innerHTML = `
        <i data-lucide="check-circle" class="w-5 h-5"></i>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-2 text-green-700 hover:text-green-900">
            <i data-lucide="x" class="w-4 h-4"></i>
        </button>
    `;
    document.body.appendChild(alert);

    // Refresh icons for the new elements
    if (window.refreshIcons) window.refreshIcons();

    // Auto-remove after 5 seconds
    setTimeout(() => alert.remove(), 5000);
}

/**
 * Display form validation errors
 */
function displayFormErrors(errors) {
    const errorContainer = document.getElementById('form-errors');
    const errorMessages = document.getElementById('error-messages');

    if (!errorContainer || !errorMessages) return;

    // Build general error list
    let errorHtml = '<ul class="list-disc list-inside">';

    // Clear any previous field errors and borders
    clearFormErrors();

    Object.entries(errors).forEach(([field, messages]) => {
        // Add to general list
        messages.forEach(message => {
            errorHtml += `<li>${message}</li>`;
        });

        // Show field-specific error
        const errorElement = document.getElementById(`error-${field}`);
        if (errorElement) {
            errorElement.textContent = messages[0];
            errorElement.classList.remove('hidden');
        }

        // Highlight input with red border
        const inputElement = document.getElementById(`note-${field}`) || document.getElementsByName(field)[0] || document.getElementsByName(`${field}[]`)[0];
        if (inputElement) {
            // For checkboxes, we might want to highlight the container instead
            if (field === 'category_ids') {
                const container = document.getElementById('categories-container');
                if (container) container.classList.add('border-red-300', 'bg-red-50');
            } else {
                inputElement.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
                inputElement.classList.remove('border-gray-200');
            }
        }
    });

    errorHtml += '</ul>';

    errorMessages.innerHTML = errorHtml;
    errorContainer.classList.remove('hidden');

    // Refresh icons
    if (window.refreshIcons) window.refreshIcons();
}

/**
 * Clear form errors
 */
function clearFormErrors() {
    // Hide general error container
    const errorContainer = document.getElementById('form-errors');
    if (errorContainer) {
        errorContainer.classList.add('hidden');
    }

    // Clear all field-specific errors
    document.querySelectorAll('[id^="error-"]').forEach(el => {
        el.textContent = '';
        el.classList.add('hidden');
    });

    // Remove red borders from inputs
    document.querySelectorAll('#note-form input, #note-form textarea').forEach(el => {
        el.classList.remove('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
        if (!el.classList.contains('hidden')) {
            el.classList.add('border-gray-200');
        }
    });

    // Remove red border from categories container specifically
    const categoriesContainer = document.getElementById('categories-container');
    if (categoriesContainer) {
        categoriesContainer.classList.remove('border-red-300', 'bg-red-50');
    }
}

// ============================================================================
// IMAGE PREVIEW HANDLING
// ============================================================================

/**
 * Handle image preview when user selects a file
 */
window.handleImagePreview = function (input) {
    const file = input.files[0];
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');

    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();

        reader.onload = function (e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');

            // Refresh icons after showing preview
            if (window.refreshIcons) window.refreshIcons();
        };

        reader.readAsDataURL(file);
    } else {
        clearImagePreview();
    }
};

/**
 * Clear image preview
 */
window.clearImagePreview = function () {
    const input = document.getElementById('note-image');
    const previewContainer = document.getElementById('image-preview-container');
    const previewImage = document.getElementById('image-preview');

    if (input) input.value = '';
    if (previewImage) previewImage.src = '';
    if (previewContainer) previewContainer.classList.add('hidden');

    // Refresh icons
    if (window.refreshIcons) window.refreshIcons();
};

// ============================================================================
// FORM MODAL (CREATE & EDIT)
// ============================================================================

/**
 * Open create note modal
 */
window.openCreateModal = function () {
    const modal = document.getElementById('form-note-modal');
    const form = document.getElementById('note-form');
    const title = document.getElementById('modal-title');
    const submitBtn = document.getElementById('submit-btn');

    // Reset form
    form.reset();
    document.getElementById('note-id').value = '';
    document.getElementById('form-method').value = 'POST';

    // Clear any existing errors
    clearFormErrors();

    // Hide current and preview images
    document.getElementById('current-image-container').classList.add('hidden');
    clearImagePreview();

    // Uncheck all categories
    document.querySelectorAll('input[name="category_ids[]"]').forEach(cb => cb.checked = false);

    // Update UI
    title.textContent = 'Create New Note';
    submitBtn.textContent = 'Create Note';

    // Show modal
    modal.classList.remove('hidden');

    // Refresh icons
    if (window.refreshIcons) window.refreshIcons();
};

/**
 * Open edit note modal
 */
window.openEditModal = async function (noteId) {
    const modal = document.getElementById('form-note-modal');
    const form = document.getElementById('note-form');
    const title = document.getElementById('modal-title');
    const submitBtn = document.getElementById('submit-btn');

    try {
        // Fetch note data
        const response = await fetch(`/admin/notes/${noteId}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Failed to fetch note');

        const data = await response.json();
        const note = data.note;

        // Reset form and errors
        form.reset();
        clearFormErrors();
        clearImagePreview();

        // Set form data
        document.getElementById('note-id').value = note.id;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('note-name').value = note.name || '';
        document.getElementById('note-content').value = note.content || '';

        // Set categories
        document.querySelectorAll('input[name="category_ids[]"]').forEach(cb => {
            cb.checked = note.categories.some(cat => cat.id == cb.value);
        });

        // Show current image if exists
        const currentImageContainer = document.getElementById('current-image-container');
        const currentImage = document.getElementById('current-image');
        if (note.image) {
            currentImage.src = `/storage/${note.image}`;
            currentImageContainer.classList.remove('hidden');
        } else {
            currentImageContainer.classList.add('hidden');
        }

        // Update UI
        title.textContent = 'Edit Note';
        submitBtn.textContent = 'Update Note';

        // Show modal
        modal.classList.remove('hidden');

        // Refresh icons
        if (window.refreshIcons) window.refreshIcons();

    } catch (error) {
        console.error('Error loading note:', error);
        alert('Error loading note details. Please try again.');
    }
};

/**
 * Close form modal
 */
window.closeFormModal = function () {
    const modal = document.getElementById('form-note-modal');
    modal.classList.add('hidden');

    // Reset form
    document.getElementById('note-form').reset();
    clearFormErrors();
    clearImagePreview();
};

/**
 * Handle form submission via AJAX
 */
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('note-form');

    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const noteId = document.getElementById('note-id').value;
            const method = document.getElementById('form-method').value;
            const submitBtn = document.getElementById('submit-btn');

            // Determine URL and method
            const url = noteId ? `/admin/notes/${noteId}` : '/admin/notes';

            // Prepare form data
            const formData = new FormData(form);

            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (csrfToken) {
                formData.append('_token', csrfToken);
            }

            // Disable submit button
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></span>Saving...';

            // Clear previous errors
            clearFormErrors();

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // Success - close modal and refresh table
                    closeFormModal();
                    showSuccessMessage(data.message);

                    // Reload the page to refresh the table (simple approach)
                    setTimeout(() => {
                        window.location.reload();
                    }, 500);
                } else {
                    // Validation errors
                    if (data.errors) {
                        displayFormErrors(data.errors);
                    } else {
                        alert(data.message || 'An error occurred. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('An error occurred while saving the note. Please try again.');
            } finally {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = noteId ? 'Update Note' : 'Create Note';
            }
        });
    }
});

// ============================================================================
// VIEW MODAL
// ============================================================================

/**
 * Open view note modal
 */
window.openViewModal = async function (noteId) {
    const modal = document.getElementById('view-note-modal');
    const content = document.getElementById('view-note-content');

    // Show modal with loading state
    modal.classList.remove('hidden');
    content.innerHTML = `
        <div class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
            <p class="text-gray-600 mt-2">Loading...</p>
        </div>
    `;

    try {
        // Fetch note data
        const response = await fetch(`/admin/notes/${noteId}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Failed to fetch note');

        const data = await response.json();
        const note = data.note;

        // Build categories HTML
        let categoriesHtml = '';
        if (note.categories && note.categories.length > 0) {
            categoriesHtml = note.categories.map(cat =>
                `<span class="px-3 py-1 text-sm rounded-full bg-indigo-50 text-indigo-600 border border-indigo-100">${cat.name}</span>`
            ).join('');
        } else {
            categoriesHtml = '<span class="text-gray-500 text-sm">No categories</span>';
        }

        // Build image HTML
        let imageHtml = '';
        if (note.image) {
            imageHtml = `
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Cover Image</h4>
                    <img src="/storage/${note.image}" alt="${note.name}" class="w-full max-w-md rounded-lg border border-gray-200">
                </div>
            `;
        }

        // Populate modal content
        content.innerHTML = `
            <div class="space-y-6">
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Title</h4>
                    <p class="text-lg text-gray-900">${note.name}</p>
                </div>
                
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Content</h4>
                    <p class="text-gray-700 whitespace-pre-wrap">${note.content || 'No content'}</p>
                </div>
                
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-2">Categories</h4>
                    <div class="flex flex-wrap gap-2">
                        ${categoriesHtml}
                    </div>
                </div>
                
                ${imageHtml}
                
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-200">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Author</h4>
                        <p class="text-sm text-gray-600">${note.user?.name || 'Unknown'}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-gray-700 mb-1">Created</h4>
                        <p class="text-sm text-gray-600">${new Date(note.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' })}</p>
                    </div>
                </div>
            </div>
        `;

        // Refresh icons
        if (window.refreshIcons) window.refreshIcons();

    } catch (error) {
        console.error('Error loading note:', error);
        content.innerHTML = `
            <div class="text-center py-8">
                <i data-lucide="alert-circle" class="w-12 h-12 text-red-500 mx-auto mb-3"></i>
                <p class="text-red-600">Error loading note details.</p>
                <button onclick="closeViewModal()" class="mt-4 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                    Close
                </button>
            </div>
        `;
        if (window.refreshIcons) window.refreshIcons();
    }
};

/**
 * Close view modal
 */
window.closeViewModal = function () {
    const modal = document.getElementById('view-note-modal');
    modal.classList.add('hidden');
};

// Close modals on background click
document.addEventListener('click', function (e) {
    if (e.target.id === 'form-note-modal') {
        closeFormModal();
    }
    if (e.target.id === 'view-note-modal') {
        closeViewModal();
    }
});

// Close modals on ESC key
document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        closeFormModal();
        closeViewModal();
    }
});
