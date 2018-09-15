import { Ajax } from 'bunnyjs/src/bunny.ajax';
import { Validate } from 'bunnyjs/src/bunny.validate';
import { DatePicker } from 'bunnyjs/src/bunny.datepicker';
import { Element } from 'bunnyjs/src/bunny.element';
import { TabList } from 'bunnyjs/src/bunny.tablist';
import { Spinner } from './spinner';
import { GoogleGeo } from './google';
import { Autocomplete } from 'bunnyjs/src/bunny.autocomplete';
import './awesomplete';
import { Navbar } from "../Components/Nav/Navbar";

export var Adventures = {

    autocomplete: {},
    autocompleteResolver: 'awesomplete',
    geo: GoogleGeo,
    geoOption: {
        nameSelector: 'place_name',
        locationSelector:'place_location',
        idSelector: 'place_id',
        latSelector: 'location_lat',
        lngSelector: 'location_lng',
        countrySelector: 'country_name'
    },
    model: 'adventure',
    like_mode: 'activity_comment',
    dateFields: ['datetime_from', 'datetime_to'],
    anchors: {
        email: 'user_email',
        about: 'user_about',
        birth: 'user_birth',
        image: 'user_image',
        id:    'user_id'
    },
    adventPage: 2,
    // bool
    adminValidate: true,
    appValidate: false,
    submitPermission: false,
    // url
    userAwesompleteUrl: '/api/v1/users/string/',//'/api/v1/adventures/users',
    activityAwesompleteUrl: '',
    reviewAwesompleteUrl: '',

    awesompleteUrl: '/api/v1/users/string/',//'/api/v1/adventures/users',
    userDataUrl: '/api/v1/users/userId/',//'/api/v1/adventures/userId/',

    activitiesContentUrl: '/activities?page=',
    reviewsContentUrl: '/reviews?page=',

    activityInviteUrl: '/api/v1/adventures/invite',
    reviewInviteUrl: '/api/v1/adventures/invite',

    likeActivityPostUrl: '/api/v1/activity_comments/like/',
    likeReviewPostUrl: '/api/v1/review_comments/like/',
    likeAdventureUrl: '/api/v1/adventures/like/',
    likeReviewUrl: '/api/v1/reviews/like/',
    replyUrl: '/api/v1/activity_comments/reply/',
    //replyUrl: '/api/v1/review_comments/reply/',



    // events
    autocompleteSelectEvent: 'awesomplete-selectcomplete',
    // id
    adminFormId: 'add_edit_activities_form',
    appFormId: 'add_edit_activities_form',
    userAutocompleteId: 'user_autocomplete',

    adventAutocompleteId: 'advent_autocomplete',
    adventInviteFormId: 'activity_invited',
    inviteButtonId: 'activity_invited_submit_button',



    appTopId: 'app_new_activities_top_step',
    postContainerId: 'app_activity_post_container',
    postPreviewContainerId: 'preview_container',
    moreButtonId: 'app_button_more',
    selectPromoImageButtonId: 'select_promo_image',
    promoImageInputId: 'promo_image',
    appRowsId: 'app_activity_rows',

    adventStepId: 'app_new_activities_step',
   
    // class
    appDropdownClass: 'app-dropdown',
    hiddenClass: 'hidden-xs-up',
    stepClassName: 'app-new-activities-step',
    nextStepsClass: 'app-new-activities-next',
    backStepsClass: 'app-new-activities-back',
    likeActivityPostClass: 'app-activity-post-like-data',
    createLikeActivityPostClass: 'app-activity-post-like',
    likeReviewPostClass: 'app-review-post-like-data',
    createLikeReviewPostClass: 'app-review-post-like',
    likeAdventureClass: 'app-activity-like-data',
    createLikeAdventureClass: 'app-activity-like',
    likeReviewClass: 'app-review-like-data',
    createLikeReviewClass: 'app-review-like',



    replyClass: 'app-activity-reply-data',
    createReplyClass: 'app-activity-reply',
    replyBottomBorderClass: 'app-card-b-divider',
    postFormClass: 'app-activity-response-form',
    responseTitleClass: 'app-responses-title',
    responseClass: 'app-responses-block',
    responseClassName: 'row app-card m-x-0 app-p-card app-activity-m-t-quarter hidden-xs-up',
    appCardClass: 'app-card',
    // html

    sections: {
        1: document.getElementById('app_new_activities_step1'),
        2: document.getElementById('app_new_activities_step2'),
        3: document.getElementById('app_new_activities_step3'),
        4: document.getElementById('app_new_activities_step4'),
        5: document.getElementById('app_new_activities_step5')
    },



    initGeoComplete(id) {
        this.geo.init(this, id);
    },

    initAwesomplete(selector) {

        //<input id="new_activity_interest_autocomplete" class="awesomplete" type="text" name="autocomplete">


        var url = this.awesompleteUrl;

        Ajax.get(url, function(data) {
            new Awesomplete(document.querySelector('#'+ selector),{ list: JSON.parse(data) });
        });
    },

    initBunnyAutocomplete(selector) {
        //<div id="user_autocomplete_autocomplete"  class="dropdown">
        //    <input type="text" id="user_autocomplete"/>
        //    <input type="hidden" id="user_autocomplete_hidden"/>
        //</div>


        Autocomplete.create(
            selector,
            selector + '_hidden',
            this.awesompleteUrl + '?like[name]={search}',
            JSON.parse,
            { inputDelay: 300 }
        );
    },

    refreshUser(selector) {
        var self = this;
        var val =  document.getElementById(selector).value;
        val = val.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        if(val == '') {
            return false;
        }
        var url = self.userDataUrl + val;

        Ajax.get(url, function(data) {
            var result = JSON.parse(data);

            if (typeof result === 'string' && result == 'error'){
                document.getElementById(selector).value = document.getElementById('user_id').value;
                console.log('error refreshUser');
            } else {
                if (document.getElementById(self.anchors.email)) {
                    document.getElementById(self.anchors.email).innerText = document.createTextNode(result.email).textContent;
                } else {
                    console.log('email anchor not found');
                }
                if (document.getElementById(self.anchors.about)) {
                    document.getElementById(self.anchors.about).innerText = document.createTextNode(result.about).textContent;
                } else {
                    console.log('about anchor not found');
                }
                if (document.getElementById(self.anchors.birth)) {
                    document.getElementById(self.anchors.birth).innerText = document.createTextNode(result.birth_date).textContent;
                } else {
                    console.log('birth anchor not found');
                }
                if (document.getElementById(self.anchors.image)) {
                    document.getElementById(self.anchors.image).setAttribute('src', result.photo_path);
                } else {
                    console.log('image anchor not found');
                }
                if (document.getElementById(self.anchors.id)) {
                    document.getElementById(self.anchors.id).value = document.getElementById(selector).value;
                } else {
                    console.log('id anchor not found');
                }

            }
        });
    },

    getNode(el) {
        return (typeof el === 'object') ? el : document.getElementById(el);
    },

    addUserRefreshEventListeners(selector) {
        var self = this;
        let el = document.getElementById(selector);
        if(el) {
            el.addEventListener('blur', function () {
                self.refreshUser(selector);
            });
            el.addEventListener(self.autocompleteSelectEvent, function () {
                self.refreshUser(selector);
            });
        }
    },

    addReplyEventListener(selector) {
        var self = this;
        let reply = this.getNode(selector);

        reply.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            self.showPostForm(reply);
        })
    },

    addLikeEventListener(selector) {
        var self = this;
        let like = this.getNode(selector);

        like.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            self.createLike(like);
        })
    },

    addFormKeyDownListener(selector) {
        var self = this;
        let form = this.getNode(selector);

        form.addEventListener('keydown', function (e) {
            if (e.keyCode == 13) {

                if (form.tagName.toLowerCase() == 'form') {

                    self.sendPostForm(form);
                }
            }
        });
    },

    refreshActivity(selector) {
        //TODO
    },

    addActivityRefreshEventListeners(selector) {
        var self = this;
        let el = document.getElementById(selector);
        if(el) {
            el.addEventListener('blur', function () {
                self.refreshActivity(selector);
            });
            el.addEventListener(self.autocompleteSelectEvent, function () {
                self.refreshActivity(selector);
            });
        }
    },



    checkSubmit() {
        let self = this;
        document.forms[this.appFormId].addEventListener('submit', (e) => {
            if(self.submitPermission) {
                return true;
            } else {
                e.stopPropagation();
                e.preventDefault();
                return false;
            }
        })
    },


    cancelCreation(el) {
        if (el.href) {
            window.location.href = el.href;
        }
    },

    toStep(step) {
        var self = this;
        let steps = [1,2,3,4,5];
        let stepId =  this.adventStepId;


        steps.forEach( (i) => {

            let el = document.getElementById(stepId + i);
            if (el) {
                el.classList.add(self.hiddenClass);
            }
        });

        var step_el = document.getElementById(this.appTopId);
        step_el.innerHTML = step;
        document.getElementById(stepId +step).classList.remove(self.hiddenClass);

        Element.scrollTo(document.getElementById(this.appFormId), {duration: 1000, offset: -Navbar.getHeight()});

        return false;
    },

    createLike(el) {



        if(el.hasAttribute('data-liked')) {
            return false;
        }

        let id = el.getAttribute('data-like');
        let url, like_class, create_like_class;

        switch (this.like_mode) {
            case 'activity_comment' :
                url = this.likeActivityPostUrl;
                like_class = this.likeActivityPostClass;
                create_like_class = this.createLikeActivityPostClass;
                break;
            case 'review_comment' :
                url = this.likeReviewPostUrl;
                like_class = this.likeReviewPostClass;
                create_like_class = this.createLikeReviewPostClass;
                break;
            case 'adventure' :
                url = this.likeAdventureUrl;
                like_class = this.likeAdventureClass;
                create_like_class = this.createLikeAdventureClass;
                break;
            case 'review' :
                url = this.likeReviewUrl;
                like_class = this.likeReviewClass;
                create_like_class = this.createLikeReviewClass;
                break;
            default:
                break;
        }

        url = url + id;

        Ajax.get(url, function (data) {
            var response = JSON.parse(data);

            if (response.result) {

                let like_container = document.querySelector('.' + like_class + '[data-like="' + id + '"]');

                let like_link = document.querySelector('.'+ create_like_class +'[data-like="' + id + '"]');

                if (typeof like_link == 'object') {
                    like_link.setAttribute('data-liked', '1');


                    like_link.getElementsByTagName('svg')[0].classList.add('active');
                }
                like_container.innerHTML = response.count;
            } else {
                let like_link = document.querySelector('.'+create_like_class+'[data-like="' + id + '"] > svg');

                if (typeof like_link == 'object') {
                    like_link.removeAttribute('role');
                }
            }
        });
    },



    showPostForm(el) {
        let self =  this;

        let id = el.getAttribute('data-reply');
        let form = document.querySelector('form[data-form="' + id + '"]');
        if (form) {
            form.parentNode.classList.toggle(self.hiddenClass);
        }
    },

    createActivity() {
        this.submitPermission = true;
        let buttons =document.getElementsByClassName(this.nextStepsClass);
        let submit_button = buttons.item(buttons.length -1);
        if (submit_button) submit_button.setAttribute('disabled', 'disabled');
        console.log(submit_button);
        document.forms[this.appFormId].submit();
    },

    sendPostForm(form){
        if (!(form instanceof Node  && form.tagName.toLowerCase() == 'form')) {
            return false;
        }

        let self = this;

        let inputs = form.getElementsByTagName("input");

        let textarea = form.getElementsByTagName("textarea");
        let post = inputs[0].value;
        if (post == '') {
            post = 'null';
        }
        let url = this.replyUrl + post;

        let formData = new FormData(form);
        //let preview_container = document.getElementById(this.postPreviewContainerId);
        let ajax = new XMLHttpRequest();


        //preview_container.innerHTML = '';
        textarea[0].value = null;

        ajax.open('POST', url, true);
        ajax.setRequestHeader('X-Requested-With','XMLHttpRequest' );
        ajax.onload = () => {

            if (ajax.readyState === XMLHttpRequest.DONE && ajax.status == 200) {

                let response = JSON.parse(ajax.responseText);

                if (response.result) {
                    let target;
                    let section = document.createElement('div');

                    if (response.newPost) {

                        target = document.querySelector('#' + self.postContainerId);
                        if(!target) {
                            return false;
                        }
                        let div = document.createElement('div');
                        div.classList.add('m-b-2');

                        section.classList.add('row');
                        section.classList.add(this.appCardClass);
                        section.classList.add('app-p-card');
                        section.classList.add('m-x-0');
                        section.setAttribute('data-post', response.postId);

                        section.innerHTML = response.html;
                        let resp_block = document.createElement('div');
                        resp_block.className = self.responseClassName;


                        resp_block.innerHTML = response.replyTitleHtml;

                        div.appendChild(section);
                        div.appendChild(resp_block);
                        target.appendChild(div);


                        let reply = section.querySelector('[data-reply="' + response.postId + '"]');
                        let like = section.querySelector('[data-like="' + response.postId + '"]');
                        let form = section.querySelector('.' + self.postFormClass);

                        like.removeAttribute('href');
                        self.addReplyEventListener(reply);
                        //self.addLikeEventListener(like);
                        self.addFormKeyDownListener(form);



                    } else {
                        target = document.querySelector('[data-post="' + post + '"]');

                        if(!target) {
                            return false;
                        }
                        let response_container;
                        let post_container = target.parentNode;
                        section.classList.add('col-xs-12');
                        section.classList.add('p-t-2');
                        section.classList.add(self.replyBottomBorderClass);
                        response_container = post_container.getElementsByClassName(self.responseClass);

                        if(response_container.length > 0) {
                            section.innerHTML = response.html;

                            response_container[0].appendChild(section);
                            response_container[0].parentNode.classList.remove(self.hiddenClass)
                        }

                        let like = document.querySelector('[data-like="' + response.postId + '"]');
                        self.addLikeEventListener(like);
                    }
                    let reply_container = document.querySelector('.' + self.replyClass + '[data-reply="' + post + '"]');
                    if (reply_container) {
                        reply_container.innerHTML = response.count;
                    }
                } else {

                }
            }
        };

        ajax.send(formData);
    },


    sendInvites() {
        let self =  this;
        let form = document.forms[this.adventInviteFormId];
        let formData = new FormData(form);
        let ajax = new XMLHttpRequest();
        let url = (this.model == 'adventure') ? this.activityInviteUrl : this.reviewInviteUrl;

        ajax.open('POST', url, true);
        ajax.setRequestHeader('X-Requested-With','XMLHttpRequest' );
        ajax.onload = () => {

            if (ajax.readyState === XMLHttpRequest.DONE && ajax.status == 200) {

                let response = JSON.parse(ajax.responseText);

                //TODO handle response
            }
        };

        ajax.send(formData);
    },

    initInviteFriends() {
        let self =  this;
        

            let button = document.getElementById(this.inviteButtonId);
        if (button) {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();
                self.sendInvites();
            })
        }
    },

    initStepControls() {
        var self =  this;
        var next_steps = document.getElementsByClassName(this.nextStepsClass);
        var back_steps = document.getElementsByClassName(this.backStepsClass);

        next_steps.forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var step = parseInt(this.getAttribute('data-step'));
                switch (step) {
                    case 1:
                        self.ckeEditorToTextarea();
                        if (self.validateStep(1)) {
                            self.toStep(2);
                        }
                        break;
                    case 2:
                        self.ckeEditorToTextarea();
                        if (self.validateStep(2)) {
                            self.toStep(3);
                        }
                        break;
                    case 3:
                        self.ckeEditorToTextarea();
                        if (self.validateStep(3)) {
                            self.toStep(4);
                        }
                        break;
                    case 4:
                        self.ckeEditorToTextarea();
                        if (self.validateStep(4)) {
                            self.toStep(5);
                        }
                        break;
                    case 5:
                        self.ckeEditorToTextarea();
                        if (self.validateStep(5)) {
                            self.createActivity();
                        }
                        break;
                    default:
                        break;
                }
                return false;
            });
        });

        back_steps.forEach(function (el) {
            el.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                var step = parseInt(this.getAttribute('data-step'));
                switch (step) {
                    case 1:
                        self.cancelCreation(el);
                        break;
                    case 2:
                        self.toStep(1);
                        break;
                    case 3:
                        self.toStep(2);
                        break;
                    case 4:
                        self.toStep(3);
                        break;
                    case 5:
                        self.toStep(4);
                        break;
                    default:
                        break;
                }
                return false;
            });
        });
    },
    /**
     * Validate step
     * @param {number} step
     * @returns {bool}
     */
    validateStep(step) {
        return Validate.validateSection(this.sections[step]);
    },

    setRequired(id){
        let el = document.getElementById(id);
        if(el) {
            el.setAttribute('required', 'required');
        }
    },

    ckeEditorToTextarea() {
        if( typeof CKEDITOR !== 'undefined') {
            for(var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();
        }
    },

    initPostSubmit() {
        var self = this;
        document.getElementsByClassName(this.postFormClass).forEach((el) => {
            el.addEventListener('keydown', function (e) {
                if (e.keyCode == 13) {
                    if (el.tagName.toLowerCase() == 'form') {
                        self.sendPostForm(el);
                    }
                }
            });
        })
    },

    initDropdown() {
        var elements =  document.getElementsByClassName(this.appDropdownClass);

        elements.forEach(function(el) {
            el.addEventListener('click', function (e) {
                e.stopPropagation();
            });
        });
    },

    initDatePicker() {
        this.dateFields.forEach(function(item) {
            let i;
            if(document.getElementById(item)) {
               i = DatePicker.create(item, {onlyAsNativeFallback: false});
            }
            //console.log(item, i);
        });
    },

    initMoreButton(selector) {
        var self = this;

        var more_button = document.getElementById(selector);

        var selected = document.querySelectorAll('[name^=categories][checked]');
        var qs = '';
        selected.forEach((el) => {
            qs += '&'+ el.name + '=1';
        });


        if (more_button) {
            more_button.addEventListener('click', function () {
                Spinner.add(more_button);
                setTimeout(() => {
                    Spinner.remove(more_button);
                }, 2000);
                let url, create_like_class;
                switch (self.model) {
                    case 'adventure' :
                        url = self.activitiesContentUrl;
                        break;
                    case 'review' :
                        url = self.reviewsContentUrl;
                        break;
                    default:
                        break;

                }
               
                url = url +self.adventPage + qs;


                switch (self.like_mode) {
                    case 'adventure' :
                        create_like_class = self.createLikeAdventureClass;
                        break;
                    case 'review' :
                        create_like_class = self.createLikeReviewClass;
                        break;
                    default:
                        break;
                }



                Ajax.get(url, function (data) {

                    var results = JSON.parse(data);
                    if(results.success == true){
                        if(self.adventPage >= results.lastPage) {
                            document.getElementById(selector).classList.add(self.hiddenClass);
                        }
                        var block = document.getElementById(self.appRowsId);
                        var row = document.createElement("div");
                        row.classList.add('row');
                        row.innerHTML = results.html;
                        let like_classes = row.querySelectorAll('.' + create_like_class + '[data-like]');
                        like_classes.forEach( (el) => {
                            el.addEventListener('click', (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                self.createLike(el);
                            })
                        });

                        block.appendChild(row);
                        Spinner.remove(more_button);
                        self.adventPage++;
                    }
                });

            });
        }
    },

    activitiesInit() {
        var self = this;
        this.initDropdown();
        if(document.getElementById(this.moreButtonId)) {
            this.initMoreButton(this.moreButtonId);
        }
        let create_like_class;
        switch (this.like_mode) {
            case 'adventure' :
                create_like_class = this.createLikeAdventureClass;
                break;
            case 'review' :
                create_like_class = this.createLikeReviewClass;
                break;
            default:
                break;
        }

        let like_classes = document.querySelectorAll('.' + create_like_class + '[data-like]');
        like_classes.forEach( (el) => {
            el.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                self.createLike(el);
            })
        });
    },

    createEditAdventureInit(){
        this.initDropdown();
        this.checkSubmit();

        //this.geo.resolveLocationData(this.geoOption);

        if(document.getElementById(this.userAutocompleteId)) {
            if(this.autocompleteResolver === 'bunny') {
                this.initBunnyAutocomplete(this.userAutocompleteId);
            } else if (this.autocompleteResolver === 'awesomplete') {
                this.initAwesomplete(this.userAutocompleteId);
            }
            this.addUserRefreshEventListeners(this.userAutocompleteId);
            this.refreshUser(this.userAutocompleteId);
        }

        if(document.getElementById(this.adventAutocompleteId)) {
            this.awesompleteUrl = this.activityAwesompleteUrl;
            this.addActivityRefreshEventListeners(this.adventAutocompleteId);
            this.initAwesomplete(this.adventAutocompleteId);
            this.refreshActivity(this.adventAutocompleteId);
        }

        if(document.getElementById(this.selectPromoImageButtonId)) {
            document.getElementById(this.selectPromoImageButtonId).addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                document.getElementById(this.promoImageInputId).click();
            });

        }

        this.initGeoComplete(this.geoOption.nameSelector);
//        this.initDatePicker();
    },

    activityInit() {
        let self = this;
        this.initDropdown();
        this.initPostSubmit();
        let create_like_class;

        switch (this.like_mode) {
            case 'activity_comment' :
                create_like_class = this.createLikeActivityPostClass;
                break;
            case 'review_comment' :
                create_like_class = this.createLikeReviewPostClass;
                break;
            case 'adventure' :
                create_like_class = this.createLikeAdventureClass;
                break;
            case 'review' :
                create_like_class = this.createLikeReviewClass;
                break;
            default:
                break;
        }

        let like_classes = document.querySelectorAll('.'+ create_like_class +'[data-like]');
        like_classes.forEach( (el) => {
            el.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                self.createLike(el);
            })
        });
        let reply_classes = document.querySelectorAll('.'+this.createReplyClass+'[data-reply]');
        reply_classes.forEach( (el) => {
            el.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                self.showPostForm(el);
            })
        });
    }
};
