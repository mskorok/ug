
import { Ajax } from 'bunnyjs/src/bunny.ajax';
import { Spinner } from "../../../../lib/spinner";

export var ActivitiesController = {

    hiddenClass: 'hidden-xs-up',
    activeClass: 'active',

    activitiesRows: document.getElementById('activities_rows'),
    activitiesMoreBlock: document.getElementById('activities_more_block'),
    btnMore: document.getElementById('app_button_more'),
    activitiesPage: 1,

    init(params) {
        this.userId = params.userId;
        this.attachEventHandlers();
    },

    attachEventHandlers() {
        this.btnMore.addEventListener('click', () => this.handleBtnMoreClick());
    },

    handleBtnMoreClick() {

        Spinner.add(this.btnMore);
        let page = ++this.activitiesPage;

        Ajax.get(

            '/users/' + this.userId + '/activities?page=' + page,

            (result) => {
                Spinner.remove(this.btnMore);
                let resultObj = JSON.parse(result);
                this.activitiesRows.insertAdjacentHTML('beforeend', resultObj.html);

                if (resultObj.showMore == true) {
                    this.unhideElement(this.activitiesMoreBlock);
                } else {
                    this.hideElement(this.activitiesMoreBlock);
                }
            },
            (result) => {
                Spinner.remove(this.btnMore);
                console.log(JSON.parse(result));
            }
        );
    },

    hideElement(el) {
        if (! el.classList.contains(this.hiddenClass)) {
            el.classList.add(this.hiddenClass);
        }
    },

    unhideElement(el) {
        el.classList.remove(this.hiddenClass);
    }
}
