
import { MultiSelectionList } from "../../../lib/multiselect";
import { RegisterController } from "./RegisterController";

import RegistrationAutofill from "../../Autofills/RegistrationAutofill";

export const RegisterStep3CategoriesController = {

    categoryList: null,

    name: null,

    btn3: document.getElementById('btn_step3'),

    init(data) {
        this.name = data.name;
        this.changeTexts();
        this.attachEventHandlers();
        this.initMultiSelectionList();

        RegistrationAutofill.fillStep3();
    },

    attachEventHandlers() {
        this.btn3.addEventListener('click', () => this.handleStep3Completion());
    },

    changeTexts() {
        const title = Server.lang.section3title.replace(':name', this.name);
        RegisterController.changeTexts(title, Server.lang.section3subtitle);
    },

    initMultiSelectionList() {
        this.categoryList = new MultiSelectionList(
            'categories_bit',
            () => { this.btn3.disabled = false },
            () => { this.btn3.disabled = true }
        );
    },

    handleStep3Completion() {
        //Form.getFormDataObject(RegisterController.form.id).set()
        RegisterController.switchStep(4, {name: this.name});
    }

};


