import { Ajax } from 'bunnyjs/src/bunny.ajax';
import { Checkbox } from "../../../../../../node_modules/bunnyjs/src/form/checkbox";
import { Spinner } from '../../../lib/spinner';

export var PeopleController = {

    btnMore: document.getElementById('btn_more'),
    url: '/people',

    // Tabs
    sections: document.getElementsByClassName('app-people-section'),
    sectionNew: document.getElementById('people_new'),
    sectionPopular: document.getElementById('people_popular'),
    sectionFriends: document.getElementById('people_friends'),

    // Nav bar
    subNavBar: document.querySelector('.app-subnavbar'),
    navItems: document.querySelectorAll('#nav_items li'),
    navNew: document.getElementById('nav_new'),
    navPopular: document.getElementById('nav_popular'),
    navFriends: document.getElementById('nav_friends'),

    // Show more sections
    sectionMoreNew: document.getElementById('show_more_new'),
    sectionMorePopular: document.getElementById('show_more_popular'),
    sectionMoreFriends: document.getElementById('show_more_friends'),

    // Current pages
    pageNew: 2,
    pagePopular: 1,
    pageFriends: 1,

    // Classes
    hiddenClass: 'hidden-xs-up',
    appDropdownClass: 'app-dropdown',
    activeClass: 'active',

    // Text
    txtRetrieving: 'Retrieving data...',
    txtBtnShowMorecaption: 'Show more',

    index() {
        this.currentTabId = document.getElementById('tab').value;

        Checkbox.create('app-checkbox-label', 'app-checkbox', 'checked');
        this.attachEventHandlers();
        this.initDropdown();
    },

    attachEventHandlers() {
        // Nav
        this.navNew.addEventListener('click', () => this.handleNavNewClick());
        this.navPopular.addEventListener('click', () => this.handleNavPopularClick());
        this.navFriends.addEventListener('click', () => this.handleNavFriendsClick());

        this.btnMore.addEventListener('click', () => this.handleBtnMoreClick());
    },

    initDropdown() {
        var elements =  document.getElementsByClassName(this.appDropdownClass);

        elements.forEach(function(el) {
            el.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });
    },

    hideShowMoreBtn() {

        if (! this.btnMore.classList.contains(this.hiddenClass)) {
            this.btnMore.classList.add(this.hiddenClass);
        }
    },

    navDeselectAll() {
        this.navItems.forEach((i) => {
            i.classList.remove("active");
            i.getElementsByClassName('nav-link')[0].classList.remove(this.activeClass);
        });
    },

    activateSection(id) {

        this.sections.forEach((i) => {
            if (i.getAttribute('id') == id) {
                i.classList.remove(this.hiddenClass);
            } else if (! i.classList.contains(this.hiddenClass)) {
                i.classList.add(this.hiddenClass);
            }
        });

        this.currentTabId = id;

        if (this.getCurrMoreBlock().innerHTML == '') {

            this.hideShowMoreBtn();
            this.showMoreRecords();
        }

    },

    activateNavItem(id) {
        this.navItems.forEach((i) => {
            if (i.getAttribute('id') == id && ! i.classList.contains(this.activeClass)) {
                i.classList.add(this.activeClass);
                i.getElementsByClassName('nav-link')[0].classList.add(this.activeClass);
            } else {
                i.classList.remove(this.activeClass);
                i.getElementsByClassName('nav-link')[0].classList.remove(this.activeClass);
            }
        });
    },

    handleBtnMoreClick() {

        Spinner.add(this.btnMore);
        this.showMoreRecords();
    },

    showMoreRecords() {

        let url = this.url + '?page=' + this.getPage() + '&tab=' + this.currentTabId + this.getCategoryFilter();

        Ajax.get(
            url,
            (data) => this.handleRecevedUsers(data),
            (error) => this.handleUserRetrievalFailure(error)
        );
    },

    getPage() {

        if (this.currentTabId == this.sectionNew.getAttribute('id')) {

            return this.pageNew;

        } else if (this.currentTabId == this.sectionPopular.getAttribute('id')) {

            return this.pagePopular;

        } else {

            return this.pageFriends;

        }
    },

    getCurrMoreBlock() {

        if (this.currentTabId == this.sectionNew.getAttribute('id')) {

            return this.sectionMoreNew;

        } else if (this.currentTabId == this.sectionPopular.getAttribute('id')) {

            return this.sectionMorePopular;

        } else {

            return this.sectionMoreFriends;

        }
    },

    incrementPage() {

        if (this.currentTabId == this.sectionNew.getAttribute('id')) {

            return this.pageNew++;

        } else if (this.currentTabId == this.sectionPopular.getAttribute('id')) {

            return this.pagePopular++;

        } else {

            return this.pageFriends++;

        }

    },

    getCategoryFilter() {

        let selectedCategories = document.querySelectorAll('[name^=categories][checked]');
        let qs = '';

        selectedCategories.forEach((el) => {
            qs += '&'+ el.name + '=1';
        });

        return qs;
    },

    handleRecevedUsers(data) {
        let results = JSON.parse(data);

        if(results.success == true){

            if (this.getPage() >= results.lastPage) {
                this.btnMore.classList.add(this.hiddenClass);
            }

            let row = document.createElement("div");

            row.classList.add('row');
            row.innerHTML = results.html;

            this.getCurrMoreBlock().appendChild(row);

            Spinner.remove(this.btnMore);
            this.incrementPage();
        }

        this.btnMore.classList.remove(this.hiddenClass);
    },

    handleUserRetrievalFailure(error) {

        Spinner.remove(this.btnMore);
    },

    handleNavNewClick() {

        this.activateSection(this.sectionNew.getAttribute('id'));
        this.activateNavItem(this.navNew.getAttribute('id'));
    },

    handleNavPopularClick() {

        this.activateSection(this.sectionPopular.getAttribute('id'));
        this.activateNavItem(this.navPopular.getAttribute('id'));
    },

    handleNavFriendsClick() {

        this.activateSection(this.sectionFriends.getAttribute('id'));
        this.activateNavItem(this.navFriends.getAttribute('id'));
    },

}
