
import { DataTable } from 'bunnyjs/src/bunny.datatable';
import { Element } from 'bunnyjs/src/bunny.element';
import { Validate } from 'bunnyjs/src/bunny.validate';
import { TabList } from 'bunnyjs/src/bunny.tablist';
import { DatePicker } from 'bunnyjs/src/bunny.datepicker';
import { Interests } from '../../lib/interests';
import { MultiSelectionList } from '../../lib/multiselect';

export var AdminUsersController = {

    index: function() {

        // if #users and #template_user_row exists init DataTable
        // else probably there are no pages to paginate and do nothing
        if (DataTable.define('users', 'template_user_row', {}, {format_data: function(data) {
            data.link = '/admin/users/' + data.id;
            data.delete_link = '/admin/users/' + data.id + '/delete';
            return data;
        }})) {
            // add event only if DataTable initiated
            DataTable.onRedraw('users', function(table) {
                window.scrollTo(0, 0);
            });
        }
    },

    showEditUser: function(args) {

        Validate.validate(document.getElementById('add_edit_user_form'), {
            on_focus: function(form_input, form_group) {
                // if form input is inside tab pane, check and switch to required tab pane
                var parent = form_group.parentNode;
                if (parent.classList.contains('tab-pane')) {
                    if (!parent.classList.contains('active')) {
                        TabList.changeTab(parent.getAttribute('id'));
                    }
                }
                setTimeout(function() {
                    Validate.focus(form_input);
                    //Element.scrollTo(form_group, 60);
                }, 200);
            }
        });

        this.categoryList = new MultiSelectionList(
            'categories_bit',
            () => {  },
            () => {  }
        );

        DatePicker.create('birth_date');
        Interests.initInterests();

    }

};
