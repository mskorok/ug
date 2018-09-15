
(function(){

    var forms = {};
    var last_submitted_form_id = null;
    var changed = false;
    var changed_form_ids = [];

    [].forEach.call(document.forms, function(form){
        var id = form.getAttribute('id');
        forms[id] = {
            el: form,
            inputs: form.querySelectorAll('input, textarea, select'),
            changed: false
        };
    });


    var window_handler = function(e) {
        // if there are at least one changed form
        if (changed) {
            // if there is form submit
            if (last_submitted_form_id !== null) {
                // check that there are other unsaved forms
                for (var k = 0; k < changed_form_ids.length; k++) {
                    if (last_submitted_form_id !== changed_form_ids[k] //ignore current form
                    && forms[changed_form_ids[k]].changed) {
                        e.returnValue = 1;
                        break;
                    }
                }
            } else {
                // form not submitted, but there are unsaved changes
                e.returnValue = 1;
            }
        }
    };

    window.addEventListener("beforeunload", window_handler);

    document.addEventListener('DOMContentLoaded', function(){
        for (var form_id in forms) {
            forms[form_id].inputs.forEach(function(input){
                input.addEventListener('change', function(e) {
                    forms[form_id].changed = true;
                    changed_form_ids.push(form_id);
                    changed = true;
                });
            });

            forms[form_id].el.addEventListener('submit', function() {
                last_submitted_form_id = form_id;
            });
        }
    }, false);
})();
