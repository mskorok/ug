import { Validate as BunnyValidate } from 'bunnyjs/src/bunny.validate';
import { Checkbox } from 'bunnyjs/src/form/checkbox';
import { GoogleProfile } from './../../Components/Geo/Google';
import { Facebook } from './../../Components/Facebook';
import { Alert } from './../../lib/alert';
//import { Spinner } from './../../lib/spinner';

var Validate = Object.create(BunnyValidate);
Validate.lang.required = 'Required';

export var LoginController = {

    fbBtn: document.getElementById('btn_fb'),
    googleBtn: document.getElementById('btn_google'),
    emailAlertId: 'email_alert',
    socialAlertId: 'social_alert',
    fbName: 'Facebook',
    googleName: 'Google',
    socialLoginFailedMsg: "Failed to login with :provider account.",


    index: function () {
        Facebook.init();
        Checkbox.create('checkbox', 'app-auth-checkbox', 'checked');
        this.attachEventHandlers();
    },

    // Events

    attachEventHandlers() {
        this.fbBtn.addEventListener('click', () => this.handleFbLogin());
        this.googleBtn.addEventListener('click', () => this.handleGoogleLogin());
    },

    // Facebook

    handleFbLogin () {

        //Spinner.toggle(this.fbBtn);
        this.hideAlerts();
        Facebook.login(
            (profile) => this.handleSocialLoginResult(profile, this.fbName),
            () => this.handleFbLoginFailure()
        );
    },

    handleFbLoginFailure() {
        console.log('Facebook authentication failed.');
        //Spinner.toggle(this.fbBtn);
    },

    // Google

    handleGoogleLogin () {

        //Spinner.toggle(this.googleBtn);
        this.hideAlerts();

        GoogleProfile.login(
            (user) => GoogleProfile.getData(user, (profile) => this.handleSocialLoginResult(profile, this.googleName)),
            () => {} //() => Spinner.toggle(this.fbBtn)
        )
    },

    //

    handleSocialLoginResult(profile, providerName) {

        let formData = new FormData();
        formData.append('provider', profile.provider);

        if (profile.hasOwnProperty('token')) {
            formData.append('token', profile.token);
        }

        let req = new XMLHttpRequest();

        req.open("POST", `/api/v1/social-login`, true);

        req.onload = () => {

            if (providerName == this.fbName) {
                //Spinner.toggle(this.fbBtn);
            } else {
                //Spinner.toggle(this.googleBtn);
            }

            if (req.status == 200) {
                //document.body.innerHTML = req.responseText
                let result = JSON.parse(req.responseText);

                if (result.status == 'success') {
                    // If there already exists an account with such email
                    // then skip registration
                    window.location = Server.app.webRedirectTo;
                } else {
                    this.showSocialAlert(result.message);
                }
            } else {
                this.showSocialAlert(this.socialLoginFailedMsg.replace(':provider', providerName));
            }
        };

        req.send(formData);
    },

    showSocialAlert(message) {
        new Alert(this.socialAlertId, message).insert();
    },

    hideAlerts() {
        Alert.hide(this.emailAlertId);
        Alert.remove(this.socialAlertId);
    }
};