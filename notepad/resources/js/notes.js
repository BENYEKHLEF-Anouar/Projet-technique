const table = document.getElementById('notes-table');
const searchInput = document.getElementById('search');

function fetchNotes(query = '') {
    fetch(`/notes?search=${query}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } }) // Custom HTTP header. Tells Laravel this is an AJAX request. Allows the backend to return partial HTML instead of a full page.
        .then(res => res.text()) // Reads the response body as plain HTML text (not JSON).
        .then(html => {
            if (table) {
                table.innerHTML = html;
                if (window.refreshIcons) {
                    window.refreshIcons();
                }
            }
        });
}

if (searchInput) {
    searchInput.addEventListener('input', (e) => { // (e) Event object.
        fetchNotes(e.target.value);
    });
}

document.getElementById('noteForm')?.addEventListener('submit', (e) => {
    e.preventDefault(); // Prevents the default form submission behavior.
    const form = e.target; // form now references the submitted <form> element.
    // Clear previous success message
    const successMsg = document.getElementById('success-msg');
    if (successMsg) successMsg.innerText = '';

    console.log(form.action)

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form), // Automatically collects: Inputs, Files, Textareas, CSRF token
        headers: { 'X-Requested-With': 'XMLHttpRequest' } // marks this as an AJAX request for Laravel.
    })
        .then(res => {
            if (res.ok) {
                fetchNotes(searchInput ? searchInput.value : '');
                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.close('#hs-slide-down-animation-modal');
                }
                form.reset(); // Clears all form fields.
                if (successMsg) {
                    successMsg.innerText = form.dataset.success;
                }
            }
        });
});
