import './bootstrap';
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    console.log('Browser timezone:', Intl.DateTimeFormat().resolvedOptions().timeZone);

    document.querySelectorAll('.local-coffee-date').forEach(function (el) {
        const iso = el.getAttribute('data-iso');
        if (iso) {
            const date = new Date(iso);
            el.textContent = date.toLocaleDateString(undefined, {
                month: 'short',
                day: 'numeric',
                year: 'numeric'
            });
        }
    });

    document.querySelectorAll('.local-coffee-time').forEach(function (el) {
        const iso = el.getAttribute('data-iso');
        if (iso) {
            const date = new Date(iso);
            console.log('Offset (hrs):', date.getTimezoneOffset() / 60);

            el.textContent = date.toLocaleTimeString(undefined, {
                hour: 'numeric',
                minute: '2-digit',
            });
        }
    });
});
