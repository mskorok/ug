
import { Dropdown } from 'bunnyjs/src/bunny.dropdown';

export default Search = {

    _overlay: null,
    _searchId: 'navbar_search', // dropdown container
    _inputId: 'navbar_search_input',

    init() {
        this._attachEventListeners();
    },

    _attachEventListeners() {
        /*this.getSearchInput().addEventListener('focus', () => {
            this.showSearch();
        });
        this.getSearchInput().addEventListener('blur', () => {
            this.hideSearch();
        });*/
        if (this.getSearchInput() !== null) {
            this.getSearchInput().addEventListener('open', () => {
                this._showOverlay();
            });
            this.getSearchInput().addEventListener('close', () => {
                this._hideOverlay();
            });
        }
    },

    getSearch() {
        return document.getElementById(this._searchId);
    },

    getSearchInput() {
        return document.getElementById(this._inputId);
    },

    showSearch() {
        this.getSearch().classList.add('open');
        this._showOverlay();
    },

    hideSearch() {
        this.getSearch().classList.remove('open');
        this._hideOverlay();
    },

    _showOverlay() {
        const el = document.createElement('div');
        el.classList.add('app-overlay');
        this._overlay = el;
        document.body.appendChild(el);
    },

    _hideOverlay() {
        document.body.removeChild(this._overlay);
    }

};
