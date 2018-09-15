
//import { Route } from 'bunnyjs/src/bunny.route';
import { Route } from './../Core/Route';

//import { AdminDashboardController } from './Controllers/AdminDashboardController';
//Route.get('/admin', AdminDashboardController.index);

import { AdminUsersController } from './Controllers/AdminUsersController';
import { AdminActivitiesController } from './Controllers/AdminActivitiesController';
import { AdminInterestsController } from './Controllers/AdminInterestsController';

Route.get('/admin/users', AdminUsersController.index);
Route.get('/admin/users/{id}', AdminUsersController.showEditUser);

Route.get('/admin/adventures', AdminActivitiesController.list);
Route.get('/admin/adventures/create', AdminActivitiesController.createAdventures);
Route.get('/admin/adventures/edit/{id}', AdminActivitiesController.editAdventures);

Route.get('/admin/interests', AdminInterestsController.index);
