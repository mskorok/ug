import { Interests } from '../../lib/interests';


export var AdminInterestsController = {
    index: function() {
        Interests.initInterests();

    }
};
