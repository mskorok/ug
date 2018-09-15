
export var FileUploads = ( () => {

    var inputId = null;

    var getNode = (el) => {
        return (typeof el === 'object') ? el : document.getElementById(el);
    };

    var createPreviewElement = (container, id) => {
        container = getNode(container);
        let i = document.createElement('img');
        i.setAttribute('id', id);
        i.setAttribute('src', '');
        i.setAttribute('alt', 'Promo image preview');
        if(container.tagName === 'DIV') {
            container.appendChild(i);
            return i;
        }
        return false;
    };



    return {

        previewContainer: 'preview_container',

        download: function(url, callback, error_callback = null) {
            var xhr = new XMLHttpRequest();
            xhr.onload = function() {
                if (this.readyState === 4) {
                    if (this.status === 200) {
                        var blob = this.response;
                        callback(blob);
                    } else {
                        if (error_callback !== null) {
                            error_callback(this.response, this.status);
                        }
                    }
                }
            };
            xhr.open('GET', url, true);
            xhr.responseType = 'blob';
            xhr.send();

        },

        addToForm: function(form_id_or_el, input_name, blob) {
            let el, post_data;

            el = getNode(form_id_or_el);
            post_data = new FormData(el);

            return post_data.append(input_name, blob);
        },

        previewImageFromInput(preview_img_id_or_el, file_input_id_or_el) {
            let el, input;

            el = getNode(preview_img_id_or_el);
            input = getNode(file_input_id_or_el);

            inputId = (input.id) ? input.id : null;

            el = (el) ? el : createPreviewElement(this.previewContainer, preview_img_id_or_el);

            if(el.src) {
                el.src = URL.createObjectURL(input.files[0]);
            }
        },

        previewImageFromBlob(preview_img_id_or_el, blob) {
            let el;

            el = getNode(preview_img_id_or_el);

            el.src = URL.createObjectURL(blob);
        },

        attachImagePreviewEvent(preview_img_id_or_el, file_input_id_or_el) {

            let input = getNode(file_input_id_or_el);

            input.addEventListener('change', () => {
                this.previewImageFromInput(preview_img_id_or_el, input);
            });
        },

        addCleanEventListener(delete_button_id, event) {
            let button = getNode(delete_button_id);

            button.addEventListener(event,  (e) => {
                e.preventDefault();
                e.stopPropagation();
                let self = this;
                let image = document.querySelector('#' + self.previewContainer + ' > img');

                let container = getNode(self.previewContainer);
                container.removeChild(image);

                if(inputId) {
                    let input = document.getElementById(inputId);
                    input.value = null;
                }

                return false;
            });
        }

    }
})();
