
import { Ajax } from 'bunnyjs/src/bunny.ajax';
import { GalleryUploads } from './../../Components/Gallery/GalleryUploads';
import { Spinner } from './../../lib/spinner';


export var Lib = {

    options: {},

    more(selector) {
        var self = this;
        let spinner = Spinner;
        var more_button = document.getElementById(selector);
        more_button.setAttribute('disabled', 'disabled');
        var selected = document.querySelectorAll('[name^=categories][checked]');
        var qs = '';
        selected.forEach((el) => {
            qs += '&'+ el.name + '=1';
        });

        spinner.add(more_button);
        setTimeout(() => {
            spinner.remove(more_button);
        }, 2000);
        let url = self.options.contentUrl + self.options.decorator.contentPage + qs;

        Ajax.get(url, (data) => {
            var results = JSON.parse(data);
            self.options.decorator.moreButtonDecorator(results, more_button, spinner)
        });
    },

    sendCommentForm(form){
        let self = this;
        if (!(form instanceof Node  && form.tagName.toLowerCase() == 'form'))  return false;
        let inputs = form.getElementsByTagName("input");
        let post = (inputs[0].value !== '') ? inputs[0].value : 'null';
        let url = '/' + this.options.prefix + this.options.replyUrl + post;

        let formData = new FormData(form);
        let ajax = new XMLHttpRequest();
        form.getElementsByTagName("textarea")[0].value = null;
        ajax.open('POST', url, true);
        ajax.setRequestHeader('X-Requested-With','XMLHttpRequest' );
        ajax.onload = () => {
            if (ajax.readyState === XMLHttpRequest.DONE && ajax.status == 200) {
                let response = JSON.parse(ajax.responseText);
                if (response.result) self.options.decorator.newCommentDecorator(post, response);
            }
        };
        ajax.send(formData);
    },

    deleteComment(post) {
        let url = '/' + this.options.prefix + this.options.deleteReplyUrl + post;
        Ajax.get(url, (data) => {
            var results = JSON.parse(data);
            if(results.result) {
                location.reload();
            } else if (results.message) {
                console.log(results.message)
            }

        });
    },

    sendInvites(form) {
        let self =  this;
        let formData = new FormData(form);
        let ajax = new XMLHttpRequest();
        let url = this.option.inviteUrl;

        ajax.open('POST', url, true);
        ajax.setRequestHeader('X-Requested-With','XMLHttpRequest' );
        ajax.onload = () => {

            if (ajax.readyState === XMLHttpRequest.DONE && ajax.status == 200) {

                let response = JSON.parse(ajax.responseText);
                self.options.decorator.inviteDecorator(response)

            }
        };

        ajax.send(formData);
    },

    createLike(el, options) {
        options = options || {};
        if(el.hasAttribute('data-liked')) return false;
        let id = el.getAttribute('data-like');
        options.id = id;
        let url = options.url || '/' + this.options.prefix  + this.options.likeUrl;
        url = url +id;
        let self = this;

        Ajax.get(url, (data) =>  {
            var response = JSON.parse(data);
            self.options.decorator.likeDecorator(response, options);
        });
    },

    createNewModel(el) {
        let self = this;
        this.submitPermission = true;

        if(this.options.withGallery) {

            let form = document.forms[this.options.appFormId];
            let formData = new FormData(form);

            if(typeof GalleryUploads !== 'undefined') {
                let files = GalleryUploads.files;
                let name;
                for (let i = 0; i < files.length; i++) {
                     name = 'gallery[' + i + ']';
                    formData.append(name, files[i]);
                }
            }

            let ajax = new XMLHttpRequest();
            let url = location.href;

            ajax.open('POST', url, true);
            ajax.setRequestHeader('X-Requested-With','XMLHttpRequest' );
            ajax.onload = () => {
                if (ajax.readyState === XMLHttpRequest.DONE && ajax.status == 200) {
                    let response = JSON.parse(ajax.responseText);
                    if (response.result == true) {
                       location.pathname = self.options.reloadUrl;
                    } else {
                        el.removeAttribute('disabled');
                    }
                }
            };
            ajax.send(formData);
        } else {
            document.forms[this.options.appFormId].submit();
        }

    },

    cancelCreation(el) {
        if (el.href) {
            window.location.href = el.href;
        }
    },

    refresh(obj) {
        let self = this;
        let el = this.getNode(obj.selector);
        let url = '/' + self.options.prefix + obj.userDataUrl;
        let val =  el.value;
        val = val.replace(/^\s+/, '').replace(/\s+$/, '').replace(/\//g, '');
        if(val == '') return false;
        url = url + val;
        Ajax.get(url+val, function(data) {
            let result = JSON.parse(data);
            obj.decorator(result, el);
        });
    },

    recommend() {
        let self = this;
        let url = '/' + this.options.prefix + this.options.recommendUrl + this.options.current_review;
        Ajax.get(url, (data) =>  {
            var response = JSON.parse(data);
            if(response.result) self.options.decorator.recommendDecorator();
        });
    },

    blockUser(el) {
        let id = el.getAttribute('data-blocked');
        let owner_id = el.getAttribute('data-owner');
        let url = '/' + this.options.prefix + this.options.blockUserUrl + owner_id + '/' +  id;
        Ajax.get(url, (data) => {
            var results = JSON.parse(data);
            if(results.result) {
                location.reload();
            } else if (results.message) {
                console.log(results.message)
            }

        });
    },

    insertNicTextarea() {
        let classes = document.getElementsByClassName('nicEdit-main');
        classes.forEach((el) => {
            let parent = el.parentNode;
            let textArea = parent.nextSibling;
            textArea.value = el.innerHTML;
        });
    },

    insertCkeTextarea() {
        for(var i in CKEDITOR.instances) CKEDITOR.instances[i].updateElement();
    },

    setRequired(id){
        let el = document.getElementById(id);
        if(el) {
            el.setAttribute('required', 'required');
        }
    },

    getNode(el) {
        return (typeof el === 'object') ? el : document.getElementById(el);
    }
};