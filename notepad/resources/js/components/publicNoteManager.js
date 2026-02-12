import baseManager from './baseManager';

export default ({ initialSearch = '', initialCategoryId = '' }) => ({
    // Spread base manager functionality
    ...baseManager({ initialSearch, initialCategoryId }),

    // Public-specific properties
    notesHtml: '',

    init() {
        // Initialize base functionality (watchers, Preline, etc.)
        this.initBase();

        // Setup public-specific watchers
        this.$watch('search', () => this.fetchNotes());
        this.$watch('categoryId', () => this.fetchNotes());

        // Handle pagination link clicks
        this.$nextTick(() => {
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

                // Re-initialize Preline and icons
                this.reinitializeUI();

                // Handle scrolling if it was pagination
                if (url.includes('page=')) {
                    const grid = document.getElementById('notes-grid');
                    if (grid) grid.scrollIntoView({ behavior: 'smooth' });
                }
            }
        } catch (error) {
            console.error('Error fetching notes:', error);
        } finally {
            this.loading = false;
        }
    },


});