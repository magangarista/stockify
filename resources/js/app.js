import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.store('sidebar', {
        open: window.innerWidth >= 1024, // default: terbuka di desktop, tertutup di mobile

        toggle() {
            this.open = !this.open;
        },

        close() {
            this.open = false;
        }
    });
});

Alpine.start();
import 'flowbite';