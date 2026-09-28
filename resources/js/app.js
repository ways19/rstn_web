import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;
window.lucide = { createIcons, icons };

document.addEventListener('DOMContentLoaded', () => {
    createIcons({ icons });
});

Alpine.start();
