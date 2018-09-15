<section class="app-new-activities-form  app-new-activities-decor clearfix">
    <fieldset class="form-group row">
        <label class="col-lg-4 col-xl-3 form-control-label app-line-height" for="description">Tell a bit more about your
            plan or idea</label>
        <div class="col-lg-7 col-xl-8">
                <textarea id="description" class="form-control app-new-activities-form-input" rows="7"
                          name="description">
                </textarea>
        </div>
    </fieldset>
    <div class="col-lg-12 app-new-activities-form-text">
        Gorbi nibh lacus, interdum porttitor sapien finibus, accumsan lobortis
        diam. Nulla laoreet, magna vel tempor auc.
    </div>
    @include('app.activities.buttons', ['link' => 'Back', 'btn' => 'Next step', 'url' => '#', 'step' => 2])
</section>