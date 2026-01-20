let searchInput = document.getElementById('search');
const modalId = '#hs-slide-down-animation-modal';
let categoryFilter = document.getElementById('category-filter');

function fetchNotes() {
    const query = searchInput ? searchInput.value : '';
    const categoryId = categoryFilter ? categoryFilter.value : '';

    fetch(`/notes?search=${query}&category_id=${categoryId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.text())
        .then(html => {
            const tableWrapper = document.getElementById('table-wrapper');
            if (tableWrapper) {
                tableWrapper.outerHTML = html;
                if (window.refreshIcons) {
                    window.refreshIcons();
                }
                // Re-attach event listeners after DOM update
                attachEventListeners();
            }
        })
        .catch(err => console.error('Error fetching notes:', err));
}

function attachEventListeners() {
    // Re-get elements after DOM update
    searchInput = document.getElementById('search');
    categoryFilter = document.getElementById('category-filter');

    if (searchInput) {
        searchInput.removeEventListener('input', fetchNotes); // Remove old listener
        searchInput.addEventListener('input', fetchNotes);
    }

    if (categoryFilter) {
        categoryFilter.removeEventListener('change', fetchNotes); // Remove old listener
        categoryFilter.addEventListener('change', fetchNotes);
    }
}

// Initial attachment
attachEventListeners();

// Handle admin pagination links
document.addEventListener('click', (e) => {
    const paginationLink = e.target.closest('#table-wrapper nav a');
    if (paginationLink) {
        e.preventDefault();
        const url = paginationLink.href;

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
                    attachEventListeners();
                }
            })
            .catch(err => console.error('Error fetching paginated admin notes:', err));
    }
});

// Reset form for "Add Note"
function resetForm() {
    const form = document.getElementById('noteForm');
    if (!form) return;

    form.reset();
    form.action = '/notes'; // Reset to store route

    // Remove method spoofing
    const methodInput = form.querySelector('input[name="_method"]');
    if (methodInput) methodInput.remove();

    // Reset Image Preview
    const imgPreview = document.getElementById('image-preview');
    if (imgPreview) imgPreview.classList.add('hidden');

    // Reset Title
    const modalTitle = document.getElementById('hs-slide-down-animation-modal-label');
    if (modalTitle) modalTitle.innerText = "Add Note"; // Or translate key if available on element data

    const successMsg = document.getElementById('success-msg');
    if (successMsg) successMsg.innerText = '';

    // Clear Error Messages
    document.querySelectorAll('.error-msg').forEach(el => el.innerText = '');
}

// Add Note Button Listener
document.getElementById('openModal')?.addEventListener('click', () => {
    resetForm();
});

// Edit Note Function
window.editNote = function (id) {
    resetForm();

    fetch(`/notes/${id}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const note = data.note;
                const form = document.getElementById('noteForm');

                // Set Action
                form.action = `/notes/${note.id}`;

                // Add Method Spoofing for PUT
                let methodInput = form.querySelector('input[name="_method"]');
                if (!methodInput) {
                    methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);
                }

                // Fill Text Inputs
                form.querySelector('[name="name"]').value = note.name;
                form.querySelector('[name="content"]').value = note.content;

                // Handle Categories (Checkboxes)
                // First uncheck all
                form.querySelectorAll('input[name="category_ids[]"]').forEach(cb => cb.checked = false);
                // Then check relevant ones
                if (data.categories) {
                    data.categories.forEach(catId => {
                        const cb = form.querySelector(`input[value="${catId}"]`);
                        if (cb) cb.checked = true;
                    });
                }

                // Handle Image Preview
                if (data.image_url) {
                    const imgPreview = document.getElementById('image-preview');
                    if (imgPreview) {
                        imgPreview.classList.remove('hidden');
                        imgPreview.querySelector('img').src = data.image_url;
                    }
                }

                // Update Modal Title
                const modalTitle = document.getElementById('hs-slide-down-animation-modal-label');
                if (modalTitle) modalTitle.innerText = "Edit Note";

                // Open Modal
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
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                fetchNotes();
                const successMsg = document.getElementById('success-msg');
                if (successMsg) successMsg.innerText = data.message;
            }
        })
        .catch(err => {
            console.error('Error deleting note:', err);
            alert('Failed to delete note. Please try again.');
        });
};

// Form Submit Handler
document.getElementById('noteForm')?.addEventListener('submit', (e) => {
    e.preventDefault();
    const form = e.target;
    const successMsg = document.getElementById('success-msg');

    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
        .then(async res => {
            const data = await res.json();
            if (res.status === 422) {
                // Clear previous errors
                document.querySelectorAll('.error-msg').forEach(el => el.innerText = '');

                // Display new errors
                for (const [field, messages] of Object.entries(data.errors)) {
                    const errorSpan = document.getElementById(`error-${field.replace('.', '_')}`);
                    if (errorSpan) {
                        errorSpan.innerText = messages[0];
                    }
                }
                return;
            }

            if (!res.ok) {
                throw new Error('Network response was not ok');
            }
            return data;
        })
        .then(data => {
            if (!data) return; // Case of 422 already handled

            if (data.success) {
                fetchNotes();
                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.close(modalId);
                }
                form.reset();
                if (successMsg) {
                    successMsg.innerText = data.message || form.dataset.success;
                }
            } else {
                alert('Something went wrong.');
            }
        })
        .catch(err => {
            console.error('Error submitting form:', err);
            // alert('Failed to save note. Please try again.');
        });
});
