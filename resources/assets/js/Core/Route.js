
import { Route as BunnyRoute } from 'bunnyjs/src/bunny.route';

export var Route = Object.create(BunnyRoute);

Route.get = function(uri, callback, method = null) {
    if (Server.app.localePrefix !== '') {
        if (uri === '/') {
            uri = Server.app.localePrefix;
        } else {
            uri = Server.app.localePrefix + uri;
        }
    }

    return BunnyRoute.get(uri, callback, method);
};
