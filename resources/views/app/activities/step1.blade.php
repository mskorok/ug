<div class="app-new-activities-form app-card  app-p-card">
    <div class="form-group row">
        <label for="title" class="col-xs-12 col-lg-3 p-l-1 col-form-label">
            @lang('app/activities_new.title')
        </label>
        <div class="col-xs-12 col-lg-9 p-r-1 app-center-block">
            <input type="text" class="form-control app-new-activities-form-input" name="title" id="title"
                   placeholder="@lang('app/activities_new.title_placeholder')" required>
            <small class="app-form-help">
                @lang('app/activities_new.title_help')
            </small>
        </div>
    </div>
    <input type="hidden" id="location_lat" name="lat" value="" required>
    <input type="hidden" id="location_lng" name="lng" value="" required>
    <input type="hidden" id="place_location" name="place_location" value="" required>
    <input type="hidden" id="place_id" name="place_id" value="" required>
    <div class="form-group row">
        <label for="place_name" class="col-xs-12 col-lg-3 p-l-1 col-form-label">
            @lang('app/activities_new.destination')
        </label>
        <div class="col-xs-12 col-lg-9 p-r-1 app-center-block">
            <input type="text" class="form-control app-new-activities-form-input" name="place_name" id="place_name"
                   placeholder="@lang('app/activities_new.destination_placeholder')" required autocomplete="off">
            <svg class="app-new-activities-form-icon">
                <use xlink:href="#svg__location"></use>
            </svg>
            <small class="app-form-help">
                @lang('app/activities_new.destination_help')
            </small>
        </div>
    </div>
    <div class="form-group row">
        <label for="datetime_from" class="col-xs-12 col-lg-3 p-l-1 col-form-label">
            @lang('app/activities_new.period')
        </label>
        <div class="col-xs-12 col-lg-9 p-r-1 app-center-block">
            <input type="text" id="datetime" class="form-control app-new-activities-form-input"
                   name="datetime" placeholder="@lang('app/activities_new.period_placeholder')">
            <input type="hidden" id="datetime_from" name="datetime_from" />
            <input type="hidden" id="datetime_to" name="datetime_to" />
            <svg class="app-new-activities-form-icon">
                <use xlink:href="#svg__calendar"></use>
            </svg>
            <div class="app-form-help">
                @lang('app/activities_new.period_help')
            </div>
        </div>
    </div>
    <div class="form-group row m-b-1">
        <label class="col-xs-12  col-lg-3  p-l-1 col-form-label" for="promo_image">
            @lang('app/activities_new.image')
        </label>
        <div class="col-xs-12 col-lg-9">
            <div class="app-inline-block app-opacity-0">
                <input type="file" accept="image/*" id="promo_image" class="app-new-activities-hidden-upload" name="promo_image" required>
            </div>
            <div class="app-new-activities-hide-input">
                <button type="button" id="select_promo_image" class="btn  btn-sm app-btn-outline-apply">
                    <span>
                        @lang('app/activities_new.image_upload_btn')
                    </span>
                </button>
            </div>
            <small class="app-form-help">
                @lang('app/activities_new.image_help')
            </small>

            {{--<div class="app-new-activities-hide-input"></div>--}}

            {{--<div id="promo_image_delete_checkbox" class="checkbox m-a-1">--}}
            {{--<label>--}}
            {{--<input type="checkbox" id="promo_image_delete" name="promo_image_delete" value="1">--}}
            {{--<span>Delete image</span>--}}
            {{--</label>--}}
            {{--</div>--}}
        </div>
        {{--<div class="col-xs-12 col-lg-1 text-xs-left text-lg-center text-xs-right">or</div>--}}
        {{--<div class="col-xs-12 col-lg-5  p-r-1">--}}
        {{--<input type="text" id="google_image" class="form-control  app-new-activities-form-input" name="google_image"--}}
        {{--placeholder="Search with a keyword in Google images">--}}
        {{--</div>--}}
    </div>
    <div class="row">
        <div class="col-xs-12  col-lg-3"></div>
        <div class="col-xs-12 col-lg-9 app-new-activities-form-preview" id="preview_container"></div>
    </div>

    <div class="form-group row">
        <label class="col-xs-12 col-lg-3  p-l-1 col-form-label app-line-height" for="short_description">
            @lang('app/activities_new.short_description')
        </label>
        <div class="col-xs-12 col-lg-9  p-r-1 app-center-block">
                <textarea id="short_description" class="form-control app-new-activities-form-input" rows="3"
                          name="short_description" maxlength="255"
                          placeholder="@lang('app/activities_new.short_description_placeholder')" required>
                </textarea>
            <small class="app-form-help">
                @lang('app/activities_new.short_description_help')
            </small>
        </div>
    </div>
    <div class="row">
        @include('app.activities.buttons', [
    'link' => trans('app/activities_new.cancel'),
     'btn' => trans('app/activities_new.next'),
      'url' => route('activities_list'),
       'step' => 1
       ])
    </div>
</div>