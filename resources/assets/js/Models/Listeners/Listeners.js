import { Lib } from './../Lib/Lib';
import { Autocomplete } from 'bunnyjs/src/bunny.autocomplete';
import { DatePicker } from 'bunnyjs/src/bunny.datepicker';
import { Validate } from 'bunnyjs/src/bunny.validate';


export var Listeners = {
    options: {},
    appDropdownClass: 'app-dropdown',
    dateFields: ['datetime_from', 'datetime_to'],
    autocompleteUrl: '/interests/?format=keyvalue&fields=name&limit=10&like[name]={search}',
    selectPromoImageButtonId: 'select_promo_image',
    promoImageInputId: 'promo_image',
    selectGalleryButtonId: 'select_gallery',
    galleryInputId:'gallery',
    inviteFormId: 'activity_invited',
    inviteButtonId: 'activity_invited_submit_button',

    init(options) {
        Lib.options = options;
        this.options = options;
    },

    showCommentFormListener() {
        let self = this;
        let reply_classes = document.querySelectorAll('.'+ this.options.createReplyClass+'[data-reply]');
        reply_classes.forEach( (el) => {
            el.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                self.options.decorator.showCommentForm(el);
            })
        });
    },

    submitCommentFormListener() {
        document.getElementsByClassName(this.options.postFormClass).forEach((form) => {
            form.addEventListener('keydown', (e) => {
                if (e.keyCode == 13) {
                    if (form.tagName.toLowerCase() == 'form') {
                        Lib.sendCommentForm(form)
                    }
                }
            });
        });
    },

    deleteCommentListener() {
        let elements = document.querySelectorAll('.'+ this.options.deleteCommentClass + '[data-comment]');
        elements.forEach((el) => {
            var comment = parseInt(el.getAttribute('data-comment'));
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                Lib.deleteComment(comment)
            });
        });
    },

    dropdownListener() {
        var elements =  document.getElementsByClassName(this.appDropdownClass);
        elements.forEach((el) => {
            el.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
    },

    datePickerListener() {
        this.dateFields.forEach((item) => {
            if(document.getElementById(item)) DatePicker.create(item, {onlyAsNativeFallback: false});
        });
    },

    createLikeListener(options) {
        options = options || {};

        let container = options.container || document;
        let createLikeClass = options.createLikeClass || this.options.createLikeClass;

        let like_classes = container.querySelectorAll('.' + createLikeClass + '[data-like]');
        if(like_classes) {
            like_classes.forEach( (el) => {
                el.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    Lib.createLike(el, options);
                })
            });
        }

    },

    checkSubmitListener() {
        let self = this;
        document.forms[this.options.appFormId].addEventListener('submit', (e) => {
            if(self.options.submitPermission) {
                return true;
            } else {
                e.stopPropagation();
                e.preventDefault();
                return false;
            }
        })
    },

    nextStepListener() {
        let self = this;
        var next_steps = document.getElementsByClassName(this.options.nextStepsClass);
        let len = next_steps.length;
        let submit_button = next_steps.item(len -1);
        next_steps.forEach((el) =>  {
            el.addEventListener('click',  (e) => {
                e.preventDefault();
                e.stopPropagation();
                var step = parseInt(el.getAttribute('data-step'));

                if (step == self.options.decorator.createModelSteps) {
                    if(step = len) {
                        if (submit_button) submit_button.setAttribute('disabled', 'disabled');
                    }
                    console.log(next_steps, self.options.decorator.createModelSteps) ;
                    Lib.createNewModel(el);
                } else {
                    if(self.validateStep(step)) {
                        self.options.decorator.toStep(step+1);
                    }
                }
                return false;
            });
        });
    },

    previousStepListener() {
        let self = this;
        var back_steps = document.getElementsByClassName(this.options.backStepsClass);
        back_steps.forEach( (el) => {
            el.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                var step = parseInt(el.getAttribute('data-step'));
                if (step == 1) Lib.cancelCreation(el);
                else if (step > 1) self.options.decorator.toStep(step-1);
            });
        });
    },

    addFormReplyListeners(el, form, postId) {
        let reply = el.querySelector('[data-reply="' + postId + '"]');
        let like_el = el.querySelector('svg');

        if(like_el.hasAttribute('role')) {
            like_el.removeAttribute('role');
        }

        this.addShowCommentFormListener(reply);
        this.addFormKeyDownListener(form);
    },

    addShowCommentFormListener(selector) {
        let self = this;
        let reply = Lib.getNode(selector);
        reply.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            self.options.decorator.showCommentForm(reply);
        })
    },

    addCreateLikeListener(selector) {
        let like_el = Lib.getNode(selector);
        like_el.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            Lib.createLike(like_el);
        })
    },

    addFormKeyDownListener(selector) {
        let form = Lib.getNode(selector);
        form.addEventListener('keydown',  (e) => {
            if (e.keyCode == 13 && form.tagName.toLowerCase() == 'form') Lib.sendCommentForm(form);
        });
    },

    autocompleteListener(selector) {
        //<div id="user_autocomplete_autocomplete"  class="dropdown">
        //    <input type="text" id="user_autocomplete"/>
        //    <input type="hidden" id="user_autocomplete_hidden"/>
        //</div>


        Autocomplete.create(
            selector,
            selector + '_hidden',
            '/' + this.options.prefix + this.autocompleteUrl,
            JSON.parse,
            { inputDelay: 300 }
        );
    },

    moreButtonListener(selector) {
        var more_button = document.getElementById(selector);
        if (more_button) {
            more_button.addEventListener('click', () => {
                Lib.more(selector);
            });
        }
    },

    promoButtonListener() {
        let self = this;
        if(document.getElementById(this.selectPromoImageButtonId)) {
            document.getElementById(this.selectPromoImageButtonId).addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                document.getElementById(self.promoImageInputId).click();
            });

        }
    },

    galleryButtonListener() {
        if(document.getElementById(this.selectGalleryButtonId)) {
            document.getElementById(this.selectGalleryButtonId).addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                document.getElementById(this.galleryInputId).click();
            });

        }
    },

    showCommentsButtonListener() {
        let button = document.getElementById(this.options.showCommentsButtonId);
        if(button) {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                this.options.decorator.showComments(button);
            });
        }
    },

    recommendButtonListener() {
        let classes = document.getElementsByClassName(this.options.recommendButtonClass);

        classes.forEach((el) => {
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                Lib.recommend();
            });
        });
    },

    sendInvitesListener() {
        let form = document.forms[this.inviteFormId];
        let button = document.getElementById(this.inviteButtonId);
        if (button) {
            button.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();
                Lib.sendInvites(form);
            })
        }
    },

    textareaListener() {
        let elements = document.querySelectorAll('button[data-step]');
        elements.forEach((el) => {
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                e.preventDefault();
                //Lib.insertNicTextarea();
                Lib.insertCkeTextarea();
            });
        });
    },

    blockUserListener() {
        let classes = document.getElementsByClassName(this.options.blockUserClass);

        classes.forEach((el) => {
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                if (el.hasAttribute('data-blocked')) {
                    Lib.blockUser(el);
                }
            });
        });
    },

    inviteToggleListeners() {
        let link_classes = document.getElementsByClassName(this.options.inviteToggleClass);
        link_classes.forEach((el) => {
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                let block_classes = document.getElementsByClassName(this.options.inviteBlockClass);
                block_classes.forEach((item) => {
                    item.classList.toggle('hidden-xs-up');
                });

            });
        });
    },

    /**
     * Validate step
     * @param {number} step
     * @returns {bool}
     */
    validateStep(step) {
        return Validate.validateSection(this.options.sections[step]);
    }
};


