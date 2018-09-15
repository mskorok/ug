
import Form from "bunnyjs/src/form/form";
import { Ajax } from "bunnyjs/src/bunny.ajax";

import { RegisterController } from './RegisterController';

import { Facebook } from './../../../Components/Facebook';
import { GoogleProfile } from './../../../Components/Geo/Google';
import { Alert } from './../../../lib/alert';

import RegistrationAutofill from '../../Autofills/RegistrationAutofill';


export const RegisterStep1Controller = {

    emailAlertId: 'email_alert',

    emailInput: document.getElementById('email'),
    passwordInput: document.getElementById('password'),

    fbBtn: document.getElementById('btn_fb'),
    googleBtn: document.getElementById('btn_google'),
    emailBtn: document.getElementById('btn_email'),

    init() {
        Facebook.init();
        this.attachEventHandlers();

        //this.test();
        RegistrationAutofill.fillStep1();
    },

    test() {
        Form.set(RegisterController.form.id, this.emailInput.name, 'test.registration@gmail.com');
        Form.set(RegisterController.form.id, this.passwordInput.name, '12345678');
        this.emailBtn.click();
    },

    attachEventHandlers() {
        // step1
        this.fbBtn.addEventListener('click', () => this.handleStep1Fb());
        this.googleBtn.addEventListener('click', () => this.handleStep1Google());
        this.emailBtn.addEventListener('click', () => this.handleStep1Email());
    },

    clearEmailAndPassword() {
        Form.set(RegisterController.form.id, this.emailInput.name, '');
        Form.set(RegisterController.form.id, this.passwordInput.name, '');
        //this.emailInput.value = '';
        //this.passwordInput.value = '';
    },

    showEmailAlert(message) {
        new Alert(this.emailAlertId, message).insert();
    },

    // Facebook

    handleStep1Fb() {
        //Spinner.toggle(this.fbBtn);
        this.clearEmailAndPassword();
        Facebook.getProfileData(
            (data) => this.handleFbProfileData(data),
            () => {} // () => Spinner.toggle(this.fbBtn)
        );
    },

    handleFbProfileData(profile) {
        this.linkToExistingAccount(profile, (profile) => { this.completeFbStep1(profile) });
    },

    completeFbStep1(socialData) {
        FB.api('/me/picture?redirect=false&width=500&height=500', (response) => {
            socialData.image = response.data.url;

            this.completeStep1(socialData);
        });

        //Spinner.toggle(this.fbBtn);
    },

    // Google

    handleGoogleClientLoad() {

        GoogleProfile.handleClientLoad();
    },

    handleStep1Google() {
        //Spinner.toggle(this.googleBtn);
        GoogleProfile.login((authResult) => this.handleGoogleLoginResult(authResult));
        //Spinner.toggle(this.googleBtn);
    },

    handleGoogleLoginResult(googleUser) {

        GoogleProfile.getData(googleUser, (data) => this.handleGoogleProfileData(data));
    },

    handleGoogleProfileData(profile) {
        this.linkToExistingAccount(profile, (profile) => { this.completeStep1(profile) });
    },

    // Email

    handleStep1Email() {
        //Spinner.toggle(this.signupEmail);
        if (RegisterController.validateStep(1)) {
            this.checkEmail(() => this.handleEmailCheckSuccess(), () => this.handleEmailCheckFailure());
        }
    },

    checkEmail(successCallback, failureCallback) {

        Ajax.get('/api/v1/users/check-email/' + Form.get(RegisterController.form.id, this.emailInput.name),
            (data) => {
                var res = JSON.parse(data);

                if (res.status === 'success') {
                    successCallback();
                } else {
                    failureCallback();
                }
            }
        );
    },

    handleEmailCheckSuccess() {
        //this.emailStep2.value = this.email.value;
        RegisterController.switchStep(2);
        //Spinner.toggle(this.signupEmail);
    },

    handleEmailCheckFailure() {
        this.showEmailAlert(Server.lang.alertEmailTaken);
    },

    //

    linkToExistingAccount(profile, failureCallback) {

        let formData = new FormData();
        formData.append('provider', profile.provider);
        formData.append('token', profile.token);
        let req = new XMLHttpRequest();

        req.open("POST", `/api/v1/social-login`, true);

        req.onload = (e) => {
            if (req.status == 200) {

                //document.body.innerHTML = req.responseText
                let result = JSON.parse(req.responseText);

                if (result.status == 'success') {
                    // If there already exists an account with such email
                    // then skip registration
                    window.location = Server.app.webRedirectTo;
                } else {
                    // Continue registration
                    failureCallback(profile);
                }
            } else {
                console.log('Fail to link to existing account.');
                //document.open()
                //document.write(req.responseText)
                //document.close()
                failureCallback(profile);
            }
        };

        req.send(formData);
    },

    completeStep1(socialData) {
        RegisterController.switchStep(2, socialData);
    },
};
