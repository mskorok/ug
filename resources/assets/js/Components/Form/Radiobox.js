
export var Radiobox = {

    create(container_class, custom_checkbox_class, checked_class) {

        document.getElementsByClassName(container_class).forEach((container) => {
            var custom_cb = container.getElementsByClassName(custom_checkbox_class)[0];
            if (custom_cb !== undefined) {

                let input = container.getElementsByTagName('input')[0];

                if (input.checked && !custom_cb.classList.contains(checked_class)) {
                    custom_cb.classList.add(checked_class);
                    input.value = 1;
                } else if (!input.checked) {
                    input.value = 0;
                } else {
                    input.value = 1;
                }

                input.addEventListener('change', (e) => {
                    let target = e.target || e.srcElement;
                    if(target.checked) {
                        this.refreshCheckValue(container_class, custom_checkbox_class, checked_class);
                    }
                });
            }
        });
    },
    refreshCheckValue (container_class, custom_checkbox_class, checked_class) {

        document.getElementsByClassName(container_class).forEach((container) => {
            var custom_cb = container.getElementsByClassName(custom_checkbox_class)[0];
            if (custom_cb !== undefined) {

                let input = container.getElementsByTagName('input')[0];

                if (input.checked) {
                    custom_cb.classList.add(checked_class);
                    input.value = 1;
                } else {
                    custom_cb.classList.remove(checked_class);
                    input.value = 0;
                }
            }
        });
    }

};

