import 'preline';
import { createIcons, icons } from 'lucide';
import './notes';
import './public_filters';

// Pre-initialize icons
createIcons({ icons });

// Expose to window for AJAX updates
window.refreshIcons = () => {
    createIcons({ icons });
};
