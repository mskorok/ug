import { Ajax } from 'bunnyjs/src/bunny.ajax';
import { Geo } from './Geo';

// Geo

export var GoogleGeo = {

    resolver(name, locationSelector, idSelector, latSelector, lngSelector, countrySelector) {
        var url = 'https://maps.google.com/maps/api/geocode/json?address=' + name;

        Ajax.get(
            url,
            function (data) {
                var result = JSON.parse(data);
                var lat = result.results[0].geometry.location.lat;
                var lng = result.results[0].geometry.location.lng;
                var country = null;
                var addresses = result.results[0].address_components;
                addresses.forEach(function (item) {
                    if (Array.isArray(item.types)) {
                        item.types.forEach(function (tag) {
                            if (tag == 'country') {
                                country = item.long_name;
                            }
                        })
                    }
                });
                if (country) {
                    if (document.getElementById(countrySelector)) {
                        document.getElementById(countrySelector).innerHTML = country;
                    }
                }

                if (document.getElementById(latSelector)) {
                    document.getElementById(latSelector).value = lat;
                }
                if (document.getElementById(lngSelector)) {
                    document.getElementById(lngSelector).value = lng;
                }
                if (document.getElementById(locationSelector)) {
                    document.getElementById(locationSelector).value = 'POINT(' + lat + ' , ' + lng + ')';
                }
                if (document.getElementById(idSelector)) {
                    document.getElementById(idSelector).value = result.results[0].place_id;
                }
            },
            function (data) {
                console.log('error', data);
            },
            {}
        );
    },

    init(obj, id) {
        let options = obj.geoOption;
        id = id || options.nameSelector;

        let autocomplete = new google.maps.places.Autocomplete(
            /** @type {HTMLInputElement} */(document.getElementById(id)),
            {types: ['geocode']});

        google.maps.event.addListener(
            autocomplete,
            'place_changed',
            () => this.resolveLocationData(options)
        );
    },

    resolveLocationData(option) {
        Geo.resolveLocationData(this.resolver, option)
    }
};

// Social Profile

export var GoogleProfile = {

    handleClientLoad() {
        gapi.load('auth2', function() {
            auth2 = gapi.auth2.init({
                client_id: Server.env.googleClientId,
                fetch_basic_profile: true,
                scope: 'profile'
            });
        });
    },

    login(successCallback, failureCallBack) {

        // TODO: Handle login pop-up closing / login failure when fixed by Google
        // https://github.com/google/google-api-javascript-client/issues/144

        auth2.signIn().then(
            () => successCallback(auth2.currentUser.get()),
            () => {
                console.log('User cancelled Google login or did not fully authorize.');
                failureCallBack();
            }
        );
    },

    getData(user, successCallback) {

        let profile = user.getBasicProfile();

        let socialData = {};

        socialData.provider = 'google';
        socialData.id = profile.getId();
        socialData.email = profile.getEmail();
        socialData.first_name = profile.getGivenName();
        socialData.last_name = profile.getFamilyName();
        socialData.image = profile.getImageUrl();
        socialData.token = user.getAuthResponse().id_token;

        successCallback(socialData);
    }
};