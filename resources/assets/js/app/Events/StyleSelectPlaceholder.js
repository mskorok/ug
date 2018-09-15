
document.addEventListener('DOMContentLoaded', () => {
    document.getElementsByTagName('select').forEach((select) => {
        let placeholder = select.getAttribute('placeholder');
        if (placeholder !== null) {

            let selected = false;
            for (let k = 0; k < select.options.length; k++) {
                if (select.options[k].hasAttribute('selected')) {
                    selected = true;
                    break;
                }
            }

            let option = document.createElement('option');
            option.setAttribute('value', '');
            option.textContent = placeholder;
            select.insertBefore(option, select.firstChild);

            if (!selected) {
                select.selectedIndex = 0;
            }

            if (select.selectedIndex === 0) {
                select.classList.add('placeholder');
            } else {
                select.classList.remove('placeholder');
            }
            select.addEventListener('change', () => {
                if (select.selectedIndex === 0) {
                    select.classList.add('placeholder');
                } else {
                    select.classList.remove('placeholder');
                }
            });
        }
    });
});
