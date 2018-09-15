
export default Tag = {

    tagName: 'span',
    className: 'app-tag',
    closeClassName: 'app-s-close',

    create(value, label) {
        const e = document.createElement(this.tagName);
        e.classList.add(this.className);
        e.dataset.value = value;
        e.textContent = label;
        return e;
    },

    remove(tag) {
        tag.parentNode.removeChild(tag);
        tag = undefined;
    },

    /**
     * Remove Tag by value if exists
     * @param container
     * @param value
     */
    removeByValueIfExists(container, value) {
        const t = this.getTagByValue(container, value);
        if (t !== false) {
            this.remove(t);
        }
    },

    getValue(tag) {
        return tag.dataset.value;
    },

    /**
     *
     * @param {HTMLElement} tag
     * @returns {Promise} removed(value)
     */
    makeClosable(tag) {
        const p = new Promise( (removed) => {
            this.addCloser(tag);
            this.attachCloseEvent(tag).then ( (value) => {
                this.remove(tag);
                removed(value);
            });
        });
        return p;
    },

    getTagsInContainer(container) {
        return container.getElementsByClassName(this.className);
    },

    /**
     *
     * @param container
     * @param value
     * @returns {HTMLElement|boolean}
     */
    getTagByValue(container, value) {
        const tags = this.getTagsInContainer(container);
        for (let k = 0; k < tags.length; k++) {
            let tag = tags[k];
            if (tag.dataset.value === value) {
                return tag;
            }
        }
        return false;
    },

    createCloser() {
        const e = document.createElement('span');
        e.classList.add(this.closeClassName);
        return e;
    },

    addCloser(tag) {
        const closer = this.createCloser();
        tag.appendChild(closer);
    },

    isClosable(tag) {
        const closer = this.getCloser(tag);
        return closer !== undefined;
    },

    getCloser(tag) {
        return tag.getElementsByClassName(this.className)[0];
    },

    removeCloser(tag) {
        if (this.isClosable(tag)) {
            const closer = this.getCloser(tag);
            tag.removeChild(closer);
        }
    },

    attachCloseEvent(tag) {
        const p = new Promise( (ok, fail) => {
            tag.addEventListener('click', () => {
                ok(this.getValue(tag));
            })
        });
        return p;
    }

};
