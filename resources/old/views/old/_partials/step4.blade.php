<section class="app-new-activities-form  app-new-activities-decor clearfix">
    <fieldset class="form-group row">
        <label class="col-lg-3 col-xl-2  form-control-label app-line-height">Privacy</label>
        <div class="col-lg-8 col-xl-9">
            <div class="btn-block app-new-activities-form-radio">
                <label class="btn-block app-radio-label app-line-height text-lg-left">
                    <div class="app-radio checked"></div>
                    <input class="hidden-xs-up " type="radio" name="is_private" checked >
                    <span class="app-new-activities-form-radio">Public activity</span>
                </label>
            </div>
            <div class="col-lg-12 m-l-1 app-new-activities-form-text">
                Anyone can see the group, its members and their posts
            </div>

            <div class="btn-block app-new-activities-form-radio">
                <label class="btn-block app-radio-label app-line-height text-lg-left">
                    <div class="app-radio"></div>
                    <input class="hidden-xs-up" type="radio" name="is_private">
                    <span class="app-new-activities-form-radio">Private activity</span>
                </label>
            </div>
            <div class="col-lg-12 m-l-1 app-new-activities-form-text  app-new-activities-border-bottom">
                Only shared members can find the group and see its posts
            </div>
        </div>
    </fieldset>
    <fieldset class="form-group row">
        <label class="col-lg-3 col-xl-2 form-control-label app-line-height">Notifications</label>
        <div class="col-lg-8 col-xl-9">

            <div class="col-lg-12">
                <label class="btn-block app-checkbox-label text-lg-left">
                    <div class="app-checkbox checked"></div>
                    <input class="hidden-xs-up" name="notifications[]" type="checkbox" checked >
                    <span  class="app-new-activities-form-text">Inform about post and other updates in this group via Mail</span>
                </label>
            </div>
            <div class="col-lg-12 p-l-0">
                <label class="btn-block app-checkbox-label text-lg-left">
                    <div class="app-checkbox"></div>
                    <input class="hidden-xs-up" name="notifications[]" type="checkbox">
                    <span  class="app-new-activities-form-text">Inform me about changes in followers in this group via Mail</span>
                </label>
            </div>
        </div>
    </fieldset>
    @include('app.activities.buttons', ['link' => 'Back', 'btn' => 'Create', 'url' => '#', 'step' => 4])
</section>

