export var MultiSelectionList = class MultiSelectionList  {

    constructor(id, onSelectAtLeastOneClb = null, onDeselectAllClb = null) {
        this.id = id;
        this.containerEl = document.getElementById(id);
        this.attachEventHandlers();
        this.onSelectAtLeastOneClb = onSelectAtLeastOneClb;
        this.onDeselectAllClb = onDeselectAllClb;
        this.selectionClassName = 'selected';
    }

    attachEventHandlers() {
        let items = this.containerEl.getElementsByClassName('list-item');

        items.forEach((item) => {
            item.addEventListener('click', (e) => {

                let el = e.target;
                el.classList.toggle(this.selectionClassName);
                let isActive = this.hasClass(el, this.selectionClassName);
                let id = el.getAttribute('data-id');
                let container = this.containerEl;

                if (isActive) {
                    // Add corresponding hidden input
                    let input = document.createElement('input');
                    input.setAttribute('type', 'hidden');
                    input.setAttribute('id', this.getInputId(id));
                    input.setAttribute('value', id);
                    input.setAttribute('name', this.getContainerId() + '[]');
                    container.appendChild(input);
                } else {
                    // Remove hidden input
                    container.removeChild(container.querySelector('#' + this.getInputId(id)));
                }

                if (isActive ||
                    (container.getElementsByClassName(this.selectionClassName).length > 0 && this.onSelectAtLeastOneClb != null)) {

                    // if selection is not empty
                    this.onSelectAtLeastOneClb();
                } else {
                    // if selection is empty
                    this.onDeselectAllClb();
                }
            });
        });
    }

    getInputId(id) {
        return 'id_' + id;
    }

    hasClass(el, className) {
        var classNameStr = " " + className + " ";

        if ((" " + el.className + " ").replace(/[\n\t]/g, " ").indexOf(classNameStr) > -1) {
            return true;
        }

        return false;
    }

    getContainerId() {
        return this.containerEl.getAttribute('id');
    }
}