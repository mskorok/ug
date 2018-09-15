
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a, button, [role="button"]').forEach((item) => {
        item.addEventListener("touchstart", () => {
            item.classList.add('touch');
        }, false);
        item.addEventListener("touchend", () => {
            item.classList.remove('touch');
        }, false);
    });
});

