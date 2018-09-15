
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.required').forEach(function(label) {
        var input_id = label.getAttribute('for');
        var input = document.getElementById(input_id);
        if (input.getAttribute('value') !== '') {
            label.classList.remove('required');
        }
        input.addEventListener('input', function() {
            if (input.value !== '') {
                label.classList.remove('required');
            } else {
                label.classList.add('required');
            }
        });
    });
}, false);
