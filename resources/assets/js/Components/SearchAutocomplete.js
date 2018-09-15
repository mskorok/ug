
import { Api } from './../Core/Api';
import { Autocomplete } from 'bunnyjs/src/bunny.autocomplete';
import { Ajax } from 'bunnyjs/src/bunny.ajax';
import { Utils } from './Utils';

export var SearchAutocomplete = {

    _items: [],

    create(container_id, resource, query, list, allowNew = true) {

        let el = document.getElementById(container_id);
        let container = el.parentNode;

        this._items[container_id] = {
            id: container_id,
            resource: resource,
            list: list,
            query: query,
            baseUrl: Server.project.apiPrefix + '/' + resource,

            el: el,
            container: container,
            btnAdd: container.querySelector('.app-search-add-item'),
            input: container.querySelector('input'),
            allowNew: allowNew
        }

        let obj = this._items[container_id];
        this.addInstanceMethods(obj);

        // Register event handlers
        obj.btnAdd.addEventListener(
            'click',
            () => obj.handleAddBtnClick(container_id)
        );

        obj.list.setOnChangeCallback(() => obj.refreshAutocompleteUrl());
        obj.addHiddenInput();

        return Autocomplete.create(container_id, obj.getHiddenInputId(), obj.getAutocompleteUrl(container_id));
    },

    addInstanceMethods(obj) {

        obj.addHiddenInput = () => {
            let hiddenInputId = obj.getHiddenInputId();
            obj.hiddenInput = document.createElement('input');
            obj.hiddenInput.setAttribute('type', 'hidden');
            obj.hiddenInput.setAttribute('id', hiddenInputId);
            obj.hiddenInput.setAttribute('value', '');
            obj.container.appendChild(obj.hiddenInput);
        };

        obj.getHiddenInputId = () => {

            return obj.id + '_hidden';
        };

        obj.getAutocompleteUrl = () => {

            return obj.baseUrl + '/?' + obj.query + '&notIn[id]=' + obj.getExclusionIdList();
        };

        obj.refreshAutocompleteUrl = () => {

            Autocomplete.get(obj.container.getAttribute('id')).ajaxUrl = obj.getAutocompleteUrl();
        };

        obj.getExclusionIdList = () => {

            return obj.list.getIdsOfAddedItems();
        };

        obj.getSelectedValue = () => {

            return obj.input.value;
        };

        obj.getSelectedId = () => {

            return obj.hiddenInput.value;
        };

        obj.handleAddBtnClick = () => {

            let id = obj.getSelectedId();
            let value = obj.getSelectedValue();

            if (! Utils.isEmpty(value)) {

                if (Utils.isEmpty(id)) {

                    let checkExistenceQuery = obj.resource + '?fields=id,name&limit=1&equalTo[name]=' + obj.getSelectedValue();

                    let result = Api.get(checkExistenceQuery)
                        .then((result) => {
                            id = result.data[obj.resource][0].id;
                            obj.addItem(value, id);
                        })
                        .catch((error) => {
                            if (obj.allowNew) {
                                obj.addItem(value);
                            }
                        });
                } else {
                    obj.addItem(value, id);
                }
            }
        };

        obj.addItem = (value, id = null) => {

            obj.list.addItem(value, id);
            obj.refreshAutocompleteUrl();
            obj.input.value = '';
            obj.hiddenInput.value = '';
        }
    },
};
