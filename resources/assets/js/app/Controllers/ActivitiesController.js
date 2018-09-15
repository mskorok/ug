/**
 * Created by michail on 22.03.16.
 */

import { Ajax }        from 'bunnyjs/src/bunny.ajax';
import { Checkbox }    from 'bunnyjs/src/form/checkbox';
import { FileUpload }  from 'bunnyjs/src/form/fileupload';
import { Spinner }     from './../../lib/spinner';
import { Lib }         from '../../Models/Lib/Lib';
import { Interests }   from '../../Models/Lib/Interests';
import { Radiobox }    from '../../Components/Form/Radiobox';
import { FileUploads } from '../../Components/Form/FileUploads';
import { Listeners }   from './../../Models/Listeners/Listeners';
import { Decorator }   from './../../Models/Decorators/Decorator';
import { GoogleGeo }   from './../../Components/Geo/Google';
import FormList        from './../../Components/Form/FormList';

//import FormList        from './../../lib/formList';


export var ActivitiesController = {

    options: {
        decorator: Decorator,
        prefix: Server.project.apiPrefix,
        model: 'adventure',
        likeModelUrl: '/adventures/like/',
        likeUrl: '/activity_comments/like/',
        replyUrl: '/activity_comments/reply/',
        deleteReplyUrl: '/activity_comments/delete/',
        contentUrl: '/activities?page=',
        //inviteUrl: '/adventures/invite/', //todo only for activities
        reloadUrl: '/activities',
        blockUserUrl: '/users/block/',

        appFormId: 'add_edit_activities_form',
        appTopId: 'app_new_activities_top_step',
        appRowsId: 'app_activity_rows',
        moreButtonId: 'app_button_more',
        postContainerId: 'app_activity_post_container',
        modelStepPrefix: 'app_new_activities_step',
        submitPermission: false,
        withGallery: false,

        postFormClass: 'app-activity-response-form',
        createReplyClass: 'app-activity-reply',
        likeClass: 'app-activity-like-data',
        createLikeClass: 'app-activity-like',
        backStepsClass: 'app-new-activities-back',
        nextStepsClass: 'app-new-activities-next',
        replyClass: 'app-activity-reply-data',
        responseClass: 'app-responses-block',
        deleteCommentClass: 'app-delete-comment',
        recommendButtonClass: 'app-activity-recommend',
        blockUserClass: 'app-block-user',
        inviteToggleClass: 'app-activity-invite-toggle',
        inviteBlockClass: 'app-activity-invite-block',




        geoOption: {
            nameSelector: 'place_name',
            locationSelector:'place_location',
            idSelector: 'place_id',
            latSelector: 'location_lat',
            lngSelector: 'location_lng',
            countrySelector: 'country_name'
        },
        sections: {
            1: document.getElementById('app_new_activities_step1'),
            2: document.getElementById('app_new_activities_step2'),
            3: document.getElementById('app_new_activities_step3'),
            4: document.getElementById('app_new_activities_step4'),
            5: document.getElementById('app_new_activities_step5')
        },
        current_user: null,
        current_activity: null
    },



    activities: function() {

        Checkbox.create('app-checkbox-label', 'app-checkbox', 'checked');
        let options = {
            likeClass: this.options.likeModelClass,
            createLikeClass: this.options.createModelLikeClass,
            url: '/' + this.options.prefix + this.options.likeModelUrl

        };
        Listeners.init(this.options);
        Decorator.init(this.options);
        Listeners.moreButtonListener(this.options.moreButtonId);


        Listeners.createLikeListener(options);
    },
    showAdd() {
        Lib.setRequired('description');

        let el_user = document.querySelector('[data-user]');
        if (el_user) {
            this.options.current_user = el_user.getAttribute('data-user');
        }

        let el_activity = document.querySelector('[data-review]');
        if (el_activity) {
            this.options.current_activity = el_activity.getAttribute('data-adventure');
        }

        Interests.selector = 'new_activity_interest_autocomplete';
        Interests.firstInterestButton = 'add_interest_to_new_activity';
        Interests.interestsHiddenBlock = 'interests_hidden_block';
        Interests.interestsForCreationBlock = 'interests_for_creation';
        Interests.mode = 'create';
        Interests.model = 'adventure';

        Interests.buttonStyle = 'app-tag';


        Listeners.init(this.options);
        Decorator.init(this.options);
        Decorator.createModelSteps = 5;
        Listeners.checkSubmitListener();
        //Listeners.showCommentFormListener();
        //// reply
        //Listeners.submitCommentFormListener();
        ////like
        //Listeners.createLikeListener();
        Listeners.textareaListener();
        Listeners.nextStepListener();
        Listeners.previousStepListener();
        //
        Listeners.promoButtonListener();
        Listeners.inviteToggleListeners();

        Checkbox.create('app-checkbox-label', 'app-checkbox', 'checked');
        Radiobox.create('app-radio-label', 'app-radio', 'checked');

        FileUploads.attachImagePreviewEvent('promo_image_image', 'promo_image');
        //FileUploads.addCleanEventListener('delete_preview','click');
        GoogleGeo.init(this.options);
        Interests.autocompleteResolver = 'bunny';

        Interests.init();
        FormList.init('app_invite_inputs_block');

    },
    activity() {

        let el_user = document.querySelector('[data-user]');
        if (el_user) {
            this.options.current_user = el_user.getAttribute('data-user');
        }

        let el_activity = document.querySelector('[data-review]');
        if (el_activity) {
            this.options.current_activity = el_activity.getAttribute('data-adventure');
        }

        Interests.selector = 'activity_interest_autocomplete';
        Interests.addInterestToAdventureButton = 'add_interest_to_activity';
        Interests.interestsHiddenBlock = 'interests_hidden_block';
        Interests.interestsForCreationBlock = 'interests_for_creation';
        Interests.buttonStyle = 'app-tag';
        Interests.model = 'adventure';

        Listeners.init(this.options);
        Decorator.init(this.options);

        Checkbox.create('app-checkbox-label', 'app-checkbox', 'checked');

        Listeners.showCommentFormListener();
        //reply
        Listeners.submitCommentFormListener();
        //like
        Listeners.createLikeListener();

        Listeners.moreButtonListener(this.options.moreButtonId);

        Listeners.deleteCommentListener();
        Listeners.blockUserListener();

        Interests.autocompleteResolver = 'bunny';
        Interests.init();
    }
};
