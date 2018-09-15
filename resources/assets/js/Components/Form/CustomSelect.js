
/**
 * CustomSelect base object
 * Wrapper of Bootstrap 4 dropdown list
 * Requires dropdown js
 */
export default CustomSelect = {

    /**
     * CustomSelect factory, creates new object and initializes it
     *
     * @param {HTMLElement} dropdown_container  -  container containing dropdown, dropdown-toggle, dropdown-menu,
     * dropdown-item's;
     * dropdown-toggle is used as label (non-selected option)
     * dropdown-menu should contain at least one dropdown-item
     * dropdown-item should have data-value="value"
     * dropdown-item may have data-selected
     * in this container hidden inputs are created
     * @param {String} name  -  name for custom input, if multiple no need to add "[]" at the end
     * @param multiple = false  - is select multiple, by default no, if yes "[]" appended to the end of name
     * @returns {Object} select  - object to be used as 1st argument in all CustomSelect public methods
     */
    create(dropdown_container, name, multiple = false) {
        const select = {};
        select.container = dropdown_container;
        select.name = name;
        select.multiple = multiple;
        select.toggle = this._getCustomToggleInput(select);
        select.toggleDefaultLabel = select.toggle.textContent;
        select.dropdown = this._getDropdown(select);
        select.hiddenInputContainer = this._createHiddenInputContainer();
        this._insertHiddenInputContainer(select, select.hiddenInputContainer);
        select.hiddenInputs = {};
        select.selectedValues = [];

        const items = this._getDropdownItems(select);
        select.dropdownItems = {};
        for (let k = 0; k < items.length; k++) {
            let item = items[k];
            select.dropdownItems[item.dataset.value] = item;
            this._attachDropdownItemClickEvent(select, item);
            if (item.dataset.selected !== undefined) {
                this._select(select, item.dataset.value, false);
            }
        }
        return select;
    },

    /**
     * Get select option DOM element by value
     * @param {Object} select
     * @param {String} value
     * @returns {HTMLElement|undefined}
     */
    getOption(select, value) {
        return select.dropdownItems[value];
    },

    hideOption(select, value) {
        this.getOption(select, value).setAttribute('hidden', '');
    },

    showOption(select, value) {
        this.getOption(select, value).removeAttribute('hidden');
    },

    select(select, value) {
        if (!this.isSelected(select, value)) {
            if (this.isMultiple(select)) {
                this._select(select, value);
            } else {
                if (select.selectedValues.length !== 0) {
                    this._deselect(select, select.selectedValues[0], false);
                }
                this._select(select, value);
            }
        } else {
            this.deselect(select, value);
        }
    },

        _select(select, value, fire_event = true) {
            select.selectedValues.push(value);
            const option = this.getOption(select, value);
            option.classList.add('active');
            option.dataset.selected = '';
            const hidden_input = this._createHiddenInput(select.name, value);
            this._insertHiddenInput(select, hidden_input);
            select.hiddenInputs[value] = hidden_input;
            if (!this.isMultiple(select)) {
                this.setLabelByValue(select, value);
            }
            if (fire_event) {
                this._fireChangeEventOnSelect(select, value, option.textContent, true);
            }
        },

    deselect(select, value) {
        if (this.isSelected(select, value)) {
            this._deselect(select, value);
        }
    },

        _deselect(select, value, fire_event = true) {
            const pos = select.selectedValues.indexOf(value);
            select.selectedValues.splice(pos, 1);
            const option = this.getOption(select, value);
            option.classList.remove('active');
            delete option.dataset.selected;
            if (!this.isMultiple(select) && select.selectedValues.length === 0) {
                this.setDefaultLabel(select);
            }
            this._removeHiddenInput(select, value);
            if (fire_event) {
                this._fireChangeEventOnSelect(select, value, option.textContent, false);
            }
        },

    isSelected(select, value) {
        return select.selectedValues.indexOf(value) !== -1;
    },

    isMultiple(select) {
        return select.multiple;
    },

    getSelectedOptions(select) {
        const selected_values = this.getSelectedValues(select);
        const selected_options = {};
        for (let k = 0; k < selected_values.length; k++) {
            let value = selected_values[k];
            selected_options[value] = select.dropdownItems[value];
        }
        return selected_options;
    },

    getSelectedValues(select) {
        return select.selectedValues;
    },

    getOptionLabel(select, value) {
        const option = this.getOption(select, value);
        return option.textContent;
    },

    setLabel(select, label) {
        select.toggle.textContent = label;
        this._setToggleActive(select);
    },

    setLabelByValue(select, value) {
        const label = this.getOptionLabel(select, value);
        this.setLabel(select, label);
    },

    setDefaultLabel(select) {
        this.setLabel(select, select.toggleDefaultLabel);
        this._setToggleInactive(select);
    },




    _attachDropdownItemClickEvent(select, item) {
        item.addEventListener('click', () => {
            const value = item.dataset.value;
            this.select(select, value);
        });
    },

    _fireChangeEventOnSelect(select, value, label, selected = true) {
        const event = new CustomEvent('change', {detail: {value: value, label: label, selected: selected}});
        select.container.dispatchEvent(event);
    },




    _getCustomToggleInput(select) {
        const toggle = select.container.getElementsByClassName('dropdown-toggle')[0];
        if (toggle === undefined) {
            throw new Error('CustomSelect must have a child element with class="dropdown-toggle"');
        }
        return toggle;
    },

    _getDropdown(select) {
        const dropdown = select.container.getElementsByClassName('dropdown-menu')[0];
        if (dropdown === undefined) {
            throw new Error('CustomSelect must have a child element with class="dropdown-menu"');
        }
        return dropdown;
    },

    _getDropdownItems(select) {
        const items = select.dropdown.getElementsByClassName('dropdown-item');
        if (items.length === 0) {
            throw new Error('Dropdown in CustomSelect must have at least one child element with class="dropdown-item"');
        }
        for (let k = 0; k < items.length; k++) {
            let item = items[k];
            if (item.dataset.value === undefined) {
                throw new Error('All Dropdown Items in CustomSelect must have data-value attribute');
            }
        }
        return items;
    },




    _setToggleActive(select) {
        select.toggle.classList.add('dropdown-active');
    },

    _setToggleInactive(select) {
        select.toggle.classList.remove('dropdown-active');
    },



    _createHiddenInputContainer() {
        const e = document.createElement('div');
        e.setAttribute('hidden', '');
        return e;
    },

    _insertHiddenInputContainer(select, hidden_input_container) {
        select.container.appendChild(hidden_input_container);
    },

    _createHiddenInput(name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        return input;
    },

    _getHiddenInputs(select) {
        return select.hiddenInputContainer.getElementsByTagName('input');
    },

    _getHiddenInputByValue(select, value) {
        return select.hiddenInputs[value];
    },

    _insertHiddenInput(select, input) {
        select.hiddenInputContainer.appendChild(input);
    },

    _removeHiddenInput(select, value) {
        const input = this._getHiddenInputByValue(select, value);
        select.hiddenInputContainer.removeChild(input);
    },

};
