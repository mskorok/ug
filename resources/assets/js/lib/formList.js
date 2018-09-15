export default FormList = {

    addButtonId: 'add_invite_input',
    container: null,
    closerClass: 'app-file-list-closer',
    template: `<div class="form-group row m-t-2 app-form-list-item">
    <div class="col-xs-3">
    <a href="#" class="pull-xs-left app-s-close m-x-2 app-file-list-closer"></a>
    </div>
    <div class="col-xs-9">
    <input class="form-control" name="invite[]" type="email">
    </div>
    </div>`,


    init(container_id) {
        this.container = document.getElementById(container_id);
        this.attachAddEventListener();
    },
    attachAddEventListener() {
        let el = this.container.querySelector('#'+this.addButtonId);

        if (el) {
            el.addEventListener('click', (e) => {
                e.stopPropagation();
                let container = document.createDocumentFragment();
                var div = document.createElement('div');
                div.innerHTML = this.template;
                while (div.firstChild) container.appendChild(div.firstChild);
                this.container.appendChild(container);
                let child = this.container.lastChild;
                let close_btn = child.querySelector('.' + this.closerClass);
                close_btn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    this.container.removeChild(child);
                })
            });
        }
    },

    getInputs() {
        if(this.container instanceof HTMLElement) {
            let collection =  this.container.querySelectorAll('input');
            let array = [];
            collection.forEach((el) => {
                array.push(el);
            });
            return array;
        }

    }
}
