import 'preline';
import { createIcons, icons } from 'lucide';

import './public_filters';
import './notes';

// Pre-initialize icons
createIcons({ icons });

// Expose to window for AJAX updates
window.refreshIcons = () => {
    createIcons({ icons });
};

// Vanilla Notification Helper
window.showNotification = (message, type = 'success') => {
    const container = document.getElementById('notification-container');
    if (!container) return;

    const notification = document.createElement('div');
    notification.className = `notification-item ${type === 'success' ? 'bg-teal-50 border-teal-500 text-teal-800' : 'bg-red-50 border-red-500 text-red-800'} border-t-2 rounded-lg p-4 shadow-lg mb-2 transition-all duration-300 opacity-0 translate-y-[-20px]`;

    notification.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                <i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" class="h-5 w-5 ${type === 'success' ? 'text-teal-600' : 'text-red-600'} mt-0.5"></i>
            </div>
            <div class="ms-3">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <div class="ms-auto ps-3">
                <button type="button" class="inline-flex rounded-md p-1.5 focus:outline-hidden close-notification">
                    <i data-lucide="x" class="h-4 w-4"></i>
                </button>
            </div>
        </div>
    `;

    container.appendChild(notification);
    window.refreshIcons();

    // Trigger animation
    setTimeout(() => {
        notification.classList.remove('opacity-0', 'translate-y-[-20px]');
    }, 10);

    // Auto remove
    const timeout = setTimeout(() => {
        notification.classList.add('opacity-0', 'translate-y-[-20px]');
        setTimeout(() => notification.remove(), 300);
    }, 5000);

    // Close on click
    notification.querySelector('.close-notification').addEventListener('click', () => {
        clearTimeout(timeout);
        notification.classList.add('opacity-0', 'translate-y-[-20px]');
        setTimeout(() => notification.remove(), 300);
    });
};
