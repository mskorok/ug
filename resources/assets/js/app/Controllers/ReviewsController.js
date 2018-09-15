/**
 * Created by michail on 22.03.16.
 */

import { Ajax }           from 'bunnyjs/src/bunny.ajax';
import { Checkbox }       from 'bunnyjs/src/form/checkbox';
import { FileUpload }     from 'bunnyjs/src/form/fileupload';
import { Spinner }        from './../../lib/spinner';
import { Lib }            from '../../Models/Lib/Lib';
import { GalleryUploads } from './../../Components/Gallery/GalleryUploads';
import { Gallery }        from './../../Components/Gallery/Gallery';
import { Listeners }      from './../../Models/Listeners/Listeners';
import { Decorator }      from './../../Models/Decorators/Decorator';
import { Radiobox }       from '../../Components/Form/Radiobox';
import { FileUploads }    from '../../Components/Form/FileUploads';
import { GoogleGeo }      from './../../Components/Geo/Google';



//import { Interests } from '../../lib/interests';
import { Interests } from '../../Models/Lib/Interests';

//import  '../../lib/ne';



export var ReviewsController = {

    options: {
        decorator: Decorator,
        prefix: Server.project.apiPrefix,
        model: 'review',
        likeModelUrl: '/reviews/like/',
        likeUrl: '/review_comments/like/',
        replyUrl: '/review_comments/reply/',
        deleteReplyUrl: '/review_comments/delete/',
        contentUrl: '/reviews?page=',
        inviteUrl: '/adventures/invite/', //todo only for activities
        reloadUrl: '/reviews',
        recommendUrl: '/reviews/recommend/',
        blockUserUrl: '/users/block/',

        appFormId: 'add_edit_reviews_form',
        appTopId: 'app_new_reviews_top_step',
        appRowsId: 'app_review_rows',
        moreButtonId: 'app_button_more',
        showCommentsButtonId: 'app_review_show_more_comments',
        postContainerId: 'app_review_post_container',
        recommendButtonId: 'app_recommended',
        modelStepPrefix: 'app_new_reviews_step',
        submitPermission: false,
        withGallery: true,

        postFormClass: 'app-open-review-response-form',
        createReplyClass: 'app-open-review-reply',
        likeClass: 'app-open-review-like-data',
        likeModelClass: 'app-review-like-data',
        createLikeClass: 'app-open-review-like',
        createModelLikeClass: 'app-review-like',
        backStepsClass: 'app-new-reviews-back',
        nextStepsClass: 'app-new-reviews-next',
        replyClass: 'app-open-review-reply-data',
        responseClass: 'app-responses-block',
        deleteCommentClass: 'app-delete-comment',
        recommendButtonClass: 'app-open-review-recommend',
        blockUserClass: 'app-block-user',




        geoOption: {
            nameSelector: 'place_name',
            locationSelector:'place_location',
            idSelector: 'place_id',
            latSelector: 'location_lat',
            lngSelector: 'location_lng',
            countrySelector: 'country_name'
        },
        sections: {
            1: document.getElementById('app_new_reviews_step1'),
            2: document.getElementById('app_new_reviews_step2'),
            3: document.getElementById('app_new_reviews_step3')
        },
        current_user: null,
        current_review: null
    },

    reviews: function() {

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
    showAdd ()  {


        let el_user = document.querySelector('[data-user]');
        if (el_user) {
            this.options.current_user = el_user.getAttribute('data-user');
            Interests.current_user = el_user;
        }

        let el_review = document.querySelector('[data-review]');
        if (el_review) {
            this.options.current_review = el_review.getAttribute('data-review');
            Interests.current_review = el_review;
        }

        Interests.selector = 'new_review_interest_autocomplete';
        Interests.firstInterestButton = 'add_interest_to_new_review';
        Interests.interestsHiddenBlock = 'interests_hidden_block';
        Interests.interestsForCreationBlock = 'interests_for_creation';
        Interests.model = 'review';
        Interests.mode = 'create';


        Interests.buttonStyle = 'app-tag';
        Lib.setRequired('description');
        Listeners.init(this.options);
        Decorator.init(this.options);
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
        Listeners.galleryButtonListener();
        ////Listeners.dropdownListener();

        FileUploads.attachImagePreviewEvent('promo_image_image', 'promo_image');
        ////FileUploads.addCleanEventListener('delete_preview','click');
        GalleryUploads.collectFilesListener();

        GoogleGeo.init(this.options);

        Interests.autocompleteResolver = 'bunny';
        //Interests.initInterests();
        Interests.init();
    },

    review () {
        let self = this;
        let el_user = document.querySelector('[data-user]');
        if (el_user) {
            this.options.current_user = el_user.getAttribute('data-user');
        }

        let el_review = document.querySelector('[data-review]');
        if (el_review) {
            this.options.current_review = el_review.getAttribute('data-review');
        }

        this.options.contentUrl = '/' + this.options.prefix +'/reviews/related/' + this.options.current_review +'?page=';

        Gallery.init();

        Listeners.init(this.options);
        Decorator.init(this.options);

        Listeners.showCommentFormListener();
        //reply
        Listeners.submitCommentFormListener();
        //like
        Listeners.createLikeListener();
        let options = {
            likeClass: self.options.likeReviewClass,
            createLikeClass: self.options.createReviewLikeClass,
            url: '/' + self.options.prefix +self.options.likeReviewUrl

        };
        Listeners.createLikeListener(options);
        //Listeners.dropdownListener();
        Listeners.moreButtonListener(this.options.moreButtonId);
        Listeners.showCommentsButtonListener();
        Listeners.recommendButtonListener();
        Listeners.deleteCommentListener();
        Listeners.blockUserListener();
    }

};
