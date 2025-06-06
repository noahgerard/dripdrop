import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.local-coffee-date').forEach(function (el) {
        const iso = el.getAttribute('data-iso');
        if (iso) {
            // Parse as UTC by appending 'Z' if not present
            const utcIso = iso.endsWith('Z') ? iso : iso + 'Z';
            const date = new Date(utcIso);
            el.textContent = date.toLocaleDateString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric',
                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone
            });
        }
    });

    document.querySelectorAll('.local-coffee-time').forEach(function (el) {
        const iso = el.getAttribute('data-iso');
        if (iso) {
            // Parse as UTC by appending 'Z' if not present
            const utcIso = iso.endsWith('Z') ? iso : iso + 'Z';
            const date = new Date(utcIso);
            el.textContent = date.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone
            });
        }
    });
});
