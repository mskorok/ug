import { Autocomplete } from 'bunnyjs/src/bunny.autocomplete';
import { Ajax } from 'bunnyjs/src/bunny.ajax';

export var UserInterests = {
    container: null,
    searchInput: null,
    interests: null,
    loadedInterests: null,
    addInterestBtn: null,
    finishBtn: null,
    loadMoreBtn: null,
    selectionClassName: 'selected',

    create(divId) {
        // Get DOM elements
        this.container = document.getElementById(divId);
        this.searchInput = this.container.querySelector('#search');
        this.interests = this.container.querySelector('#interests');
        this.refreshLoadedInterests();
        this.activeInterests = this.interests.getElementsByClassName(this.selectionClassName);
        this.addInterestBtn = this.container.querySelector('.app-search-autocomplete').querySelector('#add_interest');
        this.finishBtn = this.container.querySelector('#btn_finish');
        this.loadMoreBtn = document.getElementById('load_more_interests');

        this.loadInterests();

        // Search autocomplete
        Autocomplete.create(
            this.searchInput.getAttribute('id'),
            null,
            '/api/v1/interests/?format=keyvalue&fields=name&limit=10&like[name]={search}',
            this.acHandler
        );

        this.attachEventHandlers();
    },

    acHandler(data) {
        try {
            data = JSON.parse(data)
        } catch (e) {
            console.log('error', e);
            return []
        }
        return data;
    },

    attachEventHandlers() {
        this.addInterestBtn.addEventListener('click', () => this.handleAddBtnClick());
        this.searchInput.addEventListener('click', () => this.handleAddBtnClick());
        this.searchInput.addEventListener('keydown', (e) => {
            if (e.keyCode == 13) {
                this.handleAddBtnClick();
            }
        } );
        this.loadMoreBtn.addEventListener('click', () => this.loadInterests());
    },

    handleAddBtnClick() {
        let interestName = this.searchInput.value;
        let el = this.findInLoadedInterests(interestName);

        if (interestName == null || interestName == '' || interestName == 'undefined') {
            return;
        }

        if (el == null) {
            this.addInterestNode(interestName);
        } else if (! this.hasClass(el, this.selectionClassName)) {
            this.toggleInterestBtn(el);
        }
    },

    loadInterests() {
        let self = this;

        let offset = this.getLoadedInterestCount();

        Ajax.get('/api/v1/interests/?fields=id,name&limit=20&offset=' + offset,
            (data) => {
                let result = JSON.parse(data);

                if (Array.isArray(result) && result.length  == 0) {
                    this.loadMoreBtn.className += ' hidden-xs-up';
                } else if (typeof result.data.interests !== 'undefined') {
                    let interests = result.data.interests;
                    let html = '';
                    interests.forEach((e) => {
                        UserInterests.addInterestNode(e.name, e.id);
                    });
                    self.refreshLoadedInterests();
                }

            }
        );
    },

    addInterestNode(name, id = '') {
        let alreadyLoadedInterestEl = this.findInLoadedInterests(name);


        if (alreadyLoadedInterestEl == null) {
            // If not loaded yet
            // check if exists in database

            if ( id == '') {
                Ajax.get('/api/v1/interests/?fields=id,name&limit=1&equalTo[name]=' + name,
                    (data) => {
                        let result = JSON.parse(data);
                        if (result.data.interests.length > 0) {
                            let interests = result.data.interests;
                            this.createNewInterestNode(interests[0].name, interests[0].id, true);
                        } else {
                            this.createNewInterestNode(name, '', true);

                        }
                    },
                    (data) => {
                        this.createNewInterestNode(name, id, true);
                    }
                );
            } else {
                this.createNewInterestNode(name, id);
            }
        } else {
            // If already loaded just make sure it is selected

            if (! this.hasClass(alreadyLoadedInterestEl, this.selectionClassName)) {
                this.toggleInterestBtn(alreadyLoadedInterestEl);
            }
        }
    },

    createNewInterestNode(name, id, active = false) {
        this.interests.insertAdjacentHTML('beforeend', UserInterests.getInterestHtml(name, id))

        let el = this.interests.lastChild;

        el.addEventListener('click', (e) => {
            e.stopPropagation();
            this.toggleInterestBtn(el);
        });

        if (active) {
            this.toggleInterestBtn(el);
        }
    },

    toggleInterestBtn(el) {

        el.classList.toggle(this.selectionClassName);
        let isActive = this.hasClass(el, this.selectionClassName);
        let self = this;

        if(isActive) {
            let id = el.getAttribute('data-interest_id');
            let name = el.getElementsByClassName('interest-text')[0].innerHTML;

            if (id == '' || id == null || id == 'udefined') {
                el.insertAdjacentHTML('beforeend', `<input type="hidden" name="new_interest_list[]" value="${name}">`);
            } else {
                el.insertAdjacentHTML('beforeend', `<input type="hidden" name="interest_list[]" value="${id}">`);
            }
        } else {
            let input = el.querySelector('input');
            el.removeChild(input);
        }

        // Handle availability of <Finish> button
        if (this.finishBtn.disabled && isActive) {
            this.finishBtn.disabled = false;
        } else if (! this.finishBtn.disabled && ! isActive) {

            if (this.activeInterests.length == 0) {
                this.finishBtn.disabled = true;
            }
        }

        let notInList = self.getSelectedInterestIdList();

        Autocomplete.get(self.searchInput.getAttribute('id') + '_autocomplete')
            .ajaxUrl = '/api/v1/interests/?format=keyvalue&fields=name&limit=10&notIn[id]=' + notInList + '&like[name]={search}';
    },

    getInterestHtml(name, id = '') {

        return `<div class="app-list-item-faded" data-interest_id="${id}">` +
                    `<div class="interest-text">${name}</div>` +
               `</div>`;
    },

    getSelectedInterestIdList() {
        let list = '';
        let interests = this.loadedInterests;

        interests.forEach((e) => {

            if(this.hasClass(e, this.selectionClassName)) {
                list += e.getAttribute('data-interest_id') + ',';
            }
        });

        return list.replace(/(^,)|(,$)/g, "");
    },

    findInLoadedInterests(interestName) {
        let interests = this.loadedInterests;
        let result = null;

        interests.forEach((el) => {
            if (el.getElementsByClassName("interest-text")[0].innerHTML == interestName) {
                result = el;
            }
        });

        return result
    },

    hasClass(el, className) {
        var classNameStr = " " + className + " ";

        return (" " + el.className + " ").replace(/[\n\t]/g, " ").indexOf(classNameStr) > -1;


    },

    getLoadedInterestCount() {
        return this.loadedInterests.length;
    },
     refreshLoadedInterests() {
         this.loadedInterests = this.interests.getElementsByClassName('app-list-item-faded');
     }
};
