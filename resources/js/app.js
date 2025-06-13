import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.local-coffee-time').forEach(function (el) {
        const iso = el.getAttribute('data-iso');
        if (iso) {
            // Parse as UTC by appending 'Z' if not present
            const utcIso = iso.endsWith('Z') ? iso : iso + 'Z';
            const date = new Date(utcIso);
            const dateStr = date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone
            });
            const timeStr = date.toLocaleTimeString('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                timeZone: Intl.DateTimeFormat().resolvedOptions().timeZone
            });
            el.textContent = `${dateStr} · ${timeStr}`;
        }
    });
});
