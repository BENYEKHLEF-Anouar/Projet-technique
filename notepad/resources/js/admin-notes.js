import axios from 'axios';

document.addEventListener('DOMContentLoaded', () => {
    const tableContainer = document.getElementById('notes-table-container');
    const noteForm = document.getElementById('note-form');
    const saveNoteBtn = document.getElementById('save-note-btn');
    const modalTitle = document.getElementById('modal-title');
    const formMethod = document.getElementById('form-method');
    const noteIdInput = document.getElementById('note-id');

    // -- Handlers --

    // Open Modal for Create (Reset form)
    document.querySelectorAll('[data-hs-overlay="#hs-create-note-modal"]').forEach(btn => {
        btn.addEventListener('click', () => {
            resetForm();
        });
    });

    // Save Note (Create or Update)
    saveNoteBtn.addEventListener('click', async () => {
        const formData = new FormData(noteForm);
        const url = noteIdInput.value ? `/admin/notes/${noteIdInput.value}` : '/admin/notes';

        // Laravel needs _method=PUT for updates via FormData
        if (noteIdInput.value) {
            formData.append('_method', 'PUT');
        }

        try {
            saveNoteBtn.disabled = true;
            saveNoteBtn.innerText = 'Saving...';

            await axios.post(url, formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });

            // Success configuration
            closeModal();
            fetchNotes(); // Was refreshTable
            resetForm();
            alert('Note saved successfully!');

        } catch (error) {
            console.error(error);
            if (error.response && error.response.data.errors) {
                // Show validation errors
                // Simple implementation: alert first error
                const errors = Object.values(error.response.data.errors).flat();
                alert(errors.join('\n'));
            } else {
                alert('An error occurred. Please try again.');
            }
        } finally {
            saveNoteBtn.disabled = false;
            saveNoteBtn.innerText = 'Save Note';
        }
    });

    // Delete Note (Event delegation)
    tableContainer.addEventListener('click', async (e) => {
        if (e.target.classList.contains('delete-note-btn')) {
            if (!confirm('Are you sure you want to delete this note?')) return;

            const id = e.target.dataset.id;
            try {
                await axios.delete(`/admin/notes/${id}`);
                fetchNotes();
            } catch (error) {
                alert('Failed to delete note.');
            }
        }
    });

    // Edit Note (Event delegation)
    tableContainer.addEventListener('click', async (e) => {
        if (e.target.classList.contains('edit-note-btn')) {
            const id = e.target.dataset.id;

            try {
                const response = await axios.get(`/admin/notes/${id}/edit`);
                populateForm(response.data);

                // Open modal using Preline API if available, else standard trigger
                const modal = document.querySelector('#hs-create-note-modal');
                HSOverlay.open(modal);

            } catch (error) {
                console.error(error);
                alert('Failed to load note details.');
            }
        }
    });

    // View Note (Event delegation)
    tableContainer.addEventListener('click', async (e) => {
        if (e.target.classList.contains('view-note-btn')) {
            const id = e.target.dataset.id;
            try {
                // Reuse the edit endpoint since it returns the raw JSON model
                const response = await axios.get(`/admin/notes/${id}/edit`);
                populateViewModal(response.data);

                const modal = document.querySelector('#hs-view-note-modal');
                HSOverlay.open(modal);
            } catch (error) {
                console.error(error);
                alert('Failed to load note details.');
            }
        }
    });

    // Pagination Links (Event delegation)
    tableContainer.addEventListener('click', (e) => {
        const link = e.target.closest('a.page-link'); // Laravel pagination classes usually use Bootstrap-like structure or Tailwind
        // Tailwind pagination often implies 'a' tags inside the links
        if (link || (e.target.tagName === 'A' && e.target.href && e.target.href.includes('page='))) {
            e.preventDefault();
            const target = link || e.target;
            const url = new URL(target.href);
            const page = url.searchParams.get('page');
            fetchNotes(page); // Use new fetchNotes
        }
    });

    // -- Functions --

    // --- Fetch Notes (AJAX) ---
    function fetchNotes(page = 1) {
        const searchValue = document.getElementById('search-input')?.value || '';
        const categoryValue = document.getElementById('category-filter')?.value || '';

        let url = `/admin?page=${page}`;
        if (searchValue) url += `&search=${encodeURIComponent(searchValue)}`;
        if (categoryValue) url += `&category=${encodeURIComponent(categoryValue)}`;

        axios.get(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                document.getElementById('notes-table-container').innerHTML = response.data;
            })
            .catch(error => {
                console.error('Error fetching notes:', error);
            });
    }

    // --- Search & Filter Listeners ---
    const searchInput = document.getElementById('search-input');
    const categoryFilter = document.getElementById('category-filter');
    let searchTimeout;

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                fetchNotes(1);
            }, 300);
        });
    }

    if (categoryFilter) {
        categoryFilter.addEventListener('change', function () {
            fetchNotes(1);
        });
    }

    // --- Image Preview Logic ---
    const imageInput = document.getElementById('image');
    const imageUrlInput = document.getElementById('image_url');
    const currentImageContainer = document.getElementById('current-image');
    const currentImage = currentImageContainer.querySelector('img');

    // File Upload Preview
    if (imageInput) {
        imageInput.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    currentImage.src = e.target.result;
                    currentImageContainer.classList.remove('hidden');
                    // Clear URL input if file is selected to avoid confusion? 
                    // Or just let the backend handle precedence (usually file > url).
                    // For UI clarity, let's leave URL as is but File preview takes over.
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // URL Input Preview
    if (imageUrlInput) {
        imageUrlInput.addEventListener('input', function (e) {
            const url = e.target.value;
            // Only preview if no file is selected or to override?
            // Simple logic: if URL changes, show it. If File changes, show it.
            if (url && url.startsWith('http')) {
                currentImage.src = url;
                currentImageContainer.classList.remove('hidden');
            } else if (!imageInput.files.length) {
                // If invalid URL and no file, hide
                currentImageContainer.classList.add('hidden');
            }
        });
    }

    // --- Pagination Clicks ---

    function resetForm() {
        noteForm.reset();
        noteIdInput.value = '';
        modalTitle.innerText = 'New Note';
        formMethod.value = 'POST';
        const imgContainer = document.getElementById('current-image');
        imgContainer.classList.add('hidden');
        imgContainer.querySelector('img').src = ''; // Clear source to prevent ghosting
    }

    function populateForm(note) {
        resetForm();
        modalTitle.innerText = 'Edit Note';
        document.getElementById('note-id').value = note.id;
        document.getElementById('name').value = note.name;
        document.getElementById('content').value = note.content;

        // Reset image fields
        document.getElementById('image').value = '';
        document.getElementById('image_url').value = '';

        // If it's a URL, fill the URL field
        if (note.image && note.image.startsWith('http')) {
            document.getElementById('image_url').value = note.image;
        }

        // Preview
        const imgContainer = document.getElementById('current-image');
        const img = imgContainer.querySelector('img');
        if (note.image_url) { // Use appended accessor from JSON
            imgContainer.classList.remove('hidden');
            img.src = note.image_url;
        } else {
            // Fallback if appending didn't work or empty
            if (note.image) {
                imgContainer.classList.remove('hidden');
                img.src = note.image.startsWith('http') ? note.image : `/storage/${note.image}`;
            } else {
                imgContainer.classList.add('hidden');
                img.src = '';
            }
        }

        // Categories
        // Uncheck all first
        const checkboxes = document.querySelectorAll('input[name="categories[]"]');
        checkboxes.forEach(cb => cb.checked = false);

        // Check selected
        const selectedIds = note.categories.map(c => c.id);
        selectedIds.forEach(id => {
            const cb = document.getElementById(`category-${id}`);
            if (cb) cb.checked = true;
        });

        // Logic to remove 'required' from image input during edit
        document.getElementById('image').removeAttribute('required');
    }

    function closeModal() {
        const modal = document.querySelector('#hs-create-note-modal');
        HSOverlay.close(modal);
    }

    function populateViewModal(note) {
        document.getElementById('view-name').innerText = note.name;
        document.getElementById('view-content').innerText = note.content || 'No content.';
        document.getElementById('view-categories').innerText = note.categories.map(c => c.name).join(', ');

        // Author
        if (note.user) {
            document.getElementById('view-author').innerText = note.user.name;
        }

        const imgContainer = document.getElementById('view-image-container');
        const img = document.getElementById('view-image');

        // Use appended image_url or fallback
        const src = note.image_url ? note.image_url : (note.image ? (note.image.startsWith('http') ? note.image : `/storage/${note.image}`) : null);

        if (src) {
            imgContainer.classList.remove('hidden');
            img.src = src;
        } else {
            imgContainer.classList.add('hidden');
            img.src = '';
        }
    }
});
