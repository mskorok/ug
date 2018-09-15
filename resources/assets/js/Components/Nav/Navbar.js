
//import { Autocomplete } from 'bunnyjs/src/bunny.autocomplete';
import Search from '../../Components/Nav/Search';

export const Navbar = {

    el: document.getElementById('navbar'),
    mobileEl: document.getElementById('navbar-mobile'),
    overlayEl: null,

    mobileActiveClass: 'active',
    mobileOverlayClass: 'app-overlay',
    mobileOverlayId: 'navbar_mobile_overlay',
    mobileHamburgerSelector: '[data-id="navbar-hamburger"]',

    init() {
        this.attachHamburgerClickEvent();
        this.initSearch();
    },

    getHeight()
    {
        return this.el.clientHeight;
    },

    toggleMobileNav()
    {
        this.mobileEl.classList.toggle(this.mobileActiveClass);
        this.toggleMobileOverlay();
    },

    toggleMobileOverlay()
    {
        if (this.overlayEl === null) {
            this.overlayEl = document.createElement('div');
            this.overlayEl.id = this.mobileOverlayId;
            this.overlayEl.classList.add(this.mobileOverlayClass);
            document.body.appendChild(this.overlayEl);
            this.attachMobileOverlayClickEvent(this.overlayEl);
        } else {
            document.body.removeChild(this.overlayEl);
            this.overlayEl = null;
        }
    },

    attachMobileOverlayClickEvent(overlay_el) {
        overlay_el.addEventListener('click', () => {
            this.toggleMobileNav();
        });
    },

    attachHamburgerClickEvent() {
        document.querySelectorAll(this.mobileHamburgerSelector).forEach((hamburger) => {
            hamburger.addEventListener('click', (e) => {
                e.preventDefault();
                this.toggleMobileNav();
            });
        });
    },

    initSearch() {
        Search.init();
        //Autocomplete.create('navbar_search', null, '/api/v1/interests/?format=keyvalue&fields=name&limit=10&like[name]={search}');
    }

};
