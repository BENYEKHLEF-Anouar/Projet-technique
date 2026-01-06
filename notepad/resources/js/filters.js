export function initFilters() {
    const form = document.getElementById('filter-form');
    const notesContainer = document.getElementById('notes-container');
    const searchInput = document.getElementById('search-input');
    const categorySelect = document.getElementById('category-select');
    const clearFilters = document.getElementById('clear-filters');

    if (!form || !notesContainer) return;

    // Function to fetch filtered notes
    function fetchNotes() {
        const formData = new FormData(form); // Creates a new FormData object. A built-in browser class used to collect and send form data.
        const query = new URLSearchParams(formData).toString();

        // Update URL history (Without Reload)
        const newUrl = `${window.location.pathname}?${query}`;
        window.history.pushState({ path: newUrl }, '', newUrl);

        // Toggle Clear button visibility
        if (clearFilters) {
            if (searchInput.value || categorySelect.value) {
                clearFilters.classList.remove('hidden');
            } else {
                clearFilters.classList.add('hidden');
            }
        }


        // Fetch Filtered Notes via AJAX
        fetch(`${form.action}?${query}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' } // Sends a GET request to the form’s action URL.
        })
            // Update the Notes Grid
            .then(res => res.text())
            .then(html => {
                notesContainer.innerHTML = html;
                if (window.refreshIcons) window.refreshIcons(); // refresh icons
            })
            .catch(err => console.error(err));
    }

    // Trigger on search typing (with debounce)
    let timeout;
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(timeout);
            timeout = setTimeout(fetchNotes, 500);
        });
    }

    // Trigger on category change
    if (categorySelect) {
        categorySelect.addEventListener('change', fetchNotes);
    }

    // Clear filters via AJAX
    if (clearFilters) {
        clearFilters.addEventListener('click', (e) => {
            e.preventDefault();
            searchInput.value = '';  // Resets filters without page reload.
            categorySelect.value = '';
            fetchNotes();
        });
    }

    // Handle pagination links via AJAX
    notesContainer.addEventListener('click', (e) => {
        const link = e.target.closest('.pagination-container a');  // Delegates clicks for pagination links.
        if (link) {
            e.preventDefault();
            const url = link.href;

            // Update URL history for pagination
            window.history.pushState({ path: url }, '', url);

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(res => res.text())
                .then(html => {
                    notesContainer.innerHTML = html;
                    if (window.refreshIcons) window.refreshIcons();
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
        }
    });
}