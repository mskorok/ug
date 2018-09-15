{{--Template mobile create new activity - step1--}}

<section class="app-new-activities-form  app-new-activities-decor clearfix">

    <label for="title" class="col-xs-12 form-control-label">Title of activity</label>
    <div class="col-xs-12 app-center-block">
        <input type="text" class="form-control app-new-activities-form-input" name="title" id="title"
               placeholder="e.g. Fun trip Berlin">
    </div>

    <input type="hidden" id="location_lat_mobile" name="lat" value="">
    <input type="hidden" id="location_lng_mobile" name="lng" value="">
    <input type="hidden" id="place_location_mobile" name="place_location" value="">
    <input type="hidden" id="place_id_mobile" name="place_id" value="">

    <label for="place_name_mobile" class="col-xs-12 form-control-label">Location</label>
    <div class="col-xs-12 app-center-block">
        <input type="text" class="form-control app-new-activities-form-input" name="place_name" id="place_name_mobile"
               placeholder="e.g. East Europe" required autocomplete="off">
        <svg class="app-new-activities-form-icon">
            <use xlink:href="#location"></use>
        </svg>
    </div>

    <label for="datetime_from_mobile" class="col-xs-12 form-control-label">Period/Time</label>
    <div class="col-xs-12 app-center-block">
        <input type="date" id="datetime_from_mobile" class="form-control app-new-activities-form-input"
               name="datetime_from" placeholder="e.g. Summer of 2016" required>
        <svg class="app-new-activities-form-icon">
            <use xlink:href="#interface"></use>
        </svg>
    </div>

    <div class="app-new-activities-form-text  col-xs-12 app-center-block">
        Gorbi nibh lacus, interdum porttitor sapien finibus, accumsan lobortis
        diam. Nulla laoreet, magna vel tempor auc.
    </div>

    <label class="col-xs-12 form-control-label" for="promo_image">Promo image</label>
    <div class="col-xs-12 app-center-block">
        <button class=" btn  app-btn-outline-apply app-new-activities-form-upload">
            <span>Upload image</span>
            <input type="file" accept="image/*" id="promo_image_mobile" class="form-control " name="promo_image" value="">
        </button>

        {{--<div id="promo_image_delete_checkbox" class="checkbox m-a-1">--}}
        {{--<label>--}}
        {{--<input type="checkbox" id="promo_image_delete" name="promo_image_delete" value="1">--}}
        {{--<span>Delete image</span>--}}
        {{--</label>--}}
        {{--</div>--}}
    </div>
    <div class="col-xs-12  app-new-activities-form-text">or</div>
    <div class="col-xs-12">
        <input type="text" id="google_image" class="form-control  app-new-activities-form-input" name="google_image"
               placeholder="Search with a keyword in Google images">
    </div>
    <div class="col-xs-12 pull-xs-right">
    <img id="promo_image_preview_mobile" class="w-50" src="" alt="Promo image preview">
    </div>


    <label class="col-xs-12 form-control-label" for="short_description">Short description</label>
    <div class="col-xs-12 app-center-block">
                <textarea id="short_description" class="form-control app-new-activities-form-input" rows="3"
                          name="short_description" maxlength="255" placeholder="Write about your Activity in 256 symbols">
                </textarea>
    </div>

    <div class="app-new-activities-form-text col-xs-12 app-center-block">
        Gorbi nibh lacus, interdum porttitor sapien finibus, accumsan lobortis
        diam. Nulla laoreet, magna vel tempor auc.
    </div>
    @include('app.activities.buttons', ['link' => 'Cancel', 'btn' => 'Next step', 'url' => '#', 'step' => 1])
</section>

