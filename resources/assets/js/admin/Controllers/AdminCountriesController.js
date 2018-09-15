/*
import { DataTable } from 'bunnyjs/src/bunny.datatable';
import { Element } from 'bunnyjs/src/bunny.element';

export var AdminUsersController = {

    index: function() {

        DataTable.define('users', 'template_user_row', {}, {format_data: function(data) {
            data.name = data.first_name + ' ' + data.last_name;
            data.link = '/admin/users/' + data.id;
            data.delete_link = '/admin/users/' + data.id + '/delete';
            return data;
        }});

        DataTable.onRedraw('users', function(table) {
            window.scrollTo(0, 0);
        });

    }

};*/

//document.querySelectorAll('#id').forEach(function(element)) // $(#id).