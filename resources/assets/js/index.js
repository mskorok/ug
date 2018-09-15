
import './Helpers/_core';

import 'bunnyjs/src/bunny';
import 'bunnyjs/src/bunny.dropdown';

import './app/Events/ToggleNavbar';
import './app/Events/HandleLegalAlert';

import { Route } from './Core/Route';

import { IndexController } from './app/Controllers/IndexController';

Route.get('/', () => IndexController.index());
