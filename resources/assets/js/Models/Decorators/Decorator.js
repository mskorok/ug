
import { Element } from 'bunnyjs/src/bunny.element';

import { Lib } from './../Lib/Lib';
import { Listeners } from './../Listeners/Listeners';
import { Navbar } from "../../Components/Nav/Navbar";



export var Decorator = {

    createModelSteps: 3,
    contentPage: 2,


    hiddenClass: 'hidden-xs-up',
    sectionNewClassName: 'app-card app-p-card m-x-0 row',
    sectionClassName: 'col-xs-12 p-t-2 app-card-b-divide',
    responseClassName: 'row app-card m-x-0 app-p-card app-review-m-t-quarter hidden-xs-up',


    init(options) {
        this.modelStepPrefix = options.modelStepPrefix;
        this.postContainerId = options.postContainerId;
        this.appTopId = options.appTopId;
        this.appRowsId = options.appRowsId;
        this.postFormClass = options.postFormClass;
        this.replyClass = options.replyClass;
        this.createReplyClass = options.createReplyClass;
        this.responseClass = options.responseClass;
        this.likeClass = options.likeClass;
        this.createLikeClass = options.createLikeClass;
        this.recommendButtonId = options.recommendButtonId;
        this.likeModelClass = options.likeModelClass;
        this.createModelLikeClass = options.createModelLikeClass;
        this.prefix = options.prefix;
        this.likeModelUrl = options.likeReviewUrl;
        this.recommendButtonClass = options.recommendButtonClass;
        this.model = options.model;
    },

    newCommentDecorator(post, response) {
        let target;
        let section = document.createElement('div');
        if (response.newPost) {
            target = document.querySelector('#' + this.postContainerId);
            if(!target) return false;
            let div = document.createElement('div');
            div.classList.add('m-b-2');
            section.className = this.sectionNewClassName;
            section.setAttribute('data-post', response.postId);
            section.innerHTML = response.html;
            let resp_block = document.createElement('div');
            resp_block.className = this.responseClassName;
            resp_block.innerHTML = response.replyTitleHtml;
            div.appendChild(section);
            div.appendChild(resp_block);
            target.appendChild(div);
            let form = section.querySelector('.' + this.postFormClass);
            Listeners.addFormReplyListeners(section, form, response.postId);
        } else {
            target = document.querySelector('[data-post="' + post + '"]');
            if(!target) return false;
            let response_container;
            let post_container = target.parentNode;
            section.className = this.sectionClassName;
            response_container = post_container.getElementsByClassName(this.responseClass);
            if(response_container.length > 0) {
                section.innerHTML = response.html;
                response_container[0].appendChild(section);
                response_container[0].parentNode.classList.remove(this.hiddenClass)
            }
            let like_el = document.querySelector('[data-like="' + response.postId + '"]');
            Listeners.addCreateLikeListener(like_el);
        }
        let reply_container = document.querySelector('.' + this.replyClass + '[data-reply="' + post + '"]');
        if (reply_container) {
            reply_container.innerHTML = response.count;
        }
    },

    recommendDecorator() {

        let classes = document.getElementsByClassName(this.recommendButtonClass);

        classes.forEach((el) => {
            el.removeAttribute('role');
            el.classList.add('active');
        });
    },

    likeDecorator(response, options) {

        options = options || {};
        let likeClass = options.likeClass || this.likeClass;
        let createLikeClass = options.createLikeClass || this.createLikeClass;



        if (response.result) {
            let id = options.id  || response.id;
            if (!id) {
                return false;
            }
            let like_container = document.querySelector('.' + likeClass + '[data-like="' + id + '"]');
            let like_link = document.querySelector('.'+ createLikeClass +'[data-like="' + id + '"]');

            if (typeof like_link == 'object') {
                like_link.setAttribute('data-liked', '1');
                like_link.getElementsByTagName('svg')[0].classList.add('active');
            }
            like_container.innerHTML = response.count;
        } else {
            let like_link = document.querySelector('.' + createLikeClass + '[data-like="' + id + '"] > svg');
            if (typeof like_link == 'object') {
                like_link.removeAttribute('role');
            }
        }
    },

    showCommentForm(el) {
        let id = el.getAttribute('data-reply');
        let form = document.querySelector('form[data-form="' + id + '"]');
        if (form) {
            form.parentNode.classList.toggle(this.hiddenClass);
        }
    },

    showComments(button) {
        let parent = button.parentNode;
        let title = parent.nextSibling;
        let container = title.nextSibling;
        container.classList.remove(this.hiddenClass);
        title.classList.remove(this.hiddenClass);
        parent.classList.add(this.hiddenClass);
    },

    toStep(step) {
        let prefix =  this.modelStepPrefix;
        for (let i = 1; i< this.createModelSteps +1; i++) {
            let el = document.getElementById(prefix + i);
            if (el) {
                el.classList.add(this.hiddenClass);
            }
        }
        var step_el = document.getElementById(this.appTopId);
        step_el.innerHTML = step;
        document.getElementById(prefix +step).classList.remove(this.hiddenClass);

        Element.scrollTo(document.getElementsByTagName('section')[0], {duration: 500, offset: -Navbar.getHeight()});
        return false;
    },

    moreButtonDecorator(results, more_button, spinner) {
        if(results.success == true){
            var block = document.getElementById(this.appRowsId);
            var row = document.createElement("div");
            row.innerHTML = results.html;
            let options = {
                likeClass: this.likeModelClass,
                createLikeClass: this.createModelLikeClass,
                url: '/' + this.prefix + this.likeModelUrl,
                container: row
            };

            Listeners.createLikeListener(options);

            block.appendChild(row);
            spinner.remove(more_button);
            more_button.removeAttribute('disabled');
            if(this.contentPage >= results.lastPage) more_button.classList.add(this.hiddenClass);
            this.contentPage++;
        }
    },

    inviteDecorator(response) {

    }


};

