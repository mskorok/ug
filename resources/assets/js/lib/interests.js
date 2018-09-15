import { Ajax } from 'bunnyjs/src/bunny.ajax';
import { Autocomplete } from 'bunnyjs/src/bunny.autocomplete';
import './awesomplete';

export var Interests = {
    interestPage: 1,
    current_adventure: null,
    current_review: null,
    current_user: null,
    last_input_data: '',
    mode: 'edit',
    model: 'user',
    selector: 'autocomplete',
    autocomplete: {},
    autocompleteResolver: 'awesomplete',
    autocompleteSelectEvent: 'awesomplete-selectcomplete',
    buttonStyle: 'btn btn-info m-t-1 m-r-1 m-b-1',
    interests: 'interests',
    interestsAdd: 'interests-add',
    interestsHiddenBlock: 'interests_hidden_block',
    hiddenInterests: 'hidden_interests',
    interestsForCreationBlock: 'interests_for_creation',
    apiResult: 'create_interest_result',
    addInterestToUserButton: 'add_interest',
    addInterestToAdventureButton: 'add_interest_adventure',
    addInterestToReviewButton: 'add_interest_review',
    removeInterestButton: 'remove_interest',
    removeInterestAdventureButton: 'remove_interest_adventure',
    removeInterestReviewButton: 'remove_interest_review',
    loadMoreInterestButton: 'load_more_interest',
    firstInterestButton: 'first_user_interest',
    createInterestButton: 'create_interest',
    editInterestButton: 'edit_interest',
    deleteInterestButton: 'delete_interest',
    interestsUrl: '/api/v1/interests/',
    interestsAutocompleteUrl: '/api/v1/interests/?format=keyvalue&fields=name&limit=10&like[name]={search}',
    interestsListUrl: '/api/v1/interests/list',
    addInterestUrl: '/api/v1/interests/add/',
    editInterestUrl: '/api/v1/interests/edit/',
    addInterestToUserUrl: '/api/v1/users/add-interest/',//'/api/v1/interests/add-to-user/',
    removeInterestFromUserUrl: '/api/v1/users/remove-interest/',//'/api/v1/interests/remove-from-user/',
    refreshUserInterestsUrl: '/api/v1/users/interests/',//'/api/v1/interests/refresh-interests/',
    refreshAdventureInterestsUrl: '/api/v1/adventures/interests/',//'/api/v1/interests/refresh-adventure-interests/',
    addInterestToAdventureUrl: '/api/v1/adventures/add-interest/',//'/api/v1/interests/add-to-adventure/',
    removeInterestFromAdventureUrl: '/api/v1/adventures/remove-interest/',//'/api/v1/interests/remove-from-adventure/',
    refreshReviewsInterestsUrl: '/api/v1/review/interests/',//'/api/v1/interests/refresh-review-interests/',
    addInterestToReviewUrl: '/api/v1/review/add-interest/',//'/api/v1/interests/add-to-review/',
    removeInterestFromReviewUrl: '/api/v1/review/remove-interest/',//'/api/v1/interests/remove-from-review/',
    
    
    
    initAwesomplete(){
        this.autocomplete = new Awesomplete(document.querySelector('#' + this.selector), {list: []});
        return this.autocomplete;
    },
    
    fillInterestAwesompleteList() {
        if(this.autocompleteResolver === 'awesomplete') {
            var self = this;
            Ajax.get(self.interestsListUrl, function (data) {
                self.autocomplete.list = JSON.parse(data).map(function (i) {
                    return i.name;
                });
            });
        }

    },

    initBunnyAutocomplete() {


        //<div id="user_autocomplete_autocomplete"  class="dropdown">
        //    <input type="text" id="user_autocomplete"/>
        //    <input type="hidden" id="user_autocomplete_hidden"/>
        //</div>

        Autocomplete.create(
            this.selector,
            this.selector + '_hidden',
            this.interestsAutocompleteUrl,
            JSON.parse,
            { inputDelay: 300 }
        );

        return null;
    },

    addInterest(interest) {
        var self = this;
        interest = interest.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        var url = self.addInterestUrl + interest;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'success') {
                self.fillInterestAwesompleteList();
                self.interestApiResult(interest, res.action, null)
            } else if (res.action === 'exist') {
                self.interestApiResult(interest, res.action, null)
            } else if (res.action === 'error') {
                self.interestApiResult(interest, res.action, res.message)
            }
        });
    },
    addInterestToUser(interest) {
        var self = this;
        interest = interest.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');

        var url = self.addInterestToUserUrl + interest + '/' + this.current_user;

        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'added') {
                self.fillInterestAwesompleteList();
                self.interestApiResult(interest, res.action, res.message);
                self.refreshUserInterests();
                self.interestPage = 1;
                if(document.getElementById(self.interestsAdd)) {
                    document.getElementById(self.interestsAdd).innerHTML = '';
                }

                self.listInterests(mode);
            } else if (res.action === 'overflow') {
                self.interestApiResult(interest, res.action, res.message)
            } else if (res.action === 'error') {
                self.interestApiResult(interest, res.action, res.message)
            }
        });
    },
    removeInterestFromUser(interest) {
        var self = this;
        interest = interest.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        var url = self.removeInterestFromUserUrl + interest + '/' + this.current_user;

        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'removed') {
                self.fillInterestAwesompleteList();
                document.getElementById(self.selector).value = '';
                self.interestApiResult(interest, res.action, null);
                self.refreshUserInterests();
                self.interestPage = 1;
                if(document.getElementById(self.interestsAdd)) {
                    document.getElementById(self.interestsAdd).innerHTML = '';
                }

                self.listInterests(mode);
            } else if (res.action === 'error') {
                self.interestApiResult(interest, res.action, res.message)
            }
        });
    },
    refreshUserInterests(sign) {
        sign = sign || 'x';
        var self = this;
        var url = self.refreshUserInterestsUrl + this.current_user;

        Ajax.get(url, function (data) {
            var res = JSON.parse(data).map(function (i) {
                return i.name;
            });
            var html = '';
            res.forEach(function (item) {
                html += '<button  class="app-s-close ' + self.buttonStyle + '  refresh-buttons" data-item="' + item + '">' + item + ' '  + ' </button>'
            });
            document.getElementById(self.interests).innerHTML = html;
            var class_name = document.getElementsByClassName('refresh-buttons');

            for (var i = 0; i < class_name.length; i++) {
                class_name[i].addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var name = this.getAttribute('data-item');
                    self.removeInterestFromUser(name);
                });
            }
        });
    },
    listInterests(mode) {
        if ( typeof mode === 'undefined') {
            mode = this.mode;
        }
        var self = this;
        var url;
        switch (this.model) {
            case 'user' :
                url = self.refreshUserInterestsUrl + this.current_user + '/' + this.interestPage;
                break;
            case 'adventure' :
                url = self.refreshAdventureInterestsUrl + this.current_adventure + '/' + this.interestPage;
                break;
            case 'review' :
                url = self.refreshReviewsInterestsUrl + this.current_review + '/' + this.interestPage;
                break;
        }

        Ajax.get(url, function (data) {
            var res = JSON.parse(data).map(function (i) {
                return i.name;
            });
            var div = document.createElement('div');

            var html = '';
            res.forEach(function (item) {
                var id = item.replace(/\s+/g, '_');
                if (!(mode == 'create' && self.testForSelected(id))) {
                    html += '<button id="add-interest-buttons-' + id + '" class="' + self.buttonStyle +' add-interest-buttons" data-item="' + item + '">' + item + '  +</button>';
                }
            });
            div.innerHTML = html;
            if (document.getElementById(self.interestsAdd)) {
                document.getElementById(self.interestsAdd).appendChild(div);
                self.interestPage++;
                var class_name = document.getElementsByClassName('add-interest-buttons');
                for (var i = 0; i < class_name.length; i++) {
                    class_name[i].addEventListener('click', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var name = this.getAttribute('data-item');

                        if (mode == 'edit') {
                            switch (this.model) {
                                case 'user' :
                                    self.addInterestToUser(name);
                                    break;
                                case 'adventure' :
                                    self.addInterestToAdventure(name);
                                    break;
                                case 'review' :
                                    self.addInterestToReview(name);
                                    break;
                            }

                        } else if (mode == 'create') {
                            self.collectInterestsForCreation(name);
                        }
                    });
                }
            }
        });
    },
    collectInterestsForCreation(name, new_interest) {
        var self = this;
        new_interest = new_interest || null;
        var html;
        var id = name.replace(/\s+/g, '_');
        var el = document.getElementById(self.interestsHiddenBlock);
        var class_hidden = document.getElementsByClassName(self.hiddenInterests);
        if (class_hidden.length < 15) {
            if (el) {
                var i = document.createElement('input');
                i.setAttribute('type', 'hidden');
                i.setAttribute('name', 'interests[]');
                i.setAttribute('id', 'interest_hidden_field_' + id);
                i.setAttribute('class', self.hiddenInterests);
                i.setAttribute('value', name);
                document.getElementById(self.interestsHiddenBlock).appendChild(i);
                if (document.getElementById('create-interest-buttons-' + id)) {
                    document.getElementById('create-interest-buttons-' + id).classList.remove('hidden-xs-up');
                } else {
                    html = '<button id="create-interest-buttons-' + id + '" class="app-s-close ' + self.buttonStyle +' create-interest-buttons" data-item="' + name + '">' + name + ' </button>';
                    var div = document.createElement('div');
                    div.style.display = 'inline-block';
                    div.innerHTML = html;
                    document.getElementById(self.interestsForCreationBlock).appendChild(div);
                    if (new_interest) {
                        this.listSelected();
                    }
                    document.getElementById('create-interest-buttons-' + id).addEventListener('click', function (e) {


                        e.preventDefault();
                        e.stopPropagation();

                        if(document.getElementById('add-interest-buttons-' + id)) {
                            document.getElementById('add-interest-buttons-' + id).classList.remove('hidden-xs-up');
                        }
                        document.getElementById(self.interestsHiddenBlock).removeChild(document.getElementById('interest_hidden_field_' + id));
                        document.getElementById('create-interest-buttons-' + id).classList.add('hidden-xs-up');
                        return false;
                    });
                }
                if(document.getElementById('add-interest-buttons-' + id)) {
                    document.getElementById('add-interest-buttons-' + id).classList.add('hidden-xs-up');
                }

            }
        }
    },
    createFromInput() {
        var self = this;
        if ( typeof mode === 'undefined') {
            let mode = this.mode;
        }
        var name = document.getElementById(self.selector).value;

        if (name == '') {
            return false;
        }
        var id = name.replace(/\s+/g, '_');
        if (this.testForSelected(id)) {
            console.log('already selected');
            return true;
        }
        var url = self.interestsListUrl;

        Ajax.get(url, function (data) {
            var list = JSON.parse(data).map(function (i) {
                return i.name;
            });

            if (list.indexOf(name) > -1) {
                self.collectInterestsForCreation(name);
                self.interestPage = 1;
                self.listInterests(mode)
            } else {
                self.createInterest(name);
            }
        });

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
        if(document.getElementById(self.interestsAdd)) {
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
                    switch (self.model) {
                        case 'user' :
                            self.addInterestToUser(name);
                            break;
                        case 'adventure' :
                            self.addInterestToAdventure(name);
                            break;
                        case 'review' :
                            self.addInterestToReview(name);
                            break;
                    }

                } else if (mode == 'create') {
                    self.collectInterestsForCreation(name);
                }

            });
            class_name[j].classList.add('hidden-xs-up');
        }
        this.interestPage = 1;
    },
    createInterest (name) {
        var self = this;
        if (name == '') {
            return false;
        }
        var url = self.addInterestUrl + name;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);

            if (res.action == 'success') {

                self.fillInterestAwesompleteList();
                self.collectInterestsForCreation(name, true);
                self.interestPage = 1;
                self.listInterests();

            }
        });

    },
    editInterest(interest) {
        var self = this;
        var message, old = this.last_input_data;
        var url = self.editInterestUrl + old + '/' + interest;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'edited') {
                self.fillInterestAwesompleteList();
                message = 'Interest ' + old + ' successfully renamed to ' + interest;
                self.interestApiResult(interest, res.action, message)
            } else if (res.action === 'not found') {
                message = 'Interest ' + old + ' not found';
                self.interestApiResult(interest, res.action, message)
            }
        });
    },
    deleteInterest(interest) {
        var self = this;
        interest = interest.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        var url = self.interestsUrl + interest + '/delete';
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'deleted') {
                self.fillInterestAwesompleteList();
                self.interestApiResult(interest, res.action, null)
            } else if (res.action === 'not fount') {
                self.interestApiResult(interest, res.action, null)
            }
        });
    },
    checkInputChanges() {
        var self = this;
        var value = document.getElementById(self.selector).value;
        value.trim();
        var url = self.interestsListUrl;
        Ajax.get(url, function (data) {
            var list = JSON.parse(data).map(function (i) {
                return i.name;
            });
            if (list.indexOf(value) > -1) {
                self.last_input_data = value;
            }
        });
    },
    refreshAdventuresInterests(sign) {
        sign = sign || 'x';
        var self = this;
        var url = self.refreshAdventureInterestsUrl + this.current_adventure;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data).map(function (i) {
                return i.name;
            });
            var html = '';
            res.forEach(function (item) {
                html += '<button  class="app-s-close ' + self.buttonStyle + ' refresh-buttons" data-item="' + item + '">' + item + ' ' + ' </button>'
            });
            document.getElementById(self.interests).innerHTML = html;
            var class_name = document.getElementsByClassName('refresh-buttons');
            for (var i = 0; i < class_name.length; i++) {
                class_name[i].addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var name = this.getAttribute('data-item');
                    self.removeInterestFromAdventure(name);
                });
            }
        });
    },
    addInterestToAdventure(interest) {
        var self = this;
        interest = interest.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        var url = self.addInterestToAdventureUrl + interest + '/' + this.current_adventure;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);

            if (res.action === 'added') {
                self.fillInterestAwesompleteList();
                self.interestApiResult(interest, res.action, res.message);
                self.refreshAdventuresInterests();
            } else if (res.action === 'overflow') {
                self.interestApiResult(interest, res.action, res.message)
            } else if (res.action === 'error') {
                self.interestApiResult(interest, res.action, res.message)
            }
        });
    },
    removeInterestFromAdventure(interest) {
        var self = this;
        interest = interest.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        var url = self.removeInterestFromAdventureUrl + interest + '/' + this.current_adventure;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'removed') {
                self.fillInterestAwesompleteList();
                document.getElementById(self.selector).value = '';
                self.interestApiResult(interest, res.action, null);
                self.refreshAdventuresInterests();
            } else if (res.action === 'error') {
                self.interestApiResult(interest, res.action, res.message);
            }
        });
    },
    refreshReviewsInterests(sign) {
        sign = sign || 'x';
        var self = this;
        var url = self.refreshReviewsInterestsUrl + this.current_review;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data).map(function (i) {
                return i.name;
            });
            var html = '';
            res.forEach(function (item) {
                html += '<button  class="app-s-close ' + self.buttonStyle + ' refresh-buttons" data-item="' + item + '">' + item + ' ' + ' </button>'
            });
            document.getElementById(self.interests).innerHTML = html;
            var class_name = document.getElementsByClassName('refresh-buttons');
            for (var i = 0; i < class_name.length; i++) {
                class_name[i].addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var name = this.getAttribute('data-item');
                    self.removeInterestFromReview(name);
                });
            }
        });
    },
    addInterestToReview(interest) {
        var self = this;
        interest = interest.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        var url = self.addInterestToReviewUrl + interest + '/' + this.current_review;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'added') {
                self.fillInterestAwesompleteList();
                self.interestApiResult(interest, res.action, res.message);
                self.refreshReviewsInterests();
            } else if (res.action === 'overflow') {
                self.interestApiResult(interest, res.action, res.message)
            } else if (res.action === 'error') {
                self.interestApiResult(interest, res.action, res.message)
            }
        });
    },
    removeInterestFromReview(interest) {
        var self = this;
        interest = interest.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        var url = self.removeInterestFromReviewUrl + interest + '/' + this.current_review;
        Ajax.get(url, function (data) {
            var res = JSON.parse(data);
            if (res.action === 'removed') {
                self.fillInterestAwesompleteList();
                document.getElementById(self.selector).value = '';
                self.interestApiResult(interest, res.action, null);
                self.refreshReviewsInterests();
            } else if (res.action === 'error') {
                self.interestApiResult(interest, res.action, res.message);
            }
        });
    },
    interestApiResult(interest, action, message) {
        var self = this;
        var div = document.getElementById(self.apiResult);
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
    },
    initInterests(){
        var self = this;

        if (document.getElementById(this.selector)) {

            if (this.autocompleteResolver === 'awesomplete') {
                this.autocomplete = this.initAwesomplete();
                this.fillInterestAwesompleteList();
            } else if (this.autocompleteResolver === 'bunny') {
                this.autocomplete = this.initBunnyAutocomplete();
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
                            switch (self.model) {
                                case 'user' :
                                    self.addInterestToUser(interest);
                                    break;
                                case 'adventure' :
                                    self.addInterestToAdventure(interest);
                                    break;
                                case 'review' :
                                    self.addInterestToReview(interest);
                                    break;
                            }
                        } else {
                            self.createFromInput();
                        }

                    } else {
                        console.log('zero input');
                    }
                }
            });
            let el_user = document.querySelector('[data-user]');

            if (el_user) {
                this.current_user = el_user.getAttribute('data-user');
            }
            let el_adventure = document.querySelector('[data-adventure]');

            if (el_adventure) {
                this.current_adventure = el_adventure.getAttribute('data-adventure');
            }
            let el_review = document.querySelector('[data-review]');

            if (el_review) {
                this.current_review = el_review.getAttribute('data-review');
            }


        }

        if (document.getElementById(self.interests)) {

            switch (self.model) {
                case 'user' :
                    self.refreshUserInterests();
                    break;
                case 'adventure' :
                    self.refreshAdventuresInterests();
                    break;
                case 'review' :
                    self.refreshReviewsInterests();
                    break;
            }
        }

        if (document.getElementById(self.addInterestToUserButton)) {
            document.getElementById(self.addInterestToUserButton).addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var interest = document.getElementById(self.selector).value;
                interest.trim();
                if (interest.length && interest.length > 3) {
                    self.addInterestToUser(interest);
                } else {
                    console.log('zero input');
                }
            });
        }

        if (document.getElementById(self.addInterestToAdventureButton)) {
            document.getElementById(self.addInterestToAdventureButton).addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var interest = document.getElementById(self.selector).value;
                interest.trim();
                if (interest.length && interest.length > 3) {
                    self.addInterestToAdventure(interest);
                } else {
                    console.log('zero input');
                }
            });
        }

        if (document.getElementById(self.addInterestToReviewButton)) {
            document.getElementById(self.addInterestToReviewButton).addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var interest = document.getElementById(self.selector).value;
                interest.trim();
                if (interest.length && interest.length > 3) {
                    self.addInterestToReview(interest);
                } else {
                    console.log('zero input');
                }
            });
        }

        if (document.getElementById(self.removeInterestButton)) {
            document.getElementById(self.removeInterestButton).addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var interest = document.getElementById(self.selector).value;
                interest.trim();
                if (interest !== '') {
                    self.removeInterestFromUser(interest);
                } else {
                    console.log('zero input');
                }
            });
        }

        if (document.getElementById(self.removeInterestAdventureButton)) {
            document.getElementById(self.removeInterestAdventureButton).addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var interest = document.getElementById(self.selector).value;
                interest.trim();
                if (interest !== '') {
                    self.removeInterestFromAdventure(interest);
                } else {
                    console.log('zero input');
                }
            });
        }

        if (document.getElementById(self.removeInterestReviewButton)) {
            document.getElementById(self.removeInterestReviewButton).addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var interest = document.getElementById(self.selector).value;
                interest.trim();
                if (interest !== '') {
                    self.removeInterestFromReview(interest);
                } else {
                    console.log('zero input');
                }
            });
        }

        if (document.getElementById(self.interestsAdd)) {
            self.listInterests(mode);
        }

        if (document.getElementById(self.loadMoreInterestButton)) {
            document.getElementById(self.loadMoreInterestButton).addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                self.listInterests(mode);
            });
        }

        if (document.getElementById(this.firstInterestButton)) {

            document.getElementById(this.firstInterestButton).addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                self.createFromInput();
            });
        }

        if (document.getElementById(self.createInterestButton)) {
            document.getElementById(self.createInterestButton).addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var interest = document.getElementById(self.selector).value;
                interest.trim();
                if (interest !== '') {
                    self.addInterest(interest);
                } else {
                    console.log('zero input');
                }
            });
        }

        if (document.getElementById(self.editInterestButton)) {
            document.getElementById(self.editInterestButton).addEventListener('click', function (e) {
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

        if (document.getElementById(self.deleteInterestButton)) {
            document.getElementById(self.deleteInterestButton).addEventListener('click', function (e) {
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
};