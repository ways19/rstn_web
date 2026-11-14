import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';
import '../css/pages/diklat-registration.css';

window.Alpine = Alpine;
window.lucide = { createIcons, icons };

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

Alpine.start();


document.addEventListener('input', function (event) {
    if (!event.target.matches('.faq-page #faqSearchInput')) return;

    const root = event.target.closest('.faq-page');
    const query = event.target.value.trim().toLowerCase();
    const items = root.querySelectorAll('.faq-item');
    const sections = root.querySelectorAll('.faq-section');

    items.forEach(function (item) {
        item.hidden = query !== '' && !item.textContent.toLowerCase().includes(query);
        if (item.hidden) item.removeAttribute('open');
    });

    sections.forEach(function (section) {
        section.hidden = !Array.from(section.querySelectorAll('.faq-item'))
            .some(function (item) { return !item.hidden; });
    });
});
