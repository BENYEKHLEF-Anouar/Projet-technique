document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('public-search');
    const categoryFilter = document.getElementById('public-category');
    const notesGrid = document.getElementById('notes-grid');
    const filterForm = document.getElementById('public-filter-form');

    if (!filterForm) return;

    function fetchPublicNotes() {
        const query = searchInput ? searchInput.value : '';
        const categoryId = categoryFilter ? categoryFilter.value : '';
        const url = new URL(window.location.origin + window.location.pathname);
        if (query) url.searchParams.set('search', query);
        if (categoryId) url.searchParams.set('category_id', categoryId);

        // Update URL without reload
        window.history.pushState({}, '', url);

        fetch(url.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.text())
            .then(html => {
                const notesWrapper = document.getElementById('notes-wrapper');
                if (notesWrapper) {
                    notesWrapper.outerHTML = html;
                    if (window.refreshIcons) {
                        window.refreshIcons();
                    }
                }
            })
            .catch(err => console.error('Error fetching notes:', err));
    }

    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(fetchPublicNotes, 300);
        });
    }

    if (categoryFilter) {
        categoryFilter.addEventListener('change', fetchPublicNotes);
    }

    // Handle form submit to prevent reload
    filterForm.addEventListener('submit', (e) => {
        e.preventDefault();
        fetchPublicNotes();
    });
    // Handle pagination links
    document.addEventListener('click', (e) => {
        const paginationLink = e.target.closest('#notes-wrapper .pagination a');
        if (paginationLink) {
            e.preventDefault();
            const url = paginationLink.href;

            // Update URL without reload
            window.history.pushState({}, '', url);

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.text())
                .then(html => {
                    const notesWrapper = document.getElementById('notes-wrapper');
                    if (notesWrapper) {
                        notesWrapper.outerHTML = html;
                        if (window.refreshIcons) {
                            window.refreshIcons();
                        }
                        // Scroll to top of grid
                        document.getElementById('notes-grid')?.scrollIntoView({ behavior: 'smooth' });
                    }
                })
                .catch(err => console.error('Error fetching paginated notes:', err));
        }
    });
});
