
document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('input[type="file"]').forEach(function(input) {
        var id = input.getAttribute('id');
        var preview_el = document.getElementById(id + '_image');
        if (preview_el !== null) {
            input.addEventListener('change', function() {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.addEventListener('load', function(e) {
                        preview_el.setAttribute('src', e.target.result);
                    });
                    reader.readAsDataURL(input.files[0]);
                }
            });
        }

        var del_checkbox = document.getElementById(id + '_delete_checkbox');
        var del_el = document.getElementById(id + '_delete');
        if (del_el !== null) {
            del_el.addEventListener('change', function() {
                if (del_el.checked) {
                    del_checkbox.classList.add('has-danger');

                } else {
                    del_checkbox.classList.remove('has-danger');
                }
            });
        }
    });
}, false);
