
import { DatePicker } from 'bunnyjs/src/bunny.datepicker';

export var DateSelector = {

    attachEventHandlers() {
        this.month.addEventListener('change', () => this.refreshDayList());
        this.year.addEventListener('change', () => this.refreshDayList());
    },

    create(elementId) {
        this.elementId = elementId;

        this.day = document.querySelector('#' + this.elementId + ' .app-day-input');
        this.month = document.querySelector('#' + this.elementId + ' .app-month-input');
        this.year = document.querySelector('#' + this.elementId + ' .app-year-input');
        this.date = document.querySelector('#' + this.elementId + ' .app-date-input');

        this.attachEventHandlers();

        return this;
    },

    setDate(date) {

        date = new Date(date);

        this.date.value = DatePicker.getISODateFromDateParts(
            date.getFullYear(), date.getMonth(), date.getDate()
        );

        this.day.value = date.getDate();
        this.month.value = date.getMonth() + 1;
        this.year.value = date.getFullYear();
        this.refreshDayList();
    },

    refreshDayList() {
        let days = this.daysInMonth(this.month.value, this.year.value);
        let ddDays = this.day;
        let value = ddDays.value;

        ddDays.options.length = 1;  // Remove all options

        for (let i=1; i <= days; i++) {
            let selected = i == value ? true : false;
            ddDays.options[ddDays.options.length] = new Option(i, i, false, selected);
        }
        this.refreshDate();
    },

    refreshDate() {

        let date = new Date(
            this.year.value,
            this.month.value - 1,
            this.day.value
        );

        this.date.value = DatePicker.getISODateFromDateParts(
            date.getFullYear(), date.getMonth(), date.getDate()
        );
    },

    /**
     * Returns number of days in month tking into account leap years
     * @param month - 0-12
     * @param year - YYYY
     * @returns {number}
     */
    daysInMonth(month, year) {

        month = parseInt(month)

        if (month == null) {
            return 31;
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
    },
}
