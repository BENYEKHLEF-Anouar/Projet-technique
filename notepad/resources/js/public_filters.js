/**
 * Public Notes Management - Vanilla JavaScript Version
 * 
 * This file handles all real-time interactions for the public side of the application,
 * including AJAX-based searching, category filtering, and smooth pagination.
 * It is fully independent of any frameworks like Alpine.js or Vue.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Cache DOM elements frequently accessed to improve performance
    const searchInput = document.getElementById('public-search');
    const categoryFilter = document.getElementById('public-category');
    const notesGrid = document.getElementById('notes-grid');
    const filterForm = document.getElementById('public-filter-form');

    // If the filter form doesn't exist on the current page, exit the script immediately
    if (!filterForm) return;

    /**
     * Core function to fetch notes from the server via AJAX.
     * It builds a URL based on current search/filter state and replaces the grid content.
     */
    function fetchPublicNotes() {
        // Retrieve current values from inputs
        const query = searchInput ? searchInput.value : '';
        const categoryId = categoryFilter ? categoryFilter.value : '';

        // Generate a new URL object based on the current page location
        const url = new URL(window.location.origin + window.location.pathname);

        // Append search and category parameters to the URL if they have values
        if (query) url.searchParams.set('search', query);
        if (categoryId) url.searchParams.set('category_id', categoryId);

        /**
         * Update the browser's address bar without reloading the page.
         * This allows users to bookmark or share specific search/filter results.
         */
        window.history.pushState({}, '', url);

        /**
         * Perform the asynchronous network request.
         * We send an 'X-Requested-With' header so Laravel's $request->ajax() can detect it.
         */
        fetch(url.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.text()) // Expecting an HTML partial from the server
            .then(html => {
                const notesWrapper = document.getElementById('notes-wrapper');
                if (notesWrapper) {
                    // Replace the entire wrapper with the fresh HTML components returned by Laravel
                    notesWrapper.outerHTML = html;

                    /**
                     * Since the HTML was replaced, Lucide icons in the new elements need to be re-initialized.
                     * We call the global refreshIcons function defined in app.js.
                     */
                    if (window.refreshIcons) {
                        window.refreshIcons();
                    }
                }
            })
            .catch(err => console.error('Error fetching notes:', err));
    }

    /**
     * Search Input Handling with Debouncing
     * 
     * Debouncing prevents a request from being sent on every single keystroke.
     * Instead, it waits for the user to stop typing for 300ms.
     */
    if (searchInput) {
        let debounceTimer;
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer); // Reset the timer on every keystroke
            debounceTimer = setTimeout(fetchPublicNotes, 300); // Wait 300ms before executing
        });
    }

    /**
     * Category Filter Handling
     * 
     * Supports both the modern Preline UI Combobox and standard HTML selects.
     */
    const comboBoxEl = document.querySelector('[data-hs-combo-box]');
    if (comboBoxEl && categoryFilter) {
        /**
         * Listen for Preline UI specific selection event.
         * When a category is selected in the dropdown, update the hidden input and fetch.
         */
        comboBoxEl.addEventListener('hsComboBoxSelection', (e) => {
            const val = e.detail.value || '';
            categoryFilter.value = val;
            fetchPublicNotes();
        });

        /**
         * Fallback: Handle direct clicks on combobox items.
         * Useful if the selection event fails to fire or for broader compatibility.
         */
        comboBoxEl.addEventListener('click', (e) => {
            const itemWrapper = e.target.closest('[data-hs-combo-box-output-item]');
            if (itemWrapper) {
                const valueSource = itemWrapper.querySelector('[data-value]');
                const val = valueSource ? valueSource.getAttribute('data-value') : '';
                categoryFilter.value = val;
                fetchPublicNotes();
            }
        });
    } else if (categoryFilter && categoryFilter.tagName === 'SELECT') {
        // Standard dropdown behavior for non-combobox implementations
        categoryFilter.addEventListener('change', fetchPublicNotes);
    }

    /**
     * Form Submission Handling
     * 
     * Prevents the default browser reload when someone presses Enter in the search box.
     */
    filterForm.addEventListener('submit', (e) => {
        e.preventDefault();
        fetchPublicNotes();
    });

    /**
     * Global Click Listener for Pagination
     * 
     * Since pagination links are dynamically replaced via AJAX, we use event delegation.
     * We listen for clicks on the document and check if they originated from a pagination link.
     */
    document.addEventListener('click', (e) => {
        const paginationLink = e.target.closest('#notes-wrapper .pagination a');
        if (paginationLink) {
            e.preventDefault(); // Stop the browser from navigating away
            const url = paginationLink.href;

            // Synchronize the browser URL with the pagination state
            window.history.pushState({}, '', url);

            // Fetch only the relevant partial for the next page
            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.text())
                .then(html => {
                    const notesWrapper = document.getElementById('notes-wrapper');
                    if (notesWrapper) {
                        notesWrapper.outerHTML = html;
                        // Re-initialize Lucide icons for the new page of notes
                        if (window.refreshIcons) {
                            window.refreshIcons();
                        }
                        /**
                         * User experience: Smoothly scroll the page back to the top of the grid
                         * so the user can immediately see the new results.
                         */
                        document.getElementById('notes-grid')?.scrollIntoView({ behavior: 'smooth' });
                    }
                })
                .catch(err => console.error('Error fetching paginated notes:', err));
        }
    });
});
