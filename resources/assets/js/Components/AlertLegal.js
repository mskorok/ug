
export const AlertLegal = {

    el: document.getElementById('alert_legal'),
    closeEl: document.getElementById('alert_legal_close'),

    closedKey: 'app_legal_closed',

    removeFromDOM() {
        document.body.removeChild(this.el);
    },

    storeClosed() {
        const d = new Date();
        d.setFullYear(d.getFullYear() + 1);
        document.cookie = this.closedKey + '=1; expires=' + d.toUTCString() + '; path=/';
    },

    close() {
        this.storeClosed();
        this.removeFromDOM();
    },

    attachCloseEvent() {
        this.closeEl.addEventListener('click', () => {
            this.close();
        })
    },

    init() {
        if (this.el !== null) {
            this.attachCloseEvent();
        }
    }

};
