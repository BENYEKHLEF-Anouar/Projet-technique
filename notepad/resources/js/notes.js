const table = document.getElementById('notes-table');
const searchInput = document.getElementById('search');

function fetchNotes(query = '') {
    fetch(`/notes?search=${query}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } }) 
        .then(res => res.text()) 
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
    searchInput.addEventListener('input', (e) => { 
        fetchNotes(e.target.value);
    });
}

document.getElementById('noteForm')?.addEventListener('submit', (e) => {
    e.preventDefault(); 
    const form = e.target; 
   


    const successMsg = document.getElementById('success-msg');
    if (successMsg) successMsg.innerText = '';

    console.log(form.action)

    fetch(form.action, {
        method: 'POST',
        body: new FormData(form), 
        headers: { 'X-Requested-With': 'XMLHttpRequest' } 
    })
        .then(res => {
            if (res.ok) {
                fetchNotes(searchInput ? searchInput.value : '');
                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.close('#hs-slide-down-animation-modal');
                }
                form.reset(); 
                if (successMsg) {
                    successMsg.innerText = form.dataset.success;
                }
            }
        });
});