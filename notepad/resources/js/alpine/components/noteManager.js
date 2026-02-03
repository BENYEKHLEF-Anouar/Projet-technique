
export default ({ initialNotes = [], initialPagination = {}, initialCategoryId = '', csrf = '', deleteConfirmMessage = '', currentUserId = null, userRole = 'user' }) => ({
    notes: initialNotes,
    pagination: initialPagination,
    deleteConfirmMessage: deleteConfirmMessage,
    currentUserId: currentUserId,
    userRole: userRole,
    search: '',
    categoryId: initialCategoryId,
    currentPage: initialPagination.current_page || 1,
    showModal: false,
    isEdit: false,
    loading: false,
    errors: {},
    formData: {
        id: null,
        name: '',
        content: '',
        category_ids: [],
        image: null
    },
    imagePreview: null,

    init() {
        // Initial fetch not strictly needed if we populate initialNotes from Blade
        // but good for resetting state if needed.
        this.$watch('search', () => this.fetchNotes());
        this.$watch('categoryId', () => {
            this.fetchNotes();
        });

        this.$nextTick(() => {
            // Re-initialize Preline components
            if (typeof HSStaticMethods !== 'undefined') {
                HSStaticMethods.autoInit();
            }

            // Bind Preline Combobox to Alpine
            const comboBoxEl = document.querySelector('[data-hs-combo-box]');
            if (comboBoxEl) {
                // Preline v2.x emits a custom event on selection
                comboBoxEl.addEventListener('hsComboBoxSelection', (e) => {
                    const value = e.detail.value;
                    this.categoryId = value || '';
                });

                // Fallback for click on items if needed
                comboBoxEl.addEventListener('click', (e) => {
                    const itemWrapper = e.target.closest('[data-hs-combo-box-output-item]');
                    if (itemWrapper) {
                        const valueSource = itemWrapper.querySelector('[data-value]');
                        if (valueSource) {
                            const val = valueSource.getAttribute('data-value');
                            this.categoryId = val || '';
                        }
                    }
                });
            }
        });
    },

    async fetchNotes(page = 1) {
        this.loading = true;
        this.currentPage = page;

        const params = new URLSearchParams({
            search: this.search,
            category_id: this.categoryId,
            page: this.currentPage
        });

        try {
            const response = await fetch(`/notes?${params.toString()}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();

            // data is the return of LengthAwarePaginator->toArray()
            this.notes = data.data || [];
            this.pagination = data;

            // Re-init generic plugins if needed (like Lucide)
            this.$nextTick(() => {
                if (window.refreshIcons) window.refreshIcons();
            });
        } catch (error) {
            console.error('Error serving notes:', error);
        } finally {
            this.loading = false;
        }
    },

    changePage(page) {
        if (page < 1 || page > this.pagination.last_page || page === this.currentPage) return;
        this.fetchNotes(page);
    },

    get pages() {
        const pages = [];
        const lastPage = this.pagination.last_page || 1;
        const current = this.currentPage;

        let start = Math.max(1, current - 2);
        let end = Math.min(lastPage, current + 2);

        for (let i = start; i <= end; i++) {
            pages.push(i);
        }
        return pages;
    },

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
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (!response.ok) {
                if (response.status === 422) {
                    this.errors = result.errors;
                } else {
                    window.dispatchEvent(new CustomEvent('notify', {
                        detail: { message: result.message || 'An error occurred', type: 'error' }
                    }));
                }
                return;
            }

            // Success
            this.closeModal();
            this.fetchNotes();

            // Success feedback
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { message: result.message, type: 'success' }
            }));
        } catch (error) {
            console.error(error);
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { message: 'Unexpected error occurred', type: 'error' }
            }));
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
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                this.fetchNotes();
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { message: result.message, type: 'success' }
                }));
            } else {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { message: result.message || 'Failed to delete note', type: 'error' }
                }));
            }
        } catch (error) {
            console.error('Error deleting note:', error);
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { message: 'Unexpected error occurred', type: 'error' }
            }));
        }
    }
});
