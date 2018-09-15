<div class="app-new-activities-form app-card  app-p-card">
    <div class="form-group row">
        <label class="col-xs-12 col-lg-4 col-xl-3 p-l-1 col-form-label app-line-height" for="description">
            @lang('app/activities_new.description')
        </label>
        <div class="col-xs-12 col-lg-7 col-xl-8  p-r-1 app-center-block">
        <textarea id="description" class="form-control app-new-activities-form-input" rows="6"
                  name="description" required></textarea>
            <small class="app-form-help">
                @lang('app/activities_new.description_help')
            </small>
        </div>
    </div>
    <div class="row">
        @include('app.activities.buttons', ['link' => trans('app/activities_new.back'), 'btn' => trans('app/activities_new.next'), 'url' => '#', 'step' => 2])
    </div>
</div>