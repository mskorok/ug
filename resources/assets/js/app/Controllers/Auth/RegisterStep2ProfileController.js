
import { Checkbox } from "bunnyjs/src/form/checkbox";
import { Radio } from "bunnyjs/src/form/radio";
import { DatePicker } from "bunnyjs/src/bunny.datepicker";
import { CalendarDate } from "bunnyjs/src/bunny.calendar";
import Form from "bunnyjs/src/form/form";

import { GoogleGeo } from './../../../Components/Geo/Google';

import { RegisterController } from "./RegisterController";
import { RegisterStep2PhotoController } from "./RegisterStep2PhotoController";
import RegistrationAutofill from "../../Autofills/RegistrationAutofill";


export const RegisterStep2ProfileController = {

    nameInput: document.getElementById('name'),
    socialIdInput: document.getElementById('social_id'),
    socialProviderInput: document.getElementById('social_provider'),

    birthDay: document.getElementById('birth_day'),
    birthMonth: document.getElementById('birth_month'),
    birthYear: document.getElementById('birth_year'),
    birthDate: document.getElementById('birth_date'),

    genderInputName: 'gender_sid',

    locale: document.getElementById('locale'),
    btn2: document.getElementById('btn_step2'),

    categoryList: null,

    options: {
        geoOption: {
            nameSelector: 'hometown_name',
            locationSelector:'place_location',
            idSelector: 'place_id',
            latSelector: 'location_lat',
            lngSelector: 'location_lng',
            countrySelector: 'country_name'
        }
    },

    init(data) {
        this.changeTexts();
        this.putSocialDataToDom(data);
        this.attachEventHandlers();
        GoogleGeo.init(this.options);
        this.initCustomUIElements();
        RegisterStep2PhotoController.init();

        RegistrationAutofill.fillStep2();
    },

    attachEventHandlers() {
        //this.btnAddPhoto.addEventListener('click', () => this.photoInput.click());
        this.birthMonth.addEventListener('change', () => this.refreshDayList());
        this.birthYear.addEventListener('change', () => this.refreshDayList());
        this.btn2.addEventListener('click', () => this.handleStep2Completion());
    },

    changeTexts() {
        RegisterController.changeTexts(Server.lang.section2title, Server.lang.section2subtitle);
    },

    initCustomUIElements() {
        Checkbox.create('checkbox', 'app-auth-checkbox', 'checked');
        Radio.create('gender', 'app-auth-radio', 'checked');
    },

    /**
     * Putts Social data to DOM and switches to step 2
     * @param social_data
     */
    putSocialDataToDom(social_data) {

        if (social_data.id !== undefined) {
            Form.set(RegisterController.form.id, this.socialIdInput.name, social_data.id);
            //this.socialIdInput.value = social_data.id;
        }

        if (social_data.provider !== undefined) {
            Form.set(RegisterController.form.id, this.socialProviderInput.name, social_data.provider);
            //this.socialProviderInput.value = social_data.provider;
        }

        if (social_data.locale !== undefined) {
            Form.set(RegisterController.form.id, this.locale.name, social_data.locale);
            //this.locale.value = social_data.locale;
        }

        if (social_data.email !== undefined) {
         RegisterController.setEmail(social_data.email);
        }

        if (social_data.first_name !== undefined) {
            Form.set(RegisterController.form.id, this.nameInput.name, social_data.first_name);
            //this.firstNameInput.value = social_data.first_name;
        }

        if (social_data.last_name !== undefined) {
            Form.set(RegisterController.form.id, this.nameInput.name, social_data.first_name + ' ' + social_data.last_name);
            //this.lastNameInput.value = social_data.last_name;
        }

        if (social_data.gender !== undefined) {

            if (social_data.gender === 'male') {
                Form.set(RegisterController.form.id, this.genderInputName, '1');
                //this.male.checked = true;
            } else {
                //this.female.checked = true;
                Form.set(RegisterController.form.id, this.genderInputName, '2');
            }
        }

        if (social_data.birthday !== undefined) {
            const date = new Date(social_data.birthday);

            this.birthDate.value = DatePicker.getISODateFromDateParts(
                date.getFullYear(), date.getMonth(), date.getDate()
            );

            //this.birthDate.value = date.toISOString();
            this.birthDay.value = date.getDate();
            this.birthMonth.value = date.getMonth() + 1;
            this.birthYear.value = date.getFullYear();
            this.refreshDayList();
        }

        // initFromUrl must be last
        if (social_data.image !== undefined) {
            RegisterStep2PhotoController.initFromUrl(social_data.image);
        }

    },

    refreshDayList() {
        const days = CalendarDate.getDaysInMonth(this.birthYear.value, this.birthMonth.value);
        let ddDays = this.birthDay;
        let value = ddDays.value;

        ddDays.options.length = 1;  // Remove all options

        for (let i=1; i <= days; i++) {
            let selected = i == value ? true : false;
            ddDays.options[ddDays.options.length] = new Option(i, i, false, selected);
        }
    },

    refreshDate() {

        let date = new Date(
            this.birthYear.value,
            this.birthMonth.value - 1,
            this.birthDay.value
        );

        this.birthDate.value = DatePicker.getISODateFromDateParts(
            date.getFullYear(), date.getMonth(), date.getDate()
        );

        //this.birthDate.value = date.toISOString();
    },

    /**
     * Returns number of days in month tking into account leap years
     * @param month - 0-12
     * @param year - YYYY
     * @returns {number}
     */
    /*daysInMonth(month, year) {

        month = parseInt(month)

        if (month == null) {
            return 31;
        }

        switch (month) {
            case 2 :

                if (year == null) {
                    return 29;
                }
                return (year % 4 == 0 && year % 100) || year % 400 == 0 ? 29 : 28;
            case 4 : case 6 : case 9 : case 11 :
            return 30;
            default :
                return 31;
        }
    },*/

    handleStep2Completion() {
        if (RegisterController.validateStep(2)) {
            this.refreshDate();
            /*RegisterController.postData = FileUpload.addToForm(
                RegisterController.form,
                this.photoInput.name,
                RegisterStep2PhotoController.imageBlob
            );*/
            RegisterController.switchStep(3, {name: this.nameInput.value});
        }
    }

};
