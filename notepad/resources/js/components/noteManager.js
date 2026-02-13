import { baseItemManager } from './baseManager';

export default ({ initialNotes = [], initialPagination = {}, initialCategoryId = '', initialSearch = '', csrf = '', deleteConfirmMessage = '' }) => ({
    // Spread item manager functionality (includes base manager)
    ...baseItemManager({  // factory function
        initialItems: initialNotes,
        initialPagination,
        initialCategoryId,
        initialSearch,
        csrf
    }),

    // Map 'items' to 'notes' for semantic clarity
    get notes() {
        return this.items;
    },
    set notes(value) {
        this.items = value;
    },

    // Note-specific properties
    deleteConfirmMessage: deleteConfirmMessage,

    // Note-specific form data structure (overrides base formData)
    formData: { // JavaScript object that holds all the current data for a form in your Alpine.js component
        id: null,
        name: '',
        content: '',
        category_ids: [],
        image: null
    },
    imagePreview: null,

    init() {
        // Initialize item manager (includes base)
        this.initItemManager();
    },

    // Override fetchItems from baseItemManager
    async fetchItems(page = 1) {
        this.loading = true;
        this.currentPage = page;

        try {
            const url = this.buildFetchUrl('/notes', page);
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const data = await this.handleFetchResponse(response);
            this.items = data.data || [];
        } catch (error) {
            console.error('Error fetching notes:', error);
        } finally {
            this.loading = false;
        }
    },

    // changePage and pages are inherited from baseItemManager

    openCreateModal() {
        this.resetForm();
        this.isEdit = false;
        this.showModal = true;
    },

    openEditModal(note) {
        this.resetForm();
        this.isEdit = true;
        this.formData.id = note.id;
        this.formData.name = note.name;
        this.formData.content = note.content;
        this.formData.category_ids = note.categories ? note.categories.map(c => c.id) : [];

        // Handle image preview if available
        if (note.image) {
            this.imagePreview = `/storage/${note.image}`;
        }

        this.showModal = true;
    },

    closeModal() {
        this.showModal = false;
        this.resetForm();
    },

    resetForm() {
        this.errors = {};
        this.imagePreview = null;
        this.formData = {
            id: null,
            name: '',
            content: '',
            category_ids: [],
            image: null // File object
        };
        // Reset file input manually if present
        const fileInput = document.getElementById('note-image');
        if (fileInput) fileInput.value = '';
    },

    handleFileUpload(event) {
        const file = event.target.files[0];
        this.formData.image = file;

        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.imagePreview = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    },

    async submitForm() {
        this.loading = true;
        this.errors = {};

        const data = new FormData();
        data.append('name', this.formData.name);
        data.append('content', this.formData.content);

        // Append categories array
        this.formData.category_ids.forEach(id => {
            data.append('category_ids[]', id);
        });

        if (this.formData.image) {
            data.append('image', this.formData.image);
        }

        let url = '/notes';
        let method = 'POST';

        if (this.isEdit) {
            url = `/notes/${this.formData.id}`;
            data.append('_method', 'PUT'); // Method spoofing for FormData
        }

        try {
            const response = await fetch(url, {
                method: 'POST', // Always POST for FormData with _method spoofing
                body: data,
                headers: {
                    'X-CSRF-TOKEN': this.csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (!this.handleFormResponse(response, result)) {
                if (response.status !== 422) {
                    this.notify(result.message || 'An error occurred', 'error');
                }
                return;
            }

            // Success
            this.closeModal();
            this.fetchItems();
            this.notify(result.message, 'success');
        } catch (error) {
            console.error(error);
            this.notify('Unexpected error occurred', 'error');
        } finally {
            this.loading = false;
        }
    },

    async deleteNote(id) {
        if (!confirm(this.deleteConfirmMessage || 'Are you sure?')) return;

        try {
            const response = await fetch(`/notes/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': this.csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                this.fetchItems();
                this.notify(result.message, 'success');
            } else {
                this.notify(result.message || 'Failed to delete note', 'error');
            }
        } catch (error) {
            console.error('Error deleting note:', error);
            this.notify('Unexpected error occurred', 'error');
        }
    }
});