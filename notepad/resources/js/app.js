import 'preline';
import { createIcons, icons } from 'lucide';
import Alpine from 'alpinejs';
import noteManager from './components/noteManager';

import './public_filters';

// Register Alpine component
Alpine.data('noteManager', noteManager);

window.Alpine = Alpine;
Alpine.start();

// Pre-initialize icons
createIcons({ icons });

// Expose to window for AJAX updates or Alpine utilization
window.refreshIcons = () => {
    createIcons({ icons });
};


