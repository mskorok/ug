
import CustomSelect from "../Form/CustomSelect";
import Tag from "./Tag";

export default TagSelector = {

    create(dropdown_container, name) {

        const selector = {};
        selector.container = dropdown_container;
        selector.name = name;
        selector.customSelect = CustomSelect.create(selector.container, name + '[]', true);

        selector.tagContainer = this._createTagContainer();
        this._insertTagContainer(selector, selector.tagContainer);

        this._initSelectedTags(selector);
        this._attachChangeEvent(selector);

        return selector;
    },

    _addTag(selector, value, label) {
        let t = Tag.create(value, label);
        Tag.makeClosable(t).then( (value2) => {
            CustomSelect.deselect(selector.customSelect, value2);
        });
        this._insertTag(selector, t);
    },

    _attachChangeEvent(selector) {
        selector.container.addEventListener('change', (e) => {
            if (e.detail.selected) {
                // new item selected
                this._addTag(selector, e.detail.value, e.detail.label);
            } else {
                // deselected
                Tag.removeByValueIfExists(selector.tagContainer, e.detail.value);
            }
        });
    },

    _initSelectedTags(selector) {
        const selected_values = CustomSelect.getSelectedValues(selector.customSelect);
        for (let k = 0; k < selected_values.length; k++) {
            let value = selected_values[k];
            this._addTag(selector, value, CustomSelect.getOptionLabel(selector.customSelect, value));
        }
    },

    _insertTag(selector, tag) {
        selector.tagContainer.appendChild(tag);
    },

    _createTagContainer() {
        const tag_container = document.createElement('div');
        return tag_container;
    },

    _insertTagContainer(selector, tag_container) {
        //selector.container.appendChild(tag_container);
        selector.container.parentNode.insertBefore(tag_container, selector.container.nextSibling);
    }

};
