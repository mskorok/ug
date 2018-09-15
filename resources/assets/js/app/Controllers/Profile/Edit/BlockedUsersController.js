
export var BlockedUsersController = {

    formsUnblockUser: document.getElementsByClassName('unblock-user-form'),

    init() {
        this.attachEventHandlers();
    },

    attachEventHandlers() {

        this.formsUnblockUser.forEach((i) => {
            i.addEventListener('submit', (e) => this.handleUnblockSubmit(e));
            Form.init(i.getAttribute('id'));
        });
    },

    handleUnblockSubmit(e) {

        let el = e.target;
        e.preventDefault();

        let req = new XMLHttpRequest();

        req.open("POST", 'api/v1/profile/unblock-user', true);

        req.onload = (e) => {

            if (req.status == 200) {

                let result = JSON.parse(req.responseText);

                if (result.status == 'success') {

                    let parent = el.parentNode;
                    parent.removeChild(el);

                } else {
                    console.log(result);
                }
            } else {
                console.log('Unblock operation failed.')
            }
        };

        let formId = e.target.getAttribute('id');
        req.send(Form.getFormDataObject(formId));
    }
}
