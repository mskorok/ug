<section class="app-new-activities-form  app-new-activities-decor clearfix">
    <div class="form-group row">
        <label for="title" class="col-lg-3 form-control-label">Title of activity</label>
        <div class="col-lg-8">
            <input type="text" class="form-control app-new-activities-form-input" name="title" id="title"
                   placeholder="e.g. Fun trip Berlin">
        </div>
    </div>
    <input type="hidden" id="location_lat" name="lat" value="">
    <input type="hidden" id="location_lng" name="lng" value="">
    <input type="hidden" id="place_location" name="place_location" value="">
    <input type="hidden" id="place_id" name="place_id" value="">
    <fieldset class="form-group row">
        <label for="place_name" class="col-lg-3 form-control-label">Location</label>
        <div class="col-lg-8">
            <input type="text" class="form-control app-new-activities-form-input" name="place_name" id="place_name"
                   placeholder="e.g. East Europe" required autocomplete="off">
            <svg class="app-new-activities-form-icon">
                <use xlink:href="#location"></use>
            </svg>
        </div>
    </fieldset>
    <fieldset class="form-group row">
        <label for="datetime_from" class="col-lg-3 form-control-label">Period/Time</label>
        <div class="col-lg-8">
            <input type="date" id="datetime_from" class="form-control app-new-activities-form-input"
                   name="datetime_from" placeholder="e.g. Summer of 2016" required>
            <svg class="app-new-activities-form-icon">
                <use xlink:href="#interface"></use>
            </svg>
        </div>
    </fieldset>
    <div class="app-new-activities-form-text">
        Gorbi nibh lacus, interdum porttitor sapien finibus, accumsan lobortis
        diam. Nulla laoreet, magna vel tempor auc.
    </div>
    <fieldset class="form-group row">
        <label class="col-lg-3 form-control-label" for="promo_image">Promo image</label>
        <div class="col-lg-3">
            <button class=" btn  app-btn-outline-apply app-new-activities-form-upload">
                <span>Upload image</span>
                <input type="file" accept="image/*" id="promo_image" class="form-control " name="promo_image" value="">
            </button>
            <div id="promo_image_delete_checkbox" class="checkbox m-a-1">
            <label>
            <input type="checkbox" id="promo_image_delete" name="promo_image_delete" value="1">
            <span>Delete image</span>
            </label>
            </div>
        </div>
        <div class="col-lg-1 text-lg-center app-new-activities-form-link">or</div>
        <div class="col-lg-4">
            <input type="text" id="google_image" class="form-control  app-new-activities-form-input" name="google_image"
                   placeholder="Search with a keyword in Google images">
        </div>
        <div class="col-lg-10 pull-xs-right">
        <img id="promo_image_image" class="w-50" src="" alt="Promo image preview" >
        </div>
    </fieldset>
    <fieldset class="form-group row">
        <label class="col-lg-4 col-xl-3 form-control-label" for="short_description">Short description</label>
        <div class="col-lg-7 col-xl-8">
                <textarea id="short_description" class="form-control app-new-activities-form-input" rows="3"
                          name="short_description" maxlength="255" placeholder="Write about your Activity in 256 symbols">

                </textarea>
        </div>
    </fieldset>
    <div class="app-new-activities-form-text">
        Gorbi nibh lacus, interdum porttitor sapien finibus, accumsan lobortis
        diam. Nulla laoreet, magna vel tempor auc.
    </div>
    @include('app.activities.buttons', ['link' => 'Cancel', 'btn' => 'Next step', 'url' => route('activities_list'), 'step' => 1])
</section>