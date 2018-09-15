
import { Validate as BunnyValidate } from '../../../../../../../node_modules/bunnyjs/src/bunny.validate.js';
var Validate = Object.create(BunnyValidate);
Validate.lang.required = 'Required';

import { Api } from './../../../../Core/Api';
import { DateSelector } from './../../../../lib/date_selector';
import { GoogleGeo } from './../../../../Components/Geo/Google';
import { SearchAutocomplete } from './../../../../Components/SearchAutocomplete';
import { TagList } from './../../../../Components/TagList';
import { FileUpload } from "../../../../../../../node_modules/bunnyjs/src/form/fileupload";
import { Spinner } from "../../../../lib/spinner";

export var SettingsController = {

    // Buttons
    btnSave: document.getElementById('btn_save'),
    btnCancel: document.getElementById('btn_cancel'),
    btnDisconnectFb: document.getElementById('btn_disconnect_fb'),
    btnDisconnectGoogle: document.getElementById('btn_disconnect_google'),

    // Photo
    imgProfilePhoto: document.getElementById('profile_photo'),
    inpPhotoFile: document.getElementById('photo_file_inp'),
    removePhoto: document.getElementById('remove_photo'),

    inpEmail: document.getElementById('email'),

    categoryDropDown: document.getElementById('category-names'),

    form: document.getElementById('edit_profile_form'),

    geo: GoogleGeo,
    geoOption: {
        nameSelector: 'hometown_name',
        locationSelector:'hometown_location',
        idSelector: 'hometown_id',
        latSelector: 'hometown_lat',
        lngSelector: 'hometown_lng'
    },

    searchInterests: document.getElementById('search_interests'),
    searchLanguages: document.getElementById('search_languages'),

    postData: new FormData(this.form),
    imageBlob: null,

    // Alert
    alertDisconnectSocial: document.getElementById('alert_disconnect_social'),
    btnDisconnSocialCloseAlert: document.getElementById('alert_disconnect_social_close'),
    alertDisconnectSocialText: document.getElementById('alert_disconnect_social_text'),
    msgSetPassword: 'Cannot disconnect until a password set.',
    msgSetEmail: 'Cannot disconnect until an email set.',

    hiddenCalss: 'hidden-xs-up',

    init() {
        // Geo
        this.geo.resolveLocationData(this.geoOption);
        this.geo.init(this, this.geoOption.nameSelector);

        this.interestList = TagList.create('interest_list');
        this.categoryList = TagList.create('categories_bit', (name, id) => this.handleRemoveCategory(name, id));
        this.languageList = TagList.create('language_list');

        this.interestSearch = SearchAutocomplete.create(
            this.searchInterests.getAttribute('id'),
            'interests',
            'format=keyvalue&fields=name&limit=10&like[name]={search}',
            this.interestList
        );

        this.languageSearch = SearchAutocomplete.create(
            this.searchLanguages.getAttribute('id'),
            'languages',
            'format=keyvalue&fields=name&limit=10&like[name]={search}',
            this.languageList,
            false
        );

        DateSelector.create('birth_date');
        Validate.validate(this.form);

        this.attachEventHandlers();
    },

    attachEventHandlers() {
        this.btnSave.addEventListener('click', (e) => this.handleSaveBtnClick(e));
        this.btnCancel.addEventListener('click', () => this.handleCancelBtnClick());
        this.categoryDropDown.addEventListener('change', () => this.handleCategoryDropdownChange());

        // Photo
        this.imgProfilePhoto.addEventListener('click', () => this.inpPhotoFile.click());
        this.removePhoto.addEventListener('click', () => this.handleRemovePhoto());
        FileUpload.attachImagePreviewEvent(this.imgProfilePhoto, this.inpPhotoFile);

        // Social
        if (this.btnDisconnectFb || this.btnDisconnectGoogle) {
            this.btnDisconnSocialCloseAlert.addEventListener('click', (e) => this.handleDisconnSocialCloseAlert(e));
        }
        if (this.btnDisconnectFb) {
            this.btnDisconnectFb.addEventListener('click', () => this.handleDisconnectFbButtonClick());
        }
        if (this.btnDisconnectGoogle) {
            this.btnDisconnectGoogle.addEventListener('click', () => this.handleDisconnectGoogleButtonClick());
        }
    },

    handleDisconnSocialCloseAlert() {
        this.alertDisconnectSocial.classList.add(this.hiddenCalss);
        this.alertDisconnectSocialText.textContent = '';
    },

    handleRemovePhoto() {
        this.inpPhotoFile.value = "";
        this.imgProfilePhoto.src = Server.project.noAvatarImagePath;
    },

    handleRemoveCategory(name, id) {
        let option = document.createElement('option');
        option.text = name;
        option.value = id;
        this.categoryDropDown.appendChild(option);
    },

    handleCategoryDropdownChange(e) {
        let dd = this.categoryDropDown;
        let selectedOption = dd.options[dd.selectedIndex];
        let value = selectedOption.textContent;
        let id = selectedOption.value;

        if (id != '') {
            this.categoryList.addItem(value, id);
            dd.remove(dd.selectedIndex);
        }
    },

    handleSaveBtnClick(e) {

        e.preventDefault();

        if (Validate.validateSection(this.form)) {

            this.postData = FileUpload.addToForm(this.form, this.inpPhotoFile, this.inpPhotoFile.files[0]);

            let req = new XMLHttpRequest();
            req.open("POST", 'api/v1/edit-profile', true);

            req.onload = (e) => {

                Spinner.toggle(this.btnSave);

                if (req.status == 200) {

                    let result = JSON.parse(req.responseText);

                    if (result.status == 'success') {

                        window.location = '/edit-profile'
                    } else {
                        console.log('Edit profile operation failed');
                    }
                } else {
                    console.log('Edit profile operation failed');
                }
            };

            Spinner.toggle(this.btnSave);
            req.send(this.postData);
        } else {
            console.log('Validation failed');
        }
    },

    handleCancelBtnClick() {
        window.location = '/edit-profile';
    },

    handleDisconnectFbButtonClick() {
        this.toggleButton(this.btnDisconnectFb);
    },

    handleDisconnectGoogleButtonClick() {
        this.toggleButton(this.btnDisconnectGoogle);
    },

    handleRemovePhoto() {
        this.inpPhotoFile.value = "";
        this.imgProfilePhoto.src = Server.project.noAvatarImagePath;
    },

    handleRemoveCategory(name, id) {
        let option = document.createElement('option');
        option.text = name;
        option.value = id;
        this.categoryDropDown.appendChild(option);
    },

    toggleButton(button) {

        if (this.inpEmail.value == '' || this.inpEmail.value == null || this.inpEmail.value == 'undefined') {
            this.alertDisconnectSocialText.textContent = this.msgSetEmail;
            this.alertDisconnectSocial.classList.remove(this.hiddenCalss);
        } else {

            let result = Api.get('profile/is-password-empty')
                .then((result) => {

                    if (result.status == 'success') {

                        if (result.data == true) {

                            this.alertDisconnectSocialText.textContent = this.msgSetPassword;
                            this.alertDisconnectSocial.classList.remove(this.hiddenCalss);

                        } else {

                            let hiddenInput = button.parentNode.parentNode.getElementsByTagName('input')[0];
                            hiddenInput.value = (hiddenInput.value == 0) ? 1 : 0;

                            if (button.classList.contains('app-btn-outline-apply')) {
                                button.classList.remove('app-btn-outline-apply');
                                button.classList.add('app-btn-apply');
                            } else {
                                button.classList.remove('app-btn-apply');
                                button.classList.add('app-btn-outline-apply');
                            }
                            button.blur();

                        }
                    }

                })
                .catch((error) => {
                    console.log(result);
                });
        }
    }
};
