import 'preline';
import { createIcons, icons } from 'lucide';

import './public_filters';

// Pre-initialize icons
createIcons({ icons });

// Expose to window for AJAX updates
window.refreshIcons = () => {
    createIcons({ icons });
};

// Pre-initialize icons
createIcons({ icons });

// Expose to window for AJAX updates or Alpine utilization
window.refreshIcons = () => {
    createIcons({ icons });
};
