import 'preline';
import { createIcons, icons } from 'lucide';
import Alpine from 'alpinejs';
import noteManager from './components/noteManager';
import publicNoteManager from './components/publicNoteManager';

// Register Alpine components
Alpine.data('noteManager', noteManager);
Alpine.data('publicNoteManager', publicNoteManager);

window.Alpine = Alpine;
Alpine.start();

// Pre-initialize icons
createIcons({ icons });

// Expose to window for AJAX updates or Alpine utilization
window.refreshIcons = () => {
    createIcons({ icons });
};
