
document.addEventListener('DOMContentLoaded', () => {
    document.getElementsByClassName('dropdown').forEach((el) => {
        // get toggle button
        let btn = el.getElementsByClassName('dropdown-toggle')[0];
        // get menu
        let menu = el.getElementsByClassName('dropdown-menu')[0];

        // is dropdown menu style top changed
        let changed = false;

        // original dropdown menu style top
        let original_top = menu.style.top;

        // add event listener when dropdown toggles 'open' class
        new MutationObserver(function(mutations) {
            if (mutations[0].attributeName === 'class') {
                if (el.classList.contains('open')) {
                    // dropdown opened

                    // get space between btn bottom and window bottom corner
                    let height_to_end = window.innerHeight - btn.getBoundingClientRect().bottom;

                    // get menu height when it becomes visible in browser
                    let menu_height = menu.offsetHeight;
                    menu_height += 5;

                    // if menu_height > height_to_end - display menu up not down
                    if (menu_height > height_to_end) {
                        menu.style.top = '-' + menu_height + 'px';
                        changed = true;
                    }
                } else {
                    // dropdown closed

                    if (changed) {
                        // restore style only if it was changed
                        menu.style.top = original_top;
                        changed = false;
                    }
                }
            }
        }).observe(el, { attributes: true });
    });
});
