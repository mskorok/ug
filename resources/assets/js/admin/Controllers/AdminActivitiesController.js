/**
 * Created by michail on 10.02.16.
 */

import { DataTable } from 'bunnyjs/src/bunny.datatable';
import { Element } from 'bunnyjs/src/bunny.element';
import { Validate } from 'bunnyjs/src/bunny.validate';
import { TabList } from 'bunnyjs/src/bunny.tablist';
import { DatePicker } from 'bunnyjs/src/bunny.datepicker';
import { Adventures } from '../../lib/adventures';
import '../../lib/awesomplete';


export var AdminActivitiesController = {

    list: function() {

        // if #adventures and #template_adventure_row exists init DataTable
        // else probably there are no pages to paginate and do nothing
        if (DataTable.define('adventures', 'template_adventure_row', {}, {format_data: function(adventure) {
            adventure.edit_link = '/admin/adventures/edit/' + adventure.id;
            adventure.delete_link = '/admin/adventures/'+adventure.id+'/delete';
            return adventure;
        }})) {
            // add event only if DataTable initiated
            DataTable.onRedraw('adventures', function(table) {
                window.scrollTo(0, 0);
            });
        }
    },
    createAdventures: function(args) {
        Adventures.createEditAdventureInit();

    },
    editAdventures: function(args) {
        Adventures.createEditAdventureInit();

    }

};
