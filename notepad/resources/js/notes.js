let searchInput = document.getElementById('search');
const modalId = '#hs-slide-down-animation-modal';
let categoryFilter = document.getElementById('category-filter');

function fetchNotes() {
    const query = searchInput ? searchInput.value : '';
    const categoryId = categoryFilter ? categoryFilter.value : '';

    const tableWrapper = document.getElementById('table-wrapper');
    if (tableWrapper) tableWrapper.style.opacity = '0.5';

    fetch(`/notes?search=${query}&category_id=${categoryId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html, application/json'
        }
    })
        .then(res => res.text())
        .then(html => {
            const tableWrapper = document.getElementById('table-wrapper');
            if (tableWrapper) {
                tableWrapper.outerHTML = html;
                if (window.refreshIcons) {
                    window.refreshIcons();
                }
            }
        })
        .catch(err => console.error('Error fetching notes:', err))
        .finally(() => {
            const tableWrapper = document.getElementById('table-wrapper');
            if (tableWrapper) tableWrapper.style.opacity = '1';
        });
}

// Debounce search
let debounceTimer;
function handleSearch() {
    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(fetchNotes, 300);
}

function attachEventListeners() {
    searchInput = document.getElementById('search');
    categoryFilter = document.getElementById('category-filter');

    if (searchInput) {
        searchInput.removeEventListener('input', handleSearch);
        searchInput.addEventListener('input', handleSearch);
    }

    // Preline ComboBox Listener
    const comboBoxEl = document.querySelector('[data-hs-combo-box]');
    if (comboBoxEl) {
        comboBoxEl.removeEventListener('hsComboBoxSelection', handleComboBox);
        comboBoxEl.addEventListener('hsComboBoxSelection', handleComboBox);
    }
}

function handleComboBox(e) {
    const val = e.detail.value || '';
    if (categoryFilter) {
        categoryFilter.value = val;
        fetchNotes();
    }
}

// Initial attachment
attachEventListeners();

// Handle admin pagination links via delegation
document.addEventListener('click', (e) => {
    const paginationLink = e.target.closest('#table-wrapper nav a');
    if (paginationLink) {
        e.preventDefault();
        const url = paginationLink.href;

        const tableWrapper = document.getElementById('table-wrapper');
        if (tableWrapper) tableWrapper.style.opacity = '0.5';

        fetch(url, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.text())
            .then(html => {
                const tableWrapper = document.getElementById('table-wrapper');
                if (tableWrapper) {
                    tableWrapper.outerHTML = html;
                    if (window.refreshIcons) {
                        window.refreshIcons();
                    }
                }
            })
            .catch(err => console.error('Error fetching paginated admin notes:', err))
            .finally(() => {
                const tableWrapper = document.getElementById('table-wrapper');
                if (tableWrapper) tableWrapper.style.opacity = '1';
            });
    }
});

// Reset form for "Add Note"
function resetForm() {
    const form = document.getElementById('noteForm');
    if (!form) return;

    form.reset();
    form.action = '/notes';

    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) methodInput.remove();

    const imgPreview = document.getElementById('image-preview');
    if (imgPreview) {
        imgPreview.classList.add('hidden');
        imgPreview.querySelector('img').src = '';
    }

    const modalTitle = document.getElementById('hs-slide-down-animation-modal-label');
    if (modalTitle) modalTitle.innerText = "Add Note";

    document.querySelectorAll('.error-msg').forEach(el => el.innerText = '');
}

// Add Note Button Listener
document.getElementById('openModal')?.addEventListener('click', () => {
    resetForm();
    if (typeof HSOverlay !== 'undefined') {
        HSOverlay.open(modalId);
    }
});

// Edit Note Function
window.editNote = function (id) {
    resetForm();

    fetch(`/notes/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const note = data.note;
                const form = document.getElementById('noteForm');

                form.action = `/notes/${note.id}`;

                let methodInput = form.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);
                }

                form.querySelector('[name="name"]').value = note.name;
                form.querySelector('[name="content"]').value = note.content;

                form.querySelectorAll('input[name="category_ids[]"]').forEach(cb => cb.checked = false);
                if (data.categories) {
                    data.categories.forEach(catId => {
                        const cb = form.querySelector(`input[value="${catId}"]`);
                        if (cb) cb.checked = true;
                    });
                }

                if (data.image_url) {
                    const imgPreview = document.getElementById('image-preview');
                    if (imgPreview) {
                        imgPreview.classList.remove('hidden');
                        imgPreview.querySelector('img').src = data.image_url;
                    }
                }

                const modalTitle = document.getElementById('hs-slide-down-animation-modal-label');
                if (modalTitle) modalTitle.innerText = "Edit Note";

                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.open(modalId);
                }
            }
        });
};

// Delete Note Function
window.deleteNote = function (id) {
    if (!confirm('Are you sure you want to delete this note?')) return;

    fetch(`/notes/${id}`, {
        method: 'DELETE',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                fetchNotes();
                if (window.showNotification) window.showNotification(data.message, 'success');
            }
        })
        .catch(err => {
            console.error('Error deleting note:', err);
            if (window.showNotification) window.showNotification('Failed to delete note.', 'error');
        });
};

// Form Submit Handler
document.getElementById('noteForm')?.addEventListener('submit', (e) => {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
        .then(async res => {
            const data = await res.json();
            if (res.status === 422) {
                document.querySelectorAll('.error-msg').forEach(el => el.innerText = '');
                for (const [field, messages] of Object.entries(data.errors)) {
                    const errorSpan = document.getElementById(`error-${field.replace('.', '_')}`);
                    if (errorSpan) errorSpan.innerText = messages[0];
                }
                return;
            }
            if (!res.ok) throw new Error('Network response was not ok');
            return data;
        })
        .then(data => {
            if (!data) return;
            if (data.success) {
                fetchNotes();
                if (typeof HSOverlay !== 'undefined') {
                    const modalEl = document.querySelector(modalId);
                    if (modalEl) {
                        HSOverlay.close(modalEl);
                        // Force backdrop removal as a fallback
                        setTimeout(() => {
                            const backdrop = document.querySelector('[data-hs-overlay-backdrop-template]');
                            if (backdrop) backdrop.remove();
                            // Also remove the explicit backdrop element if Preline created one
                            const activeBackdrop = document.querySelector('.hs-overlay-backdrop');
                            if (activeBackdrop) activeBackdrop.remove();
                            // Clean up body classes
                            document.body.style.overflow = '';
                            document.body.classList.remove('overflow-hidden');
                        }, 300);
                    }
                }
                form.reset();
                if (window.showNotification) window.showNotification(data.message, 'success');
            }
        })
        .catch(err => console.error('Error submitting form:', err));
});

// Image preview helper
document.addEventListener('change', (e) => {
    if (e.target.id === 'note-image') {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                const imgPreview = document.getElementById('image-preview');
                if (imgPreview) {
                    imgPreview.classList.remove('hidden');
                    imgPreview.querySelector('img').src = event.target.result;
                }
            };
            reader.readAsDataURL(file);
        }
    }
});