
export var Facebook = {
    init: () => {

        window.fbAsyncInit = function () {
            FB.init({
                appId: Server.env.fbAppId,
                cookie: true,  // enable cookies to allow the server to access
                               // the session
                xfbml: true,  // parse social plugins on this page
                version: 'v2.5'
            });
        };

        // Load the SDK asynchronously
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    },

    login: (successCallback, failureCallback) => {

        console.log('Login');

        FB.login((response) => {

            if (response.authResponse) {

                // Fetch profile data
                FB.api(
                    '/me?fields=id,email',
                    (response) => {

                        let profile = {};
                        profile.provider = 'facebook';
                        profile.id = response.id;
                        profile.email = response.email;

                        successCallback(profile);
                    }
                );
            } else {
                console.log('User cancelled FB login or did not fully authorize.');
                failureCallback();
            }
        }, {
            scope: 'public_profile'
        });
    },

    getProfileData: (callback, failureCallback) => {
        FB.login(function(response) {

            if (response.authResponse) {

                // Fetch profile data
                FB.api(
                    '/me?fields=id,first_name,last_name,email,gender,locale,birthday',
                    (response) => {

                        let socialData = {};
                        socialData.provider = 'facebook';
                        socialData.id = response.id;
                        socialData.email = response.email;
                        socialData.first_name = response.first_name;
                        socialData.last_name = response.last_name;
                        socialData.gender = response.gender;
                        socialData.locale = response.locale;
                        socialData.birthday = response.birthday;

                        callback(socialData);
                    }
                );
            } else {
                console.log('User cancelled FB login or did not fully authorize.');
                failureCallback();
            }
        }, {
            scope: 'public_profile,email,user_birthday'
        });
    }
}