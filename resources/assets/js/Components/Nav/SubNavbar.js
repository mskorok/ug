
import Filters from './Filters';

export default SubNavbar = {

    formFilterId: 'activity_filters',
    btnShowMoreFiltersDataId: 'show_more_filters',
    sectionFiltersId: 'filters',
    classFilterActive: 'active',

    init() {
        this.attachEventListeners();
    },

    attachEventListeners() {
        const btns = this.getBtnsShowMoreFilters();
        btns.forEach( (btn) => {
            btn.addEventListener('click', () => {
                this.toggleMoreFilters();
            });
        });
    },



    getSectionFilters() {
        return document.getElementById(this.sectionFiltersId);
    },

    getBtnsShowMoreFilters() {
        return document.querySelectorAll('[data-id="' + this.btnShowMoreFiltersDataId + '"]');
    },

    toggleMoreFilters() {
        if (this.isMoreFiltersOpened()) {
            this.hideMoreFilters();
        } else {
            if (!Filters.isInitiated(this.formFilterId)) {
                Filters.init(this.formFilterId);
            }
            this.showMoreFilters();
        }
    },

    isMoreFiltersOpened() {
        const section = this.getSectionFilters();
        //return section.classList.contains(this.classFilterActive);
        return !section.hasAttribute('hidden');
    },

    showMoreFilters() {
        const section = this.getSectionFilters();
        /*section.style.maxHeight = '1000px';
        section.classList.add(this.classFilterActive);
        setTimeout( () => {
            section.style.overflow = 'inherit';
        }, 600);*/
        section.removeAttribute('hidden');
        //Filters.focusSearchInput(this.formFilterId);

    },

    hideMoreFilters() {
        const section = this.getSectionFilters();
        /*section.style.overflow = 'hidden';
        section.classList.remove(this.classFilterActive);

        setTimeout( () => {
            section.style.maxHeight = '0px';
        }, 600);*/
        section.setAttribute('hidden', '');
    }

};
