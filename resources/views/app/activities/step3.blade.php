<div class="app-new-activities-form app-card  app-p-card">
    <div class="form-group row">
        <label class="col-xs-12 col-lg-4 col-xl-3 p-l-1 col-form-label app-line-height" for="category_sid">
            @lang('app/activities_new.category')
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
    <div class="form-group row">
        <div class="form-group">
            <label class="col-xs-12 col-lg-4 col-xl-3 p-l-1 col-form-label app-line-height" for="new_activity_interest_autocomplete">
                @lang('app/activities_new.interests')
            </label>
            <div class="col-xs-12 col-lg-8 col-xl-9 p-r-1 form-group">
                <div id="new_activity_interest_autocomplete_autocomplete" class="app-relative dropdown">
                    <input id="new_activity_interest_autocomplete" class="form-control" type="text" maxlength="15"  name="autocomplete" placeholder="@lang('app/activities_new.interests_placeholder')" autocomplete="off">
                    <input id="add_interest_to_new_activity" type="button" value="@lang('app/activities_new.add')" class="app-btn-in-input">
                    <input type="hidden" id="new_activity_interest_autocomplete_hidden"/>
                </div>
                <small class="app-form-help">
                    @lang('app/activities_new.interests_help')
                </small>
            </div>
            <div class="col-xs-12 col-lg-4 col-xl-3 hidden-lg-down"></div>
            <div class="col-xs-12 col-lg-8 col-xl-9">
                <div id="interests_hidden_block"></div>
                <div id="interests_for_creation"></div>
            </div>
        </div>
    </div>
    <div class="row">
        @include('app.activities.buttons', ['link' => trans('app/activities_new.back'), 'btn' => trans('app/activities_new.next'), 'url' => '#', 'step' => 3])
    </div>
</div>
