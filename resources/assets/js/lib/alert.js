
export var Alert = class Alert  {

    /**
     * Creates new DOM element
     * @param id
     * @param message
     */
    constructor(id, message) {
        this.el = document.createElement('div');
        this.el.setAttribute('class', Alert.getClass());
        this.el.setAttribute('id', id);
        this.el.textContent = message;
        this.id = id;
    }

    /**
     * Checks if the specified alert exists in DOM
     * @param id
     * @returns {*}
     */
    static exists(id) {
        return (Alert.getExisting(id) == null || Alert.getExisting(id) == 'undefined') ? true : false;
    }

    /**
     * Deletes the specified alert from DOM
     * @param id
     */
    static remove(id) {
        let el = Alert.getExisting(id);

        if (el != null) {
            el.parentNode.removeChild(el);
        }
    }

    static hide(id) {
        let el = Alert.getExisting(id);

        if (el != null && ! el.classList.contains('hidden-xs-up')) {
            el.classList.toggle('hidden-xs-up');
        }
    }


    /**
     * Gets alert from DOM by id
     * @param id
     * @returns {*}
     */
    static getExisting(id) {

        let res = document.querySelector('#' + id + '.' + Alert.getClass());

        return (res == null) ? null : res;
    }

    static getClass() {
        return 'app-alert';
    }

    /**
     * Inserts alert node into the specified container
     * @param containerId
     */
    insert(containerId = null) {

        containerId = (containerId == null) ? this.id + '_container' : containerId;
        let container = document.getElementById(containerId);

        if (container == null) {
            throw 'Container not found.';
        }

        let el = Alert.getExisting(this.id);

        if (el != null) {
            el.textContent = this.el.textContent;
        } else {
            container.appendChild(this.el);
        }
    }
}