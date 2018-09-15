import { Awesom } from './Awesomplete';
import { Listeners } from './../Listeners/Listeners';
import Decorator from './../Decorators/InterestsDecorator';
import { Ajax } from 'bunnyjs/src/bunny.ajax';


export var Interests = {

    model: 'user',
    current_user: null,
    current_adventure: null,
    current_review: null,
    selector: 'autocomplete',
    autocompleteResolver: 'bunny',
    last_input_data: '',
    interestPage: 1,
    mode: 'edit',
    fromInput: false,
    list: false,
    interests: 'interests',
    interestsAdd: 'interests-add',
    interestsHiddenBlock: 'interests_hidden_block',
    hiddenInterests: 'hidden_interests',
    firstInterestButton: 'first_user_interest',
    interestsForCreationBlock: 'interests_for_creation',
    interestsAutocompleteUrl: '/interests/?format=keyvalue&fields=name&limit=10&like[name]={search}',
    apiResultId: 'create_interest_result',
    prefix: Server.project.apiPrefix,
    interestsListUrl: '/interests/list',
    addInterestUrl: '/interests/add/',
    editInterestUrl: '/interests/edit/',
    addToUserUrl: '/users/add-interest/',
    addToAdventureUrl: '/adventures/add-interest/',
    addToReviewUrl: '/review/add-interest/',
    refreshUserUrl: '/users/interests/',
    refreshAdventureUrl: '/adventures/interests/',
    refreshReviewUrl: '/review/interests/',
    removeFromUserUrl: '/users/remove-interest/',
    removeFromAdventureUrl: '/adventures/remove-interest/',
    removeFromReviewUrl: '/review/remove-interest/',

    buttonStyle: 'btn btn-info m-t-1 m-r-1 m-b-1',

    addButton: 'add_interest',
    removeButton: 'remove_interest',
    loadMoreButton: 'load_more_interest',
    createButton: 'create_interest',
    editButton: 'edit_interest',
    deleteButton: 'delete_interest',


    init(options) {
        this.options = options;
        var self = this;
        if (document.getElementById(this.selector)) {

            if (this.autocompleteResolver === 'awesomplete') {
                Awesom.init(this.selector).fill();

            } else if (this.autocompleteResolver === 'bunny') {
                Listeners.autocompleteListener(this.selector);
            }
            document.getElementById(this.selector).addEventListener('input', function () {
                self.checkInputChanges();
            });
            document.getElementById(this.selector).addEventListener(self.autocompleteSelectEvent, function () {
                self.checkInputChanges();
            });
            document.getElementById(this.selector).addEventListener('keydown', function (e) {
                if (e.keyCode == 13) {
                    let interest = document.getElementById(self.selector).value;
                    interest.trim();
                    if (interest.length && interest.length > 3) {
                        if(this.mode === 'edit') {
                            self.add(interest);
                        } else {
                            self.createFromInput();
                        }

                    } else {
                        console.log('zero input');
                    }
                }
            });

            this.refresh();

            if (this.list) {
                this.listInterests();
            }

            if (document.getElementById(this.firstInterestButton)) {

                document.getElementById(this.firstInterestButton).addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    let interest = document.getElementById(self.selector).value;
                    interest.trim();
                    if (interest.length && interest.length > 3) {
                        if(this.mode === 'edit') {
                            self.add(interest);
                        } else {
                            self.createFromInput();
                        }

                    } else {
                        console.log('zero input');
                    }

                });
            }


            if (document.getElementById(this.loadMoreButton)) {
                document.getElementById(this.loadMoreButton).addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    self.listInterests();
                });
            }

            if (document.getElementById(this.addButton)) {
                document.getElementById(this.addButton).addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var interest = document.getElementById(self.selector).value;
                    interest.trim();
                    if (interest !== '') {
                        self.add(interest);
                    } else {
                        console.log('zero input');
                    }
                });
            }

            if (document.getElementById(this.removeButton)) {
                document.getElementById(this.removeButton).addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var interest = document.getElementById(self.selector).value;
                    interest.trim();
                    if (interest !== '') {
                        self.remove(interest);
                    } else {
                        console.log('zero input');
                    }
                });
            }



            if (document.getElementById(this.createButton)) {
                document.getElementById(this.createButton).addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var interest = document.getElementById(self.selector).value;
                    interest.trim();
                    if (interest !== '') {
                        self.createInterest(interest);
                    } else {
                        console.log('zero input');
                    }
                });
            }

            if (document.getElementById(this.editButton)) {
                document.getElementById(this.editButton).addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var interest = document.getElementById(self.selector).value;
                    interest.trim();
                    if (interest !== '') {
                        self.editInterest(interest);
                    } else {
                        console.log('zero input');
                    }
                });
            }

            if (document.getElementById(this.deleteButton)) {
                document.getElementById(this.deleteInterestButton).addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var interest = document.getElementById(self.selector).value;
                    interest.trim();
                    if (interest !== '') {
                        self.deleteInterest(interest);
                    } else {
                        console.log('zero input');
                    }
                })
            }
        }
    },

    checkInputChanges() {
        var self = this;
        var value = document.getElementById(this.selector).value;
        value.trim();
        var url = '/' + this.prefix + this.interestsListUrl;
        Ajax.get(url, function (data) {
            var list = JSON.parse(data).map(function (i) {
                return i.name;
            });
            if (list.indexOf(value) > -1) {
                self.last_input_data = value;
            }
        });
    },

    add(interest) {
        var self = this;
        var url;
        interest = interest.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        switch (self.model) {
            case 'user' :
                url = '/' + this.prefix + this.addToUserUrl + interest + '/' + this.current_user;
                break;
            case 'adventure' :
                url = '/' + this.prefix + this.addToAdventureUrl + interest + '/' + this.current_adventure;
                break;
            case 'review' :
                url = '/' + this.prefix + this.addToReviewUrl + interest + '/' + this.current_review;
                break;
        }
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'added') {
                Awesom.fill();
                self.apiResult(interest, res.action, res.message);
                self.refresh();
                self.interestPage = 1;
                if(document.getElementById(self.interestsAdd)) {
                    document.getElementById(self.interestsAdd).innerHTML = '';
                    self.listInterests();
                }


            } else if (res.action === 'overflow' || res.action === 'error') {
                self.apiResult(interest, res.action, res.message)
            }
        });
    },

    refresh() {
        var self = this;
        if(!document.getElementById(self.interests)) {
            return false;
        }

        var url;
        switch (this.model) {
            case 'user' :
                url = '/' + this.prefix + this.refreshUserUrl + this.current_user;
                break;
            case 'adventure' :
                url = '/' + this.prefix + this.refreshAdventureUrl + this.current_adventure;
                break;
            case 'review' :
                url = '/' + this.prefix + this.refreshReviewUrl + this.current_review;
                break;
        }

        Ajax.get(url, function (data) {
            var res = JSON.parse(data).map(function (i) {
                return i.name;
            });
            Decorator.refreshButtons(res);

        });
    },

    remove(interest) {
        var self = this;
        var url;
        switch (this.model) {
            case 'user' :
                url = '/' + this.prefix + this.removeFromUserUrl + interest + '/' + this.current_user;
                break;
            case 'adventure' :
                url = '/' + this.prefix + this.removeFromAdventureUrl + interest + '/' + this.current_adventure;
                break;
            case 'review' :
                url = '/' + this.prefix + this.removeInterestFromReviewUrl + interest + '/' + this.current_review;
                break;
        }

        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'removed') {
                Awesom.fill();
                document.getElementById(self.selector).value = '';
                self.apiResult(interest, res.action, null);
                self.refresh();
                self.interestPage = 1;
                if(document.getElementById(self.interestsAdd)) {
                    document.getElementById(self.interestsAdd).innerHTML = '';
                    self.listInterests();
                }

            } else if (res.action === 'error') {
                self.apiResult(interest, res.action, res.message)
            }
        });
    },
    listInterests() {

        if (this.list == false) {
            return false;
        }

        var self = this;
        var url;
        switch (this.model) {
            case 'user' :
                url = '/' + this.prefix + self.refreshUserUrl + this.current_user + '/' + this.interestPage;
                break;
            case 'adventure' :
                url = '/' + this.prefix + self.refreshAdventureUrl + this.current_adventure + '/' + this.interestPage;
                break;
            case 'review' :
                url = '/' + this.prefix + self.refreshReviewUrl + this.current_review + '/' + this.interestPage;
                break;
        }
        Ajax.get(url, function (data) {
            var res = JSON.parse(data).map(function (i) {
                return i.name;
            });
            Decorator.addInterestButtons(res);
        });
    },

    listSelected() {
        var self = this;
        var class_hidden = document.getElementsByClassName(self.hiddenInterests);
        var name, hidden_id, html = '';

        for (var i = 0; i < class_hidden.length; i++) {
            name = class_hidden[i].getAttribute('value');
            hidden_id = name.replace(/\s+/g, '_');
            html += '<button id="add-interest-buttons-' + hidden_id + '" class="' + self.buttonStyle + ' add-interest-buttons" data-item="' + name + '">' + name + '  +</button>';
        }
        var div = document.createElement('div');
        div.style.display = 'inline-block';
        div.innerHTML = html;
        if (document.getElementById(self.interestsAdd)) {
            document.getElementById(self.interestsAdd).innerHTML = '';
            document.getElementById(self.interestsAdd).appendChild(div);
        }

        var class_name = document.getElementsByClassName('add-interest-buttons');
        for (var j = 0; j < class_name.length; j++) {
            class_name[j].addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var name = this.getAttribute('data-item');
                if (mode == 'edit') {
                    self.add(name);

                } else if (mode == 'create') {
                    self.collectInterestsForCreation(name);
                }

            });
            class_name[j].classList.add('hidden-xs-up');
        }
        this.interestPage = 1;
    },


    collectInterestsForCreation(name, new_interest) {
        var self = this;
        new_interest = new_interest || null;

        var el = document.getElementById(self.interestsHiddenBlock);
        var class_hidden = document.getElementsByClassName(self.hiddenInterests);

        if (class_hidden.length < 15) {
            if (el) {
                Decorator.collectInterestsDecorator(name);
            }
        }
    },

    testForSelected(id) {
        var self = this;
        var class_hidden = document.getElementsByClassName(self.hiddenInterests);
        var name, hidden_id, res = false;
        for (var i = 0; i < class_hidden.length; i++) {
            name = class_hidden[i].getAttribute('value');
            hidden_id = name.replace(/\s+/g, '_');
            if (hidden_id == id) {
                res = true;
            }
        }
        return res;
    },

    createInterest (interest) {
        var self = this;
        if (interest == '') {
            return false;
        }
        var url = '/' + this.prefix + this.addInterestUrl + interest;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);

            if (res.action == 'success') {
                Awesom.fill();
                self.collectInterestsForCreation(interest, true);
                self.interestPage = 1;
                self.listInterests();
            }
        });
    },
    editInterest(interest) {
        var self = this;
        var message, old = this.last_input_data;
        var url = '/' + this.prefix + this.editInterestUrl + old + '/' + interest;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'edited') {
                Awesom.fill();
                message = 'Interest ' + old + ' successfully renamed to ' + interest;
                self.apiResult(interest, res.action, message)
            } else if (res.action === 'not found') {
                message = 'Interest ' + old + ' not found';
                self.apiResult(interest, res.action, message)
            }
        });
    },
    deleteInterest(interest) {
        var self = this;
        interest = interest.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        var url = '/' + this.prefix + this.interestsUrl + interest + '/delete';
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'deleted') {
                Awesom.fill();
                self.apiResult(interest, res.action, null)
            } else if (res.action === 'not fount') {
                self.apiResult(interest, res.action, null)
            }
        });
    },

    createFromInput() {
        var self = this;

        var name = document.getElementById(self.selector).value;

        if (name == '') {
            return false;
        }
        var id = name.replace(/\s+/g, '_');
        if (this.testForSelected(id)) {
            console.log('already selected');
            return true;
        }
        var url = '/' + this.prefix + self.interestsListUrl;

        Ajax.get(url, function (data) {
            var list = JSON.parse(data).map(function (i) {
                return i.name;
            });

            if (list.indexOf(name) > -1) {
                self.collectInterestsForCreation(name);
                self.interestPage = 1;
                self.listInterests()
            } else {
                self.createInterest(name);
            }
        });

    },


    apiResult(interest, action, message) {
        var self = this;
        var div = document.getElementById(self.apiResultId);
        var text;
        div.classList.remove('hidden-xs-up');
        switch (action) {
            case 'success':
                text = 'You interest "' + interest + '" successfully created';
                div.classList.add('alert-success');
                div.innerText = document.createTextNode(text).textContent;
                break;
            case 'added':
                text = 'You interest "' + interest + '" successfully added';
                div.classList.add('alert-success');
                div.innerText = document.createTextNode(text).textContent;
                break;
            case 'edited':
                text = message;
                div.classList.add('alert-success');
                div.innerText = document.createTextNode(text).textContent;
                break;
            case 'exist':
                text = 'Interest "' + interest + '" already  exist';
                div.classList.add('alert-info');
                div.innerText = document.createTextNode(text).textContent;
                break;
            case 'overflow':
                text = message;
                div.classList.add('alert-warning');
                div.innerText = document.createTextNode(text).textContent;
                break;
            case 'not found':
                text = message;
                div.classList.add('alert-warning');
                div.innerText = document.createTextNode(text).textContent;
                break;
            case 'removed':
                text = 'Interest "' + interest + '" removed';
                div.classList.add('alert-warning');
                div.innerText = document.createTextNode(text).textContent;
                break;
            case 'error':
                text = message;
                div.classList.add('alert-danger');
                div.innerText = document.createTextNode(text).textContent;
                document.querySelector('#' + self.selector).value = '';
                break;
        }

        setTimeout(function () {
            div.innerText = document.createTextNode('').textContent;
            div.className = "hidden-xs-up p-x-3 p-y-1 m-b-2";
        }, 4000)
    }


};