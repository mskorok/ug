
import TagSelector from "../Tags/TagSelector";
import CustomSelect from "../Form/CustomSelect";

export default function Filter(form_id) {

    this._categoriesName = 'categories';
    this._dateName = 'dateselect';

    this._formId = form_id;
    this._form = document.forms[form_id];
    this._searchInput = document.forms[form_id].elements['search'];
    this._categoriesCustomInput = this.getCustomInput(this._categoriesName);
    this._dateCustomInput = this.getCustomInput(this._dateName);
}

Filter.prototype.getForm = function getForm() {
    return this._form;
};

Filter.prototype.getCustomInput = function getCustomInput(name) {
    return document.forms[this._formId].querySelector(`[data-form-input="${name}"]`);
};

Filter.prototype.getSearchInput = function getSearchInput() {
    return this._searchInput;
};

Filter.prototype.getCategoriesCustomInput = function getSearchInput() {
    return this._categoriesCustomInput;
};

Filter.prototype.getDateCustomInput = function getDateCustomInput() {
    return this._dateCustomInput;
};

Filter.prototype.initCategoriesCustomInput = function initCategoriesCustomInput() {
    const el = this.getCategoriesCustomInput();
    if (this.getCategoriesCustomInput() !== null) {
        TagSelector.create(el, this._categoriesName);
        /*this._categoriesCustomSelect = CustomSelect.create(el, 'categories[]', true);
        el.addEventListener('change', (e) => {
            if (e.detail.selected) {
                // new item selected
                let t = Tag.create(e.detail.value, e.detail.label);
                Tag.makeClosable(t).then( (value) => {
                    CustomSelect.deselect(this._categoriesCustomSelect, value);
                });
                el.appendChild(t);
            } else {
                // deselected
                Tag.removeByValueIfExists(el, e.detail.value);
            }
        });*/
    }
};

Filter.prototype.initDateCustomInput = function initDateCustomInput() {
    const el = this.getDateCustomInput();
    if (this.getCategoriesCustomInput() !== null) {
        CustomSelect.create(el, this._dateName);
    }
};
