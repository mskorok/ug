<div class="app-new-reviews-form app-card app-p-card">
    <div class="form-group row">
        <label for="title" class="col-xs-12 col-lg-3 p-l-1 col-form-label">
            @lang('app/reviews_new.title')
        </label>
        <div class="col-xs-12 col-lg-9 p-r-1 app-center-block">
            <input type="text" class="form-control app-new-reviews-form-input" name="title" id="title"
                   placeholder="@lang('app/reviews_new.title_placeholder')" required />
        </div>
    </div>
    <input type="hidden" id="location_lat" name="lat" value="">
    <input type="hidden" id="location_lng" name="lng" value="">
    <input type="hidden" id="place_location" name="place_location" value="">
    <input type="hidden" id="place_id" name="place_id" value="">
    <div class="form-group row">
        <label for="place_name" class="col-xs-12 col-lg-3 p-l-1 col-form-label">
            @lang('app/reviews_new.location')
        </label>
        <div class="col-xs-12 col-lg-9 p-r-1 app-center-block">
            <input type="text" class="form-control app-new-reviews-form-input" name="place_name" id="place_name"
                   placeholder="@lang('app/reviews_new.place_name_placeholder')" required autocomplete="off">
            <svg class="app-new-reviews-form-icon">
                <use xlink:href="#svg__location"></use>
            </svg>
        </div>
    </div>

    <div class="form-group row">
        <label for="datetime_from" class="col-xs-12 col-lg-3 p-l-1 col-form-label">
            @lang('app/reviews_new.period')
        </label>
        <div class="col-xs-12 col-lg-9 p-r-1 app-center-block">
            <input type="text" id="datetime" class="form-control app-new-activities-form-input"
                   name="datetime" placeholder="@lang('app/reviews_new.datetime_placeholder')" required />
            <input type="hidden" id="datetime_from" name="datetime_from" />
            <input type="hidden" id="datetime_to" name="datetime_to" />
            <svg class="app-new-reviews-form-icon">
                <use xlink:href="#svg__calendar"></use>
            </svg>
            <div class="help-block app-color-grey-dark app-text-sm">
                @lang('app/reviews_new.period_help_text')
            </div>
        </div>
    </div>
    <div class="form-group row m-b-1">
        <label class="col-xs-12  col-lg-3  p-l-1 col-form-label" for="promo_image">
            @lang('app/reviews_new.image')
        </label>
        <div class="col-xs-12 col-lg-9">
            <div class="app-inline-block app-opacity-0">
                <input type="file" accept="image/*" id="promo_image" class="app-new-reviews-hidden-upload" name="promo_image" required />
            </div>
            <div class="app-new-reviews-hide-input">
                <button type="button" id="select_promo_image" class="btn  btn-sm app-btn-outline-apply">
                    <span>
                        @lang('app/reviews_new.upload')
                    </span>
                </button>
            </div>

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
        <div class="col-xs-12 app-new-reviews-form-preview" id="preview_container"></div>
    </div>

    <div class="form-group row">
        <label class="col-xs-12 col-lg-3  p-l-1 col-form-label app-line-height" for="short_description">
            @lang('app/reviews_new.short_description')
        </label>
        <div class="col-xs-12 col-lg-9  p-r-1 app-center-block">
                <textarea id="short_description" class="form-control app-new-reviews-form-input widgEditor" rows="3"
                          name="short_description" maxlength="255"
                          placeholder="@lang('app/reviews_new.short_description_placeholder')" required>
                </textarea>
            <div class="help-block app-color-grey-dark app-text-sm">
                @lang('app/reviews_new.short_description_help_text')
            </div>
        </div>
    </div>
    <div class="row">
        @include('app.reviews.buttons', [
    'link' => trans('app/reviews_new.cancel'),
     'btn' => trans('app/reviews_new.next'),
      'url' => route('reviews_list'),
       'step' => 1
       ])
    </div>
</div>

