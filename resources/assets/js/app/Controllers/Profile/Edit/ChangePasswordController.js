
import { Alert } from './../../../../lib/alert';

import { Validate as BunnyValidate } from '../../../../../../../node_modules/bunnyjs/src/bunny.validate.js';
var Validate = Object.create(BunnyValidate);
Validate.lang.required = 'Required';

import { Spinner } from "../../../../lib/spinner";

export var ChangePasswordController = {

    btnChangePassword: document.getElementById('btn_change_password'),
    form: document.getElementById('change_password_form'),

    inpCurrPassword: document.getElementById('old_password'),
    inpNewPassword: document.getElementById('password'),
    inpConfirmPassword: document.getElementById('password_confirmation'),

    changePwdSuccess: document.getElementById('change_pwd_success'),

    alertId: 'alert',
    hiddenClass: 'hidden-xs-up',

    msgPasswordNotMatch: 'The password confirmation does not match.',

    init() {
        this.attachEventHandlers();
    },

    attachEventHandlers() {
        this.btnChangePassword.addEventListener('click', (e) => this.handleChangePassword(e));
    },

    handleChangePassword(e) {

        this.hideAllMessages();

        if (Validate.validateSection(this.form)) {

            if (! this.validatePasswordMatching()) {
                new Alert(this.alertId, this.msgPasswordNotMatch).insert();
            } else {

                e.preventDefault();
                Spinner.toggle(this.btnChangePassword);

                let req = new XMLHttpRequest();

                req.open("POST", 'api/v1/change-password', true);

                req.onload = (e) => {

                    if (req.status == 200) {

                        Spinner.toggle(this.btnChangePassword);

                        let result = JSON.parse(req.responseText);

                        if (result.status == 'success') {

                            this.showSuccessMsg();
                            this.hideSubmitButton();
                            console.log('Password changed.');

                        } else {
                            new Alert(this.alertId, result.data).insert();
                        }
                    } else {
                        console.log('Change password operation failed.');
                    }
                };

                req.send(new FormData(this.form));

            }

        } else {
            console.log('Validation failed');
        }
    },

    hideAllMessages() {
        Alert.remove(this.alertId);

        if (! this.changePwdSuccess.classList.contains(this.hiddenClass)) {

            this.changePwdSuccess.classList.add(this.hiddenClass);
        }
    },

    showSuccessMsg() {
        this.changePwdSuccess.classList.remove(this.hiddenClass);
    },

    hideSubmitButton() {
        if (! this.btnChangePassword.classList.contains(this.hiddenClass)) {
            this.btnChangePassword.classList.add(this.hiddenClass);
        }
    },

    validatePasswordMatching() {
        if(this.inpNewPassword.value != this.inpConfirmPassword.value) {

            this.inpConfirmPassword.setCustomValidity("Passwords Don't Match");
            return false;
        } else {

            this.inpConfirmPassword.setCustomValidity('');
            return true;
        }
    }
}
