
import { Ajax } from 'bunnyjs/src/bunny.ajax';

export var Api = {

    /**
     * GET request to API
     * @param query - Sample: interests?fields=id,name&limit=1&equalTo[name]=Driving
     * @returns {Promise}
     */
    get(query) {

        return new Promise((resolve, reject) => {

            Ajax.get('/' + Server.project.apiPrefix + '/' + query,
                (result) => {
                    resolve(JSON.parse(result));
                },
                (result) => {
                    reject(JSON.parse(result));
                }
            );
        });
    }
};
