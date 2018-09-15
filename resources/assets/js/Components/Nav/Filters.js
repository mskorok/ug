
import Filter from "./Filter";

export default Filters = {

    _collection: {},

    init(form_id) {
        if (this.isInitiated(form_id)) {
            throw new Error(`Filter for form "${form_id}" already initiated!`);
        }
        const f = new Filter(form_id);
        this._collection[form_id] = f;
        f.initCategoriesCustomInput();
        f.initDateCustomInput();
    },

    isInitiated(form_id) {
        return this._collection[form_id] !== undefined;
    },

    focusSearchInput(form_id) {
        const f = this._collection[form_id];
        const input = f.getSearchInput();
        input.focus();
    }

};
