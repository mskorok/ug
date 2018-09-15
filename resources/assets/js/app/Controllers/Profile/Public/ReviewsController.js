
import { Ajax } from 'bunnyjs/src/bunny.ajax';
import { Spinner } from "../../../../lib/spinner";

export var ReviewsController = {

    hiddenClass: 'hidden-xs-up',
    activeClass: 'active',

    reviewsRows: document.getElementById('reviews_rows'),
    reviewsMoreBlock: document.getElementById('reviews_more_block'),
    btnMore: document.getElementById('reviews_button_more'),
    reviewsPage: 1,

    init(params) {
        this.userId = params.userId;
        this.attachEventHandlers();
    },

    attachEventHandlers() {
        this.btnMore.addEventListener('click', () => this.handleBtnMoreClick());
    },

    handleBtnMoreClick() {

        Spinner.add(this.btnMore);

        let page = ++this.reviewsPage;

        Ajax.get(

            '/users/' + this.userId + '/reviews?page=' + page,

            (result) => {

                Spinner.remove(this.btnMore);
                let resultObj = JSON.parse(result);
                this.reviewsRows.insertAdjacentHTML('beforeend', resultObj.html);

                if (resultObj.showMore == true) {
                    this.unhideElement(this.reviewsMoreBlock);
                } else {
                    this.hideElement(this.reviewsMoreBlock);
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
