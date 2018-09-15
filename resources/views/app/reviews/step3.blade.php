<div class="app-new-reviews-form app-card app-p-card">
    <div class="form-group row">
        <label class="col-xs-12 col-lg-4 col-xl-3 p-l-1 col-form-label app-line-height" for="category_sid">
            @lang('app/reviews_new.category')
        </label>
        <div class="col-xs-12 col-lg-8 col-xl-9 p-r-1 form-group  app-new-activity-select-arrow">
            <select id="category_sid"  name="category_sid" class="form-control" size="1" required>
                <option></option>
                @foreach($categories as $key => $category)
                    <option value="{{ $key }}">{{ $category }}</option>
                @endforeach
            </select>
        </div>
    </div>
    {{--<div class="row">--}}
        {{--<div class="col-xs-12">--}}
            {{--<div id="interests_hidden_block"></div>--}}
            {{--<div id="interests_for_creation"></div>--}}
        {{--</div>--}}
    {{--</div>--}}
    <div class="form-group row">
        <div class="form-group">
            <label class="col-xs-12 col-lg-4 col-xl-3 p-l-1 col-form-label app-line-height" for="new_review_interest_autocomplete">
                @lang('app/reviews_new.about')
            </label>
            <div class="col-xs-12 col-lg-8 col-xl-9 p-r-1 form-group">
                <div id="new_review_interest_autocomplete_autocomplete" class="app-relative dropdown">
                    <input id="new_review_interest_autocomplete" class="form-control" type="text" name="autocomplete" autocomplete="off" placeholder="@lang('app/reviews_new.autocomplete_placeholder')">
                    <input id="add_interest_to_new_review" type="button" value="Add" class="app-btn-in-input">
                    <input type="hidden" id="new_review_interest_autocomplete_hidden"/>
                </div>
                <div class="help-block app-color-grey-dark app-text-sm">
                    @lang('app/reviews_new.about_help_text')
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-lg-4 col-xl-3 hidden-lg-down"></div>
        <div class="col-xs-12 col-lg-8 col-xl-9">
            <div id="interests_hidden_block"></div>
            <div id="interests_for_creation"></div>
        </div>
    </div>
    <div class="row">
        @include('app.reviews.buttons', ['link' => trans('app/reviews_new.back'), 'btn' => trans('app/reviews_new.finish'), 'url' => '#', 'step' => 3])
    </div>
</div>
