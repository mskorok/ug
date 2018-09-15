
(function() {

    function url(route) {

        if (route.indexOf('/') !== 0) {
            route = '/' + route;
        }

        return Server.app.localePrefix + route;
    }

    window.url = url;

    function redirect(route) {
        window.location = url(route);
    }

    window.redirect = redirect;

})();
