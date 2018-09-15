
import { Element } from 'bunnyjs/src/bunny.element';

export default ScrollToTop = {

    id: 'scroll_top',

    init() {
        this._attachEventListeners();
    },

    getBtn() {
        return document.getElementById(this.id);
    },

    scrollTop() {
        Element.scrollTo(document.body);
    },




    _attachEventListeners() {
        const btn = this.getBtn();
        if (btn !== null) {
            btn.addEventListener('click', () => {
                this.scrollTop();
            });
        }
    }

};
