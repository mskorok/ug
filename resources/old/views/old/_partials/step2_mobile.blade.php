<section class="app-new-activities-form  app-new-activities-decor clearfix">
    <label class="col-xs-12 form-control-label app-line-height" for="description">Tell a bit more about your plan or
        idea</label>
    <div class="col-xs-12 app-center-block">
        <textarea id="description" class="form-control app-new-activities-form-input" rows="6"
                  name="description"></textarea>
    </div>
    @include('app.activities.buttons', ['link' => 'Back', 'btn' => 'Next step', 'url' => '#', 'step' => 2])
</section>