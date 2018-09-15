
import { Ajax } from 'bunnyjs/src/bunny.ajax';
import { Spinner } from "../../../../lib/spinner";

export var FriendsController = {

    hiddenClass: 'hidden-xs-up',
    activeClass: 'active',

    rows: document.getElementById('friends_rows'),
    moreBlock: document.getElementById('friends_more_block'),
    btnMore: document.getElementById('friends_button_more'),
    page: 1,

    init(params) {
        this.userId = params.userId;
        this.attachEventHandlers();
    },

    attachEventHandlers() {
        this.btnMore.addEventListener('click', () => this.handleBtnMoreClick());
    },

    handleBtnMoreClick() {

        Spinner.add(this.btnMore);

        let page = ++this.page;

        Ajax.get(

            '/users/' + this.userId + '/friends?page=' + page,

            (result) => {
                Spinner.remove(this.btnMore);
                let resultObj = JSON.parse(result);
                this.rows.insertAdjacentHTML('beforeend', resultObj.html);

                if (resultObj.showMore == true) {
                    this.unhideElement(this.moreBlock);
                } else {
                    this.hideElement(this.moreBlock);
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