
import { Checkbox } from "../../../../../../../node_modules/bunnyjs/src/form/checkbox";
import { Spinner } from "../../../../lib/spinner";

export var NotificationsController = {

    form: document.getElementById('profile_notifications_form'),

    btnSave: document.getElementById('btn_save_notifications'),
    btnCancel: document.getElementById('btn_cancel_notifications'),

    hiddenClass: 'hidden-xs-up',

    init() {
        this.attachEventHandlers();
    },

    attachEventHandlers() {
        this.btnSave.addEventListener('click', (e) => this.handleSaveClick(e));
        this.btnCancel.addEventListener('click', (e) => this.handleCancelClick(e));
    },

    handleCheckBoxClick(e) {

    },

    handleSaveClick(e) {

        Spinner.toggle(this.btnSave);

        let req = new XMLHttpRequest();

        req.open("POST", 'api/v1/profile-notifications', true);

        req.onload = (e) => {

            if (req.status == 200) {

                Spinner.toggle(this.btnSave);

                let result = JSON.parse(req.responseText);

                if (result.status == 'success') {

                    console.log(req.responseText);

                } else {
                    console.log(req.responseText);
                }
            } else {
                console.log(req.responseText);
                console.log('Notification saving failed.');
            }
        };

        req.send(new FormData(this.form));
    },

    handleCancelClick(e) {

        window.location = '/edit-profile';
    }
}
