
import { Validate as BunnyValidate } from '../../../../../../../node_modules/bunnyjs/src/bunny.validate.js';
var Validate = Object.create(BunnyValidate);
Validate.lang.required = 'Required';

export var DeactivateAccountController = {

    linkDeactivate: document.getElementById('deactivate'),
    form: document.getElementById('deactivate_form'),

    alertSuccess: document.getElementById('success_alert'),
    alertError: document.getElementById('deactivation_error_alert'),

    hiddenClass: 'hidden-xs-up',

    init() {
        this.attachEventHandlers();
    },

    attachEventHandlers() {
        if (this.linkDeactivate != null) {
            this.linkDeactivate.addEventListener('click', (e) => this.handleDeactivateClick(e));
        }
    },

    handleDeactivateClick(e) {

        e.preventDefault();
        this.hideAllMessages();

        if (Validate.validateSection(this.form)) {

            let req = new XMLHttpRequest();

            req.open("POST", 'api/v1/deactivate-account', true);

            req.onload = (e) => {

                if (req.status == 200) {

                    let result = JSON.parse(req.responseText);

                    if (result.status == 'success') {

                        this.showSuccessMsg();
                        //console.log(req.responseText);

                    } else {
                        //console.log(req.responseText);
                        this.showErrorMsg(result.data);
                    }
                } else {
                    this.showErrorMsg('Deactivation failed.');
                    //console.log(req.responseText);
                    console.log('Deactivation failed.');
                }
            };

            req.send(new FormData(this.form));

        } else {
            console.log('Validation failed');
        }
    },

    hideAllMessages() {
        if (! this.alertError.classList.contains(this.hiddenClass)) {

            this.alertError.classList.add(this.hiddenClass);
        }

        if (! this.alertSuccess.classList.contains(this.hiddenClass)) {

            this.alertSuccess.classList.add(this.hiddenClass);
        }
    },

    showSuccessMsg() {
        this.alertSuccess.classList.remove(this.hiddenClass);
    },

    showErrorMsg(msg) {
        this.alertError.textContent = msg;
        this.alertError.classList.remove(this.hiddenClass);
    }
}
