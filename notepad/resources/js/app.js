import 'preline';
import { createIcons, icons } from 'lucide';
import { initFilters } from './filters';

// Pre-initialize icons
createIcons({ icons });

// Expose to window for AJAX updates
window.refreshIcons = () => {
    createIcons({ icons });
};

document.addEventListener('DOMContentLoaded', () => {
    initFilters();
});
