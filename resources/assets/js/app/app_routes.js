
import { Route } from './../Core/Route';

import { ActivitiesController } from './Controllers/ActivitiesController';
import { ReviewsController } from './Controllers/ReviewsController';
import { RegisterController } from './Controllers/Auth/RegisterController';
import { LoginController } from './Controllers/LoginController';
import { ProfileController } from './Controllers/Profile/Edit/ProfileController';
import { ActivitiesController as ProfileActivitiesController } from './Controllers/Profile/Public/ActivitiesController';
import { ReviewsController as ProfileReviewsController } from './Controllers/Profile/Public/ReviewsController';
import { FriendsController as ProfileFriendsController } from './Controllers/Profile/Public/FriendsController';
import { PeopleController } from './Controllers/People/PeopleController';

Route.get('/activities', () => ActivitiesController.activities());
Route.get('/activities/create', () => ActivitiesController.showAdd());
Route.get('/activities/{activity}', ActivitiesController, 'activity');

Route.get('/reviews', () => ReviewsController.reviews());
Route.get('/reviews/create', () => ReviewsController.showAdd());
Route.get('/reviews/{review}', () => ReviewsController.review());

Route.get('/login', () => LoginController.index());
Route.get('/register', () => RegisterController.index());
Route.get('/users/{userId}/activities', (userId) => ProfileActivitiesController.init(userId));
Route.get('/users/{userId}/reviews', (userId) => ProfileReviewsController.init(userId));
Route.get('/users/{userId}/friends', (userId) => ProfileFriendsController.init(userId));
Route.get('/edit-profile', () => ProfileController.edit());
Route.get('/people', () => PeopleController.index());
