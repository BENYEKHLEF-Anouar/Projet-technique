export default ({ initialSearch = '', initialCategoryId = '' }) => ({
    search: initialSearch,
    categoryId: initialCategoryId,
    notesHtml: '',
    loading: false,

    init() {
        this.$watch('search', () => {
            this.fetchNotes();
        });
        this.$watch('categoryId', () => {
            this.fetchNotes();
        });

        this.$nextTick(() => {
            // Bind Preline Combobox to Alpine
            const comboBoxEl = document.querySelector('[data-hs-combo-box]');
            if (comboBoxEl) {
                comboBoxEl.addEventListener('hsComboBoxSelection', (e) => {
                    this.categoryId = e.detail.value || '';
                });

                // Fallback for direct clicks
                comboBoxEl.addEventListener('click', (e) => {
                    const itemWrapper = e.target.closest('[data-hs-combo-box-output-item]');
                    if (itemWrapper) {
                        const valueSource = itemWrapper.querySelector('[data-value]');
                        if (valueSource) {
                            this.categoryId = valueSource.getAttribute('data-value') || '';
                        }
                    }
                });
            }

            // Handle pagination links
            document.addEventListener('click', (e) => {
                const paginationLink = e.target.closest('#notes-wrapper .pagination a, #notes-wrapper nav a');
                if (paginationLink) {
                    e.preventDefault();
                    this.fetchNotes(paginationLink.href);
                }
            });
        });

    },

    async fetchNotes(url = null) {
        this.loading = true;

        if (!url) {
            const params = new URLSearchParams({
                search: this.search,
                category_id: this.categoryId
            });
            url = `${window.location.pathname}?${params.toString()}`;
        }

        // Update URL without reload
        window.history.pushState({}, '', url);

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!response.ok) throw new Error('Network response was not ok');

            const html = await response.text();

            // The logic from public_filters.js replaced the whole #notes-wrapper outerHTML
            // We can do similar by just updating a variable that holds the HTML or 
            // by using an Alpine ref to replace content.
            // Using outerHTML replacement via a ref is cleaner for existing Blade structures.

            const wrapper = document.getElementById('notes-wrapper');
            if (wrapper) {
                wrapper.outerHTML = html;

                // Re-initialize icons and Preline
                this.$nextTick(() => {
                    if (window.refreshIcons) window.refreshIcons();
                    if (typeof HSStaticMethods !== 'undefined') {
                        HSStaticMethods.autoInit();
                    }
                    // Handle scrolling if it was pagination
                    if (url.includes('page=')) {
                        const grid = document.getElementById('notes-grid');
                        if (grid) grid.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            }
        } catch (error) {
            console.error('Error fetching notes:', error);
        } finally {
            this.loading = false;
        }
    },


});