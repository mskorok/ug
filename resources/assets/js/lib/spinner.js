
export var Spinner = {

    _class: 'app-spinner',

    _get(btn_el_or_id) {
        return (typeof btn_el_or_id === 'object') ? btn_el_or_id : document.getElementById(btn_el_or_id);
    },

    _getSpinner(btn_el) {
        var spinner = btn_el.getElementsByClassName(this._class)[0];
        if (spinner === undefined) {
            return false;
        }
        return spinner;
    },

    _createSpinner() {
        var spinner = document.createElement('div');
        spinner.classList.add(this._class);
        return spinner;
    },

    add(btn_el_or_id) {
        var btn = this._get(btn_el_or_id);
        var spinner = this._getSpinner(btn);
        if (spinner === false) {
            this._add(btn, spinner);
        }
    },

    _add(btn, spinner) {
        spinner = this._createSpinner();
        btn.insertBefore(spinner, btn.firstChild);
        btn.setAttribute('disabled', 'disabled');
    },

    remove(btn_el_or_id) {
        var btn = this._get(btn_el_or_id);
        var spinner = this._getSpinner(btn);
        if (spinner !== false) {
            this._remove(btn, spinner);
        }
    },

    _remove(btn, spinner) {
        btn.removeChild(spinner);
        btn.blur();
        btn.removeAttribute('disabled');
    },

    toggle(btn_el_or_id) {
        var btn = this._get(btn_el_or_id);
        var spinner = this._getSpinner(btn);
        if (spinner === false) {
            this._add(btn, spinner);
        } else {
            this._remove(btn, spinner);
        }
    }

};
