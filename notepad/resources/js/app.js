import 'preline';
import { createIcons, icons } from 'lucide';
import './notes';

// Pre-initialize icons
createIcons({ icons });

// Expose to window for AJAX updates
window.refreshIcons = () => {
    createIcons({ icons });
};
