
import simulateAutocompleteSelect from 'bunnyjs/src/utils/UI/simulateAutocompleteSelect';
import { Url } from 'bunnyjs/src/bunny.url';

import { RegisterStep1Controller } from '../Controllers/Auth/RegisterStep1Controller';
import { RegisterStep2ProfileController } from '../Controllers/Auth/RegisterStep2ProfileController';
import { RegisterStep3CategoriesController } from '../Controllers/Auth/RegisterStep3CategoriesController';
import { RegisterStep4InterestsController } from '../Controllers/Auth/RegisterStep4InterestsController';

export default RegistrationAutofill = {

    fillStep1() {
        if (Url.getQueryParam('test') >= 1) {
            RegisterStep1Controller.emailInput.value = 'test_' + '1234' + '@urlaubsgluck.local';
            RegisterStep1Controller.passwordInput.value = '12345678';
            RegisterStep1Controller.emailBtn.click();
        }
    },

    fillStep2() {
        if (Url.getQueryParam('test') >= 2) {
            RegisterStep2ProfileController.nameInput.value = 'John';

            const hometown_input = document.getElementsByName(
                RegisterStep2ProfileController.options.geoOption.nameSelector
            )[0];

            RegisterStep2ProfileController.birthDay.value = 1;
            RegisterStep2ProfileController.birthMonth.value = 1;
            RegisterStep2ProfileController.birthYear.value = 1980;

            simulateAutocompleteSelect(hometown_input, 'Berlin')
                .then(() => {
                    RegisterStep2ProfileController.btn2.click();
                });
        }
    },

    fillStep3() {
        if (Url.getQueryParam('test') >= 3) {
            setTimeout(() => {
                document.getElementById('categories_bit').firstElementChild.click();
                setTimeout(() => {
                    RegisterStep3CategoriesController.btn3.click();
                }, 800);
            }, 800);
        }
    },

    fillStep4() {
        if (Url.getQueryParam('test') >= 4) {
            setTimeout(() => {
                const search = document.getElementById('search');
                simulateAutocompleteSelect(search, 'Ta');
                setTimeout(() => {
                    //document.getElementById('categories_bit').firstElementChild.click();
                }, 800);
            }, 800);
        }
    }

}

/*window.onerror = function (errorMsg, url, lineNumber, column, errorObj) {
    alert('Error: ' + errorMsg + "\n\n" + ' Script: ' + url + "\n\n" + ' Line: ' + lineNumber
        + "\n\n" + ' Column: ' + column + "\n\n" + ' StackTrace: ' + errorObj)
};*/
