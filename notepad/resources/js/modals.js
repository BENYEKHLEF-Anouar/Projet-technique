/**
 * Admin Notes Modal Management
 * Refactored for Preline UI Modals
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
    alert.className = 'success-toast fixed top-4 right-4 z-[90] p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-lg flex items-center gap-3 animate-slide-up';
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

    let errorHtml = '<ul class="list-disc list-inside">';

    // Clear any previous field errors
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

        // Highlight input
        const inputElement = document.getElementById(`note-${field}`) || document.getElementsByName(field)[0] || document.getElementsByName(`${field}[]`)[0];
        if (inputElement) {
            inputElement.classList.add('border-red-500', 'focus:border-red-500', 'focus:ring-red-500');
            inputElement.classList.remove('border-gray-200');
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

    // Remove red borders
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
};

// ============================================================================
// FORM MODAL (CREATE & EDIT)
// ============================================================================

/**
 * Open create note modal (Resets form)
 */
window.openCreateModal = function () {
    const form = document.getElementById('note-form');
    const title = document.getElementById('form-note-modal-label');
    const submitBtn = document.getElementById('submit-btn');

    // Reset form
    if (form) form.reset();
    document.getElementById('note-id').value = '';
    document.getElementById('form-method').value = 'POST';

    // Clear errors & previews
    clearFormErrors();
    document.getElementById('current-image-container').classList.add('hidden');
    clearImagePreview();
    document.querySelectorAll('input[name="category_ids[]"]').forEach(cb => cb.checked = false);

    // Update UI
    if (title) title.textContent = 'Créer une Nouvelle Note';
    if (submitBtn) submitBtn.textContent = 'Créer la Note';

    // Open Modal using Preline API
    const modalEl = document.getElementById('form-note-modal');
    if (window.HSOverlay) {
        window.HSOverlay.open(modalEl);
    }
};

/**
 * Open edit note modal
 */
window.openEditModal = async function (noteId) {
    const title = document.getElementById('form-note-modal-label');
    const submitBtn = document.getElementById('submit-btn');
    const modalEl = document.getElementById('form-note-modal');

    // Open modal immediately to show we are working (or show loading overlay?)
    // Better: Open modal effectively, maybe show a loading state if needed. 
    // Here we open it and populate.
    if (window.HSOverlay) {
        window.HSOverlay.open(modalEl);
    }

    try {
        const response = await fetch(`/admin/notes/${noteId}/edit`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        if (!response.ok) throw new Error('Failed to fetch note');

        const data = await response.json();
        const note = data.note;

        // Populate Form
        document.getElementById('note-id').value = note.id;
        document.getElementById('form-method').value = 'PUT';
        document.getElementById('note-name').value = note.name || '';
        document.getElementById('note-content').value = note.content || '';

        // Categories
        document.querySelectorAll('input[name="category_ids[]"]').forEach(cb => {
            cb.checked = note.categories.some(cat => cat.id == cb.value);
        });

        // Image
        const currentImageContainer = document.getElementById('current-image-container');
        const currentImage = document.getElementById('current-image');
        if (note.image) {
            currentImage.src = `/storage/${note.image}`;
            currentImageContainer.classList.remove('hidden');
        } else {
            currentImageContainer.classList.add('hidden');
        }

        // Update UI
        if (title) title.textContent = 'Modifier la Note';
        if (submitBtn) submitBtn.textContent = 'Mettre à jour';

    } catch (error) {
        console.error('Error loading note:', error);
        alert('Error loading note details.');
        if (window.HSOverlay) window.HSOverlay.close(modalEl);
    }
};

/**
 * Handle form submission
 */
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('note-form');

    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();

            const noteId = document.getElementById('note-id').value;
            const submitBtn = document.getElementById('submit-btn');
            const url = noteId ? `/admin/notes/${noteId}` : '/admin/notes';
            const formData = new FormData(form);
            const modalEl = document.getElementById('form-note-modal');

            // CSRF
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (csrfToken) formData.append('_token', csrfToken);

            // Loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'Sauvegarde...';
            clearFormErrors();

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                    body: formData
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    showSuccessMessage(data.message);
                    if (window.HSOverlay) window.HSOverlay.close(modalEl);
                    setTimeout(() => window.location.reload(), 500);
                } else {
                    if (data.errors) {
                        displayFormErrors(data.errors);
                    } else {
                        alert(data.message || 'Error occurred.');
                    }
                }
            } catch (error) {
                console.error('Error submitting form:', error);
                alert('An error occurred.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = noteId ? 'Mettre à jour' : 'Créer la Note';
            }
        });
    }
});

// ============================================================================
// VIEW MODAL
// ============================================================================

window.openViewModal = async function (noteId) {
    const modalEl = document.getElementById('view-note-modal');
    const loading = document.getElementById('view-modal-loading');
    const content = document.getElementById('view-modal-content');

    // Open Modal
    if (window.HSOverlay) {
        window.HSOverlay.open(modalEl);
    }

    // Reset state
    if (loading) loading.classList.remove('hidden');
    if (content) content.classList.add('hidden');

    try {
        const response = await fetch(`/admin/notes/${noteId}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        });

        if (!response.ok) throw new Error('Failed to fetch');

        const data = await response.json();
        const note = data.note;

        // Populate
        document.getElementById('view-note-title').textContent = note.name;
        document.getElementById('view-note-user').textContent = note.user?.name || 'Inconnu';
        if (note.created_at) {
            document.getElementById('view-note-date').textContent = new Date(note.created_at).toLocaleDateString('fr-FR', {
                year: 'numeric', month: 'long', day: 'numeric'
            });
        }
        document.getElementById('view-note-body').textContent = note.content || '';

        // Image
        const imgContainer = document.getElementById('view-note-image-container');
        const img = document.getElementById('view-note-image');
        if (note.image) {
            img.src = `/storage/${note.image}`;
            imgContainer.classList.remove('hidden');
        } else {
            imgContainer.classList.add('hidden');
        }

        // Categories
        const catContainer = document.getElementById('view-note-categories');
        if (catContainer) {
            if (note.categories && note.categories.length > 0) {
                catContainer.innerHTML = note.categories.map(cat =>
                    `<span class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-800/30 dark:text-blue-500">${cat.name}</span>`
                ).join('');
            } else {
                catContainer.innerHTML = '<span class="text-gray-500 text-sm italic">Aucune catégorie</span>';
            }
        }

        // Show Content
        if (loading) loading.classList.add('hidden');
        if (content) content.classList.remove('hidden');

    } catch (error) {
        console.error('Error:', error);
        // Ensure modal is closed or show error
        // alert('Error loading note.');
        // if (window.HSOverlay) window.HSOverlay.close(modalEl);
    }
};

// No global event listeners for Escape/Click needed as Preline handles them.
