import { initQuillEditors } from "./quill";

/*
|--------------------------------------------------------------------------
| Mobile Navigation
|--------------------------------------------------------------------------
*/

const menuButton = document.querySelector("[data-mobile-menu-button]");
const mobileMenu = document.querySelector("[data-mobile-menu]");

if (menuButton && mobileMenu) {
    menuButton.addEventListener("click", () => {
        const isHidden = mobileMenu.classList.toggle("hidden");
        const isOpen = !isHidden;

        menuButton.setAttribute("aria-expanded", String(isOpen));
        menuButton.setAttribute(
            "aria-label",
            isOpen ? "Close navigation menu" : "Open navigation menu",
        );
    });
}

/*
|--------------------------------------------------------------------------
| Quill Initiation
|--------------------------------------------------------------------------
*/

document.addEventListener("DOMContentLoaded", () => initQuillEditors());

// Opsional: dipanggil manual untuk konten dinamis (modal, AJAX, dll.)
window.initQuillEditors = initQuillEditors;
