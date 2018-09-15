<div class="app-new-activities-form app-card  app-p-card">
    <div class="form-group row m-t-2">
        <label class="col-xs-12  col-lg-3 col-form-label app-text-sm app-color-grey-dark p-y-0">
            @lang('app/activities_new.privacy')
        </label>
        <div class="col-xs-12 col-lg-9 app-new-activities-radio-padding">
            <div class="btn-block app-new-activities-form-radio">
                <label class="btn-block app-radio-label text-lg-left">
                    <div class="app-radio checked"></div>
                    <input class="hidden-xs-up " type="radio" name="is_private" checked>
                    <span class="app-new-activities-form-radio">
                        <b>
                            @lang('app/activities_new.public')
                        </b>
                    </span>
                </label>
                <small class="app-form-help">
                    @lang('app/activities_new.public_help')
                </small>
            </div>
            <div class="btn-block app-new-activities-form-radio m-t-1">
                <label class="btn-block app-radio-label text-lg-left">
                    <div class="app-radio"></div>
                    <input class="hidden-xs-up" type="radio" name="is_private">
                    <span class="app-new-activities-form-radio">
                        <b>
                            @lang('app/activities_new.private')
                        </b>
                    </span>
                </label>
                <small class="app-form-help">
                    @lang('app/activities_new.private_help')
                </small>
            </div>
        </div>
    </div>
    <div class="row">
        @include('app.activities.buttons', ['link' => trans('app/activities_new.back'), 'btn' => trans('app/activities_new.next'), 'url' => '#', 'step' => 4])
    </div>
</div>

