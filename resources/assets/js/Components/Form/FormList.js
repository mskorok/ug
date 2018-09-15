
export default FormList = {

    addButtonId: 'add_invite_input',
    container: null,
    inputContainerClass: 'app-form-list-item',
    inputContainerClassName: 'form-group row m-t-2 app-form-list-item',
    closerLinkClassName: 'pull-xs-left app-s-close m-x-2 app-file-list-closer',
    inputName: '',

    init(container_id) {
        let container = document.getElementById(container_id);
        if(container instanceof HTMLElement) {
            let input = container.querySelector('input');
            let add_button = container.querySelector('#' + this.addButtonId);
            if (input instanceof HTMLElement && add_button instanceof HTMLElement) {
                this.container = container;
                if (input.hasAttribute('name')) {
                    this.inputName = input.getAttribute('name');
                    if(this.inputName.indexOf('[]') === -1) {
                        this.inputName += '[]';
                        input.setAttribute('name', this.inputName);
                    }
                }
                this.attachAddEventListener(container_id);
                return true;
            }
        }
        throw new Error('Input or button not found');
    },

    attachAddEventListener(container_id) {
        let container = document.getElementById(container_id);
        if(container instanceof HTMLElement) {
            let self = this;
            let el = container.querySelector('#' + this.addButtonId);

            if (el) {
                el.addEventListener('click', (e) => {
                    e.stopPropagation();
                    self.addInput(container_id);

                });
            }
        }
    },

    getInputs(container_id) {
        let container = document.getElementById(container_id);
        if(container instanceof HTMLElement) {
            let collection =  this.container.querySelectorAll('input');
            let array = [];
            collection.forEach((el) => {
                array.push(el);
            });
            return array;
        }

    },

    attachDeleteEventListener(close_btn) {
        let self = this;
        let input_container = close_btn.closest('.' + this.inputContainerClass);

        if (close_btn instanceof HTMLElement) {
            close_btn.addEventListener('click', (e) => {
                e.stopPropagation();
                if(input_container instanceof HTMLElement) {
                    self.removeInput(input_container);
                }
            });
        }
    },

    createInputContainer() {
        let div = document.createElement('div');
        div.className = this.inputContainerClassName;
        return div;
    },

    createInput() {
        let div = document.createElement('div');
        let input = document.createElement('input');
        div.classList.add('col-xs-9');
        input.setAttribute('name', this.inputName);
        input.setAttribute('type', 'email');
        input.classList.add('form-control');
        div.appendChild(input);
        return div;
    },

    createCloser() {
        let div = document.createElement('div');
        let a = document.createElement('a');
        div.classList.add('col-xs-3');
        a.className = this.closerLinkClassName;
        a.setAttribute('href', '#');
        div.appendChild(a);
        return div;
    },

    insertInputContainer(container_id, input_container) {
        let container = document.getElementById(container_id);
        if(input_container instanceof HTMLElement && container instanceof HTMLElement) {
            container.appendChild(input_container);
        }
    },

    addInput(container_id) {
        let input_container =  this.createInputContainer();
        let input = this.createInput();
        let closer = this.createCloser();
        input_container.appendChild(closer);
        input_container.appendChild(input);
        this.insertInputContainer(container_id, input_container);
        this.makeInputDeletable(input);
    },

    removeInput(input) {
        if(input instanceof HTMLElement) {
            this.container.removeChild(input);
        }
    },

    makeInputDeletable(input) {
        let close_btn = this.getCloseBtnByInput(input);
        this.attachDeleteEventListener(close_btn);

    },

    getCloseBtnByInput(input) {
        let input_container = input.closest('.' + this.inputContainerClass);
        return input_container.querySelector('a');
    }
}



