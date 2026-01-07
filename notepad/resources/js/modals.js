/**
 * Admin Notes Modal Management
 * Vanilla JavaScript for handling create, edit, and view modals with AJAX submissions
 */

// ============================================================================
// MODAL UTILITIES
// ============================================================================

/**
 * Toggle modal visibility with transitions
 * @param {HTMLElement} modal - The modal element
 * @param {boolean} show - Whether to show or hide
 */
function toggleModal(modal, show) {
    if (!modal) return;

    if (show) {
        // Enable display
        modal.classList.remove('hidden');
        
        // Trigger reflow to enable transition
        // This is crucial for the transition to play after removing 'hidden'
        void modal.offsetWidth;
        
        // Fade in
        modal.classList.remove('opacity-0');
        
        // Scale in content
        const inner = modal.querySelector('div');
        if (inner) {
            inner.classList.remove('scale-95');
            inner.classList.add('scale-100');
        }
    } else {
        // Fade out
        modal.classList.add('opacity-0');
        
        // Scale out content
        const inner = modal.querySelector('div');
        if (inner) {
            inner.classList.remove('scale-100');
            inner.classList.add('scale-95');
        }

        // Wait for transition to finish before hiding display
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
}

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
    alert.className = 'success-toast fixed top-4 right-4 z-[60] p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl shadow-lg flex items-center gap-3 animate-slide-up';
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
    title.textContent = 'Créer une Nouvelle Note';
    submitBtn.textContent = 'Créer la Note';

    // Show modal
    toggleModal(modal, true);

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
        title.textContent = 'Modifier la Note';
        submitBtn.textContent = 'Mettre à jour';

        // Show modal
        toggleModal(modal, true);

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
    toggleModal(modal, false);

    // Reset form after transition
    setTimeout(() => {
        document.getElementById('note-form').reset();
        clearFormErrors();
        clearImagePreview();
    }, 300);
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
            submitBtn.innerHTML = '<span class="inline-block animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></span>Sauvegarde...';

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
                submitBtn.textContent = noteId ? 'Mettre à jour' : 'Créer la Note';
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
    toggleModal(modal, true);
    content.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
            <p class="text-gray-500 mt-4 font-medium animate-pulse">Chargement...</p>
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
                `<span class="px-3 py-1 text-sm rounded-full bg-indigo-50 text-indigo-700 border border-indigo-100/50 font-medium">${cat.name}</span>`
            ).join('');
        } else {
            categoriesHtml = '<span class="text-gray-400 text-sm italic">Aucune catégorie</span>';
        }

        // Build image HTML
        let imageHtml = '';
        if (note.image) {
            imageHtml = `
                <div class="rounded-xl overflow-hidden shadow-sm border border-gray-100">
                    <img src="/storage/${note.image}" alt="${note.name}" class="w-full object-cover">
                </div>
            `;
        }

        // Populate modal content
        content.innerHTML = `
            <div class="space-y-8 animate-fade-in">
                ${imageHtml}
                
                <div>
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Titre</h4>
                    <p class="text-2xl font-bold text-gray-900 leading-tight">${note.name}</p>
                </div>
                
                <div>
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Contenu</h4>
                    <div class="prose prose-indigo max-w-none text-gray-600 leading-relaxed whitespace-pre-wrap bg-gray-50/50 p-4 rounded-xl border border-gray-100/50">${note.content || '<span class="italic text-gray-400">Aucun contenu</span>'}</div>
                </div>
                
                <div>
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Catégories</h4>
                    <div class="flex flex-wrap gap-2">
                        ${categoriesHtml}
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-4 pt-6 border-t border-gray-100">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-gray-500">Auteur</h4>
                            <p class="text-sm font-medium text-gray-900">${note.user?.name || 'Inconnu'}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                            <i data-lucide="calendar" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-semibold text-gray-500">Créé le</h4>
                            <p class="text-sm font-medium text-gray-900">${new Date(note.created_at).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })}</p>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Refresh icons
        if (window.refreshIcons) window.refreshIcons();

    } catch (error) {
        console.error('Error loading note:', error);
        content.innerHTML = `
            <div class="text-center py-12">
                <div class="inline-flex p-3 bg-red-50 rounded-full mb-4">
                    <i data-lucide="alert-circle" class="w-8 h-8 text-red-500"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-1">Erreur de chargement</h3>
                <p class="text-gray-500 mb-6">Impossible de charger les détails de la note.</p>
                <button onclick="closeViewModal()" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm">
                    Fermer
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
    toggleModal(modal, false);
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
