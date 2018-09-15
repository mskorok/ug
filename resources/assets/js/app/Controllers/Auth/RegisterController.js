
import { Validate as BunnyValidate } from 'bunnyjs/src/bunny.validate';
import { Element } from 'bunnyjs/src/bunny.element';
import Form from 'bunnyjs/src/form/form';

import './../../Events/StyleSelectPlaceholder';

import { RegisterStep1Controller } from './RegisterStep1Controller';
import { RegisterStep2ProfileController } from './RegisterStep2ProfileController';
import { RegisterStep3CategoriesController } from './RegisterStep3CategoriesController';
import { RegisterStep4InterestsController } from './RegisterStep4InterestsController';
import { Alert } from "../../../lib/alert";

var Validate = Object.create(BunnyValidate);
Validate.lang.required = 'Required';

export const RegisterController = {

    hiddenClass: 'hidden-xs-up',

    formAlertId: 'form_alert',

    form: document.getElementById('reg_form'),
    footer: document.getElementById('auth_footer'),
    title: document.getElementById('auth_title'),
    subTitle: document.getElementById('auth_subtitle'),
    emailInput: document.getElementById('email'),

    sections: {
        1: document.getElementById('step1'),
        2: document.getElementById('step2'),
        3: document.getElementById('step3'),
        4: document.getElementById('step4')
    },

    controllers: {
        1: RegisterStep1Controller,
        2: RegisterStep2ProfileController,
        3: RegisterStep3CategoriesController,
        4: RegisterStep4InterestsController
    },

    //postData: new FormData(this.form),


    // route methods
    index() {
        Form.init(this.form.id);
        RegisterStep1Controller.init();
    },

    /**
     * Switch current step to next step and pass data to next step (optional)
     * Hides current step, shows next step, runs init() method in next step's controller
     * Scrolls window to header
     * @param new_step_nr > 1
     * @param {object} data
     */
    switchStep(new_step_nr, data = {}) {
        this.sections[new_step_nr - 1].classList.add(this.hiddenClass);
        this.sections[new_step_nr].classList.remove(this.hiddenClass);
        this.controllers[new_step_nr].init(data);
        Element.scrollTo(this.title);
    },

    /**
     * Validate step
     * @param {number} current_step_nr
     * @returns {bool}
     */
    validateStep(current_step_nr) {
        return Validate.validateSection(this.sections[current_step_nr]);
    },

    /**
     * Change texts (title, subtitle, footer HTML)
     * @param {string} title
     * @param {string} subtitle
     * @param {string} footer_html
     */
    changeTexts(title = '', subtitle = '', footer_html = '') {
        this.title.textContent = title;
        this.subTitle.textContent = subtitle;
        this.footer.innerHTML = footer_html;
    },


    showFormAlert(message) {
        new Alert(this.formAlertId, message).insert();
    },

    setEmail(email) {
        Form.set(this.form.id, this.emailInput.name, email);
        //this.emailInput.value = email;
    }
    
};
