
import { Decorator } from './../Decorators/RefreshUserDecorator';
import { Lib } from './../Lib/Lib';

export var RefreshUserListener = {

    prefix: Server.project.apiPrefix,
    userDataUrl: '/users/userId/',
    autocompleteSelectEvent: 'awesomplete-selectcomplete',
    selector: 'user_autocomplete',
    decorator: Decorator.refreshUserDecorator,

    addRefreshEventListeners() {
        var self = this;
        let el = document.getElementById(this.selector);
        if(el) {
            el.addEventListener('blur', function () {
               Lib.refresh(self);
            });
            el.addEventListener(self.autocompleteSelectEvent, function () {
                Lib.refresh(self);
            });
        }
    }
};
