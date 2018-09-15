
import Form from "bunnyjs/src/form/form";

import { UserInterests } from "../../../lib/user_interests";
import { RegisterController } from "./RegisterController";
import { Spinner } from "../../../lib/spinner";

import RegistrationAutofill from "../../Autofills/RegistrationAutofill";


export const RegisterStep4InterestsController = {

    btnFinish: document.getElementById('btn_finish'),

    name: null,

    init(data) {
        UserInterests.create('user-intrests');
        this.attachEventHandlers();
        this.name = data.name;
        this.changeTexts();
        RegistrationAutofill.fillStep4();
    },

    changeTexts() {
        const title = Server.lang.section4title.replace(':name', this.name);
        RegisterController.changeTexts(title, Server.lang.section4subtitle);
    },

    attachEventHandlers() {
        this.btnFinish.addEventListener('click', (e) => this.handleRegFormSubmit(e));
    },

    handleRegFormSubmit(e) {

        Spinner.toggle(this.btnFinish);

        console.log(Form.getFormDataObject(RegisterController.form.id));

        if (RegisterController.validateStep(4)) {
            
            let req = new XMLHttpRequest();

            req.open("POST", 'api/v1/register', true);
            req.setRequestHeader('X-Requested-With','XMLHttpRequest' );
            req.onload = (e) => {

                if (req.status == 200) {

                    let result = JSON.parse(req.responseText);

                    if (result.status == 'success') {
                        // If there already exists an account with such email
                        // then skip registration
                        redirect(Server.app.webRedirectTo);
                    } else if (result.status == 'registered') {
                        redirect('/login');
                    } else {
                        Spinner.toggle(this.btnFinish);
                        RegisterController.showFormAlert('Registration failed. Please try once more.');
                        console.log(result);
                    }
                } else {
                    Spinner.toggle(this.btnFinish);
                    document.open();
                    document.write(req.responseText);
                    document.close();
                    //console.log(req.responseText)
                }
            };

            req.send(Form.getFormDataObject(RegisterController.form.id));
            e.preventDefault();
        }
    }

};
