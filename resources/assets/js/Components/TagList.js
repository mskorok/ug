
import { Utils } from './Utils';

export var TagList = {

    _items: [],

    create(container_id, onRemoveItem = (name, id) => {}) {

        let container = document.getElementById(container_id);
        let list = container.getElementsByTagName('ul')[0];

        this._items[container_id] = {
            id: container_id,
            container: container,
            list: list,
            listItems: list.getElementsByTagName('li'),
            onChange: () => {
            },
            onRemoveItem: (name, id) => onRemoveItem(name, id)
        };

        let obj = this._items[container_id];

        this.addInstanceMethods(obj);
        obj.attachEventHandlers();

        return obj;
    },

    addInstanceMethods(obj) {

        obj.handleTagClick = (e) => {

            e.stopPropagation();
            let tag = e.target;
            let id = tag.getAttribute('data-id');
            let value = null;

            if (id == '' || id == null || id == 'undefined') {
                value = tag.textContent;
            } else {
                value = id;
            }

            let hiddenInput = document.querySelector('#' + obj.id + ' input[type=hidden][value="' + value + '"]');

            obj.onRemoveItem(tag.textContent, id);
            obj.container.removeChild(hiddenInput);
            obj.list.removeChild(tag);
            obj.onChange();
        };

        obj.attachEventHandlers = () => {

            obj.listItems.forEach((el) => {
                el.addEventListener('click', (e) => obj.handleTagClick(e));
            });
        };

        obj.addItem = (name, id = null) => {

            if (! obj.isSelected(name)) {

                obj.addTag(name, id);
                obj.addHiddenInput(name, id);
                obj.onChange();
            }
        };

        obj.addTag = (name, id) => {

            let li = document.createElement('li');
            li.setAttribute('class', 'app-tag app-s-close');
            li.setAttribute('data-id', (id == null) ? '' : id);
            li.textContent = name;

            obj.list.appendChild(li);
            li.addEventListener('click', (e) => obj.handleTagClick(e));
        };

        obj.addHiddenInput = (name, id) => {

            let hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');

            if (Utils.isEmpty(id)) {
                hiddenInput.setAttribute('name', obj.getHiddenInputNameNew());
                hiddenInput.value = name;
            } else {
                hiddenInput.setAttribute('name', obj.getHiddenInputName());
                hiddenInput.value = id;
            }

            obj.container.appendChild(hiddenInput);
        };

        obj.getHiddenInputName = () => {

            return obj.id + '[]';
        };

        obj.getHiddenInputNameNew = () => {

            return 'new_' + obj.getHiddenInputName();
        };

        obj.isSelected = (name) => {

            let result = false;

            obj.listItems.forEach((el) => {
                if (el.textContent == name) {
                    result = true;
                }
            });

            return result;
        };

        obj.getIdsOfAddedItems = () => {

            let items = document.getElementsByName(obj.getHiddenInputName());
            let list = '';

            items.forEach((el) => {
                list += el.value + ',';
            });

            return list.replace(/,+$/, "");
        };

        obj.setOnChangeCallback = (callback) => {

            obj.onChange = callback;
        };
    }
};
